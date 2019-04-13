 <?php 
//---获取数据-------------
$sql = "SELECT * from ".TABLE_CATE." where pid='$pidcate' and alias_jump=''  and sta_visible='y' $andlangbh order by pos desc,id limit $cus_columns";
//echo $sql;  
$fecatenum = getnum($sql);
if($fecatenum==0) echo '没有cate记录。'.$pidcate;
else  $result_cate = getall($sql);

?>
<div  <?php echo $cssname?>"  <?php echo $stylev?>>
<ul class="newsgridlist">
<?php 
if($fecatenum>0){

   $showimgV= 'n';
   if(is_int(strpos($cssname,'showimg'))) $showimgV= 'y'; 


 foreach($result_cate as $v){
    
      $name = $v['name']; 
      $pidcate = $v['pidname']; 
    
      
      $cateurl = get_url($v);

      ?>
      <li class="main boxcol <?php echo $cus_columnsv;?>"><div class="boxheader">  
	      <a class="more" href="<?php echo $cateurl?>">更多></a>
       <h3><?php echo $name?></h3> 
       </div>
 
        <ul class="sublist <?php echo $cssname?>">
             <?php 
             
              if(substr($pidcate, 0,4)=='cate') $pidcatemain = $pidcate;
              else $pidcatemain = get_field(TABLE_CATE,'ppid',$pidcate,'pidname');

            $sqlwhere = wherecatev($pidcatemain,$pidcate);
            $orderv = " order by pos desc,dateedit desc ";

             $sqlall22="select * from ".TABLE_NODE." where  $sqlwhere and sta_visible='y'  $andlangbh   $orderv limit 0,$maxline";
 
               if(getnum($sqlall22)>0){
                    $result22 = getall($sqlall22);
                    foreach ($result22 as $k22 => $v22) { 
                            $title=$v22['title'];    
                            $kvsm=$v22['kvsm'];    
                            $nodeurl = get_url($v22);                           
                            $imgvsm  = get_img($kvsm);


                           if($k22==0 && $showimgV =='y') 
                           { 
                            ?>
                            <li class="first img">
                            <a  <?php echo linkhref($nodeurl);?>>
                            <img class="zoomimg" src="<?php echo $imgvsm?>" alt="<?php echo $title?>" />
                            <div class="text"><?php echo $title?></div></a></li>
                                <?php
                            }
                            else {?>
                                 <li><a <?php echo linkhref($nodeurl);?>><?php echo $title?></a></li>
                            <?php } 

                    }
                    
                }
                else echo '<li>sorry,no result sub.</li>';

                    ?>
         </ul> 
    </li> 

 
<?php
}
?>


 

</ul>
<div class="c"> </div>
</div>
<?php }
 
?>
 

