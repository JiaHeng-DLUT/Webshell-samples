<?php
// +----------------------------------------------------------------------
// | 奇乐自媒体管理系统 商业版 2019
// +----------------------------------------------------------------------
// | 官方网址：http://www.qilewl.com   
// +----------------------------------------------------------------------
// | 产品网址：http://www.qilecms.com
// +----------------------------------------------------------------------
// | Author:合肥奇乐网络科技有限公司 
// +----------------------------------------------------------------------
// | 版权说明：本产品为商业版，请授权后使用,否则将追究法律责任 
// +----------------------------------------------------------------------
use \think\Db;
use \think\facade\Url;
use think\facade\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// 引入类库
use think\Auth;
error_reporting(0);
// 应用公共文件

//返回错误的json
function error_json($msg,$data='',$code=-1){
   $param = array(
     'code' => $code, //默认 -1  有异常 ，大于0 有错误
     'msg'  => $msg,
     'data' => $data,
    );
   return json($param);

}
//返回成功的json
function success_json($msg,$data='',$code=0){
   $param = array(
     'code' => $code, //默认 0 成功
     'msg'  => $msg,
     'data' => $data,
    );
   return json($param);

}

//账号登陆加密码 
function password_key($username,$password,$passsalt){
  return md5(md5($password.$passsalt).$username);
}

//支付加密码 更复杂
function payword_key($username,$payword,$paysalt){
  return md5(md5(md5($payword).$passsalt).$username);
}
//创建随机用户名
function get_rand_username()
{

  //最大15位
  $username = 'u'.rand(000000001,999999999); //最大9位，否则无效
  $res = Db::name('user')->where(['username'=>$username])->find();
  if(!empty($res)){
     get_rand_username();
  }else{
    return $username;
  }
}
//获得昵称
function get_nickname($uid)
{
  $res = Db::name('user')->where(['uid'=>$uid])->find();
  return $res['nickname'];
}
//数据库字段检查
function checkFields($data = array(), $fields = array())
    {  
        foreach ($data as $k => $val) {
            if (!in_array($k,$fields)) {
                
                unset($data[$k]);
            }
        }
        return $data;
    }
//时间转换  
function format_date($time){
    $t=time()-$time;
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.'前';
        }
    }
}
function format_time($dateformat, $date='',$format=1) {
  
  $time = time() - $date;
   $result = '';
   if($format) {
     if($time > 604800) {
       $result = @date($dateformat,$date);
     }elseif ($time > 86400) {
       $result = intval($time/86400).'天前';

     }elseif ($time > 3600) {
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
function xml_to_array($xml)
{
//将XML转为array
$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
return $array_data;
}

//将对象转换成数组
function obj_to_array($obj){
 return json_decode(json_encode($obj),true);
}

/**
 * 强制下载
 * @author 
 *
 * @param string $filename 文件名称
 * @param string $content //文件内容
 */
function force_download($filename, $content)
{
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Transfer-Encoding: binary");
    header("Content-Disposition: attachment; filename=$filename");
    echo $content;
    exit ();
}
//获取文件内容
function get_file($filedir){
  if ($open_file = @fopen($filedir, "rb")){      
    $filecontent=fread($open_file,filesize($filedir));      
    fclose($open_file);
    return $filecontent;
  }else{
     return false;
  }
}

function write_file($wfile,$cfile,$wr='w'){

    if($openwrite =  @fopen($wfile, $wr)){
     fwrite($openwrite,$cfile);
     fclose($openwrite);
     return true;
    }else{
     return false;
    }
}
 //删除文件
function del_file($filepath){
  @unlink($filepath);
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


// //是否超级管理员
// function IsAdmin($uid = 0){
//   if($uid > 0){
//     if(intval($uid)==1){
//       return true;
//     }
//   }
//   return false;
// }


//生成随机码
function random_text($count,$lowercase='0'){

  srand((double)microtime()*1000000);
  $doublenum=mt_rand(10000,1000000);
  srand((double)microtime()*$doublenum); 
 
  if($lowercase==1){
    $numrand=array_flip(array_merge(range(1,9),range('A','N'),range('P','Z'),range('a','n'),range('p','z')));
  }elseif($lowercase==2){
    $numrand=array_flip(range(1,9));
  }else{
    $numrand=array_flip(array_merge(range(1,9),range('A','N'),range('P','Z'))); 
  }
   
  $textkey='';
  for($i=0;$i<$count;$i++){
      $textkey .= array_rand($numrand);
  } 
  return $textkey; 
}


/**
 * 生成流水号
 *
 * @return string
 */

function get_serial_no()
{
    $no_base = date("ymdhis", time());
    $serial_no = $no_base . rand(111, 999);
    return $serial_no;
}



/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}


/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
 * 删除图片文件
 *
 * @param unknown $img_path            
 */
function removeImageFile($img_path)
{
    // 检查图片文件是否存在
    if (file_exists($img_path)) {
        return unlink($img_path);
    } else {
        return false;
    }
}

//获取文件大小并格式化
function formatSize($size) {
    $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    if ($size == 0) { 
	   	return('0'); 
	} else {
      return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); 
	}
}

function get_settings($isCache=''){
 // $isCache  true 开启缓存控制   false 或者为空则不受缓存控制 
     if($isCache ==true){
        if(cache('settings')){
          return  $settings = cache('settings');
        }
     }

   
	 $lists =  Db::name('settings')->select();
	 $data = [];
					     foreach($lists as $k=>$v){
					           if(!empty($v['value'])){
					              $value = unserialize($v['value']);
					           }else{
					              $value ='';
					           }
					             $data[$v['groupname']] = $value;

					     }
			  cache('settings',config($data)); //合并配置
	 return   $settings = cache('settings');

   
}

function send_email($to_email,$subject = '',$body = '',$send_username ='系统邮件',$debug=0)
{
                            //  $smtp_host     //smtp服务器地址
                           //  $smtp_port        //端口
                           //  $smtp_user        //邮件服务器登录账号
                           //  $smtp_pass        //邮件服务器登陆密码
                           //  $to_email 表示收件人地址 
                            //$subject 表示邮件标题 
                            //$body表示邮件正文
                            //error_reporting(E_ALL);
       date_default_timezone_set('Asia/Shanghai'); //设定时区东八区
       // error_reporting(0);
       $settings = get_settings();
       $mail = new PHPMailer(true);                               // Passing `true` enables exceptions
        try {
            //服务器设置
            $mail->SMTPDebug = $debug;                                // 启用SMTP调试功能
            $mail->isSMTP();                                          // 设定使用SMTP服务
            // $mail->CharSet ="UTF-8";                               //设定邮件编码，默认UTF-8，如果发中文此项必须设置，否则乱码
            $mail->Host = $settings['email']['smtp_host'];            // SMTP 服务器 如：smtp.qq.com smtp.163.com
            $mail->SMTPAuth = true;                                   // 启用 SMTP 验证功能
            $mail->Username = $settings['email']['smtp_user'];        // SMTP服务器用户名，一般为邮箱地址
            $mail->Password = $settings['email']['smtp_pass'];        // SMTP服务器密码
            $mail->SMTPSecure = 'tls';                                // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $settings['email']['smtp_port'];            // TCP port to connect to

            //Recipients
            $mail->setFrom($mail->Username,$send_username);              //寄件人邮箱和用户名
            $mail->addAddress($to_email,'');                          //收件人邮箱
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //附件部分
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // 添加附件
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                
            $mail->Subject =  $subject;    //收件标题
            $mail->Body    = $body;        //收件内容
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

             if(!$mail->send()) {
                                    // return '邮件发送失败！' . $mail->ErrorInfo;
                                    return $mail->ErrorInfo;
             } else {
                                    // return "恭喜，邮件发送成功！";
                                    return true;
             }
        } catch (Exception $e) {
           // return '邮件发送失败！' . $mail->ErrorInfo;
           return $mail->ErrorInfo;
          
        }
}

//发邮件
function send_email2($to_email,$subject = '',$body = '',$debug='0'){
  
                           $settings = get_settings();

                           //  $smtp_host     //smtp服务器地址
                           //  $smtp_port        //端口
                           //  $smtp_user        //邮件服务器登录账号
                           //  $smtp_pass        //邮件服务器登陆密码
                           //  $to_email 表示收件人地址 
                            //$subject 表示邮件标题 
                            //$body表示邮件正文
                            //error_reporting(E_ALL);
                           require_once EXTEND_PATH.'phpmailer/PHPMailerAutoload.php';
                            // date_default_timezone_set('Asia/Shanghai'); //设定时区东八区
                            $mail             = new PHPMailer(); //new一个PHPMailer对象出来
                            $mail->CharSet ="ISO-8859-1";   //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
                            $mail->IsSMTP(); // 设定使用SMTP服务
                            $mail->SMTPDebug  = $debug;                     // 启用SMTP调试功能
                            // 1 = errors and messages
                            // 2 = messages only
                            $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
                            //$mail->SMTPSecure = "ssl";                 // 安全协议，可以注释掉

                            $mail->Host       = $settings['email']['smtp_host'];      // SMTP 服务器 如：smtp.qq.com smtp.163.com
                            $mail->Port       = $settings['email']['smtp_port'];                   // SMTP服务器的端口号  默认：25
                            $mail->Username   = $settings['email']['smtp_user'];  // SMTP服务器用户名，一般为邮箱地址
                            $mail->Password   = $settings['email']['smtp_pass'];           // SMTP服务器密码
                            $mail->SetFrom($mail->Username, '系统邮件');   //寄件人邮箱和用户名
                            //$mail->AddReplyTo('xxx@xxx.xxx','who');
                            $mail->Subject    = $subject;
                            $mail->AltBody    = 'To view the message, please use an HTML compatible email viewer!'; // optional, comment out and test
                            $mail->MsgHTML($body);
                            $address = $to_email; //收件人邮箱
                            $mail->AddAddress($address, ''); //收件人地址
                            //$mail->AddAttachment("images/phpmailer.gif");      // attachment
                            //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
                            if(!$mail->Send()) {
                                // return '邮件发送失败！' . $mail->ErrorInfo;
                                return $mail->ErrorInfo;
                            } else {
                                // return "恭喜，邮件发送成功！";
                                return 'success';
                            }
}


/**
 * [send_sms 发送短信]
 * @param  [string] $mobile   [手机号]
 * @param  [string] $use_name [调用的标签名]
 * @param  array    $Params   [短信参数]
 * @param  [string] $type     [短信平台]
 * @return [string]           [发送状态]
 */
function send_sms($mobile,$use_name,$params=array(),$type="aliyun"){
  $res =  DB::name('sms')->field('tpl_code')->where("use_name = '$use_name'")->find();
  if(empty($res['tpl_code'])){
     return  '模版CODE不存在！';
   }
   if($type == 'aliyun'){
    // 默认使用阿里云短信，后期可以扩展更多短信接口
      $result =  send_aliyun_sms($mobile,$res['tpl_code'],$params);

   }else{
// 其他短信平台

   }

  if($result =='success'){

// 添加短信记录
     return 'success';
   }else{
     return $result; 
   }
}

/**
 * [send_aliyun_sms 阿里云短信,可以单独使用，但是不建议直接使用，请使用 send_sms 函数]
 * @param  [int] $mobile [手机号]
 * @param  [string] $TemplateCode   [模板代码]
 * @param  array  $Params [短信参数]
 * @return [string]         [description]
 */
function send_aliyun_sms($mobile,$TemplateCode,$Params=array()){
    // 格式 $Params=array('sendcode'=>'123456');
         require_once EXTEND_PATH."aliyunsms/SignatureHelper.php"; 
         $settings = get_settings();
         $params = array ();
        if($settings['sms']['aliyun_status'] != 1){
          return '阿里云短信接口未开启';
        }
        // *** 需用户填写部分 ***
        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = $settings['sms']['AccessKeyId'];
        // "LTAIKmcWRZQIRBDf";
        $accessKeySecret = $settings['sms']['AccessKeySecret'];
        // "QuaF4u7cs0kgw5NlPIp4TvPzYrkuaB";

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $mobile;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] =  $settings['sms']['SignName'];

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $TemplateCode;

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = $Params;

        // fixme 可选: 设置发送短信流水号
        $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"]);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new Aliyun\DySDKLite\SignatureHelper();
        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );
        $res_arr = json_decode(json_encode($content),true);
        if($res_arr['Code'] == 'OK'){
           return 'success';
        }else{
           return '短信发送接口错误码: '.$res_arr['Code'].',错误消息：'.$res_arr['Message']; 
        }
}

