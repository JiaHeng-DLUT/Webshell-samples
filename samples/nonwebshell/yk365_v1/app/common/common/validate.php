<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2017 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.youke365.site                        */
/*  官方论坛：http://bbs.youke365.site                        */                           
/**************************************************************/
function is_valid_dir($str)
{
	if (preg_match('/^[a-zA-Z][a-zA-Z0-9_-]*$/', $str)) {
		return true;
	} else {
		return false;
	}
}
function is_valid_str($str)
{
	if (preg_match('/^[a-zA-Z][a-zA-Z0-9_-]*$/', $str)) {
		return true;
	} else {
		return false;
	}
}

function is_valid_url($url)
{
	if (preg_match('/^http(s)?:\/\//i', $url)) {
		return true;
	} else {
		return false;
	}
}

function is_valid_email($email)
{
	if (preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $email)) {
		return true;
	} else {
		return false;
	}
}

function is_valid_domain($domain)
{
	if (preg_match("/^[a-zA-z]+:\/\/[^\s]*$/i", $domain)) {
		return true;
	} else {
		return false;
	}
}
