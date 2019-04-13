

<?php 
 
if($type=='all'){ //generate all style;

 $ssall = "select * from ".TABLE_STYLE." where  $noandlangbh  limit 100";
    $rowall = getall($ssall); 
    foreach ($rowall as $vall) {

      $pidname = $vall['pidname']; 
     generatecss($pidname,$htmldir);
 }
    

}
else {generatecss($pidname,$htmldir);}
  //---------------------
//htmldir is in common.inc

function generatecss($pidname,$htmldir){

 
 // echo $pidname;
  global $andlangbh;global $bshou;global $superadmin;
  $filename='sql_'.$pidname;
  //------------------------------

    $sql = "SELECT htmldir from ".TABLE_STYLE."  where  pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);
$htmldir=$row['htmldir'];
 
//---------------------------------

  $cssfilename = $htmldir .'/css/sql_'.$htmldir.'.css';
 $cssfileroot = TEMPLATEROOT.$cssfilename;
 $cssfilepath = TEMPLATEPATH.$cssfilename;

if(!is_file($cssfileroot )){
  echo '模板目录下的'.$cssfilename.'不存在。';
  exit;
}
 
 
//------------------------------
    $ss = "select * from ".TABLE_STYLE."   where pidname='$pidname' $andlangbh limit 1";
    $row = getrow($ss); 
    if($row=='no'){ echo 'no result , pidname is wrong.'.$pidname;}
      else{
           $title = $row['title'];

            $style_normal = $row['style_normal'];  
            $style_hf = $row['style_hf'];
            $style_menu = $row['style_menu'];
            $style_boxtitle = $row['style_boxtitle']; 
            $style_banner = $row['style_banner']; 
         

  /*----------------style_normal------------*/
$bscntarr = explode('==#==',$style_normal); 
//pre($bscntarr);
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
              if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }
      else{
      $body_bgcolor=$body_bgimg=$body_bgimgset=$pagewidth='';
      $color_body=$color_a=$color_ahover='';
      }


 /*-----------------style_hf----------*/
$bscntarr = explode('==#==',$style_hf); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }
      else{
      $header_bgcolor=$header_bgimg='';
      $header_color=$header_color_a=$header_color_ahover='';
      $footer_bgcolor=$footer_bgimg=$footer_color=$footer_color_a=$footer_color_ahover='';
       $footerbar_bgcolor=$footerbar_color=$footerbar_color_a=$footerbar_color_ahover='';
      $sta_header_width='';
      }

 /*---------------style_menu----------*/
$bscntarr = explode('==#==',$style_menu); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }
      else{
      $menu_bgcolor=$menu_bgimg=$menu_color='';
      $menu_bgcolor_h=$menu_bgimg_h=$menu_color_h='';
      $menu_height=$menu_border='';

      $msub_bgcolor=$msub_color='';
      $msub_bgcolor_h=$msub_color_h='';
      $msub_height=$msub_border='';

      $sta_menuright=''; 

      }
 /*---------------style_banner----------*/
$bscntarr = explode('==#==',$style_banner); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }
      else{
      $banner_bgcolor=$banner_bgimg=$banner_color=''; 
       $menu_style='';

      }

 /*----------------style_boxtitle----------*/

$bscntarr = explode('==#==',$style_boxtitle); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }
      else{
      $boxtitle_height=$boxtitle_bgcolor='';
      $boxtitle_bgimg=$boxtitle_color='';
      }

/*-------------------desp------------------------*/
          
         //  $desp = $row['desp'];
         
         //   $despv=str_replace("[uploadpath]",UPLOADPATHIMAGE,$desp);
 
            
/**************begin generate*************************************/
            switch ($body_bgimgset)
                  {
                  case 'norepeat':
                     $body_bgimgset = 'center 0 no-repeat';
                    break;  
                  case 'repeatx':
                    $body_bgimgset = '0 0 repeat-x';
                    break;
                  case 'repeaty':
                    $body_bgimgset = 'center 0 repeat-y';
                    break;  
                  //default:
                   // code to be executed                     
                  }
                  /*

               background-image:url('a.jpg');
               background-repeat    : repeat;
               background-attachment: fixed;
               background-position  : right top;
                  */
if($body_bgimg<>'')  $body_bgimg =  "url('".genercss_orhttpimg($body_bgimg)."') $body_bgimgset";
if($header_bgimg<>'')  $header_bgimg =  "url('".genercss_orhttpimg($header_bgimg)."') 0 0 repeat-x";
if($footer_bgimg<>'')  $footer_bgimg =  "url('".genercss_orhttpimg($footer_bgimg)."') 0 0 repeat-x";
if($menu_bgimg<>'')  $menu_bgimg =  " url('".genercss_orhttpimg($menu_bgimg)."') 0 0 repeat-x";
if($menu_bgimg_h<>'')  $menu_bgimg_h =  "url('".genercss_orhttpimg($menu_bgimg_h)."') center center no-repeat";
if($banner_bgimg<>'')  $banner_bgimg =  "url('".genercss_orhttpimg($banner_bgimg)."') center top no-repeat ;background-size:cover; ";
if($boxtitle_bgimg<>'')  $boxtitle_bgimg =  "url('".genercss_orhttpimg($boxtitle_bgimg)."') 0 0 repeat-x";

