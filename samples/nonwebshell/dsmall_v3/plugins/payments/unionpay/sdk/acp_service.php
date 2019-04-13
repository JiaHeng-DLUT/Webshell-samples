<?php
namespace com\unionpay\acp\sdk;
header ( 'Content-type:text/html;charset=utf-8' );
include_once 'log.class.php';
include_once 'SDKConfig.php';
include_once 'common.php';
include_once 'cert_util.php';

class AcpService {

	/**
	 *
	 * 更新证书
	 *
	 * Enter description here ...
	 */
	public static function updateEncryptCert(&$params)
	{
        $logger = LogUtil::getLogger();
		// 取得证书
		$strCert = $params['encryptPubKeyCert'];
		$certType = $params['certType'];
		openssl_x509_read($strCert);
		$certInfo = openssl_x509_parse($strCert);
		if($certType === "01"){
			$logger->LogInfo ('原证书certId：'.CertUtil::getEncryptCertId().'，新证书certId：'.$certInfo['serialNumber']);
			// 更新敏感信息加密公钥
			if (CertUtil::getEncryptCertId() != $certInfo['serialNumber']) {
				$newFileName = getBackupFileName(SDKConfig::getSDKConfig()->encryptCertPath);
				// 将原证书备份重命名
				if(!copy(SDKConfig::getSDKConfig()->encryptCertPath, $newFileName)){
					$logger->LogError ('原证书备份失败');
					return -1;
				}
				// 更新证书
				if(!file_put_contents(SDKConfig::getSDKConfig()->encryptCertPath, $strCert)){
					$logger->LogError ('更新证书失败');
					return -1;
				}
				$logger->LogInfo ('证书更新成功');
				return 1;
			} else {						
				$logger->LogInfo ('证书无需更新');
				return 0;
			}
		} else if($certType === "02"){
			return 0;
		} else {						
			$logger->LogError ('unknown cerType: '. $certType);
			return -1;
		}
	}

	/**
	 * 签名
	 * @param req 请求要素
	 * @param resp 应答要素
	 * @return 是否成功
	 */
	static function sign(&$params) {
		if($params['signMethod']=='01')	{
			return AcpService::signByCertInfo($params, SDKConfig::getSDKConfig()->signCertPath, SDKConfig::getSDKConfig()->signCertPwd);
		} else {
			return AcpService::signBySecureKey($params, SDKConfig::getSDKConfig()->secureKey);
		} 
	}
	
	static function signByCertInfo(&$params, $cert_path, $cert_pwd) {

		$logger = LogUtil::getLogger();
		$logger->LogInfo ( '=====签名报文开始======' );
		if(isset($params['signature'])){
			unset($params['signature']);
		}
		
		$result = false;
		
		if($params['signMethod']=='01') {
			//证书ID
			$params ['certId'] = CertUtil::getSignCertIdFromPfx($cert_path, $cert_pwd);
			$private_key = CertUtil::getSignKeyFromPfx( $cert_path, $cert_pwd );
			// 转换成key=val&串
			$params_str = createLinkString ( $params, true, false );
			$logger->LogInfo ( "签名key=val&...串 >" . $params_str );
			if($params['version']=='5.0.0'){
				$params_sha1x16 = sha1 ( $params_str, FALSE );
				$logger->LogInfo ( "摘要sha1x16 >" . $params_sha1x16 );
				// 签名
				$result = openssl_sign ( $params_sha1x16, $signature, $private_key, OPENSSL_ALGO_SHA1);
		
				if ($result) {
					$signature_base64 = base64_encode ( $signature );
					$logger->LogInfo ( "签名串为 >" . $signature_base64 );
					$params ['signature'] = $signature_base64;
				} else {
					$logger->LogInfo ( ">>>>>签名失败<<<<<<<" );
				}
			} else if($params['version']=='5.1.0'){
				//sha256签名摘要
				$params_sha256x16 = hash( 'sha256',$params_str);
				$logger->LogInfo ( "摘要sha256x16 >" . $params_sha256x16 );
				// 签名
				$result = openssl_sign ( $params_sha256x16, $signature, $private_key, 'sha256');
				if ($result) {
					$signature_base64 = base64_encode ( $signature );
					$logger->LogInfo ( "签名串为 >" . $signature_base64 );
					$params ['signature'] = $signature_base64;
				} else {
					$logger->LogInfo ( ">>>>>签名失败<<<<<<<" );
				}
			} else {
				$logger->LogError ( "wrong version: " + $params['version'] );
				$result = false;
			}
		} else {
			$logger->LogError ( "signMethod不正确");
			$result = false;
		}
		$logger->LogInfo ( '=====签名报文结束======' );
		return $result;
	}
	
