<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

 ?>

 <?php
	 if($sidebartop<>'') {echo '<div class="c sidebartop">';
	            block($sidebartop);
	            echo '</div>';
	        }
	?>

	<?php
	 if($sidebar<>'') block($sidebar);
	 else{

	 	 if(!isdmmobile()) require_once BLOCKROOT.'tpl/sidebar/sidebar_page.php';	
  
	  }
	?>
	<?php
	 if($sidebarbot<>'') {echo '<div class="c sidebar_bot">';
	            block($sidebarbot);
	            echo '</div>';
	        }
	?>

 
