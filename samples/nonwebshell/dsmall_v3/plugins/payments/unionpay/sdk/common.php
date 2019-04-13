<?php
namespace com\unionpay\acp\sdk;
include_once 'log.class.php';
include_once 'SDKConfig.php';
header ( 'Content-type:text/html;charset=utf-8' );

class LogUtil
{
	private static $_logger = null;
	public static function getLogger()
	{
		if (LogUtil::$_logger == null ) {
			$l = SDKConfig::getSDKConfig()->logLevel;
			if("INFO" == strtoupper($l))
				$level = PhpLog::INFO;
			else if("DEBUG" == strtoupper($l))
				$level = PhpLog::DEBUG;
			else if("ERROR" == strtoupper($l))
				$level = PhpLog::ERROR;
			else if("WARN" == strtoupper($l))
				$level = PhpLog::WARN;
			else if("FATAL" == strtoupper($l))
				$level = PhpLog::FATAL;
			else
				$level = PhpLog::OFF;
			LogUtil::$_logger = new PhpLog ( SDKConfig::getSDKConfig()->logFilePath, "PRC", $level );
		}
		return self::$_logger;
	}
}

/**
 * key1=value1&key2=value2转array
 * @param $str key1=value1&key2=value2的字符串
 * @param $$needUrlDecode 是否需要解url编码，默认不需要
 */
function parseQString($str, $needUrlDecode=false){
	$result = array();
	$len = strlen($str);
	$temp = "";
	$curChar = "";
	$key = "";
	$isKey = true;
	$isOpen = false;
	$openName = "\0";

	for($i=0; $i<$len; $i++){
		$curChar = $str[$i];
		if($isOpen){
			if( $curChar == $openName){
				$isOpen = false;
			}
			$temp .= $curChar;
		} elseif ($curChar == "{"){
			$isOpen = true;
			$openName = "}";
			$temp .= $curChar;
		} elseif ($curChar == "["){
			$isOpen = true;
			$openName = "]";
			$temp .= $curChar;
		} elseif ($isKey && $curChar == "="){
			$key = $temp;
			$temp = "";
			$isKey = false;
		} elseif ( $curChar == "&" && !$isOpen){
			putKeyValueToDictionary($temp, $isKey, $key, $result, $needUrlDecode);
			$temp = "";
			$isKey = true;
		} else {
			$temp .= $curChar;
		}
	}
	putKeyValueToDictionary($temp, $isKey, $key, $result, $needUrlDecode);
	return $result;
}


function putKeyValueToDictionary($temp, $isKey, $key, &$result, $needUrlDecode) {
	if ($isKey) {
		$key = $temp;
		if (strlen ( $key ) == 0) {
			return false;
		}
		$result [$key] = "";
	} else {
		if (strlen ( $key ) == 0) {
			return false;
		}
		if ($needUrlDecode)
			$result [$key] = urldecode ( $temp );
		else
			$result [$key] = $temp;
	}
}

/**
 * 取得备份文件名
 * 
 * Enter description here ...
 * @param $path
 */
function getBackupFileName($path){
	$i = strrpos($path, ".");
	$leftFileName = substr($path, 0, $i);
	$rightFileName = substr($path, $i + 1);
	$newFileName = $leftFileName . '_backup.' . $rightFileName;
	return $newFileName;
}

/**
 * 字符串转换为 数组
 *
 * @param unknown_type $str
 * @return multitype:unknown
 */
function convertStringToArray($str) {
	return parseQString($str);
}

/**
 * 压缩文件 对应java deflate
 *
 * @param unknown_type $params        	
 */
function deflate_file(&$params) {
	$logger = LogUtil::getLogger();
	foreach ( $_FILES as $file ) {
		$logger->LogInfo ( "---------处理文件---------" );
		if (file_exists ( $file ['tmp_name'] )) {
			$params ['fileName'] = $file ['name'];
			
			$file_content = file_get_contents ( $file ['tmp_name'] );
			$file_content_deflate = gzcompress ( $file_content );
			
			$params ['fileContent'] = base64_encode ( $file_content_deflate );
			$logger->LogInfo ( "压缩后文件内容为>" . base64_encode ( $file_content_deflate ) );
		} else {
			$logger->LogInfo ( ">>>>文件上传失败<<<<<" );
		}
	}
}


/**
 * 讲数组转换为string
 *
 * @param $para 数组        	
 * @param $sort 是否需要排序        	
 * @param $encode 是否需要URL编码        	
 * @return string
 */
function createLinkString($para, $sort, $encode) {
	if($para == NULL || !is_array($para))
		return "";
	
	$linkString = "";
	if ($sort) {
		$para = argSort ( $para );
	}
	while ( list ( $key, $value ) = each ( $para ) ) {
		if ($encode) {
			$value = urlencode ( $value );
		}
		$linkString .= $key . "=" . $value . "&";
	}
	// 去掉最后一个&字符
	$linkString = substr ( $linkString, 0, count ( $linkString ) - 2 );
	
	return $linkString;
}

/**
 * 对数组排序
 *
 * @param $para 排序前的数组
 *        	return 排序后的数组
 */
function argSort($para) {
	ksort ( $para );
	reset ( $para );
	return $para;
}


function getProjName(){
	$dir = str_replace("\\","/", dirname(__FILE__));
	$rootDir = str_replace("\\", "/", $_SERVER ['DOCUMENT_ROOT']);
	if($rootDir[strlen($rootDir) - 1] != "/") $rootDir = $rootDir . "/";
	$index = strlen($rootDir);
	$dir = substr($dir, $index);
	$index = strpos($dir, "/");
	$projName = substr($dir, 0, $index);
	return $projName;
}

