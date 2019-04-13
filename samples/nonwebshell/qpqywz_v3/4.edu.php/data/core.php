<?php
Function CreateIndex($html){ //生成首页
global $conn,$C_dir;

$result = mysqli_query($conn, "select * from SL_menu where U_del=0 and U_type='index'");
$row = mysqli_fetch_assoc($result);
if($row["U_sub"]==0){
$U_id=$row["U_id"];
}else{
$U_id=$row["U_id"];
}
$U_bg=$row["U_bg"];
if ($html!="" && is_null($html)==false){
$HTMLCode=str_Replace("{@SL_菜单ID}",$U_id,$html);
if (is_file($C_dirx.$U_bg)){
$HTMLCode=str_Replace("{@SL_菜单背景}",$U_bg,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_菜单背景}","images/nobg.png",$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_页面标识}","index_0",$HTMLCode);
return $HTMLCode;
}
}

function CreateText($html,$S_id){  //生成简介页面
global $conn,$C_dir,$C_dirx,$C_7PID,$C_7PKEY,$C_7money,$C_ds1,$C_tp,$C_td,$C_html;
$sql="select * from SL_menu where U_del=0 and U_type like 'text' and U_typeid=".intval($S_id)." limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
    if($row["U_sub"]==0){
        $U_id=$row["U_id"];
    }else{
        $U_id=$row["U_sub"];
    }
    $U_bg=$row["U_bg"];
}

$sql="select * from SL_text where T_del=0 and T_id=".intval($S_id);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$T_id=$row["T_id"];
$T_keywords=lang($row["T_keywords"]);
$T_description=lang($row["T_description"]);
$T_pagetitle=lang($row["T_pagetitle"]);
$T_title=lang($row["T_title"]);
$T_entitle=lang($row["T_entitle"]);
$T_content=lang($row["T_content"])."<style>iframe{max-width:100% !important;}video{max-width:100% !important;}.text_content img{max-width:100% !important;}</style>";
$T_pic=$row["T_pic"];
}

if($html!="" && !is_null($html)){
$HTMLCode=str_Replace("{@SL_简介标题}",$T_title,$html);
if(is_null($T_pagetitle) || $T_pagetitle==""){
$HTMLCode=str_Replace("{@SL_简介页面标题}",$T_title,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_简介页面标题}",$T_pagetitle,$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_菜单ID}",$U_id,$HTMLCode);
if(is_file($C_dirx.$U_bg)){
$HTMLCode=str_Replace("{@SL_菜单背景}",$U_bg,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_菜单背景}","images/nobg.png",$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_页面标识}","text_".$T_id,$HTMLCode);
$HTMLCode=str_Replace("{@SL_简介英文标题}",$T_entitle,$HTMLCode);
if($C_ds1==1){
$T_content=$T_content."<div style=\"border-top:#DDDDDD solid 2px; margin:20px 0 0 0;\"></div><script src=\"//7-pay.cn/".$C_7PID.".js?type=btn&error=请到后台“基本设置”-“收款设置”检查7支付PID和Pkey是否填写正确！&money=".str_Replace("@","|",$C_7money)."&sign=".strtolower(md5($C_7PKEY.str_Replace("@","|",$C_7money)))."\"></script>";
}

if($C_td==1){
    $T_content=$T_content."<script type=\"text/javascript\" src=\"".$C_dir."js/like.php?id=t".$T_id."\"></script>";
}

if($C_tp==1){
$T_content=$T_content."<div style=\"border-top:#DDDDDD solid 2px; margin:20px 0;\"></div><div id=\"comments_box\"></div><script type=\"text/javascript\" src=\"".$C_dir."js/scms.php?action=comment&page=text_".$T_id."\"></script>";
}

$HTMLCode=str_Replace("{@SL_简介内容}","<div class=\"text_content\">".$T_content."</div>",$HTMLCode);
$HTMLCode=str_Replace("{@SL_简介ID}",$T_id,$HTMLCode);
$HTMLCode=str_Replace("{@SL_简介keywords}",$T_keywords,$HTMLCode);
$HTMLCode=str_Replace("{@SL_简介description}",$T_description,$HTMLCode);
if(is_file($C_dirx.$T_pic)){
$HTMLCode=str_Replace("{@SL_简介配图}",$T_pic,$HTMLCode);
$HTMLCode=str_Replace("{@SL_简介图片}",$T_pic,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_简介配图}","images/nopic.png",$HTMLCode);
$HTMLCode=str_Replace("{@SL_简介图片}","images/nopic.png",$HTMLCode);
}
if($C_html==1 && !WAPstr()){
$HTMLCode=str_Replace("{@SL_简介链接}",$C_dir.$_SESSION["e"]."html/about/".$T_id.".$html",$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_简介链接}",$C_index."?type=text&S_id=".$T_id,$HTMLCode);
}
$CreateText=$HTMLCode;
}
return $CreateText;
}

function CreateProductList($html,$xx,$page){  //生成产品列表页
global $conn,$C_dir,$C_dirx;

if($xx=="x" || $xx==""){
    $S_info="where S_id>0";
}else{
    $S_info="where S_id=".intval($xx);
}

$sql="select * from SL_psort ".$S_info." and S_del=0 and S_show=1 limit 1";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$S_idx=$row["S_id"];
$S_pic=$row["S_pic"];
$S_pagetitle=lang($row["S_pagetitle"]);
$S_keywords=lang($row["S_keywords"]);
$S_description=lang($row["S_description"]);
$S_title=lang($row["S_title"]);
$S_entitle=lang($row["S_entitle"]);
$S_sub=$row["S_sub"];
$S_type=$row["S_type"];
}

$sql="select * from SL_menu where U_del=0 and U_type='product' and U_typeid=".intval($S_idx);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
if($row["U_sub"]==0){
$U_id=$row["U_id"];
}else{
$U_id=$row["U_sub"];
}
$U_bg=$row["U_bg"];
}

if($xx=="x"){
$S_idx=0;
$S_type=1;
$S_title=lang("案例中心/l/Product");
$S_pagetitle=lang("案例中心/l/Product");
}else{
if($xx=="0" || $xx==""){
$S_idx=0;
$S_type=0;
$S_title=lang("产品中心/l/Product");
$S_pagetitle=lang("产品中心/l/Product");
}
}
if($html!="" && !is_null($html)){
$HTMLCode=str_Replace("{@SL_产品分类标题}",$S_title,$html);
if(is_null($S_pagetitle) || $S_pagetitle==""){
$HTMLCode=str_Replace("{@SL_产品分类页面标题}",$S_title,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_产品分类页面标题}",$S_pagetitle,$HTMLCode);
}

$HTMLCode=str_Replace("{@SL_菜单ID}",$U_id,$HTMLCode);
if(is_file($C_dirx.$U_bg)){
$HTMLCode=str_Replace("{@SL_菜单背景}",$U_bg,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_菜单背景}","images/nobg.png",$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_页面标识}","product_".$S_idx,$HTMLCode);
$HTMLCode=str_Replace("{@SL_产品分类英文标题}",$S_entitle,$HTMLCode);
$HTMLCode=str_Replace("{@SL_产品分类ID}",$S_idx,$HTMLCode);
$HTMLCode=str_Replace("{@SL_产品分类page}",$page,$HTMLCode);
if(is_file($C_dirx.$S_pic)){
$HTMLCode=str_Replace("{@SL_产品分类图片}",$S_pic,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_产品分类图片}","images/nopic.png",$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_产品分类type}",$S_type,$HTMLCode);
$HTMLCode=str_Replace("{@SL_产品分类keywords}",$S_keywords,$HTMLCode);
$HTMLCode=str_Replace("{@SL_产品分类description}",$S_description,$HTMLCode);
$CreateProductList=$HTMLCode;
}
return $CreateProductList;
}



function CreateProductInfo($html, $P_id) {  //生成产品内容页
    global $conn,$C_dir,$C_dirx,$C_index,$C_html,$C_ds3,$C_7PID,$C_7PKEY,$C_7money,$C_pp,$C_pd;
    $sql = "select * from SL_product,SL_psort where P_del=0 and S_del=0 and P_sort=S_id and P_id=" . intval($P_id) . " and S_show=1 order by P_order desc";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $P_idx = $row["P_id"];
        $P_title = lang($row["P_title"]);
        $P_content = lang($row["P_content"]) . "<style>iframe{max-width:100% !important;}video{max-width:100% !important;}.product_content img{max-width:100% !important;}</style>";
        $P_short = lang($row["P_short"]);
        $P_price = $row["P_price"];
        $P_rest = $row["P_rest"];
        $P_buy = $row["P_buy"];
        $P_unlogin = $row["P_unlogin"];
        $P_time = $row["P_time"];
        $P_pagetitle = lang($row["P_pagetitle"]);
        $P_keywords = lang($row["P_keywords"]);
        $P_description = lang($row["P_description"]);
        if ($row["P_path"] == "" || is_null($row["P_path"])) {
            $P_path = "media/";
        } else {
            $P_path = $row["P_path"];
        }
        $P_path = splitx(splitx($P_path, "|", 0) , "__", 0);
        $P_shuxing = $row["P_shuxing"];
        $P_name = $row["P_name"];
        $P_email = $row["P_email"];
        $P_address = $row["P_address"];
        $P_mobile = $row["P_mobile"];
        $P_postcode = $row["P_postcode"];
        $P_qq = $row["P_qq"];
        $P_remark = $row["P_remark"];
        if ($P_name == 1 || $P_email == 1 || $P_address == 1 || $P_mobile == 1 || $P_postcode == 1 || $P_qq == 1 || $P_remark == 1) {
            $P_contact = 1;
        } else {
            $P_contact = 0;
        }
        $S_title = lang($row["S_title"]);
        $S_entitle = lang($row["S_entitle"]);
        $S_id = $row["S_id"];
        $S_sub = $row["S_sub"];
        $S_type = $row["S_type"];
        $S_keywords = lang($row["S_keywords"]);
        $S_description = lang($row["S_description"]);
    }
    if ($S_sub != 0) {
        $sql = "select * from SL_psort where S_del=0 and S_id=" . intval($S_sub);
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $S_subtitle = lang($row["S_title"]);
            $S_subentitle = lang($row["S_entitle"]);
        }
    }
    if ($S_subtitle == "") {
        $S_subtitle = $S_title;
    }
    if ($S_subentitle == "") {
        $S_subentitle = $S_entitle;
    }
    $sql = "select * from SL_menu where U_del=0 and U_type='product' and U_typeid=" . intval($S_id);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        if ($row["U_sub"] == 0) {
            $U_id = $row["U_id"];
        } else {
            $U_id = $row["U_sub"];
        }
        $U_bg = $row["U_bg"];
    }
    $sql = "select * from SL_product where P_del=0 and P_sort=" . intval($S_id) . " order by P_order,P_id desc";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $Ne_list = $Ne_list . $row["P_id"] . ",";
        }
    }
    $Ne_list = ",0," . $Ne_list . "0,";
    $P_Nid = splitx(splitx($Ne_list, "," . $P_idx . ",", 1) , ",", 0);
    $P_Pid = splitx(splitx($Ne_list, "," . $P_idx . ",", 0) , ",", count(explode(",", splitx($Ne_list, "," . $P_idx . ",", 0)))-1);
    if ($P_Nid == "0") {
        $P_Ntitle = lang("没有了/l/None");
    } else {
        $P_Ntitle = lang(getrs("select * from SL_product where P_id=" . intval($P_Nid), "P_title"));
    }
    if ($P_Pid == "0") {
        $P_Ptitle = lang("没有了/l/None");
    } else {
        $P_Ptitle = lang(getrs("select * from SL_product where P_id=" . intval($P_Pid), "P_title"));
    };

    $SL_pic = "<iframe src='" . $C_dir . "js/pic.php?P_id=" . $P_idx . "' marginheight='0' marginwidth='0' frameborder='0' scrolling='no' width='100%' height='100%' id='iframepage' name='iframepage' onLoad='iFrameHeight()'></iframe>";
    $SL_pic=$SL_pic."<script type='text/javascript' language='javascript'>function iFrameHeight() {var ifm= document.getElementById('iframepage');var subWeb = document.frames ? document.frames['iframepage'].document :ifm.contentDocument;if(ifm != null && subWeb != null){ifm.height = subWeb.body.scrollHeight;}};window.timer = setInterval('iFrameHeight()', 500);</script>";

    if ($html != "" && !is_null($html)) {
        $HTMLCode = str_Replace("{@SL_产品分类标题}", $S_title, $html);
        $HTMLCode = str_Replace("{@SL_产品分类英文标题}", $S_entitle, $HTMLCode);
        $HTMLCode = str_Replace("{@SL_菜单ID}", $U_id, $HTMLCode);
        if (is_file($C_dirx . $U_bg)) {
            $HTMLCode = str_Replace("{@SL_菜单背景}", $U_bg, $HTMLCode);
        } else {
            $HTMLCode = str_Replace("{@SL_菜单背景}", "images/nobg.png", $HTMLCode);
        }
        $HTMLCode = str_Replace("{@SL_图片轮播}", $SL_pic, $HTMLCode);
        $HTMLCode = str_Replace("{@SL_页面标识}", "productinfo_" . $P_idx, $HTMLCode);
        $HTMLCode = str_Replace("{@SL_产品大分类}", $S_sub, $HTMLCode);
        $HTMLCode = str_Replace("{@SL_产品大分类标题}", $S_subtitle, $HTMLCode);
        $HTMLCode = str_Replace("{@SL_产品大分类英文标题}", $S_subentitle, $HTMLCode);
        if ($P_keywords == "" || $P_keywords == "未填" || is_null($P_keywords)) {
            $HTMLCode = str_Replace("{@SL_产品分类keywords}", $S_keywords, $HTMLCode);
        } else {
            $HTMLCode = str_Replace("{@SL_产品分类keywords}", $P_keywords, $HTMLCode);
        }
        if ($P_description == "" || $P_description == "未填" || is_null($P_description)) {
            $HTMLCode = str_Replace("{@SL_产品分类description}", $S_description, $HTMLCode);
        } else {
            $HTMLCode = str_Replace("{@SL_产品分类description}", $P_description, $HTMLCode);
        }
        $HTMLCode = str_Replace("{@SL_产品分类ID}", $S_id, $HTMLCode);
        $HTMLCode = str_Replace("{@SL_产品分类type}", $S_type, $HTMLCode);
        $HTMLCode = str_Replace("{@SL_产品标题}", $P_title, $HTMLCode);
        if (is_null($P_pagetitle) || $P_pagetitle == "") {
            $HTMLCode = str_Replace("{@SL_产品页面标题}", $P_title, $HTMLCode);
        } else {
            $HTMLCode = str_Replace("{@SL_产品页面标题}", $P_pagetitle, $HTMLCode);
        }
        $HTMLCode = str_Replace("{@SL_产品评论框}", "<div class=\"comments_box2\"></div><script type=\"text/javascript\" src=\"" . $C_dir . "js/scms.php?action=comment&page=productinfo_" . $P_idx . "\"></script>", $HTMLCode);
        $HTMLCode = str_Replace("{@SL_产品发布时间}", $P_time, $HTMLCode);
        $HTMLCode = str_Replace("{@SL_产品ID}", $P_idx, $HTMLCode);
        $HTMLCode = str_Replace("{@SL_产品价格}", round($P_price, 2) , $HTMLCode);
        if (is_file($C_dirx . $P_path)) {
            $HTMLCode = str_Replace("{@SL_产品大图}", $P_path, $HTMLCode);
            $HTMLCode = str_Replace("{@SL_产品小图}", $P_path, $HTMLCode);
        } else {
            $HTMLCode = str_Replace("{@SL_产品大图}", "images/nopic.png", $HTMLCode);
            $HTMLCode = str_Replace("{@SL_产品小图}", "images/nopic.png", $HTMLCode);
        }
        if ($C_ds3 == 1) {
            $P_content = $P_content . "<div style=\"border-top:#DDDDDD solid 2px; margin:20px 0 0 0;\"></div><script src=\"//7-pay.cn/" . $C_7PID . ".js?type=btn&error=请到后台“基本设置”-“收款设置”检查7支付PID和Pkey是否填写正确！&money=" . str_replace("@", "|", $C_7money) . "&sign=" . strtolower(md5($C_7PKEY . str_replace("@", "|", $C_7money))) . "\"></script>";
        }

        if ($C_pd==1){
            $P_content=$P_content."<script type=\"text/javascript\" src=\"".$C_dir."js/like.php?id=p".$P_idx."\"></script>";
        }

        if ($C_pp == 1) {
            $P_content = $P_content . "<div style=\"border-top:#DDDDDD solid 2px; margin:20px 0;\"></div><div id=\"comments_box\"></div><script type=\"text/javascript\" src=\"" . $C_dir . "js/scms.php?action=comment&page=productinfo_" . $P_idx . "\"></script>";
        }
        
        $HTMLCode = str_Replace("{@SL_产品内容}", "<div class=\"product_content\">".$P_content."</div>", $HTMLCode);
        $HTMLCode = str_Replace("{@SL_产品简述}", $P_short, $HTMLCode);
            if (is_null($P_shuxing)) {
                $P_shuxing = "";
            }
            $P_js = "<script src='" . $C_dir . "js/buy.js'></script><link rel='stylesheet' href='" . $C_dir . "css/buy.css'><script>\$(function() { \$('label').click(function(){var aa = \$(this).attr('aa');\$('[aa=\"'+aa+'\"]').removeAttr('class') ;\$(this).attr('class','checked');});});</script><script>function check(){";
            $shuxing = explode("@",$P_shuxing);
            if($P_shuxing!=""){
                for ($j = 0; $j < count($shuxing); $j++) {
                    $sc = explode("|", splitx($shuxing[$j], "_", 1));

                    for ($i = 0; $i < count($sc); $i++) {
                        if ($i < count($sc)-1) {
                            $pd = $pd . "\$('#" . $j . "_" . $i . "').get(0).checked||";
                        } else {
                            $pd = $pd . "\$('#" . $j . "_" . $i . "').get(0).checked";
                        }
                    }
                    if ($pd != "") {
                        $P_js = $P_js . "if(" . $pd . "){}else{alert('请选择商品属性');return false;}" . PHP_EOL;
                        $pd = "";
                    }
                }
            }

            $P_js = $P_js . "}</script>";
            $P_js = $P_js . "<script>function shuaxin(){";
            $shuxing = explode("@", $P_shuxing);
            if($P_shuxing!=""){
                for ($j = 0; $j < count($shuxing); $j++) {
                    $sc = explode("|",splitx($shuxing[$j], "_", 1) );
                    $sp = explode("|",splitx($shuxing[$j], "_", 2) );
                    for ($i = 0; $i < count($sc); $i++) {

                        $P_js=$P_js."if(\$('#".$j."_".$i."').get(0).checked){sp".$j."=".$sp[$i]."};".PHP_EOL;

                    }
                }
            }
            $P_js = $P_js . " \$('#price').html((";
            $P_js = $P_js . $P_price;
            $shuxing = explode("@", $P_shuxing);
            if($P_shuxing!=""){
                for ($j = 0; $j < count($shuxing); $j++) {
                    $P_js = $P_js . "+sp" . $j;
                }
            }
            $P_js = $P_js . ").toFixed(2));";
            $P_js = $P_js . " \$('#P_price').val(";
            $P_js = $P_js . $P_price;
            $shuxing = explode("@", $P_shuxing);
            if($P_shuxing!=""){
                for ($j = 0; $j < count($shuxing); $j++) {
                    $P_js = $P_js . "+sp" . $j;
                }
            }

            $P_js = $P_js . ")}</script>";
            $P_sc = $P_sc . "<b>" . lang("价格/l/Price") . "：</b> " . lang("/l/￥") . "<span id='price' style='font-size:20px;color:#ff0000;'>" . round($P_price, 2) . "</span> " . lang("元/l/") . "<br>";
            $shuxing = explode("@", $P_shuxing);
            $P_sc = $P_sc . "<form action='" . $C_dir . "buy.php?action=input' id='buy' method='post'>";
            if($P_shuxing!=""){
                for ($j = 0; $j < count($shuxing); $j++) {
                    if ($shuxing[$j] != "__") {
                        $P_sc = $P_sc . "<b>" . lang(splitx($shuxing[$j], "_", 0)) . "</b> ";
                        $P_sc2 = $P_sc2 . "<b>" . lang(splitx($shuxing[$j], "_", 0)) . "</b> ";
                        $sc = explode("|", splitx($shuxing[$j], "_", 1));
                        for ($i = 0; $i < count($sc); $i++) {
                            $P_sc = $P_sc . "<input type='radio' name='scvvvvv_" . $j . "' id='" . $j . "_" . $i . "' value='" . $i . "' onchange='shuaxin()' > <label for='" . $j . "_" . $i . "' aa='scvvvvv_" . $j . "' style='line-height:150%;'>" . lang($sc[$i]) . "</label> ";
                            $P_sc2 = $P_sc2 . lang($sc[$i]) . " / ";
                        }
                        $P_sc = $P_sc . "<br>";
                        $P_sc2 = substr($P_sc2, 0, strlen($P_sc2) - 2);
                        $P_sc2 = $P_sc2 . "<br>";
                    }
                }
            }
            $P_sc=$P_sc."<b>".lang("购买数量/l/Amount")."：</b><input type='button' class='add' value='-' onClick='javascript:if(this.form.amount.value>=2){this.form.amount.value--;}'><input type='text' name='no' value='1' id='amount' ><input type='button' class='add' value='+' id='plus' onClick='javascript:if(this.form.amount.value<=".($P_rest-1)."){this.form.amount.value++;}'>（".lang("库存/l/rest")."：".$P_rest.lang("件/l/")."）<br>";

            $P_sc = $P_sc . "<input type='hidden' name='P_id' value='" . $P_idx . "'><input type='hidden' name='P_price' id='P_price' value=''>";
            if ($P_unlogin == 1) {
                $P_sc = $P_sc . "<input type='submit' value='" . lang("免登录购买/l/Buy Now") . "' onClick='return check()' class='buy'> <input type='button' value='" . lang("加入购物车/l/Add to Cart") . "' onClick='addcart(\$(\"#buy\").serialize(),\"".$C_dir."\")' class='cart'></form><script>$(\"#buy\").attr(\"action\",\"".$dir."member/unlogin.php\")</script>";
            } else {
                $P_sc = $P_sc . "<input type='submit' value='" . lang("立即购买/l/Buy Now") . "' onClick='return check()' class='buy'> <input type='button' value='" . lang("加入购物车/l/Add to Cart") . "' onClick='addcart(\$(\"#buy\").serialize(),\"".$C_dir."\")' class='cart'></form>";
            }
        
        if ($P_buy == 1) {
            $HTMLCode = str_Replace("{@SL_产品购买}", $P_js . $P_sc, $HTMLCode);
        } else {
            if ($P_sc2 == "") {
                $HTMLCode = str_Replace("{@SL_产品购买}", $P_short, $HTMLCode);
            } else {
                $HTMLCode = str_Replace("{@SL_产品购买}", $P_sc2, $HTMLCode);
            }
        }
        $HTMLCode = str_Replace("{@SL_产品下一个标题}", $P_Ntitle, $HTMLCode);
        $HTMLCode = str_Replace("{@SL_产品上一个标题}", $P_Ptitle, $HTMLCode);
        if ($C_html == 1 && !WAPstr()) {
            $HTMLCode = str_Replace("{@SL_产品分类链接}", $C_dir . $_SESSION["e"] . "html/product/list-" . $S_id . ".html", $HTMLCode);
        } else {
            $HTMLCode = str_Replace("{@SL_产品分类链接}", $C_index . "?type=product&S_id=" . $S_id, $HTMLCode);
        }
        if ($P_Pid !== "0") {
            if ($C_html == 1 && !WAPstr()) {
                $HTMLCode = str_Replace("{@SL_产品上一个链接}", $C_dir . $_SESSION["e"] . "html/product/" . $P_Pid . ".html", $HTMLCode);
            } else {
                $HTMLCode = str_Replace("{@SL_产品上一个链接}", $C_index . "?type=productinfo&S_id=" . $P_Pid, $HTMLCode);
            }
        } else {
            $HTMLCode = str_Replace("{@SL_产品上一个链接}", "javascript:;", $HTMLCode);
        }
        if ($P_Nid !== "0") {
            if ($C_html == 1 && !WAPstr()) {
                $HTMLCode = str_Replace("{@SL_产品下一个链接}", $C_dir . $_SESSION["e"] . "html/product/" . $P_Nid . ".html", $HTMLCode);
            } else {
                $HTMLCode = str_Replace("{@SL_产品下一个链接}", $C_index . "?type=productinfo&S_id=" . $P_Nid, $HTMLCode);
            }
        } else {
            $HTMLCode = str_Replace("{@SL_产品下一个链接}", "javascript:;", $HTMLCode);
        }
        $CreateProductInfo = $HTMLCode;
    }
    return $CreateProductInfo;
}

