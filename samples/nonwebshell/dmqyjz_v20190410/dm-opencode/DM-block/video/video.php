<?php

 $sql="select cssname,title,kv,pidname from  ".TABLE_VIDEO."  where  pidname='$pidname'   $andlangbh order by  id desc";
     //echo $sql;
if(getnum($sql)>0) {
  $row=getrow($sql);
  $pidname=$row['pidname'];$title=$row['title'];
  $kv=$row['kv'];$cssname=$row['cssname'];
  //$effect=$row['effect'];
  //$despjj=$row['despjj'];
  //$desp=$row['desp'];
//


//$despjj= web_despdecode($row_detail['despjj']);
  //video image
            if($kv=='') $videoimgv = STAPATH.'img/video.jpg';
            else  $videoimgv = UPLOADPATHIMAGE.$kv;

$videoarr ='<div class="bgvideoarrow"></div>';
if(is_int(strpos($cssname,'novideoarrow'))) $videoarr ='';


//video code ,see incldue/file_formpost_videopop.php
?>
<div class="tc">
<div class="videowrap di <?php echo $cssname;?>">
<div class="di por <?php echo $cssname;?>">
  <a data-fancybox data-type="iframe" data-src="<?php echo BASEURL?>dmpostform.php?type=videopop&pidname=<?php echo $pidname;?>&lang=<?php echo LANGPATH;?>" href="javascript:;">
    <img src="<?php echo $videoimgv;?>" alt="<?php echo $title;?>" />


<?php echo $videoarr;?>
</a>

</div>
</div></div>
<?php

}

   ?>
