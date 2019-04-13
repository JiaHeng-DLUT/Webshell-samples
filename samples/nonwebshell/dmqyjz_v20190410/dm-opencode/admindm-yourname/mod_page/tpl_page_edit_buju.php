<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>


<?php
 
 if($act=="edit_buju"){
   
?>

<h2 class="h2tit_biao">修改布局</h2>

<form  onsubmit="javascript:return menupageadd(this)" action="<?php  echo $jumpv_update_buju;?>"   method="post" enctype="multipart/form-data">
<table class="formtab">


 <tr>
    <td width="12%" class="tr"><b>banner标识：</b></td>
    <td width="88%" style="background:#DBF2FF">  <input onclick="this.select();document.execCommand('Copy');" name="bslh" type="text" value="<?php echo $row['taiimg']?>" size="40">
     <?php echo $xz_maybe;?></td>
  </tr>

  <tr>
    <td width="12%" class="tr">页面路径：</td>
    <td width="88%" style="background:#DBF2FF">

    页面路径的图片：  <input name="leftimg2" type="text"  value="<?php echo $row['bcb_img']?>" size="30">
      <?php echo $xz_maybe;?>
     <div style="margin:6px 0;border-bottom:1px solid #999"></div>
自定义页面路径(文字)(<em>如果使用文字，则上面图片框要留空</em>)：<br /><textarea rows="2" cols="130" name="bcb_text">
<?php echo $row['bcb_text'];?>
</textarea>
     <br /> <?php echo $xz_maybe;?>
(参考代码请见本页下面)

      </td>
  </tr>

 <tr>
    <td width="12%" class="tr">页面左侧：</td>
    <td width="88%" style="background:#fff">

 左侧标识1：<input name="pbage_block1" type="text" value="<?php echo $row['leftblock1']?>" size="40">
      <?php echo $xz_maybe;?>(默认为左侧菜单，隐藏请填： hide)

<br />
     <!-- <div style="margin:6px 0;border-bottom:1px solid #999"></div>-->


左侧标识2：<input name="paage_block2" type="text" value="<?php echo $row['leftblock2']?>" size="40">
      <?php echo $xz_maybe;?>
 <br />
   左侧标识3：<input name="pacge_block3" type="text" value="<?php echo $row['leftblock3']?>" size="40">
      <?php echo $xz_maybe;?>


      </td>
  </tr>

<tr>
    <td width="12%" class="tr">页面右侧：</td>
    <td width="88%" style="background:#E3DEBE">
右侧标识符1： <input name="raight1" type="text"  value="<?php echo $row['rginctop'];?>" size="40"> <?php echo $xz_maybe;?> &nbsp; &nbsp;

<br />
右侧标识符2： <input name="rbight3" type="text"  value="<?php echo $row['rgincmid'];?>" size="40"> <?php echo $xz_maybe;?>
 (默认为功能模块内容显示。隐藏请填： hide)
<br />
右侧标识符3： <input name="rcight2" type="text"  value="<?php echo $row['rgincbot'];?>" size="40"> <?php echo $xz_maybe;?>

      </td>
  </tr>
   <tr>
    <td width="12%" class="tr">其他标识：</td>
    <td width="88%" style="background:#DBF2FF">
页面上部： <input name="pagetop" type="text"  value="<?php echo $row['pagetop'];?>" size="30"> <?php echo $xz_maybe;?> &nbsp;
  </td>
  </tr>

  <tr>
    <td></td>
    <td> <input class="mysubmit" type="submit" name="Submit" value="提交"></td>
  </tr>
 </table>
</form>

<?php
} 
?>
<div class="" style="border:5px solid #ccc;padding:6px">

 页面路径代码参考:<br />
  <textarea cols="130" rows="2">
<a href="index.html">首 页</a> > <a href="about.html">关于我们</a> > 企业文化
      </textarea>
</div>