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
//返回错误的json
function error_json($msg,$data='',$code=-1){
   $param = array(
     'code' => $code, //默认 -1 有异常
     'msg'  => $msg,
     'data' => $data,
    );
   return json_encode($param);

}
//返回成功的json
function success_json($msg,$data='',$code=0){
   $param = array(
     'code' => $code, //默认 0 成功
     'msg'  => $msg,
     'data' => $data,
    );
   return json_encode($param);

}

function msgbox($msg, $url = 'javascript: history.go(-1);') {
	global $Youke,$options;;
	
	$template = 'msgbox.html';
	template_exists($template);
	
	$Youke->assign('msg', $msg);
	$Youke->assign('url', $url);
	$Youke->assign('cfg', $options);
	echo $Youke->display('msgbox.html');
	exit();
}
function getAPI($url){
  $json = file_get_contents($url);
  $arr = json_decode($json,true);
  return $arr;
}
function getJson($arr){
   exit(json_encode($arr));
}

function redirect($url) {
	header('location:'.$url, false, 301);
    exit;
}

//删除目录
function delDir($dir) {
    if (!is_dir($dir)) {
        return false;
    }
    $handle = opendir($dir);
    while (($file = readdir($handle)) !== false) {
        if ($file != "." && $file != "..") {
            is_dir("$dir/$file") ? del_dir("$dir/$file") : @unlink("$dir/$file");
        }
    }
    if (readdir($handle) == false) {
        closedir($handle);
        @rmdir($dir);
    }
}

/*
 * I('id',0); 获取id参数 自动判断get或者post
 * I('post.name','','htmlspecialchars'); 获取$_POST['name']
 * I('get.'); 获取$_GET
 * 
 * @param string $name 变量的名称 支持指定类型
 * @param mixed $default 不存在的时候默认值
 * @param mixed $filter 参数过滤方法
 * 
 */
function I($name,$default='',$filter =null){

   if(strpos($name,'.')) { // 指定参数来源
        //判断参数$name中是否包括.号
        list($method,$name) =   explode('.',$name,2);
        //如果包括.号将.号前后分隔，并且分别赋值给$method以及$name
    }else{ // 默认为自动判断
        //如果没有.号
        $method =   'param';
    }

 switch(strtolower($method)) {//将$method转换为小写
        //如果$method为get，则$input为$_GET
        case 'get'     :   $input =& $_GET;break;
        //如果$method为get，则$input为$_POST
        case 'post'    :   $input =& $_POST;break;
        //如果为put，则将post的原始数据转参数给$input
        case 'put'     :   parse_str(file_get_contents('php://input'), $input);break;
        //如果是param
        case 'param'   :
            //判断$_SERVER['REQUEST_METHOD']
            switch($_SERVER['REQUEST_METHOD']) {
                //如果为post，则$input的内容为$_POST的内容
                case 'POST':
                    $input  =  $_POST;
                    break;
                //如果为PUT.则input的内容为PUT的内容
                case 'PUT':
                    parse_str(file_get_contents('php://input'), $input);
                    break;
                //默认为$_GET的内容
                default:
                    $input  =  $_GET;
            }
            break;
        //如果$method为request，则$input为$_REQUEST
        case 'request' :   $input =& $_REQUEST;   break;
        //如果$method为session，则$input为$_SESSION
        case 'session' :   $input =& $_SESSION;   break;
        //如果$method为cookie，则$input为$_COOKIE
        case 'cookie'  :   $input =& $_COOKIE;    break;
        //如果$method为server，则$input为$_SERVER
        case 'server'  :   $input =& $_SERVER;    break;
        //如果$method为globals，则$input为$GLOBALS
        case 'globals' :   $input =& $GLOBALS;    break;
        //默认返回空
        default:
            return NULL;
    }

  if(empty($name)) { // 获取全部变量
        //获取到的变量$input全部复制给$data
        $data       =   $input;
        //array_walk_recursive — 对数组中的每个成员递归地应用用户函数
        //将$data的键值作为filter_exp函数的第一个参数，键名作为第二个参数
        //如果$data的键值中含有or或者exp这两个字符，自动在后面加一个空格
        array_walk_recursive($data,'filter_exp');
        //判断过滤参数是否有，如果有的话，就直接使用过滤方法，如果没有的话，就使用配置中的过滤方法
        $filters    =   isset($filter)?$filter:'htmlspecialchars';
        if($filters) {
            $filters    =   explode(',',$filters);
            //将过滤参数中的每个方法都应用到$data中
            foreach($filters as $filter){
                //将$data的每个值使用$filters过滤
                $data   =   array_map_recursive($filter,$data); // 参数过滤
            }
        }
    }elseif(isset($input[$name])) { // 取值操作
        $data       =   $input[$name];
        is_array($data) && array_walk_recursive($data,'filter_exp');
        $filters    =   isset($filter)?$filter:'htmlspecialchars';
        if($filters) {
            $filters    =   explode(',',$filters);
            foreach($filters as $filter){
                if(function_exists($filter)) {
                    $data   =   is_array($data)?array_map_recursive($filter,$data):$filter($data); // 参数过滤
                }else{
                    $data   =   filter_var($data,is_int($filter)?$filter:filter_id($filter));
                    if(false === $data) {
                        return   isset($default)?$default:NULL;
                    }
                }
            }
        }
    }else{ // 变量默认值
       $data       =    isset($default)?$default:NULL;
    }
    return $data; 
}