function CreateNewsList($html,$xx,$page){  //生成新闻列表页
global $conn,$C_dir,$C_index,$C_html,$C_nsorttitle,$C_nsortentitle;
$xx=URLDecode($xx);
if($xx=="" || strpos($xx,"tag:")!==false || strpos($xx,"author:")!==false || strpos($xx,"date:")!==false || strpos($xx,"type:")!==false){
$S_info=" where S_id>0";
}else{
$S_info=" where S_id=".intval($xx);
}
$sql="select * from SL_nsort ".$S_info." and S_del=0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$S_idx=$row["S_id"];
$S_pagetitle=lang($row["S_pagetitle"]);
$S_keywords=lang($row["S_keywords"]);
$S_description=lang($row["S_description"]);
$S_title=lang($row["S_title"]);
$S_entitle=lang($row["S_entitle"]);
$S_sub=$row["S_sub"];
$S_type=$row["S_type"];
}

$sql="select * from SL_menu where U_del=0 and U_type='news' and U_typeid=".intval($S_idx);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
if($row["U_sub"]==0){
$U_id=$row["U_id"];
}else{
$U_id=$row["U_sub"];
}
$U_bg=$row["U_bg"];
}
if($xx=="" || $xx=="0"){
$S_idx=0;
$S_title=lang($C_nsorttitle);
$S_entitle=lang($C_nsortentitle);
$S_pagetitle=lang($C_nsorttitle);
}
if(strpos($xx,"tag:")!==false){
$S_idx=$xx;
$S_title=lang("标签：".splitx($xx,":",1)."/l/tag:".splitx($xx,":",1));
$S_entitle=lang("tag：".splitx($xx,":",1)."/l/tag:".splitx($xx,":",1));
$S_pagetitle=lang("标签：".splitx($xx,":",1)."/l/tag:".splitx($xx,":",1));
}
if(strpos($xx,"author:")!==false){
$S_idx=$xx;
$S_title=lang("作者：".splitx($xx,":",1)."/l/author:".splitx($xx,":",1));
$S_entitle=lang("Author：".splitx($xx,":",1)."/l/author:".splitx($xx,":",1));
$S_pagetitle=lang("作者：".splitx($xx,":",1)."/l/author:".splitx($xx,":",1));
}
if(strpos($xx,"date:")!==false){
$S_idx=$xx;
$S_title=lang("日期：".splitx($xx,":",1)."/l/date:".splitx($xx,":",1));
$S_entitle=lang("Date：".splitx($xx,":",1)."/l/date:".splitx($xx,":",1));
$S_pagetitle=lang("日期：".splitx($xx,":",1)."/l/date:".splitx($xx,":",1));
}
if(strpos($xx,"type:")!==false){
switch(splitx($xx,":",1)){

case "news":
$S_type="新闻";
break;
case "job":
$S_type="招聘";
break;
case "download":
$S_type="下载";
break;
case "video":
$S_type="视频";
break;
case "notice":
$S_type="公告";
break;
case "team":
$S_type="团队";
break;
default:
$S_type="新闻";
}
$S_idx=$xx;
$S_title=lang("类型：".$S_type."/l/type:".splitx($xx,":",1));
$S_entitle=lang("Type：".splitx($xx,":",1)."/l/type:".splitx($xx,":",1));
$S_pagetitle=lang("类型：".$S_type."/l/type:".splitx($xx,":",1));
}
if($html!="" and !is_null($html)){
$HTMLCode=str_Replace("{@SL_新闻分类标题}",$S_title,$html);
if(is_null($S_pagetitle) || $S_pagetitle==""){
$HTMLCode=str_Replace("{@SL_新闻分类页面标题}",$S_title,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_新闻分类页面标题}",$S_pagetitle,$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_菜单ID}",$U_id,$HTMLCode);
if(is_file($C_dirx.$U_bg)){
$HTMLCode=str_Replace("{@SL_菜单背景}",$U_bg,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_菜单背景}","images/nobg.png",$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_页面标识}","news_".$S_idx,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻分类英文标题}",$S_entitle,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻分类ID}",$S_idx,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻分类page}",$page,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻分类keywords}",$S_keywords,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻分类description}",$S_description,$HTMLCode);
if($C_html==1 && !WAPstr()){
$HTMLCode=str_Replace("{@SL_新闻分类链接}",$C_dir.$_SESSION["e"]."html/news/list-".$S_idx.".html",$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_新闻分类链接}",$C_index."?type=news&S_id=".$S_idx,$HTMLCode);
}
$CreateNewsList=$HTMLCode;
}
return $CreateNewsList;
}


function CreateNewsInfo($html,$N_id){  //生成新闻内容页
global $conn,$C_dir,$C_dirx,$C_index,$C_html,$C_sort,$C_7PKEY,$C_7PID,$C_np,$C_nd,$C_ds2,$C_7money;
$sql="select * from SL_news,SL_nsort where N_del=0 and S_del=0 and N_sort=S_id and N_id=".intval($N_id)." and S_show=1 and N_sh=0 order by N_id desc";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$N_idx=$row["N_id"];
$N_order=$row["N_order"];
$N_title=lang($row["N_title"]);
$N_content=lang($row["N_content"])."<style>iframe{max-width:100% !important;}video{max-width:100% !important;}.news_content img{max-width:100% !important;}</style>";
$N_short=lang($row["N_short"]);
$N_date=$row["N_date"];
$N_author=$row["N_author"];
$N_view=$row["N_view"];
$N_sort=$row["N_sort"];
$N_pagetitle=lang($row["N_pagetitle"]);
$N_keywords=lang($row["N_keywords"]);
$N_description=lang($row["N_description"]);
$S_title=lang($row["S_title"]);
$S_entitle=lang($row["S_entitle"]);
$S_id=$row["S_id"];
$S_keywords=lang($row["S_keywords"]);
$S_description=lang($row["S_description"]);
$N_pic=$row["N_pic"];
$N_like=$row["N_like"];
$N_type=$row["N_type"];
$N_job=$row["N_job"];
$N_jobname=$row["N_jobname"];
$N_video=$row["N_video"];
$N_file=$row["N_file"];
$N_team=$row["N_team"];
$N_teamid=$row["N_teamid"];
$N_teaminfo=$row["N_teaminfo"];
$N_hideon=$row["N_hideon"];
$N_hidetype=$row["N_hidetype"];
$N_hideintro=$row["N_hideintro"];
$N_hide=$row["N_hide"];
$N_price=$row["N_price"];
$N_tag=$row["N_tag"];
}

if($N_job=="" || is_null($N_job)){
$N_job="||||||||";
}
if($N_jobname=="" || is_null($N_jobname)){
$N_jobname="@@@@@@@@@";
}
if($N_file=="" || is_null($N_file)){
$N_file="|||||";
}
if($N_team=="" || is_null($N_team)){
$N_team="|||||";
}
$job=explode("|",$N_job);
$jobname=explode("@",$N_jobname);
$file=explode("|",$N_file);
$team=explode("|",$N_team);
$sql="select * from SL_menu where U_del=0 and U_type='news' and U_typeid=".intval($S_id);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
if($row["U_sub"]==0){
$U_id=$row["U_id"];
}else{
$U_id=$row["U_sub"];
}
$U_bg=$row["U_bg"];
}

$sql="select * from SL_news where N_del=0 and N_sort=".intval($S_id)." and N_sh=0 order by N_order,N_id desc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$Ne_list=$Ne_list.$row["N_id"].",";
}
}
$Ne_list=",0,".$Ne_list."0,";

$N_Nid=splitx(splitx($Ne_list,",".$N_idx.",",1),",",0);
$N_Pid=splitx(splitx($Ne_list,",".$N_idx.",",0),",",count(explode(",",splitx($Ne_list,",".$N_idx.",",0)))-1);

if($N_Nid=="0"){
$N_Ntitle=lang("没有了/l/None");
}else{
$N_Ntitle=lang(getrs("select * from SL_news where N_del=0 and N_sh=0 and N_id=".intval($N_Nid),"N_title"));
}
if($N_Pid=="0"){
$N_Ptitle=lang("没有了/l/None");
}else{
$N_Ptitle=lang(getrs("select * from SL_news where N_del=0 and N_sh=0 and N_id=".intval($N_Pid),"N_title"));
}
if($html!="" && !is_null($html)){
$HTMLCode=str_Replace("{@SL_新闻分类标题}",$S_title,$html);
$HTMLCode=str_Replace("{@SL_新闻分类英文标题}",$S_entitle,$HTMLCode);
$HTMLCode=str_Replace("{@SL_菜单ID}",$U_id,$HTMLCode);
if(is_file($C_dirx.$U_bg)){
$HTMLCode=str_Replace("{@SL_菜单背景}",$U_bg,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_菜单背景}","images/nobg.png",$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_页面标识}","newsinfo_".$N_idx,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻分类ID}",$S_id,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻ID}",$N_idx,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻标题}",$N_title,$HTMLCode);
if(is_null($N_pagetitle) || $N_pagetitle==""){
$HTMLCode=str_Replace("{@SL_新闻页面标题}",$N_title,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_新闻页面标题}",$N_pagetitle,$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_新闻评论框}","<div class=\"comments_box2\"></div><script type=\"text/javascript\" src=\"".$C_dir."js/scms.php?action=comment&page=newsinfo_".$N_idx."\"></script>",$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻作者}",$N_author,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻发表日期}",$N_date,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻发表日}",date("d",strtotime($N_date)),$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻发表月}",date("m",strtotime($N_date)),$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻发表年}",date("Y",strtotime($N_date)),$HTMLCode);
if($N_keywords=="" || $N_keywords=="未填" || is_null($N_keywords)){
$HTMLCode=str_Replace("{@SL_新闻分类keywords}",$S_keywords,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_新闻分类keywords}",$N_keywords,$HTMLCode);
}
if($N_description=="" || $N_description=="未填" || is_null($N_description)){
$HTMLCode=str_Replace("{@SL_新闻分类description}",$S_description,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_新闻分类description}",$N_description,$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_新闻点赞量}",$N_like,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻浏览量}","<script type='text/javascript' language='javascript' src='".$C_dir."js/scms.php?action=newsview&N_id=".$N_idx."'></script><span id='view'></span><iframe onload='view_add()' style='display:none'></iframe>",$HTMLCode);
if(is_file($C_dirx.$N_pic)){
$HTMLCode=str_Replace("{@SL_新闻配图}",$N_pic,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻图片}",$N_pic,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_新闻配图}","images/nopic.png",$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻图片}","images/nopic.png",$HTMLCode);
}
if($C_sort==2){
$tag=explode(",",$N_tag);
for ($i=1 ;$i< count($tag)-1;$i++){
$N_content=str_Replace($tag[$i],"<a href=\"".$C_dir."?type=news&S_id=tag:".$tag[$i]."\">".$tag[$i]."</a>",$N_content);
}
}
if($N_hideon==1){
if($N_price=="0"){
$N_content=$N_content."<div class='hide_news'><div class='hide_title'><span>隐藏内容</span></div><b>".$N_hideintro."：</b><br>".$N_hide."</div>";
}else{
$goods=getbody("https://7-pay.cn/encode/index.asp","str=".$N_hide."&pkey=".$C_7PKEY);
if(strpos($N_price,"|")==0){
$N_content=$N_content."<div class='hide_news'><div class='hide_title'><span>隐藏内容</span></div><div id='hide_content'>".$N_hideintro."：<script src=\"//7-pay.cn/".$C_7PID.".js?type=".$N_hidetype."&sence=1&title=".lang("该隐藏内容需要购买/l/The hidden content needs to be purchased")."&content=".lang("支付完成后自动显示隐藏内容/l/Show hidden content automatically after payment has been completed")."&goods=".$goods."&error=".lang("请到后台“基本设置”-“收款设置”检查7支付PID和Pkey是否填写正确！/l/Please check your 7pay PID and PKEY")."&money=".$N_price."&sign=".strtolower(md5($C_7PKEY.$N_price))."&lang=".lang("cn/l/en/l/tw")."\"></script></div></div>";
}else{
$N_content=$N_content."<div class='hide_news'><div class='hide_title'><span>隐藏内容</span></div><div id='hide_content'>".$N_hideintro."：<script src=\"//7-pay.cn/".$C_7PID.".js?type=".$N_hidetype."&sence=0&title=".lang("打赏任意金额即可获取隐藏内容/l/Reward any amount for hidden content")."&content=".lang("打赏完成后自动显示/l/Show automatically after reward")."&goods=".$goods."&error=".lang("请到后台“基本设置”-“收款设置”检查7支付PID和Pkey是否填写正确！/l/Please check your 7pay PID and PKEY")."&money=".$N_price."&sign=".strtolower(md5($C_7PKEY.$N_price))."&lang=".lang("cn/l/en/l/tw")."\"></script></div></div>";
}
}
$N_content=$N_content."<script src=\"".$C_dir."js/scms.php?action=hide&N_id=".$N_idx."\"></script>";
}
if($C_ds2==1){
$N_content=$N_content."<div style=\"border-top:#DDDDDD solid 2px; margin:20px 0 0 0;\"></div><script src=\"//7-pay.cn/".$C_7PID.".js?type=btn&sence=0&error=".lang("请到后台“基本设置”-“收款设置”检查7支付PID和Pkey是否填写正确！/l/Please check your 7pay PID and PKEY")."&money=".str_Replace("@","|",$C_7money)."&sign=".strtolower(md5($C_7PKEY.str_replace("@","|",$C_7money)))."\"></script>";
}

if ($C_nd==1){
    $N_content=$N_content."<script type=\"text/javascript\" src=\"".$C_dir."js/like.php?id=n".$N_idx."\"></script>";
}

if($C_np==1){
$N_content=$N_content."<div style=\"border-top:#DDDDDD solid 2px; margin:20px 0;\"></div><div id=\"comments_box\"></div><script type=\"text/javascript\" src=\"".$C_dir."js/scms.php?action=comment&page=newsinfo_".$N_idx."\"></script>";
}


$css_info="<link rel=\"stylesheet\" type=\"text/css\" href=\"".$C_dir."css/new.css\" />";
$job_info="<div class=\"wrapx\"><table border=1 bordercolor=\"#EEEEEE\" cellspacing=0 frame=\"hsides\" rules=\"rows\" cellpadding=0 class=\"news_tab\"><tr><td><b>".lang($jobname[0])."：</b>".$job[0]."</td><td><b>".lang($jobname[1])."：</b>".$job[1]."</td><td><b>".lang($jobname[2])."：</b>".$job[2]."</td></tr><tr><td><b>".lang($jobname[3])."：</b>".$job[3]."</td><td><b>".lang($jobname[4])."：</b>".$job[4]."</td><td><b>".lang($jobname[5])."：</b>".$job[5]."</td></tr><tr><td><b>".lang($jobname[6])."：</b>".$job[6]."</td><td><b>".lang($jobname[7])."：</b>".$job[7]."</td><td><b>".lang($jobname[8])."：</b>".$job[8]."</td></tr></table></div>";
$file_info="<div class=\"wrapx\"><table border=1 bordercolor=\"#EEEEEE\" cellspacing=0 frame=\"hsides\" rules=\"rows\" cellpadding=0 class=\"news_tab\"><tr><td><b>".lang("文件名称/l/File Name")."：</b>".$file[0]."</td><td><b>".lang("文件大小/l/Size")."：</b>".$file[1]."</td><td><b>".lang("版本号/l/version")."：</b>".$file[2]."</td></tr><tr><td><b>".lang("语言/l/Code")."：</b>".$file[3]."</td><td><b>".lang("运行环境/l/Environmenta")."：</b>".$file[4]."</td><td><b>".lang("下载地址/l/Download")."：</b><a class=\"download\" href=\"".$C_dir."js/scms.php?action=download&N_id=".$N_idx."\" target=\"_blank\">".lang("点击下载/l/Download")."</a></td></tr></table></div>";
if($N_teaminfo==0){
$team_info="<div class=\"wrapx\"><table border=1 bordercolor=\"#EEEEEE\" cellspacing=0 frame=\"hsides\" rules=\"rows\" cellpadding=0 class=\"news_tab\"><tr><td rowspan=\"5\" width=\"50%\"><img src=\"".$C_dir.$N_pic."\" style=\"border:solid 1px #DDDDDD;padding:5px;background:#ffffff;\"></td><td><b style=\"font-size:20px;\">".$N_title."<b></td></tr><tr><td><b>".lang("职位/l/Job")."：</b>".$team[0]."</td></tr><tr><td><b>".lang("年龄/l/Age")."：</b>".$team[1]."</td></tr><tr><td><b>".lang("部门/l/department")."：</b>".$team[2]."</td></tr><tr><td><b>".lang("学历/l/Education")."：</b>".$team[3]."</td></tr></table></div>";
}else{
$team_info="<div>".getrs("select * from SL_member where M_id=".intval($N_teamid),"M_info")."</div>";
}
if(strpos($N_video,"<")!==false){
$video_info=$N_video;
}else{
if(substr($N_video,0,5)=="media"){
$video_info="<video width=\"100%\" height=\"500\" controls><source src=\"".$C_dir.$N_video."\" type=\"video/mp4\">您的浏览器不支持 video 标签。</video>";
}else{
$video_info="<video width=\"100%\" height=\"500\" controls><source src=\"".$N_video."\" type=\"video/mp4\">您的浏览器不支持 video 标签。</video>";
}
}

$N_content="<div class=\"news_content\">".$N_content."</div>";
switch($N_type){
case 0:
$HTMLCode=str_Replace("{@SL_新闻内容}",$css_info.$N_content,$HTMLCode);
break;
case 1:
$HTMLCode=str_Replace("{@SL_新闻内容}",$css_info.$job_info.$N_content,$HTMLCode);
break;
case 2:
$HTMLCode=str_Replace("{@SL_新闻内容}",$css_info.$file_info.$N_content,$HTMLCode);
break;
case 3:
$HTMLCode=str_Replace("{@SL_新闻内容}",$css_info.$video_info."<br>".$N_content,$HTMLCode);
break;
case 5:
$HTMLCode=str_Replace("{@SL_新闻内容}",$css_info.$team_info.$N_content,$HTMLCode);
default:
$HTMLCode=str_Replace("{@SL_新闻内容}",$css_info.$N_content,$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_新闻简述}",$N_short,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻下一篇标题}",$N_Ntitle,$HTMLCode);
$HTMLCode=str_Replace("{@SL_新闻上一篇标题}",$N_Ptitle,$HTMLCode);
if($C_html==1 && !WAPstr()){
$HTMLCode=str_Replace("{@SL_新闻分类链接}",$C_dir.$_SESSION["e"]."html/news/list-".$S_id.".html",$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_新闻分类链接}",$C_index."?type=news&S_id=".$S_id,$HTMLCode);
}
if($N_Pid!="0"){
if($C_html==1 && !WAPstr()){
$HTMLCode=str_Replace("{@SL_新闻上一篇链接}",$C_dir.$_SESSION["e"]."html/news/".$N_Pid.".html",$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_新闻上一篇链接}",$C_index."?type=newsinfo&S_id=".$N_Pid,$HTMLCode);
}
}else{
$HTMLCode=str_Replace("{@SL_新闻上一篇链接}","javascript:;",$HTMLCode);
}
if($N_Nid!="0"){
if($C_html==1 && !WAPstr()){
$HTMLCode=str_Replace("{@SL_新闻下一篇链接}",$C_dir.$_SESSION["e"]."html/news/".$N_Nid.".html",$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_新闻下一篇链接}",$C_index."?type=newsinfo&S_id=".$N_Nid,$HTMLCode);
}
}else{
$HTMLCode=str_Replace("{@SL_新闻下一篇链接}","javascript:;",$HTMLCode);
}
$CreateNewsInfo=$HTMLCode;
}
return $CreateNewsInfo;
}

