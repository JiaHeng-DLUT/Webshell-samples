<div class="box"> 
<div class="boxheader">
    <h3><i class="fa fa-list" aria-hidden="true"></i> 修改样式</h3>
</div>
  <div class="boxcontent">

      <ul class="list-group">

         <li><i class="fa fa-angle-right"></i> <a class="<?php echo $editcssdesp_cur;?>"  href="<?php echo $jumpv_p;?>&file=edit_cssdesp&act=edit">修改自定义样式 ></a></li>

         <?php 
         $sta_sqlcss = get_field(TABLE_STYLE,'sta_sqlcss',$pidname,'pidname');
 
         if($sta_sqlcss<>'y'){

          ?>
          <li><i class="fa fa-exclamation-circle"></i> 您已取消了数据库样式，可以点击下面链接开启它。 </li>

          <?php 
        }
        else {
          ?>
          <li><i class="fa fa-angle-right"></i> <a class="<?php echo $editcsssql_cur;?>"  href="<?php echo $jumpv_p;?>&file=edit_csssql&act=edit">修改数据库样式 ></a></li>


          <?php 
        }
        ?>

        <li><i class="fa fa-angle-right"></i> <a class="<?php echo $editcssactive_cur;?>"  href="<?php echo $jumpv_p;?>&file=edit_cssactive&act=edit">开启数据库样式 ></a></li>
      </ul>
  </div>
</div>

