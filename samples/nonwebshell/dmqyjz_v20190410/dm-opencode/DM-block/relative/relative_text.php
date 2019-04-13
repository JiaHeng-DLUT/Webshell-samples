  
<div class="relativenode relativenodetext">
<h3><?php echo $relativetitle;?></h3>
 
<ul>
<?php
 
foreach($result as $v){

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
  <li class="colhalf">
        <span><?php echo $dateday?></span>
       <a <?php echo $linkurl?>><?php echo $title?></a> 
      </li>
<?php 
 
 }
  ?>  
 </ul>
<div class="c"> </div> 
</div>
 