	static function signBySecureKey(&$params, $secureKey) {
		
		$logger = LogUtil::getLogger();
		$logger->LogInfo ( '=====签名报文开始======' );
		
		if($params['signMethod']=='11') {
			// 转换成key=val&串
			$params_str = createLinkString ( $params, true, false );
			$logger->LogInfo ( "签名key=val&...串 >" . $params_str );
			$params_before_sha256 = hash('sha256', $secureKey);
			$params_before_sha256 = $params_str.'&'.$params_before_sha256;
			$logger->LogDebug( "before final sha256: " . $params_before_sha256);
			$params_after_sha256 = hash('sha256',$params_before_sha256);
			$logger->LogInfo ( "签名串为 >" . $params_after_sha256 );
			$params ['signature'] = $params_after_sha256;
			$result = true;
		} else if($params['signMethod']=='12') {
			//TODO SM3
			$logger->LogError ( "signMethod=12未实现");
			$result = false;
		} else {
			$logger->LogError ( "signMethod不正确");
			$result = false;
		}
		$logger->LogInfo ( '=====签名报文结束======' );
		return $result;
	}

	/**
	 * 验签
	 * @param $params 应答数组
	 * @return 是否成功
	 */
	static function validate($params) {

		$logger = LogUtil::getLogger();

		$isSuccess = false;

		if($params['signMethod']=='01')
		{
			$signature_str = $params ['signature'];
			unset ( $params ['signature'] );
			$params_str = createLinkString ( $params, true, false );
			$logger->LogInfo ( '报文去[signature] key=val&串>' . $params_str );
			$logger->LogInfo ( '签名原文>' . $signature_str );
			if($params['version']=='5.0.0'){

				// 公钥
				$public_key = CertUtil::getVerifyCertByCertId ( $params ['certId'] );
				$signature = base64_decode ( $signature_str );
				$params_sha1x16 = sha1 ( $params_str, FALSE );
				$logger->LogInfo ( 'sha1>' . $params_sha1x16 );
				$isSuccess = openssl_verify ( $params_sha1x16, $signature, $public_key, OPENSSL_ALGO_SHA1 );
				$logger->LogInfo ( $isSuccess ? '验签成功' : '验签失败' );

			} else if($params['version']=='5.1.0'){

				$strCert = $params['signPubKeyCert'];
				$strCert = CertUtil::verifyAndGetVerifyCert($strCert);
				if($strCert == null){
                	$logger->LogError ("validate cert err: " + $params["signPubKeyCert"]);
					$isSuccess = false;
				} else {
					$params_sha256x16 = hash('sha256', $params_str);
					$logger->LogInfo ( 'sha256>' . $params_sha256x16 );
					$signature = base64_decode ( $signature_str );
					$isSuccess = openssl_verify ( $params_sha256x16, $signature,$strCert, "sha256" );
					$logger->LogInfo ( $isSuccess ? '验签成功' : '验签失败' );
				}

			} else {
				$logger->LogError ( "wrong version: " + $params['version'] );
				$isSuccess = false;
			}
		} else {
			$isSuccess = AcpService::validateBySecureKey($params, SDKConfig::getSDKConfig()->secureKey);
		} 
		return $isSuccess;
	}