$bodybg ='background:'.$body_bgcolor.' '.$body_bgimg.'; ';
if($body_bgcolor==='' && $body_bgimg=='') $bodybg ='';

  $bodybgcss =  "body{ $bodybg  color:$color_body} \n .container{width: $pagewidth; margin-left:auto;margin-right:auto;position:relative; }"; 
 $color_a = "\n a{color:$color_a;text-decoration:none; } a:hover{color:$color_ahover}";


 $menucss = "\n.menu{background:$menu_bgcolor $menu_bgimg;height: $menu_height ;line-height:$menu_height;border-bottom:$menu_border;z-index:99;    } \n .menu li.m{background:$menu_bgcolor;border-bottom:$menu_border;}  \n .menu a{color:$menu_color} \n .menu a:hover,.menu a.active{background:$menu_bgcolor_h $menu_bgimg_h;color:$menu_color_h}";
 $msubcss = "\n.menu li li{background:$msub_bgcolor;height: $msub_height ;line-height:$msub_height;border-bottom:$msub_border;z-index:99;    } \n .menu li li a{color:$msub_color} \n .menu li li a:hover,.menu li li a.active{background:$msub_bgcolor_h;color:$msub_color_h}";
 $othercolor = " \n .sidebar a.active{font-weight:bold;color:$boxtitle_bgcolor}\n .topsearch .searchbtn{background:$boxtitle_bgcolor;color:#fff }\n .pageroll a,.pageroll span{border:1px solid #ddd;background:#e2e2e2;color:$menu_bgcolor;}\n.pageroll span{color:#bbb}\n.pageroll a.cur,.pageroll a:hover{color:$menu_color;background:$menu_bgcolor}\n .bx-wrapper .bx-pager.bx-default-pager a:hover,
.bx-wrapper .bx-pager.bx-default-pager a.active{background:$boxtitle_bgcolor;}";

/*banner----------------------*/
$bannercommon = "";
if($banner_enable=='y'){
   $bannercommon =  " .bannertext{display:block; } .bannerboth .bannertext{display:none; }";
}
else $bannercommon =  " .bannertext{display:none; }";

if($banner_textfirst=='y' && $banner_enable=='y'){
 $bannercommon .=  " .bannerboth .bannerimg{display:none; } .bannerboth .bannertext{display:block; }";
}
 
 $bannerbg ='background:'.$banner_bgcolor.' '.$banner_bgimg.'; ';
if($banner_bgcolor==='' && $banner_bgimg=='') $bannerbg ='';

$bannercommon .= ".bannertext{text-align:center;font-weight:300; $bannerbg  $banner_style;} \n.bannertext h1 {font-size:35px;color:$banner_color;font-weight:400} \n ";

$bannermobile = ".bannertext{padding:30px 0} \n.bannertext h1 {font-size:22px;}\n ";
 
 
/*titlebox-------------------*/
$titlebox = "\n.boxheader{height: $boxtitle_height;background:$boxtitle_bgcolor $boxtitle_bgimg;}\n.boxheader h3{color:$boxtitle_color;border-left:5px solid $boxtitle_color}\n.boxheader .more{color:$boxtitle_color}.boxheader .more:hover{color:$boxtitle_color}\n.content_header h3{border-left: 5px solid $boxtitle_bgcolor;}.content_header{border-bottom: 1px solid $boxtitle_bgcolor;}\n.sdheader,.sidebar h4.blockhd{height:$boxtitle_height;line-height:$boxtitle_height; background:$boxtitle_bgcolor $boxtitle_bgimg; color: $boxtitle_color;text-align:center;font-size:14px;font-weight:bold}.newsgridlist h3{background}\n\n";

            // if($sta_widthscreen=='y')   {
            //  $sta_widthscreen ="";
             // }
            // else {
             // $sta_widthscreen =".pagewrap{width: 1200px;border:0px solid red;margin:0 auto;  } ";
         //  }  
 
$headerbg ='background:'.$header_bgcolor.' '.$header_bgimg.'; ';
if($header_bgcolor==='' && $header_bgimg=='') $headerbg ='';

 $header = "\n.header{ $headerbg color:$header_color} \n .header a{color:$header_color_a} \n .header a:hover{color:$header_color_ahover}";
 $footer = "\n.footer{background:$footer_bgcolor $footer_bgimg;color:$footer_color} .footer .blockhd{color:$footer_color}\n .footer a{color:$footer_color_a} \n .footer a:hover{color:$footer_color_ahover}\n";

 $footerbar = "\n.footerbar{background:$footerbar_bgcolor;color:$footerbar_color} \n .footerbar a{color:$footerbar_color_a} \n .footerbar a:hover{color:$footerbar_color_ahover}\n";

$csscontent="/*----本文件的css由后台产生的，请在后台模板里修改主，请不要直接更改此文件。当前的样式名：$title  ------ 技术支持：DM企业建站 www.demososo.com---------------*/\n $bodybgcss $color_a   $othercolor $header $footer $footerbar $bannercommon  $titlebox \n /*----------仅限pc端样式 only pc style---------*/\n@media (min-width: 801px) {\n $menucss $msubcss \n} \n/*----------仅限mobile端样式 only mobile style---------*/\n@media (max-width: 800px) {\n $bannermobile \n}";

 
//\n\n /*----------custom css textarea---------*/\n\n $despv  -- desp no use
         //   echo $csscontent;
    file_put_contents($cssfileroot,$csscontent);//更新Cssfile

 // $ss = "update ".TABLE_STYLE." set  despsql='$csscontent' where pidname='$pidname' $andlangbh limit 1";
  //iquery($ss);

 
  
   $cssfilelink = '<a target="_blank" href="'.$cssfilepath.'?v='.rand(1000,9999).'">'.$cssfilename.'</a>';

 echo '<p style="padding:20px 0;font-size:16px;color:blue">操作成功。'.$cssfilelink.' 已更新。(css由后台配置生成，所以请不要直接编辑这个数据库css文件。)<br /><br /> <br /> <br /></p> ';
 

    }
}//end func


function genercss_orhttpimg($addr){
    if(strpos($addr,'://')>1) return $addr;
    else return UPLOADPATHIMAGE.$addr;

}
?>
