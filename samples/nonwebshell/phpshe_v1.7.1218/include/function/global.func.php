<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2011-0501 koyshe <koyshe@gmail.com>
 */
//####################// 系统核心函数 //####################//
//模板函数
function pe_tpl($tplname, $tplpath = '')
{
	global $pe, $module;
	$tplnamearr = explode('.', $tplname);
	$tplpathcache = "{$pe['path_root']}data/cache/template/{$module}/";
	$tplpathcache_name = "{$tplpathcache}{$tplnamearr[0]}.php";
	$tplpath_name = $pe['path_tpl'] . $tplname;
	!is_dir($tplpathcache) && mkdir($tplpathcache, 0777, true);
	if (!is_file($tplpathcache_name) or @filemtime($tplpath_name) > @filemtime($tplpathcache_name)) {
		if (!is_file($tplpath_name)) {
			pe_bug("模板文件 ./template/default/{$module}/{$tplname} 丢失", __LINE__);			
		}
		$html = file_get_contents($tplpath_name);
		$html = preg_replace('/<\!\-\-\{/', '<?php ', $html);
		$html = preg_replace('/\}\-\->/', '?>', $html);
		$html = preg_replace('/\{\$([^\}]*)\}/', '<?php echo \$\1 ?>', $html);
		$html = preg_replace('/\{(\w+\([^\}]*\))\}/', '<?php echo \1 ?>', $html);
		file_put_contents($tplpathcache_name, $html);
	}
	return $tplpathcache_name;
}
//数据库安全
function pe_dbhold($str, $exc=array())
{
	if (is_array($str)) {
		foreach($str as $k => $v) {
			$str[$k] = in_array($k, $exc) ? pe_dbhold($v, 'all') : pe_dbhold($v);
		}
	}
	else {
		//$str = $exc == 'all' ? mysql_real_escape_string($str) : mysql_real_escape_string(htmlspecialchars($str));
		$str = $exc == 'all' ? addslashes($str) : addslashes(htmlspecialchars($str));
	}
	return $str;
}
//导入hook
function pe_lead($leadname)
{
	global $pe;
	return include_once($pe['path_root'].$leadname);
}
//前台url
function pe_url($modact, $argstr=null)
{
	global $pe;
	$modact = explode('-', $modact);
	switch ($pe['url_model']) {
		case 'php':
			$url = "{$pe['host_root']}index.php";
			$modact[0] && $url .= "?mod={$modact[0]}";
			$modact[1] && $url .= "&act={$modact[1]}";
			$modact[2] && $url .= "&id={$modact[2]}";
			//$modact[3] && $url .= "&urlarg[2]={$modact[3]}";
			//$modact[4] && $url .= "&urlarg[3]={$modact[4]}";
			$argstr && $url = "{$url}&{$argstr}";
		break;
		default:
			$url = $pe['url_model'] == 'pathinfo_safe' ? "{$pe['host_root']}index.php/" : $pe['host_root'];
			$modact[0] && $url .= $modact[0];
			$modact[1] && $url .= "/{$modact[1]}";
			$modact[2] && $url .= "-{$modact[2]}";
			$modact[3] && $url .= "-{$modact[3]}";
			$modact[4] && $url .= "-{$modact[4]}";
			$argstr && $url .= "?{$argstr}";
		break;
	}
	return $url;
}
//获取当前url
function pe_nowurl($arr = null) {
	//global $pe;
	//return $pe['host_root'].($_SERVER['PATH_INFO'] ? $_SERVER['PATH_INFO'] : $_SERVER['REQUEST_URI']);
	$http = $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http';
	$url = "{$http}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	if (is_array($arr)) {
		foreach ($arr as $k=>$v) {
			if ($v) {
				$url = preg_replace("/([\?|&])({$k}=[^&]*)/i", "$1{$k}={$v}", $url);		
			}
			else {
				if (!function_exists('pe_nowurl_nn')) {
					function pe_nowurl_nn($match) {
						if ($match[1] == "?" && $match[3] == "&") return "?";
						if ($match[1] == "&" && $match[3] == "&") return "&";
						if (in_array($match[1], array("?", "&")) && $match[3] == "") return "";		
					}
				}
				$url = preg_replace_callback("/([\?|&])({$k}=[^&]*)(&?)/i", "pe_nowurl_nn", $url);
				/*if (version_compare(PHP_VERSION, '5.3', '<')) {
					$url = preg_replace_callback("/([\?|&])({$k}=[^&]*)(&?)/i", create_function('$match', 
						'if ($match[1] == "?" && $match[3] == "&") return "?";
						if ($match[1] == "&" && $match[3] == "&") return "&";
						if (in_array($match[1], array("?", "&")) && $match[3] == "") return "";'		
					), $url);
				}
				else {
					$url = preg_replace_callback("/([\?|&])({$k}=[^&]*)(&?)/i", function($match) { 
						if ($match[1] == "?" && $match[3] == "&") return "?";
						if ($match[1] == "&" && $match[3] == "&") return "&";
						if (in_array($match[1], array("?", "&")) && $match[3] == "") return "";		
					}, $url);
				}*/	
			}	
		}
	}
	return $url;
}
//获取当前网址为下个地址的fromto
function pe_fromto()
{
	$host = pe_nowurl();
	stripos($host, 'fromto') !== false && $host = substr($host, 0, stripos($host, 'fromto')-1);
	return 'fromto='.urlencode($host);
	//return 'fromto='.urlencode(basename($_SERVER['SCRIPT_FILENAME'])."?{$_SERVER['QUERY_STRING']}");
}
//图片缩略图
function pe_thumb($img = '', $w = null, $h = null, $thumbtype = null)
{
	global $pe;
	static $sington = false;
//	$img = str_ireplace($pe['host_root'], $pe['path_root'], $img);
	//$img = $pe['path_root'] . strstr($img, 'data/attachment/');
	$img = "{$pe['path_root']}$img";
	switch ($thumbtype) {
		case 'avatar':
			$img_new = is_file($img) ? $img : "{$pe['path_root']}include/image/noavatar.jpg";		
		break;
		case 'upload':
			$img_new = is_file($img) ? $img : "{$pe['path_root']}include/image/noupload.jpg";		
		break;
		default :
			$img_new = is_file($img) ? $img : "{$pe['path_root']}include/image/nopic.png";	
		break;
	}
	if ($w or $h) {
		$img_thumb = "{$pe['path_root']}data/cache/thumb/".date('Y-m')."/thumb_{$w}x{$h}_".pe_filename($img_new);
		if (!is_file($img_thumb)) {
			if ($sington == false) {
				include_once("{$pe['path_root']}include/class/thumb.class.php");
			}
			new thumb($img_new, $img_thumb, $w, $h);
		}
		return str_ireplace($pe['path_root'], $pe['host_root'], $img_thumb);
	}
	return str_ireplace($pe['path_root'], $pe['host_root'], $img_new);
}

