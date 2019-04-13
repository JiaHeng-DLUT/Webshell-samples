<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
define('BASEURL',$baseurl);
define("HOSTNAME", $_SERVER['HTTP_HOST']);

ini_set('display_errors', TRUE);//false

define( 'WEB_ROOT', substr(dirname(__FILE__),0,-4) . '/' );



define('SES_ROOT',WEB_ROOT.'cache/session');
define('INCLUDE_ROOT',WEB_ROOT.'component/dm-include/');
define('TEMPLATEROOT',WEB_ROOT.'DM-template/');
define('TEMPLATEPATH',$baseurl.'DM-template/');
define('ADMINDIR',@$_COOKIE['admindir']);
define('ISADMIN',@$_COOKIE['isadmin']);

// echo dirname(__FILE__).'<br />';

//  echo TPLBASEROOT.'<br />';
 // echo WEB_ROOT.'<br />';
 //echo SES_ROOT.'<br />';
$PHP_SELF=$_SERVER['PHP_SELF'];


//--
$cfg_cinc='component/dm-config/';
require_once WEB_ROOT.$cfg_cinc.'inc_table.php';
require_once WEB_ROOT.$cfg_cinc.'config.php';
//require_once WEB_ROOT.$cfg_cinc.'text_can.php';
//require_once WEB_ROOT.$cfg_cinc.'fsession.php';
require_once WEB_ROOT.$cfg_cinc.'database.php';
require_once WEB_ROOT.$cfg_cinc.'mysql.php';
require_once WEB_ROOT.$cfg_cinc.'global.common.php';

//front func echo SES_ROOT.'<br />';

$targetv = ''; //$targetv is set in page_search, and list_text.php
$routeid='';$alias='';$ifalias='';$offset=5;$page_total='';
 
$routeid = @htmlentitdm($_GET['routeid']);
$alias = @htmlentitdm($_GET['alias']);
$ifalias = @htmlentitdm($_GET['ifalias']);
if(@$file=='')  $file = @htmlentitdm($_GET['file']);
$detailid = @htmlentitdm($_GET['detailid']);$brandid = @htmlentitdm($_GET['brandid']);
$page = @htmlentitdm($_GET['page']);
 if (!isset($page)) $page=1; 
$pagelayout ='';

	/*------------some variable------------*/
		$title='';
		$pid=$curpidname = $pidname ='';
		$maintitle = $mainpid= $mainpidname= $mainalias='';//parent parent
		$modtype='';
		$sidebarcss =  $contentcss =  $bodycss='';

		$maxline= $listfg ='';
		$breadarr = array();
		$seo1 = array();$seo2 = array();$seo3 = array();
		//array_push($stack, "apple", "raspberry");
		//array_unshift($seo1, $row['seo1']);


//
$act = @htmlentitdm($_GET['act']);$act2 = @htmlentitdm($_GET['act2']);$pidname = @htmlentitdm($_GET['pidname']);
$alias = @htmlentitdm($_GET['alias']);$tid = @intval($_GET['tid']);
$catid = @intval($_GET['catid']);
//$page = @intval($_GET['page']);//page is in file_inc.php
$fid = @intval($_GET['fid']);$search = @htmlentitdm($_GET['search']);$searchpage = @htmlentitdm($_GET['searchpage']);//htmlspecialchars
//
if(empty($act)) $act='index';
if($catid=='') $catid=0;

/*------------some variable------------*/

$dateall = date("Y-m-d H:i:s");
$dateday = date("Y-m-d");

//-----begin lang-------------