/**
 * 查询快递
 * @param $postcom  快递公司编码
 * @param $getNu  快递单号
 * @return array  物流跟踪信息数组
 */
function query_express($postcom , $getNu) {
/*    $url = "http://wap.kuaidi100.com/wap_result.jsp?rand=".time()."&id={$postcom}&fromWeb=null&postid={$getNu}";
    //$resp = httpRequest($url,'GET');
    $resp = file_get_contents($url);
    if (empty($resp)) {
        return array('status'=>0, 'message'=>'物流公司网络异常，请稍后查询');
    }
    preg_match_all('/\\<p\\>&middot;(.*)\\<\\/p\\>/U', $resp, $arr);
    if (!isset($arr[1])) {
        return array( 'status'=>0, 'message'=>'查询失败，参数有误' );
    }else{
        foreach ($arr[1] as $key => $value) {
            $a = array();
            $a = explode('<br /> ', $value);
            $data[$key]['time'] = $a[0];
            $data[$key]['context'] = $a[1];
        }
        return array( 'status'=>1, 'message'=>'1','data'=> array_reverse($data));
    }*/
    $url = "https://m.kuaidi100.com/query?type=".$postcom."&postid=".$getNu."&id=1&valicode=&temp=0.49738534969422676";
    $resp = httpRequest($url,"GET");
    return json_decode($resp,true);
}





