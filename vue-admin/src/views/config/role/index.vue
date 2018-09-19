<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.name" placeholder="组名称" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter"/>
      <el-button class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">搜索</el-button>
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="handleCreate">添加</el-button>
    </div>

    <el-table
      v-loading="listLoading"
      :key="tableKey"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;">
      <el-table-column label="ID" align="center" width="65">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="组名称" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="备注" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.note }}</span>
        </template>
      </el-table-column>
      <el-table-column label="排序" align="center" width="65">
        <template slot-scope="scope">
          <el-tag type="success">{{ scope.row.sort }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="操作" align="center" width="300">
        <template slot-scope="scope">
          <el-button type="warning" size="mini" @click="handleMenus(scope.row)">菜单权限</el-button>
          <el-button type="primary" size="mini" @click="handleUpdate(scope.row)">编辑</el-button>
          <el-button type="danger" size="mini" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

    <div class="pagination-container">
      <el-pagination v-show="total>0" :current-page="listQuery.page" :page-sizes="[10,20,30,50]" :page-size="listQuery.limit" :total="total" background layout="total, sizes, prev, pager, next, jumper" @size-change="handleSizeChange" @current-change="handleCurrentChange"/>
    </div>
    <!-- 新增/编辑 -->
    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form ref="dataForm" :rules="rules" :model="dataForm" label-position="right" label-width="100px" style="width: 400px; margin-left:50px;">
        <el-form-item label="组名称" prop="name">
          <el-input v-model="dataForm.name"/>
        </el-form-item>
        <el-form-item label="备注">
          <el-input v-model="dataForm.note"/>
        </el-form-item>
        <el-form-item label="排序" prop="sort">
          <el-input v-model.number="dataForm.sort"/>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取消</el-button>
        <el-button v-if="dialogStatus == 'create'" type="primary" @click="createData">确定</el-button>
        <el-button v-else type="primary" @click="updateData">确定</el-button>
      </div>
    </el-dialog>
    <!-- 菜单权限 -->
    <el-dialog :visible.sync="dialogMenusVisible" title="菜单权限">
      <el-tree
        ref="tree"
        :default-expand-all="true"
        :data="menusData.tree"
        :props="defaultProps"
        show-checkbox
        node-key="id"/>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogMenusVisible = false">取消</el-button>
        <el-button type="primary" @click="updateMenusRole">确定</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>

import { fetchList, createRole, updateRole, deleteRole } from '@/api/config/role'
import { getList as getListMenus } from '@/api/config/menu'

export default {
  data() {
    return {
      listQuery: {
        name: undefined,
        page: 1,
        limit: 20
      },
      tableKey: 0,
      list: null,
      total: null,
      menusData: {
        id: undefined,
        tree: []
      },
      listLoading: true,
      textMap: {
        update: '编辑',
        create: '新增'
      },
      dialogFormVisible: false,
      dialogMenusVisible: false,
      dialogStatus: '',
      dataForm: {
        id: undefined,
        name: '',
        sort: 0,
        note: '',
        menus: '[]'
      },
      rules: {
        name: [
          { required: true, message: '请输入组名称', trigger: 'blur' }
        ],
        sort: [
          { type: 'integer', required: true, message: '请输入整数', trigger: ['change', 'blur'] }
        ]
      },
      defaultProps: {
        children: 'children',
        label: 'title'
      }
    }
  },
  created() {
    this.getList()
    this.getMenusList()
  },
  methods: {
    // 获取数据
    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.items
        this.total = response.total
        this.listLoading = false
      })
    },
    getMenusList() {
      getListMenus().then(response => {
        this.menusData.tree = response.items
      })
    },
    // 搜索
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    // 改变分页大小
    handleSizeChange(val) {
      this.listQuery.limit = val
      this.getList()
    },
    // 改变页数
    handleCurrentChange(val) {
      this.listQuery.page = val
      this.getList()
    },
    resetTemp() {
      this.dataForm = {
        id: undefined,
        name: '',
        sort: 0,
        note: '',
        menus: '[]'
      }
    },
    // 添加
    handleCreate() {
      this.resetTemp()
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          createRole(this.dataForm).then((data) => {
            this.list.unshift(data)
            this.total++
            this.dialogFormVisible = false
          })
        }
      })
    },
    // 编辑
    handleUpdate(row) {
      this.dataForm = Object.assign({}, row)
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.dataForm)
          updateRole(tempData).then((data) => {
            // 遍历原数组找到id相同的数据并替换
            for (const v of this.list) {
              if (v.id === this.dataForm.id) {
                const index = this.list.indexOf(v)
                this.list.splice(index, 1, data)
                break
              }
            }
          })
          this.dialogFormVisible = false
        }
      })
    },
    // 删除
    handleDelete(row) {
      this.$confirm('此操作将删除该数据, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        deleteRole(row).then(() => {
          const index = this.list.indexOf(row)
          this.total--
          this.list.splice(index, 1)
        })
      }).catch(() => {})
    },
    // 菜单权限
    handleMenus(row) {
      this.dialogMenusVisible = true
      const tempData = Object.assign({}, row)
      this.menusData.id = tempData.id
      const menusArray = JSON.parse(tempData.menus_key)
      this.$nextTick(() => {
        if (menusArray && menusArray.length > 0) {
          this.$refs.tree.setCheckedKeys(menusArray.map(function(item) {
            return parseInt(item)
          }))
        } else {
          this.$refs.tree.setCheckedKeys([])
        }
      })
    },
    updateMenusRole() {
      const tempData = Object.assign({}, this.menusData)
      const keyArray = [].concat(this.$refs.tree.getHalfCheckedKeys(), this.$refs.tree.getCheckedKeys())
      updateRole({
        id: tempData.id,
        menus: JSON.stringify(keyArray),
        menus_key: JSON.stringify(this.$refs.tree.getCheckedKeys(true))
      }).then((data) => {
        for (const v of this.list) {
          if (v.id === tempData.id) {
            const index = this.list.indexOf(v)
            this.list.splice(index, 1, data)
            break
          }
        }
      })
      this.dialogMenusVisible = false
    }
  }
}
</script>