// 过滤表单中的表达式
function filter_exp(&$value){
    if (in_array(strtolower($value),array('exp','or'))){
        $value .= ' ';
    }
}

function array_map_recursive($filter, $data) {
    $result = array();
    foreach ($data as $key => $val) {
        $result[$key] = is_array($val)
         ? array_map_recursive($filter, $val)
         : call_user_func($filter, $val);
    }
    return $result;
 }
function get_query($sql){
global  $Db;
            $rd = $Db->query($sql);
            $arr =array();
            while($row =$Db->fetch_array($rd)){ 
            $arr[] =$row;
            } 
            return $arr;
    }

//加密解密
function encryptDecrypt($key, $string, $decrypt){
   // $decrypt = true 解密
  // $decrypt = false 加密
    $key=md5($key);
    $key_length=strlen($key);
    $string=$decrypt=='true'?base64_decode($string):substr(md5($string.$key),0,8).$string;
    $string_length=strlen($string);
    $rndkey=$box=array();
    $result='';
    for($i=0;$i<=255;$i++)
    {
      $rndkey[$i]=ord($key[$i%$key_length]);
      $box[$i]=$i;
    }
    for($j=$i=0;$i<256;$i++)
    {
      $j=($j+$box[$i]+$rndkey[$i])%256;
      $tmp=$box[$i];
      $box[$i]=$box[$j];
      $box[$j]=$tmp;
    }
    for($a=$j=$i=0;$i<$string_length;$i++)
    {
      $a=($a+1)%256;
      $j=($j+$box[$a])%256;
      $tmp=$box[$a];
      $box[$a]=$box[$j];
      $box[$j]=$tmp;
      $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
    }
    if($decrypt=='true')
    {
      if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8))
      {
        return substr($result,8);
      }
      else
      {
        return'';
      }
    }
    else
    {
      return str_replace('=','',base64_encode($result));
    }
}