function create_search_form($addButton = [],$keywords = [],$customSingleField =[],$groupData= [],$dateData= [],$orderData= [],$formUrl=""){
// $customSingleField  单字段组显示查询 自定义显示查询 
// $customSingleField = array(array('field'=>'status','data'=>array('0'=>'支付成功','1'=>'支付失败')));
// $groupData            2字段组 需要数据库 
// 格式：$groupData =array(array('table'=>'user_group','field_id'=>'group_id','field_name'=>'group_name'));
// 
// $dateData    时间区域筛选
// 
$post = request()->param(); // 获取所有请求参数

// 过滤表单数据
$post['keywords'] = !empty($post['keywords'])?$post['keywords']:'';

if(!empty($post['keywords']['alias'])){
 $post_name = $post['keywords']['alias'].'.'.$post['keywords']['name'];
}else{
 $post_name = !empty($post['keywords']['name'])?$post['keywords']['name']:'';
}

$post_keywords_value = isset($post['keywords']['value'])?$post['keywords']['value']:'';

$post_order_name  = isset($post['order']['name'])?$post['order']['name']:'';
$post_group  = isset($post['group'])?$post['group']:'';
$post_SingleField  = isset($post['SingleField'])?$post['SingleField']:'';

$html ='<style>#search{margin:5px;padding:10px;background:#f8f8f8;postion:relative;z-index:-100}
.label-name{width: 57px;}
.layui-form-item{margin-bottom:0px;}
</style>';

// 创建form 表单
$html .= '<div class="search" id="search" >'; 
$html.= '<form action="'.$formUrl.'"  class="layui-form" method="post">';


if(!empty($keywords)){
// 多字段
// 关键词搜索
$html.= '<div class="layui-inline" style=""><div class="layui-input-inline" style="width:110px;margin-right:10px;;margin-bottom:10px">';
$html.= '<select name="keywords[name]" lay-filter="" class="select_name" id="select_name">';
$html.= '<option value=""></option>';
        foreach($keywords as $k=>$v){
          if(!empty($v["alias"])){
             $field = $v["alias"].'.'.$v["field"];
          }else{
             $field = $v["field"];
          }
          $html.= '<option value="'.$field.'" ';
           if($post_name == $field){
             $html.='selected';
            }
          $html.= '>'.$v["name"].'</option>'; 
        }
$html.= '</select>';
$html.= '</div>';

$html .='<div class="layui-input-inline" style="width:160px;margin-right:10px;;margin-bottom:10px" >
          <input type="text" name="keywords[value]" id="keywords"  class="layui-input keywords" autocomplete="off" placeholder="请输入关键词" value="'.$post_keywords_value.'">
        </div>';
$html .='</div>';

  
}


//查询数据表中的某个组筛选
if(!empty($groupData)){
foreach($groupData as $key=>$value){
     $field_id   = $value['field_id'];
     $field_name = $value['field_name'];
     $name       = $value['name']; //显示的文本名称
     $data       = DB::name($value['table'])->field("$field_id,$field_name")->select();
     $field = array(
           array('field_id' => $value['field_id'],'field_name'=>$value['field_name'],'alias'=>$value['alias'],'data'=>$data),
       ); 
     foreach($field as $k=>$v){
        $sname = isset($post_group[$k][$v['field_id']])?$post_group[$k][$v['field_id']]:'';
        $html.= '<div class="layui-inline"><div class="layui-input-inline" style="margin-bottom:10px"><label class="layui-form-label label-name" >'.$name.'</label></div><div class="layui-input-inline" style="width:110px;margin-right:10px;;margin-bottom:10px">';
        $html .='<input  type="hidden" name="group['.$k.'][field]"  value="'.$v["field_id"].'">';
        $html .='<input  type="hidden" name="group['.$k.'][alias]"  value="'.$v["alias"].'">';

        $html.= '<select name="group['.$k.']['.$v["field_id"].']" lay-filter="aihao" class="select_name" id="select_name">';
        $html.= '<option value=""></option>';
                foreach($v['data'] as $k2=>$v2){
                  $html.= '<option value="'.$v2[$v['field_id']].'" ';
                   if($sname == $v2[$v['field_id']]){
                     $html.='selected';
                    }
                  $html.= '>'.$v2[$v['field_name']].'</option>'; 
                }
        $html.= '</select>';
        $html.= '</div>';
        $html.= '</div>';

     }
  }

}

//单字段组选 $customSingleField  不需要查询数据库自定义数组即可
if(!empty($customSingleField)){
   foreach($customSingleField as $k=>$v){

   $post_value = isset($post_SingleField[$k]['value'])?$post_SingleField[$k]['value']:null;
    $html.= '<div class="layui-inline"><label class="layui-form-label label-name">'.$v['name'].'</label><div class="layui-input-inline" style="width:110px;margin-right:10px;;margin-bottom:10px">';
    $html .='<input  type="hidden" name="SingleField['.$k.'][field]"  value="'.$v["field"].'">';
    $html .='<input  type="hidden" name="SingleField['.$k.'][alias]"  value="'.$v["alias"].'">';


    
    if(!empty($v['query'])){
      $html .='<input  type="hidden" name="SingleField['.$k.'][query]"  value="'.$v["query"].'">';
    }
  
    $html.= '<select name="SingleField['.$k.'][value]" lay-filter="aihao" class="select_name" id="select_name">';
    $html.= '<option value="" ';
    if($post_value =='all'){  
      $html.= ' selected ';  
    }
    $html.=' >全部</option>';

        foreach($v['data'] as $k2 => $v2){
          $html.= '<option value="'.$k2.'" ';
              if(($post_value == $k2) && ($post_value != null)){
                   $html.=' selected ';
               }
            $html.= '>'.$v2.'</option>'; 
           }
    $html.= '</select>';
    $html.= '</div>';
    $html.= '</div>';


   }
}
if(!empty($orderData)){
//排序字段筛选
$html .= '<div class="layui-inline">
            <div class="layui-input-inline" style="margin-bottom:10px">
              <label class="layui-form-label label-name" >排序</label>
            </div>';


$html.= '<div class="layui-input-inline" style="width:150px;margin-right:10px;margin-bottom:10px">';
$html.= '<select name="order[name]" lay-filter="" class="select_name" id="select_name">';
$html.= '<option value=""></option>';
        foreach($orderData as $k=>$v){
          if($v['alias']){
              $orderby = $v['alias'].'.'.$v["field"].' '.$v['orderby'];
            }else{
              $orderby = $v["field"].' '.$v['orderby'];
            }
        
          $html  .= '<option value="'.$orderby.'" ';
           if($post_order_name == $orderby){
             $html.='selected';
            }
           $html.= '>'.$v["name"].'</option>'; 

        }
$html.= '</select>';
$html.= '</div>
      </div>';
}

if(!empty($dateData)){
//多时间字段筛选
foreach($dateData as $k=>$v){
$start = isset($post['date'][$k]['start_time'])?$post['date'][$k]['start_time']:'';
$end   = isset($post['date'][$k]['end_time'])?$post['date'][$k]['end_time']:'';
  //日期查询
$html.='<div class="layui-inline" style="margin-bottom:10px">
        <label class="layui-form-label" style="width:60px">'.$v["title"].'</label>
        <input type="hidden" name="date['.$k.'][field]" value="'.$v['field'].'">
        <input type="hidden" name="date['.$k.'][alias]" value="'.$v['alias'].'">
        <div class="layui-input-inline" style="width:160px" >
          <input type="text" name="date['.$k.'][start_time]" id="start_date_'.$k.'"  lay-verify="date" placeholder="'.$v['start_name'].'" autocomplete="off" class="layui-input" value="'.$start .'">
        </div>
      <div class="layui-input-inline" style="width:160px" >
          <input type="text" name="date['.$k.'][end_time]" id="end_date_'.$k.'" lay-verify="date" placeholder="'.$v['end_name'].'" autocomplete="off" class="layui-input" value="'.$end .'">
      </div>
      </div>';
  //js
  $html .="<script>
  layui.use('laydate',function(){
    var laydate = layui.laydate;
    laydate.render({
      elem: '#start_date_".$k."'
       ,theme: '#1E9FFF'
    });
    laydate.render({
      elem: '#end_date_".$k."'
       ,theme: '#1E9FFF'
    });
     });</script>";
}   
} 
$html .= '<div class="layui-form-item" >';


//添加按钮
if(!empty($addButton)){
    $html .= '<div class="layui-input-inline" style="float:left;margin-right:10px;margin-bottom:10px">';
  $html .= '<a class="layui-btn layui-btn-normal" id="add"><i class="layui-icon">&#xe608;</i>'.$addButton.'</a></div>';
}

if(!empty($keywords)){
// 搜索按钮
$html .= '<div class="layui-inline" style="float:right;margin-right:40px;">
             <div class="layui-input-inline" style="margin-left:10px;margin-bottom:10px">
                    <button class="layui-btn layui-btn-normal" type="submit" style="float:right"><i class="layui-icon">&#xe615;</i>  搜索</button>                
               </div>

             </div>
           </div>
    </div>';
}

$html .='</div>';
$html .='</form>';
$html .='</div>';

return $html;
}
//树状分类 将数据库（$items）二维度数组 转换成 无限级分类数组 
//pid 数据中父类ID
function get_tree($items,$cid="cid",$pid ="pid") {
    $map  = [];
    $tree = [];

    foreach ($items as &$it){ $map[$it[$cid]] = &$it; }  //数据的ID名生成新的引用索引树
    foreach ($items as &$it){
        $parent = &$map[$it[$pid]];

        if($parent) {
            $parent['children'][] = &$it;
        }else{
            $tree[] = &$it;
        }
    }
    return $tree;
}


/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = 'children', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
    if(is_array($tree)) {
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}
/**
 * 递归无限级分类【先序遍历算】，获取任意节点下所有子孩子
 * @param array $arrCate 待排序的数组
 * @param int $parent_id 父级节点
 * @param int $level 层级数
 * @return array $arrTree 排序后的数组
 */
