<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

?>

  <tr>
      <td   class="tr"> 添加css：
      </td>
      <td >
    <textarea class="form-control" rows="5" name="addcss"><?php echo $addcss; ?></textarea> <?php echo $xz_maybe; ?>
    <p class="cgray">参考：  assets/vendor/singlecss/font-awesome.css  <br />
    assets/vendor/singlecss/animate.css  <br />
    assets/vendor/bootstrap/bt3.css  <br />
    assets/vendor/bootstrap/bt4.css
    </p>
    </td>
    </tr>

    <tr>
      <td   class="tr"> 添加js：  </td>
      <td >
    <textarea class="form-control" rows="5" name="addjs"><?php echo $addjs; ?></textarea> <?php echo $xz_maybe; ?>
    </td>
    </tr>