<?php 


$sql = "SELECT htmldir from ".TABLE_STYLE."  where  pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);
$htmldir=$row['htmldir'];
generatecss($bscnt22,$htmldir); 

function generatecss($style_hf,$htmldir){

 
global $jumpv_pf;
   
  //---------------------------------
  
    $cssfilename = $htmldir .'/cssjs/'.$htmldir.'_custom.css';
   $cssfileroot = TEMPLATEROOT.$cssfilename;
  if(!is_file($cssfileroot )){
   // echo $cssfilename.'不存在。';
    alert('模板目录下的'.$cssfilename.'不存在，请创建。');
    jump($jumpv_pf.'&act=edit');
    exit;
  }


 /*-----------------style_hf----------*/
$bscntarr = explode('==#==',$style_hf); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) { //pre($bsvalue);
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
      $headertop_bgcolor=$headertop_color=$headertop_color_a=$headertop_color_ahover='';
      $sta_header_width='';
 
      $menu_bgcolor=$menu_bgimg=$menu_color='';
      $menu_bgcolor_h=$menu_bgimg_h=$menu_color_h='';
      $menu_height=$menu_border='';

      $msub_bgcolor=$msub_color='';
      $msub_bgcolor_h=$msub_color_h='';
      $msub_height=$msub_border='';

      $sta_menuright=''; 

  
      $boxtitle_height=$boxtitle_bgcolor='';
      $boxtitle_color='';
      }

/*-------------------desp------------------------*/
          

$bodynarrow = $bodynarrow=='y'?'.pagewrap{width:1200px;margin:0 auto}':'';
$bodybg = $bodybg==''?'':'background:'.$bodybg;
$contentwrapbg = $contentwrapbg==''?'':".contentwrap,.pageregionwrap,.bannerwrap{background:$contentwrapbg} ";

 $color_a = "\n body{color:$bodycolor;$bodybg} a{color:$color_a;text-decoration:none; } a:hover{color:$color_ahover} $contentwrapbg ";


 $menucss = "\n.menu{background:$menu_bgcolor;height: $menu_height ;line-height:$menu_height;border-bottom:$menu_border;z-index:99;    } \n .menu li.m{background:$menu_bgcolor;border-bottom:$menu_border;}  \n .menu a{color:$menu_color} \n .menu a:hover,.menu a.active{background:$menu_bgcolor_h;color:$menu_color_h}";
 $msubcss = "\n.menu li li{background:$msub_bgcolor;height: $msub_height ;line-height:$msub_height;border-bottom:$msub_border;z-index:99;    } \n .menu li li a{color:$msub_color} \n .menu li li a:hover,.menu li li a.active{background:$msub_bgcolor_h;color:$msub_color_h}";

 $othercolor = "";

 
 
/*titlebox-------------------*/
$titlebox = "\n.sdheader,.sidebar h4.blockhd{ background:$boxtitle_bgcolor ;color: $boxtitle_color;} .content_header h3{border-left: 5px solid $boxtitle_bgcolor;}.content_header{border-bottom: 1px solid $boxtitle_bgcolor;}";

 
 
$headerbg ='background:'.$header_bgcolor;
 $header = "\n.header{ $headerbg } \n ";
 $footer = "\n.footer{background:$footer_bgcolor;color:$footer_color} .footer .blockhd{color:$footer_color}\n .footer a{color:$footer_color_a} \n .footer a:hover{color:$footer_color_ahover}\n";
 $headertop = "\n.headertop{background:$headertop_bgcolor;color:$headertop_color} .headertop .blockhd{color:$headertop_color}\n .headertop a{color:$headertop_color_a} \n .headertop a:hover{color:$headertop_color_ahover}\n";

$csscontent="@charset 'UTF-8';\n/*----本文件的css由后台产生的，请在后台模板里修改，请不要直接更改此文件。  ------ 技术支持：DM企业建站 www.demososo.com---------------*/\n $color_a  $headertop  $othercolor $header $footer $titlebox \n /*----------仅限pc端样式 only pc style---------*/\n@media (min-width: 801px) {\n  $bodynarrow $menucss $msubcss \n}  ";

 
//\n\n /*----------custom css textarea---------*/\n\n $despv  -- desp no use
 
  //echo $csscontent;

  file_put_contents($cssfileroot,$csscontent);//更新Cssfile  

     jump($jumpv_pf.'&act=edit');
}//end func

 
?>
