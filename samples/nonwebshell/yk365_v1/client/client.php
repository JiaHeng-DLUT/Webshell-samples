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


define('UPDATE_API_URL',"http://auth.youke365.site/update.php");  // 服务端通信地址

define('CLIENT_AUTH_CODE','fe7946eb9b90bbbbffbd607b53e74293'); //网站客户端授权码,授权后可获得



/***  需要服务端同步设置的常量 ***/
define('CLIENT_API_KEY','youke365'); //如服务端没有修改，客户端可不修改。用户不得随意修改，通信密钥，客户端与服务端必须一致，否则升级信息无法解密


