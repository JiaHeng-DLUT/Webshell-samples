<?php

    $sqlabm = "SELECT * from ".TABLE_ALBUM."  where  pidname='$pidname'   $andlangbh  order by  id desc";
       //echo '==============='.$sqlabm;
$dhtrigger = 'album'.rand(1000,9999);

    if(getnum($sqlabm)>0){
         $row = getrow($sqlabm);
         $effect = $row['effect'];
         $pid = $row['pid'];
         $cssname = $row['cssname'];
         $cus_columns = $row['cus_columns'];
         $cus_columnsv = ' '.cus_columnsfun($cus_columns); 

               $sql = "SELECT * from ".TABLE_ALBUM."  where  pid='$pidname' and sta_visible='y'   $andlangbh  order by pos desc,id desc";
                   if(getnum($sql)>0){

                   if(substr($effect,0,5)=='self_')   $file  =  TPLCURROOT.'selfblock/album/'.$effect;
                     else  $file =  BLOCKROOT.'album/'.$effect;  
 

                       if(checkfile($file)) {
                          echo '<div class="albumwrap tc  '.$cssname.'">';
                            $row_abm = getall($sql);
                            require $file;
                           echo '</div>'; 

                      } 

                   }
                   else{
                     echo  '<div class="tc p30"><img src = "'.STAPATH.'img/noimg.png" alt="此相册里没有图片" /></div>';
                   }
          

    }
    else{
        echo '出错，相册不存在。- '.$pidname;
    }


?>
