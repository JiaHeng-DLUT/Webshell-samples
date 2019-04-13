<?php
require 'conn/conn.php';
require 'conn/function.php';

$action=$_GET["action"];
$files='|admin/ajax.php|admin/chat_test.php|admin/data.php|admin/dbm.php|admin/demo.php|admin/download.php|admin/fontpicker.php|admin/help.php|admin/index.php|admin/test.php|admin/tpl.php|admin/update2.php|alipay/alipay.config.php|alipay/alipayapi.php|alipay/index.php|alipay/lib/alipay_core.function.php|alipay/lib/alipay_md5.function.php|alipay/lib/alipay_notify.class.php|alipay/lib/alipay_submit.class.php|alipay/notify_url.php|alipay/return_url.php|api/index.php|api/notify.php|bank/callback1.php|bank/callback2.php|bank/callback3.php|bbs/bbs.php|bbs/index.php|bbs/item.php|bbs/list.php|booksave.php|buy.php|bank/api.php|conn/code_1.php|conn/code_2.php|conn/conn.php|conn/conn2.php|conn/function.php|conn/mobile.php|data/ajax.bas|data/data.bas|data/api.bas|data/function.bas|data/core.php|feed.php|form.php|index.php|install.php|js/like.php|js/pic.php|js/scms.php|ueditor/php/action_crawler.php|ueditor/php/action_list.php|ueditor/php/action_upload.php|ueditor/php/controller.php|ueditor/php/Uploader.class.php|mapload.php|member/auto.php|member/foot.php|member/index.php|member/invoice_add.php|member/invoice_list.php|member/left.php|member/member_check.php|member/member_edit.php|member/member_email.php|member/member_fenlist.php|member/member_form.php|member/member_found.php|member/member_gift.php|member/member_login.php|member/member_mobile.php|member/member_moneylist.php|member/member_news.php|member/member_newsinfo.php|member/member_order.php|member/member_pay.php|member/member_pay2.php|member/member_pwdedit.php|member/member_reg.php|member/member_role.php|member/member_setpwd.php|member/member_wuliu.php|member/OK.php|member/post.php|member/sendmail.php|member/sendmobile.php|member/top.php|member/unlogin.php|paypal/notify_url.php|paypal/notify_url2.php|qq/include.php|qq/qqlogin.php|qq/reg.php|repair.php|search.php|upload/upload.php|upload/update.php|wap_index.php|weixin/index.php|wxpay/jsapi.php|wxpay/login.php|wxpay/native.php|wxpay/notify_url.php|checkmm.php|';

function gl($name){
	$name=str_replace("\\","/",$name);
	return str_replace("data/..//","",$name);
}

function checkmm($a){
    global $files,$C_admin;
    if(strpos(strtolower($files),strtolower("|".str_replace($C_admin."/","admin/",$a)."|"))!==false){
        echo "<p style='color:#009900'>程序文件".$a."将会更新</p>";
    }else{
        echo "<p style='color:#ff0000'>疑似木马".$a."将会删除</p>";
    }
}

function delmm($a){
    global $files,$C_admin;
    if(strpos(strtolower($files),strtolower("|".str_replace($C_admin."/","admin/",$a)."|"))!==false){
        file_put_contents($a,file_get_contents("http://cdn.shanling.top/php/".str_replace($C_admin."/","admin/",$a).".txt"));
        echo "<p style='color:#009900'>程序文件".$a."更新成功！</p>";
    }else{
        unlink($a);
        echo "<p style='color:#ff9900'>疑似木马".$a."删除成功！</p>";
    }
}

