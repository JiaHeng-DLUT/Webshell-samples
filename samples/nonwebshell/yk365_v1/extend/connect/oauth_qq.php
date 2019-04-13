<?php
class oauth_qq {
	private static $_instance;
	private $config = array();
	
	private function __construct($config) {
		$this->oauth_qq($config);
	}
	
	public static function get_instance($config) {
		if (!isset(self::$_instance)) {
			$class = __CLASS__;
			self::$_instance = new $class($config);
		}
		return self::$_instance;
	}
	
	private function oauth_qq($config) {
		$this->config = $config;
		$_SESSION["appid"] = $this->config['appid'];
		$_SESSION["appkey"] = $this->config['appkey'];
		$_SESSION["callback"] = $this->config['callback'];
		$_SESSION["scope"] = "get_user_info";

	}

	public function login() {
	    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection


		$login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=".$_SESSION["appid"]."&redirect_uri=".urlencode($_SESSION["callback"])."&scope=".$_SESSION["scope"]."&state=".$_SESSION['state'];
		header("Location: $login_url");
	}

	public function callback() {
	// print_r($_SESSION);
	// echo $_REQUEST['state'];
	// echo '<br>';
	// echo $_SESSION['state'];
		// if ($_REQUEST['state'] == $_SESSION['state']) { //CSRF protection
		    $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id=".$_SESSION["appid"]."&client_secret=".$_SESSION["appkey"]."&code=".$_REQUEST["code"]."&state=".$_SESSION['state']."&redirect_uri=".urlencode($_SESSION["callback"]);

			$response = get_url_contents($token_url);

			if (strpos($response, "callback") !== false) {
				$lpos = strpos($response, "(");
				$rpos = strrpos($response, ")");
				$response  = substr($response, $lpos + 1, $rpos - $lpos -1);
				return $response;
				// $msg = json_decode($response);

				// if ($msg->error  != '0') {
					// echo "<h3>error:</h3>" . $msg->error;
					// echo "<h3>message:</h3>" . $msg->error_description;
					// exit;
					// return false;
				// }
			}
			
			$params = array();
			parse_str($response, $params);
			
			$_SESSION["access_token"] = $params["access_token"];
		// } else {
		// 	echo("The state does not match. You may be a victim of CSRF.");
		// }
	}
	
	public function get_openid() {
		$graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$_SESSION['access_token'];
		$openstr  = get_url_contents($graph_url);
		if (strpos($openstr, "callback") !== false) {
			$lpos = strpos($openstr, "(");
			$rpos = strrpos($openstr, ")");
			$openstr  = substr($openstr, $lpos + 1, $rpos - $lpos - 1);
		}
		
		$user = json_decode($openstr);
		if (isset($user->error)) {
			echo "<h3>error:</h3>" . $user->error;
			echo "<h3>msg  :</h3>" . $user->error_description;
			exit;
		}
		
		//set openid to session
		$_SESSION["openid"] = $user->openid;
	}

	public function get_user_info() {
		$get_user_info = "https://graph.qq.com/user/get_user_info?access_token=".$_SESSION['access_token']."&oauth_consumer_key=".$_SESSION["appid"]."&openid=".$_SESSION["openid"]. "&format=json";
		$info = get_url_contents($get_user_info);
		$arr = json_decode($info, true);
		
		return $arr;
	}

	public function __clone() {
		trigger_error('Clone is not allow', E_USER_ERROR);
	}
}

function get_url_contents($url) {
       if (!function_exists('curl_init')) {  
            return 'curl 服务器未开启';
        }else{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $url);
            $response =  curl_exec($ch);
            curl_close($ch);
        }

    return $response;
}
?>