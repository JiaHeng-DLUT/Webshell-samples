
 <?php
 global $andlangbh;global $curstyle;
    $sqlall="select * from ".TABLE_BLOCK." where pidname='$pidname'   $andlangbh  order by id desc limit 1";
   //echo $sqlall;
    if(getnum($sqlall)>0){
        $v = getrow($sqlall);
        //pre($v);
       $blockarr = $v; //use in func getbkarr_node

$blockimg=$cssname= $namefront=$blockid=$nodebtnmore='';
$bgcolor=$bgimg=$cssstyle='';
$bgrepeat= 'no-repeat';
$bgposi= 'center center';
$bgsize= 'cover';
$bgattach = '';
$stylev=$linkurl=$linktitle='';

$cus_columns = 2;$cus_substrnum=0;
 $maxline=1;


    $blockcan = $v['blockcan'];
    $bscntarr = explode('==#==',$blockcan);
    if(count($bscntarr)>1){
      foreach ($bscntarr as   $bsvalue) {
       if(strpos($bsvalue, ':##')){
         $bsvaluearr = explode(':##',$bsvalue);
         $bsccc = $bsvaluearr[0];
         $$bsccc=$bsvaluearr[1];
       }
     }
   }



     $tid = $v['id'];$pid = $v['pid']; $ppid = $v['pidstylebh'];
     $blockimg = $v['blockimg'];
     $name = $v['name'];
      $typecolumn = $v['typecolumn'];
      $template = $v['template'];
      $pidcate = $v['pidcate'];

 $cus_columnsv = ' '.cus_columnsfun($cus_columns);
 $cus_columnsv_bt = ' '.cus_columnsfun_bt($cus_columns);


 $dhtrigger = 'slick'.rand(1000,9999);

   $bgvideo= 'n';
 if(is_int(strpos($cssname,'bgvideo'))) $bgvideo= 'y';



$linkurlv ='';


    $despjj = decode($v['despjj']);
    $desp= web_despdecode($v['desp']);
      $desptext= web_despdecode($v['desptext']);
      $despv='';
      if($desptext<>'') $despv = $desptext;
      else  $despv = $desp;

//----------
if($cssstyle<>'' || $bgcolor<>'' || $bgimg<>''){
 $stylebg = regionbg($bgcolor,$bgimg,$bgrepeat,$bgposi,$bgsize,$bgattach);
 if($cssstyle=='')   $stylev =  'style = "'.$stylebg.'"';
  else $stylev =  'style = "'.$stylebg.' '.$cssstyle.'"';
}

//------------

 if($typecolumn=='column'){
     $reqfile = BLOCKROOT.$template.'.tpl.php';
 }
 else{
         $ppid4 = substr($ppid,0,4);

           if($ppid=='common')  $reqfile =  BLOCKROOT.$pid.'/'.$template;
          if($ppid4=='styl')  $reqfile =  TPLCURROOT.'/selfblock/'.$pid.'/'.$template;
          if($ppid4=='dmre')  $reqfile = REGIONROOT.$ppid.'/'.$pid.'/'.$template;



if($pid=='bknode' || $pid=='bkblockdh'){

         //------------------
      if($pid=='bknode'){
        edit_fenode($pidcate);//用来在前台编辑后台。
          if(substr($pidcate, 0,4)=='cate') $pidcatemain = $pidcate;
          else $pidcatemain = get_field(TABLE_CATE,'ppid',$pidcate,'pidname');

            $sqlwhere = wherecatev($pidcatemain,$pidcate);
            $orderv = " order by pos desc,dateedit desc ";
          }
         else {
          $sqlwhere = " pid='$pidname' and modtype='blockdh' ";
          $orderv = " order by pos desc,id ";
           edit_fenode_blockdh($pidname);//用来在前台编辑后台。
         }

         if(is_int(strpos($cssname,'ordernodetj'))) $wheretj= " and sta_tj='y' ";
         else $wheretj='';
         if(is_int(strpos($cssname,'ordernodenew'))) $wherenew= " and sta_new='y' ";
         else $wherenew='';


        $sqlnode="select * from ".TABLE_NODE." where  $sqlwhere and sta_visible='y' $wheretj $wherenew  $andlangbh   $orderv limit 0,$maxline";
           //echo $sqlnode;
        $fenum = getnum($sqlnode);
        if($fenum==0) {
          if(!is_int(strpos($pidcate,'|')))  echo '没有node记录  in vblock.php';
           $result = array();
        }
        else  $result = getall($sqlnode);

      //--------------
     }
  }
       if(checkfile($reqfile))   require $reqfile;


}
else { echo '<p>暂无内容，找不到区块： '.$pidname.'，可能是前台和后台的语言不一致。</p>';}

?>