function Createform($html,$S_id){  //生成表单页面
global $conn,$C_dir,$C_dirx,$C_index,$C_html;
$sql="select * from SL_form where F_del=0 and F_id=".intval($S_id);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$F_title=lang($row["F_title"]);
$F_pic=$row["F_pic"];
$F_entitle=lang($row["F_entitle"]);
$F_id=$row["F_id"];
$F_pagetitle=lang($row["F_pagetitle"]);
$F_keywords=lang($row["F_keywords"]);
$F_description=lang($row["F_description"]);
}
$sql="select * from SL_menu where U_del=0 and U_type='form' and U_typeid=".intval($S_id);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
if($row["U_sub"]==0){
$U_id=$row["U_id"];
}else{
$U_id=$row["U_sub"];
}
$U_bg=$row["U_bg"];
}

$SL_form="<iframe src='".$C_dir."form.php?S_id=".$S_id."' marginheight='0' marginwidth='0' frameborder='0' scrolling='no' width='100%' height='100%' id='iframepage' name='iframepage' onLoad='iFrameHeight()' style='width:100%;max-width:800px;'></iframe>";
$SL_form=$SL_form."<script type='text/javascript' language='javascript'>function iFrameHeight() {var ifm= document.getElementById('iframepage');var subWeb = document.frames ? document.frames['iframepage'].document :ifm.contentDocument;if(ifm != null && subWeb != null){ifm.height = subWeb.body.scrollHeight;}}</script>";


if($html!="" && !is_null($html)){
$HTMLCode=str_Replace("{@SL_表单内容}",$SL_form,$html);
$HTMLCode=str_Replace("{@SL_菜单ID}",$U_id,$HTMLCode);
if(is_file($C_dirx.$U_bg)){
$HTMLCode=str_Replace("{@SL_菜单背景}",$U_bg,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_菜单背景}","images/nobg.png",$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_页面标识}","form_".$F_id,$HTMLCode);
$HTMLCode=str_Replace("{@SL_表单ID}",$F_id,$HTMLCode);
$HTMLCode=str_Replace("{@SL_表单keywords}",$F_keywords,$HTMLCode);
$HTMLCode=str_Replace("{@SL_表单description}",$F_description,$HTMLCode);
$HTMLCode=str_Replace("{@SL_表单标题}",$F_title,$HTMLCode);
if(is_null($F_pagetitle) || $F_pagetitle==""){
$HTMLCode=str_Replace("{@SL_表单页面标题}",$F_title,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_表单页面标题}",$F_pagetitle,$HTMLCode);
}
if(is_file($C_dirx.$F_pic)){
$HTMLCode=str_Replace("{@SL_表单配图}",$F_pic,$HTMLCode);
$HTMLCode=str_Replace("{@SL_表单图片}",$F_pic,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_表单配图}","images/nopic.png",$HTMLCode);
$HTMLCode=str_Replace("{@SL_表单图片}","images/nopic.png",$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_表单英文标题}",$F_entitle,$HTMLCode);
if($C_html==1 && !WAPstr()){
$HTMLCode=str_Replace("{@SL_表单链接}",$C_dir.$_SESSION["e"]."html/form/".$F_id.".html",$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_表单链接}",$C_index."?type=form&S_id=".$F_id,$HTMLCode);
}
$Createform=$HTMLCode;
}
return $Createform;
}


function CreateContact($html){  //生成联系页面
global $conn,$C_dirx,$C_html,$C_description,$C_keywords;
$sql="select * from SL_contact limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$C_title=lang($row["C_title"]);
$C_entitle=lang($row["C_entitle"]);
$C_content=lang($row["C_content"]);
$C_address=lang($row["C_address"]);
$C_zb=$row["C_zb"];
$Co_keywords=lang($row["C_keywords"]);
$Co_description=lang($row["C_description"]);
$sql="select * from SL_menu where U_del=0 and U_type='contact'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
if($row["U_sub"]==0){
$U_id=$row["U_id"];
}else{
$U_id=$row["U_sub"];
}
$U_bg=$row["U_bg"];
}
if($html!="" && !is_null($html)){
$HTMLCode=str_Replace("{@SL_联系标题}",$C_title,$html);
$HTMLCode=str_Replace("{@SL_菜单ID}",$U_id,$HTMLCode);
if(is_file($C_dirx.$U_bg)){
$HTMLCode=str_Replace("{@SL_菜单背景}",$U_bg,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_菜单背景}","images/nobg.png",$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_页面标识}","contact_0",$HTMLCode);
$HTMLCode=str_Replace("{@SL_联系英文标题}",$C_entitle,$HTMLCode);
$HTMLCode=str_Replace("{@SL_联系方式}",$C_content,$HTMLCode);
$HTMLCode=str_Replace("{@SL_地图地址}",$C_address,$HTMLCode);
$HTMLCode=str_Replace("{@SL_地图坐标}",$C_zb,$HTMLCode);
if($Co_keywords=="" || $Co_keywords=="未填" || is_null($Co_keywords)){
$HTMLCode=str_Replace("{@SL_网站关键字}",$C_keywords,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_网站关键字}",$Co_keywords,$HTMLCode);
}
if($Co_description=="" || $Co_description=="未填" || is_null($Co_description)){
$HTMLCode=str_Replace("{@SL_网站描述}",lang($C_description),$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_网站描述}",lang($Co_description),$HTMLCode);
}
if($C_html==1 && !WAPstr()){
$HTMLCode=str_Replace("{@SL_联系链接}",$C_dir.$_SESSION["e"]."html/contact/index.$html",$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_联系链接}",$C_index."?type=contact",$HTMLCode);
}
$CreateContact=$HTMLCode;
}
return $CreateContact;
}


function CreateGuestbook($html){  //生成留言页面
    global $conn,$C_dirx;
$sql="select * from SL_menu where U_del=0 and U_type='guestbook'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
if($row["U_sub"]==0){
$U_id=$row["U_id"];
}else{
$U_id=$row["U_sub"];
}
$U_bg=$row["U_bg"];
}
if($html!="" && !is_null($html)){
$HTMLCode=str_Replace("{@SL_菜单ID}",$U_id,$html);
if(is_file($C_dirx.$U_bg)){
$HTMLCode=str_Replace("{@SL_菜单背景}",$U_bg,$HTMLCode);
}else{
$HTMLCode=str_Replace("{@SL_菜单背景}","images/nobg.png",$HTMLCode);
}
$HTMLCode=str_Replace("{@SL_页面标识}","guestbook_0",$HTMLCode);
$CreateGuestbook=$HTMLCode;
}
return $CreateGuestbook;
}

function newsp($style,$S_id){
global $conn,$C_dir,$C_dirx,$C_html,$C_index;
if($S_id==0){
$S_info=" and S_sub=0";
}else{
$S_info=" and S_id=".intval($S_id);
}
$i=0;
$sql="select * from SL_nsort where S_del=0 and S_id>0 ".$S_info." and S_show=1 order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("&i&",$i,$style);
$style2=str_Replace("&j&",$i+1,$style2);
if(is_file($C_dirx.$row["S_pic"])){
$style2=str_Replace("&新闻分类图片&",$row["S_pic"],$style2);
}else{
$style2=str_Replace("&新闻分类图片&","images/nopic.png",$style2);
}
$style2=str_Replace("&新闻分类ID&",$row["S_id"],$style2);
$style2=str_Replace("&新闻分类标题&",lang($row["S_title"]),$style2);
$style2=str_Replace("&新闻分类英文标题&",lang($row["S_entitle"]),$style2);
if($C_html==1 and !WAPstr()){
    $style2=str_Replace("&新闻分类链接&",$C_dir.$_SESSION["e"]."html/new/list-".$row["S_id"].".html",$style2);
}else{
    $style2=str_Replace("&新闻分类链接&",$C_index."?type=news&S_id=".$row["S_id"],$style2);
}
if($S_id==0){
$sql2="select * from SL_nsort where S_del=0 and S_sub=".$row["S_id"]." and S_show=1 order by S_order,S_id desc";
$result2 = mysqli_query($conn, $sql2);

if(mysqli_num_rows($result2) > 0) {
while($row2 = mysqli_fetch_assoc($result2)) {
$S_a=$S_a.$row2["S_id"]."|";
}
}
$S_a=$S_a."-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|";
$style2=str_Replace("&a&",splitx($S_a,"|",0),$style2);
$style2=str_Replace("&b&",splitx($S_a,"|",1),$style2);
$style2=str_Replace("&c&",splitx($S_a,"|",2),$style2);
$style2=str_Replace("&d&",splitx($S_a,"|",3),$style2);
$style2=str_Replace("&e&",splitx($S_a,"|",4),$style2);
$style2=str_Replace("&f&",splitx($S_a,"|",5),$style2);
$style2=str_Replace("&g&",splitx($S_a,"|",6),$style2);
$style2=str_Replace("&h&",splitx($S_a,"|",7),$style2);
$style2=str_Replace("&i&",splitx($S_a,"|",8),$style2);
$style2=str_Replace("&j&",splitx($S_a,"|",9),$style2);
$style2=str_Replace("&k&",splitx($S_a,"|",10),$style2);
$style2=str_Replace("&l&",splitx($S_a,"|",11),$style2);
$style2=str_Replace("&m&",splitx($S_a,"|",12),$style2);
$style2=str_Replace("&n&",splitx($S_a,"|",13),$style2);
$style2=str_Replace("&o&",splitx($S_a,"|",14),$style2);
}
$S_a="";
$i=$i+1;
$newsp=$newsp.$style2;
}
}
$newsp=str_Replace("，",",",$newsp);
return $newsp;
}


function productp($style,$S_id){
global $conn,$C_dir,$C_dirx,$C_html,$C_index;
if($S_id==0){
$S_info=" and S_sub=0 and S_type=0";
}else{
$S_info=" and S_id=".intval($S_id)." and S_type=0";
}
$i=0;
$sql="select * from SL_psort where S_del=0 and S_id>0 ".$S_info." and S_show=1 order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("&i&",$i,$style);
$style2=str_Replace("&j&",$i+1,$style2);
if(is_file($C_dirx.$row["S_pic"])){
$style2=str_Replace("&产品分类图片&",$row["S_pic"],$style2);
}else{
$style2=str_Replace("&产品分类图片&","images/nopic.png",$style2);
}
$style2=str_Replace("&产品分类ID&",$row["S_id"],$style2);
$style2=str_Replace("&产品分类标题&",lang($row["S_title"]),$style2);
$style2=str_Replace("&产品分类英文标题&",lang($row["S_entitle"]),$style2);
if($C_html==1 and !WAPstr()){
$style2=str_Replace("&产品分类链接&",$C_dir.$_SESSION["e"]."html/product/list-".$row["S_id"].".html",$style2);
}else{
$style2=str_Replace("&产品分类链接&",$C_index."?type=product&S_id=".$row["S_id"],$style2);
}
if($S_id==0){
$sql2="select * from SL_psort where S_del=0 and S_sub=".$row["S_id"]." and S_show=1 order by S_order,S_id desc";
$result2 = mysqli_query($conn, $sql2);

if(mysqli_num_rows($result2) > 0) {
while($row2 = mysqli_fetch_assoc($result2)) {
$S_a=$S_a.$row2["S_id"]."|";
}
}
$S_a=$S_a."-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|-1|";
$style2=str_Replace("&a&",splitx($S_a,"|",0),$style2);
$style2=str_Replace("&b&",splitx($S_a,"|",1),$style2);
$style2=str_Replace("&c&",splitx($S_a,"|",2),$style2);
$style2=str_Replace("&d&",splitx($S_a,"|",3),$style2);
$style2=str_Replace("&e&",splitx($S_a,"|",4),$style2);
$style2=str_Replace("&f&",splitx($S_a,"|",5),$style2);
$style2=str_Replace("&g&",splitx($S_a,"|",6),$style2);
$style2=str_Replace("&h&",splitx($S_a,"|",7),$style2);
$style2=str_Replace("&i&",splitx($S_a,"|",8),$style2);
$style2=str_Replace("&j&",splitx($S_a,"|",9),$style2);
$style2=str_Replace("&k&",splitx($S_a,"|",10),$style2);
$style2=str_Replace("&l&",splitx($S_a,"|",11),$style2);
$style2=str_Replace("&m&",splitx($S_a,"|",12),$style2);
$style2=str_Replace("&n&",splitx($S_a,"|",13),$style2);
$style2=str_Replace("&o&",splitx($S_a,"|",14),$style2);
}
$S_a="";
$i=$i+1;
$productp=$productp.$style2;
}
}
$productp=str_Replace("，",",",$productp);
return $productp;
}

Function getslide($style){   //获取幻灯列表
global $conn,$C_dir,$C_dirx,$C_index,$C_html;
$result = mysqli_query($conn,"select * from SL_slide where S_del=0 order by S_order,S_id desc");
if (mysqli_num_rows($result) > 0) {
$i=1;
while($row = mysqli_fetch_assoc($result)) {
        if(is_file($C_dirx.$row["S_pic"])){
            $style2=str_Replace("%图片路径%",$row["S_pic"],$style);
            $style2=str_Replace("%幻灯图片%",$row["S_pic"],$style2);
        }else{
            $style2=str_Replace("%图片路径%","images/nopic.png",$style);
            $style2=str_Replace("%幻灯图片%","images/nopic.png",$style2);
        }

        $style2=str_Replace("%幻灯ID%",$row["S_id"],$style2);
        $style2=str_Replace("%幻灯标题%",lang($row["S_title"]),$style2);
        $style2=str_Replace("%幻灯描述%",lang($row["S_content"]),$style2);
        $style2=str_Replace("%幻灯链接%",$row["S_link"],$style2);
        $style2=str_Replace("%i%",$i,$style2);
        $style2=str_Replace("%j%",$i-1,$style2);
        $getslide=$getslide.$style2;
        $i+=1;
    }
} 

$getslide=str_Replace("，",",",$getslide);
return $getslide;
}


function bread($style,$typex,$id){   //获取面包屑导航
global $conn,$C_title,$C_dir,$C_dirx,$C_html,$C_index;
if (!is_Numeric($id)){

$idx=explode(":",$id);

switch($idx[0]){
case "tag":
$bread=str_replace("%面包屑标题%",lang("标签：".$idx[1]."/l/tag:".$idx[1].""),$style);
break;
case "author":
$bread=str_replace("%面包屑标题%",lang("作者：".$idx[1]."/l/author:".$idx[1].""),$style);
break;
case "date":
$bread=str_replace("%面包屑标题%",lang("日期：".$idx[1]."/l/date:".$idx[1].""),$style);
break;
case "type":
switch($idx[1]){
case "news":
$bread=str_replace("%面包屑标题%",lang("类型：新闻/l/type:news"),$style);
break;
case "job":
$bread=str_replace("%面包屑标题%",lang("类型：招聘/l/type:job"),$style);
break;
case "download":
$bread=str_replace("%面包屑标题%",lang("类型：下载/l/type:download"),$style);
break;
case "video":
$bread=str_replace("%面包屑标题%",lang("类型：视频/l/type:video"),$style);
break;
case "notice":
$bread=str_replace("%面包屑标题%",lang("类型：公告/l/type:notice"),$style);
break;
default:
$bread=str_replace("%面包屑标题%",lang("类型：新闻/l/type:news"),$style);
}
}
}


switch($typex){
case "text":
$title=lang(getrs("select * from SL_text where T_id=".intval($id),"T_title"));
$style2=str_replace("%面包屑标题%",$title,$style);
$style2=str_replace("%面包屑链接%","",$style2);
break;
case "form":
$title=lang(getrs("select *  from SL_form where F_id=".intval($id),"F_title"));
$style2=str_replace("%面包屑标题%",$title,$style);
$style2=str_replace("%面包屑链接%","",$style2);
break;
case "contact":
$style2=str_replace("%面包屑标题%",lang($C_title),$style);
$style2=str_replace("%面包屑链接%","",$style2);
break;
case "guestbook":
$style2=str_replace("%面包屑标题%",lang("在线留言/l/Guestbook"),$style);
$style2=str_replace("%面包屑链接%","",$style2);
break;
case "nsort":
$title=lang(getrs("select * from SL_nsort where S_id=".intval($id),"S_title"));
$S_sub=getrs("select * from SL_nsort where S_id=".intval($id),"S_sub");
$style2=str_replace("%面包屑标题%",$title,$style);
$style2=str_replace("%面包屑链接%","",$style2);

if ($S_sub!=0){
$title2=lang(getrs("select * from SL_nsort where S_id=".intval($S_sub),"S_title"));
$style3=str_replace("%面包屑标题%",$title2,$style);
if ($C_html==1 && !WAPstr()){
$style3=str_replace("%面包屑链接%",$C_dir.$_SESSION["e"]."html/news/list-".$S_sub.".html",$style3);
}else{
$style3=str_replace("%面包屑链接%",$C_index."?type=news&S_id=".$S_sub,$style3);
}
$style2=$style3.$style2;
}
break;
case "psort":
$title=lang(getrs("select * from SL_psort where S_id=".intval($id),"S_title"));
$S_sub=getrs("select * from SL_psort where S_id=".intval($id),"S_sub");
$style2=str_replace("%面包屑标题%",$title,$style);
$style2=str_replace("%面包屑链接%","",$style2);
if ($S_sub!=0){
$title2=lang(getrs("select * from SL_psort where S_id=".intval($S_sub),"S_title"));
$style3=str_replace("%面包屑标题%",$title2,$style);
if ($C_html==1 && !WAPstr()){
$style3=str_replace("%面包屑链接%",$C_dir.$_SESSION["e"]."html/product/list-".$S_sub.".html",$style3);
}else{
$style3=str_replace("%面包屑链接%",$C_index."?type=product&S_id=".$S_sub,$style3);
}
$style2=$style3.$style2;
}
break;
case "news":
$title=lang(getrs("select * from SL_news where N_sh=0 and N_id=".intval($id),"N_title"));
$N_sort=getrs("select * from SL_news where N_sh=0 and N_id=".intval($id),"N_sort");
$style2=str_replace("%面包屑标题%",$title,$style);
$style2=str_replace("%面包屑链接%","",$style2);
$title2=lang(getrs("select * from SL_nsort where S_id=".intval($N_sort),"S_title"));
$S_sub=getrs("select * from SL_nsort where S_id=".intval($N_sort),"S_sub");
$style3=str_replace("%面包屑标题%",$title2,$style);
if ($C_html==1 && !WAPstr()){
$style3=str_replace("%面包屑链接%",$C_dir.$_SESSION["e"]."html/news/list-".$N_sort.".html",$style3);
}else{
$style3=str_replace("%面包屑链接%",$C_index."?type=news&S_id=".$N_sort,$style3);
}
$style2=$style3.$style2;
if ($S_sub!=0){
$title3=lang(getrs("select * from SL_nsort where S_id=".intval($S_sub),"S_title"));
$style4=str_replace("%面包屑标题%",$title3,$style);
if ($C_html==1 && !WAPstr()){
$style4=str_replace("%面包屑链接%",$C_dir.$_SESSION["e"]."html/news/list-".$S_sub.".html",$style4);
}else{
$style4=str_replace("%面包屑链接%",$C_index."?type=news&S_id=".$S_sub,$style4);
}
$style2=$style4.$style2;
}
break;
case "product":
$title=lang(getrs("select * from SL_product where P_id=".intval($id),"P_title"));
$P_sort=getrs("select * from SL_product where P_id=".intval($id),"P_sort");
$style2=str_replace("%面包屑标题%",$title,$style);
$style2=str_replace("%面包屑链接%","",$style2);
$title2=lang(getrs("select * from SL_psort where S_id=".intval($P_sort),"S_title"));
$S_sub=getrs("select * from SL_psort where S_id=".intval($P_sort),"S_sub");
$style3=str_replace("%面包屑标题%",$title2,$style);
if ($C_html==1 && !WAPstr()){
$style3=str_replace("%面包屑链接%",$C_dir.$_SESSION["e"]."html/product/list-".$P_sort.".html",$style3);
}else{
$style3=str_replace("%面包屑链接%",$C_index."?type=product&S_id=".$P_sort,$style3);
}
$style2=$style3.$style2;
if ($S_sub!=0){
$title3=lang(getrs("select * from SL_psort where S_id=".intval($S_sub),"S_title"));
$style4=str_replace("%面包屑标题%",$title3,$style);
if ($C_html==1 && !WAPstr()){
$style4=str_replace("%面包屑链接%",$C_dir.$_SESSION["e"]."html/product/list-".$S_sub.".html",$style4);
}else{
$style4=str_replace("%面包屑链接%",$C_index."?type=product&S_id=".$S_sub,$style4);
}
$style2=$style4.$style2;
}
}
$bread=str_replace("，",",",$style2);
return $bread;
}


function getwapslide($style){   //获取手机版幻灯列表
global $conn,$C_dirx;
$i=1;
$sql="select * from SL_wapslide order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
if(is_file($C_dirx.$row["S_pic"])){
$style2=str_Replace("%图片路径%",$row["S_pic"],$style);
$style2=str_Replace("%幻灯图片%",$row["S_pic"],$style2);
}else{
$style2=str_Replace("%图片路径%","images/nopic.png",$style);
$style2=str_Replace("%幻灯图片%","images/nopic.png",$style2);
}
$style2=str_Replace("%幻灯ID%",$row["S_id"],$style2);
$style2=str_Replace("%幻灯链接%",$row["S_link"],$style2);
$style2=str_Replace("%幻灯标题%",lang($row["S_title"]),$style2);
$style2=str_Replace("%幻灯描述%",lang($row["S_content"]),$style2);
$style2=str_Replace("%i%",$i,$style2);
$getwapslide=$getwapslide.$style2;
$i=$i+1;
}
}
$getwapslide=str_Replace("，",",",$getwapslide);
return $getwapslide;
}

