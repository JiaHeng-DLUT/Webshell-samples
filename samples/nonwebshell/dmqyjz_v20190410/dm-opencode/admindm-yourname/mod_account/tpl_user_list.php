
<?php
$sql = "SELECT * from ".TABLE_USER." where type='normal'  order by pos desc,id desc";
   //echo $sql;
$rowlist = getall($sql);
 if($rowlist=='no') echo $norr2;
 else{

?>
<form method=post action="<?php echo $jumpvf;?>&act=pos">
<table class="formtab">
<tr class="trheader">
<td width="10%">排序</td> <td width="88%">名称</td>
</tr>
<?php

foreach($rowlist as $vcat){
   $tidcur=$vcat['id']; //tidmain ,not use tid,for conflict in subedit.php
   $email=$vcat['email']; 

   if($tidcur==$tid) $curclass=' class="redbgcur" ';
else $curclass=' ';

  $emailv = '<a '.$curclass.' href="'.$jumpv.'&file=edit&act=edit&tid='.$tidcur.'"><strong>'.$email.'</strong></a>';
   
 ?>
<tr>
<td align="center"><input type="text" name="<?php echo $tidcur;?>"  value="<?php echo $vcat['pos'];?>" size="5" /></td>
 <td>  <?php   echo $emailv ;?></td>
</tr>
<?php 
} 
?>
</table>

<div style="padding-bottom:22px"><input class="mysubmit mysubmitsm" type="submit" name="Submit" value="排序" />
<br />
<?php echo $sortid_desc?></div>
</form>

<?php 
}
?>