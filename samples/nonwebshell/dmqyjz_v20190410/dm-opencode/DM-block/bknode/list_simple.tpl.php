
 <ul class="list_simple <?php echo $cssname?>"  <?php echo $stylev?>>
<?php
 foreach($result as $v){
 $titlestyle = $v['titlestyle'];
 $title = $v['title']; 
  $pidname = $v['pidname']; 
  $dateday=substr($v['dateedit'],0,10);
 $url = get_url($v);
 $titlestylev=$titlestyle<>''?' style="'.$titlestyle.'" ':'';
 $nodeurl = linkhref($url).$titlestylev;

//   $despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],$cus_substrnum);
 
?>
<li><span><?php echo $dateday;?></span><a <?php echo $nodeurl;?>><?php echo $title;?></a></li>
 
<?php
 } 

 ?> 
  
 </ul>