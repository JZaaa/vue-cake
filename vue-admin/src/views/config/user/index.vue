<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.username" placeholder="用户名" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter"/>
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
      <el-table-column label="用户名" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.username }}</span>
        </template>
      </el-table-column>
      <el-table-column label="管理员组" align="center">
        <template slot-scope="scope">
          <el-tag type="success">{{ roleList[scope.row.role_id] }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="昵称" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.nickname }}</span>
        </template>
      </el-table-column>
      <el-table-column label="状态" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.state === 2" type="info">禁用</el-tag>
          <el-tag v-else>正常</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="操作" align="center" width="235">
        <template slot-scope="scope">
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
        <el-form-item label="用户名" prop="username">
          <el-input v-model="dataForm.username"/>
        </el-form-item>
        <el-form-item label="用户组" prop="role_id">
          <el-select v-model.number="dataForm.role_id" filterable placeholder="请选择">
            <el-option
              v-for="(item, index) in roleList"
              :key="index"
              :label="item"
              :value="parseInt(index)"/>
          </el-select>
        </el-form-item>
        <el-form-item label="昵称" prop="nickname">
          <el-input v-model="dataForm.nickname"/>
        </el-form-item>
        <el-form-item v-if="dialogStatus == 'create'" label="密码" prop="password">
          <el-input v-model="dataForm.password" type="password"/>
        </el-form-item>
        <el-form-item v-else label="密码">
          <el-input v-model="dataForm.password" type="password" placeholder="为空则不修改密码"/>
        </el-form-item>
        <el-form-item label="状态">
          <el-switch
            v-model.number="dataForm.state"
            :inactive-value="2"
            :active-value="1"
            inactive-text="禁用"
            active-text="正常"
          />
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取消</el-button>
        <el-button v-if="dialogStatus == 'create'" type="primary" @click="createData">确定</el-button>
        <el-button v-else type="primary" @click="updateData">确定</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>

import { getListAll } from '@/api/config/role'
import { getList, createData, updateData, deleteData } from '@/api/config/user'

export default {
  data() {
    return {
      listQuery: {
        username: undefined,
        page: 1,
        limit: 20
      },
      tableKey: 0,
      list: null,
      total: null,
      listLoading: true,
      textMap: {
        update: '编辑',
        create: '新增'
      },
      roleList: [],
      dialogFormVisible: false,
      dialogStatus: '',
      dataForm: {
        id: undefined,
        username: '',
        nickname: '',
        password: '',
        state: 1,
        role_id: undefined
      },
      rules: {
        username: [
          { required: true, message: '请输入用户名', trigger: 'blur' }
        ],
        password: [
          { required: true, message: '请输入密码', trigger: 'blur' }
        ],
        nickname: [
          { required: true, message: '请输入昵称', trigger: 'blur' }
        ],
        role_id: [
          { required: true, message: '请选择用户组', trigger: 'blur' }
        ]
      }
    }
  },
  created() {
    this.getRoleList()
    this.getList()
  },
  methods: {
    // 获取数据
    getList() {
      this.listLoading = true
      getList(this.listQuery).then(response => {
        this.list = response.items
        this.total = response.total
        this.listLoading = false
      })
    },
    // 获取用户组列表
    getRoleList() {
      getListAll().then(response => {
        this.roleList = response
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
        username: '',
        nickname: '',
        password: '',
        state: 1,
        role_id: undefined
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
          createData(this.dataForm).then((data) => {
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
      this.dataForm.password = ''
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
          updateData(tempData).then(() => {
            // 遍历原数组找到id相同的数据并替换
            for (const v of this.list) {
              if (v.id === this.dataForm.id) {
                const index = this.list.indexOf(v)
                this.list.splice(index, 1, this.dataForm)
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
        deleteData(row).then(() => {
          const index = this.list.indexOf(row)
          this.total--
          this.list.splice(index, 1)
        })
      }).catch(() => {})
    }
  }
}
</script>
