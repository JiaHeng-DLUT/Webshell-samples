<?php
/****************奇乐网站授权管理系统 商业版 客户端*************/
/*                                                             */
/*  auth.qilewl.com (C)2018 qilewl.com Inc.                    */
/*  This is NOT a freeware, use is subject to license terms    */
/*  奇乐网站授权管理系统是商业软件,使用于商业用途请购买授权    */
/*  V1.0.0 2018                                                */
/*  官方网址：http://www.qilewl.com                            */ 
/*                                                             */                      
/***************************************************************/

// error_reporting(0);
date_default_timezone_set("PRC");

require ROOT_PATH."client/client.php";

//客户端是否自动备份

$AutoBackup      = true; //true 备份 false 不备份

//备份目录

define('BACKUP_DIR',ROOT_PATH.'data/backup/'); //备份文件存放目录
// 升级文件保存目录

define('UPDATE_DIR',ROOT_PATH.'data/update/'); //默认 上级 data/update/  ,升级sql 放在此目录


//升级后客户端是否删除升级补丁

$UpgradePackage  = true;  //true 删除 false 不删除




