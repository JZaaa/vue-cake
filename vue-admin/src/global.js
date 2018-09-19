const BASE_URL = process.env.BASE_API

// 图片/文件上传url
const upload = {
  file: BASE_URL + '/upload/file-upload',
  img: BASE_URL + '/upload/pic-upload'
}

export default {
  upload
}
