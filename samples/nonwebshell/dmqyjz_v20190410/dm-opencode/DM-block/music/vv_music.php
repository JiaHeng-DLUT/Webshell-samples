<?php
 $sqlabm = "SELECT * from ".TABLE_MUSIC."  where  pidname='$pidname'  $andlangbh  order by  id desc";
      //echo '==============='.$sqlabm;
$dhtrigger = 'music'.rand(1000,9999);

    if(getnum($sqlabm)>0){
         $row = getrow($sqlabm);
         $effect = $row['effect'];
         $cssname = $row['cssname'];
       if($effect=='vmusic.php') {
            echo ' 出错，效果文件不能选择 vmusic.php';
        }
        else{
               $sql = "SELECT title,kv,kvlink,pidname from ".TABLE_MUSIC."  where  pid='$pidname'  and sta_visible='y'   $andlangbh  order by pos desc,id desc";
                   if(getnum($sql)>0){

                       $reqfile = BLOCKROOT.'music/'.$effect; 

                       if(is_file($reqfile)) {
                          
                            $resmusic = getall($sql);
                           // pre($resmusic);
                            require $reqfile;
                            
                      }
                       else echo '音乐效果 - DM-block/music/'.$effect.' 不存在';
                   }
                   else{
                     echo  '<div class="tc p30">还没有mp3</div>';
                   }
          }
    }
    else{
        echo '出错，音乐不存在。- '.$pidname;
    }


?>
