<div class="topsearchbox">
<?php
global $searchtext; global $langpath;
?>
<form  action="<?php echo BASEURL?>search.php?lang=<?php echo $langpath?>" method="post" accept-charset="UTF-8">
	<input class="text" type="text" name="searchword" placeholder="<?php echo $searchtext;?>">
	 <button><i class="fa fa-search"  style="display:none"  aria-hidden="true"></i></button>
	</form>
</div>

 
