<?php
 
 //  $arr_formerror = array(
 //     'error0'=>'可以为空', 
 //     'error1'=>'不能为空',    
 //      'error2'=>'手机号格式不对', 
 //      'error3'=>'E-mail格式不对', 
 //      'error4'=>'必须是数字',       
 //    );
 // $error_mustone = '至少选择一个';
 
 //when multi lang,use below:

 $arr_formerror = array(
     'error0'=>FORMERROR0, 
     'error1'=>FORMERROR1,    
      'error2'=>FORMERROR2, 
      'error3'=>FORMERROR3, 
      'error4'=>FORMERROR4,       
    );
 $error_mustone = ERRORMUSTONE;

 ?>
  <?php 
 
	  $sqlsub = "SELECT * from ".TABLE_FIELD." where  pid='$pidname' $andlangbh and sta_visible='y' order by pos desc, id";
		  //echo $sqlsub;exit;
		 $rowlistsub = getall($sqlsub);
		 //pre($rowlistsub);
		if($rowlistsub<>'no') {
			foreach($rowlistsub as $vsub){

			   $tid=$vsub['id'];
			   $typeinput=$vsub['typeinput']; 
			   $sta_vis=$vsub['sta_visible']; 
			   $pidnamefield=$vsub['pidname'];  
			   $error=$vsub['error'];  
			   $cssname=$vsub['cssname'];  
			   
			   $cssname = $cssname==''?'c nocss':$cssname;
				  
				if($typeinput=='radio' || $typeinput=='checkbox' || $typeinput=='select')
				  $errorv = $error_mustone;
				else  $errorv =  select_return_string($arr_formerror,0,'',$error);
				  
				$value='';				 
		  
		?>
			<div class="jsline line <?php echo $cssname?>">
			<div class="key" data-typeinput="<?php echo $typeinput;?>" data-error="<?php echo $error;?>">
			<?php
			if($error<>'error0') echo '<span class="errorstar">*</span> ';
			?>
			<span  class="label"><?php echo $vsub['name'];?>：</span>			 
			</div>
			<div class="valuediv">
			 <?php   fieldvalue($pidnamefield,$typeinput,$value); 				
			   if($error<>'error0') {
				echo '<p class="error">'.$errorv.'</p>';
			   }
				?> 
			</div>
			 </div>			  
		  <?php 
		  } //end foreach 
			
		}//end if has fields
		else echo 'no feild in the form';	
			
 

 ?>
	 <div class="linesubmit">
	   <div class="dmbtn">   
			<input type="submit" class="more submit cp" value="<?php echo $formSumbit?>">  
			<div class="submitloading"> 
			  <img src="<?php echo STAPATH.'img/loading.gif'?>" alt="" />
			</div> 
	   </div>
	</div><!--end submit-->
 
 
 
 <script>
  $('#<?php echo $formrand?> .submit').click(function() {
	   var parentv = $(this).closest('.formblock'); //parentv for multi form js .
	    
	 // console.log(<?php echo $formrand ?>);
	   
	  var content = dmformvalid(parentv);
	   if(content){   
		   //console.log(content);
		     dmformajax(parentv,content,<?php echo $formrand ?>);		   
	   }   	 
               
    });
	
 //console.log(formdata); 

</script>

 


