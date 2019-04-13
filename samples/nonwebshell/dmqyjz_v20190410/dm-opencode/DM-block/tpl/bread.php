<?php
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

 global $breadarr;

 ?>

<div class="breadcrumb">
    <?php
     if($breadtext<>'') echo decode($breadtext);
     else {
             $bread_v='';
            //  $bread_home = '<span class="breadhome">'.BREADLOC.'<i class="fa fa-home"></i> <a  href="index.html">'.HOME.'</a></span>';

                $bread_home = '<span class="breadhome"><i class="fa fa-home"></i><a  href="'.BASEURLPATH.'">'.HOME.'</a></span>';


               $divi = '<span class="breaddivi">></span>';
                //echo '<pre>aaaaaaa'.print_r($arr,1).'</pre>';
                if(count($breadarr)>0){
                   foreach($breadarr as $i=>$v){
                      if($i==0)  $bread_v= decode($v);
                      else  $bread_v= $bread_v.$divi .$v;

                   }
                }
             //   echo $bread_home.$divi.strip_tags($bread_v);
                 echo $bread_home.$divi.$bread_v;

     }
     ?>
</div>