//评价星级
function pe_comment($val, $width=16) {
	global $pe;
	$star_arr = array(1=>'很差', 2=>'较差', 3=>'一般', 4=>'满意', 5=>'很满意');
	for ($i=1; $i<=5; $i++) {
		if ($i <= intval($val)) {
			$html .= "<img src='{$pe['host_root']}include/plugin/raty/images/star-on.png' title='{$i}' style='width:{$width}px;margin-right:1px' />";
		}
		elseif (ceil($val) == $i) {
			$html .= "<img src='{$pe['host_root']}include/plugin/raty/images/star-half.png' title='{$i}' style='width:{$width}px;margin-right:1px' />";			
		}
		else {
			$html .= "<img src='{$pe['host_root']}include/plugin/raty/images/star-off.png' title='{$i}' style='width:{$width}px;margin-right:1px' />";	
		}
	}
	return $html;
}

//seo信息
function pe_seo($title='', $keywords='', $description='', $type = 'index')
{
	if ($type == 'admin') {
		$seo['title'] = $title ? "{$title} - 欢迎使用PHPSHE商城系统": '欢迎使用PHPSHE商城系统';
	}
	else {
		$setting = cache::get('setting');
		$seo['title'] = $title ? "{$title} - {$setting['web_title']} - Powered by phpshe" : "{$setting['web_title']} - Powered by phpshe";
		$seo['keywords'] = $keywords ? $keywords : $setting['web_keywords'];
		$seo['description'] = $description ? $description : $setting['web_description'];
	}
	return $seo;
}

