  <?php 
      if( ! function_exists('array_column'))  //php5.5以下不支持array_column，所以这里定义下
{
  function array_column($input, $columnKey, $indexKey = NULL)
  {
    $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
    $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
    $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
    $result = array();
 
    foreach ((array)$input AS $key => $row)
    { 
      if ($columnKeyIsNumber)
      {
        $tmp = array_slice($row, $columnKey, 1);
        $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
      }
      else
      {
        $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
      }
      if ( ! $indexKeyIsNull)
      {
        if ($indexKeyIsNumber)
        {
          $key = array_slice($row, $indexKey, 1);
          $key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
          $key = is_null($key) ? 0 : $key;
        }
        else
        {
          $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
        }
      }
 
      $result[$key] = $tmp;
    }
 
    return $result;
  }
}

?>
  <?php 
  // echo $pidcate;
   $arr = explode("|",$pidcate);
  // pre($arr);
   

   if(isdmmobile())  echo '<h3 class="homeprotjtitle">'.$namefront.'</h3>';

   ?>


        	<div class="title homenodetjheader">
           <div class="f-l prlisttopnav ">  


                	


				<?php 
				if(!isdmmobile())  echo '<div class="w1 w1title"><strong>'.$namefront.'： </strong></div>';
                 echo '<ul class="w1 w2link">';
				foreach($arr as $k=>$v){
					 $varr = explode("=",$v);
					 $name = $varr[0];
					 
								$cur = $k==0?'on2':'';
					echo  '<li class="'.$cur.' STYLE2"><a href="javascript:void(0)">'.$name.'</a></li>';
				}
				echo '</ul>';
				?>	
				<div class="c"> </div>	 
                   
              </div>
			  
			  
			  <?php 

			  if(!isdmmobile())   block('myprog_search');
			  ?>

				
				
            </div>
			<div class="clear"></div>
			<div class="prlist22">
		<?php 
				foreach($arr as $k=>$v){
					 $varr = explode("=",$v);					 
					  $pid = $varr[1];					  
					   $pidarr = explode("-",$pid);					  
					 //pre( $pidarr);
					  $result = array();
					 foreach($pidarr as $pid ){						 
						 //----------------------
						// echo $pid.'-';
						 $ppid = get_field(TABLE_CATE,'ppid',$pid,'pidname');
						// echo '=='.$ppid.'-';
						  $sqlwhere = wherecatev($ppid,$pid); 
      $sqlnode="select  distinct   * from ".TABLE_NODE." where  $sqlwhere and sta_visible='y' $andlangbh  and sta_tj='y'  order by pos desc,id desc limit 0,$maxline";
			//  echo $sqlnode.'<br />'; 
				$fenum = getnum($sqlnode);
				if($fenum>0)  {
					$result2 = getall($sqlnode);
					$result= array_merge($result,$result2);
				}
					
				  
						 
						 
						 //--------------------------						 
					 }//end $pidarr foreach	
					// echo '<br><br>';
					 
					// pre($result);
					 $divhide = $k<>0?' style="display:none"':'';
					 $k++;
					 
					 echo '<ul id="a'.$k.'" '.$divhide.'>';
					 htmlhomenodetjhere($result);
					 echo '</ul>';
				}//end arr foreach
				
				
				
	function  htmlhomenodetjhere($result){
				//pre($result);
				$key = 'id';
			 $result = assoc_unique($result, $key);

	     
	      $bypos = array_column($result,'pos');
        array_multisort($bypos,SORT_DESC,$result);

		
		   	foreach($result as $k=>$v){
						  $tid = $v['id'];$pos = $v['pos'];$pid = $v['pid'];
        $title = $v['title']; 
        $pidname = $v['pidname'];$alias_jump = $v['alias_jump'];
        $imgv =  get_img_def($v['kvsm']);
       
       // $despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],$cus_substrnum);       

 
	  
	$proxinghao = $v['proxinghao'];  
	  
        $alias=alias($pidname,'node');  
         $linkurl = url('node',$alias,$tid,$alias_jump);
		 if($k<20){
						?>
					 <li>
						<a href="<?php echo $linkurl;?>">
						<img src="<?php echo $imgv;?>" alt="<?php echo $title;?>" />
						<div class="xinghao"><?php echo $proxinghao;?></div>
						<div class="title22"><?php echo $title;?><?php //echo $pos.'-'.$pid.$title;?></div>
						</a>
					</li>
				<?php
	 	} 
					
				} 
	}			
	//-----------
	function assoc_unique($arr, $key) {
    $tmp_arr = array();
    foreach ($arr as $k => $v) {
        if (in_array($v[$key], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
            unset($arr[$k]);
        } else {
            $tmp_arr[] = $v[$key];
        }
    }
   // sort($arr); //sort函数对数组进行排序
    return $arr;
}

	
	
				?>	
		</div>				
      