if(SITEIDBYDOMAIN=='y'){  // 通过域名来判断 站点(语言)的id
     	$sitedomain = $_SERVER['HTTP_HOST'];

		 //echo $sitedomain.'<br />';

		$sql = "SELECT lang,domain from ".TABLE_LANG."  where sta_visible='y' order by pos desc,id desc";
		//echo $sql;
		$mainlang ='';
         if(getnum($sql)>0){
         	$rowall= getall($sql); //pre($rowall);
         	foreach ($rowall as  $v) {
         		  if($sitedomain==$v['domain'])  $mainlang = $v['lang'];
         	}
         }
        if($mainlang=='') { echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' ;
						echo '对不起，没有找到域名对应的站点( 取查找处于显示状态的站点)。'; exit; }

  $langcur = $mainlang;//must need
  define('BASEURLPATH',  $baseurl);
  define('LANGPATH',  $mainlang);
}
else{
        $langcur = $mainlang;//must need ，只有后缀时，才有主语言之分。通过域名时则没有主语言的说话，因为域名决定了主语言
		$langpath = @htmlentitdm($_GET['lang']); //path(suffix) is not lang.
		 //echo $langpath.'==';
		define('LANGPATH',  $langpath); //use  BASEURL/dmpostform.php,add surfix ,lang = LANGPATH,not LANG
		if($langpath<>'')  {
			
				$langcur = get_field(TABLE_LANG,'lang',$langpath,'langpath');

				if($langcur=='noid'){
				  require(WEB_ROOT.'DM-template/base/page_404lang.php');

				   exit;
				}

		 }
		if($langcur==$mainlang)   define('BASEURLPATH',  $baseurl);
		else {
			if(ENABLEMULTISITE=='y') define('BASEURLPATH',  $baseurl.$langpath.'/');
			else define('BASEURLPATH',  $baseurl);
		}

}

//多站点代码 multisite code：
define('MAINLANG', $mainlang);  //must here ,only use in front
define('LANG', $langcur);
//define('LANGPATH',  $mainlang); //when no multi lang...
//define('BASEURLPATH',  $baseurl);

//-----end lang------------- 

/*------------------------------------*/
$sql = "SELECT bh from ".TABLE_USER." where userdir='$userdir'   limit 1";
	if(getnum($sql)==0){ echo  'not exist user...';exit;}
	else{
		$row = getrow($sql);
		$userbh = $row['bh'];
		define('USERBH', $userbh);
		$andlangbh=" and lang='".LANG."'  and pbh='".USERBH."' ";
		$noandlangbh=" lang='".LANG."'  and pbh='".USERBH."' ";
		define('ANDLANGBH', $andlangbh);
		define('NOANDLANGBH', $noandlangbh);



		$sql = "SELECT * from ".TABLE_LANG." where lang='".LANG."'  limit 1";
		$row = getrow($sql);
		if($row=='no') die('sorry,no lang...'.LANG);
		$websitename = $row['sitename'];
		$langfile = $row['langfile'];
		 $arr_assets = $row['arr_assets'];
		$arr_basicset = $row['arr_basicset'];
		$arr_smtp = $row['arr_smtp'];

		$curstyle = $row['curstyle'];//use for if editlink


		//must be here

		 //if(@$_COOKIE["curstyless"]<>'') 	 $curstyle = $_COOKIE["curstyless"];
		//  else  header('Location:http://www.demososo.com/mb.html');



        //-----arr_basicset---------------------
	$bscntarr = explode('==#==',$arr_basicset);
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }

      $bscntarr = explode('==#==',$arr_assets);
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }



		define('CSSVERSION',$cssversion);
		define('STA_FRONTEDIT',$sta_frontedit);

		/*---------some config, other in config.php above require*/
				$uploaddir=LANG.'/';
				$stapath=$baseurl.$stadir;
				define('STAPATH', $stapath);
				define('STAROOT',WEB_ROOT.$stadir);
				define('UPLOADROOT',STAROOT.'upload/');
				define('UPLOADROOTIMAGE',STAROOT.'upload/image/'.$uploaddir);
				define('TMIMG',STAPATH.'img/tm.gif');

				define('LIBSPATH',STAPATH.'app/libs/');




        define('ADMIN', 'n');//use url function when link target
		//---------------

// $bsbanner=$bsbannermob=$bsindex=$bsindexmob=$bsmenu=$bsfooter=$bsfootermob=$bsfooternavmob='';
$sqlstyle = "SELECT * from ".TABLE_STYLE." where pidname='$curstyle' $andlangbh limit 1";
 //echo $sqlstyle;exit;