//####################// 处理结果展示 //####################//
function pe_success($msg, $url=null, $type=null)
{
	$_SESSION['msg_show'] = $msg;
	$_SESSION['msg_result'] = 'success';
	pe_goto($url, $type);
}
function pe_error($msg, $url=null, $type=null) {
	$_SESSION['msg_show'] = $msg;
	$_SESSION['msg_result'] = 'error';	
	pe_goto($url, $type);
}
function pe_result() {
	global $pe;
	if (isset($_SESSION['msg_show']) && $_SESSION['msg_show']) {
		isset($_SESSION['msg_show']) && $show = $_SESSION['msg_show'];
		unset($_SESSION['msg_show']);
		if ($_SESSION['msg_result'] == 'success') {
			$bg_name = 'dui';
			$font_color = '#598f13';
		}
		else {
			$bg_name = 'cuo';
			$font_color = '#a7342b';
		}
print<<<html
	<style type="text/css">
	#msgshow{position:absolute;font-family:'Arial';}
	#msgshow_l{background:url({$pe['host_root']}include/image/{$bg_name}_l.gif) no-repeat; width:38px; height:50px; float:left;}
	#msgshow_r{background:url({$pe['host_root']}include/image/{$bg_name}_r.gif) no-repeat; width:7px; height:50px; float:left;}
	#msgshow_m{background:url({$pe['host_root']}include/image/{$bg_name}_m.gif) repeat-x; height:34px; float:left; padding:16px 10px 0 10px; font-size:14px; font-weight:bold; color:{$font_color}; display:inline-block; min-width:95px; _width:95px;}
	</style>
	<script type="text/javascript">
		$("#msgshow").remove();
		$("body").append('<div id="msgshow"><div id="msgshow_l"></div><div id="msgshow_m">{$show}</div><div id="msgshow_r"></div><div class="clear"></div></div>');
		_w_top = document.body.scrollTop || document.documentElement.scrollTop;
		_w_height = $(window).height();
		_w_width = $(window).width();
		_d_top = _w_top + (_w_height - $("#msgshow").height()) / 2;
		_d_left = (_w_width - $("#msgshow_m").width() - 65) / 2;
		$("#msgshow").css({"top":_d_top, "left":_d_left}).show();
		setTimeout(function(){ $("#msgshow").fadeOut(2000) }, 2000);
	</script>
html;
	}
}
//跳转函数	
function pe_goto($url = '', $type = 'default')
{
	global $pe;
	if ($type == 'dialog') {
		$url = $url ? "top.location.href = '{$url}'" : "top.location.reload()";	
	}
	else {
		$url = $url ? $url : (stripos($_SERVER['HTTP_REFERER'], $pe['host_root']) === false ? $pe['host_root'] : $_SERVER['HTTP_REFERER']);
		$url = "window.location.href='{$url}'";
	}
	echo "<script type='text/javascript'>{$url}</script>";
	die();
}
//####################// 文件相关函数 //####################//
//文件夹大小
function pe_dirsize($dir_path)
{
	$size = 0;
	if (is_file($dir_path)) {
		$size = filesize($dir_path);
	}
	else {
		$dir_arr = glob(trim($dir_path).'/*');
		if (is_array($dir_arr)) {
			foreach ($dir_arr as $k => $v) {
				$size += pe_dirsize($v);
			}
		}
	}
	return $size;
}
//删除文件夹
function pe_dirdel($dir_path)
{
	if (is_file($dir_path)) {
		unlink($dir_path);
	}
	else {
		$dir_arr = glob(trim($dir_path).'/*');
		if (is_array($dir_arr)) {
			foreach ($dir_arr as $k => $v) {
				pe_dirdel($v, $type);
			}	
		}
		@rmdir($dir_path);
	}
}
//文件夹列表
function pe_dirlist($dir_path) {
	$dir_arr = glob($dir_path);
	if (is_array($dir_arr)) {
		foreach ($dir_arr as $k => $v) {
			$tpl_arr[$k] = trim(strrchr(trim($v, '/'), '/'), '/');
		}
		return $tpl_arr;
	}
	else {
		return array();
	}
}
//获取文件名
function pe_filename($path, $type = '')
{
	$patharr = explode('/', $path);
	$pathkey = count($patharr) - 1;
	$filename = $patharr[$pathkey];
	switch ($type) {
		case 'name':
			$arr = explode('.', $filename);
			return $arr[0];
		break;
		case 'ext':
			$arr = explode('.', $filename);
			return $arr[1];
		break;			
		default:
			return $filename;
		break;
	}
}
//获取文件或文件夹读写权限
function pe_is_writeable($file)
{
	//从分隔符DIRECTORY_SEPARATOR判断是linux系统，直接用is_writable判断是否可写
	if (DIRECTORY_SEPARATOR == '/' and @ini_get("safe_mode") == false) return is_writable($file);
	//如果是windows平台，首先判断是否是目录，如果是目录，则创建随机文件(用完删除)，判断文件是否成功创建，来判断是否可写
	if (is_dir($file)) {
		$file = rtrim($file, '/').'/'.md5(mt_rand(1,100).mt_rand(1,100));
		if (($fp = @fopen($file, 'x')) === false) {
			return false;
		}
		fclose($fp);
		@chmod($file, 0777);
		@unlink($file);
		return true;
	}
	//如果是文件，通过是否能够写入判断
	elseif (!is_file($file) or ($fp = @fopen($file, 'x')) === false) {
		return false;
	}
	fclose($fp);
	return true;
}

