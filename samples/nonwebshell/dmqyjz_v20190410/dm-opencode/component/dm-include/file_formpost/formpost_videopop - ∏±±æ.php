<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

 //http://fancyapps.com/fancybox/#examples

 
 $sql="select * from  ".TABLE_VIDEO."  where  pidname='$pidname' $andlangbh order by  id desc";
     //echo $sql; 
if(getnum($sql)>0) {
  $row=getrow($sql);
  $pidname=$row['pidname'];$title=$row['title'];
  $kv=$row['kv'];$cssname=$row['cssname'];
  // $effect=$row['effect'];
  $pid=$row['pid'];$type=$row['type'];
  $despjj=$row['despjj'];
 $desp=$row['desp'];
 $video=$row['video'];

$datafrom = $pid.'--'.$type;

 $despjj= web_despdecode($row['despjj']);


  //--seo----
    $seo1v=$title;
    $seo2v=$title;
    $seo3v=$title;
    //unset($seo1)
    //array_unshift($seo1, $curseo1);
    if($seo1v<>''){ $seo1[0] =$seo1v;} else  $seo1[0] =$title;
    if($seo2v<>''){ $seo2[0] =$seo2v;} else  $seo2[0] =$title;
    if($seo3v<>''){ $seo3[0] =$seo3v;} else  $seo3[0] =$title;
   
 
require_once  BLOCKROOT.'tpl/meta.php'; 

 
?>
   
  
     <div class="videodetail" data-from = <?php echo $datafrom;?>>
        <div class="videodesp">

         <?php 
        
         if($video<>'') {   
                   $videoroot = STAROOT.'upload/video/'.$video;
                   $videopath = STAPATH.'upload/video/'.$video.'?v='.CSSVERSION;
                            
                  if(!is_file($videoroot)){

                            echo '<br /><span class="cred"> DM-static/upload/video 目录不存在这个视频文件: '.$video.'</span>';
                        }

                  else { 
            //video image
            if($kv=='') $videoimgv = STAPATH.'img/video.jpg';
            else  $videoimgv = UPLOADPATHIMAGE.$kv;
            ?>

              <video id="dmvideo_1" class="video-js vjs-default-skin vjs-big-play-centered" controls  autoplay="autoplay" preload="none" width="100%" height="100%"  poster="<?php echo $videoimgv;?>" data-setup="{}">
                <source src="<?php echo $videopath;?>" type="video/mp4">
               
               </video> 

            <?php
         }
       }
         else{



 
         $strpos2 = is_int(strpos($desp,'iframe'));
         
        if($strpos2){ echo decode($desp); }
          else { 
            echo '<br /><br /><br /><br /><br />出错提示：请检查视频地址的内容。只支持mp4或iframe，或embed形式。另外移动端不支持embed形式。所以，最好用mp4或iframe。';
            exit;
          }
 
           
            if(isdmmobile()) {

              if(is_int(strpos($desp,'embed')))  echo '<p style="color:#666;text-align:center">移动端可能不支持flash的播放形式。请用mp4或iframe的形式</p>';
            }
             
           
         }
     ?>
        

         </div>
          <?php 
           echo '<h5 class="videotitle">'.$title.'</h5>';
          if($despjj<>'') echo '<div class="videotext">'.$despjj.'</div>';

          ?>
                
        </div>

   <?php     

        }
else {
      echo 'no record of video.';
 }

 ?>







<script>

document.body.style.overflow='hidden' ;

</script>





 <?php


 //以下 这是 mp4视频的js,css,如果不需要，可以删除
 //getCssSingle(STAPATH.'assets/vendor/videojs/videojs.min.css');
 //getJsSingle(STAPATH.'assets/vendor/videojs/videojs.min.js');

if(3<2){ //no use.........
?>

<script type="text/javascript">
 
if($('#dmvideo_1').length>0){
    videojs('dmvideo_1').ready(function(){
      //console.log(this.options()); //log all of the default videojs options

       // Store the video object
      var myPlayer = this, id = myPlayer.id();
      // Make up an aspect ratio
      var aspectRatio = 264/640;

      function resizeVideoJS(){
        var width = document.getElementById(id).parentElement.offsetWidth;
        myPlayer.width(width).height( width * aspectRatio );

      }

      // Initialize resizeVideoJS()
      resizeVideoJS();
      // Then on resize call resizeVideoJS()
      window.onresize = resizeVideoJS;
    });
  }
</script>
<?php 

}
?>



</body>
</html>
   
 


