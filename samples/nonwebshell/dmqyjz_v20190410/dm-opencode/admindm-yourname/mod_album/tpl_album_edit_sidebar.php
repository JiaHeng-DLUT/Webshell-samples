<?php 
 $sql="select * from  ".TABLE_ALBUM."  where  pid='$pid' and type='$type' $andlangbh order by pos desc,id desc";
 //echo $sql;
   $rowlist = getall($sql);
 
    ?>
 
     <?php
	   if($rowlist == 'no') {
         //$loactlink= $PHP_SELF."?pid=$pid&act=add";
        //jump($loactlink);//
        echo '<p style="padding:10px">没有相关图片，请添加。</p>';
     }
     
    else{
        echo '<strong style="display:block;background:#e2e2e2;padding:5px">修改图片</strong>';
      echo '<ul>';
        foreach($rowlist as $v){
            $imgsqlname = $v['kvsm'];
			$title = $v['title'];
            $tid = $v['id'];
            if($title=='') $title='无标题'; 
           
 //mod_album.php?lang=en&pid=&ppid=album20180726_1147127952&file=edit&tid=10&act=edit
 $link =  $jumpv_file.'&tid='.$tid.'&act=edit';
           echo '<li><i class="fa fa-angle-right"></i> <a style=" display:inline-block;padding:0 10px" href="'.$link.'">'.$title.'</a></li>';

        }
      
    echo '</ul>';  
    }
?>