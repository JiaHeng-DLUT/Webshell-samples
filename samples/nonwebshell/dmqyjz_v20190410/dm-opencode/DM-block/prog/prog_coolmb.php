 
<style>
.coolmbtest {padding:20px 10px}

.coolmbtest  a {display:inline-block; padding:10px;text-align:center;}
.coolmbtest strong {display:block;}
.coolmbtest a img{width:120px;height:120px;}

@media  (max-width: 801px) {
.coolmbtest  a { padding:10px 6px;  }
.coolmbtest a img{width:100px;height:100px;}

}

</style>
<div class="container coolmbtest">
  <strong>酷模板页面区域演示</strong>

 <?php 
	 //$sql = "SELECT * from ".TABLE_REGION." where pidstylebh='dmregion' and sta_visible='y'  $andlangbh order by pos desc,id desc";
	 //echo $sql; 
	// $rowlist = getall($sql);
	//if($rowlist=='no') echo '暂无内容';
	//else{

	//foreach ($rowlist as $v) {

		for ($i=100; $i<=123; $i++) {
		  // $dmregdir = $v['dmregdir'];
			$dmregdir = 'dmregion_'.$i;
			 
				$imgroot= STAROOT.'img/coolmbthumb/'.$dmregdir.'.jpg';
				//echo $imgroot;
				if(is_file($imgroot))  $imgv= STAPATH.'img/coolmbthumb/'.$dmregdir.'.jpg';
				else  $imgv= DEFAULTIMG;

				$pimg = '<img src="'.$imgv.'" alt="" />'; 

 				$dir22 = REGIONROOT.$dmregdir;
 				 if($dmregdir=='' || !is_dir($dir22))  echo '<a href=""><img src="'.DEFAULTIMG.'" alt="" /><br />'.$dmregdir.'目录不存在</a>';
				 else echo '<a href="'.$dmregdir.'.html" target="_blank">'.$pimg.'<br />'.$dmregdir.'</a>';
			}
	//} 
		
	?>
</div>