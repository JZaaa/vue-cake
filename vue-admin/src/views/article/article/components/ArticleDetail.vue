<template>
  <div class="form-container">
    <el-form ref="dataForm" :rules="rules" :model="dataForm" label-position="right" label-width="100px">
      <sticky :class-name="'sub-navbar'">
        <el-button style="margin-left: 10px;" type="info" @click="$router.back()">取消</el-button>
        <el-button v-loading="loading" style="margin-left: 10px;" type="success" @click="submitForm">发布</el-button>
      </sticky>
      <div class="form-item-container">
        <el-form-item label="标题" prop="title">
          <el-input v-model="dataForm.title"/>
        </el-form-item>
        <el-form-item label="栏目分类" prop="arctype_id">
          <el-select v-model.number="dataForm.arctype_id" filterable placeholder="请选择">
            <el-option
              v-for="(item, index) in arctypeList"
              :key="index"
              :label="item"
              :value="parseInt(index)"/>
          </el-select>
        </el-form-item>
        <el-form-item label="短标题">
          <el-input v-model="dataForm.shorttitle"/>
        </el-form-item>
        <el-form-item label="描述">
          <el-input :rows="1" v-model="dataForm.description" type="textarea" class="article-textarea" autosize placeholder="请输入内容"/>
        </el-form-item>
        <el-form-item label="关键字">
          <el-input v-model="dataForm.keywords"/>
        </el-form-item>
        <el-form-item label="颜色">
          <el-color-picker v-model="dataForm.color"/>
        </el-form-item>
        <el-form-item label="状态">
          <el-checkbox v-model.number="dataForm.istop" :true-label="1" :false-label="2">置顶</el-checkbox>
          <el-checkbox v-model.number="dataForm.isshow" :true-label="1" :false-label="2">显示</el-checkbox>
        </el-form-item>
        <el-form-item label="发布日期" prop="pubdate">
          <el-date-picker
            v-model="dataForm.pubdate"
            type="datetime"
            placeholder="选择日期时间"
            format="yyyy年MM月dd日 HH:mm:ss"
            value-format="yyyy-MM-dd HH:mm:ss"/>
        </el-form-item>
        <div class="editor-container">
          <Tinymce ref="editor" :height="400" v-model="dataForm.content" />
        </div>
        <div style="margin-bottom: 20px;">
          <Upload v-model="dataForm.image" />
        </div>
      </div>
    </el-form>
  </div>
</template>

<script>

import Tinymce from '@/components/Tinymce'
import Sticky from '@/components/Sticky' // 粘性header组件
import Upload from '@/components/Upload/singleImage2'
import { getListAll } from '@/api/article/arctype'
import { getData, createData, updateData } from '@/api/article/article'

const defaultForm = {
  id: undefined,
  arctype_id: undefined,
  title: '',
  shorttitle: '',
  color: '',
  description: '',
  keywords: '',
  content: '',
  pubdate: new Date(),
  image: '',
  isshow: 1,
  istop: 2
}

export default {
  components: {
    Tinymce,
    Sticky,
    Upload
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      dataForm: Object.assign({}, defaultForm),
      rules: {
        arctype_id: [
          { required: true, message: '请选择用户组', trigger: 'blur' }
        ],
        title: [
          { required: true, message: '请填写标题', trigger: 'blur' }
        ],
        pubdate: [
          { required: true, message: '请选择发布时间', trigger: 'blur' }
        ]
      },
      articleId: this.id,
      arctypeList: [],
      loading: false
    }
  },
  created() {
    this.getArctypeList()
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    } else {
      this.dataForm = Object.assign({}, defaultForm)
    }
  },
  methods: {
    fetchData(id) {
      getData({
        id: id
      }).then(response => {
        this.dataForm = response
      })
    },
    // 获取列表
    getArctypeList() {
      getListAll().then(response => {
        this.arctypeList = response
      })
    },
    submitForm() {
      if (this.isEdit) {
        this.updateData()
      } else {
        this.createData()
      }
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          createData(this.dataForm).then(() => {})
        }
      })
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.dataForm)
          updateData(tempData).then(() => {})
        }
      })
    }
  }
}
</script>