//####################// 杂项函数 //####################//
function pe_404($title = null, $show = null)
{
	global $pe;
	header("HTTP/1.1 404 Not Found");
    header("status: 404 Not Found");
    if ($title) {
    	$title = $title;
 		$show  = $show  ? $show  : "{$title}";
    }
    else {
    	$title = "您访问的页面未找到！";
 		$show  = "{$title}<a href='{$pe['host_root']}' style='text-decoration:none'>返回首页</a>";
    }
    if ($pe['mobile']) {
    	$meta = '<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />';
    	$css = 'max-width:640px; min-width:300px;'; 
    }
    else {
     	$meta = '';
     	$css = 'max-width:600px;';  
    }
print<<<html
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />{$meta}
<title>{$title}</title>
<meta name="keywords" content="phpshe" />
<meta name="description" content="phpshe" />
</head>
<body style="background:#F9F9F9">
	<div style="{$css}margin:100px auto;padding:40px 10px 40px 30px; background:#ffffff; border:1px solid #DFDFDF; border-radius:3px;font-size:14px">{$show}</div>
</body>
</html>
html;
	die($html);
}
function pe_bug($notice, $line = null)
{
	$html = "<p>错误提示：{$notice}</p><p>错误定位：{$_SERVER[SCRIPT_FILENAME]}(第{$line}行)</p>";
	pe_404('系统错误', $html);
}
//获取text
function pe_text($str)
{
	$str = str_ireplace(array('\t','\r','\n','\rn','&nbsp;',' ','　'), '', strip_tags($str));
	return trim($str);
}
//针对文本保留html显示格式
function pe_texthtml($str)
{
	return nl2br(str_replace(' ', '&nbsp;', $str));
}
//获取适合js输出的html
function pe_jshtml($str, $isshow = 1) {
	$str = addslashes(str_replace(array("\r", "\n", "\t"), array('', '', ''), $str));
	return $isshow ? 'document.write("'.$str.'");' : $str;
}
//截取字符串
function pe_cut($str, $len, $tail = '')
{
	$str_len = strlen($str);//字符串总偏移量
	$i = 0;//截取汉字时字符偏移量
	$l = 0;//已截取了的汉字长度
	while (true) {
		if (ord(substr($str, $i, 1)) > 0xa0) {//中文
			$cnstr .= substr($str, $i, 3);
			$i += 3;
			$l++;
		}
		else {//字母，字符，数字
			$cnstr .= substr($str, $i, 1);
			$i++;
			$l += 0.5;
		}
		if ($l == $len or ($l+0.5) == $len) {
			return $str_len <= $i ? $cnstr : $cnstr . $tail;
		}
	}
}
//数字处理
function pe_num($num, $type, $len = 1, $fix = false) {
	$pow = pow(10, $len);
	if ($type == 'round') {
		$num = round($num, $len);
	}
	elseif ($type == 'ceil') {
		$num = ceil($num * $pow) / $pow;	
	}
	elseif ($type == 'floor') {
		$num = floor($num * $pow) / $pow;	
	}
	if ($fix == true) {
		$num_arr = explode('.', $num);
		$num = "{$num_arr[0]}.{$num_arr[1]}".str_repeat('0', $len - strlen($num_arr[1]));
	}
	return $num;
}
//js弹框
function pe_alert($msg)
{
	echo "<script type='text/javascript'>alert('{$msg}')</script>";
	pe_goto();
}
//增加反斜杠
function pe_addslashes($arr)
{
    if (empty($arr)) {
        return $arr;
    }
	else {
        return is_array($arr) ? array_map('pe_addslashes', $arr) : addslashes($arr);
    }
}
//移除反斜杠
function pe_stripslashes($arr)
{
    if (empty($arr)) {
        return $arr;
    }
	else {
        return is_array($arr) ? array_map('pe_stripslashes', $arr) : stripslashes($arr);
    }
}
//移除字符串左右空格
function pe_trim($str)
{
	if (is_array($str)) {
		foreach($str as $k => $v) {
			$str[$k] = pe_trim($v);
		}
	}
	elseif ($str) {
		$str = trim($str);
	}
	return $str;	
}
//获取ip
function pe_ip()
{
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    $ip_arr = explode(',', $realip);
    return $ip_arr[0];
}
//转换日期
function pe_date($time, $type = 'Y-m-d H:i') {
	return $time ? date($type, $time) : '';
}

