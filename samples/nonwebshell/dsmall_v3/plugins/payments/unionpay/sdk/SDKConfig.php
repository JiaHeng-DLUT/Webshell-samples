<?php
namespace com\unionpay\acp\sdk;;
include_once 'log.class.php';
include_once 'common.php';

class SDKConfig {
	
	private static $_config = null;
	public static function getSDKConfig(){
		if (SDKConfig::$_config == null ) {
			SDKConfig::$_config = new SDKConfig();
		}
		return SDKConfig::$_config;
	}
	public static function setSDKConfig($name,$value){
		if (SDKConfig::$_config == null ) {
			SDKConfig::$_config = new SDKConfig();
		}
                SDKConfig::$_config->$name=$value;
	}
	private $frontTransUrl;
	private $backTransUrl;
	private $singleQueryUrl;
	private $batchTransUrl;
	private $fileTransUrl;
	private $appTransUrl;
	private $cardTransUrl;
	private $jfFrontTransUrl;
	private $jfBackTransUrl;
	private $jfSingleQueryUrl;
	private $jfCardTransUrl;
	private $jfAppTransUrl;
	private $qrcBackTransUrl;
	private $qrcB2cIssBackTransUrl;
	private $qrcB2cMerBackTransUrl;
	
	private $signMethod;
	private $version;
	private $ifValidateCNName;
	private $ifValidateRemoteCert;
	
	private $signCertPath;
	private $signCertPwd;
	private $validateCertDir;
	private $encryptCertPath;
	private $rootCertPath;
	private $middleCertPath;
	private $frontUrl;
	private $backUrl;
	private $secureKey;
	private $logFilePath;
	private $logLevel;

	function __construct(){

		//如果想把acp_sdk.ini挪到其他路径的话，请修改下面这行指定绝对路径。
		$configFilePath = dirname(__FILE__) . "/acp_sdk.ini";
		
		if(!file_exists($configFilePath)){
			$logger = LogUtil::getLogger();
			$logger->LogError("配置文件加载失败，文件路径：[" . $configFilePath . "].请检查启动php的用户是否有读权限。");
			return;
		}
		$ini_array = parse_ini_file($configFilePath, true);
		$sdk_array = $ini_array["acpsdk"];
		$this->frontTransUrl = array_key_exists("acpsdk.frontTransUrl", $sdk_array)?$sdk_array["acpsdk.frontTransUrl"] : null;
		$this->backTransUrl = array_key_exists("acpsdk.backTransUrl", $sdk_array)?$sdk_array["acpsdk.backTransUrl"] : null;
		$this->singleQueryUrl = array_key_exists("acpsdk.singleQueryUrl", $sdk_array)?$sdk_array["acpsdk.singleQueryUrl"] : null;
		$this->batchTransUrl = array_key_exists("acpsdk.batchTransUrl", $sdk_array)?$sdk_array["acpsdk.batchTransUrl"] : null;
		$this->fileTransUrl = array_key_exists("acpsdk.fileTransUrl", $sdk_array)?$sdk_array["acpsdk.fileTransUrl"] : null;
		$this->appTransUrl = array_key_exists("acpsdk.appTransUrl", $sdk_array)?$sdk_array["acpsdk.appTransUrl"] : null;
		$this->cardTransUrl = array_key_exists("acpsdk.cardTransUrl", $sdk_array)?$sdk_array["acpsdk.cardTransUrl"] : null;
		$this->jfFrontTransUrl = array_key_exists("acpsdk.jfFrontTransUrl", $sdk_array)?$sdk_array["acpsdk.jfFrontTransUrl"] : null;
		$this->jfBackTransUrl = array_key_exists("acpsdk.jfBackTransUrl", $sdk_array)?$sdk_array["acpsdk.jfBackTransUrl"] : null;
		$this->jfSingleQueryUrl = array_key_exists("acpsdk.jfSingleQueryUrl", $sdk_array)?$sdk_array["acpsdk.jfSingleQueryUrl"] : null;
		$this->jfCardTransUrl = array_key_exists("acpsdk.jfCardTransUrl", $sdk_array)?$sdk_array["acpsdk.jfCardTransUrl"] : null;
		$this->jfAppTransUrl = array_key_exists("acpsdk.jfAppTransUrl", $sdk_array)?$sdk_array["acpsdk.jfAppTransUrl"] : null;
		$this->qrcBackTransUrl = array_key_exists("acpsdk.qrcBackTransUrl", $sdk_array)?$sdk_array["acpsdk.qrcBackTransUrl"] : null;
		$this->qrcB2cIssBackTransUrl = array_key_exists("acpsdk.qrcB2cIssBackTransUrl", $sdk_array)?$sdk_array["acpsdk.qrcB2cIssBackTransUrl"] : null;
		$this->qrcB2cMerBackTransUrl = array_key_exists("acpsdk.qrcB2cMerBackTransUrl", $sdk_array)?$sdk_array["acpsdk.qrcB2cMerBackTransUrl"] : null;

		$this->signMethod = array_key_exists("acpsdk.signMethod", $sdk_array)?$sdk_array["acpsdk.signMethod"] : null;
		$this->version = array_key_exists("acpsdk.version", $sdk_array)?$sdk_array["acpsdk.version"] : null;
		$this->ifValidateCNName = array_key_exists("acpsdk.ifValidateCNName", $sdk_array)?$sdk_array["acpsdk.ifValidateCNName"] : "true";
		$this->ifValidateRemoteCert = array_key_exists("acpsdk.ifValidateRemoteCert", $sdk_array)?$sdk_array["acpsdk.ifValidateRemoteCert"] : "false";
					
		$this->signCertPath = array_key_exists("acpsdk.signCert.path", $sdk_array)?$sdk_array["acpsdk.signCert.path"]: null;
		$this->signCertPwd = array_key_exists("acpsdk.signCert.pwd", $sdk_array)?$sdk_array["acpsdk.signCert.pwd"]: null;
		
		$this->validateCertDir = array_key_exists("acpsdk.validateCert.dir", $sdk_array)? $sdk_array["acpsdk.validateCert.dir"]: null;
		$this->encryptCertPath = array_key_exists("acpsdk.encryptCert.path", $sdk_array)? $sdk_array["acpsdk.encryptCert.path"]: null;
		$this->rootCertPath = array_key_exists("acpsdk.rootCert.path", $sdk_array)? $sdk_array["acpsdk.rootCert.path"]: null;
		$this->middleCertPath =  array_key_exists("acpsdk.middleCert.path", $sdk_array)?$sdk_array["acpsdk.middleCert.path"]: null;
		
		$this->frontUrl =  array_key_exists("acpsdk.frontUrl", $sdk_array)?$sdk_array["acpsdk.frontUrl"]: null;
		$this->backUrl =  array_key_exists("acpsdk.backUrl", $sdk_array)?$sdk_array["acpsdk.backUrl"]: null;
		
		$this->secureKey =  array_key_exists("acpsdk.secureKey", $sdk_array)?$sdk_array["acpsdk.secureKey"]: null;
		$this->logFilePath =  array_key_exists("acpsdk.log.file.path", $sdk_array)?$sdk_array["acpsdk.log.file.path"]: null;
		$this->logLevel =  array_key_exists("acpsdk.log.level", $sdk_array)?$sdk_array["acpsdk.log.level"]: null;
		
	}

	public function __get($property_name)
	{
		if(isset($this->$property_name))
		{
			return($this->$property_name);
		}
		else
		{
			return(NULL);
		}
	}

}


