
 <?php 
 global $andlangbh;global $curstyle;
    $sqlall="select * from ".TABLE_BLOCK." where pidname='$pidname'   $andlangbh  order by id desc limit 1";
  // echo $sqlall;
    if(getnum($sqlall)>0){
        $v = getrow($sqlall);
      //  pre($v);
 
$blockbg=$blockimg=$bgcolor=$linktitle=$linkurl=$cssname= $namefront=$blockid='';
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
  
      
    
     $tid = $v['id'];$pid = $v['pid'];$kv = $v['kv'];
     $name = $v['name']; 
      $typecolumn = $v['typecolumn'];
       
      $template = $v['template'];    
      $pidcate = $v['pidcate'];
        
  
 $cus_columnsv = ' '.cus_columnsfun($cus_columns);
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
 $stylev ='';
if($bgcolor<>''){
if(is_int(strpos($bgcolor,'.'))){
  $bgimgv = ' url('.UPLOADPATHIMAGE.$bgcolor.') center bottom no-repeat;';
  $bgsize = 'background-size:cover;';
   $stylev =' style="background:'.$bgimgv.$bgsize.' "';
}
else{
   $stylev =" style='background:$bgcolor' ";
}
}
//------------

 if($typecolumn=='column'){
     $req_file = TPLBASEROOT.'block/'.$template.'.tpl.php'; 
       $req_name ='base/block/'.$template.'.tpl.php';  
 }
 else{    
         if(substr($template,0,8)=='mbblock/')  $req_name =  HTMLDIR.'/'.$template;
          else  $req_name =  'base/block/'.$pid.'/'.$template;  
         
        $req_file = TEMPLATEROOT.$req_name; 


 }
    
       if(is_file($req_file)) require $req_file;
       else echo '<p style="background:#ccc;color:red">没有此文件: '.$req_name.' </p>';

           
}
else { echo '<p>暂无内容，找不到区块： '.$pidname.'</p>';}
?>