function left_list($style,$U_id){   //获取左侧列表
global $conn,$C_dir,$C_logo,$C_html,$C_index;
if($U_id==""){
$left_list="";
}

$sql="select * from SL_menu where U_id=".intval($U_id);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$U_sub=$row["U_sub"];
}else{
$left_list="";
}
if($U_sub!=0){
$sql="select * from SL_menu where U_del=0 and U_sub=".$U_sub." and not U_sub=0 and U_hide=0 order by U_order";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("%左侧标题%",lang($row["U_title"]),$style);
if($row["U_type"]=="link" || ($row["U_url"]!="" && $row["U_url"]!="|" && !is_null($row["U_url"]))){

if(strpos($row["U_url"],"|")===false){
$url=$row["U_url"];
$target="blank";
}else{
$url=splitx($row["U_url"],"|",0);
$target=splitx($row["U_url"],"|",1);
}

$style2=str_Replace("%左侧链接%",$url."\" target=\"".$target."",$style2);
}else{
if($C_html==1 && !WAPstr()){
switch($row["U_type"]){

case "index":
$style2=str_Replace("%左侧链接%",$C_dir,$style2);
break;
case "text":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/about/".$row["U_typeid"].".html",$style2);
break;
case "product":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/product/list-".$row["U_typeid"].".html",$style2);
break;
case "news":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/news/list-".$row["U_typeid"].".html",$style2);
break;
case "form":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/form/".$row["U_typeid"].".html",$style2);
break;
case "contact":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/contact/index.html",$style2);
break;
case "guestbook":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/guestbook/index.html",$style2);
break;
}
}else{
$style2=str_Replace("%左侧链接%",$C_index."?type=".$row["U_type"]."&S_id=".$row["U_typeid"],$style2);
}
}
switch($row["U_type"]){

case "index":
$style2=str_Replace("%左侧图片%",$C_logo,$style2);
break;
case "text":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_text where T_id=".$row["U_typeid"],"T_pic"),$style2);
break;
case "product":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_psort where S_id=".$row["U_typeid"],"S_pic"),$style2);
break;
case "news":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_nsort where S_id=".$row["U_typeid"],"S_pic"),$style2);
break;
case "form":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_form where F_id=".$row["U_typeid"],"F_pic"),$style2);
break;
case "contact":
$style2=str_Replace("%左侧图片%",$C_logo,$style2);
break;
case "guestbook":
$style2=str_Replace("%左侧图片%",$C_logo,$style2);
break;
}
$style2=str_Replace("%左侧ID%",$row["U_id"],$style2);
$style2=str_Replace("%左侧type%",$row["U_type"],$style2);
$style2=str_Replace("%左侧typeID%",$row["U_typeid"],$style2);
$left_list=$left_list.$style2;
$style2="";
}
}
}else{
$sql="select * from SL_menu where U_del=0 and U_sub=".intval($U_id)." and not U_sub=0 and U_hide=0 order by U_order";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("%左侧标题%",lang($row["U_title"]),$style);
if($row["U_type"]=="link" || ($row["U_url"]!="" && $row["U_url"]!="|" && !is_null($row["U_url"]))){

if(strpos($row["U_url"],"|")===false){
$url=$row["U_url"];
$target="blank";
}else{
$url=splitx($row["U_url"],"|",0);
$target=splitx($row["U_url"],"|",1);
}

$style2=str_Replace("%左侧链接%",$url."\" target=\"".$target."",$style2);
}else{
if($C_html==1 && !WAPstr()){
switch($row["U_type"]){

case "index":
$style2=str_Replace("%左侧链接%",$C_dir,$style2);
break;
case "text":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/about/".$row["U_typeid"].".html",$style2);
break;
case "product":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/product/list-".$row["U_typeid"].".html",$style2);
break;
case "productinfo":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/product/".$row["U_typeid"].".html",$style2);
break;
case "news":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/news/list-".$row["U_typeid"].".html",$style2);
break;
case "newsinfo":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/news/".$row["U_typeid"].".html",$style2);
break;
case "form":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/form/".$row["U_typeid"].".html",$style2);
break;
case "contact":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/contact/index.html",$style2);
break;
case "guestbook":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/guestbook/index.html",$style2);
break;
}
}else{
$style2=str_Replace("%左侧链接%",$C_index."?type=".$row["U_type"]."&S_id=".$row["U_typeid"],$style2);
}
}
switch($row["U_type"]){

case "index":
$style2=str_Replace("%左侧图片%",$C_logo,$style2);
break;
case "text":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_text where T_id=".$row["U_typeid"],"T_pic"),$style2);
break;
case "product":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_psort where S_id=".$row["U_typeid"],"S_pic"),$style2);
break;
case "news":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_nsort where S_id=".$row["U_typeid"],"S_pic"),$style2);
break;
case "form":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_form where F_id=".$row["U_typeid"],"F_pic"),$style2);
break;
case "contact":
$style2=str_Replace("%左侧图片%",$C_logo,$style2);
break;
case "guestbook":
$style2=str_Replace("%左侧图片%",$C_logo,$style2);
break;
}
$style2=str_Replace("%左侧ID%",$row["U_id"],$style2);
$style2=str_Replace("%左侧type%",$row["U_type"],$style2);
$style2=str_Replace("%左侧typeID%",$row["U_typeid"],$style2);
$left_list=$left_list.$style2;
$style2="";
}
}else{
$sql2="select * from SL_menu where U_id=".intval($U_id)." and U_hide=0 order by U_order";
$result2 = mysqli_query($conn, $sql2);
if(mysqli_num_rows($result2) > 0) {
$style2=str_Replace("%左侧标题%",lang($row2["U_title"]),$style);
if($row2["U_type"]=="link" || ($row2["U_url"]!="" && $row2["U_url"]!="|" && !is_null($row2["U_url"]))){

if(strpos($row2["U_url"],"|")===false){
$url=$row2["U_url"];
$target="blank";
}else{
$url=splitx($row2["U_url"],"|",0);
$target=splitx($row2["U_url"],"|",1);
}

$style2=str_Replace("%左侧链接%",$url."\" target=\"".$target."",$style2);
}else{
if($C_html==1 && !WAPstr()){
switch($row2["U_type"]){

case "index":
$style2=str_Replace("%左侧链接%",$C_dir,$style2);
break;
case "text":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/about/".$row2["U_typeid"].".html",$style2);
break;
case "product":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/product/list-".$row2["U_typeid"].".html",$style2);
break;
case "productinfo":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/product/".$row2["U_typeid"].".html",$style2);
break;
case "news":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/news/list-".$row2["U_typeid"].".html",$style2);
break;
case "newsinfo":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/news/".$row2["U_typeid"].".html",$style2);
break;
case "form":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/form/".$row2["U_typeid"].".html",$style2);
break;
case "contact":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/contact/index.html",$style2);
break;
case "guestbook":
$style2=str_Replace("%左侧链接%",$C_dir.$_SESSION["e"]."html/guestbook/index.html",$style2);
break;
}
}else{
$style2=str_Replace("%左侧链接%",$C_index."?type=".$row2["U_type"]."&S_id=".$row2["U_typeid"],$style2);
}
}
switch($row2["U_type"]){

case "index":
$style2=str_Replace("%左侧图片%",$C_logo,$style2);
break;
case "text":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_text where T_id=".$row2["U_typeid"],"T_pic"),$style2);
break;
case "product":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_psort where S_id=".$row2["U_typeid"],"S_pic"),$style2);
break;
case "news":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_nsort where S_id=".$row2["U_typeid"],"S_pic"),$style2);
break;
case "form":
$style2=str_Replace("%左侧图片%",getrs("select * from SL_form where F_id=".$row2["U_typeid"],"F_pic"),$style2);
break;
case "contact":
$style2=str_Replace("%左侧图片%",$C_logo,$style2);
break;
case "guestbook":
$style2=str_Replace("%左侧图片%",$C_logo,$style2);
break;
}
$style2=str_Replace("%左侧ID%",$row2["U_id"],$style2);
$style2=str_Replace("%左侧type%",$row2["U_type"],$style2);
$style2=str_Replace("%左侧typeID%",$row2["U_typeid"],$style2);
$left_list=$left_list.$style2;
$style2="";
}
}
}
$left_list=str_Replace("，",",",$left_list);
return $left_list;
}

function comment_list($style){   //获取评论列表
    global $conn,$C_dir;

    $sql="select * from SL_comment where C_sh=1 order by C_id desc";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $style2=str_Replace("%评论内容%",$row["C_content"],$style);
            $style2=str_Replace("%评论时间%",$row["C_time"],$style2);
            $style2=str_Replace("%用户名称%",getrs("select * from SL_member where M_id=".$row["C_mid"],"M_login"),$style2);
            $M_pic=getrs("select * from SL_member where M_id=".$row["C_mid"],"M_pic");
            if (substr($M_pic,0,4)!="http"){
            $M_pic="media/".$M_pic;
            }
            $style2=str_Replace("%用户头像%",$M_pic,$style2);
            $comment_list=$comment_list.$style2;
        }
    } else {
            $comment_list="";
    }
    $comment_list=str_replace("，",",",$comment_list);
    return $comment_list;
}




function hotwords($style){   //获取搜索热词
global $C_hotwords;

$hotword=explode(",",lang($C_hotwords));
For($j = 0 ;$j< count($hotword);$j++){
$style2=str_Replace("%搜索热词%",$hotword[$j],$style);
$hotwords=$hotwords.$style2;
}
$hotwords=str_Replace("，",",",$hotwords);
return $hotwords;
}


function member($style,$style2){   //获取会员登录
global $C_member,$C_dir;
if($C_member==1){
$member="<script src=\"".$C_dir."js/scms.php?action=member&str=".urlencode($style)."|".urlencode($style2)."\"></script>";
}else{
$member="";
}
return $member;
}

function tag_list($style,$N_id){   //获取标签列表
global $C_tag,$C_dir;
if ($N_id=0){
$N_tag=",".$C_tag.",";
}else{
$N_tag=getrs("select * from SL_news where N_sh=0 and N_id=".intval($N_id),"N_tag");

if ($N_tag=="" || $N_tag==",," || is_null($N_tag)){
$tag_list=lang("暂无/l/none");
}
}
$tag=explode(",",$N_tag);
$j=1;

foreach($tag as $value){
$style2=str_Replace("%标签名称%",$tag[$j],$style);
$style2=str_Replace("%标签链接%",$C_dir."?type=news&S_id=tag:".$tag[$j],$style2);
$style2=str_Replace("%i%",$j-1,$style2);
$style2=str_Replace("%j%",$j,$style2);
$tag_list=$tag_list.$style2;
}

$tag_list=str_Replace("，",",",$tag_list);
return $tag_list;
}



function pic_list($style,$P_id){   //获取产品图列表
global $C_dirx;
$pic=getrs("select * from SL_product where P_id=".intval($P_id),"P_path");
$P_pic=explode("|",$pic);
For($j = 0 ;$j< count($P_pic);$j++){
if(is_file($C_dirx.splitx($P_pic[$j],"__",0))){
$style2=str_Replace("%产品图片%",splitx($P_pic[$j],"__",0),$style);
}else{
$style2=str_Replace("%产品图片%","images/nopic.png",$style);
}
if(strpos($pic,"__")!==false){
$style2=str_Replace("%图片描述%",splitx($P_pic[$j],"__",1),$style2);
}else{
$style2=str_Replace("%图片描述%","",$style2);
}
$style2=str_Replace("%i%",$j,$style2);
$pic_list=$pic_list.$style2;
}
$pic_list=str_Replace("，",",",$pic_list);
return $pic_list;
}


function qq_list($style,$qtype){   //获取客服列表
global $C_qq;
$qq=explode(",",lang($C_qq));
For($j = 0;$j< count($qq);$j++){
if($qtype=="qq"){
if(Is_Numeric(splitx($qq[$j],"|",0))){
$style2=str_Replace("%号码%",splitx($qq[$j],"|",0),$style);
$style2=str_Replace("%职务%",splitx($qq[$j],"|",1),$style2);
$qq_list=$qq_list.$style2;
}
}
if($qtype=="ww"){
if(!Is_Numeric(splitx($qq[$j],"|",0))){
$style2=str_Replace("%号码%",splitx($qq[$j],"|",0),$style);
$style2=str_Replace("%职务%",splitx($qq[$j],"|",1),$style2);
$qq_list=$qq_list.$style2;
}
}
}
$qq_list=str_Replace("，",",",$qq_list);
return $qq_list;
}

function getpage2($page_type, $xx, $num) { //获取新闻、产品分页
    global $conn, $C_npage, $C_ppage, $C_dir, $C_html;
    if (strpos($xx, "|") !== false) {
        $S_type = splitx($xx, "|", 1);
    } else {
        $S_type = 0;
    }
    if ($S_type == "") {
        $S_type = 0;
    }
    $xx = splitx($xx, "|", 0);
    $S_page = splitx($num, "|", 1);
    $num = splitx($num, "|", 0);
    if ($S_page == "") {
        $S_page = 1;
    }

    if ($page_type == "news") {
        if (strpos($xx, "tag:") === false && strpos($xx, "author:") === false && strpos($xx, "date:") === false && strpos($xx, "type:") === false) {
            if ($xx == "0" || $xx == "") {
                $sql = "select count(*) as count_num from SL_news,SL_nsort where N_del=0 and S_del=0 and N_sh=0 and N_sort=S_id and S_show=1";
            } else {
                $sql2 = "select  * from SL_nsort where S_id=" . intval($xx);
                $result = mysqli_query($conn, $sql2);
                $row = mysqli_fetch_assoc($result);
                if (mysqli_num_rows($result) > 0) {
                    if ($row["S_sub"] == 0) {
                        $sql = "select count(*) as count_num from SL_news,SL_nsort where N_del=0 and S_del=0 and N_sh=0 and N_sort=S_id and S_show=1 and S_sub=" . intval($xx);
                    } else {
                        $sql = "select count(*) as count_num from SL_news,SL_nsort where N_del=0 and S_del=0 and N_sh=0 and N_sort=S_id and S_show=1 and N_sort=" . intval($xx);
                    }
                }
            }
        } else {
            switch (splitx($xx, ":", 0)) {
                case "tag":
                    $sql = "select count(*) as count_num from SL_news where N_del=0 and N_sh=0 and N_tag like '%," . splitx($xx, ":", 1) . ",%'";
                    break;

                case "author":
                    $sql = "select count(*) as count_num from SL_news where N_del=0 and N_sh=0 and N_author='" . t(splitx($xx, ":", 1)) . "'";
                    break;

                case "date":
                    $sql = "select count(*) as count_num from SL_news where N_del=0 and N_sh=0 and year(N_date)=" . date("Y", strtotime(splitx($xx, ":", 1))) . " and month(N_date)=" . date("m", strtotime(splitx($xx, ":", 1))) . " and day(N_date)=" . date("d", strtotime(splitx($xx, ":", 1)));
                    break;

                case "type":
                    switch (splitx($xx, ":", 1)) {
                        case "news":
                            $sql = "select count(*) as count_num from SL_news where N_del=0 and N_sh=0 and N_type=0";
                            break;

                        case "job":
                            $sql = "select count(*) as count_num from SL_news where N_del=0 and N_sh=0 and N_type=1";
                            break;

                        case "download":
                            $sql = "select count(*) as count_num from SL_news where N_del=0 and N_sh=0 and N_type=2";
                            break;

                        case "video":
                            $sql = "select count(*) as count_num from SL_news where N_del=0 and N_sh=0 and N_type=3";
                            break;

                        case "notice":
                            $sql = "select count(*) as count_num from SL_news where N_del=0 and N_sh=0 and N_type=4";
                        default:
                            $sql = "select count(*) as count_num from SL_news where N_del=0 and N_sh=0 and N_type=0";
                    }
            }
        }
        $list = "news_list";
        $num = $C_npage;
    }
    if ($page_type == "product") {
        if ($xx == "0" || $xx == "") {
            $sql = "select count(*) as count_num from SL_product,SL_psort where P_del=0 and S_del=0 and S_type=" . intval($S_type) . " and S_show=1 and P_sort=S_id";
        } else {
            $sql2 = "select  * from SL_psort where S_del=0 and S_type=" . intval($S_type) . " and S_id=" . intval($xx);
            $result = mysqli_query($conn, $sql2);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) {
                if ($row["S_sub"] == 0) {
                    $sql = "select count(*) as count_num from SL_product,SL_psort where P_del=0 and S_del=0 and S_type=" . intval($S_type) . " and P_sort=S_id and S_show=1 and S_sub=" . intval($xx);
                } else {
                    $sql = "select count(*) as count_num from SL_product,SL_psort where P_del=0 and S_del=0 and P_sort=S_id and S_show=1 and P_sort=" . intval($xx);
                }
            }
        }
        $list = "product_list";
        $num = $C_ppage;
    }
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $count_num = $row["count_num"];
    $page_num = floor($count_num / $num) + 1;
    if ($count_num % $num == 0) {
        $page_num = $page_num - 1;
    }
    if ($xx == "0" && $S_type == 1) {
        $yy = "x";
    } else {
        $yy = $xx;
    }
    if ($C_html == 1) {
        $getpage2 = "<link href='" . $C_dir . "css/Pager.css' rel='stylesheet' type='text/css'/><script src='" . $C_dir . "js/jquery.pager.js' type='text/javascript'></script><script type='text/javascript' language='javascript'>$(document).ready(function(){\$('#pager').pager({pagenumber:" . $S_page . ", pagecount:" . $page_num . ", buttonClickCallback:PageClick });\$('.pages').append('<li>" . lang("共" . $page_num . "页" . $count_num . "条/l/" . $page_num . " pages," . $count_num . " ") . "</li>');});PageClick = function(pageclickednumber){window.location='" . $C_dir . $_SESSION["e"] . "html/" . $page_type . "/list-" . $yy . "-'+pageclickednumber+'.html';}</script>";
    } else {
        $getpage2 = "<link href='" . $C_dir . "css/Pager.css' rel='stylesheet' type='text/css'/><script src='" . $C_dir . "js/jquery.pager.js' type='text/javascript'></script><script type='text/javascript' language='javascript'>\$(document).ready(function(){\$('#pager').pager({pagenumber:" . $S_page . ", pagecount:" . $page_num . ", buttonClickCallback:PageClick }); $('.pages').append('<li>" . lang("共" . $page_num . "页" . $count_num . "条/l/" . $page_num . " pages," . $count_num . " ") . "</li>');});PageClick = function(pageclickednumber){window.location='?type=" . $page_type . "&S_id=" . $yy . "&page='+pageclickednumber;}</script>";
    }
    $getpage2 = $getpage2 . "<div id='pager'></div>";
    return $getpage2;
}



