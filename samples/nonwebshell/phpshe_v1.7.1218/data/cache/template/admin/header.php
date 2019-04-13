<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $seo['title'] ?></title>
<meta name="keywords" content="<?php echo $seo['keywords'] ?>" />
<meta name="description" content="<?php echo $seo['description'] ?>" />
<link rel="shortcut icon" type="image/ico" href="<?php echo $pe['host_root'] ?>favicon.ico">
<link type="text/css" rel="stylesheet" href="<?php echo $pe['host_tpl'] ?>css/style.css" />
<script type="text/javascript" src="<?php echo $pe['host_root'] ?>include/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $pe['host_root'] ?>include/js/global.js"></script>
<script type="text/javascript" src="<?php echo $pe['host_root'] ?>include/js/arttpl.js"></script>
<script type="text/javascript" src="<?php echo $pe['host_root'] ?>include/plugin/layer/layer.js"></script>
</head>
<body style="overflow-y:hidden">
<div class="bgimg"></div>
<div class="pagetop">
	<div class="head">
		<div class="logo fl"><img src="<?php echo $pe['host_tpl'] ?>images/logo.png"></div>
		<div class="head_r fr">
			<a href="admin.php" class="head_tb1" style="border-left:0"><s></s>概况</a>
			<a href="admin.php?mod=moban" class="head_tb8"><s></s>模板</a>
			<a href="admin.php?mod=tongji" class="head_tb3"><s></s>统计</a>
			<a href="admin.php?mod=db" class="head_tb5"><s></s>备份</a>
			<a href="admin.php?mod=cache" class="head_tb6"><s></s>缓存</a>
			<a href="<?php echo $pe['host_root'] ?>" target="_blank" class="head_tb7"><s></s>首页</a>
			<a href="admin.php?mod=do&act=logout" class="head_tb2" style="background:none"><s></s>退出</a>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="content">
	<div class="left">
		<?php foreach($adminmenu as $k=>$v):?>
		<?php if(!$v['show'])continue;?>
		<div class="fenlei">
			<h3 class="fl_tb<?php echo $k ?>"><s></s><?php echo $v['headnav'] ?></h3>
			<ul>
				<?php foreach($v['subnav'] as $kk=>$vv):?>
				<?php if(!$vv['show'])continue;?>
				<li class="<?php if($vv['menumark']==$menumark):?>sel<?php endif;?>"><a href="<?php echo $vv['url'] ?>"><span>├</span><?php echo $vv['name'] ?></a></li>
				<?php endforeach;?>
			</ul>
			<div class="clear"></div>
			<?php if($k!=6):?><div class="xian"></div><?php endif;?>
		</div>
		<?php endforeach;?>
	</div>