function pe_date_color($date) {
	if (substr($date, 0, 10) == date('Y-m-d')) {
		$date = '<span class="cred">'.$date.'</span>';
	
	}
	return $date;
}

//多久以前
function pe_dayago($dmtime) {
	if (!$dmtime) return '≠';
	if ((time()-$dmtime) > 86400) {
		return intval((time()-$dmtime)/86400).'天前';
	}
	elseif ((time()-$dmtime) > 3600) {
		return intval((time()-$dmtime)/3600).'小时前';
	}
	elseif ((time()-$dmtime) > 60) {
		return intval((time()-$dmtime)/60).'分钟前';
	}
	elseif ((time()-$dmtime) > 0) {
		return (time()-$dmtime).'秒前';
	}
}

//获取无符号数字
function pe_unsigned($num1 = 0, $num2 = 0) {
	return ($num1 < $num2) ? 0 : $num1 - $num2;
}

//url处理函数
function pe_updateurl($k, $v='')
{
	$querystr = $_SERVER['QUERY_STRING'];
	$url = $v === ''
		? preg_replace('/\b'.$k.'=[^&]*/', '', $querystr)
		: ((stripos($querystr, "&{$k}=") === false && stripos($querystr, "?{$k}=") === false) ? "{$querystr}&{$k}={$v}" : preg_replace('/\b'.$k.'=[^&]*/', "$k=$v", $querystr));
	$url = trim($url, '&');
	return $url ? "?{$url}" : '?';
}
//url批量处理函数
function pe_updateurl_arr($arr)
{
	$querystr = $_SERVER['QUERY_STRING'];
	foreach ($arr as $val) {
		$k = $val[0];
		$v = $val[1];
		$querystr = $v === ''
			? preg_replace('/'.$k.'=[^&]*/', "", $querystr)
			: (stripos($querystr, $k.'=') === false ? "{$querystr}&{$k}={$v}" : preg_replace('/'.$k.'=[^&]*/', "$k=$v", $querystr));
		$querystr = trim($querystr, '&');
	}
	return $querystr ? '?'.$querystr : '';
}
//sql段函数。如时间段，但必须符合money=50-100的格式
function pe_sqlrange($fieldname, $rangeval, $misc = '-')
{
	if (stripos($rangeval, $misc) === false) {
		$sqlwhere = "{$fieldname} = '$rangeval'";
	}
	else {
		$rangarr = explode($misc, $rangeval);
		if ($rangarr[0] == 0 or !$rangarr[0]) {
			$sqlwhere = "{$fieldname} <= '$rangarr[1]'";
		}
		elseif ($rangarr[1] == 0 or !$rangarr[1]) {
			$sqlwhere = "{$fieldname} >= '$rangarr[0]'";
		}
		else {
			$sqlwhere = "{$fieldname} >= '$rangarr[0]' and {$fieldname} <= '$rangarr[1]'";		
		}
	}
	return $sqlwhere;
}

