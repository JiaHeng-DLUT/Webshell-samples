<?php
class AppUtil{
	/**
	 * 将参数数组签名
	 */
	public static function SignArray(array $array,$appkey){
		$array['key'] = $appkey;// 将key放到数组中一起进行排序和组装
		ksort($array);
		$blankStr = AppUtil::ToUrlParams($array);
		$sign = md5($blankStr);
		return $sign;
	}
	
	public static function ToUrlParams(array $array)
	{
		$buff = "";
		foreach ($array as $k => $v)
		{
			if($v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
/**
	 * 校验签名
	 * @param array 参数
	 * @param unknown_type appkey
	 */
	public static function ValidSign(array $array,$appkey){
		$sign = $array['sign'];
		unset($array['sign']);
		$array['key'] = $appkey;
		$mySign = AppUtil::SignArray($array, $appkey);
		return strtolower($sign) == strtolower($mySign);
	}
	
	
}
?>