<?php 
require '../conn/conn2.php';
require '../conn/function.php';


$dir=str_replace("/", "\\",dirname(__FILE__));
if($_GET["action"]=="mod"){
  mysqli_query($conn,"update SL_config set C_admin='".splitx($dir,"\\",count(explode("\\",$dir))-1)."'");
  box("修复成功！","./","success");
}
if(splitx($dir,"\\",count(explode("\\",$dir))-1)!=$C_admin){
  die("后台目录出错！<a href='?action=mod'>点击此处</a>进行修复");
}

?>
<!DOCTYPE html>
<html data-ng-app="app">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <meta charset="utf-8" />
  <title>后台管理</title>
  <link href="<?php echo $C_dir.$C_ico?>" rel="shortcut icon" />
  <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <link rel="stylesheet" href="css/bootstrap.css?v=<?php echo gen_key(20)?>" type="text/css" />
  <link rel="stylesheet" href="css/animate.css?v=<?php echo gen_key(20)?>" type="text/css" />
  <link rel="stylesheet" href="../css/css/font-awesome.min.css?v=<?php echo gen_key(20)?>" type="text/css" />
  <link rel="stylesheet" href="css/app.css?v=<?php echo gen_key(20)?>" type="text/css" />
  <link rel="stylesheet" href="../css/sweetalert.css?v=<?php echo gen_key(20)?>" type="text/css" />
</head>
<body ng-controller="AppCtrl">
<!--[if lt IE 9]><div class="low"><h3>您的浏览器版本太低，请先升级！</h3>推荐：谷歌浏览器、火狐浏览器、IE9+、360浏览器（极速模式）</div><![endif]-->
  <div class="app" id="app" ng-class="{'app-header-fixed':app.settings.headerFixed, 'app-aside-fixed':app.settings.asideFixed, 'app-aside-folded':app.settings.asideFolded, 'app-aside-dock':app.settings.asideDock, 'container':app.settings.container}" ui-view></div>
  <script>window.langcode="php"</script>
  <script src="js/jquery.min.js?v=<?php echo gen_key(20)?>"></script> <!-- 必需 -->
  <script src="js/angular.min.js?v=<?php echo gen_key(20)?>"></script> <!-- 必需 -->
  <script src="js/angular-ui-router.js?v=<?php echo gen_key(20)?>"></script> <!-- 必需 -->
  <script src="js/ui-bootstrap-tpls.js?v=<?php echo gen_key(20)?>"></script> <!-- 必需 -->
  <script src="js/ocLazyLoad.js?v=<?php echo gen_key(20)?>"></script> <!-- 必需 -->
  <script src="js/all.js?v=<?php echo gen_key(20)?>"></script> <!-- 必需 -->
  <script src="../js/sweetalert.min.js?v=<?php echo gen_key(20)?>"></script> <!-- 必需 -->
  <script src="../js/qrcode.min.js?v=<?php echo gen_key(20)?>"></script> <!-- 必需 -->

  <script type="text/javascript" src="../ueditor/ueditor.config.js?v=<?php echo gen_key(20)?>"></script>
  <script type="text/javascript" src="../ueditor/ueditor.all.min.js?v=<?php echo gen_key(20)?>"></script>

</body>
</html>