function pe_sqlin($fieldname, $arr) {
	if (is_array($arr)) {
 		$sqlwhere = "`{$fieldname}` in('".implode("','", $arr)."')";	
	}
	else {
 		$sqlwhere = "`{$fieldname}` = '{$arr}'";		
	}
	return $sqlwhere;
}
//####################// 安全函数 //####################//
function pe_token_set($str='') {
	if ($_SESSION['pe_token']) {
		return $_SESSION['pe_token'];		
	}
	else {
		return md5("{$_SERVER['REMOTE_ADDR']}koyshe+andrea=phpshe".microtime(true).rand(1000,100000).$str);	
	}
	/*setcookie("pe_token", $pe_token);
	return $pe_token;
	if ($type == 'html') {
		return "<input type='hidden' name='pe_token' value='{$pe_token}' />";
	}
	else {
		return $pe_token;	
	}*/
}
function pe_token_match() {
	global $pe;
	$referer = parse_url($_SERVER['HTTP_REFERER']);
	$pe_token = $_POST['pe_token'] ? $_POST['pe_token'] : $_GET['token'];	
	if (@stripos($pe['host_root'], $referer['host']) === false or $pe_token != $_SESSION['pe_token'] or $pe_token == '' or $_SESSION['pe_token'] == '') {
		unset($_POST['pe_token']);
		pe_error('跨站操作...');
	}
	unset($_POST['pe_token']);
}

function pe_dbxss($val) {
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=@avascript:alert('XSS')>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
      // ;? matches the ;, which is optional
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
      // @ @ search for the hex values
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      // @ @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[xX]0{0,8}([9ab]);)';
               $pattern .= '|';
               $pattern .= '|(&#0{0,8}([9|10|13]);)';
               $pattern .= ')*';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'@phpshe@'.substr($ra[$i], 2); // add in <> to nerf the tag
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
   }
   return $val;
}