function get_real_size($size) {
	$kb = 1024;         // Kilobyte
	$mb = 1024 * $kb;   // Megabyte
	$gb = 1024 * $mb;   // Gigabyte
	$tb = 1024 * $gb;   // Terabyte

	if ($size < $kb) {
		return $size.' Byte';
	} else if ($size < $mb) {
		return round($size / $kb, 2).' KB';
	} else if ($size < $gb) {
		return round($size / $mb, 2).' MB';
	} else if ($size < $tb) {
		return round($size / $gb, 2).' GB';
	} else {
		return round($size / $tb,2).' TB';
	}
}
function format_time($date='',$dateformat="Y-m-d", $format=1) {

   $time = time() - $date;
   $result = '';
   if($format) {
     if($time > 24*3600) {
       $result = @date($dateformat,$date);
     } elseif ($time > 3600) {
       $result = intval($time/3600).'小时前';
     } elseif ($time > 60) {
       $result = intval($time/60).'分钟前';
     } elseif ($time > 0) {
       $result = $time.'秒前';
     } else {
       $result = '刚刚';
     }
    }else{
    $result = @date($dateformat,$date);
   }
     return $result;
}
// 转换时间单位:秒 to XXX
function format_timespan($seconds = '') {
	if ($seconds == '') $seconds = 1;
	$str = '';
	$years = floor($seconds / 31536000);
	if ($years > 0) {
		$str .= $years.' 年, ';
	}
	$seconds -= $years * 31536000;
	$months = floor($seconds / 2628000);
	if ($years > 0 || $months > 0) {
		if ($months > 0) {
			$str .= $months.' 月, ';
		}
		$seconds -= $months * 2628000;
	}
	$weeks = floor($seconds / 604800);
	if ($years > 0 || $months > 0 || $weeks > 0) {
		if ($weeks > 0)	{
			$str .= $weeks.' 周, ';
		}
		$seconds -= $weeks * 604800;
	}
	$days = floor($seconds / 86400);
	if ($months > 0 || $weeks > 0 || $days > 0) {
		if ($days > 0) {
			$str .= $days.' 天, ';
		}
		$seconds -= $days * 86400;
	}
	$hours = floor($seconds / 3600);
	if ($days > 0 || $hours > 0) {
		if ($hours > 0) {
			$str .= $hours.' 小时, ';
		}
		$seconds -= $hours * 3600;
	}
	$minutes = floor($seconds / 60);
	if ($days > 0 || $hours > 0 || $minutes > 0) {
		if ($minutes > 0) {
			$str .= $minutes.' 分钟, ';
		}
		$seconds -= $minutes * 60;
	}
	if ($str == '') {
		$str .= $seconds.' 秒, ';
	}
	$str = substr(trim($str), 0, -1);
	return $str;
}



/** format tags */
function get_format_tags($str) {
	$arrstr = !empty($str) && strpos($str, ',') > 0 ? explode(',', $str) : (array) $str;
	$count = count($arrstr);
	
	$newarr = array();
	for ($i = 0; $i < $count; $i++) {
		$tag = trim($arrstr[$i]);
		$newarr[$i]['tag_name'] = $tag;
		$newarr[$i]['tag_link'] =url('search',['type'=>'tags','query'=>$tag]);
	}
	unset($arrstr);
	
	return $newarr;
}





function get_kefu(){
	global $options;
	// 在线QQ客服
	$kefu = array();
	foreach (explode("\r\n",$options['site_kefu']) as $v){
		array_push($kefu,$v);
	}

	return $kefu;
}
	
/** 分页函数 */
function showpage($pageurl, $totalnum, $curpage, $perpage = 20) {
	$pagenav = '';
	$pageurl .= (strpos($pageurl, '?') === false) ? '?' : '&';
	
	if ($totalnum > 0) {
		$pagestep = 8;
		$offset = 5;
		$pagenum = @ceil($totalnum / $perpage);
		
		if ($pagestep > $pagenum) {
			$start = 1;
			$end = $pagenum;
		} else {			
			$start = $curpage - $offset;
			$end = $curpage + $pagestep - $offset - 1;	
			
			if ($start < 1) {
				$end = $curpage + 1 - $start;
				$start = 1;
				
				if (($end - $start) < $pagestep && ($end - $start) < $pagenum) {
					$end = $pagestep;
				}				
			} elseif ($end > $pagenum) {
				$start = $curpage - $pagenum + $end;
				$end = $pagenum;
				
				if (($end - $start) < $pagestep && ($end - $start) < $pagenum) {
					$start = $pagenum - $pagestep + 1;
				}
			}
		}

		$pagenav = ($curpage > 1 && $pagenum > $pagestep ? '<a href="'.$pageurl.'page=1" class="pages" title="首页">首页</a>' : '').($curpage > 1 ? '<a href="'.$pageurl.'page='.($curpage - 1).'"  class="pages" title="上一页">上一页</a>' : '');

if($pagenum > 1){
		for($i = $start; $i <= $end; $i++) {
			$pagenav .= $i == $curpage? '<span class="current">'.$i.'</span>' : '<a href="'.$pageurl.'page='.$i.'" class="pages">'.$i.'</a>';
		}
}	



		$pagenav .= ($curpage < $pagenum ? '<a href="'.$pageurl.'page='.($curpage + 1).'" class="next_page" title="下一页">下一页</a><a href="'.$pageurl.'page='.$pagenum.'" class="last_page" title="尾页">尾页</a>' : '');
		
		/*
		if ($pagenum > 30) {
			$pagenav .= '<span class="jump_page">转至第<input type="text" name="page" size="1" maxlength="5" value="'.$curpage.'" onKeyPress="if (event.keyCode==13) window.location=\''.$pageurl.'page=\'+this.value;">页</span>';
		}
		*/
		/*
		$pagenav = $pagenav ? '<span class="total_page">共 '.$totalnum.' 条</span>'.$pagenav : '';
		*/
	}
	
	return $pagenav;
}

