<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.title" placeholder="标题" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter"/>
      <el-button class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">搜索</el-button>
      <router-link :to="'/article/article-create'">
        <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit">添加</el-button>
      </router-link>
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
      <el-table-column label="标题">
        <template slot-scope="scope">
          <span>
            <span :style="{ color: scope.row.color }">{{ scope.row.title }}</span>
            <el-tag v-show="scope.row.istop === 1" type="warning">置顶</el-tag>
            <el-tag v-show="scope.row.isshow !== 1" type="info">隐藏</el-tag>
          </span>
        </template>
      </el-table-column>
      <el-table-column label="栏目分类" align="center">
        <template slot-scope="scope">
          <el-tag type="success">{{ arctypeList[scope.row.arctype_id] }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="发布时间" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.pubdate }}</span>
        </template>
      </el-table-column>
      <el-table-column label="操作" align="center" width="235">
        <template slot-scope="scope">
          <router-link :to="'/article/article-edit/'+ scope.row.id">
            <el-button type="primary" size="mini">编辑</el-button>
          </router-link>
          <el-button type="danger" size="mini" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

    <div class="pagination-container">
      <el-pagination v-show="total>0" :current-page="listQuery.page" :page-sizes="[10,20,30,50]" :page-size="listQuery.limit" :total="total" background layout="total, sizes, prev, pager, next, jumper" @size-change="handleSizeChange" @current-change="handleCurrentChange"/>
    </div>

  </div>
</template>

<script>

import { getListAll } from '@/api/article/arctype'
import { getList, deleteData } from '@/api/article/article'

export default {
  data() {
    return {
      listQuery: {
        title: undefined,
        page: 1,
        limit: 20
      },
      tableKey: 0,
      list: null,
      total: null,
      listLoading: true,
      arctypeList: []
    }
  },
  created() {
    this.getArctypeList()
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
    // 获取列表
    getArctypeList() {
      getListAll().then(response => {
        this.arctypeList = response
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