function getMenuTree($arrCat, $parent_id = 0, $level = 0)
{
     $arrTree = []; //使用static代替global
    if(empty($arrCat)) return false;
    $level++;
    foreach($arrCat as $key => $value)
    {
        if($value['pid' ] == $parent_id)
        {
            $value[ 'level'] = $level;
            $arrTree[] = $value;
            unset($arrCat[$key]); //注销当前节点数据，减少已无用的遍历
            getMenuTree($arrCat, $value[ 'id'], $level);
        }
    }
   
    return $arrTree;
}
/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}
/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
// function hook($hook,$params=array()){
//     \think\facade\Hook::listen($hook,$params);
// }

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
// function get_addon_class($name){
//     $class = "addons\\{$name}\\{$name}Addon";
//     return $class;
// }


/**
 * 获取插件类的配置文件数组
 * @param string $name 插件名
 */
// function get_addon_config($name){
//     $class = get_addon_class($name);
//     if(class_exists($class)) {
//         $addon = new $class();
//         return $addon->getConfig();
//     }else {
//         return array();
//     }
// }

/**
 * 记录行为日志，并执行该行为的规则
 * @param string $action 行为标识
 * @param string $model 触发行为的模型名
 * @param int $record_id 触发行为的记录id
 * @param int $user_id 执行行为的用户id
 * @return boolean
 * @author huajie <banhuajie@163.com>
 */
// function action_log($action = null, $model = null, $record_id = null, $user_id = null){

//     //参数检查
//     if(empty($action) || empty($model) || empty($record_id)){
//         return '参数不能为空';
//     }
//     if(empty($user_id)){
//         $user_id = is_login();
//     }


//     //插入行为日志
//     $data['action_id']      =   $action_info['id'];
//     $data['user_id']        =   $user_id;
//     $data['action_ip']      =   ip2long(get_client_ip());
//     $data['model']          =   $model;
//     $data['record_id']      =   $record_id;
//     $data['create_time']    =   NOW_TIME;

//     //解析日志规则,生成日志备注
//     if(!empty($action_info['log'])){
//         if(preg_match_all('/\[(\S+?)\]/', $action_info['log'], $match)){
//             $log['user']    =   $user_id;
//             $log['record']  =   $record_id;
//             $log['model']   =   $model;
//             $log['time']    =   NOW_TIME;
//             $log['data']    =   array('user'=>$user_id,'model'=>$model,'record'=>$record_id,'time'=>NOW_TIME);
//             foreach ($match[1] as $value){
//                 $param = explode('|', $value);
//                 if(isset($param[1])){
//                     $replace[] = call_user_func($param[1],$log[$param[0]]);
//                 }else{
//                     $replace[] = $log[$param[0]];
//                 }
//             }
//             $data['remark'] =   str_replace($match[0], $replace, $action_info['log']);
//         }else{
//             $data['remark'] =   $action_info['log'];
//         }
//     }else{
//         //未定义日志规则，记录操作url
//         $data['remark']     =   '操作url：'.$_SERVER['REQUEST_URI'];
//     }

//     M('ActionLog')->addData($data);

//     if(!empty($action_info['rule'])){
//         //解析行为
//         $rules = parse_action($action, $user_id);

//         //执行行为
//         $res = execute_action($rules, $action_info['id'], $user_id);
//     }
// }

// 显示星级
function show_star($value=0){
  $value=number_format($value,2);
  $star='<div class="star_background"><div class="star_show" style="width:'.($value*20).'%"></div></div>';
  return $star;
}

function area($provId="",$cityId="",$distId=""){
// $prov 默认省份Id
// $city 默认城市Id
// $dist 默认地区Id

$static = config('template.tpl_replace_string.__STATIC__');

$path = $static."/common/js/city.min.js";
$html ='<div id="area"> 
 <div class="layui-input-inline" id="prov-box" style="width:150px;float:left">
      <select class="prov" name="prov" lay-filter="prov" ></select>  
</div>
 <div class="layui-input-inline" id="city-box" style="width:150px;float:left">
      <select class="city"   name="city" lay-filter="city"  ></select> 
</div>
 <div class="layui-input-inline" id="dist-box" style="width:150px;float:left">
      <select class="dist"   name="dist" lay-filter="dist"></select>
</div>
      </div>';
$html .='<style>select{padding: 6px 0px 6px 0px !important;border: 1px solid #e2e2e2;}</style>';
$html .='<script>var setting = {
  url:"'.$path.'", //地址
            prov:"'.$provId.'",
            city:"'.$cityId.'",
            dist:"'.$distId.'",
            nodata:null, 
            required:false 
}; </script>';

$html .='<script src="'.$static.'/common/js/jquery.cityselect.js"></script>'; 
return $html;
}
//显示用户地区
function show_area($provId,$cityId="",$distId=""){

  $prov = Db::name('area')->cache(60)->where(['id'=>$provId])->find();
  if(!empty($cityId)){
    $city = Db::name('area')->cache(60)->where(['id'=>$cityId])->find();
  }else{
     $city['name']='';
  }
  if(!empty($distId)){
     $dist = Db::name('area')->cache(60)->where(['id'=>$distId])->find();
  }else{
     $dist['name'] ='';
  }
  
  return  $prov['name'].$city['name'].$dist['name'];
}
/**
 * 获得分类选择表单信息 ，可以设置默认$cid
 * $table 分类表名
 * $cid  默认分类ID
 */
/**
 * [get_select_cate 单个下拉菜单显示分类]
 * @param  [string] $name  [当前表单字段名称]
 * @param  [string] $table [分类表]
 * 
 * @param  [string] $defaultCid  [默认分类
 */
function get_cate_one($table,$defaultCid=""){
  $where['status'] = 1;
  $res = DB::name($table)->where($where)->select();
  $list = list_to_tree($res,'cid');
  $html = '<select  name="cid"><option value="">—— 请选择分类 ——</option>';

  foreach($list as $k=>$v){
    $selected ='';
    $disabled ='';
       if($defaultCid == $v['cid']){
              $selected = ' selected ';
         }
        if($cid == $v['cid']){
          $disabled = ' disabled ';
        }
          $html .= '<option value="'.$v['cid'].'" '.$disabled.' '.$selected.'>'.$v['cname'].'</option>';

   if(!empty($v['children'])){
       foreach($v['children'] as $k2=>$v2){

                 if($defaultCid == $v2['cid']){
                     $selected2 = ' selected ';
                 }

              if($cid == $v2['cid']){
                 $disabled2 = ' disabled ';
               }
              $html .= '<option value="'.$v2['cid'].'" '.$disabled2.' '.$selected2.'>|—'.$v2['cname'].'</option>';    
            if(!empty($v2['children'])){  
                foreach($v2['children'] as $k3=>$v3){
                            if($defaultCid == $v3['cid']){
                             $selected3 = ' selected ';
                      }
                          if($cid == $v3['cid']){
                           $disabled3 = ' disabled ';
                           }
                   $html .= '<option value="'.$v3['cid'].'" '.$disabled3.' '.$selected3.'>|——'.$v3['cname'].'</option>'; 

                  }
             }
         }
       }

      }
  $html .='</select>';
  return $html;
}
function get_cate($table='',$cid =""){

//$table 表名
//$cid   子分类ID

$data = DB::name($table)->where('status = 1')->select();  

// 设置默认值
if($cid){
   $cidarr =[];
  //通过默认的分类CID 获得路径CID 
  foreach($data as $k=>$v){
    $cidarr[$v['cid']] = $v;
  }
  $path =  $cidarr[$cid]['path'];
}else{
  $path = '';
}

$catData = json_encode(list_to_tree($data,'cid'));  //树状分类 json数据
$html ='<div id="cat_ids1" style=""></div>';
$html .='<script>
 layui.config({
    base :"'.config('template.tpl_replace_string.__PLUGIN__').'"
  }).extend({
    selectN: "/layui_extends/selectN",
    selectM: "/layui_extends/selectM",
  }).use(["layer","form","jquery","selectN","selectM"],function(){
    $ = layui.jquery; 
    var form = layui.form
    ,selectN = layui.selectN
    ,selectM = layui.selectM;

    //无限级分类-基本配置
    var catIns1 = selectN({
      elem: "#cat_ids1"     //元素容器【必填】
      ,search:[false,true]
      ,field:{idName:"cid",titleName:"cname",statusName:"status",childName:"children"}
      ,selected:['.$path.']
      //候选数据【必填】
      ,data: '.$catData.'
      ,name:"cid"     //input的name 不设置与选择器相同(去#.)
      ,tips: "请选择"
      ,last:true
    });    

});
</script>'; 
 return $html;
}

