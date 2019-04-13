

    <tr>
     
         <td class="tr"><a class="needpopup" href="../mod_module/mod_showblockid_album.php?lang=<?php echo LANG; ?>" >相册标识</a>：</td>
     <td>    
     <input name="detail_albumid" type="text"  value="<?php echo $detail_albumid;?>" size="35" /> <?php echo $xz_maybe;?>
     <?php echo check_blockid($detail_albumid);?>
     </td>
    </tr>
    <tr>
         <td class="tr">  <a class="needpopup" href="../mod_module/mod_showblockid_video.php?lang=<?php echo LANG; ?>" >视频标识</a>
  ：</td>
     <td>    
     <input name="detail_videoid" type="text"  value="<?php echo $detail_videoid;?>" size="35" /> <?php echo $xz_maybe;?>
     <?php echo check_blockid($detail_videoid);?>
     </td>
    </tr>

        <tr>
         <td class="tr">
       <a class="needpopup"  href="../mod_module/mod_showblockid_music.php?lang=<?php echo LANG?>">音乐区块标识</a>：</td>
     <td> 
     <?php 
      //$detail_musicid=str_replace("|",chr(13),$detail_musicid);

     ?>
    <!--
    <textarea name="detail_musicid" type="text" cols="10" rows="5"  class="form-control" /><-?php echo $detail_musicid?></textarea>
    -->
    <input name="detail_musicid" type="text"  value="<?php echo $detail_musicid;?>" size="35" /> <?php echo $xz_maybe;?>
    <?php echo check_blockid($detail_musicid);?>
        
        </td>
    </tr>
