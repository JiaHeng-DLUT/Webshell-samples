<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
 
<?php  if($contentheader==''){?>

<div class="content_header">
<?php
	 if($breadposi=='r') require_once BLOCKROOT.'tpl/bread.php';
	?>
<h3><?php  echo '<a href="'.$cururllink.'">'.strip_tags($curpagetitle).'</a>';?></h3>
</div>

<?php }
else{ //if is hide or other,is hide contheader. or img
	if($contentheader<>'hide'){
			$imgcontheader = UPLOADPATHIMAGE.$contentheader; 
 			echo '<div class="content_headerimg" style="background:url('.$imgcontheader.') no-repeat"> </div>';
 		}
}
 ?>
<?php
	 if($contenttop<>'') {echo '<div class="c contenttop">';
	 block($contenttop);
	 echo '</div>';}
?>
 
<div class="c content_default">
	<?php
	 if($content<>'') block($content);	 
	 else { 
	 	     if(substr($detailfg,0,5)=='self_')  $reqfile =  TPLCURROOT.'/selfblock/detail/'.$detailfg;
            	 else  $reqfile =  BLOCKROOT.'detail/'.$detailfg;
            	 if(checkfile($reqfile)) require  $reqfile;  
	 } 
	?>
</div>
 <?php
	 if($contentbot<>'') {echo '<div class="c content_bot">';
	 block($contentbot);
	 echo '</div>';}
	?>