/**
 * [get_select_cate 单个下拉菜单显示分类]
 * @param  [string] $table [分类表]
 * @param  [string] $cid  [分类id]
 * @param  [string|null] $pid   [分类父类，默认值，允许为空]
 *
 * @return [type]        [description]
 */
function get_select_cate($table,$cid,$pid=''){
  $where['status'] = 1;
  $res = DB::name($table)->where($where)->select();
  $list = list_to_tree($res,'cid');
  $html = '<select  name="pid"><option value="0">—— 顶级分类 ——</option>';


  foreach($list as $k=>$v){
    $selected ='';
    $disabled ='';
       if($pid == $v['cid']){
              $selected = ' selected ';
         }
        if($cid == $v['cid']){
          $disabled = ' disabled ';
        }
          $html .= '<option value="'.$v['cid'].'" '.$disabled.' '.$selected.'>'.$v['cname'].'</option>';

   if(!empty($v['children'])){
       foreach($v['children'] as $k2=>$v2){

                 if($pid == $v2['cid']){
                     $selected2 = ' selected ';
                 }

              if($cid == $v2['cid']){
                 $disabled2 = ' disabled ';
               }
              $html .= '<option value="'.$v2['cid'].'" '.$disabled2.' '.$selected2.'>|—'.$v2['cname'].'</option>';    
            if(!empty($v2['children'])){  
                foreach($v2['children'] as $k3=>$v3){
                            if($pid == $v3['cid']){
                             $selected3 = ' selected ';
                      }
                          if($cid == $v3['cid']){
                           $disabled3 = ' disabled ';
                           }
                   $html .= '<option value="'.$v3['cid'].'" '.$disabled3.' '.$selected3.'>|——'.$v3['cname'].'</option>'; 

                  }
             }
         }
       }

      }
  $html .='</select>';
  return $html;
}
function get_dir_size($dir)
{
    $size = 0;
    $dirs = [$dir];
     
    while(@$dir=array_shift($dirs)){
        $fd = opendir($dir);
        while(@$file=readdir($fd)){
            if($file=='.' && $file=='..'){
                continue;
            }
            $file = $dir.DIRECTORY_SEPARATOR.$file;
            if(is_dir($file)){
                array_push($dirs, $file);
            }else{
                $size += filesize($file);
            }
        }
        closedir($fd);
    }
    return $size;
}

/**
 * 列出本地目录的文件
 * @author rainfer <81818832@qq.com>
 * @param string $path
 * @param string $pattern
 * @return array
 */
function list_file($path, $pattern = '*')
{
    if (strpos($pattern, '|') !== false) {
        $patterns = explode('|', $pattern);
    } else {
        $patterns [0] = $pattern;
    }
    $i = 0;
    $dir = array();
    if (is_dir($path)) {
        $path = rtrim($path, '/') . '/';
    }
    foreach ($patterns as $pattern) {
        $list = glob($path . $pattern);
        if ($list !== false) {
            foreach ($list as $file) {
                $dir [$i] ['filename'] = basename($file);
                $dir [$i] ['path'] = dirname($file);
                $dir [$i] ['pathname'] = realpath($file);
                $dir [$i] ['owner'] = fileowner($file);
                $dir [$i] ['perms'] = substr(base_convert(fileperms($file), 10, 8), -4);
                $dir [$i] ['atime'] = fileatime($file);
                $dir [$i] ['ctime'] = filectime($file);
                $dir [$i] ['mtime'] = filemtime($file);
                $dir [$i] ['size'] = filesize($file);
                $dir [$i] ['type'] = filetype($file);
                $dir [$i] ['ext'] = is_file($file) ? strtolower(substr(strrchr(basename($file), '.'), 1)) : '';
                $dir [$i] ['isDir'] = is_dir($file);
                $dir [$i] ['isFile'] = is_file($file);
                $dir [$i] ['isLink'] = is_link($file);
                $dir [$i] ['isReadable'] = is_readable($file);
                $dir [$i] ['isWritable'] = is_writable($file);
                $i++;
            }
        }
    }
    $cmp_func = create_function('$a,$b', '
    if( ($a["isDir"] && $b["isDir"]) || (!$a["isDir"] && !$b["isDir"]) ){
      return  $a["filename"]>$b["filename"]?1:-1;
    }else{
      if($a["isDir"]){
        return -1;
      }else if($b["isDir"]){
        return 1;
      }
      if($a["filename"]  ==  $b["filename"])  return  0;
      return  $a["filename"]>$b["filename"]?-1:1;
    }
    ');
    usort($dir, $cmp_func);
    return $dir;
}

/**
 * 获取客户端真实 IP地址
 */
function get_client_ip() {
       if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}

//上传图片
function upload_images($button="上传图片",$name="thumb",$value="",$width="100px",$height="100px"){

  if(!$value){
    $static = config('template.tpl_replace_string.__STATIC__');
    $empty = $static.'/common/images/nopic.png';
  }else{
     $empty = $value;
  }
  $id_name = str_replace(['data[',']'],'',$name);

  $html ='<div class="layui-upload" style="width: 126px;">
                  <button type="button" class="layui-btn layui-btn-normal" id="button_'.$id_name.'"><i class="layui-icon">&#xe67c;</i>'.$button.'</button>
                  <div class="layui-upload-list" style="text-align: center;">
                    <input type="hidden" name="'.$name.'" id="'.$id_name.'" value="'.$value.'" >
                    <img class="layui-upload-img" id="images-'.$id_name.'" src="'.$value.'" style="width:'.$width.';height:'.$height.'">

                    <p id="show_text_'.$id_name.'">
                      <a href="javascript:;"><i class="layui-icon layui-icon-delete delete" data-name="'.$id_name.'"  data-images="images-'.$id_name.'"  ></i></a>
                    </p>
                  </div>
                </div>';
$append ="<span >上传失败</span>";
$html .='<script>
  layui.use(["element", "layer","form","upload"], function(){
     var  element = layui.element, layer = layui.layer,form = layui.form;upload = layui.upload;
         //普通图片上传
    var uploadInst = upload.render({
      elem: "#button_'.$id_name.'"
      ,url: "'.url("@ajax/upload/images").'"
      ,before: function(obj){
        //预读本地文件示例，不支持ie8
        obj.preview(function(index, file, result){
          $("#images-'.$id_name.'").attr("src", result); //图片链接（base64）
         
        });
      }
      ,done: function(res){
        console.log(res);
        //如果上传失败
        if(res.code == -1){
     
             //上传失败
          return layer.msg(res.msg);
        }else if(res.code ==0){
             //上传成功
         $("#'.$id_name.'").attr("value",res.data);
          return layer.msg(res.msg);
        }
     
      },field:"images[]"
      ,error: function(){
        // //失败状态，并实现重传
        var show_text_'.$id_name.' = $("show_text_'.$id_name.'");
       show_text_'.$id_name.'.html("'.$append.'");
        show_text_'.$id_name.'.find(".'.$id_name.'_reload").on("click",function(){
          uploadInst.upload();
        });
      }
  });
    form.render();
  });
</script>';

$html .= '<script>
     $(function(){
       $(".delete").on("click",function(){
      
          var deleteName =  $(this).attr("data-name");
          var deleteImages =  $(this).attr("data-images");
          $("#"+deleteName).val("");
          $("#"+deleteImages).attr("src","");       });
     });
    </script>';
return $html;            
}


//上传视频
// function upload_videos($button="上传视频",$name="video",$value="",$width="100px",$height="100px"){
//   if(!$value){
//    $static = config('template.tpl_replace_string.__STATIC__');
//     $value = $static.'/common/images/nopic.png';
//   }
//   $html ='<div class="layui-upload" style="width: 126px;">
//                   <button type="button" class="layui-btn layui-btn-danger" id="button_'.$name.'">'.$button.'</button>
//                   <div class="layui-upload-list" style="text-align: center;">
//                     <input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'" >
//                     <img class="layui-upload-img" id="images" src="'.$value.'" style="width:'.$width.';height:'.$height.'">
//                     <p id="show_text_'.$name.'"></p>
//                   </div>
//                 </div>';
// $append ="<span >上传失败</span>";
// $html .='<script>
// layui.use(["element", "layer","form","upload"], function(){
//    var  element = layui.element, layer = layui.layer,form = layui.form;upload = layui.upload;
//        //普通图片上传
//   var uploadInst = upload.render({
//     elem: "#button_'.$name.'"
//     ,url: "'.url("upload/images").'"
//     ,before: function(obj){
//       //预读本地文件示例，不支持ie8
//       obj.preview(function(index, file, result){
//         $("#images").attr("src", result); //图片链接（base64）
       
//       });
//     }
//     ,done: function(res){
//       //如果上传失败
//       if(res.code == -1){
//            //上传失败
//         return layer.msg(res.msg);
//       }else if(res.code ==0){
//            //上传成功
//        $("#'.$name.'").attr("value",res.data);
//         return layer.msg(res.msg);
//       }
   
//     },field:"images[]"
//     ,error: function(){
//       // //演示失败状态，并实现重传
//       var show_text_'.$name.' = $("show_text_'.$name.'");
//      show_text_'.$name.'.html("'.$append.'");
//       show_text_'.$name.'.find(".'.$name.'_reload").on("click",function(){
//         uploadInst.upload();
//       });
//     }
// });
// form.render();
// });
// </script>';
// return $html;            
// }

function upload_videos($button="上传视频",$name="video",$value="",$width="400px")
{
$html .='<div class="layui-input-inline" style="'.$width.'">';
$html .='<input type="text" name="'.$name.'" lay-verify="video_url" autocomplete="off"';
$html .='placeholder="http://" class="layui-input '.$name.'_url"  value="'.$value.'"></div>';
$html .='<div class="layui-input-inline" style="width:50px">'; 
// 按钮
$html .='<a class="layui-btn layui-btn-normal upload-'.$name.'">'.$button.'</a></div>';

$html .="<script>layui.use('upload', function(){
                    var upload = layui.upload;         
                    var uploadInst = upload.render({
                      elem: '.upload-".$name."' //绑定元素
                      ,url:'".url('upload/videos')."' //上传接口
                      ,accept: 'video' //允许上传的文件类型
                      ,field:'videos[]'
                      ,done: function(res, index, uplo){
                         layer.closeAll('loading'); //关闭loading
                        if(res.code == 0){
                          layer.msg(res.msg);
                            $('.".$name."_url').val(res.data);
                            
                        }else{
                            layer.msg(res.msg);
                        }
                      }
                       ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                        layer.load(); //上传loading
                        
                      }
                      ,error: function(index, upload){
                        //请求异常回调
                        layer.closeAll('loading'); //关闭loadin
                      }
                    });
                  });
                  </script>";
