#### 介绍
卡贷超平台相关介绍：
快速办卡：对接十多家主流银行办卡通道，一键申请，快速下卡。
极速网贷：整合市面上多家网络贷款口子，安全便捷，极速放款

#详细功能介绍
![贷超平台详细功能介绍](https://gitee.com/uploads/images/2019/0408/003642_8f43348e_4928843.png "贷超平台.png")


#### 卡贷超
稍后更新提交代码


#### 软件架构
软件架构说明
1. 采用laravel5.6.*研发，
2. 系统要求必须是PHP7.1.3以上，MySQL5.7以上，Nginx
3. 详细技术请咨询QQ：455912704

#### 安装教程

#### 下载源码
git clone https://gitee.com/lihuimei/daichao.git
以下步骤基本是 Laravel 项目安装需要执行的必须步骤
####安装依赖包
下载好源码后，直接执行
#### cd daichao
#### composer install
#### 设置 .env
.env 文件中的数据库部分设置成自己开发的数据库配置
cp .env.example .env
#### 应用密钥
通过以下命令来生成应用密钥，密钥值在 .env 文件 APP_KEY

php artisan key:generate
#### 设定公共磁盘软连接
Laravel 中上传文件通常是存储在 storage/app/public 目录下，该目录下的文件可以通过 php artisan storage:link 命令软连接到 public 目录下，以供外部访问。

#### 更多细节请见：Laravel 官方文档

## 导入商品数据 ##
通过使用各类 mysql 管理工具 或者 mysql 命令执行 sql 文件导入。

sql 文件地址： daichao.sql

最后一步
请把 .env 文件中 APP_URL,PC_URL 值设置为你当前的域名，

APP_URL=http://admin.xxx.com
PC_URL=http://www.xxx.com

