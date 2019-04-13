<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
 <div class="tagcontent">
	 <?php 
	 
	 $sqllist22 = "SELECT node from ".TABLE_TAGNODE." where  tag='$tagpidname'   $andlangbh  order by  id desc";
 // echo $sqllist22; 
  /*begin page roll*/
  
     $num_rows = getnum($sqllist22);
	  $page_total=ceil($num_rows/$tagmaxline);//must put here,because when no data,we need the vaule of page_total	
     if($num_rows>0){
    
       // if($page>$page_total) $page=$page_total; //if have,then not jump in pager.php
       if($page>$page_total || $page==0)   $result = array();
           else {
            $start=($page-1)*$tagmaxline;
            $sqllist33="$sqllist22  limit $start,$tagmaxline";
    	   //echo  $sqllist33; 		 
            $result = getall($sqllist33);
 
              if(substr($tag_fg,0,5)=='self_')   $file =  TPLCURROOT.'selfblock/tag/'.$tag_fg;
              else  $file =  BLOCKROOT.'tag/'.$tag_fg;
              if(checkfile($file)) require $file;
           }
              require_once BLOCKROOT.'other/plugin_pager.php';

  

    }
    else {
       echo NOARTICLE;
    }

	  			 
?> 
 </div><!--end tagcontent-->