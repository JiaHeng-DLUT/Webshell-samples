<?php 
require '../conn/conn2.php';
require '../conn/function.php';
$t1 = microtime(true);

$dir=str_replace("/", "\\",dirname(__FILE__));

if($_GET["action"]=="mod"){
  mysqli_query($conn,"update SL_config set C_admin='".splitx($dir,"\\",count(explode("\\",$dir))-1)."'");
  box("修复成功！","./","success");
}

if(splitx($dir,"\\",count(explode("\\",$dir))-1)!=$C_admin){
  die("后台目录出错！<a href='?action=mod'>点击此处</a>进行修复");
}

$action=$_GET["action"];

if($action!="update"){
    $version_info=trim(file_get_contents("version.txt"),"\xEF\xBB\xBF");
    $update=file_get_contents("http://cdn.shanling.top/php/update.txt");
    $update=str_replace("\r\n","",$update);
    $update=trim($update,"\xEF\xBB\xBF");
    $up_list=splitx($update,"|",1);
    $file_list=splitx($update,"|",2);
    $file_list2=splitx($update,"|",3);
    $md5_list=splitx($update,"|",5);
    $num=count(explode("@",$file_list));
    file_put_contents($dirx."update.txt",$file_list."|".$file_list2."|".$md5_list);
}

if($action=="md5"){
    $f=explode("@",$file_list2);
    for($i=0;$i<count($f);$i++){
        $md5=$md5.md5(trim(file_get_contents($dirx.$f[$i]),"\xEF\xBB\xBF"))."@";
    }
    $md5=substr($md5,0,strlen($md5)-1); 
    if($md5_list==$md5){
        die("md5一致，所有文件都已更新成功！");
    }else{
        die("md5不一致，部分文件未更新成功（检查是否开启了写入权限）！");
    }
}

if($action=="update"){
    $id=intval($_GET["id"]);

    $f1=splitx(splitx(file_get_contents($dirx."update.txt"),"|",0),"@",$id);
    $f2=splitx(splitx(file_get_contents($dirx."update.txt"),"|",1),"@",$id);
    $f3=splitx(splitx(file_get_contents($dirx."update.txt"),"|",2),"@",$id);

    if(!is_file($dirx.$f2)){
        $file_str=trim(file_get_contents("http://cdn.shanling.top/php/".$f1.".txt"),"\xEF\xBB\xBF");
        file_put_contents($dirx.$f2,$file_str);
        $t2 = microtime(true);
        die($f2."|1|".round($t2-$t1,3));
    }else{
        if($f3!=md5(trim(file_get_contents($dirx.$f2),"\xEF\xBB\xBF"))){
            $file_str=trim(file_get_contents("http://cdn.shanling.top/php/".$f1.".txt"),"\xEF\xBB\xBF");
            if(md5($file_str)!=md5(trim(file_get_contents($dirx.$f2),"\xEF\xBB\xBF"))){
                file_put_contents($dirx.$f2,$file_str);
                $t2 = microtime(true);
                die($f2."|1|".round($t2-$t1,3));
            }else{
                $t2 = microtime(true);
                die($f2."|0|".round($t2-$t1,3));
            }
        }else{
            $t2 = microtime(true);
            die($f2."|0|".round($t2-$t1,3));
        }
    }
}

