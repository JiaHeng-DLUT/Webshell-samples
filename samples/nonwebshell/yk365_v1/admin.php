<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2018 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.youke365.site                        */
/*  官方论坛：http://bbs.youke365.site                        */                           
/**************************************************************/

// 说明：为了安全期间，这个后台入口地址，可以随便修改文件名称，不影响登陆。




//*************************Youke365登陆加密授权部分，请勿修改，以免无法登陆 *************************************
session_start();
$login_auth_code = md5('YouKe365'.rand(100000,999999)); //加密内容，不得修改否则后台无法登陆
$_SESSION['YouKe365Code'] = $login_auth_code;
$url = "/login/YouKe365Code/".$login_auth_code.'.html';
header('Location:/admin'.$url); 
exit();
