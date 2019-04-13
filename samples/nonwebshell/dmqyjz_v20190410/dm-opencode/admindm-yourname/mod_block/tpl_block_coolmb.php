
<?php 

$dirreg = REGIONROOT;
$dirregarr = getDir(REGIONROOT);
//pre($dirregarr);

foreach ($dirregarr as $v){
 
   echo '<a     href="'.$jumpv.'&ppid='.$v.'">  '.$v.'</a> &nbsp; | &nbsp;';
}
?>