if(getnum($sqlstyle)>0){
	$rowstyle = getrow($sqlstyle);
	 // pre($rowstyle);
   $sta_sqlcss = $rowstyle['sta_sqlcss'];
	$style_blockid = $rowstyle['style_blockid'];
	$pidmenu = $rowstyle['pidmenu'];
	$pidregion = $rowstyle['pidregion'];
	$htmldir = $rowstyle['htmldir'];$headereffect = $rowstyle['headereffect'];
	$addcss = $rowstyle['addcss'];$addjs = $rowstyle['addjs'];
	$sta_bootstrap = $rowstyle['sta_bootstrap'];
	$sta_bootstrap = $rowstyle['sta_bootstrap'];

	/*------------css dir--------------------------------------*/

       define('TPLBASEROOT', TEMPLATEROOT.'base/');//base hmtl dir
       if(!is_dir(TPLBASEROOT)) echo '<p style="padding:10px;background:red">base模板目录不存在！</p>';
		   //alert('html目录'.$htmldir.'不存在！');

          define('HTMLDIR', $htmldir);
           define('TPLCURROOT', TEMPLATEROOT.$htmldir.'/'); //cur html dir
		  //echo TPLCURROOT;

       if(!is_dir(TPLCURROOT))
       	{
       		echo '<p style="padding:10px;background:red"> 模板目录'.$htmldir.'不存在！请到官网确定此模板是否需要购买，或参考视频教程来创建模板。</p>';
       		exit;
       	}


	   define('TPLCURPATH',TEMPLATEPATH.$htmldir.'/');

         define('DISPLAYROOT',TPLBASEROOT.'display/');
          define('PARTROOT',TPLBASEROOT.'part/');
		define('EFFECTROOT',TPLBASEROOT.'block/');//old is effect,now is base/block

      define('TPLBASEPATH', TEMPLATEPATH.'base/');

       define('DEFAULTIMG',STAPATH.'img/defaultimg.jpg');
       define('DEFAULTIMGDIV','<img src="'.DEFAULTIMG.'" alt="" />');


	/*-----------style_blockid-----------------*/
    $bscntarr = explode('==#==',$style_blockid);

    $bsbannertop=$bsbanner=$bsbannermob=$bsindex=$bsindexmob=$bsmenu=$bsheadertop=$bsheader=$bsheaderlogo=$bsheadertext=$bsheadersearch=$bsfooterbegin=$bsfooter=$bsfooterbar=$bsfooterlast=$bsfooternavmob=$bsblock404=$sta_narrowscreen=$sta_header_fullwidth=$sta_menuright=$sta_menufix='';
//bsfooterbegin,bsheaer no use, add footercols and links, add logo and text and search....


     if(count($bscntarr)>1){  
        foreach ($bscntarr as   $bsvalue) {
           $bsvaluearr = explode(':##',$bsvalue);
           $bsccc = $bsvaluearr[0];
           $$bsccc=$bsvaluearr[1];
        }
    }



  }
 else{
 	echo 'sorry,not found,maybe style and lang not match......pls refresh page, or contact us: www.demososo.com';
 	setcookie("curstyle",'');//the reste cookie........
 	exit;
 }


//----------------------

}




//if($cdn<>'' && $sta_cdn=='y')   define('UPLOADPATH', $cdn.'/upload/');
//else define('UPLOADPATH', $stapath.'upload/');
define('UPLOADPATH', $stapath.'upload/');
define('UPLOADPATHIMAGE', UPLOADPATH.'image/'.$uploaddir);
?>
<?php
require_once INCLUDE_ROOT.'func_frontcommon.php';
$langname = 'component/lang/'.$langfile;
$langfileV = WEB_ROOT.$langname;

reqfile($langfileV,$langname);

 
require_once WEB_ROOT.'api/apiinc/file_apiinc.php';

?>
