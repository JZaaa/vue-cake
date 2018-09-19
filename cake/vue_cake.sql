/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.1.29-MariaDB : Database - vue_cake
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`vue_cake` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `vue_cake`;

/*Table structure for table `ad_arctypes` */

DROP TABLE IF EXISTS `ad_arctypes`;

CREATE TABLE `ad_arctypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) DEFAULT NULL COMMENT '栏目名称',
  `parent_id` int(11) DEFAULT NULL COMMENT '父id',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '类型，1文章列表,2图片列表,3单页面',
  `image` varchar(50) DEFAULT NULL COMMENT '图片',
  `isshow` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否显示，1显示，2隐藏',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `href` varchar(255) DEFAULT NULL COMMENT '跳转链接',
  `enable_columns` text COMMENT '文章开启模块规则,json',
  `select_path` varchar(32) DEFAULT NULL COMMENT '树形id路径',
  PRIMARY KEY (`id`),
  UNIQUE KEY `KEYWORDS` (`keywords`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='栏目表';

/*Data for the table `ad_arctypes` */

insert  into `ad_arctypes`(`id`,`name`,`parent_id`,`sort`,`type`,`image`,`isshow`,`keywords`,`description`,`href`,`enable_columns`,`select_path`) values 
(1,'首页',0,0,3,'',1,NULL,'','','{\"description\":\"1\",\"keywords\":\"1\",\"content\":\"1\",\"image\":\"1\"}',NULL),
(2,'幻灯片',1,0,2,'',1,NULL,'','','{\"description\":\"1\",\"keywords\":\"1\",\"image\":\"1\",\"istop\":\"1\",\"url\":\"1\"}','[1]'),
(3,'新闻',0,0,1,'',1,NULL,'','','{\"shorttitle\":\"1\",\"color\":\"1\",\"description\":\"1\",\"keywords\":\"1\",\"content\":\"1\",\"image\":\"1\",\"istop\":\"1\"}',NULL),
(4,'关于我们',0,0,3,'',1,NULL,'','','{\"description\":\"1\",\"keywords\":\"1\",\"content\":\"1\"}',NULL);

/*Table structure for table `ad_articles` */

DROP TABLE IF EXISTS `ad_articles`;

CREATE TABLE `ad_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `arctype_id` int(11) DEFAULT NULL COMMENT '栏目id',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `shorttitle` varchar(36) DEFAULT NULL COMMENT '短标题',
  `color` varchar(10) DEFAULT NULL COMMENT '颜色',
  `description` varchar(250) DEFAULT NULL COMMENT '描述',
  `keywords` varchar(100) DEFAULT NULL COMMENT '关键字',
  `content` mediumtext COMMENT '内容',
  `pubdate` datetime DEFAULT NULL COMMENT '发布时间',
  `image` varchar(200) DEFAULT NULL COMMENT '缩略图',
  `autoimage` tinyint(2) DEFAULT '2' COMMENT '是否提取图片，1是，2否。提取内容中第一个图片为缩略图',
  `tag` varchar(100) DEFAULT NULL COMMENT '标签',
  `isshow` tinyint(2) DEFAULT '1' COMMENT '是否显示，1显示，2隐藏',
  `istop` tinyint(2) DEFAULT '2' COMMENT '是否置顶，1是，2否',
  `user_id` int(11) DEFAULT NULL COMMENT '管理员id',
  `url` varchar(255) DEFAULT NULL COMMENT '跳转链接',
  `created` datetime DEFAULT NULL COMMENT '创建时间',
  `modified` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `created` (`created`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='文章表';

/*Data for the table `ad_articles` */

insert  into `ad_articles`(`id`,`arctype_id`,`title`,`shorttitle`,`color`,`description`,`keywords`,`content`,`pubdate`,`image`,`autoimage`,`tag`,`isshow`,`istop`,`user_id`,`url`,`created`,`modified`) values 
(1,2,'幻灯片123','sdf12','#0F9A40','123','aaaaaa','<p><img class=\"wscnph\" src=\"http://jzaaa.jshop.com:81/files/20180919/tght1fl1.png\" /></p>\n<p>dsfsdf</p>','2018-09-19 14:45:33','files/20180919/igrx41eb.gif',1,NULL,1,1,1,'df','2018-05-17 10:44:04','2018-09-19 14:45:37'),
(4,3,'新闻12','12','#42821c','','','','2018-05-17 13:39:59','files/20180522/vi127di3.png',2,NULL,1,1,1,NULL,'2018-05-17 13:40:10','2018-05-22 14:43:29'),
(3,2,'sdf1','','','','','','2018-05-17 11:41:42','files/20180517/ebu2p72s.png',2,NULL,1,2,1,'','2018-05-17 11:41:49','2018-05-17 11:50:44'),
(8,4,'关于我们123213',NULL,NULL,'','123123','','2018-05-17 14:25:39',NULL,2,NULL,1,2,1,NULL,'2018-05-17 14:25:44','2018-05-17 14:25:47');

/*Table structure for table `ad_menus` */

DROP TABLE IF EXISTS `ad_menus`;

CREATE TABLE `ad_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `title` varchar(32) DEFAULT NULL COMMENT '标题',
  `name` varchar(32) NOT NULL COMMENT '路由唯一标识',
  `path` varchar(80) NOT NULL COMMENT '路径',
  `redirect` varchar(80) DEFAULT NULL COMMENT '跳转路径',
  `hidden` tinyint(2) NOT NULL DEFAULT '2' COMMENT '是否隐藏',
  `icon` varchar(32) DEFAULT NULL COMMENT '图标',
  `component` varchar(32) NOT NULL COMMENT '组件',
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `select_path` varchar(32) DEFAULT NULL COMMENT '树形id路径',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `ad_menus` */

insert  into `ad_menus`(`id`,`parent_id`,`title`,`name`,`path`,`redirect`,`hidden`,`icon`,`component`,`sort`,`select_path`) values 
(1,0,'系统管理','Config','/config','menu',2,'example','Layout',0,'[0]'),
(2,1,'管理员组','RoleIndex','role',NULL,2,NULL,'role_index',0,'[1]'),
(3,1,'菜单管理','MenuIndex','menu',NULL,2,NULL,'menu_index',2,'[1]'),
(4,1,'用户管理','UserIndex','user','',2,'','user_index',0,'[1]'),
(5,0,'信息管理','Article','/article','index',2,'form','Layout',1,'[0]'),
(6,5,'文章管理','ArticleIndex','index','',2,'','article_index',1,'[5]'),
(7,5,'文章栏目','ArctypeIndex','arctype','',2,'','arctype_index',0,'[5]'),
(8,5,'文章编辑','ArticleEdit','article-edit/:id','',1,'','article_edit',0,'[5]'),
(9,5,'文章新增','ArticleCreate','article-create','',1,'','article_create',0,'[5]');

/*Table structure for table `ad_options` */

DROP TABLE IF EXISTS `ad_options`;

CREATE TABLE `ad_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `field` varchar(50) DEFAULT NULL COMMENT '字段名',
  `value` text COMMENT '值',
  `type` varchar(50) DEFAULT NULL COMMENT '所属分类',
  `autoload` varchar(20) DEFAULT 'yes' COMMENT '是否自动加载，缓存起来',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

/*Data for the table `ad_options` */

insert  into `ad_options`(`id`,`name`,`field`,`value`,`type`,`autoload`) values 
(1,'系统名称','systemname','CakeCMS管理系统','system','yes'),
(2,'系统logo','systemlogo','img/cake-logo.png','system','yes'),
(3,'显示系统名称','systemnamehide','1','system','yes'),
(4,'起始年份','systemyear','2018','system','yes'),
(5,'底部信息','systemfoot','Copyright © 2018 CakeCMS','system','yes'),
(6,'百度地图','baidu','','other','yes'),
(7,'云片短信','yunpian','','other','yes'),
(8,'站点名称','sitename','','site','yes'),
(9,'站点副名称','sitefuname','','site','yes'),
(10,'站点描述','sitedesc','','site','yes'),
(11,'关键词','sitekeywords','','site','yes'),
(12,'版权信息','sitecopyright','','site','yes'),
(13,'备案编号','siteicpsn','','site','yes'),
(14,'统计代码','sitestatistics','','site','yes'),
(15,'登录名称','systemlogin','CakeCMS管理系统','system','yes'),
(16,NULL,'systemfulltext','1','system','yes');

/*Table structure for table `ad_roles` */

DROP TABLE IF EXISTS `ad_roles`;

CREATE TABLE `ad_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) DEFAULT NULL COMMENT '组别名称',
  `menus` text COMMENT '菜单权限',
  `note` varchar(100) DEFAULT NULL COMMENT '备注',
  `sort` int(11) DEFAULT '0' COMMENT '排序id',
  `menus_key` text COMMENT '被选中具体菜单key值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员组表';

/*Data for the table `ad_roles` */

insert  into `ad_roles`(`id`,`name`,`menus`,`note`,`sort`,`menus_key`) values 
(1,'管理员组','[5,6,9,8,7,1,3,4,2]','',2,'[6,9,8,7,3,4,2]');

/*Table structure for table `ad_search_index` */

DROP TABLE IF EXISTS `ad_search_index`;

CREATE TABLE `ad_search_index` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `obj_type` varchar(20) NOT NULL COMMENT '模块类型',
  `obj_id` int(11) unsigned NOT NULL COMMENT '关联id',
  `title` text NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `params` text COMMENT '拓展字段',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `object` (`obj_type`,`obj_id`),
  FULLTEXT KEY `content` (`title`,`content`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='全文索引';

/*Data for the table `ad_search_index` */

/*Table structure for table `ad_users` */

DROP TABLE IF EXISTS `ad_users`;

CREATE TABLE `ad_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `username` varchar(50) DEFAULT NULL COMMENT '登录名',
  `password` varchar(100) DEFAULT NULL COMMENT '登录密码',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称',
  `role_id` int(11) DEFAULT NULL COMMENT '用户组id',
  `state` tinyint(2) DEFAULT '1' COMMENT '登录状态.1正常，2禁止',
  `created` datetime DEFAULT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

/*Data for the table `ad_users` */

insert  into `ad_users`(`id`,`username`,`password`,`nickname`,`role_id`,`state`,`created`,`modified`) values 
(1,'admin','$2y$10$v5bE3wc3AASZSK05CLUvf.hhjWxWEfXZGz.1LAVtNn/70n6DsVFOi','管理员',1,1,'2017-09-22 15:16:50','2018-05-16 01:40:42');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