Function getmenu($main_style,$sub_style,$sub_include){    //获取菜单列表
global $conn,$C_html,$C_delang,$C_logo,$C_index,$C_dir,$C_dirx;
$result = mysqli_query($conn, "select * from SL_menu where U_del=0 and U_sub=0 and U_hide=0 order by U_order");
$j = 1;
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $result1 = mysqli_query($conn, "select * from SL_menu where U_del=0 and U_sub=" . $row["U_id"] . " and U_hide=0 order by U_order");
        $i = 1;
        if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
                $sub_style2 = str_Replace("%子菜单ID%", $row1["U_id"], $sub_style);
                $sub_style2 = str_Replace("%子ID%", $i, $sub_style2);
                $sub_style2 = str_Replace("%子菜单类型%", $row1["U_type"], $sub_style2);
                $sub_style2 = str_Replace("%子菜单标题%", lang($row1["U_title"]) , $sub_style2);
                $sub_style2 = str_Replace("%子菜单英文标题%", lang($row1["U_entitle"]) , $sub_style2);
                $sub_style2 = str_Replace("%子菜单typeID%", $row1["U_typeid"], $sub_style2);
                if ($row1["U_color"] != "" && !is_null($row1["U_color"])) {
                    $sub_style2 = str_Replace("%子菜单色调%", $row1["U_color"], $sub_style2);
                } else {
                    $sub_style2 = str_Replace("%子菜单色调%", "#000000", $sub_style2);
                }
                $sub_style2 = str_Replace("%子菜单图标%", $row1["U_ico"], $sub_style2);
                switch ($row1["U_type"]) {
                    case "index":
                        $sub_style2 = str_Replace("%子菜单图片%", $C_logo, $sub_style2);
                        break;

                    case "text":
                        $sub_style2 = str_Replace("%子菜单图片%", getrs("select * from SL_text where T_id=" . $row1["U_typeid"], "T_pic") , $sub_style2);
                        break;

                    case "product":
                        $sub_style2 = str_Replace("%子菜单图片%", getrs("select * from SL_psort where S_id=" . $row1["U_typeid"], "S_pic") , $sub_style2);
                        break;

                    case "news":
                        $sub_style2 = str_Replace("%子菜单图片%", getrs("select * from SL_nsort where S_id=" . $row1["U_typeid"], "S_pic") , $sub_style2);
                        break;

                    case "form":
                        $sub_style2 = str_Replace("%子菜单图片%", getrs("select * from SL_form where F_id=" . $row1["U_typeid"], "F_pic") , $sub_style2);
                        break;

                    case "contact":
                        $sub_style2 = str_Replace("%子菜单图片%", $C_logo, $sub_style2);
                        break;

                    case "guestbook":
                        $sub_style2 = str_Replace("%子菜单图片%", $C_logo, $sub_style2);
                        break;
                }
                if ($row1["U_type"] == "link" || ($row1["U_url"] != "" && $row1["U_url"]!="|" && !is_null($row1["U_url"]))) {

                    if(strpos($row1["U_url"],"|")===false){
                        $url=$row1["U_url"];
                        $target="blank";
                    }else{
                        $url=splitx($row1["U_url"],"|",0);
                        $target=splitx($row1["U_url"],"|",1);
                    }

                    $sub_style2 = str_Replace("%子菜单链接%", $url . "\" target=\"".$target."", $sub_style2);
                } else {
                    if ($C_html == 1 && !WAPstr()) {
                        switch ($row1["U_type"]) {
                            case "index":
                                if ($C_delang == 0) {
                                    $sub_style2 = str_Replace("%子菜单链接%", $C_dir . "indexe.html", $sub_style2);
                                }
                                if ($C_delang == 1) {
                                    $sub_style2 = str_Replace("%子菜单链接%", $C_dir, $sub_style2);
                                }
                                break;

                            case "text":
                                $sub_style2 = str_Replace("%子菜单链接%", $C_dir . $_SESSION["e"] . "html/about/" . $row1["U_typeid"] . ".html", $sub_style2);
                                break;

                            case "product":
                                $sub_style2 = str_Replace("%子菜单链接%", $C_dir . $_SESSION["e"] . "html/product/list-" . $row1["U_typeid"] . ".html", $sub_style2);
                                break;

                            case "news":
                                $sub_style2 = str_Replace("%子菜单链接%", $C_dir . $_SESSION["e"] . "html/news/list-" . $row1["U_typeid"] . ".html", $sub_style2);
                                break;

                            case "form":
                                $sub_style2 = str_Replace("%子菜单链接%", $C_dir . $_SESSION["e"] . "html/form/" . $row1["U_typeid"] . ".html", $sub_style2);
                                break;

                            case "contact":
                                $sub_style2 = str_Replace("%子菜单链接%", $C_dir . $_SESSION["e"] . "html/contact/index.html", $sub_style2);
                                break;

                            case "guestbook":
                                $sub_style2 = str_Replace("%子菜单链接%", $C_dir . $_SESSION["e"] . "html/guestbook/index.html", $sub_style2);
                                break;

                            case "bbs":
                                $sub_style2 = str_Replace("%子菜单链接%", $C_dir . $_SESSION["e"] . "bbs", $sub_style2);
                                break;

                            case "member":
                                $sub_style2 = str_Replace("%子菜单链接%", $C_dir . $_SESSION["e"] . "member", $sub_style2);
                                break;
                        }
                    } else {
                        $sub_style2 = str_Replace("%子菜单链接%", $C_index . "?type=" . $row1["U_type"] . "&S_id=" . $row1["U_typeid"] . "&lang=" . langx($_SESSION["i"], $_SESSION["f"]) , $sub_style2);
                    }
                }
                $submenu = $submenu . $sub_style2;
                $sub_style2 = "";
                $i = $i + 1;
            }
        }
        $main_style2 = str_Replace("%主菜单ID%", $row["U_id"], $main_style);
        $main_style2 = str_Replace("%主ID%", $j, $main_style2);
        $main_style2 = str_Replace("%主菜单类型%", $row["U_type"], $main_style2);
        $main_style2 = str_Replace("%主菜单标题%", lang($row["U_title"]) , $main_style2);
        $main_style2 = str_Replace("%主菜单英文标题%", lang($row["U_entitle"]) , $main_style2);
        $main_style2 = str_Replace("%主菜单typeID%", $row["U_typeid"], $main_style2);
        if ($row["U_color"] != "" && !is_null($row["U_color"])) {
            $main_style2 = str_Replace("%主菜单色调%", $row["U_color"], $main_style2);
        } else {
            $main_style2 = str_Replace("%主菜单色调%", "#000000", $main_style2);
        }
        $main_style2 = str_Replace("%主菜单图标%", $row["U_ico"], $main_style2);
        switch ($row["U_type"]) {
            case "index":
                $main_style2 = str_Replace("%主菜单图片%", $C_logo, $main_style2);
                break;

            case "text":
                $main_style2 = str_Replace("%主菜单图片%", getrs("select * from SL_text where T_id=" . $row["U_typeid"], "T_pic") , $main_style2);
                break;

            case "product":
                $main_style2 = str_Replace("%主菜单图片%", getrs("select * from SL_psort where S_id=" . $row["U_typeid"], "S_pic") , $main_style2);
                break;

            case "news":
                $main_style2 = str_Replace("%主菜单图片%", getrs("select * from SL_nsort where S_id=" . $row["U_typeid"], "S_pic") , $main_style2);
                break;

            case "form":
                $main_style2 = str_Replace("%主菜单图片%", getrs("select * from SL_form where F_id=" . $row["U_typeid"], "F_pic") , $main_style2);
                break;

            case "contact":
                $main_style2 = str_Replace("%主菜单图片%", $C_logo, $main_style2);
                break;

            case "guestbook":
                $main_style2 = str_Replace("%主菜单图片%", $C_logo, $main_style2);
                break;
        }
        if ($row["U_type"] == "link" || ($row["U_url"] != "" && $row["U_url"]!="|" )) {
            if(strpos($row["U_url"],"|")===false){
                $url=$row["U_url"];
                $target="blank";
            }else{
                $url=splitx($row["U_url"],"|",0);
                $target=splitx($row["U_url"],"|",1);
            }
            $main_style2 = str_Replace("%主菜单链接%", $url . "\" target=\"".$target."", $main_style2);
        } else {
            if ($C_html == 1 && !WAPstr()) {
                switch ($row["U_type"]) {
                    case "index":
                        $main_style2 = str_Replace("%主菜单链接%", $C_dir . "?lang=" . langx($_SESSION["i"], $_SESSION["f"]) , $main_style2);
                        break;

                    case "text":
                        $main_style2 = str_Replace("%主菜单链接%", $C_dir . $_SESSION["e"] . "html/about/" . $row["U_typeid"] . ".html", $main_style2);
                        break;

                    case "product":
                        $main_style2 = str_Replace("%主菜单链接%", $C_dir . $_SESSION["e"] . "html/product/list-" . $row["U_typeid"] . ".html", $main_style2);
                        break;

                    case "news":
                        $main_style2 = str_Replace("%主菜单链接%", $C_dir . $_SESSION["e"] . "html/news/list-" . $row["U_typeid"] . ".html", $main_style2);
                        break;

                    case "form":
                        $main_style2 = str_Replace("%主菜单链接%", $C_dir . $_SESSION["e"] . "html/form/" . $row["U_typeid"] . ".html", $main_style2);
                        break;

                    case "contact":
                        $main_style2 = str_Replace("%主菜单链接%", $C_dir . $_SESSION["e"] . "html/contact/index.html", $main_style2);
                        break;

                    case "guestbook":
                        $main_style2 = str_Replace("%主菜单链接%", $C_dir . $_SESSION["e"] . "html/guestbook/index.html", $main_style2);
                        break;

                    case "bbs":
                        $main_style2 = str_Replace("%主菜单链接%", $C_dir . $_SESSION["e"] . "bbs", $main_style2);
                        break;

                    case "member":
                        $main_style2 = str_Replace("%主菜单链接%", $C_dir . $_SESSION["e"] . "member", $main_style2);
                        break;
                }
            } else {
                $main_style2 = str_Replace("%主菜单链接%", $C_index . "?type=" . $row["U_type"] . "&S_id=" . $row["U_typeid"] . "&lang=" . langx($_SESSION["i"], $_SESSION["f"]) , $main_style2);
            }
        }
        if ($submenu != "") {
            $main_style3 = str_Replace("%子菜单%", $sub_include, $main_style2);
            $main_style3 = str_Replace("%子菜单样式%", $submenu, $main_style3);
        } else {
            $main_style3 = str_Replace("%子菜单%", $submenu, $main_style2);
        }
        $main_style3 = str_Replace("%主菜单%", str_replace("%子菜单%", "", $main_style2) , $main_style3);
        $getmenu = $getmenu . $main_style3;
        $main_style2 = "";
        $main_style3 = "";
        $submenu = "";
        $j = $j + 1;
    }
}
$getmenu = str_Replace("，", ",", $getmenu);
$getmenu = str_Replace("?type=index&S_id=1&lang=en", "?lang=en", $getmenu);
$getmenu = str_Replace("?type=index&S_id=1&lang=cn", "?lang=cn", $getmenu);
return $getmenu;
}

function product_sort_list($style, $S_sub, $num) {    //获取产品分类列表
    global $conn,$C_index,$C_html,$C_dirx,$C_dir;

    if ($num == 0) {
        $num_info = "";
    } else {
        $num_info = " limit " . $num;
    }

    if (strpos($S_sub, "|") !==false) {
        $S_type = splitx($S_sub,"|",1);
    } else {
        $S_type = 0;
    }

    if ($S_type == "") {
        $S_type = 0;
    }

    $S_sub = splitx($S_sub,"|",0);


    if ($S_sub == "x") {
        $sub_info = "S_sub=0";
    } else {
        if ($S_sub == 0) {
            $sub_info = "not S_sub=0";
        } else {
            $sub_info = "S_sub=" . intval($S_sub);
        }
    }

    $x = 0;

    if ($S_sub != "0") {
        $result = mysqli_query($conn, "select * from SL_psort where S_del=0 and " . $sub_info . " and S_type=" . intval($S_type) . " and S_show=1 order by S_order,S_id desc" . $num_info);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $style2 = str_Replace("%产品分类ID%", $row["S_id"], $style);
                if (is_file($C_dirx . $row["S_pic"])) {
                    $style2 = str_Replace("%产品分类图片%", $row["S_pic"], $style2);
                } else {
                    $style2 = str_Replace("%产品分类图片%", "images/nopic.png", $style2);
                }
                $style2 = str_Replace("%产品分类标题%", lang($row["S_title"]), $style2);
                $style2 = str_Replace("%产品分类英文标题%", lang($row["S_entitle"]), $style2);
                if (!is_null($row["S_keywords"]) && !is_null($row["S_description"])) {
                    $style2 = str_Replace("%产品分类keywords%", lang($row["S_keywords"]), $style2);
                    $style2 = str_Replace("%产品分类description%", lang($row["S_description"]), $style2);
                }
                $style2 = str_Replace("%i%", $x, $style2);
                $style2 = str_Replace("%j%", $x + 1, $style2);
                if ($C_html == 1 && !WAPstr()) {
                    $style2 = str_Replace("%产品分类链接%", $C_dir . $_SESSION["e"] . "html/product/list-" . $row["S_id"] . ".html", $style2);
                } else {
                    $style2 = str_Replace("%产品分类链接%", $C_index . "?type=product&S_id=" . $row["S_id"], $style2);
                }
                $product_sort_list = $product_sort_list . $style2;
                $style2 = "";
                $x = $x + 1;
            }
        }
    } else {
        $result = mysqli_query($conn, "select * from SL_psort where S_del=0 and S_sub=0 and S_show=1 order by S_order,S_id desc");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $result2 = mysqli_query($conn, "select  * from SL_psort where S_del=0 and S_sub=" . $row["S_id"] . " and S_type=" . intval($S_type) . " and S_show=1 order by S_order,S_id desc" . $num_info);
                if (mysqli_num_rows($result2) > 0) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        $style2 = str_Replace("%产品分类ID%", $row2["S_id"], $style);
                        if (is_file($C_dirx . $row2["S_pic"])) {
                            $style2 = str_Replace("%产品分类图片%", $row2["S_pic"], $style2);
                        } else {
                            $style2 = str_Replace("%产品分类图片%", "images/nopic.png", $style2);
                        }
                        $style2 = str_Replace("%产品分类标题%", lang($row2["S_title"]), $style2);
                        $style2 = str_Replace("%产品分类英文标题%", lang($row2["S_entitle"]), $style2);
                        if (!is_null($row["S_keywords"]) && !is_null($row2["S_description"])) {
                            $style2 = str_Replace("%产品分类keywords%", lang($row2["S_keywords"]), $style2);
                            $style2 = str_Replace("%产品分类description%", lang($row2["S_description"]), $style2);
                        }
                        $style2 = str_Replace("%i%", $x, $style2);
                        $style2 = str_Replace("%j%", $x + 1, $style2);
                        if ($C_html == 1 && !WAPstr()) {
                            $style2 = str_Replace("%产品分类链接%", $C_dir . $_SESSION["e"] . "html/product/list-" . $row2["S_id"] . ".html", $style2);
                        } else {
                            $style2 = str_Replace("%产品分类链接%", $C_index . "?type=product&S_id=" . $row2["S_id"], $style2);
                        }
                        $product_sort_list = $product_sort_list . $style2;
                        $style2 = "";
                        $x = $x + 1;
                    }
                }
            }
        }
    }
    $product_sort_list = str_Replace("，", ",", $product_sort_list);
    return $product_sort_list;
}


function book_list($style){    //获取留言列表
global $conn,$W_msg;
$x=0;
$sql="select * from SL_guestbook where G_sh=1 order by G_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("%留言ID%",$row["G_id"],$style);
$style2=str_Replace("%留言姓名%",$row["G_name"],$style2);
$style2=str_Replace("%留言标题%",$row["G_title"],$style2);
$style2=str_Replace("%留言内容%",$row["G_Msg"],$style2);
$style2=str_Replace("%留言回复%",$row["G_reply"],$style2);
$style2=str_Replace("%留言时间%",$row["G_time"],$style2);
$style2=str_Replace("%i%",$x,$style2);
$style2=str_Replace("%j%",$x+1,$style2);
$book_list=$book_list.$style2;
$style2="";
$x=$x+1;
}
}
if($W_msg==0){
$book_list="管理员未开放留言显示!";
}
$book_list=str_Replace("，",",",$book_list);

return $book_list;
}


function text_list($style){    //获取简介列表
global $conn,$C_dir,$C_dirx,$C_html,$C_index;
$x=0;
$sql="select * from SL_text where T_del=0 order by T_order,T_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("%简介ID%",$row["T_id"],$style);
$style2=str_Replace("%简介标题%",lang($row["T_title"]),$style2);
$style2=str_Replace("%简介英文标题%",lang($row["T_entitle"]),$style2);
$style2=str_Replace("%i%",$x,$style2);
$style2=str_Replace("%j%",$x+1,$style2);
if(is_file($C_dirx.$row["T_pic"])){
$style2=str_Replace("%简介配图%",$row["T_pic"],$style2);
$style2=str_Replace("%简介图片%",$row["T_pic"],$style2);
}else{
$style2=str_Replace("%简介配图%","images/nopic.png",$style2);
$style2=str_Replace("%简介图片%","images/nopic.png",$style2);
}
$style2=str_Replace("%简介内容%",lang($row["T_content"]),$style2);
if(is_null($row["T_link"]) || $row["T_link"]==""){
if($C_html==1 && !WAPstr()){
$style2=str_Replace("%简介链接%",$C_dir.$_SESSION["e"]."html/about/".$row["T_id"].".html",$style2);
}else{
$style2=str_Replace("%简介链接%",$C_index."?type=text&S_id=".$row["T_id"],$style2);
}
}else{
$style2=str_Replace("%简介链接%",$row["T_link"],$style2);
}
$text_list=$text_list.$style2;
$style2="";
$x=$x+1;
}
}
$text_list=str_Replace("，",",",$text_list);
return $text_list;
}


function news_listx($main_style,$sub_style,$num,$S_id){    //获取新闻列表x
global $conn,$C_dir,$C_dirx,$C_index,$C_html;
if($num==0){
$num_info="";
}else{
$num_info=" limit ".$num." ";
}
if($S_id=="0"){
$sort="not S_sub=0";
}else{
if($S_id=="x"){
$sort="S_sub=0";
}else{
$sort="S_sub=".intval($S_id);
}
}
$sql="select * from SL_nsort where S_del=0 and ".$sort." and S_show=1 order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {

if($S_id=="x"){
$sql1="select * from SL_news,SL_nsort where N_del=0 and S_del=0 and N_sh=0 and N_sort=S_id and S_show=1 and S_sub=".$row["S_id"]." order by N_order,N_id desc ".$num_info." ";
}else{
$sql1="select * from SL_news,SL_nsort where N_del=0 and S_del=0 and N_sh=0 and N_sort=S_id and S_show=1 and N_sort=".$row["S_id"]." order by N_order,N_id desc ".$num_info." ";
}
$result1 = mysqli_query($conn, $sql1);

if(mysqli_num_rows($result1) > 0) {
while($row1 = mysqli_fetch_assoc($result1)) {
$sub_style2=str_Replace("%新闻ID%",$row1["N_id"],$sub_style);
if(is_file($C_dirx.$row1["N_pic"])){
$sub_style2=str_Replace("%新闻图片%",$row1["N_pic"],$sub_style2);
}else{
$sub_style2=str_Replace("%新闻图片%","images/nopic.png",$sub_style2);
}
$sub_style2=str_Replace("%新闻标题%",lang($row1["N_title"]),$sub_style2);
$sub_style2=str_Replace("%新闻简述%",lang($row1["N_short"]),$sub_style2);
$sub_style2=str_Replace("%新闻作者%",$row1["N_author"],$sub_style2);
$sub_style2=str_Replace("%新闻浏览量%",$row1["N_view"],$sub_style2);
$sub_style2=str_Replace("%新闻点赞量%",$row1["N_like"],$sub_style2);
$sub_style2=str_Replace("%发表时间%",$row1["N_date"],$sub_style2);
$sub_style2=str_Replace("%发表日期%",date("Y",strtotime($row1["N_date"]))."-".date("m",strtotime($row1["N_date"]))."-".date("d",strtotime($row1["N_date"])),$sub_style2);
$sub_style2=str_Replace("%发表月%",date("m",strtotime($row1["N_date"])),$sub_style2);
$sub_style2=str_Replace("%发表日%",date("d",strtotime($row1["N_date"])),$sub_style2);
$sub_style2=str_Replace("%发表年%",date("Y",strtotime($row1["N_date"])),$sub_style2);
if($C_html==1 && !WAPstr()){
if(is_null($row1["N_link"]) || $row1["N_link"]==""){
$sub_style2=str_Replace("%新闻链接%",$C_dir.$_SESSION["e"]."html/news/".$row1["N_id"].".html",$sub_style2);
}else{
$sub_style2=str_Replace("%新闻链接%",$row1["N_link"],$sub_style2);
}
$sub_style2=str_Replace("%新闻分类链接%",$C_dir.$_SESSION["e"]."html/new/list-".$row1["S_id"].".html",$sub_style2);
}else{
if(is_null($row1["N_link"]) || $row1["N_link"]==""){
$sub_style2=str_Replace("%新闻链接%",$C_index."?type=newsinfo&S_id=".$row1["N_id"],$sub_style2);
}else{
$sub_style2=str_Replace("%新闻链接%",$row1["N_link"],$sub_style2);
}
$sub_style2=str_Replace("%新闻分类链接%",$C_index."?type=news&S_id=".$row1["S_id"],$sub_style2);
}

$submenu=$submenu.$sub_style2;
$sub_style2="";

}
}

$main_style2=str_Replace("%新闻分类ID%",$row["S_id"],$main_style);
if(is_file($C_dirx.$row["S_pic"])){
$main_style2=str_Replace("%新闻分类图片%",$row["S_pic"],$main_style2);
}else{
$main_style2=str_Replace("%新闻分类图片%","images/nopic.png",$main_style2);
}
$main_style2=str_Replace("%新闻分类标题%",lang($row["S_title"]),$main_style2);
$main_style2=str_Replace("%新闻分类英文标题%",lang($row["S_entitle"]),$main_style2);
if($C_html==1 && !WAPstr()){
$main_style2=str_Replace("%新闻分类链接%",$C_dir.$_SESSION["e"]."html/news/list-".$row["S_id"].".html",$main_style2);
}else{
$main_style2=str_Replace("%新闻分类链接%",$C_index."?type=news&S_id=".$row["S_id"],$main_style2);
}
$main_style3=str_Replace("%新闻列表%",$submenu,$main_style2);
$news_listx=$news_listx.$main_style3;
$main_style2="";
$main_style3="";
$submenu="";
}
}
$news_listx=str_Replace("，",",",$news_listx);
return $news_listx;
}

function product_listx($main_style,$sub_style,$num,$S_id){    //获取产品列表x
global $conn,$C_dir,$C_dirx,$C_index,$C_html;
if($num==0){
$num_info="";
}else{
$num_info=" limit ".$num." ";
}
if($S_id=="0"){
$sort="not S_sub=0";
}else{
if($S_id=="x"){
$sort="S_sub=0";
}else{
$sort="S_sub=".intval($S_id);
}
}

$sql="select * from SL_psort where S_del=0 and ".$sort." and S_show=1 order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
if($S_id=="x"){
$sql1="select * from SL_product,SL_psort where P_del=0 and S_del=0 and P_sort=S_id and S_sub=".$row["S_id"]." and S_show=1 order by P_order,P_id desc ".$num_info."";
}else{
$sql1="select * from SL_product,SL_psort where P_del=0 and S_del=0 and P_sort=S_id and P_sort=".$row["S_id"]." and S_show=1 order by P_order,P_id desc ".$num_info."";
}
$result1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result1) > 0) {
while($row1 = mysqli_fetch_assoc($result1)) {
$sub_style2=str_Replace("%产品ID%",$row1["P_id"],$sub_style);
if(is_file($C_dirx.splitx(splitx($row1["P_path"],"|",0),"__",0))){
$sub_style2=str_Replace("%产品小图%",splitx(splitx($row1["P_path"],"|",0),"__",0),$sub_style2);
$sub_style2=str_Replace("%产品大图%",splitx(splitx($row1["P_path"],"|",0),"__",0),$sub_style2);
$sub_style2=str_Replace("%产品图片%",splitx(splitx($row1["P_path"],"|",0),"__",0),$sub_style2);
}else{
$sub_style2=str_Replace("%产品小图%","images/nopic.png",$sub_style2);
$sub_style2=str_Replace("%产品大图%","images/nopic.png",$sub_style2);
$sub_style2=str_Replace("%产品图片%","images/nopic.png",$sub_style2);
}
$sub_style2=str_Replace("%产品标题%",lang($row1["P_title"]),$sub_style2);
$sub_style2=str_Replace("%产品简述%",lang($row1["P_short"]),$sub_style2);
$sub_style2=str_Replace("%产品价格%",round($row1["P_price"],2),$sub_style2);
$sub_style2=str_Replace("%发布时间%",$row1["P_time"],$sub_style2);
$sub_style2=str_Replace("%发布日期%",date("Y",strtotime($row1["P_time"]))."-".date("m",strtotime($row1["P_time"]))."-".date("d",strtotime($row1["P_time"])),$sub_style2);
$sub_style2=str_Replace("%发布月%",date("m",strtotime($row1["P_time"])),$sub_style2);
$sub_style2=str_Replace("%发布日%",date("d",strtotime($row1["P_time"])),$sub_style2);
$sub_style2=str_Replace("%发布年%",date("Y",strtotime($row1["P_time"])),$sub_style2);
if($C_html==1 && !WAPstr()){
$sub_style2=str_Replace("%产品链接%",$C_dir.$_SESSION["e"]."html/product/".$row1["P_id"].".html",$sub_style2);
}else{
$sub_style2=str_Replace("%产品链接%",$C_index."?type=productinfo&S_id=".$row1["P_id"],$sub_style2);
}

$submenu=$submenu.$sub_style2;
$sub_style2="";

}
}

$main_style2=str_Replace("%产品分类ID%",$row["S_id"],$main_style);
if(is_file($C_dirx.$row["S_pic"])){
$main_style2=str_Replace("%产品分类图片%",$row["S_pic"],$main_style2);
}else{
$main_style2=str_Replace("%产品分类图片%","images/nopic.png",$main_style2);
}
$main_style2=str_Replace("%产品分类标题%",lang($row["S_title"]),$main_style2);
$main_style2=str_Replace("%产品分类英文标题%",lang($row["S_entitle"]),$main_style2);
if($C_html==1 && !WAPstr()){
$main_style2=str_Replace("%产品分类链接%",$C_dir.$_SESSION["e"]."html/product/list-".$row["S_id"].".html",$main_style2);
}else{
$main_style2=str_Replace("%产品分类链接%",$C_index."?type=product&S_id=".$row["S_id"],$main_style2);
}
$main_style3=str_Replace("%产品列表%",$submenu,$main_style2);
$product_listx=$product_listx.$main_style3;
$main_style2="";
$main_style3="";
$submenu="";
}
}
$product_listx=str_Replace("，",",",$product_listx);
return $product_listx;
}


