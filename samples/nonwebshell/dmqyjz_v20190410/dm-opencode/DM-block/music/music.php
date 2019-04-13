<?php
/*
 if(@$detail_musicid<>'') $musicid = $detail_musicid;
 else $musicid = $despjj; //from block 
 //echo $musicid;

 $ifmusicarr ='n';
 $musicaddr = array();
 if(is_int(strpos($musicid,'|'))){
     $musicarr = explode('|', $musicid);
     $musicfirst = $musicarr[0];
      $ifmusicarr='y';


 }
 else {
   $musicfirst = $musicid;
 }
*/
 
 
      $title = $resmusic[0]['title'];
      $kvlink = $resmusic[0]['kvlink'];
      $kv = $resmusic[0]['kv'];
      $musicaddr = getmusic($kvlink,$kv);
      if($musicaddr =='no')  $title = $title.'--本地的音乐文件不存在。';
 
?>

<div class="musicwrap <?php echo $cssname?>">
<div id="wxaudio1" data-path="<?php echo STAPATH;?>assets/vendor/wxmusic/" ></div>

 <?php
if(count($resmusic)>1){
  echo '<div class="musiclist"><strong>音乐列表：</strong><ul>';
    foreach ($resmusic as $k=>$v) {
     
      $title2 = $v['title'];
      $kvlink2 = $v['kvlink'];
      $kv2 = $v['kv'];
      $musicaddr2 = getmusic($kvlink2,$kv2);
     // echo $musicaddr2;
      if($musicaddr2 =='no')  $title2 = $title2.'--本地的音乐文件不存在。';

       ?>

  <li><span  <?php if($k==0) echo ' class="cur"'; ?> data-src="<?php echo $musicaddr2;?>" data-title="<?php echo $title2;?>">• <?php echo $title2;?></span></li>


 <?php

       }
     echo '  </ul></div>';
   }
 
 
?>

</div>
<link href="<?php echo STAPATH;?>assets/vendor/wxmusic/wxaudio.css?v=<?php echo CSSVERSION;?>" rel="stylesheet" type="text/css" />
<script src="<?php echo STAPATH;?>assets/vendor/wxmusic/wxaudio.js?v=<?php echo CSSVERSION;?>" type="text/javascript" charset="utf-8"></script>


<script>
  var wxAudio = new Wxaudio({
    ele: '#wxaudio1',
    title: '<?php echo $title;?>',
    disc: '',
    src: '<?php echo $musicaddr;?>'
  });
  function play() {
    wxAudio.audioPlay()
  }



  $(function(){
         $('.musiclist li span').click(function(){

                      $('.musiclist li span').removeClass('cur');
                      $(this).addClass('cur');
                     var src = $(this).data('src');
                      var title = $(this).data('title');
                      var disc = '';
                      wxAudio.audioCut(src, title, disc)

         });



  })

</script>
