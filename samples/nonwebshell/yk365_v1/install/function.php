<?php
//修改配置文件函数 
function set_config($array, $config_file = './../config.php') {
	if (empty($array) || !is_array($array)) {
		return false;
	}
	
	$config = file_get_contents($config_file); //读取配置
	foreach ($array as $name => $value) {
		$name = str_replace(array("'", '"', '['), array("\\'", '\"', '\['), $name); //转义特殊字符，再传给正则替换
		if (is_string($value) && !in_array($value, array('true', 'false', '3306'))) {
			$value = "'".$value."'"; //如果是字符串，加上单引号
		}
		$config = preg_replace("/define\(\'".$name."\'\,\s+\'(.*?)\'\);/i", "define('".$name."', {$value});", $config); //查找替换
	 }
	 
	//写入配置
	if (file_put_contents($config_file, $config)) {
		return true;
	} else { 
		return false;
	}
}

//替换MYSQL表前缀
function replace_sql($sql_path, $old_prefix = '', $new_prefix = '') {
	$delimiter = '(;\n)|((;\r\n))|(;\r)';
	$commenter = array('#', '--');
	
	//判断文件是否存在
	if (!file_exists($sql_path)) {
		return false;
	}
        
	$content = file_get_contents($sql_path); //读取sql文件
    $content = str_replace($old_prefix, $new_prefix, $content); //替换前缀
		
    //通过sql语法的语句分割符进行分割
    $segment = explode(";\r", trim($content)); 



    //去掉注释和多余的空行
	$data = array();
    foreach ($segment as $statement){
    	$sentence = explode("\n", $statement);         
    	$newStatement = array();
    	foreach ($sentence as $subSentence) {
    		if (trim($subSentence) != '') {
    			//判断是会否是注释
    			$isComment = false;
    			foreach ($commenter as $comer) {
    				if (preg_match("/^(".$comer.")/is", trim($subSentence))) {
    					$isComment = true;
    					break;
    				}
    			}
    			//如果不是注释，则认为是sql语句
    			if (!$isComment) {
    				$newStatement[] = $subSentence;
    			}
            }
        }           
     	$data[] = $newStatement;		 	
	}

	//组合sql语句
    foreach ($data as $statement) {
    	$newStmt = '';
        foreach ($statement as $sentence) {
        	$newStmt = $newStmt.trim($sentence)."\n";
        }    
		if (!empty($newStmt)) { 
			$result[] = $newStmt;
		}
	}	
	return $result;
}

//邮箱验证
function is_valid_email($email) {
	if (preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $email)) {
		return true;
	} else {
		return false;
	}
}

//跳转
function redirect($url) {
    header('location:'.$url, false, 301);
	exit;
}

//成功信息
function success($msg = '') {
	$str = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<style type="text/css">
body {background: #f3f3f3;}
#msgbox {background: #fff; border: solid 3px #e8e8e8; font: normal 16px/30px normal; margin: 100px auto; padding: 50px; width: 450px;}
</style>
</head>

<body>
<div id="msgbox">$msg<br /><div align="center">点击进入 <a href="./../index.php" target="_blank">[网站首页]</a>　<a href="/admin.php" target="_blank">[管理后台]</a></div></div>
</body>
</html>
EOT;
	exit($str);
}

//失败信息
function failure($msg = '', $url = 'javascript:history.back();') {
	$str = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<style type="text/css">
body {background: #f3f3f3;}
#msgbox {background: #fff; border: solid 3px #e8e8e8; font: normal 16px/30px normal; margin: 100px auto; padding: 50px; width: 450px;}
</style>
</head>

<body>
<div id="msgbox">$msg<br /><br /><div align="center"><a href="$url">[点击这里返回]</a></div></div>
</body>
</html>
EOT;
	exit($str);
}
?>