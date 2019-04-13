  <table class="formtab">
 
      <td >
  发布时间：
       
      <input name="dateedit" type="text"  value="<?php echo $dateedit;?>" class="form-control" />
  <span class="cgray">参考：<?php echo date("Y-m-d H:i:s");?></span>
     
        </td>
    </tr>

 
    <tr>
      <td>禁止访问：
<?php 
 
//$disselect='';
if($user_stanoaccess=='y' && $usertype=='normal') {// $disselect='disabled="disabled"';//no use,will effect abc1
$sta_noaccess='y';
echo '<span class="cgray">您的权限 不能修改禁止访问。</span><br />';
}
 ?>
      <select name="sta_noaccess">
    <?php   
   
    select_from_arr($arr_yn,$sta_noaccess,'');?>
     </select>
     <?php
   if($sta_noaccess=='y') echo '<span style="color:red">禁止访问</span>';
   ?>
        </td>
    </tr>
     
 

     <tr>
     <td>      
      点击数： 
      <input name="hit" type="text"  value="<?php echo $hit?>" size="20" />
   
    </td>
    </tr>

     <tr>   <td>
      页面跳转网址： 
      <input name="alias_jump" type="text"    value="<?php echo $alias_jump?>" class="form-control form-controldi" />
 
       <?php echo $xz_maybe;?>
      <br /><?php echo $text_outlink;?> 


 <?php if($alias_jump<>'') { echo $text_jump;
      }?>
      

        </td>
    </tr>

  <tr>   <td>
      标题样式： 
      <input name="titlestyle" type="text"  value="<?php echo $titlestyle?>" class="form-control form-controldi" />
 
       <?php echo $xz_maybe;?> 
      
<p class="cgray">试下： color:red (适用于分类文本列表效果文件)</p>
        </td>
    </tr>





  </table>

