<div class="topsearchbox">
<?php
global $searcherror; global $searchtext; global $langpath;
?>
<form  action="search.html" method="post" accept-charset="UTF-8">
	<input class="text" type="text" name="searchword" data-error="<?php echo $searcherror;?>" value="<?php echo $searchtext;?>">
	 <button><i class="fa fa-search"  style="display:none"  aria-hidden="true"></i></button>
	</form>
</div>

 