function product_list2($title_style,$style,$num,$S_id){    //获取产品列表
global $conn,$C_dir,$C_dirx,$C_index,$C_psorttitle,$C_psortentitle,$C_ppage,$C_html;
if($S_id=="0"){
    $show_info=" and S_show=1";
}else{
    $show_info="";
}
if(strpos($num,"|")!==false){
    $S_page=splitx($num,"|",1);
    $num=$C_ppage;
    $idx="index";
}else{
    $num=splitx($num,"|",0);
    $idx="";
    $S_page=1;
}

if($S_page==""){
    $S_page=1;
}

if(strpos($S_id,"|")!==false){
    $S_type=splitx($S_id,"|",1);
}else{
    $S_type=0;
}
if($S_type==""){
    $S_type=0;
}
$S_id=splitx($S_id,"|",0);
$S_iid=$S_id;
if($num=="0"){
    $num_info="";
}else{
    $num_info="limit ".$num;
}
if(!is_numeric($S_id)){
$sql="select * from SL_psort where S_del=0 and S_sub=0 and S_show=1 and S_type=0 order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$S_sublist=$S_sublist.$row["S_id"].",";
$sql2="select * from SL_psort where S_del=0 and S_sub=".$row["S_id"]." and S_show=1 and S_type=0 order by S_order,S_id desc";
$result2 = mysqli_query($conn, $sql2);

if(mysqli_num_rows($result2) > 0) {
while($row2 = mysqli_fetch_assoc($result2)) {
$S_list=$S_list.$row2["S_id"].",";
}
}
}
}
$S_list=$S_list."0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
$S_sublist=$S_sublist."0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
switch($S_id){

case "a":
$top=0;
$sub_info=0;
break;
case "b":
$top=1;
$sub_info=0;
break;
case "c":
$top=2;
$sub_info=0;
break;
case "d":
$top=3;
$sub_info=0;
break;
case "e":
$top=4;
$sub_info=0;
break;
case "f":
$top=5;
$sub_info=0;
break;
case "g":
$top=6;
$sub_info=0;
break;
case "h":
$top=7;
$sub_info=0;
break;
case "i":
$top=8;
$sub_info=0;
break;
case "j":
$top=9;
$sub_info=0;
break;
case "k":
$top=10;
$sub_info=0;
break;
case "A":
$top=0;
$sub_info=1;
break;
case "B":
$top=1;
$sub_info=1;
break;
case "C":
$top=2;
$sub_info=1;
break;
case "D":
$top=3;
$sub_info=1;
break;
case "E":
$top=4;
$sub_info=1;
break;
case "F":
$top=5;
$sub_info=1;
break;
case "G":
$top=6;
$sub_info=1;
break;
case "H":
$top=7;
$sub_info=1;
break;
case "I":
$top=8;
$sub_info=1;
break;
case "J":
$top=9;
$sub_info=1;
break;
case "K":
$top=10;
$sub_info=1;
}
if($sub_info==0){
$S_id=splitx($S_list,",",$top);
}else{
$S_id=splitx($S_sublist,",",$top);
}
}

$sql="select * from SL_psort where S_del=0 and S_type=".intval($S_type)." and S_show=1 order by S_id asc limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$S_aid=$row["S_id"];
}
if($S_id==0){
$S_id_info="";
}else{
$sql="select * from SL_psort where S_del=0 and S_type=".intval($S_type)." and S_show=1 and S_id=".intval($S_id);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$S_sub=$row["S_sub"];
}
if($S_sub!=0){
$S_id_info="and S_id=".intval($S_id);
}else{
$S_id_info="and S_sub=".intval($S_id);
}
}

$x=0;
if($S_page==1){
    $sql="select * from SL_product,SL_psort where P_del=0 and S_del=0 and P_sort=S_id and S_type=".intval($S_type)." ".$S_id_info." ".$show_info." and S_show=1 order by P_top desc,P_order asc,P_id desc ".$num_info;
}else{
    $sql="select * from SL_product,SL_psort where P_del=0 and S_del=0 and P_sort=S_id and S_type=".intval($S_type)." ".$S_id_info." ".$show_info." and S_show=1 order by P_top desc,P_order asc,P_id desc limit ".$num*($S_page-1).",".$num;
}

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
if($S_id!="0"){
if($S_sub==0){
if(is_file($C_dirx.getrs("select * from SL_psort where S_id=".$row["S_sub"],"S_pic"))){
$title_style=str_Replace("%产品分类图片%",getrs("select * from SL_psort where S_id=".$row["S_sub"],"S_pic"),$title_style);
}else{
$title_style=str_Replace("%产品分类图片%","images/nopic.png",$title_style);
}
$title_style=str_Replace("%产品分类标题%",lang(getrs("select * from SL_psort where S_id=".$row["S_sub"],"S_title")),$title_style);
$title_style=str_Replace("%产品分类ID%",getrs("select * from SL_psort where S_id=".$row["S_sub"],"S_id"),$title_style);
$title_style=str_Replace("%产品分类英文标题%",lang(getrs("select * from SL_psort where S_id=".$row["S_sub"],"S_entitle")),$title_style);
}else{
if(is_file($C_dirx.$row["S_pic"])){
$title_style=str_Replace("%产品分类图片%",$row["S_pic"],$title_style);
}else{
$title_style=str_Replace("%产品分类图片%","images/nopic.png",$title_style);
}
$title_style=str_Replace("%产品分类标题%",lang($row["S_title"]),$title_style);
$title_style=str_Replace("%产品分类ID%",$row["S_id"],$title_style);
$title_style=str_Replace("%产品分类英文标题%",lang($row["S_entitle"]),$title_style);
}
}else{
if($S_type==0){
$title_style=str_Replace("%产品分类ID%",$row["S_id"],$title_style);
$title_style=str_Replace("%产品分类标题%",lang($C_psorttitle),$title_style);
$title_style=str_Replace("%产品分类英文标题%",lang($C_psortentitle),$title_style);
}else{
$title_style=str_Replace("%产品分类ID%",$row["S_id"],$title_style);
$title_style=str_Replace("%产品分类标题%","案例中心",$title_style);
$title_style=str_Replace("%产品分类英文标题%","case",$title_style);
}
}
$style2=str_Replace("%产品分类标题%",lang($row["S_title"]),$style);
$style2=str_Replace("%产品分类英文标题%",lang($row["S_entitle"]),$style2);
$style2=str_Replace("%产品分类ID%",$row["S_id"],$style2);
$style2=str_Replace("%产品标题%",lang($row["P_title"]),$style2);
$style2=str_Replace("%产品简述%",lang($row["P_short"]),$style2);
$style2=str_Replace("%产品ID%",$row["P_id"],$style2);
if($row["P_time"]==""){
$P_time="2017-1-1";
}else{
$P_time=$row["P_time"];
}
$style2=str_Replace("%发布时间%",$P_time,$style2);
$style2=str_Replace("%发布日期%",date("Y",strtotime($P_time))."-".date("m",strtotime($P_time))."-".date("d",strtotime($P_time)),$style2);
$style2=str_Replace("%i%",$x,$style2);
$style2=str_Replace("%j%",$x+1,$style2);
if($row["P_path"]=="" || is_null($row["P_path"])){
$P_path="media/|media/|media/|media/|media/|media/|media/|media/|media/|media/|media/|media/|media/";
}else{
$P_path=$row["P_path"]."|media/|media/|media/|media/|media/|media/|media/|media/|media/|media/|media/|media/";
}
if(is_file($C_dirx.splitx(splitx($P_path,"|",0),"__",0))){
$style2=str_Replace("%产品小图%",splitx(splitx($P_path,"|",0),"__",0),$style2);
$style2=str_Replace("%产品大图%",splitx(splitx($P_path,"|",0),"__",0),$style2);
$style2=str_Replace("%产品图1%",splitx(splitx($P_path,"|",0),"__",0),$style2);
}else{
$style2=str_Replace("%产品小图%","images/nopic.png",$style2);
$style2=str_Replace("%产品大图%","images/nopic.png",$style2);
$style2=str_Replace("%产品图1%","images/nopic.png",$style2);
}
if(is_file($C_dirx.splitx(splitx($P_path,"|",1),"__",0))){
$style2=str_Replace("%产品图2%",splitx(splitx($P_path,"|",1),"__",0),$style2);
}else{
$style2=str_Replace("%产品图2%","images/nopic.png",$style2);
}
if(is_file($C_dirx.splitx(splitx($P_path,"|",2),"__",0))){
$style2=str_Replace("%产品图3%",splitx(splitx($P_path,"|",2),"__",0),$style2);
}else{
$style2=str_Replace("%产品图3%","images/nopic.png",$style2);
}
if(is_file($C_dirx.splitx(splitx($P_path,"|",3),"__",0))){
$style2=str_Replace("%产品图4%",splitx(splitx($P_path,"|",3),"__",0),$style2);
}else{
$style2=str_Replace("%产品图4%","images/nopic.png",$style2);
}
if(is_file($C_dirx.splitx(splitx($P_path,"|",4),"__",0))){
$style2=str_Replace("%产品图5%",splitx(splitx($P_path,"|",4),"__",0),$style2);
}else{
$style2=str_Replace("%产品图5%","images/nopic.png",$style2);
}
$style2=str_Replace("%产品价格%",round($row["P_price"],2),$style2);
$style2=str_Replace("%产品内容%",lang($row["P_content"]),$style2);
if($C_html==1 && !WAPstr()){
if(is_null($row["P_link"]) || $row["P_link"]==""){
$style2=str_Replace("%产品链接%",$C_dir.$_SESSION["e"]."html/product/".$row["P_id"].".html",$style2);
}else{
$style2=str_Replace("%产品链接%",$row["P_link"],$style2);
}
$style2=str_Replace("%产品分类链接%",$C_dir.$_SESSION["e"]."html/product/list-".$row["S_id"].".html",$style2);
}else{
if(is_null($row["P_link"]) || $row["P_link"]==""){
$style2=str_Replace("%产品链接%",$C_index."?type=productinfo&S_id=".$row["P_id"],$style2);
}else{
$style2=str_Replace("%产品链接%",$row["P_link"],$style2);
}
$style2=str_Replace("%产品分类链接%",$C_index."?type=product&S_id=".$row["S_id"],$style2);
}
if($S_id!==0){
if($S_sub==0){
if($C_html==1 && !WAPstr()){
$title_style=str_Replace("%产品分类链接%",$C_dir.$_SESSION["e"]."html/product/list-".getrs("select * from SL_psort where S_id=".$row["S_sub"],"S_id").".html",$title_style);
}else{
$title_style=str_Replace("%产品分类链接%",$C_index."?type=product&S_id=".getrs("select * from SL_psort where S_id=".$row["S_sub"],"S_id"),$title_style);
}
}else{
if($C_html==1 && !WAPstr()){
$title_style=str_Replace("%产品分类链接%",$C_dir.$_SESSION["e"]."html/product/list-".$row["S_id"].".html",$title_style);
}else{
$title_style=str_Replace("%产品分类链接%",$C_index."?type=product&S_id=".$row["S_id"],$title_style);
}
}
}else{
if($C_html==1 && !WAPstr()){
$title_style=str_Replace("%产品分类链接%",$C_dir.$_SESSION["e"]."html/product/list-".$S_aid.".html",$title_style);
}else{
$title_style=str_Replace("%产品分类链接%",$C_index."?type=product&S_id=".$S_aid,$title_style);
}
}

$product_list2=$product_list2.$style2;
$style2="";
$x=$x+1;
}
$product_list2=$title_style.$product_list2;
}else{
$title_style=str_Replace("%产品分类图片%","images/nopic.png",$title_style);
$title_style=str_Replace("%产品分类ID%","",$title_style);
$title_style=str_Replace("%产品分类标题%","该ID下暂无产品分类",$title_style);
$title_style=str_Replace("%产品分类英文标题%","null",$title_style);
$title_style=str_Replace("%产品分类链接%","#",$title_style);
$style2=str_Replace("%产品分类标题%","该ID下暂无产品分类",$style);
$style2=str_Replace("%产品分类英文标题%","null",$style2);
$style2=str_Replace("%产品分类ID%","",$style2);
$style2=str_Replace("%产品标题%","该ID下暂无产品",$style2);
$style2=str_Replace("%产品简述%","",$style2);
$style2=str_Replace("%产品ID%","",$style2);
$style2=str_Replace("%产品小图%","images/nopic.png",$style2);
$style2=str_Replace("%产品大图%","images/nopic.png",$style2);
$style2=str_Replace("%产品价格%","",$style2);
$style2=str_Replace("%产品内容%","",$style2);
$style2=str_Replace("%产品链接%","#",$style2);
$style2=str_Replace("%产品分类链接%","#",$style2);
$product_list2=$title_style.$style2;
}
$product_list2=str_Replace("，",",",$product_list2);

return $product_list2;
}



function contact_list($style){    //获取联系列表
global $conn,$C_html,$C_index,$C_dir;
$sql="select  * from SL_contact limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$C_title=lang($row["C_title"]);
$C_entitle=lang($row["C_entitle"]);
}
$style2=str_Replace("%联系ID%","1",$style);
$style2=str_Replace("%联系标题%",$C_title,$style2);
$style2=str_Replace("%联系英文标题%",$C_entitle,$style2);
if($C_html==1 and !WAPstr()){
$style2=str_Replace("%联系链接%",$C_dir.$_SESSION["e"]."html/contact/index.html",$style2);
}else{
$style2=str_Replace("%联系链接%",$C_index."?type=contact",$style2);
}
$style3=str_Replace("%联系ID%","2",$style);
$style3=str_Replace("%联系标题%","在线留言",$style3);
$style3=str_Replace("%联系英文标题%","Guestbook",$style3);
if($C_html==1 and !WAPstr()){
$style3=str_Replace("%联系链接%",$C_dir.$_SESSION["e"]."html/guestbook/index.html",$style3);
}else{
$style3=str_Replace("%联系链接%",$C_index."?type=guestbook",$style3);
}
$contact_list=$style2.$style3;
$contact_list=str_Replace("，",",",$contact_list);

return $contact_list;
}


function news_sort_list($style){    //获取新闻分类列表
global $C_html,$conn,$C_index,$C_dir;
$x=0;
$sql="select * from SL_nsort where S_del=0 and not S_sub=0 and S_show=1 order by S_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("%新闻分类ID%",$row["S_id"],$style);
$style2=str_Replace("%新闻分类标题%",lang($row["S_title"]),$style2);
$style2=str_Replace("%新闻分类英文标题%",lang($row["S_entitle"]),$style2);
$style2=str_Replace("%i%",$x,$style2);
$style2=str_Replace("%j%",$x+1,$style2);
if(!is_null($row["S_keywords"]) && !is_null($row["S_description"])){
$style2=str_Replace("%新闻分类keywords%",lang($row["S_keywords"]),$style2);
$style2=str_Replace("%新闻分类description%",lang($row["S_description"]),$style2);
}
if($C_html==1 and !WAPstr()){
$style2=str_Replace("%新闻分类链接%",$C_dir.$_SESSION["e"]."html/news/list-".$row["S_id"].".html",$style2);
}else{
$style2=str_Replace("%新闻分类链接%",$C_index."?type=news&S_id=".$row["S_id"],$style2);
}
$news_sort_list=$news_sort_list.$style2;
$style2="";
$x=$x+1;
}
}
$news_sort_list=str_Replace("，",",",$news_sort_list);
return $news_sort_list;
}

function product_sort_list2($main_style,$sub_style,$sub_include){    //获取产品列表2
global $conn,$C_dir,$C_dirx,$C_html,$C_index;
$sql="select * from SL_psort where S_del=0 and S_sub=0 and S_type=0 and S_show=1 order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$sql1="select * from SL_psort where S_del=0 and S_sub=".$row["S_id"]." and S_type=0 and S_show=1 order by S_order,S_id desc";
$result1 = mysqli_query($conn, $sql1);

if(mysqli_num_rows($result1) > 0) {
while($row1 = mysqli_fetch_assoc($result1)) {
$sub_style2=str_Replace("%子分类ID%",$row1["S_id"],$sub_style);
if(is_file($C_dirx.$row1["S_pic"])){
$sub_style2=str_Replace("%子分类图片%",$row1["S_pic"],$sub_style2);
}else{
$sub_style2=str_Replace("%子分类图片%","images/nopic.png",$sub_style2);
}
$sub_style2=str_Replace("%主分类ID%",$row["S_id"],$sub_style2);
$sub_style2=str_Replace("%子分类标题%",lang($row1["S_title"]),$sub_style2);
$sub_style2=str_Replace("%子分类英文标题%",lang($row1["S_entitle"]),$sub_style2);
if($C_html==1 && !WAPstr()){
$sub_style2=str_Replace("%子分类链接%",$C_dir.$_SESSION["e"]."html/product/list-".$row1["S_id"].".html",$sub_style2);
}else{
$sub_style2=str_Replace("%子分类链接%",$C_index."?type=product&S_id=".$row1["S_id"],$sub_style2);
}
$submenu=$submenu.$sub_style2;
$sub_style2="";

}
}

$main_style2=str_Replace("%主分类ID%",$row["S_id"],$main_style);
if(is_file($C_dirx.$row["S_pic"])){
$main_style2=str_Replace("%主分类图片%",$row["S_pic"],$main_style2);
}else{
$main_style2=str_Replace("%主分类图片%","images/nopic.png",$main_style2);
}
$main_style2=str_Replace("%主分类标题%",lang($row["S_title"]),$main_style2);
$main_style2=str_Replace("%主分类英文标题%",lang($row["S_entitle"]),$main_style2);
if($C_html==1 && !WAPstr()){
$main_style2=str_Replace("%主分类链接%",$C_dir.$_SESSION["e"]."html/product/list-".$row["S_id"].".html",$main_style2);
}else{
$main_style2=str_Replace("%主分类链接%",$C_index."?type=product&S_id=".$row["S_id"],$main_style2);
}
if($submenu!==""){
$main_style3=str_Replace("%子分类%",$sub_include,$main_style2);
$main_style3=str_Replace("%子分类样式%",$submenu,$main_style3);
}else{
$main_style3=str_Replace("%子分类%",$submenu,$main_style2);
}
$main_style3=str_Replace("%主分类%",str_replace("%子分类%","",$main_style2),$main_style3);

$product_sort_list2=$product_sort_list2.$main_style3;
$main_style2="";
$main_style3="";
$submenu="";
}
}
$product_sort_list2=str_Replace("，",",",$product_sort_list2);
return $product_sort_list2;
}

function news_sort_list2($main_style,$sub_style,$sub_include){    //获取新闻分类列表2
global $conn,$C_dir,$C_dirx,$C_html,$C_index;
$sql="select * from SL_nsort where S_del=0 and S_sub=0 and S_show=1 order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$sql1="select * from SL_nsort where S_del=0 and S_sub=".$row["S_id"]." and S_show=1 order by S_order,S_id desc";
$result1 = mysqli_query($conn, $sql1);

if(mysqli_num_rows($result1) > 0) {
while($row1 = mysqli_fetch_assoc($result1)) {
$sub_style2=str_Replace("%子分类ID%",$row1["S_id"],$sub_style);
if(is_file($C_dirx.$row1["S_pic"])){
$sub_style2=str_Replace("%子分类图片%",$row1["S_pic"],$sub_style2);
}else{
$sub_style2=str_Replace("%子分类图片%","images/nopic.png",$sub_style2);
}
$sub_style2=str_Replace("%子分类标题%",lang($row1["S_title"]),$sub_style2);
$sub_style2=str_Replace("%子分类英文标题%",lang($row1["S_entitle"]),$sub_style2);
if($C_html==1 && !WAPstr()){
$sub_style2=str_Replace("%子分类链接%",$C_dir.$_SESSION["e"]."html/news/list-".$row1["S_id"].".html",$sub_style2);
}else{
$sub_style2=str_Replace("%子分类链接%",$C_index."?type=news&S_id=".$row1["S_id"],$sub_style2);
}
$submenu=$submenu.$sub_style2;
$sub_style2="";
}
}

$main_style2=str_Replace("%主分类ID%",$row["S_id"],$main_style);
if(is_file($C_dirx.$row["S_pic"])){
$main_style2=str_Replace("%主分类图片%",$row["S_pic"],$main_style2);
}else{
$main_style2=str_Replace("%主分类图片%","images/nopic.png",$main_style2);
}
$main_style2=str_Replace("%主分类标题%",lang($row["S_title"]),$main_style2);
$main_style2=str_Replace("%主分类英文标题%",lang($row["S_entitle"]),$main_style2);
if($C_html==1 && !WAPstr()){
$main_style2=str_Replace("%主分类链接%",$C_dir.$_SESSION["e"]."html/news/list-".$row["S_id"].".html",$main_style2);
}else{
$main_style2=str_Replace("%主分类链接%",$C_index."?type=news&S_id=".$row["S_id"],$main_style2);
}
if($submenu!==""){
$main_style3=str_Replace("%子分类%",$sub_include,$main_style2);
$main_style3=str_Replace("%子分类样式%",$submenu,$main_style3);
}else{
$main_style3=str_Replace("%子分类%",$submenu,$main_style2);
}
$main_style3=str_Replace("%主分类%",str_replace("%子分类%","",$main_style2),$main_style3);
$news_sort_list2=$news_sort_list2.$main_style3;
$main_style2="";
$main_style3="";
$submenu="";
}
}
$news_sort_list2=str_Replace("，",",",$news_sort_list2);
return $news_sort_list2;
}