function opt_checked($compare1, $compare2) {
    if (isset($compare1) && $compare1 == $compare2) {
		$checked = ' checked ';
	} else {
		$checked = '';
	}
	
	return $checked;
}

function opt_selected($compare1, $compare2) {
    if ($compare1 == $compare2) {
		$selected = ' selected';
	} else {
		$selected = '';
	}
	
	return $selected;
}

function opt_display($compare1, $compare2) {
    if ($compare1 == $compare2) {
		$display = '';
	} else {
		$display = 'none';
	}
	
	return $display;
}

/** 去除转义字符 */
function stripslashes_deep($value) {
	if (is_array($value)) {
		$value = array_map('stripslashes_deep', $value);
	} elseif (is_object($value)) {
		$vars = get_object_vars($value);
		foreach ($vars as $key => $data) {
			$value -> {$key} = stripslashes_deep($data);
		}
	} else {
		$value = stripslashes($value);
	}
	
	return $value;
}


/** 计算UTF8字符串长度 */
function utf8_strlen($string = '') {
	preg_match_all("/./us", $string, $match);
	return count($match[0]);
}

/** 添加转义字符 */
function add_magic_quotes($array) {
	foreach ((array) $array as $k => $v) {
		if (is_array($v)) {
			$array[$k] = add_magic_quotes($v);
		} else {
			$array[$k] = addslashes($v);
		}
	}
	
	return $array;
}

/** 计算时间隔 */
function datediff($format, $timestamp) {
	$newtime = time() - $timestamp;
	
	$hour = floor($newtime / 3600);
	$day = floor($newtime / (24 * 3600));
	$week = floor($newtime / (7 * 24 * 3600));
	$month = floor($newtime / (30 * 24 * 3600));

	$format = strtolower($format);
	switch ($format) {
		case 'h' :
			return $hour;
			break;
		case 'd' :
			return $day;
			break;
		case 'w' :
			return $week;
			break;
		case 'm' :
			return $month;
			break;
	}
}

/** 表单HASH */
function get_formhash() {
	$formhash = substr(md5(substr(time(), 0, -7)), 8, 8);
	
	return $formhash;
}

/** 生成指定长度的随机字符串 */
function random($length = 16, $isnum = false){
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $isnum ? 10 : 35);
	$seed = $isnum ? $seed.'zZ'.strtoupper($seed) : str_replace('0', '', $seed).'01234056789';
	
	$randstr = '';
	$max = strlen($seed) - 1;
	for ($i = 0; $i < $length; $i++) {
		$randstr .= $seed{mt_rand(0, $max)};
	}
	return $randstr;
}

/** 编码函数 */
function authcode($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key = md5($key ? $key : 'yeN3g9EbNfiaYfodV63dI1j8Fbk5HaL7W4yaW4y7u2j4Mf45mfg2v899g451k576');
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

/** 将数组转换为以逗号分隔的字符串 */
function dimplode($array) {
	if (!empty($array)) {
		return "'".implode("','", is_array($array) ? $array : array($array))."'";
	} else {
		return '';
	}
}

/** apache模块检测 */
function apache_mod_enabled($module) {
	if (function_exists('apache_get_modules')) {
		$apache_mod = apache_get_modules();
		if (in_array($module, $apache_mod)) {
			return true;
		} else {
			return false;
		}
	}
}

/** 获取客户端IP */
function get_client_ip() {
	if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$client_ip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$client_ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$client_ip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$client_ip = $_SERVER['REMOTE_ADDR'];
	}
	
	$client_ip = addslashes($client_ip);
	@preg_match("/[\d\.]{7,15}/", $client_ip, $ip);
	$ip_addr = $ip[0] ? $ip[0] : 'unknown';
	unset($ip);
	
	return $ip_addr;
}

