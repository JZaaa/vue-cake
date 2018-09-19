<template>
  <div class="app-container">
    <el-alert
      class="margin-bottom-xs"
      title="菜单组件需对应前端路由map表，若仅存在单独一个子菜单，请设置父标题为空！"
      type="error"/>
    <div class="filter-container">
      <el-input v-model="listQuery.title" placeholder="标题" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter"/>
      <el-button class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">搜索</el-button>
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="handleCreate">添加</el-button>
    </div>

    <tree-table
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
    >
      <el-table-column label="标题" align="center">
        <template slot-scope="scope">
          <div>{{ scope.row.title }}</div>
        </template>
      </el-table-column>
      <el-table-column label="唯一标识" align="center">
        <template slot-scope="scope">
          <div>{{ scope.row.name }}</div>
        </template>
      </el-table-column>
      <el-table-column label="路径" align="center">
        <template slot-scope="scope">
          <div>{{ scope.row.path }}</div>
        </template>
      </el-table-column>
      <el-table-column label="重定向" align="center">
        <template slot-scope="scope">
          <div>{{ scope.row.redirect }}</div>
        </template>
      </el-table-column>
      <el-table-column label="隐藏" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.hidden === 1" type="info">隐藏</el-tag>
          <el-tag v-else>显示</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="图标" align="center">
        <template slot-scope="scope">
          <svg-icon v-if="scope.row.icon" :icon-class="scope.row.icon" />
        </template>
      </el-table-column>
      <el-table-column label="组件" align="center">
        <template slot-scope="scope">
          <div>{{ scope.row.component }}</div>
        </template>
      </el-table-column>
      <el-table-column label="排序" align="center">
        <template slot-scope="scope">
          <el-tag type="success">{{ scope.row.sort }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="操作" align="center" width="235">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="handleUpdate(scope.row)">编辑</el-button>
          <el-button v-if="!(scope.row.children && scope.row.children.length > 0)" type="danger" size="mini" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </tree-table>

    <!-- 新增/编辑 -->
    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form ref="dataForm" :rules="rules" :model="dataForm" label-position="right" label-width="100px" style="width: 400px; margin-left:50px;">
        <el-form-item label="唯一标识" prop="name">
          <el-input v-model="dataForm.name"/>
        </el-form-item>
        <el-form-item label="标题">
          <el-input v-model="dataForm.title"/>
        </el-form-item>
        <el-form-item label="父栏目">
          <el-cascader
            :options="selectData"
            v-model="selectOption"
            style="width: 100%"
            size="medium"
            placeholder="试试搜索"
            filterable
            change-on-select
          />
        </el-form-item>
        <el-form-item label="路径" prop="path">
          <el-input v-model="dataForm.path"/>
        </el-form-item>
        <el-form-item label="重定向">
          <el-input v-model="dataForm.redirect"/>
        </el-form-item>
        <el-form-item label="状态">
          <el-switch
            v-model.number="dataForm.hidden"
            :inactive-value="1"
            :active-value="2"
            inactive-text="隐藏"
            active-text="显示"
          />
        </el-form-item>
        <el-form-item label="图标">
          <el-input v-model="dataForm.icon"/>
        </el-form-item>
        <el-form-item label="组件" prop="component">
          <el-input v-model="dataForm.component"/>
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

  </div>
</template>

<script>

import { getList, createData, updateData, deleteData } from '@/api/config/menu'
import treeTable from '@/components/TreeTable'

/**
 * 格式化下拉选择数据
 * @param val
 * @param disable
 * @returns {*}
 */
function formatSelectData(val, disable) {
  return val.map((item) => {
    const children = item.children
    item = {
      value: item.id,
      label: item.name + '(' + item.title + ')'
    }
    if (disable && disable === item.value) {
      item.disabled = true
    }
    if (children && children.length > 0) {
      item.children = formatSelectData(children, disable)
    }
    return item
  })
}

export default {
  components: {
    treeTable
  },
  data() {
    return {
      listQuery: {
        title: undefined
      },
      list: [],
      textMap: {
        update: '编辑',
        create: '新增'
      },
      dialogFormVisible: false,
      dialogStatus: '',
      dataForm: {
        id: undefined,
        title: '',
        name: '',
        path: '',
        redirect: '',
        hidden: 2,
        icon: '',
        component: '',
        parent_id: 0,
        sort: 0,
        select_path: '[0]'
      },
      rules: {
        name: [
          { required: true, message: '请输入唯一标识', trigger: 'blur' }
        ],
        path: [
          { required: true, message: '请输入路径', trigger: 'blur' }
        ],
        component: [
          { required: true, message: '请输入组件', trigger: 'blur' }
        ],
        sort: [
          { type: 'integer', required: true, message: '请输入整数', trigger: ['change', 'blur'] }
        ]
      }
    }
  },
  computed: {
    selectData() {
      const data = formatSelectData([].concat(this.list), this.dataForm.id)
      data.unshift(
        {
          value: 0,
          label: '顶级菜单'
        }
      )
      return data
    },
    selectOption: {
      get() {
        const path = JSON.parse(this.dataForm.select_path)
        return (path && path.length > 0) ? path : [0]
      },
      set(value) {
        this.dataForm.parent_id = value[value.length - 1]
        this.dataForm.select_path = JSON.stringify(value)
      }
    }
  },
  created() {
    this.getList()
  },
  methods: {
    // 获取数据
    getList() {
      getList(this.listQuery).then(response => {
        this.list = response.items
      })
    },
    // 搜索
    handleFilter() {
      this.getList()
    },
    resetTemp() {
      this.dataForm = {
        id: undefined,
        title: '',
        name: '',
        sort: 0,
        path: '',
        redirect: '',
        hidden: 2,
        icon: '',
        component: '',
        parent_id: 0,
        select_path: '[0]'
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
          const tempData = this.formatPostData(Object.assign({}, this.dataForm))
          createData(tempData).then(() => {
            this.getList()
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
          const tempData = this.formatPostData(Object.assign({}, this.dataForm))
          updateData(tempData).then(() => {
            this.getList()
            this.dialogFormVisible = false
          })
        }
      })
    },
    // 格式化提交数据，主要删除children,parent 防止json循环引用
    formatPostData(data) {
      if (data.children) {
        delete data.children
      }
      if (data.parent) {
        delete data.parent
      }
      return data
    },
    // 删除
    handleDelete(row) {
      if (row.children && row.children.length > 0) {
        this.$alert('该项存在子菜单禁止删除！', '错误', {
          confirmButtonText: '确定'
        })
        return
      }
      this.$confirm('此操作将删除该数据, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        deleteData(row).then(() => {
          this.getList()
        })
      }).catch(() => {})
    }
  }
}
</script>