function text_intro($style,$T_id,$num){    //获取简介简述
global $conn,$C_dir,$C_dirx,$C_index,$C_html;
if(is_Numeric($T_id)){
$sql="select * from SL_text where T_del=0 and T_id=".intval($T_id);
}else{
switch($T_id){

case "a":
$top=0;
break;
case "b":
$top=1;
break;
case "c":
$top=2;
break;
case "d":
$top=3;
break;
case "e":
$top=4;
break;
case "f":
$top=5;
break;
case "g":
$top=6;
break;
case "h":
$top=7;
break;
case "i":
$top=8;
break;
case "j":
$top=9;
break;
case "k":
$top=10;
break;
}
if($top==0){
$sql="select * from SL_text where T_del=0 order by T_order,T_id desc limit 1";
}else{
$sql="select * from (select * from SL_text where T_del=0 order by T_order,T_id desc limit ".($top+1).")a order by T_order desc,T_id asc limit 1";
}
}
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("%简介内容%",mb_substr(strip_tags(lang($row["T_content"])),0,$num,"utf-8")."..",$style);
$style2=str_Replace("%简介内容2%",lang($row["T_content"]),$style2);
$style2=str_Replace("%简介标题%",lang($row["T_title"]),$style2);
if(is_file($C_dirx.$row["T_pic"])){
$style2=str_Replace("%简介图片%",$row["T_pic"],$style2);
}else{
$style2=str_Replace("%简介图片%","images/nopic.png",$style2);
}
$style2=str_Replace("%简介英文标题%",lang($row["T_entitle"]),$style2);
if(is_null($row["T_link"]) || $row["T_link"]==""){
if($C_html==1 && !WAPstr()){
$style2=str_Replace("%简介链接%",$C_dir.$_SESSION["e"]."html/about/".$row["T_id"].".html",$style2);
}else{
$style2=str_Replace("%简介链接%",$C_index."?type=text&S_id=".$row["T_id"],$style2);
}
}else{
$style2=str_Replace("%简介链接%",$row["T_link"],$style2);
}
$text_intro=$text_intro.$style2;
$style2="";
}
}
$text_intro=str_Replace("，",",",$text_intro);
return $text_intro;
}



function link_list($style,$S_id){    //获取友链列表
global $conn,$C_dirx;
if(is_file($C_dirx."conn/from.txt")){
$url=splitx(trim(file_get_contents($C_dirx."conn/from.txt"),"\xEF\xBB\xBF"),"|",1);
$from1=splitx(trim(file_get_contents($C_dirx."conn/from.txt"),"\xEF\xBB\xBF"),"|",0);
}else{
$url="http://www.s-cms.cn";
$from1="free";
}
if($from1!="free"){
$infox=" and not L_url='http://www.s-cms.cn'";
}else{
$infox="";
}
if(is_numeric($S_id)){
if($S_id==0){
$aa="";
}else{
$aa="and L_sort=".intval($S_id);
}
}else{
switch($S_id){
case "a":
$top=0;
break;
case "b":
$top=1;
break;
case "c":
$top=2;
break;
case "d":
$top=3;
break;
case "e":
$top=4;
break;
case "f":
$top=5;
break;
case "g":
$top=6;
break;
case "h":
$top=7;
break;
case "i":
$top=8;
break;
case "j":
$top=9;
break;
case "k":
$top=10;
}
if($top==0){
$sql="select * from SL_lsort order by S_order,S_id desc limit 1";
}else{
$sql="select * from (SELECT  * FROM SL_lsort order by S_order,S_id desc limit ".($top+1).")a order by S_order desc,S_id asc limit 1";
}
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$aa="and L_sort=".$row["S_id"];
}
}
$sql="select * from SL_link where L_del=0 and L_id>0 ".$aa.$infox." order by L_order asc,L_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("%友链网址%",$row["L_url"],$style);
$style2=str_Replace("%友链网站%",lang($row["L_title"]),$style2);
if(is_file($C_dirx.$row["L_pic"])){
	$style2=str_Replace("%友链图片%",$row["L_pic"],$style2);
}else{
	$style2=str_Replace("%友链图片%","images/nopic.png",$style2);
}
$link_list=$link_list.$style2;
$style2="";
}
}
$link_list=str_Replace("，",",",$link_list);
return $link_list;
}


function link_sort_list($style){    //获取友链分类列表
global $conn;
$x=0;
$sql="select * from SL_lsort order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("%友链分类ID%",$row["S_id"],$style);
$style2=str_Replace("%友链分类标题%",lang($row["S_title"]),$style2);
$style2=str_Replace("%i%",$x,$style2);
$style2=str_Replace("%j%",$x+1,$style2);
$link_sort_list=$link_sort_list.$style2;
$style2="";
$x=$x+1;
}
}
$link_sort_list=str_Replace("，",",",$link_sort_list);
return $link_sort_list;
}


function link_listx($main_style,$sub_style){    //获取友链列表x
global $conn;
$sql="select * from SL_lsort order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$sql1="select * from SL_link,SL_lsort where L_del=0 and L_sort=S_id and S_id=".$row["S_id"]." order by L_order asc,L_id desc";
$result1 = mysqli_query($conn, $sql1);
if(mysqli_num_rows($result1) > 0) {
while($row1 = mysqli_fetch_assoc($result1)) {
$sub_style2=str_Replace("%友链ID%",$row1["L_id"],$sub_style);
$sub_style2=str_Replace("%友链网站%",lang($row1["L_title"]),$sub_style2);
$sub_style2=str_Replace("%友链网址%",lang($row1["L_url"]),$sub_style2);
$sub_style2=str_Replace("%友链图片%",lang($row1["L_pic"]),$sub_style2);
$submenu=$submenu.$sub_style2;
$sub_style2="";
}
}

$main_style2=str_Replace("%友链分类ID%",$row["S_id"],$main_style);
$main_style2=str_Replace("%友链分类标题%",lang($row["S_title"]),$main_style2);
$main_style3=str_Replace("%友链列表%",$submenu,$main_style2);
$link_listx=$link_listx.$main_style3;
$main_style2="";
$main_style3="";
$submenu="";
}
}
$link_listx=str_Replace("，",",",$link_listx);
return $link_listx;
}


function form_list($style){    //获取表单列表
global $conn,$C_html,$C_index,$C_dir;
$x=0;
$sql="select * from SL_form where F_del=0 order by F_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$style2=str_Replace("%表单ID%",$row["F_id"],$style);
$style2=str_Replace("%表单标题%",lang($row["F_title"]),$style2);
$style2=str_Replace("%表单英文标题%",lang($row["F_entitle"]),$style2);
$style2=str_Replace("%i%",$x,$style2);
$style2=str_Replace("%j%",$x+1,$style2);
if($C_html==1 && !WAPstr()){
$style2=str_Replace("%表单链接%",$C_dir.$_SESSION["e"]."html/form/".$row["F_id"].".html",$style2);
}else{
$style2=str_Replace("%表单链接%",$C_index."?type=form&S_id=".$row["F_id"],$style2);
}
$form_list=$form_list.$style2;
$style2="";
$x=$x+1;
}
}
$form_list=str_Replace("，",",",$form_list);
return $form_list;
}


function news_list2($title_tyle, $style, $num, $S_id, $order) {    //获取新闻列表
    global $conn, $C_wap, $C_dir, $C_dirx, $C_nsorttitle, $C_nsortentitle, $C_npage, $C_index, $C_html;
    if ($S_id == "0") {
        $show_info = " and S_show=1";
    } else {
        $show_info = "";
    }
    switch ($order) {
        case "normal":
            $orderby = "N_top desc,N_order asc,N_date desc,N_id desc";
            break;
        case "hot":
            $orderby = "N_view desc,N_order asc,N_id desc";
            break;
        case "latest":
            $orderby = "N_date desc,N_order asc";
            break;
        case "order":
            $orderby = "N_order asc,N_id desc";
            break;
        case "rnd":
            $orderby = "RAND()";
            break;
        default:
            $orderby = "N_top desc,N_order asc,N_date desc,N_id desc";
            break;
    }

    if (strpos($num, "|") !== false) {
        $S_page = splitx($num, "|", 1);
        $num = $C_npage;
    } else {
        $num = splitx($num, "|", 0);
        $S_page = 1;
    }

    if ($S_page == "") {
        $S_page = 1;
    }

    if ($num == "0") {
        $num_info = "";
    } else {
        $num_info = "limit " . $num;
    }

    if (strpos($S_id, "tag") === false && strpos($S_id, "date") === false && strpos($S_id, "author") === false && strpos($S_id, "type") === false) {
        $S_id = splitx($S_id, "|", 0);
        if (!is_Numeric($S_id)) {
            $sql = "select * from SL_nsort where S_del=0 and S_sub=0 and S_show=1 order by S_order,S_id desc";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $S_sublist = $S_sublist . $row["S_id"] . ",";
                    $sql2 = "select * from SL_nsort where S_del=0 and S_sub=" . $row["S_id"] . " and S_show=1 order by S_order,S_id desc";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0) {
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            $S_list = $S_list . $row2["S_id"] . ",";
                        }
                    }
                }
            }
            $S_list = $S_list . "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
            $S_sublist = $S_sublist . "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
            switch ($S_id) {
                case "a":
                    $top = 0;
                    $sub_info = 0;
                    break;

                case "b":
                    $top = 1;
                    $sub_info = 0;
                    break;

                case "c":
                    $top = 2;
                    $sub_info = 0;
                    break;

                case "d":
                    $top = 3;
                    $sub_info = 0;
                    break;

                case "e":
                    $top = 4;
                    $sub_info = 0;
                    break;

                case "f":
                    $top = 5;
                    $sub_info = 0;
                    break;

                case "g":
                    $top = 6;
                    $sub_info = 0;
                    break;

                case "h":
                    $top = 7;
                    $sub_info = 0;
                    break;

                case "i":
                    $top = 8;
                    $sub_info = 0;
                    break;

                case "j":
                    $top = 9;
                    $sub_info = 0;
                    break;

                case "k":
                    $top = 10;
                    $sub_info = 0;
                    break;

                case "A":
                    $top = 0;
                    $sub_info = 1;
                    break;

                case "B":
                    $top = 1;
                    $sub_info = 1;
                    break;

                case "C":
                    $top = 2;
                    $sub_info = 1;
                    break;

                case "D":
                    $top = 3;
                    $sub_info = 1;
                    break;

                case "E":
                    $top = 4;
                    $sub_info = 1;
                    break;

                case "F":
                    $top = 5;
                    $sub_info = 1;
                    break;

                case "G":
                    $top = 6;
                    $sub_info = 1;
                    break;

                case "H":
                    $top = 7;
                    $sub_info = 1;
                    break;

                case "I":
                    $top = 8;
                    $sub_info = 1;
                    break;

                case "J":
                    $top = 9;
                    $sub_info = 1;
                    break;

                case "K":
                    $top = 10;
                    $sub_info = 1;
            }
            if ($sub_info == 0) {
                $S_id = splitx($S_list, ",", $top);
            } else {
                $S_id = splitx($S_sublist, ",", $top);
            }
        }
        $sql = "select S_id from SL_nsort where S_del=0 and S_show=1 order by S_id asc limit 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $S_aid = $row["S_id"];
        }
        if ($S_id == "0") {
            $S_id_info = "";
        } else {
            $sql = "select * from SL_nsort where S_del=0 and S_show=1 and S_id=" . intval($S_id);
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) {
                $S_sub = $row["S_sub"];
            }
            if ($S_sub != 0) {
                $S_id_info = "and S_id=" . $S_id;
            } else {
                $S_id_info = "and S_sub=" . $S_id;
            }
        }
    } else {
        switch (splitx($S_id, ":", 0)) {
            case "tag":
                $S_id_info = "and N_tag like '%," . splitx($S_id, ":", 1) . ",%'";
                break;

            case "author":
                $S_id_info = "and N_author like '" . splitx($S_id, ":", 1) . "'";
                break;

            case "date":
                $S_id_info = "and year(N_date)=" . date("Y", strtotime(splitx($S_id, ":", 1))) . " and month(N_date)=" . date("m", strtotime(splitx($S_id, ":", 1))) . " and day(N_date)=" . date("d", strtotime(splitx($S_id, ":", 1)));
                break;

            case "type":
                switch (splitx($S_id, ":", 1)) {
                    case "news":
                        $N_tp = 0;
                        break;

                    case "job":
                        $N_tp = 1;
                        break;

                    case "download":
                        $N_tp = 2;
                        break;

                    case "video":
                        $N_tp = 3;
                        break;

                    case "notice":
                        $N_tp = 4;
                        break;

                    case "team":
                        $N_tp = 5;
                        break;
                    default:
                        $N_tp = 0;
                }
                $S_id_info = "and N_type=" . $N_tp;
        }
    }

    $x = 0;
    if ($S_page==1){
        $sql = "select * from SL_news,SL_nsort where N_del=0 and S_del=0 and N_sort=S_id " . $S_id_info . " " . $show_info . " and N_sh=0 and S_show=1 order by " . $orderby ." ". $num_info;
    }else{
        $sql = "select * from SL_news,SL_nsort where N_del=0 and S_del=0 and N_sort=S_id " . $S_id_info . " " . $show_info . " and N_sh=0 and S_show=1 order by " . $orderby . " limit " . $num * ($S_page - 1) . "," . $num;
    }
    
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($S_id != "0") {
                if ($S_sub == 0) {
                    if (is_file($C_dirx . getrs("select * from SL_nsort where S_id=" . $row["S_sub"], "S_pic"))) {
                        $title_tyle = str_Replace("%新闻分类图片%", getrs("select * from SL_nsort where S_id=" . $row["S_sub"], "S_pic") , $title_tyle);
                    } else {
                        $title_tyle = str_Replace("%新闻分类图片%", "images/nopic.png", $title_tyle);
                    }
                    $title_tyle = str_Replace("%新闻分类标题%", lang(getrs("select * from SL_nsort where S_id=" . $row["S_sub"], "S_title")) , $title_tyle);
                    $title_tyle = str_Replace("%新闻分类ID%", getrs("select * from SL_nsort where S_id=" . $row["S_sub"], "S_id") , $title_tyle);
                    $title_tyle = str_Replace("%新闻分类英文标题%", lang(getrs("select * from SL_nsort where S_id=" . $row["S_sub"], "S_entitle")) , $title_tyle);
                } else {
                    if (is_file($C_dirx . $row["S_pic"])) {
                        $title_tyle = str_Replace("%新闻分类图片%", $row["S_pic"], $title_tyle);
                    } else {
                        $title_tyle = str_Replace("%新闻分类图片%", "images/nopic.png", $title_tyle);
                    }
                    $title_tyle = str_Replace("%新闻分类标题%", lang($row["S_title"]) , $title_tyle);
                    $title_tyle = str_Replace("%新闻分类ID%", $row["S_id"], $title_tyle);
                    $title_tyle = str_Replace("%新闻分类英文标题%", lang($row["S_entitle"]) , $title_tyle);
                }
            } else {
                $title_tyle = str_Replace("%新闻分类ID%", $row["S_id"], $title_tyle);
                $title_tyle = str_Replace("%新闻分类标题%", lang($C_nsorttitle) , $title_tyle);
                $title_tyle = str_Replace("%新闻分类英文标题%", lang($C_nsortentitle) , $title_tyle);
            }
            $style2 = str_Replace("%新闻分类标题%", lang($row["S_title"]) , $style);
            $style2 = str_Replace("%新闻分类英文标题%", lang($row["S_entitle"]) , $style2);
            $style2 = str_Replace("%新闻分类ID%", $row["S_id"], $style2);
            if ($row["N_strong"] == 1) {
                $style2 = str_Replace("%新闻标题%", "<b>%新闻标题%</b>", $style2);
            }
            if ($row["N_color"] != "" && !is_null($row["N_color"])) {
                $style2 = str_Replace("%新闻标题%", "<font color='" . $row["N_color"] . "'>%新闻标题%</font>", $style2);
            }
            $style2 = str_Replace("%新闻标题%", lang($row["N_title"]) , $style2);
            if (is_file($C_dirx . $row["N_pic"])) {
                $style2 = str_Replace("%新闻图片%", $row["N_pic"], $style2);
            } else {
                $style2 = str_Replace("%新闻图片%", "images/nopic.png", $style2);
            }
            $style2 = str_Replace("%新闻作者%", $row["N_author"], $style2);
            $style2 = str_Replace("%新闻简述%", lang($row["N_short"]) , $style2);
            $style2 = str_Replace("%新闻内容%", lang($row["N_content"]) , $style2);
            $style2 = str_Replace("%新闻ID%", $row["N_id"], $style2);
            $style2 = str_Replace("%发表时间%", $row["N_date"], $style2);
            $style2 = str_Replace("%发表日期%", date("Y", strtotime($row["N_date"])) . "-" . date("m", strtotime($row["N_date"])) . "-" . date("d", strtotime($row["N_date"])) , $style2);
            $style2 = str_Replace("%发表月%", date("m", strtotime($row["N_date"])) , $style2);
            $style2 = str_Replace("%发表日%", date("d", strtotime($row["N_date"])) , $style2);
            $style2 = str_Replace("%发表年%", date("Y", strtotime($row["N_date"])) , $style2);
            $style2 = str_Replace("%新闻浏览量%", $row["N_view"], $style2);
            $style2 = str_Replace("%新闻点赞量%", $row["N_like"], $style2);
            $file = explode("|", $row["N_file"] . "|||||||||||||||");
            $job = explode("|", $row["N_job"] . "|||||||||||||||");
            $team = explode("|", $row["N_team"] . "|||||||||||||||");
            $style2 = str_Replace("%招聘职位%", $job[0], $style2);
            $style2 = str_Replace("%招聘人数%", $job[1], $style2);
            $style2 = str_Replace("%工作地点%", $job[2], $style2);
            $style2 = str_Replace("%薪资水平%", $job[3], $style2);
            $style2 = str_Replace("%学历要求%", $job[4], $style2);
            $style2 = str_Replace("%经验要求%", $job[5], $style2);
            $style2 = str_Replace("%年龄要求%", $job[6], $style2);
            $style2 = str_Replace("%性别要求%", $job[7], $style2);
            $style2 = str_Replace("%语言要求%", $job[8], $style2);
            $style2 = str_Replace("%文件名称%", $file[0], $style2);
            $style2 = str_Replace("%文件大小%", $file[1], $style2);
            $style2 = str_Replace("%版本号%", $file[2], $style2);
            $style2 = str_Replace("%语言%", $file[3], $style2);
            $style2 = str_Replace("%运行环境%", $file[4], $style2);
            $style2 = str_Replace("%下载%", $file[5], $style2);
            $style2 = str_Replace("%职位%", $team[0], $style2);
            $style2 = str_Replace("%年龄%", $team[1], $style2);
            $style2 = str_Replace("%部门%", $team[2], $style2);
            $style2 = str_Replace("%学历%", $team[3], $style2);
            $style2 = str_Replace("%新闻视频%", $row["N_video"], $style2);
            $style2 = str_Replace("%i%", $x, $style2);
            $style2 = str_Replace("%j%", $x + 1, $style2);
            if ($C_html == 1 and !WAPstr()) {
                if (is_null($row["N_link"]) || $row["N_link"] == "") {
                    $style2 = str_Replace("%新闻链接%", $C_dir . $_SESSION["e"] . "html/news/" . $row["N_id"] . ".html", $style2);
                } else {
                    $style2 = str_Replace("%新闻链接%", $row["N_link"], $style2);
                }
                $style2 = str_Replace("%新闻分类链接%", $C_dir . $_SESSION["e"] . "html/new/list-" . $row["S_id"] . ".html", $style2);
            } else {
                if (is_null($row["N_link"]) || $row["N_link"] == "") {
                    $style2 = str_Replace("%新闻链接%", $C_index . "?type=newsinfo&S_id=" . $row["N_id"], $style2);
                } else {
                    $style2 = str_Replace("%新闻链接%", $row["N_link"], $style2);
                }
                $style2 = str_Replace("%新闻分类链接%", $C_index . "?type=news&S_id=" . $row["S_id"], $style2);
            }
            if ($S_id != "0") {
                if ($S_sub == "0") {
                    if ($C_html == 1 and !WAPstr()) {
                        $title_tyle = str_Replace("%新闻分类链接%", $C_dir . $_SESSION["e"] . "html/news/list-" . getrs("select * from SL_nsort where S_id=" . $row["S_sub"], "S_id") . ".html", $title_tyle);
                    } else {
                        $title_tyle = str_Replace("%新闻分类链接%", $C_index . "?type=news&S_id=" . getrs("select * from SL_nsort where S_id=" . $row["S_sub"], "S_id") , $title_tyle);
                    }
                } else {
                    if ($C_html == 1 and !WAPstr()) {
                        $title_tyle = str_Replace("%新闻分类链接%", $C_dir . $_SESSION["e"] . "html/news/list-" . $row["S_id"] . ".html", $title_tyle);
                    } else {
                        $title_tyle = str_Replace("%新闻分类链接%", $C_index . "?type=news&S_id=" . $row["S_id"], $title_tyle);
                    }
                }
            } else {
                if ($C_html == 1 and !WAPstr()) {
                    $title_tyle = str_Replace("%新闻分类链接%", $C_dir . $_SESSION["e"] . "html/news/list-" . $S_aid . ".html", $title_tyle);
                } else {
                    $title_tyle = str_Replace("%新闻分类链接%", $C_index . "?type=news&S_id=" . $S_aid, $title_tyle);
                }
            }
            $news_list2 = $news_list2 . $style2;
            $style2 = "";
            $x = $x + 1;
        }
        $news_list2 = $title_tyle . $news_list2;
    } else {
        $title_tyle = str_Replace("%新闻分类ID%", "", $title_tyle);
        $title_tyle = str_Replace("%新闻分类标题%", "该ID下暂无新闻分类", $title_tyle);
        $title_tyle = str_Replace("%新闻分类英文标题%", "null", $title_tyle);
        $title_tyle = str_Replace("%新闻分类链接%", "#", $title_tyle);
        $title_tyle = str_Replace("%新闻分类图片%", "images/nopic.png", $title_tyle);
        $style2 = str_Replace("%新闻分类标题%", "该ID下暂无新闻分类", $style);
        $style2 = str_Replace("%新闻分类英文标题%", "null", $style2);
        $style2 = str_Replace("%新闻分类ID%", "", $style2);
        $style2 = str_Replace("%新闻标题%", "该ID下暂无新闻", $style2);
        $style2 = str_Replace("%新闻图片%", "images/nopic.png", $style2);
        $style2 = str_Replace("%新闻作者%", "", $style2);
        $style2 = str_Replace("%新闻简述%", "", $style2);
        $style2 = str_Replace("%新闻内容%", "", $style2);
        $style2 = str_Replace("%新闻ID%", "", $style2);
        $style2 = str_Replace("%发表时间%", "", $style2);
        $style2 = str_Replace("%发表日期%", "", $style2);
        $style2 = str_Replace("%发表月%", "", $style2);
        $style2 = str_Replace("%发表日%", "", $style2);
        $style2 = str_Replace("%发表年%", "", $style2);
        $style2 = str_Replace("%新闻链接%", "#", $style2);
        $style2 = str_Replace("%新闻浏览量%", 0, $style2);
        $style2 = str_Replace("%新闻点赞量%", 0, $style2);
        $news_list2 = $title_tyle . $style2;
    }
    $news_list2 = str_Replace("，", ",", $news_list2);
    return $news_list2;
}