	static function validateBySecureKey($params, $secureKey) { 
		
		$logger = LogUtil::getLogger();
		$isSuccess = false;
		
		$signature_str = $params ['signature'];
		unset ( $params ['signature'] );
		$params_str = createLinkString ( $params, true, false );
		$logger->LogInfo ( '报文去[signature] key=val&串>' . $params_str );
		$logger->LogInfo ( '签名原文>' . $signature_str );
		
		if($params['signMethod']=='11') {
			
			$params_before_sha256 = hash('sha256', $secureKey);
			$params_before_sha256 = $params_str.'&'.$params_before_sha256;
			$params_after_sha256 = hash('sha256',$params_before_sha256);
			$isSuccess = $params_after_sha256 == $signature_str;
			$logger->LogInfo ( $isSuccess ? '验签成功' : '验签失败' );
		} else if($params['signMethod']=='12') {
			//TODO SM3
			$logger->LogError ( "sm3没实现");
			$isSuccess = false;
		} else {
			$logger->LogError ( "signMethod不正确");
			$isSuccess = false;
		}

		return $isSuccess;
		
	}
	
	/**
	 * @deprecated 5.1.0开发包已删除此方法，请直接参考5.1.0开发包中的VerifyAppData.php验签。
	 * 对控件支付成功返回的结果信息中data域进行验签
	 * @param $jsonData json格式数据，例如：{"sign" : "J6rPLClQ64szrdXCOtV1ccOMzUmpiOKllp9cseBuRqJ71pBKPPkZ1FallzW18gyP7CvKh1RxfNNJ66AyXNMFJi1OSOsteAAFjF5GZp0Xsfm3LeHaN3j/N7p86k3B1GrSPvSnSw1LqnYuIBmebBkC1OD0Qi7qaYUJosyA1E8Ld8oGRZT5RR2gLGBoiAVraDiz9sci5zwQcLtmfpT5KFk/eTy4+W9SsC0M/2sVj43R9ePENlEvF8UpmZBqakyg5FO8+JMBz3kZ4fwnutI5pWPdYIWdVrloBpOa+N4pzhVRKD4eWJ0CoiD+joMS7+C0aPIEymYFLBNYQCjM0KV7N726LA==",  "data" : "pay_result=success&tn=201602141008032671528&cert_id=68759585097"}
	 * @return 是否成功
	 */
	static function validateAppResponse($jsonData) {

		$data = json_decode($jsonData);
		$sign = $data->sign;
		$data = $data->data;
		$dataMap = parseQString($data);
		$public_key = CertUtil::getVerifyCertByCertId( $dataMap ['cert_id'] );
		$signature = base64_decode ( $sign );
		$params_sha1x16 = sha1 ( $data, FALSE );
		$isSuccess = openssl_verify ( $params_sha1x16, $signature,$public_key, OPENSSL_ALGO_SHA1 );
		return $isSuccess;
	}