if($action=="function"){
    @ready(trim(splitx($update,"|",4),"\xEF\xBB\xBF"));
    unlink($dirx."update.txt");
    die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站后台管理</title>
<link href="<?php echo $C_dir.$C_ico?>" rel="shortcut icon" />
<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="../css/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="../css/sweetalert.css" type="text/css" />
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/sweetalert.min.js"></script>
<style>
*{font-size: 12px;line-height: 170%;}
a {
  color: #363f44;
  text-decoration: none;
  cursor: pointer;
}
p{margin-bottom: 5px;}
</style>
<script>
window.$num=<?php echo $num?>;
window.$j=0;
window.filelist="<?php echo splitx(file_get_contents($dirx."update.txt"),"|",1)?>";


function md5(){
    $("#version").hide();
    $("#print").show();
    $("#log").show();
    $("#print").height($(window).height()-100);
    $.ajax({
            type: 'get',
            url: '?action=md5',
            success: function(data) {
                $("#print").html(data+"<br><a class='btn btn-xs btn-success' href=''><i class='fa fa-reply'></i> 返回</a>");
            }
        })
}

function updateall(i){

    $("#version").hide();
    $("#progressx").show();
    $("#print").show();
    $("#log").show();
    $("#print").height($(window).height()-100);

    $.ajax({
            type: 'get',
            url: '?action=update&id='+i,
            success: function(data) {

                $("#progress").attr("style","width: "+(((i+1)/$num)*100-1)+"%");
                $("#progress").html((((i+1)/$num)*100-1).toFixed(2)+"%");

                datax=data.split("|");
                if(datax[1]=="1"){
                    info="<p style='color:#ff9900'>更新文件 "+datax[0]+" 成功！耗时"+datax[2]+"秒</p>";
                }else{
                    info="<p style='color:#009900'>程序文件 "+datax[0]+" 无需更新！</p>";
                }
                $j=$j+Number(datax[1]);

                if(i==0){
                    $("#print").html(info);
                }else{
                    $("#print").html(info+$("#print").html());
                }
                
                if(i<$num-1){
                    updateall(i+1);
                }else{
                    $.get("?action=function", function(result){
                        $("#progress").attr("style","width: "+(((i+1)/$num)*100)+"%");
                        $("#progress").html((((i+1)/$num)*100).toFixed(2)+"%");
                        $t2=(new Date()).getTime();
                        $("#print").html("<p style='color:#0099ff;font-weight:bold;'>本次共更新"+$j+"个文件，耗时"+(($t2-$t1)/1000)+"秒，更新已完成，请重启浏览器！<button class='btn btn-xs btn-success' onClick='md5()'><i class='fa fa-key'></i> 校验md5</button></p>"+$("#print").html());
                    });
                }
            },
            error:function(data) {
                data="x|0|x";

                $("#progress").attr("style","width: "+(((i+1)/$num)*100-1)+"%");
                $("#progress").html((((i+1)/$num)*100-1).toFixed(2)+"%");

                datax=data.split("|");
                info="<p style='color:#ff0000'>更新文件 "+filelist.split("@")[i]+" 失败！[请检查目录是否存在]</p>";
                $j=$j+Number(datax[1]);

                if(i==0){
                    $("#print").html(info);
                }else{
                    $("#print").html(info+$("#print").html());
                }
                
                if(i<$num-1){
                    updateall(i+1);
                }else{
                    $.get("?action=function", function(result){
                        $t2=(new Date()).getTime();
                        $("#print").html("<p style='color:#0099ff;font-weight:bold;'>本次共更新"+$j+"个文件，耗时"+(($t2-$t1)/1000)+"秒，更新已完成，请重启浏览器！<button class='btn btn-xs btn-success' onClick='md5()'><i class='fa fa-key'></i> 校验md5</button></p>"+$("#print").html());
                    });
                }
            }
        })
}
</script>
</head>
<body style="padding: 10px;">
<div class="progress progress-striped active" style="display: none;margin-bottom: 10px" id="progressx">
    <div class="progress-bar progress-bar-success" role="progressbar"
         aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
         style="width: 0%;" id="progress">
    </div>
</div>

<p style="display: none" id="log">更新日志：</p>
<div id="print" class="form-control" style="margin-top:10px;display: none;background: #f7f7f7;overflow: auto;word-wrap:break-word">
</div>


<div id="version">
<p style="font-weight: bold;">当前版本号：<?php echo $version_info?></p>
<div style="width: 100%;height: 225px;overflow: auto;background: #EEEEEE;padding: 10px;">
<?php
echo $up_list;
?>
</div>
<div style="margin: 5px 0;font-weight: bold;">需要更新的文件列表：</div>
<div style="width: 100%;height: 225px;overflow: auto;background: #EEEEEE;padding: 10px;">
<?php
echo str_replace("@","<br>",$file_list);
?>
</div>
<?php 
if(splitx($update,"|",0)!=$version_info){
    echo "<p>更新过程请勿中断，如果遇到更新失败请联系客服寻求解决方案。</p><button class='btn btn-xs btn-success' onClick='window.\$t1=(new Date()).getTime();updateall(0);'><i class='fa fa-refresh'></i> 开始更新</button>";
}else{
    echo "<p>当前为最新版本，如有需要可强制更新。</p><button class='btn btn-xs btn-primary' onClick='window.\$t1=(new Date()).getTime();updateall(0);'><i class='fa fa-refresh'></i> 强制更新</button>";
}
?>
</div>
</body>﻿
</html>