function check($dir){
    if(!is_dir($dir)) return false;
    $handle = opendir($dir);
    if($handle){
        while(($fl = readdir($handle)) !== false){
            $temp = $dir.DIRECTORY_SEPARATOR.$fl;
            if(is_dir($temp) && $fl!='.' && $fl != '..'){
                check($temp);
            }else{
                if($fl!='.' && $fl != '..' && (substr($fl,-3)=="php" || substr($fl,-3)=="asp" || substr($fl,-3)=="bas") && substr($fl,-8)!="conn.php" && substr($fl,-9)!="conn2.php"){
                    checkmm(gl($temp));
                }
            }
        }
    }
}

function del($dir){
    if(!is_dir($dir)) return false;
    $handle = opendir($dir);
    if($handle){
        while(($fl = readdir($handle)) !== false){
            $temp = $dir.DIRECTORY_SEPARATOR.$fl;
            if(is_dir($temp) && $fl!='.' && $fl != '..'){
                del($temp);
            }else{
                if($fl!='.' && $fl != '..' && (substr($fl,-3)=="php" || substr($fl,-3)=="asp" || substr($fl,-3)=="bas") && substr($fl,-8)!="conn.php" && substr($fl,-9)!="conn2.php"){
                    delmm(gl($temp));
                }
            }
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>检测木马</title>
 <link rel="stylesheet" href="css/css/font-awesome.min.css" type="text/css" />
 <link rel="stylesheet" href="css/sweetalert.css" type="text/css" />
 <script src="js/jquery.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<style>
*{font-size: 12px;line-height: 170%;}
a {
  color: #363f44;
  text-decoration: none;
  cursor: pointer;
}
.add{background:#0099ff; color:#FFFFFF; border:#0099ff solid 1px; padding:2px 5px;-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius:5px; margin-top:5px;white-space:nowrap;}
.add:hover{background:#ffffff; color:#0099ff; }

.del{background:#ff9900; color:#FFFFFF; border:#ff9900 solid 1px; padding:2px 5px;-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius:5px; margin-top:5px;white-space:nowrap;}
.del:hover{background:#ffffff; color:#ff9900; }

p{font-size: 12px;margin:0px}
</style>
</head>
<body>
<?php if($action!="check" && $action!="del"){?>
<p>说明：清理木马的同时将删除非程序自带的PHP文件（非PHP文件将不会删除），请您提前做好备份工作。</p>
<a href="?action=check" onClick="swal({title: '',text: '耐心等待，请不要关闭页面',imageUrl: '<?php echo $C_admin?>/img/loading.gif',html: true,showConfirmButton: false});" class='add'><i class='fa fa-refresh'></i> 检测木马</a>

<?php }
if ($action=="check"){
echo "需要更新或删除的文件列表：<div style='height:500px; overflow:auto;background-color:#EEEEEE;padding:5px;margin-bottom:10px'>";
check('data/../');
echo "</div><p style='color:#ff0000;margin-bottom:10px;'>【如果有在线无法删除的顽固木马文件，请到FTP或服务器手动删除】</p>";
echo "<p><a href=\"?action=del\" onClick=\"swal({title: '',text: '耐心等待，请不要关闭页面',imageUrl: '".$C_admin."/img/loading.gif',html: true,showConfirmButton: false});\" class=\"add\"><i class=\"fa fa-refresh\"></i> 开始清理</a></p>";
}

if ($action=="del"){
echo "<div style='height:500px;overflow:auto;background-color:#EEEEEE;padding:5px;margin-bottom:10px'>";
del('data/../');
echo "</div><p style='color:#ff0000;margin-bottom:10px;'>【建议您再次检测一次木马文件，防止顽固木马无法删除】</p>";
echo "<p><a href=\"index.php\" target=\"_blank\" class=\"add\"><i class=\"fa fa-send\"></i> 进入首页</a> <a href=\"?action=check\" onClick=\"swal({title: '',text: '耐心等待，请不要关闭页面',imageUrl: '".$C_admin."/img/loading.gif',html: true,showConfirmButton: false});\" class=\"del\"><i class=\"fa fa-refresh\"></i> 再次检测</a></p>";
}

?>
</body>
</html>