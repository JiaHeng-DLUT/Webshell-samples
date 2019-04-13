<?php
 //$formSumbit = '提交';
 //$formSumbitHave = '已提交';
 //$formSumbitOk = '提交成功';
 //$formSumbitRepeat = '请不要重复提交';

 //when multi lang,use below:
 $formSumbit = FORMSUBMIT;
 $formSumbitHave = FORMSUBMITHAVE;
 $formSumbitOk = FORMSUBMITOK;
 $formSumbitRepeat = FORMSUBMITREPEAT;
 
 //echo $pidname;
 $sqlsub = "SELECT * from ".TABLE_FIELD." where  pidname='$pidname' $andlangbh and sta_visible='y' order by pos desc, id";
 //echo $sqlsub;exit;
 if(getnum($sqlsub)>0){
		  $resform = getrow($sqlsub);
		  $formname = $resform['name']; 
		  $namefront = $resform['namefront'];   
		  $cssname = $resform['cssname']; 
		  $effect = $resform['effect']; 
	  //--------------
		  global  $nodepidname;
		   
		  if(!isset($nodepidname))  {
		  	 $nodepidname='';
		  }  
		  else{
		  	  if(substr($nodepidname,0,4)=='page'){
		  	  	$arr = get_fieldarr(TABLE_PAGE,$nodepidname,'pidname');
		  	  	$nodetitle = $arr['name'];
		  	  	$nodeurl = BASEURLPATH.get_url($arr);

		  	  }
		  	  else{
		  	  	$arr = get_fieldarr(TABLE_NODE,$nodepidname,'pidname');
		  	  	$nodetitle = $arr['title'];
		  	  	$nodeurl = BASEURLPATH.get_url($arr);

		  	  }
			   $formname  = $formname.'<br />来自：'.$nodetitle.' - '.$nodeurl;
		  }
 
 //$inquerytooken = 'inq_'.date("Ymd_His_").rand(1111,9999);
 $tokenhour = 'inq_'.date("Ymd_H");//minute

$formrand = $pidname.rand(1111,9999);
$formrandjson = 'json'.$formrand;
  ?>

  <script>
  var  <?php echo $formrand ?> = {
  	tokenhour:'<?php echo $tokenhour?>',
  	formtitle:'<?php echo $formname?>',
  	ajaxformurl:'<?php echo BASEURL?>dmpostform.php?type=formblock&lang=<?php echo LANGPATH?>',
  	ajaxsendemailurl:'<?php echo BASEURL?>dmpostform.php?type=sendemail&lang=<?php echo LANGPATH?>',
  	nodepidname:'<?php echo $nodepidname;?>',
  	formpidname:'<?php echo $pidname;?>',
  	formSumbitHave: '<?php echo $formSumbitHave;?>',
  	formSumbitOk:'<?php echo $formSumbitOk;?>',
  	formSumbitRepeat:'<?php echo $formSumbitRepeat;?>',
  }

 
</script>

<?php 
if($namefront<>'')   echo '<div class="bodyheader"><h3>'.$namefront.'</h3></div>';

?>
 <div id='<?php echo $formrand;?>' class="formblock <?php echo $cssname;?>">  
	 <?php 
  

	    if(substr($effect,0,5)=='self_') $file = TPLCURROOT.'selfblock/form/'.$effect;
	    else $file = BLOCKROOT.'form/'.$effect;
		if(checkfile($file)) require $file;
   
 ?>	  
</div> 
<?php 
} //end has form
else {  echo 'no  form by the id.' ; }
?>

 