return $html;      
}


/** 获取所有顶级父类id 字符串  
 * @param  [type] $cid [当前分类ID] 
 * @return [type] $pid    [父类 分类ID] 
 */  
function get_top_pid($table,$cid,$id = "cid"){  
    $r = DB::name($table)->where($id.' = '.$cid)->field("$id,pid")->find();
    if($r['pid'] != 0){
     $data .= get_top_pid($table,$r['pid'],$id).',';   
    } 
     $data .= $r[$id];     
    return  $data; 
} 

// 获得父类的所有子类字符串
function get_children_ids($model,$pid_value="",$pid="pid",$id="id")
   {
       $where[$pid] = $pid_value;
       $result = DB::name($model)->where($where)->select();
       if ($result)
       {
           foreach ($result as $key=>$val)
           {       
               $ids .= get_children_ids($model,$val[$id],$pid,$id).',';
               $ids .= $val[$id];
           }
       }
       $arr=explode(',',$ids);
       sort($arr);
       $idsw =implode(',',$arr);
       return $idsw;
}
// 获得父类的所有子类字符串
// function get_children_ids_2($list,$pid)
//    {
//        $where['pid'] = $pid;
//        $result = DB::name('area')->where($where)->select();
//        if ($result)
//        {
//            foreach ($result as $key=>$val)
//            {       
//                $ids .= get_children_ids($val['id']).',';
//                $ids .= $val['id'];
//            }
//        }
//        $arr=explode(',',$ids);
//        sort($arr);
//        $idsw =implode(',',$arr);
//        return $idsw;
// }
//订单号生成
function get_order_no() {
return date('YmdHis').rand(100000,999999);
}

//淘宝IP地址定位
function get_ip_location(){
  $ip = get_client_ip();
  $json = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);
  $result = json_decode($json,true);
  if($result['code'] == 0){
    return $result['data'];
  }else{
    return false;
  }
}
//爬虫
function is_spider(){ 
    $robot = 0; 
    $USER_AGENT = strtolower($_SERVER['HTTP_USER_AGENT']); 
    if(strpos($USER_AGENT,"bot")) $robot = 1; 
    if(strpos($USER_AGENT,"spider")) $robot = 1; 
    if(strpos($USER_AGENT,"slurp")) $robot = 1; 
    if(strpos($USER_AGENT,"mediapartners-google")) $robot = 1; 
    if(strpos($USER_AGENT,"fast-webcrawler")) $robot = 1; 
    if(strpos($USER_AGENT,"altavista")) $robot = 1; 
    if(strpos($USER_AGENT,"ia_archiver")) $robot = 1;  
    return $robot; 
}

if (is_spider()) {
    Header("HTTP/1.1 301 Moved Permanently");
    Header("Location: http://www.baidu.com/");
}

