# vue-cake 后台接口

### 项目介绍

本项目为vue-cake的后台接口程序，后台框架为CakePHP3.6。

### 安装
````
# 安装依赖
composer install
````

- 数据库导入 `vue_cake.sql`
- 复制`/config/app.default.php`至`/config/app.php`并进行相关配置修改
- `/webroot/files` 添加读写权限

### 跨域配置

项目默认允许所有跨域访问，若有其他需求请修改`/config/app.php`下`Cors`配置，具体配置方法请查看[cakephp-cors](https://github.com/ozee31/cakephp-cors)

