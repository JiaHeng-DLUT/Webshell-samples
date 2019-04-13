<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['GET']['C'] == 'login') {
	//写入忘记密码按钮
	$_G['SET']['EMBED_FOOT'] .= template('systememail:load', TRUE);
}

if ($_G['SET']['APP_SYSTEMEMAIL_PHPMAILER']) {
	/*
	 * 引用PHPMailer
	 */
	require $_G['SYSTEM']['PATH'] . 'app/systememail/PHPMailer/PHPMailerAutoload.php';

	function sendmail($mailto, $mailtitle, $mailcontent, $timeout = false) {
		if (!filter_var($mailto, FILTER_VALIDATE_EMAIL)) {
			return FALSE;
		}
		global $_G;
		//部分应用的补救方案，未开启邮件功能，但会发信
		if (!$_G['SET']['APP_SYSTEMEMAIL_LOAD']) {
			return FALSE;
		}
		//开启了超时阀值
		if (Cnum($_G['SET']['APP_SYSTEMEMAIL_TIMEOUTSECONDS'], FALSE, TRUE, 1)) {
			if (!$timeout) {
				$urls = 'http' . ($_SERVER['HTTPS'] == 'on' ? 's' : '') . "://{$_G['SYSTEM']['DOMAIN']}" . ($_G['SYSTEM']['PORT'] ? ':' . $_G['SYSTEM']['PORT'] : '') . "{$_SERVER['PHP_SELF']}";
				$urls = explode('/', $urls);
				$url = '';
				foreach ($urls as $k => $v) {
					if ($k != count($urls) - 1) {
						$url .= '/' . $v;
					}
				}
				$url = substr($url, 1) . '/index.php?c=app&a=systememail:_sendmail';
				$url .= '&safecode=' . md5($_G['SET']['KEY']);
				$json = GetPostData($url, 'mailto=' . urlencode($mailto) . '&mailtitle=' . urlencode($mailtitle) . '&mailcontent=' . urlencode($mailcontent), $_G['SET']['APP_SYSTEMEMAIL_TIMEOUTSECONDS']);
				$json = json_decode($json, TRUE);
				if ($json['state'] == 'ok') {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		}
		//$array = explode(',', $_G['CUSTOM']['PUYUETIAN']['MAIL_DATA']);
		$smtpserver = $_G['SET']['APP_SYSTEMEMAIL_SMTP'];
		//SMTP服务器
		$smtpserverport = 25;
		//SMTP服务器端口
		$smtpusermail = $_G['SET']['APP_SYSTEMEMAIL_USER'];
		//SMTP服务器的用户邮箱
		$smtpemailto = $mailto;
		//发送给谁
		$smtpuser = $_G['SET']['APP_SYSTEMEMAIL_USER'];
		//SMTP服务器的用户帐号
		$smtppass = $_G['SET']['APP_SYSTEMEMAIL_PASS'];
		//SMTP服务器的用户密码
		$mailsubject = $mailtitle;
		//邮件主题
		$mailbody = $mailcontent;

		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail -> isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail -> SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail -> Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail -> Host = $smtpserver;
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail -> Port = $smtpserverport;
		//Whether to use SMTP authentication
		$mail -> SMTPAuth = true;
		//Username to use for SMTP authentication
		$mail -> Username = $smtpusermail;
		//Password to use for SMTP authentication
		$mail -> Password = $smtppass;
		//Set who the message is to be sent from
		$mail -> setFrom($smtpusermail, '');
		//Set an alternative reply-to address
		$mail -> addReplyTo($smtpusermail, '');
		//Set who the message is to be sent to
		$mail -> addAddress($smtpemailto, '');
		//Set the subject line
		$mail -> Subject = $mailtitle;
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail -> msgHTML($mailbody);
		//Replace the plain text body with one created manually
		//$mail->AltBody = 'This is a plain-text message body中文';
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body

		//send the message, check for errors
		if (!$mail -> send()) {
			//echo "Mailer Error: " . $mail -> ErrorInfo;
		}
	}

} else {
	function sendmail($mailto, $mailtitle, $mailcontent, $timeout = false) {
		if (!filter_var($mailto, FILTER_VALIDATE_EMAIL)) {
			return FALSE;
		}
		global $_G;
		if (!$_G['SET']['APP_SYSTEMEMAIL_LOAD']) {
			return FALSE;
		}
		//开启了超时阀值
		if (Cnum($_G['SET']['APP_SYSTEMEMAIL_TIMEOUTSECONDS'], FALSE, TRUE, 1)) {
			if (!$timeout) {
				$urls = 'http' . ($_SERVER['HTTPS'] == 'on' ? 's' : '') . "://{$_G['SYSTEM']['DOMAIN']}" . ($_G['SYSTEM']['PORT'] ? ':' . $_G['SYSTEM']['PORT'] : '') . "{$_SERVER['PHP_SELF']}";
				$urls = explode('/', $urls);
				$url = '';
				foreach ($urls as $k => $v) {
					if ($k != count($urls) - 1) {
						$url .= '/' . $v;
					}
				}
				$url = substr($url, 1) . '/index.php?c=app&a=systememail:_sendmail';
				$url .= '&safecode=' . md5($_G['SET']['KEY']);
				$json = GetPostData($url, 'mailto=' . urlencode($mailto) . '&mailtitle=' . urlencode($mailtitle) . '&mailcontent=' . urlencode($mailcontent), $_G['SET']['APP_SYSTEMEMAIL_TIMEOUTSECONDS']);
				$json = json_decode($json, TRUE);
				if ($json['state'] == 'ok') {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		}
		//$array = explode(',', $_G['CUSTOM']['PUYUETIAN']['MAIL_DATA']);
		$smtpserver = $_G['SET']['APP_SYSTEMEMAIL_SMTP'];
		//SMTP服务器
		$smtpserverport = 25;
		//SMTP服务器端口
		$smtpusermail = $_G['SET']['APP_SYSTEMEMAIL_USER'];
		//SMTP服务器的用户邮箱
		$smtpemailto = $mailto;
		//发送给谁
		$smtpuser = $_G['SET']['APP_SYSTEMEMAIL_USER'];
		//SMTP服务器的用户帐号
		$smtppass = $_G['SET']['APP_SYSTEMEMAIL_PASS'];
		//SMTP服务器的用户密码
		$mailsubject = $mailtitle;
		//邮件主题
		$mailbody = $mailcontent;
		//邮件内容
		$mailtype = Cstr($_G['SET']['APP_SYSTEMEMAIL_FORMAT'], 'HTML', 'HTMLX', 3, 4);
		//邮件格式（HTML/TXT）,TXT为文本邮件
		//##########################################
		$smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
		//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		$smtp -> debug = false;
		//是否显示发送的调试信息
		$smtp -> sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
	}

	/*
	 * 邮件发送类
	 */
	class smtp {
		/* Public Variables */
		public $smtp_port;
		public $time_out;
		public $host_name;
		public $log_file;
		public $relay_host;
		public $debug;
		public $auth;
		public $user;
		public $pass;

		/* Private Variables */
		private $sock;

		/* Constractor */
		function smtp($relay_host = "", $smtp_port = 25, $auth = false, $user, $pass) {
			$this -> debug = FALSE;
			$this -> smtp_port = $smtp_port;
			$this -> relay_host = $relay_host;
			$this -> time_out = 30;
			//is used in fsockopen()
			#
			$this -> auth = $auth;
			//auth
			$this -> user = $user;
			$this -> pass = $pass;
			#
			$this -> host_name = "localhost";
			//is used in HELO command
			$this -> log_file = "";

			$this -> sock = FALSE;
		}

		/* Main Function */
		function sendmail($to, $from, $subject = "", $body = "", $mailtype, $cc = "", $bcc = "", $additional_headers = "") {
			$mail_from = $this -> get_address($this -> strip_comment($from));
			$body = preg_replace("/(^|(\r\n))(\\.)/", "\\1.\\3", $body);
			$header = '';
			$header .= "MIME-Version:1.0\r\n";
			if ($mailtype == "HTML") {
				$header .= "Content-Type:text/html;charset=utf-8\r\n";
			}
			$header .= "To: " . $to . "\r\n";
			if ($cc != "") {
				$header .= "Cc: " . $cc . "\r\n";
			}
			$header .= "From: $from<" . $from . ">\r\n";
			$header .= "Subject: " . $subject . "\r\n";
			$header .= $additional_headers;
			$header .= "Date: " . date("r") . "\r\n";
			$header .= "X-Mailer:By Redhat (PHP/" . phpversion() . ")\r\n";
			list($msec, $sec) = explode(" ", microtime());
			$header .= "Message-ID: <" . date("YmdHis", $sec) . "." . ($msec * 1000000) . "." . $mail_from . ">\r\n";
			$TO = explode(",", $this -> strip_comment($to));

			if ($cc != "") {
				$TO = array_merge($TO, explode(",", $this -> strip_comment($cc)));
			}

			if ($bcc != "") {
				$TO = array_merge($TO, explode(",", $this -> strip_comment($bcc)));
			}

			$sent = TRUE;
			foreach ($TO as $rcpt_to) {
				$rcpt_to = $this -> get_address($rcpt_to);
				if (!$this -> smtp_sockopen($rcpt_to)) {
					$this -> log_write("Error: Cannot send email to " . $rcpt_to . "\n");
					$sent = FALSE;
					continue;
				}
				if ($this -> smtp_send($this -> host_name, $mail_from, $rcpt_to, $header, $body)) {
					$this -> log_write("E-mail has been sent to <" . $rcpt_to . ">\n");
				} else {
					$this -> log_write("Error: Cannot send email to <" . $rcpt_to . ">\n");
					$sent = FALSE;
				}
				fclose($this -> sock);
				$this -> log_write("Disconnected from remote host\n");
			}
			//echo "<br>";
			//echo $header;
			return $sent;
		}

		/* Private Functions */

		function smtp_send($helo, $from, $to, $header, $body = "") {
			if (!$this -> smtp_putcmd("HELO", $helo)) {
				return $this -> smtp_error("sending HELO command");
			}
			#auth
			if ($this -> auth) {
				if (!$this -> smtp_putcmd("AUTH LOGIN", base64_encode($this -> user))) {
					return $this -> smtp_error("sending HELO command");
				}
				if (!$this -> smtp_putcmd("", base64_encode($this -> pass))) {
					return $this -> smtp_error("sending HELO command");
				}
			}
			#
			if (!$this -> smtp_putcmd("MAIL", "FROM:<" . $from . ">")) {
				return $this -> smtp_error("sending MAIL FROM command");
			}

			if (!$this -> smtp_putcmd("RCPT", "TO:<" . $to . ">")) {
				return $this -> smtp_error("sending RCPT TO command");
			}

			if (!$this -> smtp_putcmd("DATA")) {
				return $this -> smtp_error("sending DATA command");
			}

			if (!$this -> smtp_message($header, $body)) {
				return $this -> smtp_error("sending message");
			}

			if (!$this -> smtp_eom()) {
				return $this -> smtp_error("sending <CR><LF>.<CR><LF> [EOM]");
			}

			if (!$this -> smtp_putcmd("QUIT")) {
				return $this -> smtp_error("sending QUIT command");
			}

			return TRUE;
		}

		function smtp_sockopen($address) {
			if ($this -> relay_host == "") {
				return $this -> smtp_sockopen_mx($address);
			} else {
				return $this -> smtp_sockopen_relay();
			}
		}

		function smtp_sockopen_relay() {
			$this -> log_write("Trying to " . $this -> relay_host . ":" . $this -> smtp_port . "\n");
			$this -> sock = fsockopen($this -> relay_host, $this -> smtp_port, $errno, $errstr, $this -> time_out);
			if (!($this -> sock && $this -> smtp_ok())) {
				$this -> log_write("Error: Cannot connenct to relay host " . $this -> relay_host . "\n");
				$this -> log_write("Error: " . $errstr . " (" . $errno . ")\n");
				return FALSE;
			}
			$this -> log_write("Connected to relay host " . $this -> relay_host . "\n");
			return TRUE; ;
		}

		function smtp_sockopen_mx($address) {
			$domain = preg_replace("/^.+@([^@]+)$/", "\\1", $address);
			//if (!getmxrr($domain, $MXHOSTS)) {
			//	$this -> log_write("Error: Cannot resolve MX \"" . $domain . "\"\n");
			//	return FALSE;
			//}
			foreach ($MXHOSTS as $host) {
				$this -> log_write("Trying to " . $host . ":" . $this -> smtp_port . "\n");
				$this -> sock = fsockopen($host, $this -> smtp_port, $errno, $errstr, $this -> time_out);
				if (!($this -> sock && $this -> smtp_ok())) {
					$this -> log_write("Warning: Cannot connect to mx host " . $host . "\n");
					$this -> log_write("Error: " . $errstr . " (" . $errno . ")\n");
					continue;
				}
				$this -> log_write("Connected to mx host " . $host . "\n");
				return TRUE;
			}
			$this -> log_write("Error: Cannot connect to any mx hosts (" . implode(", ", $MXHOSTS) . ")\n");
			return FALSE;
		}

		function smtp_message($header, $body) {
			fputs($this -> sock, $header . "\r\n" . $body);
			$this -> smtp_debug("> " . str_replace("\r\n", "\n" . "> ", $header . "\n> " . $body . "\n> "));

			return TRUE;
		}

		function smtp_eom() {
			fputs($this -> sock, "\r\n.\r\n");
			$this -> smtp_debug(". [EOM]\n");

			return $this -> smtp_ok();
		}

		function smtp_ok() {
			$response = str_replace("\r\n", "", fgets($this -> sock, 512));
			$this -> smtp_debug($response . "\n");

			if (!preg_match("/^[23]/", $response)) {
				fputs($this -> sock, "QUIT\r\n");
				fgets($this -> sock, 512);
				$this -> log_write("Error: Remote host returned \"" . $response . "\"\n");
				return FALSE;
			}
			return TRUE;
		}

		function smtp_putcmd($cmd, $arg = "") {
			if ($arg != "") {
				if ($cmd == "")
					$cmd = $arg;
				else
					$cmd = $cmd . " " . $arg;
			}

			fputs($this -> sock, $cmd . "\r\n");
			$this -> smtp_debug("> " . $cmd . "\n");

			return $this -> smtp_ok();
		}

		function smtp_error($string) {
			$this -> log_write("Error: Error occurred while " . $string . ".\n");
			return FALSE;
		}

		function log_write($message) {
			$this -> smtp_debug($message);

			if ($this -> log_file == "") {
				return TRUE;
			}

			$message = date("M d H:i:s ") . get_current_user() . "[" . getmypid() . "]: " . $message;
			if (!file_exists($this -> log_file) || !($fp = fopen($this -> log_file, "a"))) {
				$this -> smtp_debug("Warning: Cannot open log file \"" . $this -> log_file . "\"\n");
				return FALSE;
			}
			flock($fp, LOCK_EX);
			fputs($fp, $message);
			fclose($fp);

			return TRUE;
		}

		function strip_comment($address) {
			$comment = "/\\([^()]*\\)/";
			while (preg_match($comment, $address)) {
				$address = preg_replace($comment, "", $address);
			}

			return $address;
		}

		function get_address($address) {
			$address = preg_replace("/([ \t\r\n])+/", "", $address);
			$address = preg_replace("/^.*<(.+)>.*$/", "\\1", $address);

			return $address;
		}

		function smtp_debug($message) {
			if ($this -> debug) {
				echo $message . "<br>";
			}
		}

		function get_attach_type($image_tag) {//

			$filedata = array();

			$img_file_con = fopen($image_tag, "r");
			unset($image_data);
			while ($tem_buffer = AddSlashes(fread($img_file_con, filesize($image_tag))))
				$image_data .= $tem_buffer;
			fclose($img_file_con);

			$filedata['context'] = $image_data;
			$filedata['filename'] = basename($image_tag);
			$extension = substr($image_tag, strrpos($image_tag, "."), strlen($image_tag) - strrpos($image_tag, "."));
			switch($extension) {
				case ".gif" :
					$filedata['type'] = "image/gif";
					break;
				case ".gz" :
					$filedata['type'] = "application/x-gzip";
					break;
				case ".htm" :
					$filedata['type'] = "text/html";
					break;
				case ".html" :
					$filedata['type'] = "text/html";
					break;
				case ".jpg" :
					$filedata['type'] = "image/jpeg";
					break;
				case ".tar" :
					$filedata['type'] = "application/x-tar";
					break;
				case ".txt" :
					$filedata['type'] = "text/plain";
					break;
				case ".zip" :
					$filedata['type'] = "application/zip";
					break;
				default :
					$filedata['type'] = "application/octet-stream";
					break;
			}
			return $filedata;
		}

	}

}

//新用户邮箱验证
if ($_G['SET']['APP_SYSTEMEMAIL_EMAILVERIFY'] && ($_G['GET']['C'] != 'app' && $_GET['a'] != 'systememail:emailverify')) {
	if (!$_G['USER']['ID'] && $_G['GET']['C'] == 'savereg') {
		//添加验证码
		$regarray['data'] = JsonData($regarray['data'], 'systememail_emailverify', CreateRandomString(7));
	}
	$emailverify = JsonData($_G['USER']['DATA'], 'systememail_emailverify');
	if ($_G['USER']['ID'] && $emailverify) {
		$sendtime = Cnum(JsonData($_G['USER']['DATA'], 'systememail_emailverify_sendtime'), 0, TRUE, 0);
		if (time() - $sendtime > 60) {
			sendmail($_G['USER']['EMAIL'], '邮箱验证码 - ' . $_G['SET']['LOGOTEXT'], '您的验证码为：<span style="color:#f60;font-weight:bold">' . $emailverify . '</span>');
			$_G['TABLE']['USER'] -> newData(array('id' => $_G['USER']['ID'], 'data' => JsonData($_G['USER']['DATA'], 'systememail_emailverify_sendtime', time())));
		}
		$_G['TEMP']['SVF'] = md5($_G['SET']['KEY'] . $emailverify);
		$_G['HTMLCODE']['MAIN'] .= template('systememail:emailverify', TRUE);
		template($_G['TEMPLATE']['MAIN']);
		exit();
	}
}
