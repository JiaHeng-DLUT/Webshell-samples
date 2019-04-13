 
<ul class="textlist <?php echo $cssname?>"  <?php echo $stylev?>>
<?php
foreach($result as $v){
            $tid=$v['id'];
			$title=$v['title'];
			$titlestyle=$v['titlestyle'];
			$pidname=$v['pidname'];
			$dateday=substr($v['dateedit'],0,10);

			$alias=alias($pidname,'node');  
            $kvsm=$v['kvsm'];            
			 
              //echo $cus_substrnum;
              $despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],$cus_substrnum);  
            
            $addr2 =  get_img($kvsm);
            $url = get_url($v);

          if($titlestyle<>'') $titlestylev=' style="'.$titlestyle.'" ';
		  else $titlestylev='';
 

            if($kvsm<>""){
            	?>
            	<li class="hasimg"><a class="img" href="detail-72.html"><img src="http://127.0.0.22:8080/dev2018/dm-opencodestatic/DM-static/upload/image/cn/20160603_101652_5575.png" alt="男篮热身计划：5月VS澳洲6月战马其顿7月赴美"></a><div class="text"><h4><span class="day">2016-05-02</span><a href="detail-72.html">男篮热身计划：5月VS澳洲6月战马其顿7月赴美</a></h4><p class="textshort">北京时间4月6日消息，“高通骁龙”杯中澳男篮热身对抗赛发布会...</p></div></li>


            	<?php
          
                echo '<li class="hasimg">';
				echo '<a class="img"'.linkhref($url).$titlestylev.'><img src="'.$addr2.'" alt="'.$title.'" /></a>';
				echo '<div class="text">';
				echo '<h4>';
				echo '<span class="day">'.$dateday.'</span>';
				 echo '<a '.linkhref($url).$titlestylev.'>'.$title.'</a>';
				echo '</h4>';
				//echo '<p class="textshort">'.web_despdecode($despjj).'</p>';
				if($cus_substrnum>0)  echo '<p class="textshort">'.$despv.'</p>';	
					
				echo '</div>';
				echo '</li>';

            }
            else{
            	?>
            	<li class="noimg"><div class="text"><h4><span class="day">2018-12-18</span>
            	<a href="detail-1018.html"><?php echo $title;?></a></h4>
            	<p class="textshort"></p></div></li>
            	<?php
             echo '<li class="noimg">';
			 	echo '<div class="text">';
				echo '<h4>';
			    echo '<span class="day">'.$dateday.'</span>';
			    echo '<a '.linkhref($url).$titlestylev.'>'.$title.'</a>';
			    echo '</h4>';
				if($cus_substrnum>0)  echo '<p class="textshort">'.$despv.'</p>';		
				echo '</div>';
			 echo '</li>'; 
            }

        }//end foreach

?>
</ul>