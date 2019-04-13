 <footer class="footerwrap"> 
 <div class="footer">
<?php 

 if(isdmmobile()){ //except ipad  
 	 if($bsfootermob=='')  block($bsfooter); 	 
 	 else  	block($bsfootermob);  //prog_footernavmob or prog_footernavmob_en
	 
  }

  else 

  {
		block($bsfooter); 
  }
?>
</div>
</footer>