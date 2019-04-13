<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
define('BASEURL',$baseurl);
define("HOSTNAME", $_SERVER['HTTP_HOST']);

ini_set('display_errors', TRUE);//false
//ini_set("error_reporting","E_ALL & ~E_NOTICE");
  //ini_set('display_errors', FALSE);
//define('WEB_ROOT', substr(dirname(__FILE__), 0, -4));
//define('TPLBASEROOT',WEB_ROOT.'html/');
//define('SES_ROOT',WEB_ROOT.'cache\ses');
//change below in single website

define( 'WEB_ROOT', dirname(__FILE__) . '/' );
//define('WEB_ROOT', substr(dirname(__FILE__), 0, -22));


//define('SES_ROOT',WEB_ROOT.'cache/session');
define('INCLUDE_ROOT',WEB_ROOT.'component/dm-include/');
define('TEMPLATEROOT',WEB_ROOT.'DM-template/');
define('TEMPLATEPATH',$baseurl.'DM-template/');
define('REGIONROOT',WEB_ROOT.'DM-region/');
define('REGIONPATH',$baseurl.'DM-region/');
define('ADMINDIR',@$_COOKIE['admindir']);
define('ISADMIN',@$_COOKIE['isadmin']);
$PHP_SELF=$_SERVER['PHP_SELF']; 


// echo dirname(__FILE__).'<br />';

//  echo TPLBASEROOT.'<br />';
 // echo WEB_ROOT.'<br />';
 //echo SES_ROOT.'<br />';
$installoldname = WEB_ROOT.'install.php';
if(is_file($installoldname)){
	$installrand = 'install'.rand(1111,9999).'6'.rand(1111,9999).'.php';
	$installtemp = WEB_ROOT.$installrand;
	//echo $installtemp;
	rename($installoldname,$installtemp);
	 echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' ;
		 echo '对不起，根目录不能有install.php文件，已经给其随机改名为:'.$installrand.'<a href="'.$installrand.'">(点击开始安装)</a>'; 

		 exit; 
}

//----------
$cfg_cinc='component/dm-config/';
require_once WEB_ROOT.$cfg_cinc.'inc_table.php';
require_once WEB_ROOT.$cfg_cinc.'config.php';
require_once WEB_ROOT.$cfg_cinc.'text_can.php';
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
 
$fid = @intval($_GET['fid']);$search = @htmlentitdm($_GET['search']);$searchpage = @htmlentitdm($_GET['searchpage']);//htmlspecialchars
//
if(empty($act)) $act='index';
if($catid=='') $catid=0;

/*------------some variable------------*/

$dateall = date("Y-m-d H:i:s");
$dateday = date("Y-m-d");

//-----begin lang-------------

//-----begin lang-------------


 
//多站点代码 multisite code：
define('MAINLANG', $mainlang);  //must here ,only use in front
define('LANG', $mainlang);
 define('LANGPATH',  $mainlang); //when no multi lang...
 define('BASEURLPATH',  $baseurl);

//-----end lang------------- 

//-----end lang------------- 