function get_domain($url) {
	if (preg_match("/^(http:\/\/)?([^\/]+)/i", $url, $domain)) {
		return $domain[2];
	} else {
		return false;
	}
}

function get_root_domain($url){   
$arr = parse_url($url);     
$data = $arr['scheme']."://".$arr['host'];   
if($data){
  return $data;
}else{
  return false;
}

}
function format_url($url) {
	if ($url != "") {
		$url_parts = parse_url($url);

		$scheme = isset($url_parts['scheme'])?$url_parts['scheme']:"";
		$host = isset($url_parts['host'])?$url_parts['host']:"";
		$path =  isset($url_parts['path'])?$url_parts['path']:"";
		$port = !empty($url_parts['port']) ? ':'.$url_parts['port'] : '';
		$url = (!empty($scheme) ? $scheme.'://'.$host : (!empty($host) ? 'http://'.$host : 'http://'.$path)).$port.'/';
		
		return $url;
	}
}

/** 获取指定URL内容 */
function get_url_content($url) {
	if (empty($url)) {
    	return false;
	}
	
	$timeout = 30;
    // $data = '';
    // for ($i = 0; $i < 5 && empty($data); $i++) {
		if (function_exists('curl_init')) {
			$ch = curl_init();
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);  // 从证书中检查SSL加密算法是否存在  
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
			
        	$data = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($http_code != '200') {
				return false;
			}
        } elseif (function_exists('fsockopen')) {
			$params = parse_url($url);
			$host = $params['host'];
			$path = $params['path'];
			$query = $params['query'];
			$fp = @fsockopen($host, 80, $errno, $errstr, $timeout);
			if (!$fp) {
				return false;
			} else {
				$result = '';
				$out = "GET /" . $path . '?' . $query . " HTTP/1.0\r\n";
				$out .= "Host: $host\r\n";
				$out .= "Connection: Close\r\n\r\n";
				@fwrite($fp, $out);
				$http_200 = preg_match('/HTTP.*200/', @fgets($fp, 1024));
				if (!$http_200) {
					return false;
				}

				while (!@feof($fp)) {
                if ($get_info) {
                    $data .= @fread($fp, 1024);
                } else {
                    if (@fgets($fp, 1024) == "\r\n") {
                        $get_info = true;
                    }
                }
            }
            @fclose($fp);
        }
        } elseif (function_exists( 'file_get_contents')) {
			if (!get_cfg_var('allow_url_fopen')) {
				return false;
			}
            $context = stream_context_create(
				array('http' => array('timeout' => $timeout))
			);
            $data = @file_get_contents($url, false, $context);
        } else {
			return false; 
		}
	// }
	
	if (!$data) {
		return false;
    } else {
		$encode = mb_detect_encoding($data, array('ascii', 'gb2312', 'utf-8', 'gbk'));
		if ($encode == 'EUC-CN' || $encode == 'CP936') {
			$data = @mb_convert_encoding($data, 'utf-8', 'gb2312');
		}
		
        return $data;
	}
}

/** 检查非法关键词 */
function censor_words($keywords = '', $content = '') {
	$checked = true;
	if (!empty($keywords) && !empty($content)) {
		$wordarr = explode(',', $keywords);
		foreach ($wordarr as $val) {
			if (preg_match('/'.$val.'/i', $content)) {
				$checked = false;
			}
		}
	}
	
	return $checked;
}