//判断手机还是PC
function pe_mobile($mobile = false){
	global $pe;
	if ($mobile) return true;
 	if (stristr($_SERVER['HTTP_VIA'], "wap")) {// 先检查是否为wap代理，准确度高
		$mobile = true;
    }
    elseif (stripos($_SERVER['HTTP_ACCEPT'], "VND.WAP.WML") > 0){// 检查浏览器是否接受 WML.
		$mobile = true;
   	}
   	elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {//检查USER_AGENT
        $mobile = true;          
    }
	if (($mobile or stripos($_SERVER['SERVER_NAME'], 'm.') === 0) && file_exists("{$pe['path_root']}module/mobile_index")) {
		return true;
	}
	else {
		return false;
	}
}
function pe_jsonshow($arr, $tmp = 1) {
	/*if ($tmp == 1) {
	//	$json['isAdmin'] = true;
		$json['json'] = $arr;
	}
	else {
		$json = $arr;
	}*/
	echo json_encode($arr);
	die();
}

//给文件加非阻塞锁
function pe_lock($name) {
	$fp = fopen("{$pe['path_root']}data/lock/{$name}.lock", "w+");
	if (!flock($fp, LOCK_EX | LOCK_NB)) {
		fclose($fp);
		return false;
	}
	return $fp;
}
//给文件解锁
function pe_lock_del($fp) {
	flock($fp, LOCK_UN); // 释放锁定
	fclose($fp);
}

//表单验证
function pe_formcheck($type, $value) {
	switch ($type) {
		case 'uname':
			$result = preg_match("/^[A-Za-z0-9\x{4e00}-\x{9fa5}]+$/u", $value) ?  true : false;
		break;
		case 'tname':
			$result = preg_match("/^[\x{4e00}-\x{9fa5}]{2,4}$/u", $value) ?  true : false;
		break;
		case 'phone':
			$result = preg_match("/^1\d{10}$/", $value) ?  true : false;
		break;
		case 'email':
			$result = preg_match("/^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[a-z]{2,3}$/", $value) ?  true : false;
		break;
		case 'qq':
			$result = preg_match("/^[1-9][0-9]{4,14}$/", $value) ?  true : false;
		break;
	}
	return $result;
}

//活动状态
function pe_hd_stateshow($stime, $etime) {
	$nowtime = time();
	if (stripos($stime, '-') !== false) $stime = strtotime($stime);
	if (stripos($etime, '-') !== false) $etime = strtotime($etime);
	if ($etime <= time()) {
		$text = '<span class="c888">已结束</span>';
	}
	elseif ($stime > time()) {
		$text = '<span class="corg">未开始</span>';
	}	
	if ($etime <= time()) {
		$text = '<span class="c888">已结束</span>';
	}
	else {
		$text = '<span class="cgreen">进行中</span>';	
	}
	return $text;
}

//判断是否ajax请求
function pe_checkajax() {
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		return true;
	}
	else {
		return false;
	}
}

//设置cookie
function pe_setcookie($name, $value='', $time=86400) {
	$value = is_array($value) ? serialize($value) : $value;
	$time = is_null($time) ? null : (time() + $time);
	setcookie($name, $value, $time, '/');
}

//读取cookie
function pe_getcookie($name, $type = 'string') {
	$value = pe_trim(pe_stripslashes($_COOKIE[$name]));
	if ($type == 'array') {
		$value = unserialize($value) !== false ? unserialize($value) : array();
	}
	else {
		$value = unserialize($value) !== false ? unserialize($value) : $value;
	}
	$value = pe_trim(pe_stripslashes($value));
	return $value;
}

//####################// 用户权限函数 //####################//
function pe_login($type){
	global $pe, $db;
	if (md5($_SESSION["{$type}_id"].$pe['host_root']) != $_SESSION["{$type}_idtoken"]) return false;
	$info = $db->pe_select($type, array("{$type}_id"=>$_SESSION["{$type}_id"]));
	if (!$info["{$type}_id"]) {
		unset($_SESSION["{$type}_id"], $_SESSION["{$type}_name"], $_SESSION["{$type}_idtoken"]);
		return false;
	}
	return $info;	
}

