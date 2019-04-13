<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/

 $bscntarr = explode('==#==',$arr_smtp); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }

 

//echo $smtp_active;



   if($smtp_active=='y'){
            

                require_once INCLUDE_ROOT.'vendor/phpmailer/class.phpmailer.php';


   $content = decode(@htmlentitdm($_POST['content']));
   $title = date("Y-m-d H:i:s").'有来自网站的留言  (DM系统技术支持)';
   $mysite ='我的网站';



//echo $content;



//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
$mail->CharSet = 'UTF-8'; //UTF-8
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = $smtp_server; // "smtp.163.com";

//Set the SMTP port number - likely to be 25, 465 or 587   一般是25，但其他邮箱系统不一定。
$mail->Port = 25;

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication  邮箱账号
$mail->Username = $smtp_email;

//Password to use for SMTP authentication  邮箱密码
$mail->Password = $smtp_ps;

//Set who the message is to be sent from
$mail->setFrom($smtp_email, $mysite);
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress($smtp_email, $mysite);

//Set the subject line
$mail->Subject = $title;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($content);
//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "发送失败: " . $mail->ErrorInfo;
} else {
    echo "邮件发送成功!";
}








   }//end $smtp_active=='y'



	?>