<div class="taggrid grid2ceng imghg210">
  <ul class="c">
 <?php
 foreach($result as $v2){
		 $nodepidname = $v2['node']; 
		   $sql = "SELECT * from ".TABLE_NODE." where  pidname='$nodepidname'   $andlangbh  limit 1";
 			if(getnum($sql)>0){
 					$v= getrow($sql);
 					   $title = $v['title'];       
        $titlestyle=$v['titlestyle'];      
      $dateday=substr($v['dateedit'],0,10);                        
     // $despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],$cus_substrnum);              
            $kvsm=$v['kvsm'];
            $imgv =  get_img($kvsm);
            $url = get_url($v);
            $titlestylev=$titlestyle<>''?' style="'.$titlestyle.'" ':'';            
            $linkurl = linkhref($url).$titlestylev;

			         ?>

 <li class="boxcol col_1f4 gcoverlayjia">
     <a  <?php echo $linkurl;?>>
         <div class="overlay"><span>+</span></div>
           <div class="img">
              <img src="<?php echo $imgv?>" alt="<?php echo $title?>">
            </div>
           <h3><?php echo $title?></h3>
    </a> 
</li>								
 <?php
  }//end getnum
 }
  ?>
 
</ul>
</div>
 