	/**
	 * 后台交易 HttpClient通信
	 *
	 * @param unknown_type $params
	 * @param unknown_type $url
	 * @return mixed
	 */
	static function post($params, $url) {
		$logger = LogUtil::getLogger();

		$opts = createLinkString ( $params, false, true );
		$logger->LogInfo ( "后台请求地址为>" . $url );
		$logger->LogInfo ( "后台请求报文为>" . $opts );

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false ); // 不验证证书
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false ); // 不验证HOST
		curl_setopt ( $ch, CURLOPT_SSLVERSION, 1 ); // http://php.net/manual/en/function.curl-setopt.php页面搜CURL_SSLVERSION_TLSv1
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
				'Content-type:application/x-www-form-urlencoded;charset=UTF-8' 
				) );
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $opts );
				curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
				$html = curl_exec ( $ch );
				$logger->LogInfo ( "后台返回结果为>" . $html );

				if(curl_errno($ch)){
					$errmsg = curl_error($ch);
					curl_close ( $ch );
					$logger->LogInfo ( "请求失败，报错信息>" . $errmsg );
					return null;
				}
				if( curl_getinfo($ch, CURLINFO_HTTP_CODE) != "200"){
					$errmsg = "http状态=" . curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close ( $ch );
					$logger->LogInfo ( "请求失败，报错信息>" . $errmsg );
					return null;
				}
				curl_close ( $ch );
				$result_arr = convertStringToArray ( $html );
				return $result_arr;
	}

	/**
	 * 后台交易 HttpClient通信
	 *
	 * @param unknown_type $params
	 * @param unknown_type $url
	 * @return mixed
	 */
	static function get($params, $url) {

		$logger = LogUtil::getLogger();

		$opts = createLinkString ( $params, false, true );
		$logger->LogDebug( "后台请求地址为>" . $url ); //get的日志太多而且没啥用，设debug级别
		$logger->LogDebug ( "后台请求报文为>" . $opts );

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false ); // 不验证证书
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false ); // 不验证HOST
		curl_setopt ( $ch, CURLOPT_SSLVERSION, 1 ); // http://php.net/manual/en/function.curl-setopt.php页面搜CURL_SSLVERSION_TLSv1
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
		'Content-type:application/x-www-form-urlencoded;charset=UTF-8'
		) );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $opts );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$html = curl_exec ( $ch );
		$logger->LogInfo ( "后台返回结果为>" . $html );
		if(curl_errno($ch)){
			$errmsg = curl_error($ch);
			curl_close ( $ch );
			$logger->LogDebug ( "请求失败，报错信息>" . $errmsg );
			return null;
		}
		if( curl_getinfo($ch, CURLINFO_HTTP_CODE) != "200"){
			$errmsg = "http状态=" . curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ( $ch );
			$logger->LogDebug ( "请求失败，报错信息>" . $errmsg );
			return null;
		}
		curl_close ( $ch );
		return $html;
	}

	static function createAutoFormHtml($params, $reqUrl) {
		// <body onload="javascript:document.pay_form.submit();">
		$encodeType = isset ( $params ['encoding'] ) ? $params ['encoding'] : 'UTF-8';
		$html = <<<eot
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset={$encodeType}" />
</head>
<body onload="javascript:document.pay_form.submit();">
    <form id="pay_form" name="pay_form" action="{$reqUrl}" method="post">
	
eot;
		foreach ( $params as $key => $value ) {
			$html .= "    <input type=\"hidden\" name=\"{$key}\" id=\"{$key}\" value=\"{$value}\" />\n";
		}
		$html .= <<<eot
   <!-- <input type="submit" type="hidden">-->
    </form>
</body>
</html>
eot;
		$logger = LogUtil::getLogger();
		$logger->LogInfo ( "自动跳转html>" . $html );
		return $html;
	}



	static function getCustomerInfo($customerInfo) {
		if($customerInfo == null || count($customerInfo) == 0 )
		return "";
		return base64_encode ( "{" . createLinkString ( $customerInfo, false, false ) . "}" );
	}

	/**
	 * map转换string，按新规范加密
	 *
	 * @param
	 *        	$customerInfo
	 */
	static function getCustomerInfoWithEncrypt($customerInfo) {
		if($customerInfo == null || count($customerInfo) == 0 )
		return "";
		$encryptedInfo = array();
		foreach ( $customerInfo as $key => $value ) {
			if ($key == 'phoneNo' || $key == 'cvn2' || $key == 'expired' ) {
				//if ($key == 'phoneNo' || $key == 'cvn2' || $key == 'expired' || $key == 'certifTp' || $key == 'certifId') {
				$encryptedInfo [$key] = $customerInfo [$key];
				unset ( $customerInfo [$key] );
			}
		}
		if( count ($encryptedInfo) > 0 ){
			$encryptedInfo = createLinkString ( $encryptedInfo, false, false );
			$encryptedInfo = AcpService::encryptData ( $encryptedInfo, SDKConfig::getSDKConfig()->encryptCertPath );
			$customerInfo ['encryptedInfo'] = $encryptedInfo;
		}
		return base64_encode ( "{" . createLinkString ( $customerInfo, false, false ) . "}" );
	}


	/**
	 * 解析customerInfo。
	 * 为方便处理，encryptedInfo下面的信息也均转换为customerInfo子域一样方式处理，
	 * @param unknown $customerInfostr
	 * @return array形式ParseCustomerInfo
	 */
	static function parseCustomerInfo($customerInfostr) {
		$customerInfostr = base64_decode($customerInfostr);
		$customerInfostr = substr($customerInfostr, 1, strlen($customerInfostr) - 2);
		$customerInfo = parseQString($customerInfostr);
		if(array_key_exists("encryptedInfo", $customerInfo)) {
			$encryptedInfoStr = $customerInfo["encryptedInfo"];
			unset ( $customerInfo ["encryptedInfo"] );
			$encryptedInfoStr = AcpService::decryptData($encryptedInfoStr);
			$encryptedInfo = parseQString($encryptedInfoStr);
			foreach ($encryptedInfo as $key => $value){
				$customerInfo[$key] = $value;
			}
		}
		return $customerInfo;
	}

	static function getEncryptCertId() {
		$cert_path=SDKConfig::getSDKConfig()->encryptCertPath;
		return CertUtil::getEncryptCertId($cert_path);
	}

	/**
	 * 加密数据
	 * @param string $data数据
	 * @param string $cert_path 证书配置路径
	 * @return unknown
	 */
	static function encryptData($data, $cert_path=null) {
		if( $cert_path == null ) {
			$cert_path = SDKConfig::getSDKConfig()->encryptCertPath;
		}
		$public_key = CertUtil::getEncryptKey( $cert_path );
		openssl_public_encrypt ( $data, $crypted, $public_key );
		return base64_encode ( $crypted );
	}

	/**
	 * 解密数据
	 * @param string $data数据
	 * @param string $cert_path 证书配置路径
	 * @return unknown
	 */
	static function decryptData($data, $cert_path=null, $cert_pwd=null) {

		if( $cert_path == null ) {
			$cert_path = SDKConfig::getSDKConfig()->signCertPath;
			$cert_pwd = SDKConfig::getSDKConfig()->signCertPwd;
		}
		
		$data = base64_decode ( $data );
		$private_key = CertUtil::getSignKeyFromPfx ( $cert_path, $cert_pwd);
		openssl_private_decrypt ( $data, $crypted, $private_key );
		return $crypted;
	}


	/**
	 * 处理报文中的文件
	 *
	 * @param unknown_type $params
	 */
	static function deCodeFileContent($params, $fileDirectory) {
		$logger = LogUtil::getLogger();
		if (isset ( $params ['fileContent'] )) {
			$logger->LogInfo ( "---------处理后台报文返回的文件---------" );
			$fileContent = $params ['fileContent'];

			if (empty ( $fileContent )) {
				$logger->LogInfo ( '文件内容为空' );
				return false;
			} else {
				// 文件内容 解压缩
				$content = gzuncompress ( base64_decode ( $fileContent ) );
				$filePath = null;
				if (empty ( $params ['fileName'] )) {
					$logger->LogInfo ( "文件名为空" );
					$filePath = $fileDirectory . $params ['merId'] . '_' . $params ['batchNo'] . '_' . $params ['txnTime'] . '.txt';
				} else {
					$filePath = $fileDirectory . $params ['fileName'];
				}
				$handle = fopen ( $filePath, "w+" );
				if (! is_writable ( $filePath )) {
					$logger->LogInfo ( "文件:" . $filePath . "不可写，请检查！" );
					return false;
				} else {
					file_put_contents ( $filePath, $content );
					$logger->LogInfo ( "文件位置 >:" . $filePath );
				}
				fclose ( $handle );
			}
			return true;
		} else {
			return false;
		}
	}


	static function enCodeFileContent($path){

		$file_content_base64 = '';
		if(!file_exists($path)){
			echo '文件没找到';
			return false;
		}

		$file_content = file_get_contents ( $path );
		//UTF8 去掉文本中的 bom头
		$BOM = chr(239).chr(187).chr(191);
		$file_content = str_replace($BOM,'',$file_content);
		$file_content_deflate = gzcompress ( $file_content );
		$file_content_base64 = base64_encode ( $file_content_deflate );
		return $file_content_base64;
	}

}

