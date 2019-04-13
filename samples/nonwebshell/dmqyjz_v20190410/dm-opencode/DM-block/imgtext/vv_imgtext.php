<?php

    $sqlabm = "SELECT * from ".TABLE_IMGTEXT."  where  pidname='$pidname'   $andlangbh  order by id desc";
 
    if(getnum($sqlabm)>0){
         $row = getrow($sqlabm);
         $imgtextpidname = $row['pidname'];
         $effect = $row['effect']; 
         $cssname = $row['cssname'];$fullwidth = $row['fullwidth'];$haswow = $row['haswow'];
        // echo $fullwidth;
       
        $fullwidthv = $fullwidth=='n'?' container ':'';
        $cssname = $fullwidthv.$cssname;

               $sql = "SELECT * from ".TABLE_IMGTEXT."  where  pid='$pidname' and sta_visible='y'   $andlangbh  order by pos desc,id";
                   if(getnum($sql)>0){

                     $file =  BLOCKROOT.'imgtext/'.$effect;  

                       if(checkfile($file)) {
                            echo '<div id="'.$imgtextpidname.'" class="cc imgtextwrap '.$cssname.'" data-effect="'.$effect.'">';
                            $result_imgtext = getall($sql);
                           // pre($result_imgtext);
                            require $file;   
                             echo '</div>';                         

                      } 

                   }
                   

    }
    else{
        echo '出错，imgtext不存在。- '.$pidname;
    }


?>
<?php

function imgtext_echocnt($format,$blockid,$imgv,$title,$despv,$haswow){
   if($haswow=='y') {
      $wowleft = ' wow fadeInLeft';
      $wowright = ' wow fadeInRight';$wowup = ' wow fadeInUp ';
   }else{
         $wowleft =  $wowright  = $wowup = '';
   }

      if($format=='imgtop') {
      
       echo '<div class="tc"><img src="'.$imgv.'" alt="'.$title.'" /></div>';
       echo '<h3 class="tc">'.$title.'</h3> <div class="desp">'.$despv.'</div>';
      
  }
   
 else if($format=='imgleft') {
     
       echo '<div class="colhalf tc '.$wowleft.'"><img src="'.$imgv.'" alt="'.$title.'" /></div>';
       echo '<div class="colhalf '.$wowright.'"><h3>'.$title.'</h3> <div class="desp">'.$despv.'</div></div>';
        
  }
 else  if($format=='imgright') {  
        
       echo '<div class="colhalf'.$wowleft.'"><h3>'.$title.'</h3> <div class="desp">'.$despv.'</div></div>';
       echo '<div class="colhalf tc '.$wowright.'"><img src="'.$imgv.'" alt="'.$title.'" /></div>';
        
  }   

   else  if($format=='onlyedit') {          
       echo ' <div class="desp">'.$despv.'</div>';
        
  }  

 
  else if($format=='bsleft') {
        
       echo '<div class="colhalf '.$wowleft.'">';
       block($blockid);
       echo '</div>';
       echo '<div class="colhalf '.$wowright.'"><h3>'.$title.'</h3> <div class="desp">'.$despv.'</div></div>';
        
        
  }
 else if($format=='bsright') {  
       
       echo '<div class="colhalf '.$wowleft.'"><h3>'.$title.'</h3><div class="desp">'.$despv.'</div></div>'; 
       echo '<div class="colhalf '.$wowright.'">';
       block($blockid);
       echo '</div>';
       

  }  
 else if($format=='bsonly') {  
       
      echo '<div class="'.$wowup.'">';
       block($blockid);
       echo '</div>';
       

  }  

}
  

function titlefgv($title,$titlefg){
   if($titlefg=='notitle') $v = '';
   else if($titlefg=='titlecenter') {
            $v = '<div class="regionhd "><h3 class="hd">'.$title.'</h3><div class="titleline  titlelinelong "> <span class="titlelineshort"></span></div></div>';
   }
   else if($titlefg=='titleleft') {
              $v = '<div class="regionhd  regionhdleft"><h3 class="hd">'.$title.'</h3><div class="titleline  titlelinelong "> <span class="titlelineshort"></span></div></div>';
   }

   return $v;
}
 

?>