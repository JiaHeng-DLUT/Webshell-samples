<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>
<?php 

$searchkey = @htmlentitdm($_POST['searchword']);


?>
<div class="contentwrap container">
	<div class="content_header dn"><h3><?php echo SEARCH_RESULT?>：</h3></div>
	 
	<div class="content_def">
	
 
	 <div class="c searcharea">
		<div class="searchresult">
		<?php
		 

			if($searchkey=='') echo '<p class="nokey">'.SEARCH_ALERTKEYWORDS.'!</p>';
			else{
						

	  $sqlsearch = "SELECT * from ".TABLE_NODE."  where sta_search='y'  and  title  like  '%$searchkey%'   $andlangbh order by id desc limit 100";	
	 // echo $sqlsearch;//exit; 
	  //sta_search='y' -- bec blockdh in node also
	  if(getnum($sqlsearch)>0){
        	   echo '<p class="key">'.SEARCH_KEYWORDS.'：<span style="color:#666;font-size:18px"> '.$searchkey.'</span></p>';
	 
		$result = getall($sqlsearch); 
		  
		     $reqfile = BLOCKROOT.'search/search.php'; 			 
			if(checkfile($reqfile)) require($reqfile);
				   
		
		}
		else{
		 echo '<p class="noresult">'.SEARCH_NORESULT.'： <span style="color:#666;font-size:20px">'.$searchkey.'</span></p>';
		}//对不起，没有找到相关内容
		
	}
	?>
	</div>
</div>	
</div> 

</div><!--end contentwrap-->