//生成用户id(针对未登录用户)
function pe_user_id() {
	global $pe;
	$user_id = md5($pe['db_name'].session_id().$pe['db_name']);
	$_SESSION['pe_token'] = pe_token_set($user_id);
	return $user_id;
}

//生成唯一id
function pe_guid($table = null, $prefix = null) {
	global $db;
	$guid = date('ymdHis').mt_rand(0,9).mt_rand(0,9).mt_rand(0,9);
	$guid = $prefix ? "{$prefix}_{$guid}" : $guid;
	if (!$table) return $guid;
	$table_arr = explode('|', $table);
	if ($db->pe_num($table_arr[0], array($table_arr[1]=>$guid))) {
		return pe_guid($table, $prefix);
	}
	else {
		return $guid;
	}
}

function pe_qrcode($url) {
	global $pe;
	$user_qrcode = "{$pe['path_root']}data/cache/thumb/".date('Y-m')."/".md5($url).".png";
	if (!is_file($user_qrcode)) {
		if (!is_dir("{$pe['path_root']}data/cache/thumb/".date('Y-m'))) {
			mkdir("{$pe['path_root']}data/cache/thumb/".date('Y-m'), 0777, true);		
		}
		pe_lead('include/class/phpqrcode.class.php');
		QRcode::png($url, $user_qrcode);
	}
	return "{$pe['host_root']}data/cache/thumb/".date('Y-m')."/".md5($url).".png";
}

//修正中文编码问题
function pe_json_encode($value) {
    if (version_compare(PHP_VERSION,'5.4.0','<')) {
        $str = json_encode($value);
        $str = preg_replace_callback("#\\\u([0-9a-f]{4})#i", create_function('$matchs','return iconv("UCS-2BE", "UTF-8", pack("H4", $matchs[1]));'), $str);
        return $str;
    }
    else {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}

function pe_curl_get($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$result = curl_exec($ch);
	//var_dump(curl_error($ch));
	curl_close($ch);
	return $result;
}

function pe_curl_post($url, $arr = '', $arr_type = 'arr', $cert = array()) {
	if (is_array($arr)) {
		foreach ($arr as $k=>$v) {
			if (!is_array($v) && stripos($v, '@') === 0) {
				$v = substr($v, 1);
				if (class_exists('CURLFile')) {
					$arr[$k] = new CURLFile($v);
				}
				else {
					$arr[$k] = '@'.$v;
				}
			}
		}
		if ($arr_type == 'json') {
			$data = pe_json_encode($arr);
		}
		else {
			$data = $arr;
		}
	}
	else {
		$data = $arr;
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	if (isset($cert['ssl_cert']) && isset($cert['ssl_key'])) {
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, $cert['ssl_cert']);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, $cert['ssl_key']);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$result = curl_exec($ch);
	if (stripos($result, '<xml>') !== false) {
		$result = json_decode(json_encode(simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)), true); 
	}
//	var_dump(curl_error($ch));
	curl_close($ch);
	return $result;
}

//获取xml数据
function pe_getxml() {
	$xml = file_get_contents("php://input");
	libxml_disable_entity_loader(true);
	return $xml = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
}

//在线客服链接
function pe_kfurl($type, $num) {
	global $pe;
	switch ($type) {
		case 'qq':
			if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
				$url = "http://wpa.qq.com/msgrd?v=3&uin={$num}&site={$pe['host_root']}&menu=yes&from=message&isappinstalled=1";
			}
			else {
				$url = "mqqwpa://im/chat?chat_type=wpa&uin={$num}&version=1&src_type=web&web_src={$pe['host_root']}";
			}
		break;
	}
	return $url;
}
?>