function creat_index($T_lang){
global $conn;
if(strpos($T_lang,"0")!==false){
setlang("cn");
file_put_contents("../html/index.html",e(d(c(CreateIndex(b(a("index", 1)))))));
}
if(strpos($T_lang,"2")!==false){
setlang("cht");
file_put_contents("../fhtml/index.html",cnfont(e(d(c(CreateIndex(b(a("index", 1)))))),"f"));
}
if(strpos($T_lang,"1")!==false){
setlang("en");
file_put_contents("../ehtml/index.html",e(d(c(CreateIndex(b(a("index", 1)))))));
}
}

function creat_text($T_lang,$T_id){
global $conn;
if(check_auth2("x1")){
if($T_id==""){
$sqlx="select * from SL_text where T_del=0 and order by T_order,T_id desc";
}else{
$sqlx="select * from SL_text where T_del=0 and T_id=".intval($T_id)." order by T_order,T_id desc";
}

$resultx = mysqli_query($conn,  $sqlx);
if (mysqli_num_rows($resultx) > 0) {
while($rowx = mysqli_fetch_assoc($resultx)) {
if(strpos($T_lang,"0")!==false){
setlang("cn");
file_put_contents("../html/about/".$rowx["T_id"].".html",e(d(c(CreateText(b(a("text",$rowx["T_id"])),$rowx["T_id"])))));
}
if(strpos($T_lang,"2")!==false){
setlang("cht");
file_put_contents("../fhtml/about/".$rowx["T_id"].".html",cnfont(e(d(c(CreateText(b(a("text",$rowx["T_id"])),$rowx["T_id"])))),"f"));
}
if(strpos($T_lang,"1")!==false){
setlang("en");
file_put_contents("../ehtml/about/".$rowx["T_id"].".html",e(d(c(CreateText(b(a("text",$rowx["T_id"])),$rowx["T_id"])))));
}
}
}
}
}


function creat_news_info($T_lang,$N_id){
global $conn;
if(check_auth2("x1")){
if($N_id==""){
$sqlx="select * from SL_news where N_del=0 and N_sh=0 order by N_id desc";
}else{
$sqlx="select * from SL_news where N_del=0 and N_sh=0 and N_id=".intval($N_id)." order by N_id desc";
}

$resultx = mysqli_query($conn,  $sqlx);
if (mysqli_num_rows($resultx) > 0) {
while($rowx = mysqli_fetch_assoc($resultx)) {
if(strpos($T_lang,"0")!==false){
setlang("cn");
file_put_contents("../html/news/".$rowx["N_id"].".html",e(d(c(CreateNewsInfo(b(a("newsinfo",$rowx["N_id"])),$rowx["N_id"])))));
}
if(strpos($T_lang,"2")!==false){
setlang("cht");
file_put_contents("../fhtml/news/".$rowx["N_id"].".html",cnfont(e(d(c(CreateNewsInfo(b(a("newsinfo",$rowx["N_id"])),$rowx["N_id"])))),"f"));
}
if(strpos($T_lang,"1")!==false){
setlang("en");
file_put_contents("../ehtml/news/".$rowx["N_id"].".html",e(d(c(CreateNewsInfo(b(a("newsinfo",$rowx["N_id"])),$rowx["N_id"])))));
}
}
}
}
}

function creat_news_list($T_lang,$S_id){
    global $conn,$C_npage;
if(check_auth2("x1")){

if($S_id==""){
    $sqlx="select * from SL_nsort where S_del=0 order by S_id desc";
}else{
    $sqlx="select * from SL_nsort where S_del=0 and S_id=".intval($S_id)." order by S_id desc";
}

$resultx = mysqli_query($conn,  $sqlx);
if (mysqli_num_rows($resultx) > 0) {
while($rowx = mysqli_fetch_assoc($resultx)) {
$S_sub=$rowx["S_sub"];
if($S_sub!=0){
    $sql2="select count(N_id) as N_count from SL_news where N_del=0 and N_sh=0 and N_sort=".$rowx["S_id"];
}else{
    $sql2="select count(N_id) as N_count from SL_news,SL_nsort where N_del=0 and S_del=0 and N_sh=0 and N_sort=S_id and S_sub=".$rowx["S_id"];
}
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$P_count=$row2["N_count"];
$page_num=floor($P_count/$C_npage)+1;
if($P_count % $C_npage ==0){
$page_num=$page_num-1;
}
if(strpos($T_lang,"0")!==false){
setlang("cn");
file_put_contents("../html/news/list-".$rowx["S_id"].".html",e(d(c(CreateNewsList(b(a("news",$rowx["S_id"])),$rowx["S_id"],1)))));
for ($q=1;$q< $page_num+1;$q++){
file_put_contents("../html/news/list-".$rowx["S_id"]."-".$q.".html",e(d(c(CreateNewsList(b(a("news",$rowx["S_id"])),$rowx["S_id"],$q)))));
}
}
if(strpos($T_lang,"2")!==false){
setlang("cht");
file_put_contents("../fhtml/news/list-".$rowx["S_id"].".html",cnfont(e(d(c(CreateNewsList(b(a("news",$rowx["S_id"])),$rowx["S_id"],1)))),"f"));
for ($q=1;$q<$page_num+1;$q++){
file_put_contents("../fhtml/news/list-".$rowx["S_id"]."-".$q.".html",cnfont(e(d(c(CreateNewsList(b(a("news",$rowx["S_id"])),$rowx["S_id"],$q)))),"f"));
}
}
if(strpos($T_lang,"1")!==false){
setlang("en");
file_put_contents("../ehtml/news/list-".$rowx["S_id"].".html",e(d(c(CreateNewsList(b(a("news",$rowx["S_id"])),$rowx["S_id"],1)))));
for ($q=1 ;$q<$page_num+1;$q++){
file_put_contents("../ehtml/news/list-".$rowx["S_id"]."-".$q.".html",e(d(c(CreateNewsList(b(a("news",$rowx["S_id"])),$rowx["S_id"],$q)))));
}
}
}
}

$sql="select count(N_id) as N_count from SL_news where N_del=0 and N_sh=0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$P_count=$row["N_count"];
$page_num=floor($P_count/$C_npage)+1;
if($P_count % $C_npage ==0){
    $page_num=$page_num-1;
}
if(strpos($T_lang,"0")!==false){
    setlang("cn");
    file_put_contents("../html/news/list-0.html",e(d(c(CreateNewsList(b(a("news",0)),0,1)))));
    for ($q=1;$q<$page_num+1;$q++){
        file_put_contents("../html/news/list-0-".$q.".html",e(d(c(CreateNewsList(b(a("news",0)),0,$q)))));
    }
}
if(strpos($T_lang,"2")!==false){
    setlang("cht");
    file_put_contents("../fhtml/news/list-0.html",cnfont(e(d(c(CreateNewsList(b(a("news",0)),0,1)))),"f"));
    for ($q=1 ;$q< $page_num+1;$q++){
        file_put_contents("../fhtml/news/list-0-".$q.".html",cnfont(e(d(c(CreateNewsList(b(a("news",0)),0,$q)))),"f"));
    }
}
if(strpos($T_lang,"1")!==false){
    setlang("en");
    file_put_contents("../ehtml/news/list-0.html",e(d(c(CreateNewsList(b(a("news",0)),0,1)))));
    for ($q=1 ;$q< $page_num+1;$q++){
        file_put_contents("../ehtml/news/list-0-".$q.".html",e(d(c(CreateNewsList(b(a("news",0)),0,$q)))));
    }
}
}
}

function creat_product_info($T_lang,$P_id){
    global $conn;
if(check_auth2("x1")){

if($P_id==""){
$sqlx="select * from SL_product where P_del=0 order by P_id desc";
}else{
$sqlx="select * from SL_product where P_del=0 and P_id=".intval($P_id)." order by P_id desc";
}

$resultx = mysqli_query($conn,  $sqlx);
if (mysqli_num_rows($resultx) > 0) {
while($rowx = mysqli_fetch_assoc($resultx)) {
if(strpos($T_lang,"0")!==false){
setlang("cn");
file_put_contents("../html/product/".$rowx["P_id"].".html",e(d(c(CreateProductInfo(b(a("productinfo",$rowx["P_id"])),$rowx["P_id"])))));
}
if(strpos($T_lang,"2")!==false){
setlang("cht");
file_put_contents("../fhtml/product/".$rowx["P_id"].".html",cnfont(e(d(c(CreateProductInfo(b(a("productinfo",$rowx["P_id"])),$rowx["P_id"])))),"f"));
}
if(strpos($T_lang,"1")!==false){
setlang("en");
file_put_contents("../ehtml/product/".$rowx["P_id"].".html",e(d(c(CreateProductInfo(b(a("productinfo",$rowx["P_id"])),$rowx["P_id"])))));
}

}
}

}
}
function creat_product_list($T_lang, $S_id) {
    global $conn, $C_ppage;
    if (check_auth2("x1")) {
        if ($S_id == "") {
            $sqlx = "select * from SL_psort where S_del=0 order by S_id desc";
        } else {
            $sqlx = "select * from SL_psort where S_del=0 and S_id=" . intval($S_id) . " order by S_id desc";
        }
        $resultx = mysqli_query($conn, $sqlx);
        if (mysqli_num_rows($resultx) > 0) {
            while ($rowx = mysqli_fetch_assoc($resultx)) {
                $S_sub = $rowx["S_sub"];
                if ($S_sub != 0) {
                    $sql2 = "select count(P_id) as P_count from SL_product where P_del=0 and P_sort=" . $rowx["S_id"];
                } else {
                    $sql2 = "select count(P_id) as P_count from SL_product,SL_psort where P_del=0 and S_del=0 and P_sort=S_id and S_sub=" . $rowx["S_id"];
                }
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $P_count = $row2["P_count"];
                $page_num = floor($P_count / $C_ppage) + 1;
                if ($P_count % $C_ppage == 0) {
                    $page_num = $page_num - 1;
                }
                if (strpos($T_lang, "0") !== false) {
                    setlang("cn");
                    file_put_contents("../html/product/list-" . $rowx["S_id"] . ".html", e(d(c(CreateProductList(b(a("product", $rowx["S_id"])) , $rowx["S_id"], 1)))));
                    for ($q = 1; $q < $page_num + 1; $q++) {
                        file_put_contents("../html/product/list-" . $rowx["S_id"] . "-" . $q . ".html", e(d(c(CreateProductList(b(a("product", $rowx["S_id"])) , $rowx["S_id"], $q)))));
                    }
                }
                if (strpos($T_lang, "2") !== false) {
                    setlang("cht");
                    file_put_contents("../fhtml/product/list-" . $rowx["S_id"] . ".html", cnfont(e(d(c(CreateProductList(b(a("product", $rowx["S_id"])) , $rowx["S_id"], 1)))) , "f"));
                    for ($q = 1; $q < $page_num + 1; $q++) {
                        file_put_contents("../fhtml/product/list-" . $rowx["S_id"] . "-" . $q . ".html", cnfont(e(d(c(CreateProductList(b(a("product", $rowx["S_id"])) , $rowx["S_id"], $q)))) , "f"));
                    }
                }
                if (strpos($T_lang, "1") !== false) {
                    setlang("en");
                    file_put_contents("../ehtml/product/list-" . $rowx["S_id"] . ".html", e(d(c(CreateProductList(b(a("product", $rowx["S_id"])) , $rowx["S_id"], 1)))));
                    for ($q = 1; $q < $page_num + 1; $q++) {
                        file_put_contents("../ehtml/product/list-" . $rowx["S_id"] . "-" . $q . ".html", e(d(c(CreateProductList(b(a("product", $rowx["S_id"])) , $rowx["S_id"], $q)))));
                    }
                }
            }
        }
        $sql = "select count(P_id) as P_count from SL_product,SL_psort where P_del=0 and S_del=0 and P_sort=S_id and S_type=0";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $P_count = $row["P_count"];
        $page_num = floor($P_count / $C_ppage) + 1;
        if ($P_count % $C_ppage == 0) {
            $page_num = $page_num - 1;
        }
        if (strpos($T_lang, "0") !== false) {
            setlang("cn");
            file_put_contents("../html/product/list-0.html", e(d(c(CreateProductList(b(a("product", 0)) , "0", 1)))));
            for ($q = 1; $q < $page_num + 1; $q++) {
                file_put_contents("../html/product/list-0-" . $q . ".html", e(d(c(CreateProductList(b(a("product", 0)) , "0", $q)))));
            }
        }
        if (strpos($T_lang, "2") !== false) {
            setlang("cht");
            file_put_contents("../fhtml/product/list-0.html", cnfont(e(d(c(CreateProductList(b(a("product", 0)) , "0", 1)))) , "f"));
            for ($q = 1; $q < $page_num + 1; $q++) {
                file_put_contents("../fhtml/product/list-0-" . $q . ".html", cnfont(e(d(c(CreateProductList(b(a("product", 0)) , "0", $q)))) , "f"));
            }
        }
        if (strpos($T_lang, "1") !== false) {
            setlang("en");
            file_put_contents("../ehtml/product/list-0.html", e(d(c(CreateProductList(b(a("product", 0)) , "0", 1)))));
            for ($q = 1; $q < $page_num + 1; $q++) {
                file_put_contents("../ehtml/product/list-0-" . $q . ".html", e(d(c(CreateProductList(b(a("product", 0)) , "0", $q)))));
            }
        }
    }
}
function creat_form($T_lang,$F_id){
global $conn;
if(check_auth2("x1")){

if($F_id==""){
$sqlx="select * from SL_form where F_del=0 order by F_id desc";
}else{
$sqlx="select * from SL_form where F_del=0 and F_id=".intval($F_id)." order by F_id desc";
}
$resultx = mysqli_query($conn,  $sqlx);
if (mysqli_num_rows($resultx) > 0) {
while($rowx = mysqli_fetch_assoc($resultx)) {
if(strpos($T_lang,"0")!==false){
setlang("cn");
file_put_contents("../html/form/".$rowx["F_id"].".html",e(d(c(CreateForm(b(a("form",$rowx["F_id"])),$rowx["F_id"])))));
}
if(strpos($T_lang,"2")!==false){
setlang("cht");
file_put_contents("../fhtml/form/".$rowx["F_id"].".html",cnfont(e(d(c(CreateForm(b(a("form",$rowx["F_id"])),$rowx["F_id"])))),"f"));
}
if(strpos($T_lang,"1")!==false){
setlang("en");
file_put_contents("../ehtml/form/".$rowx["F_id"].".html",e(d(c(CreateForm(b(a("form",$rowx["F_id"])),$rowx["F_id"])))));
}

}
}

}
}
function creat_guestbook($T_lang){
    global $conn;
if(check_auth2("x1")){
if(strpos($T_lang,"0")!==false){
setlang("cn");
file_put_contents("../html/guestbook/index.html",e(d(c(CreateGuestbook(b(a("guestbook",1)))))));
}
if(strpos($T_lang,"2")!==false){
setlang("cht");
file_put_contents("../fhtml/guestbook/index.html",cnfont(e(d(c(CreateGuestbook(b(a("guestbook",1)))))),"f"));
}
if(strpos($T_lang,"1")!==false){
setlang("en");
file_put_contents("../ehtml/guestbook/index.html",e(d(c(CreateGuestbook(b(a("guestbook",1)))))));
}
}
}
function creat_contact($T_lang){
    global $conn;
if(check_auth2("x1")){
if(strpos($T_lang,"0")!==false){
setlang("cn");
file_put_contents("../html/contact/index.html",e(d(c(CreateContact(b(a("contact",1)))))));
}
if(strpos($T_lang,"2")!==false){
setlang("cht");
file_put_contents("../fhtml/contact/index.html",cnfont(e(d(c(CreateContact(b(a("contact",1)))))),"f"));
}
if(strpos($T_lang,"1")!==false){
setlang("en");
file_put_contents("../ehtml/contact/index.html",e(d(c(CreateContact(b(a("contact",1)))))));
}
}
}

function qqkefu(){    //获取右侧QQ客服样式
global $conn,$C_dir,$C_domain,$C_wcode,$C_qq,$C_mobile,$C_qqon;
$sql="select * from SL_config limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$C_qq1=$row["C_qq1"];
$C_qq2=$row["C_qq2"];
$C_qq3=$row["C_qq3"];
$C_qq4=$row["C_qq4"];
$C_member=$row["C_member"];
$C_top=$row["C_top"];
$C_kfon=$row["C_kfon"];
}

if ($C_kfon==1){
$kf1="none";
$kf2="block";
}else{
$kf1="block";
$kf2="none";
}

$QQkefu="<link href='".$C_dir."css/lanrenzhijia.css' rel='stylesheet' type='text/css' /><script src='".$C_dir."js/jquery.KinSlideshow-1.2.1.min.js' type='text/javascript'></script>";
$QQkefu=$QQkefu."<div id='online_qq_layer' style='z-index:1000;'><div id='online_qq_tab'><div class='online_icon'><a target='_blank' id='floatShow' style='display:".$kf1.";' href='javascript:void(0);'>&nbsp;</a><a target='_blank' id='floatHide' style='display:".$kf2.";' href='javascript:void(0);'>&nbsp;</a></div></div><div id='onlineService' style='display:".$kf2."'><div class='online_windows overz'><div class='online_w_top'></div><div class='online_w_c overz'>";
if($C_qq1==1){
    $x=1;
    $QQkefu=$QQkefu."<div class='online_bar expand' id='onlineSort".$x."'><h2><a onclick='changeOnline(".$x.")'>".lang("在线客服/l/Online Service")."</a></h2><div class='online_content overz' id='onlineType".$x."'><ul class='overz'>";
        $qq=explode(",",lang($C_qq));
        for($i = 0 ;$i<count($qq);$i++){
        if ($qq[$i]!=""){
        if (strpos($qq[$i],"|")!==false){
        if (Is_Numeric(splitx($qq[$i],"|",0))){
        $QQkefu=$QQkefu."<li><a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://wpa.qq.com/msgrd?v=3&uin=".splitx($qq[$i],"|",0)."&site=qq&menu=yes' target='_blank' class='qq_icon'>".splitx($qq[$i],"|",1)."</a></li>";
        }else{
        $QQkefu=$QQkefu."<li><a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://www.taobao.com/webww/ww.php?ver=3&touid=".urlencode(splitx($qq[$i],"|",0))."&siteid=cntaobao&status=1&charset=utf-8' target='_blank' class='ww_icon'>".splitx($qq[$i],"|",1)."</a></li>";
        }
        }else{
        if (Is_Numeric(splitx($qq[$i]."|","|",0))){
        $QQkefu=$QQkefu."<li><a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://wpa.qq.com/msgrd?v=3&uin=".splitx($qq[$i]."|","|",0)."&site=qq&menu=yes' target='_blank' class='qq_icon'>".splitx($qq[$i]."|","|",1)."</a></li>";
        }else{
        $QQkefu=$QQkefu."<li><a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://www.taobao.com/webww/ww.php?ver=3&touid=".urlencode(splitx($qq[$i]."|","|",0))."&siteid=cntaobao&status=1&charset=utf-8' target='_blank' class='ww_icon'>".splitx($qq[$i]."|","|",1)."</a></li>";
        }
        }
        }
        }
    $QQkefu=$QQkefu."</ul></div></div>";
}
if($C_qq2==1){
$x=$x+1;
$QQkefu=$QQkefu."<div class='online_bar collapse2' id='onlineSort".$x."'><h2><a onclick='changeOnline(".$x.")'>".lang("电话客服/l/Telephone service")."</a></h2><div class='online_content overz' id='onlineType".$x."'><ul class='overz'>";
$mobile=explode("|",$C_mobile);
for($j = 0 ;$j< count($mobile);$j++){
$QQkefu=$QQkefu."<li>".$mobile[$j]."</li>";
}
$QQkefu=$QQkefu."</ul></div></div>";
}
if($C_qq3==1){
$x=$x+1;
$QQkefu=$QQkefu."<div class='online_bar collapse2' id='onlineSort".$x."'><h2><a onclick='changeOnline(".$x.")'>".lang("网站二维码/l/site QR code")."</a></h2><div class='online_content overz' id='onlineType".$x."'><ul class='overz'><script type='text/javascript' src='".$C_dir."js/qrcode.min.js'></script><div id='qrcode' style='margin:0 0 10px 10px;'></div><script>var qrcode = new QRCode('qrcode', {width: 110,height: 110,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});qrcode.makeCode('".gethttp().$C_domain."');</script></ul></div></div>";
}
if($C_qq4==1){
$x=$x+1;
$QQkefu=$QQkefu."<div class='online_bar collapse2' id='onlineSort".$x."'><h2><a onclick='changeOnline(".$x.")'>".lang("微信公众号/l/wechat")."</a></h2><div class='online_content overz' id='onlineType".$x."'><ul class='overz'><img src='".$C_dir.$C_wcode."' width='120' /></ul></div></div>";
}
$QQkefu=$QQkefu."</div><div class='online_w_bottom'></div></div></div></div>";
if($C_qqon==0){
$QQkefu="";
}
$QQkefu=$QQkefu."<link type='text/css' rel='stylesheet' href='".$C_dir."css/style.css'><div class='toolbar'>";
if($C_member==1){
$QQkefu=$QQkefu."<a href='".$C_dir."member' class='toolbar-item toolbar-item-feedback'></a>";
}
if($C_top==1){
$QQkefu=$QQkefu."<a href='javascript:scroll(0,0)' class='toolbar-item toolbar-item-top'></a>";
}
$QQkefu=$QQkefu."</div>";
return $QQkefu;
}

function dec62($n) {  //转62进制
        $base = 62;  
        $index = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';  
        $ret = '';  
        for($t = floor(log10($n) / log10($base)); $t >= 0; $t --) {  
            $a = floor($n / pow($base, $t));  
            $ret .= substr($index, $a, 1);  
            $n -= $a * pow($base, $t);  
        }  
        return $ret;  
    }  
function dec10($s) {  //转10进制
        $base = 62;  
        $index = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';  
        $ret = 0;  
        $len = strlen($s) - 1;  
        for($t = 0; $t <= $len; $t ++) {  
            $ret += strpos($index, substr($s, $t, 1)) * pow($base, $len - $t);  
        }  
        return $ret;  
    }
?>