/** UTF8字符串长度  */
function strlen_utf8($str) {
	$i = 0;  
	$count = 0;  
	$len = strlen ($str);  
	while ($i < $len) {  
		$chr = ord ($str[$i]);  
		$count++;  
		$i++;  
		if($i >= $len) break;  
		if($chr & 0x80) {  
			$chr <<= 1;  
			while ($chr & 0x80) {  
				$i++;  
				$chr <<= 1;  
			}  
		}  
	}  
	return $count;  
} 

function is_addslashes($str){
  if(!get_magic_quotes_gpc()){
//没有开启再去转义，开启就没有必要了
   return  addslashes($str);
 } 
}


/** 获取内容中的链接 */
function get_content_links($document) {	
	preg_match_all("'<\s*a\s.*?href\s*=\s*([\"\'])?(?(1) (.*?)\\1 | ([^\s\>]+))'isx", $document, $matches);

	while(list($key, $val) = each($matches[2])) {
		if (!empty($val)) $links[] = $val;
	}
		
	while(list($key, $val) = each($matches[3])) {
		if (!empty($val)) $links[] = $val;
	}
	
	return $links;
}

/** 保存远程文件到本地 */
function save_to_local($weburl, $savepath = '') {
	$succeed = false;

	set_time_limit(0);
	if (substr($savepath, -1) != '/') $savepath .= '/';
	if (!is_dir($savepath)) @mkdir($savepath, 0777);
	
  $imgurl = 'https://blinky.nemui.org/shot/large?http://'.$weburl;
	$newpath = $savepath.$weburl.'.jpg';
	$data = get_url_content($imgurl);
	if (strlen($data) != 1984) {
		if ($data) {
			$fp = @fopen($newpath, "w");
       		@fwrite($fp, $data);
       		@fclose($fp);
			
			$succeed = true;
		}
	}
	
	if ($succeed) {
		return $newpath;
	} else {
		return $succeed;
	}
}



// 获得字符串中第一个图片作为标题
function get_img($str){

  if(preg_match('/<img[^>]*src=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i',$str,$arr)){
     return  $arr[1];
  }else{
    return false;
  }
// $arr['1']  //url
// $arr['2']  //title
// $arr['3'] //alt
}

// 过滤字符串中的图片
function get_str($str,$num=''){
  if(!empty($num)){
     $content = preg_replace("/<img.*?>/si","",$str);
     return mb_substr(strip_tags($content),0,$num);
  }else{
     $content = preg_replace("/<img.*?>/si","",$str);
     return  strip_tags($content);  
  }
 
}

function show_time($time = 0,$test=''){ 
    if(empty($time)){return $test;} 
    $time = substr($time,0,10); 
    $ttime = time() - $time; 
    if($ttime <= 0 || $ttime < 60){ 
        return '几秒前'; 
    }    
    if($ttime > 60 && $ttime <120){ 
        return '1分钟前'; 
    } 
     
    $i = floor($ttime / 60);                            //分 
    $h = floor($ttime / 60 / 60);                       //时 
    $d = floor($ttime / 86400);                         //天 
    $m = floor($ttime / 2592000);                       //月 
    $y = floor($ttime / 60 / 60 / 24 / 365);            //年 
    if($i < 30){ 
        return $i.'分钟前'; 
    } 
    if($i > 30 && $i < 60){ 
        return '一小时内'; 
    } 
    if($h>=1 && $h < 24){ 
        return $h.'小时前'; 
    } 
    if($d>=1 && $d < 30){ 
        return $d.'天前'; 
    }    
    if($m>=1 && $m < 12){        
        return $m.'个月前'; 
    } 
    if($y){ 
        return $y.'年前'; 
    }    
    return ""; 
     
} 
function get_ico($url){


   	 $arr = get_headers($url.'/favicon.ico');
       // $arr[0];
       $arr2 = explode(' ',$arr[0]);
       if(empty($arr)){ return false; }
		if($arr2[1] == '200'){
			return true;
		}else{
		    return false;
		}

}

function addlog($value){

				    $file = ROOT_PATH."log.txt";//保存的文件名
					$handle = fopen($file, 'a');
                    $time = date("Y-m-d H:i:s",time());
                     
                    $content = "";
                    $content.= $value;
                    $content.= "时间：".$time.";\r\n";

					fwrite($handle,$content);
					fclose($handle);  	
}



