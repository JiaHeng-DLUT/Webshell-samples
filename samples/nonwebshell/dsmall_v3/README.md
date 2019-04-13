# DSMall
## 关于DSMall

## 安装部署
	本程序依赖Thinkphp5框架，推荐框架版本 ThinkPHP5.0.24完整版
	
## 相关依赖SDK安装
	1.阿里云OSS  composer require aliyuncs/oss-sdk-php   
	介绍地址：https://help.aliyun.com/document_detail/32099.html?spm=5176.87240.400427.47.eaLg1R
	2.phpmailer  composer require phpmailer/phpmailer

## 安装教程
1、将源码解压到服务器空间
2、域名应该指向到public目录，因为应用入口文件位于public/index.php。
比如我的DSMALL项目在  D:\www\dsmall  域名应该指向到 D:\www\dsmall\public
3、进行安装 http://域名/install/install.php
4、后台地址：http://域名/index.php/admin
5、前台地址：http://域名/index.php/home



如果还有什么不懂的到DSMALL论坛(http://bbs.csdeshang.com)进行提问，以及下载最新版本。



V2.5.7
1. 修复微信自动登录没有unionid时需要中断
2. 修复苹果手机小程序支付的小BUG
3. 修复语言包BUG
4. 修复SNS显示错位
5. 去除初始化数据的多余图片
6. 后台界面优化

V3.0.1
1. 优化手机端分类页的体验
2. 后台登陆退出优化
3. 后台界面美化
4. 商家结算优化，管理后台可设置商家结算周期，以及商家可自行申请提现。

V3.0.3
1. 新增分销市场功能
2. 微信扫码登录BUG修复
3. 优化闲置语言包以及收藏BUG
4. 店铺结算放入日执行任务中
5. 分销员调整上级的BUG