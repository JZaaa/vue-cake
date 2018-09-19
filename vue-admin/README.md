# vue-admin 后台vue界面

### 项目介绍

本项目为vue-cake的vue页面程序，利用[vue-admin-template](https://github.com/PanJiaChen/vue-admin-template)进行开发，Api接口为 CakePHP3.6 开发。

### 使用方法

````
# 安装依赖
npm install

# dev环境运行
npm run dev

# 编译
npm run build
````

### 相关配置修改

````
# dev接口地址
/config/dev.env.js --- BASE_API

# build接口地址
/config/prod.env.js --- BASE_API

# 图片/文件上传地址
/src/global.js --- upload
````

### 当前实现功能

- 菜单管理
- 动态路由(权限配置)
- 用户组-管理员管理
- 分类-文章管理