//下载远程压缩包到本地
function httpcopy($down_url,$savedir="", $timeout=1060) {


    $info = json_decode(file_get_contents($down_url),true); 
   
    $url = encryptDecrypt(CLIENT_API_KEY,$info['data']['encryptUrl'],true); //解密

    $url = trim(str_replace(" ","%20",$url));
    $file = pathinfo($url,PATHINFO_BASENAME);  //返回  文件名.zip
    $filename = pathinfo($url,PATHINFO_FILENAME);  //返回  文件名称
    !is_dir($savedir) && @mkdir($savedir,0755,true);
    if(function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $temp = curl_exec($ch);         
        if(@file_put_contents($savedir.$file,$temp) && !curl_error($ch)) {
            return $file;
        } else {
            return false;
        }
        curl_close($ch);
    } else {
 
        $opts = array(
            "http"=>array(
            "method"=>"GET",
            "header"=>"",
            "timeout"=>$timeout)
        );
        $context = stream_context_create($opts);
        if(@copy($url,$savedir.$file, $context)) {
            return $file;
        } else {
        
            return false;
        }
    }

}

function delFile($dirName){
    if(file_exists($dirName) && $handle=opendir($dirName)){
        while(false!==($item = readdir($handle))){
            if($item!= "." && $item != ".."){
                if(file_exists($dirName.'/'.$item) && is_dir($dirName.'/'.$item)){
                    delFile($dirName.'/'.$item);
                }else{
                    if(unlink($dirName.'/'.$item)){
                        return true;
                    }
                }
            }
        }
        closedir( $handle);
    }
}

//获得配置信息函数
function get_options() {
	global $Db;
	$options = [];
	$sql = "SELECT option_name, option_value FROM ".table('options');
	$results = $Db->query($sql);
	foreach ($results as $v) {
		$options[$v['option_name']] = addslashes($v['option_value']);
	}
	return load_cache('options') ? load_cache('options') : $options;
}
//url构造函数
function url($url,$param="",$domain=""){


 if ('/' != PATHINFO_DEPR) {
// 安全替换
      $url = str_replace('/',PATHINFO_DEPR, $url);
}


if(!empty($domain)){
  $domain = rtrim($domain,'/');
}else{

  $domain ='';
}

// 匹配左侧第一位是否为 右斜杠
if(stripos($url,'/') >=0 ){
   $url= ltrim($url,"/");
}


if(PATHINFO_DEPR == '/'){
   $array = explode('/',$url);
}elseif(PATHINFO_DEPR == '-'){
   $array = explode('-',$url);
}elseif(PATHINFO_DEPR == '_'){
   $array = explode('_',$url);
}


if(count($array)==1){
	
   $controller =array_pop($array);
   if(__MODULE__){
   	//当前模块
   	$module = __MODULE__;
   }else{
   	// 默认模块
   	$module= DEFAULE_MODULE;
   }
}elseif(count($array)==2){
	
    $controller = !empty($array[1])?$array[1]:DEFAULE_CONTROLLER;
    $module    = !empty($array[0])?$array[0]:DEFAULE_MODULE;
}

  
    $paramStr= '';
  if(is_array($param)){
   
	   foreach($param as $k=>$v ){

           $paramStr.= PATHINFO_DEPR.$k.PATHINFO_DEPR.$v;
	   }
	    return $domain.'/'.$module.PATHINFO_DEPR.$controller.$paramStr.'.'.URL_HTML_SUFFIX;
  }else{
  	   
        return $domain.'/'.$module.PATHINFO_DEPR.$controller.$paramStr.'.'.URL_HTML_SUFFIX;
  }


 
	
}

/** thumbs */
function get_webthumb($web_url) {
	global $options;   
    return "https://blinky.nemui.org/shot/large?".$web_url;
}
/** thumbs */
// function get_webthumb($web_pic) {
// 	global $options;
    

// 	if (!empty($web_pic)) {
// 		$strurl = rtrim($options['site_root'],'/').$web_pic;
// 	} else {
// 		$strurl = $options['site_root'].'public/images/nopic.gif';
// 	}
	
