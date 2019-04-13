<div class="siteheader">
<div class="fr">
 
<?php
if('aa'=='ywwrew--nouse'){  //nide ,no use.....
 $sqllang = "SELECT id,sitename,lang,path from ".TABLE_LANG." where pbh='".USERBH."' and sta_visible='y' and lang='" .LANG. "' order by pos desc,id limit 1";

 $langnum = getnum($sqllang);

if($langnum>0)
{
	$rowlang=getrow($sqllang);
	$sitename = $rowlang['sitename'];
	$lang=$rowlang['lang']; $path=$rowlang['path'];
	$imgpath = $stapath.'img/langimg/'.$lang.'.gif';
	$imgroot = STAROOT.'img/langimg/'.$lang.'.gif';

	$titlevv = '<img src="'.$imgpath.'" height="16" title="'.LANG.'" alt="'.LANG.'" />';
	if(!is_file($imgroot)){
		//$imgpath = $stapath.'img/langimg/langdefault.gif';
		$titlevv = $sitename;
	}


?>
     <div class="fl langimg por">
     	 <div class="clicknextshow  cp">
			<?php			 
			echo $titlevv;			 
			?>
			<i class="fa fa-caret-down"></i>
     	 </div>

	 	<div class="langimginc dn">
	 			  <?php
							  $sqllang = "SELECT id,sitename,lang from ".TABLE_LANG." where pbh='".USERBH."' and lang<>'" .LANG. "' order by pos desc,id";
								$rowlistlang = getall($sqllang);
								if($rowlistlang=='no') echo '暂无内容';
								else{
								foreach($rowlistlang as $v){
								  $lang=$v['lang'];
								  $sitename = $v['sitename'];
								  $imgpath = $stapath.'img/langimg/'.$lang.'.gif';
								  $link = '../mod_common/mod_index.php?lang='.$lang;

									$imgroot = STAROOT.'img/langimg/'.$lang.'.gif';

									if(!is_file($imgroot)) {
										$imgpath = $stapath.'img/langimg/langdefault.gif';
										$sitename2=$sitename;

									}
									else{
										$sitename2='';
									}


								  echo '<a title="'.$lang.'" href="'.$link.'">'.$sitename2.'<img src="'.$imgpath.'" alt="'.$lang.'" /></a>';
								}
							}


	 			  ?>

	 		</div>

     </div>
 <?php
	 }

}
  ?>





	 <a  class="fl tdn headerfront" href="<?php echo  BASEURLPATH;?>" target="_blank">查看网站></a>
	 <div class="fl headeruser">
	     <img class="clicknextshow" src="../cssjs/img/user.png" height="24" alt="user" />
	 		<div class="headeruserinc">
	 			 <a href="../mod_account/mod_account.php?lang=<?php echo LANG?>">超级管理员></a>
	 			  <a href="../mod_account/mod_user.php?lang=<?php echo LANG?>">普通管理员></a>

	 			 <a href="../mod_common/logout.php" title="退出"><span>退出></span></a>

	 		</div>

	 </div>
</div>

<h1 class="fl"><?php echo  $websitename.' <span style="font-size:12px;color:blue">'.$styletitle.'</span>';?></h1>

</div>

<div class="c0"></div>

<div class="navdm_mob">
<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          </div>

<ul class="navdm">
<li class="main"><a href="../mod_common/mod_index.php?lang=<?php echo LANG?>">后台首页</a></li>


<li class="main"><a href="../mod_basic/mod_lang.php?lang=<?php echo LANG?>">网站设置</a></li>

<li class="main navblock"><a href="javascript:void(0)" style="cursor:default">内容</a>
	  <div  class="poa dn xialabox">
	  <div class="xialabox_inc">
	 
  <?php 
      menu_content(); 
  ?>

	</div>
	</div>
	  <span class="subicon"><i class="fa fa-caret-down"></i></span>
</li>

