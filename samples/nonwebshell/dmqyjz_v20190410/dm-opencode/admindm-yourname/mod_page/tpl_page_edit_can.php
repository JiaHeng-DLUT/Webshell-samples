<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}


 if($act=='update'){


//pre($_POST);
 
 
   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

  $bscnt22 = '';
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
       $bscnt22 = substr($bscnt22,0,-5);
 

     $ss = "update ".TABLE_PAGE." set arr_can='$bscnt22'  where id='$tid' $andlangbh limit 1";

	 // echo $ss;exit;
	 	iquery($ss);
  
	jump($jumpv_back);
 }
 else
 {

  $detail_albumid = $detail_videoid =$detail_musicid =$downloadtitle =$downloadurl =$linkmoretitle =$linkmore ='';
 
  $sql = "SELECT arr_can from ".TABLE_PAGE."  where  id='$tid' $andlangbh   order by id limit 1";
$row = getrow($sql);
 
 

$arr_can=$row['arr_can'];



//pre($arr_can);

$bscntarr = explode('==#==',$arr_can); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }
    
?>
  <form  action="<?php echo $jumpv_file; ?>&act=update" method="post" enctype="multipart/form-data">

<div style="background:#e2e2e2;padding:10px;font-size:16px;font-weight:bold">其他参数：</div> 
 
  <table class="formtab" >
 
 

 
    <tr>
    <td class="tr" width="20%">资料下载的链接：
    <br />
    <?php echo $xz_maybe;?>
    </td>
    <td >
    字样：
    <input name="downloadtitle" type="text"  value="<?php echo $downloadtitle;?>" size="35" />
    <br /> 
    链接：
    <input name="downloadurl" type="text"  value="<?php echo $downloadurl;?>" class="form-control" /> 
  
  
    <br /><?php echo $text_outlink;?>
      </td>
  </tr>
   
 
  <tr>
    <td class="tr" width="20%">查看全文的链接：
    <br />
    <?php echo $xz_maybe;?>
    </td>
    <td >
    字样：
    <input name="linkmoretitle" type="text"  value="<?php echo $linkmoretitle;?>" size="35" /> 
    <br /> 
    链接：
    <input name="linkmore" type="text"  value="<?php echo $linkmore;?>" class="form-control" /> 
  
  
    <br /><?php echo $text_outlink;?>
      </td>
  </tr>



  <?php 
//require_once HERE_ROOT.'mod_page/plugin_page_inc_can.php';
?>


</table>


    

  

<div class="c tc"> 
 
 <input class="mysubmit"     type="submit" name="Submit" value="提交" /> 
     
<?php echo $inputmust;?>
 </div>

 </form>
<?php
  }
  ?>
  
 