 
  <table class="formtab" >
 

  <tr>
      <td  class="tr" width="80">禁止访问：</td>
      <td  >
 
      <select name="sta_noaccess">
    <?php select_from_arr($arr_yn,$sta_noaccess,'');?>
     </select>
   <?php
   if($sta_noaccess=='y') echo '<span style="color:red">禁止访问</span>';
   ?>
        </td>
    </tr>

 

 



</table>