<li class="main"><a href="../mod_style/mod_style.php?lang=<?php echo LANG?>">模板管理</a></li>

 <li class="main navblock"><a href="javascript:void(0)" style="cursor:default">结构</a>
	  <div  class="poa dn xialabox">
	  <div class="xialabox_inc">


<a href="../mod_imgtext/mod_mainimgtext.php?lang=<?php echo LANG; ?>&pid=common">图文生成器</a>
  <a href="../mod_blockgroup/mod_maingroup.php?lang=<?php echo LANG?>">组合区块</a>
  <a href="../mod_block/mod_block.php?lang=<?php echo LANG?>&ppid=common">区块管理</a>
	<a href="../mod_region/mod_mainregion.php?lang=<?php echo LANG; ?>&ppid=common">页面区域管理</a>
 
  <div style="height:1px;margin:0;background:#2480C4"></div>

   <a href="../mod_album/mod_mainalbum.php?lang=<?php echo LANG?>&pid=common">相册区块</a>
   <a href="../mod_video/mod_video.php?lang=<?php echo LANG?>&pid=common">视频区块</a>
	 <a href="../mod_music/mod_mainmusic.php?lang=<?php echo LANG?>&pid=common">音乐区块</a>
 <a href="../mod_form/mod_form.php?lang=<?php echo LANG?>&pid=block&type=block">表单区块</a>
 
  
	</div>
	</div>
	  <span class="subicon"><i class="fa fa-caret-down"></i></span>
</li>


  <li class="main navblock"><a href="javascript:void(0)" style="cursor:default">模块管理</a>
	  <div  class="poa dn xialabox">
	  <div class="xialabox_inc">
		 		 <a href="../mod_module/mod_baidumap.php?lang=<?php echo LANG; ?>&file=list">百度地图参数</a>
				  <a href="../mod_seo/mod_seo.php?lang=<?php echo LANG; ?>&file=page">SEO管理</a>

				 <a href="../mod_module/mod_smtp.php?lang=<?php echo LANG; ?>&file=list">邮箱设置</a>
				  <a href="../mod_tag/mod_tag.php?lang=<?php echo LANG; ?>&file=list">标签管理</a>
					<a href="../mod_auth/mod_auth.php?lang=<?php echo LANG; ?>&file=list">会员管理</a>
				  <a href="../mod_module/mod_bakdata.php?lang=<?php echo LANG; ?>&file=list"  >备份数据库</a>
			 
				 
	</div>
	</div>
	  <span class="subicon"><i class="fa fa-caret-down"></i></span>
</li>


  <li class="main navblock"><a href="javascript:void(0)" style="cursor:default">媒体和标识</a>
	  <div  class="poa dn xialabox">
	  <div class="xialabox_inc">
		<a class="needpopup" href="../mod_imgfj/mod_imgfj.php?pid=name&lang=<?php echo LANG; ?>"  >名称附件管理</a>
		<a class="needpopup" href="../mod_imgfj/mod_imgfj.php?pid=common&lang=<?php echo LANG; ?>" >公共编辑器附件管理</a>
	 	<?php echo showblockid(); ?>

	</div>
	</div>
	<span class="subicon"><i class="fa fa-caret-down"></i></span>
</li>


</ul>

<div class="c0"></div>
<?php 
global $menu_content;
if($menu_content=='y'){
	echo '<div class="menucurcnt">';
	menu_content();
	echo '</div>';
}


function  menu_content(){
	echo '<a href="../mod_menu/mod_mainmenu.php?lang='.LANG.'">菜单管理</a>';
	echo '<a href="../mod_page/mod_page.php?lang='.LANG.'">单页面管理</a>';
	echo '<a href="../mod_category/mod_category.php?lang='.LANG.'">分类管理</a>';
	 echo '<a href="../mod_node/mod_node.php?lang='.LANG.'">内容管理</a>';
//	echo ' <a href="../mod_category/mod_fefilecate.php?lang='.LANG.'">效果区块内容管理</a>';

}

?>