// 	return $strurl;
// }


//xml 转换成数组 包含2个函数
function xml_to_array($xml)                              
{                                                        
//将XML转为array
$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
return $array_data;                                         
}    
                                                    
function struct_to_array($item) {                        
  if(!is_string($item)) {                                
    $item = (array)$item;                                
    foreach ($item as $key=>$val){                       
      $item[$key]  =  struct_to_array($val);             
    }                                                    
  }                                                      
  return $item;                                          
}                                                        
/*移动端判断*/
function is_mobile()
{ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
} 

// session操作函数
function session($name='',$value='',$lifeTime='',$domain='',$path =''){

 if(!empty($name) && empty($value)){
     if($name =='start'){
         session_start();
     }elseif($name =='destroy'){
         session_destroy();
     }elseif(is_null($value)){
     
         unset($_SESSION[SESSION_PREFIX][$name]);
     }else{
         if(isset($_SESSION[SESSION_PREFIX][$name])){
            return $_SESSION[SESSION_PREFIX][$name];
         }else{
            return false;
         }
        
     }

   
}elseif(!empty($name) && !empty($value)){

     $_SESSION[SESSION_PREFIX][$name] = $value;

 }elseif(is_null($name) && empty($value)){

    unset($_SESSION[SESSION_PREFIX]);

 }

//设置 session 保存路径
   if(!empty($path)){
     @ini_set('session.cookie_path',$path);
   }
//设置 session 生存时间
   if(!empty($lifeTime)){
     @ini_set('session.cookie_lifetime',$lifeTime);
   }
//设置 session 域名
   if(!empty($domain)){
     @ini_set('session.cookie_domain',$domain); 
   }


}
// 是否ajax请求	
function isAjax(){
  if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    return true;
  }else{
    return false;
  }
}
function sendmail($mailto, $subject, $content) {
	global $options;
// $options['site_root']
	require(EXTEND_PATH.'phpmailer/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->SMTPDebug = 1;
	$mail->IsSMTP(); //使用SMTP方式发送
	$mail->SMTPAuth = ($options['smtp_auth'] == 'yes') ? true : false; //启用SMTP验证功能，一般需要开启
	$mail->Host     = $options['smtp_host']; //smtp服务器地址
	$mail->Port     = $options['smtp_port']; //smtp服务器端口
	$mail->Username = $options['smtp_user']; //smtp服务器帐号
	$mail->Password = $options['smtp_pass']; // smtp服务器密码
	$mail->CharSet  = 'utf-8'; //发送的邮件内容编码
	$mail->SetFrom($options['smtp_user'], $options['site_name']); //发件人的邮箱和姓名
	$mail->AddReplyTo($options['smtp_user'], $options['site_name']); //回复时的邮箱和姓名，一般跟发件人一样
	//$mail->SMTPSecure = "ssl"; //gmail需要启用sll安全连接
	$mail->Subject = $subject; //邮件主题
	$mail->MsgHTML($content); //邮件内容，支持html代码
	//发送邮件
	if (is_array($mailto)) {
		//同时发送给多个人
		foreach ($mailto as $key => $value) {
			$mail->AddAddress($value, "");  // 收件人邮箱和姓名
		}
	} else {		//只发送给一个人
		$mail->AddAddress($mailto, "");  // 收件人邮箱和姓名
	}
	
	if (!$mail->Send()) {
		// echo "Mailer Error: ".$mail->ErrorInfo;
		return false;  
	} else {
		return true;
	}
}


//删除文件夹及其文件夹下的所有文件
function del_dir($dir) {
      //先删除目录下的文件：
      $dh=opendir($dir);
      while ($file=readdir($dh)) {
        if($file!="." && $file!="..") {
          $fullpath=$dir."/".$file;
          if(!is_dir($fullpath)) {
              unlink($fullpath);
          } else {
              del_dir($fullpath);
          }
        }
      }

       closedir($dh);
      //删除当前文件夹：
      if(rmdir($dir)) {
        return true;
      } else {
        return false;
      }
}

//参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
 function curl_request($url,$post='',$cookie='', $returnCookie=0){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "https://www.baidu.com/");
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //支持https
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
}
