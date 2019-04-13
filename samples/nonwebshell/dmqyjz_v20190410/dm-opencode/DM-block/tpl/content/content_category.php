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
	 	     //begin list---------------
         $pidcate= $curcatepidname;
          $cus_columnsv = ' '.cus_columnsfun($cus_columns);
           $cus_columnsv_bt = ' '.cus_columnsfun_bt($cus_columns);
        $dhtrigger = 'slick'.rand(1000,9999);
      //------------------
	 $sqlwhere = wherecatev($mainpidname,$curcatepidname);
		$sqlnode="select * from ".TABLE_NODE." where  $sqlwhere and sta_visible='y' $andlangbh    order by pos desc,id desc ";

				 //echo $sqlnode;
				$fenum = getnum($sqlnode);
				if($fenum==0) {echo '没有记录。';
				$result = array();
				}
				else {

					$page_total=ceil($fenum/$maxline);
					// if($page>$page_total) $page=$page_total; //if have,then not jump in pager.php
					 if($page>$page_total || $page==0)   $result = array();
					 else {
							$start=($page-1)*$maxline;
							if($start<0) $start=0;
								$sqllist33="$sqlnode  limit $start,$maxline";
							 // echo $sqllist33;exit;
								$result = getall($sqllist33);
					}
	//--------------
         	 if(substr($template,0,5)=='self_')  $reqfile =  TPLCURROOT.'selfblock/list/'.$template;
             else  $reqfile =  BLOCKROOT.'list/'.$template;
			 if(checkfile($reqfile)) require $reqfile;

	      }
			 require_once BLOCKROOT.'other/plugin_pager.php';

 //end list---------------
	 }
	?>
</div>
 <?php
	 if($contentbot<>'') {echo '<div class="c content_bot">';
	 block($contentbot);
	 echo '</div>';}
	?>
