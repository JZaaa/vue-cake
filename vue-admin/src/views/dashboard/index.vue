<template>
  <div class="app-container">
    <el-card :body-style="{ padding: 0 }" class="box-card" shadow="hover">
      <div slot="header" class="clearfix">
        <span>系统信息</span>
      </div>
      <el-table
        :show-header="false"
        :data="serverInfo"
        stripe
        style="width: 100%">
        <el-table-column
          prop="label"
          width="180"/>
        <el-table-column
          prop="value"
        />
      </el-table>
    </el-card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'Dashboard',
  computed: {
    ...mapGetters([
      'serverInfo'
    ])
  }
}
</script>

<style scoped>
  .bg-purple-dark {
    background: #d3dce6;
  }
  .grid-content {
    border-radius: 4px;
    min-height: 36px;
  }
</style>