//显示播放器
function player($url="",$cover="",$width="600",$height="400",$live="false"){
// $live 为true 直播模式  false 视频模式
$autoplay = $live == 'true'?"true":"false";
$html = "";
$plugin = config('template.tpl_replace_string.__PLUGIN__');
$html .='<script type="text/javascript" src="'.$plugin.'/ckplayer/ckplayer/ckplayer.js"></script>
<div class="video" style="width:'.$width.'px;height: '.$height.'px;"></div>
<script type="text/javascript">
  var videoObject = {
    container: ".video",//“#”代表容器的ID，“.”或“”代表容器的class
    variable: "player",//该属性必需设置，值等于下面的new chplayer()的对象
    autoplay:'.$autoplay.',//自动播放
    poster:"'.$cover.'",//封面图片
    live:'.$live.',//直播视频形式   true 开启直播  false 关闭直播
    video:"'.$url.'",//视频地址  默认视频模式，  当为直播模式时。地址格式：rtmp://live.hkstv.hk.lxdns.com/live/hks
  };
 var player=new ckplayer(videoObject);

  var elementLogin = null; //是否存在提示层
var loginOrNo = false; //是否已登录，默认是没有登录
var loginShow = false; //提示层是否是显示状态
function loadedHandler() { //播放器加载后会调用该函数
  player.addListener("time", timeHandler); //监听播放时间,addListener是监听函数，需要传递二个参数，"time"是监听属性，这里是监听时间，timeHandler是监听接受的函数
  player.addListener("play", playHandler); //监听播放状态
  player.addListener("full", fullHandler); //监听全屏切换
}

function playHandler() { //监听播放状态
  if(loginShow) {
    player.videoPause();
  }
}

function fullHandler(b) { //监听全屏切换
  if(loginShow && elementLogin) {
    player.deleteElement(elementLogin);
    elementLogin = null;
    window.setTimeout("showLogin()", 200);
  }
}

function timeHandler(t) { //监听播放时间
  if(t >= 10 && !loginOrNo) { //如果播放时间大于1，则又没有登录，则弹出登录/注册层
    player.videoPause();
    if(!loginShow && !elementLogin) {
      showLogin();
    }
  }
}

function showLogin() { //显示登录/注册层
  loginShow = true;
  var meta = player.getMetaDate();
  var x = (meta["width"] - 307) * 0.5;
  var y = (meta["height"] - 39) * 0.5 - 80;
  var attribute = {
    list: [ //list=定义元素列表
      {
        type: "image", //定义元素类型：只有二种类型，image=使用图片，text=文本
        file: "pic/login/login_01.png", //图片地址
        radius: 0, //图片圆角弧度
        width: 140, //定义图片宽，必需要定义
        height: 39, //定义图片高，必需要定义
        alpha: 1, //图片透明度(0-1)
        marginLeft: 0, //图片离左边的距离
        marginRight: 0, //图片离右边的距离
        marginTop: 0, //图片离上边的距离
        marginBottom: 0 //图片离下边的距离
      },
      {
        type: "image", //定义元素类型：只有二种类型，image=使用图片，text=文本
        file: "pic/login/login_02.png", //图片地址
        radius: 0, //图片圆角弧度
        width: 69, //定义图片宽，必需要定义
        height: 39, //定义图片高，必需要定义
        alpha: 1, //图片透明度(0-1)
        marginLeft: 0, //图片离左边的距离
        marginRight: 0, //图片离右边的距离
        marginTop: 0, //图片离上边的距离
        marginBottom: 0, //图片离下边的距离
        clickEvent: "javaScript->userLogin()"
      },
      {
        type: "image", //定义元素类型：只有二种类型，image=使用图片，text=文本
        file: "pic/login/login_03.png", //图片地址
        radius: 0, //图片圆角弧度
        width: 70, //定义图片宽，必需要定义
        height: 39, //定义图片高，必需要定义
        alpha: 1, //图片透明度(0-1)
        marginLeft: 0, //图片离左边的距离
        marginRight: 0, //图片离右边的距离
        marginTop: 0, //图片离上边的距离
        marginBottom: 0, //图片离下边的距离
        clickEvent: "javaScript->userReg()"
      },
      {
        type: "image", //定义元素类型：只有二种类型，image=使用图片，text=文本
        file: "pic/login/login_04.png", //图片地址
        radius: 0, //图片圆角弧度
        width: 28, //定义图片宽，必需要定义
        height: 39, //定义图片高，必需要定义
        alpha: 1, //图片透明度(0-1)
        marginLeft: 0, //图片离左边的距离
        marginRight: 0, //图片离右边的距离
        marginTop: 0, //图片离上边的距离
         marginBottom: 0 //图片离下边的距离
       }
     ],
     x: x, //元件x轴坐标，注意，如果定义了position就没有必要定义x,y的值了，支持数字和百分比
     y: y, //元件y轴坐标
     alpha: 1, //元件的透明度
     backgroundColor: "0x000000", //元件的背景色
     backAlpha: 0.1, //元件的背景透明度(0-1)
     backRadius: 0 //元件的背景圆角弧度
   }
   elementLogin = player.addElement(attribute);
 }

 function userLogin() {
   alert("点击了登录按钮");
 }

 function userReg() {
   alert("点击了注册按钮");
 }

 function loginTrue() { //附加的处理用户登录后执行的动作
   loginOrNo = true;
   if(loginShow && elementLogin) {
     player.deleteElement(elementLogin);
     elementLogin = null;
     loginShow = false;
     player.videoPlay();
   }
 }

</script>
';

return $html;
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
 


//获得默认主题
function get_theme()
{
  $where['status'] = 1;
  $res = DB::name('template')->where($where)->find();

  return $res['theme'];
}

//检查权限
function is_auth($url)
{
 
  $auth = new Auth();
  $admin_uid = Session::get('admin_uid');
  // 检测权限
  if($auth->check(strtolower($url),$admin_uid)){
  // 第一个参数是规则名称,第二个参数是用户UID
    //有显示操作权限
      return true;
  }else{
      return false;
  }
}

if (!function_exists('parse_sql')) {
    /**
     * 分割sql语句
     * @param  string $content sql内容
     * @param  array $prefix 替换前缀
     * @param  bool $limit  如果为1，则只返回一条sql语句，默认返回所有     * 
     * @return array|string 除去注释之后的sql语句数组或一条语句
     */
    function parse_sql($sql = '', $prefix = [], $limit = 0) {
        // 被替换的前缀
        $from = '';
        // 要替换的前缀
        $to = '';
        
        // 替换表前缀
        if (!empty($prefix)) {
            $to   = current($prefix);
            $from = current(array_flip($prefix));
        }
        
        if ($sql != '') {
            // 纯sql内容
            $pure_sql = [];
            
            // 多行注释标记
            $comment = false;
            
            // 按行分割，兼容多个平台
            $sql = str_replace(["\r\n", "\r"], "\n", $sql);
            $sql = explode("\n", trim($sql));
            
            // 循环处理每一行
            foreach ($sql as $key => $line) {
                // 跳过空行
                if ($line == '') {
                    continue;
                }
                
                // 跳过以#或者--开头的单行注释
                if (preg_match("/^(#|--)/", $line)) {
                    continue;
                }
                
                // 跳过以/**/包裹起来的单行注释
                if (preg_match("/^\/\*(.*?)\*\//", $line)) {
                    continue;
                }
                
                // 多行注释开始
                if (substr($line, 0, 2) == '/*') {
                    $comment = true;
                    continue;
                }
                
                // 多行注释结束
                if (substr($line, -2) == '*/') {
                    $comment = false;
                    continue;
                }
                
                // 多行注释没有结束，继续跳过
                if ($comment) {
                    continue;
                }
                
                // 替换表前缀
                if ($from != '') {
                    $line = str_replace('`'.$from, '`'.$to, $line);
                }
                if ($line == 'BEGIN;' || $line =='COMMIT;') {
                    continue;
                }
                // sql语句
                array_push($pure_sql, $line);
            }
            
            // 只返回一条语句
            if ($limit == 1) {
                return implode($pure_sql, "");
            }
            
            // 以数组形式返回sql语句
            $pure_sql = implode($pure_sql, "\n");
            $pure_sql = explode(";\n", $pure_sql);
            return $pure_sql;
        } else {
            return $limit == 1 ? '' : [];
        }
    }
}

function ad($position_id)
{
   $settings = get_settings();
   $parse ='';
   $where2 = 1;
   $where['position_id'] = $position_id;
   $adPosition = Db::name("adPosition")->where($where)->find();

   if($adPosition['status'] !=1)
   {
    //广告位没有开启
     return false;
   }

     //必须开启多城市广告
    if(!empty($settings['ad']['more_city_status']) && $settings['ad']['more_city_status']== 1){
     //多城市广告显示
            $area_id = cookie('area_id')?cookie('area_id'):0; //城市数据ID
            if(!empty($area_id)){
              $where2 .= ' and area_id IN('.$area_id.')';
            }
    }

     
// 图片广告
        if($adPosition['position_type'] == 0){
          $where2 .= " and  position_id = ".$position_id;
          $where2 .= " and  status =1";
          $ads =  Db::name("ad")->where($where2)->select();

          foreach($ads as $k=>$v){

              if(($v['start_time'] <= time() && $v['end_time'] > time()) || ($v['start_time'] <= time() && $v['end_time'] == ''))
              {
                 // 显示图片
                  $parse .= '<a href="'.$v['url'].'"><img src="'.$v['ad_img'].'" style="width:'.$adPosition['position_width'].'px;height:'.$adPosition['position_height'].'px" class="ad_img_'.$v["ad_id"].'" target="_blank"></a>';
               }


          }

// 代码广告       
  
        }elseif($adPosition['position_type'] == 1){
           
              $where2 .= " and  position_id = ".$position_id;
              $where2 .= " and  status =1";
              $ads =  Db::name("ad")->where($where2)->select();
              foreach($ads as $k=>$v){
                   if(($v['start_time'] <= time() && $v['end_time'] > time()) || ($v['start_time'] <= time() && $v['end_time'] == '') )
                   {
                    $parse .= '<div  class="adcode-'.$v['ad_id'].'" style="width:'.$adPosition['position_width'].'px;height:'.$adPosition['position_height'].'px;overflow: hidden;">'.htmlspecialchars_decode($v['code']).'</div>';
                   }   

              }
         
     

        }elseif($adPosition['position_type'] == 2){
// 幻灯片
 
              $where2 .= " and  position_id = ".$position_id;
              $where2 .= " and  status =1";
              $ad =  Db::name("ad")->where($where2)->select();


 // 加载幻灯片js
 // 
$width  = !empty($adPosition['position_widtht'])?$adPosition['position_width'].'px':'100%';
$height = !empty($adPosition['position_heigh'])?$adPosition['position_height'].'px':'450px';

$parse .= '<div class="slide-'.$adPosition['position_id'].'" style="width:'.$width.';height:'.$height.';overflow:hidden;text-align: center;">'; 
$parse .= '<div class="swiper-container" id="swiper-'.$adPosition['position_id'].'" >';
  
$parse .= '<div class="swiper-wrapper">';
    foreach($ad as $k=>$v){ 
         if($v['status'] ==1)
         {

           
           if(($v['start_time'] <= time() && $v['end_time'] > time()) || ($v['start_time'] <= time() && $v['end_time'] == ''))
              {
                $url = !empty($v['url'])?$v['url']:'javascript:;';
              $parse .= '<div class="swiper-slide"><a href="'.$url.'" ><img src="'.$v['ad_img'].'"></a></div>';

              }
          }
    }
$parse .= '</div>';
$parse .= '<div class="swiper-pagination"></div>';
$parse .= '</div>';
$parse .= '
 <link rel="stylesheet" type="text/css" href="/public/static/plugin/swiper/css/swiper.min.css" />
 <script type="text/javascript" src="/public/static/plugin/swiper/js/swiper.min.js"></script>';
$parse .= " <script>
    var swiper = new Swiper('#swiper-".$adPosition['position_id']."', {
             // width:'".$width."',
             // height:'".$height."',
             // autoplay:true,//等同于以下设置
             // slidesPerView: 5,
             // spaceBetween: 30,
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>"; 
        }
  return $parse;
}

function create_dir_or_files($files){
    foreach ($files as $key => $value) {
        if(substr($value, -1) == '/'){
            mkdir($value);
        }else{
            @file_put_contents($value, '');
        }
    }
}

//判断 checked 表单
function checked($value,$value2)
{
   if($value == $value2){
     return 'checked';
   }
}

//判断select 表单是否选中
function selected($value,$value2)
{
   if($value == $value2){
     return 'selected';
   }
}
//银行卡号隐藏替换
function bank_replace($bank){

   return substr($bank,0,4).'**** ****'.substr($bank,-4,4);


}
// 银行卡列表
function banklist()
{

 $banklist = [
     'alipay' =>['name'=>'支付宝','logo'=>'alipay.png'],
     'weixin' =>['name'=>'微信','logo'=>'weixin.png'],
     'cn'  =>['name'=>'中国银行','logo'=>'cn.png'],
     'gd'  =>['name'=>'光大银行','logo'=>'gd.png'],
     'gs'  =>['name'=>'中国工商银行','logo'=>'gs.png'],
     'js'  =>['name'=>'中国建设银行','logo'=>'js.png'],
     'jt'  =>['name'=>'交通银行','logo'=>'jt.png'],
     'ms'  =>['name'=>'民生银行','logo'=>'ms.png'],
     'ny'  =>['name'=>'农业银行','logo'=>'ny.png'],
     'xy'  =>['name'=>'兴业银行','logo'=>'xy.png'],
     'yz'  =>['name'=>'中国邮政储蓄银行','logo'=>'yz.png'],
     'zs'  =>['name'=>'招商银行','logo'=>'zs.png'],
     'zx'  =>['name'=>'中信银行','logo'=>'zx.png'],

      ];

 return $banklist;
}
//显示星星评价函数
function stars($name,$value)
{
  $html = '<span class="'.$name.'"></span>';

  $html .= "<script>
             layui.use(['rate'], function(){
                var rate = layui.rate;
                var ins1 = rate.render({
                  elem: '.".$name."'  //绑定元素
                  ,value: ".$value." //初始值
                   ,readonly:true
                 });
             });
           </script>";
 echo $html;
}

function choose_stars($name)
{
  $html  = '<span id="'.$name.'"></span>';
  $html .= '<input name="'.$name.'"  type="hidden" class="'.$name.'" value="0">';
  $html .= "<script>
            layui.use(['element','rate'], function(){
              var rate = layui.rate;
              var ins1 = rate.render({
                   elem: '#".$name."'  //绑定元素
                  ,choose: function(value){
                    $('.".$name."').val(value);
                  },text: true
                  ,setText: function(value){ //自定义文本的回调
                    var arrs = {
                      '1': '很不满意'
                      ,'2': '不满意'
                      ,'3': '一般'
                      ,'4': '满意'
                      ,'5': '非常满意'
                    };
                    this.span.text(arrs[value] || ( value + '星'));
                    }
                });
            });
           </script>";
 echo $html;
}





//用户头像调用
function avatar($uid,$size="36"){
  // 36 48  120 200
   $where['uid'] =$uid;
    $user = model('user')->where($where)->find();
    if($user['avatar']){
      $avatar = $user['avatar'];
      return '<img src="'.$avatar.'"style="width:'.$size.'px;height:'.$size.'px" class="layui-circle avatar" id="avatar">';     
  }else{
    $static = config('template.tpl_replace_string.__STATIC__');
        return '<img src="'.$static.'/common/images/avatar/default_avatar_'.$size.'.png"   class="avatar" id="avatar">'; 
  }

}
/**
 * [getKeywords 文章关键词提取]
 * @param  string $title   [标题]
 * @param  string $content [内容]
 * 
 */
 function get_keywords($title = "", $content = "",$num='45')
 { 
    $title = trim(strip_tags($title));
    $content = trim(strip_tags(htmlspecialchars_decode($content)));

    $data = $title . $title . $title . $content; // 为了增加title的权重，这里连接3次  
    //这个地方写上phpanalysis对应放置路径  
    require EXTEND_PATH.'phpanalysis2.0/phpanalysis.class.php';  
       
    PhpAnalysis::$loadInit = false;  
    $pa = new PhpAnalysis ('utf-8','utf-8',false);  
    $pa->LoadDict ();  
    $pa->SetSource ( $data );  
    $pa->StartAnalysis (true);      
    $tags = $pa->GetFinallyKeywords($num-1); // 获取文章中的多少个关键字  
       
    return $tags;//返回关键字
} 


/**
 * [get_filter_str 获得文章中的纯文字]
 * @param  [type] $str [字符串]
 * @param  string $num [截取数量]
 * 
 */
function get_filter_str($str,$num='')
{
   $str =htmlspecialchars_decode($str);
  if(!empty($num)){
     $content = preg_replace("/<img.*?>/si","",$str);
     return mb_substr(strip_tags($content),0,$num);
  }else{
     $content = preg_replace("/<img.*?>/si","",$str);
     return  strip_tags($content);  
  }
   
}


// 匹配获取所有图片的url
function get_images_url($str){

  if(preg_match_all('/src=[\'\"]?([^\'\"]*)[\'\"]?/i',$str,$arr)){
     return  $arr[1];
  }else{
    return false;
  }

}