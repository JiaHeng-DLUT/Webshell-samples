 
 <div id="<?php echo $dhtrigger;?>" class="jstabhoverwrap sidebar_imgleft <?php echo $cssname;?>" <?php echo $stylev;?>>

 <div class="tabheaderleft">
  <a class="more jstabhover active" data-tab="homeprotableft01" href="javascript:void(0)">最新</a>    
  <a class="more jstabhover" data-tab="homeprotableft01" href="javascript:void(0)">推荐</a>    
  </div>
   <?php 
 edit_fenode($pidcate);//用来在前台编辑后台。


 ?>
  <div class="tabcnt ">
  <?php
  $arrleft01 = array(' and sta_new="y" ',' and sta_tj="y" ');
  foreach ($arrleft01 as $k=>$v){
	  
 if(substr($pidcate, 0,4)=='cate') $pidcatemain = $pidcate;
          else $pidcatemain = get_field(TABLE_CATE,'ppid',$pidcate,'pidname');

            $sqlwhere = wherecatev($pidcatemain,$pidcate);
            $orderv = $v;

$sqlnode="select * from ".TABLE_NODE." where  $sqlwhere $v and sta_visible='y'  $andlangbh order by pos desc,dateedit desc limit 0,$maxline";
   $fenum = getnum($sqlnode);
        if($fenum==0) {
         // if(!is_int(strpos($pidcate,'|')))  echo '没有node记录  in vblock.php';
          echo '没有记录';
           $result = array();
        }
        else  $result = getall($sqlnode);  
  
  ?>
   <div class="jstabhovercnt" <?php if($k>0) echo ' style="display:none"';?>>
   <ul>  
      <?php 
      foreach($result as $k=>$v){
		           $title=$v['title'];
      $titlestyle=$v['titlestyle'];      
      $dateday=substr($v['dateedit'],0,10);                        
      $despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],$cus_substrnum);              
            $kvsm=$v['kvsm'];
            $imgv =  get_img($kvsm);
            $url = get_url($v);
            $titlestylev=$titlestyle<>''?' style="'.$titlestyle.'" ':'';            
            $nodeurl = linkhref($url).$titlestylev; 

    ?>
     <li> 
             <div class="img">
              <a <?php echo $nodeurl;?>> <img class="mt10" src="<?php echo $imgv?>"  alt="<?php echo $title?>">  </a>
            </div>			
			<div class="text">
				<h5 class="title"><a <?php echo $nodeurl;?>><?php echo $title?></a></h5>
				 
				<?php  if($cus_substrnum>0) 
						echo '<div class="desp">'.$despv.'</div>';
				?>
           </div> 
     </li> 
  <?php
  
}
?> 
</ul>
</div>
<?php 
}
?>
</div>

</div>
 