/*------------------------------------*/
$sql = "SELECT bh from ".TABLE_USER." where userdir='$userdir'   limit 1";
	if(getnum($sql)==0){ echo  'not exist user...';exit;}
	else{
		$row = getrow($sql); 
		$user2510= $userbh = $row['bh'];
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
		
		$cdnurl ='';


		//must be here

	 

$tagmaxline=20; //just init.
$searcherror='';
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
				 define('BLOCKROOT', WEB_ROOT.'DM-block/');//base hmtl dir
				 define('EFFECTROOT', WEB_ROOT.'DM-block/');//base hmtl dir
				define('UPLOADROOT',STAROOT.'upload/');
				define('UPLOADROOTIMAGE',STAROOT.'upload/image/'.$uploaddir);
				define('TMIMG',STAPATH.'img/tm.gif');
				
		 


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
	//$pidmenu = $rowstyle['pidmenu'];  //move to layout...
	$pidregion = $rowstyle['pidregion'];$pidregionmobile = $rowstyle['pidregionmobile'];
	$htmldir = $rowstyle['htmldir'];
	//$header_pc = $rowstyle['header_pc']; $header_mobile = $rowstyle['header_mobile']; $skincss = $rowstyle['skincss'];
	$addDMcssjs = $rowstyle['addDMcssjs'];
	$addcss = $rowstyle['addcss'];
	$addjs = $rowstyle['addjs'];
	$sta_bootstrap = $rowstyle['sta_bootstrap'];
	$sta_bootstrap = $rowstyle['sta_bootstrap'];

 

	/*------------css dir--------------------------------------*/

      
       define('TPLBASEROOT', TEMPLATEROOT.'base/');//base hmtl dir
      // if(!is_dir(TPLBASEROOT)) echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><p style="padding:10px;background:red">base模板目录不存在！</p>';
		   //alert('html目录'.$htmldir.'不存在！');

          define('HTMLDIR', $htmldir);
           define('TPLCURROOT', TEMPLATEROOT.$htmldir.'/'); //cur html dir
		  //echo TPLCURROOT;

       if(!is_dir(TPLCURROOT))
       	{
       		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><p style="padding:10px;background:red"> 模板目录'.$htmldir.'不存在！请到官网确定此模板是否需要购买，或参考视频教程来创建模板。</p>';
       		exit;
       	}


	   define('TPLCURPATH',TEMPLATEPATH.$htmldir.'/');
	 
 
       define('DEFAULTIMG',STAPATH.'img/defaultimg.jpg');
       define('DEFAULTIMGDIV','<img src="'.DEFAULTIMG.'" alt="" />');


	/*-----------style_blockid-----------------*/
    $bscntarr = explode('==#==',$style_blockid);

    $bsbannertop=$bsbanner=$bsbannermob=$bsindex=$bsindexmob=$bsmenu=$bsheadertop=$bsheader=$bsheaderlogo=$bsheadertext=$bsheadersearch=$bsfooterbegin=$bsfooter=$bsfooterbar=$bsfooterlast=$bsfooternavmob=$bsblock404=$sta_narrowscreen=$sta_header_fullwidth=$sta_menuright=$sta_menufix='';
     $bsheaderlogomobi='';
//bsfooterbegin,bsheaer no use, add footercols and links, add logo and text and search....


     if(count($bscntarr)>1){  
        foreach ($bscntarr as   $bsvalue) {
           $bsvaluearr = explode(':##',$bsvalue);
           $bsccc = $bsvaluearr[0];
           $$bsccc=$bsvaluearr[1];
        }
    }
    //------------
    if(isdmmobile()){
    	 $logoimg = $bsheaderlogomobi==''?$bsheaderlogo:$bsheaderlogomobi;
    	 $pidregion = $pidregionmobile==''? $pidregion:$pidregionmobile;
    	  }
    else $logoimg = $bsheaderlogo; 
  
    //-------------------

  }
 else{
 	echo 'sorry,not found,maybe style and lang not match......pls refresh page, or contact us: www.demososo.com';
 	setcookie("curstyle",'');//the reste cookie........
 	exit;
 }


//----------------------

}




if($cdnurl<>'')   define('UPLOADPATH', $cdnurl);
 else  define('UPLOADPATH', $stapath.'upload/');
define('UPLOADPATHIMAGE', UPLOADPATH.'image/'.$uploaddir);

?>
<?php
require_once INCLUDE_ROOT.'func_frontcommon.php';

$langfileV = WEB_ROOT.'component/lang/'.$langfile;
if(checkfile($langfileV)) require_once($langfileV);

require_once INCLUDE_ROOT.'func_block.php';
//function layoutcur($pid,$type){  //invoke is in page
require_once INCLUDE_ROOT.'func_layout.php';
layoutcommon(); //must need

//--------for member---
$filefilefile = $file; //use in meta_cssjs.php,when member,add member.css...just avoid repeat name $file,
//echo $filefilefile;
 if(is_int(strpos($file,'/'))) {   //use for $file='file_formpost/formpost_'.$type; ... in dmpostform.php
$filev = INCLUDE_ROOT.$file.'.php';
  		 if(is_file($filev)) require_once $filev;
  		 else echo $file.'.php  - file not exist;';
}
 else  require_once INCLUDE_ROOT.'file_inc.php';
 
?>
