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

   $arrcanexcerpt =  array("detpriceold","detprice","stock", "sku");  

  $bscnt22 = '';
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
          //  if($k=='detail_musicid'){
              //  $v =  htmlentitdm(@$_POST['detail_musicid']);
               // $v=str_replace(chr(13),"|",$v);
               // $v=str_replace(chr(32),"",$v);
             //}
             if(in_array($k,$arrcanexcerpt))   continue;
            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
       $bscnt22 = substr($bscnt22,0,-5);

       $detpriceold =  htmlentitdm(@$_POST['detpriceold']);
       $detprice =  htmlentitdm(@$_POST['detprice']);
       $stock =  htmlentitdm(@$_POST['stock']);
       $sku =  htmlentitdm(@$_POST['sku']);

//echo $bscnt22;exit;
     $ss = "update ".TABLE_NODE." set arr_can='$bscnt22',detpriceold='$detpriceold',detprice='$detprice',stock='$stock',sku='$sku'  where id='$tid' $andlangbh limit 1";
    //  echo $ss;exit;
      iquery($ss);
  
     jump($jumpv_file);
 
 
 }
 else
 {
 
$stock=10000;
$detpriceold=$detprice=0;
 
 
$author=$authorcompany = $detlinktitle=$detlinkurl=$downloadurl=$linkmore='';
$titlebz1=$titlebz2=$titlebz3=$nodekvshow='';

$sql = "SELECT * from ".TABLE_NODE."  where  id='$tid' $andlangbh   order by id limit 1";
$row = getrow($sql); 
$sku=$row['sku'];$stock=$row['stock'];
$detpriceold=$row['detpriceold'];$detprice=$row['detprice'];
$arr_can=$row['arr_can'];

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
    
$detpriceold = floatval($detpriceold);
$detprice = floatval($detprice);

 ?>
 
 <section class="content-header">
   <h1>
      其他参数：
      </h1>
  
    </section>

  <form  action="<?php echo $jumpv_file; ?>&act=update" method="post" enctype="multipart/form-data">

 <table class="formtab" >


   <tr>
      <td class="tr">
    发布 ：
      </td>
      <td>  
     发 布 人：&nbsp;&nbsp;&nbsp;<input name="author" type="text"  value="<?php echo $author;?>" size="35" />
 
    <div class="c5"></div>
    来源：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="authorcompany" type="text"  value="<?php echo $authorcompany;?>" size="35" />
     
      
      <?php echo $text_usetext;?>
        </td>
    </tr>
 




<tr>
      <td class="tr">
        电商：
<br />
<?php echo $xz_maybe;?>
      </td>
      <td> 
     SKU：
      <input name="sku" type="text"  value="<?php echo $sku;?>" size="20"> （为数字）
      <div class="c5"></div> 
      库存：
      <input name="stock" type="text"  value="<?php echo $stock;?>" size="20"> （为数字）
      <div class="c5"></div> 
     
      原价：<input name="detpriceold" type="text"  value="<?php echo $detpriceold;?>" size="20">元 （为数字）
      <div class="c5"></div>
      现价：<input name="detprice" type="text"  value="<?php echo $detprice;?>" size="20">元 （为数字）

      <div class="c5"></div> 

      <?php if($detprice>$detpriceold)  echo '<p class="cred">提示：亲，错了吧，为什么现价更高呢？</p>';?>
      
      <br />

产品购买链接字样：<input name="detlinktitle" type="text"  value="<?php echo $detlinktitle;?>" size="10"> 
<?php echo $text_usetext;?>
 <div class="c5"></div>
 产品购买链接网址：<input name="detlinkurl" type="text"  value="<?php echo $detlinkurl;?>" class="form-control" />
    <br /><?php echo $text_outlink;?>
      <?php 
  if($detlinkurl<>''){
      if(substr($detlinkurl,0,4)<>'http') echo '<p class="cred">提示:产品外部链接没有以http开头</p>';
      }?>
     
        </td>
    </tr>

    <tr>
      <td class="tr">资料下载的链接：
      <br />
      <?php echo $xz_maybe;?>
      </td>
      <td >
     
      <input name="downloadurl" type="text"  value="<?php echo $downloadurl;?>" class="form-control" /> 
    

      <br /><?php echo $text_outlink;?>
        </td>
    </tr>
    <tr>
      <td class="tr">查看全文的链接：
      <br />
      <?php echo $xz_maybe;?>
      </td>
      <td >
      
      <input name="linkmore" type="text"  value="<?php echo $linkmore;?>" class="form-control" /> 
    

      <br /><?php echo $text_outlink;?>
        </td>
    </tr>

 
<?php 
//require_once HERE_ROOT.'mod_page/plugin_page_inc_can.php';
?>


<tr>
     <td width="12%" class="tr">显示kv：</td>
            <td width="88%">                
            <select name="nodekvshow" >
            <?php select_from_arr($arr_yn,$nodekvshow,'');?>
            </select>
       </td>
        </tr>

 
 <tr>
            <td width="12%" class="tr">备注：</td>
            <td width="88%"> 
                备注1：<input name="titlebz1" type="text"   value="<?php echo $titlebz1; ?>" size="30"  /><?php echo $xz_maybe; ?> 
                   <div class="c5"> </div>
                 备注2：<input name="titlebz2" type="text"   value="<?php echo $titlebz2; ?>" size="30"  /><?php echo $xz_maybe; ?> 
                     <div class="c5"> </div>
                 备注2：<input name="titlebz3" type="text"   value="<?php echo $titlebz3; ?>" size="30"  /><?php echo $xz_maybe; ?> 
            </td>
        </tr>
 

</table>

 
 
<div class="c tc"> 
 
 <input class="mysubmit"     type="submit" name="Submit" value="提交" /> 
     
 <?php echo $inputmust;?>

 </div>

 </form>
<?php
  }
  ?>
 
 <script>
 $(function(){

    $('.mysubmitnew').click(function(){


 var titlev =  $("input[name='title']").val().trim();
    if(titlev=='') {
      alert('请输入标题');
      $("input[name='title']").focus();
      return false;

    }

  
  //-------------
}

      );

 });
 
 </script>
 