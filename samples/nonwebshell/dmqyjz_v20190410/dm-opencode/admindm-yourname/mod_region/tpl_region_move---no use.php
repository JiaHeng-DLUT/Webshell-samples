<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

 exit;

  if($act=='update')
 {
  if($abc1==''){
     alert('请选择区域');
     jump($jumpvpf.'&act=edit&tid='.$tid); 
     exit;

  }


$sql = "SELECT * from ".TABLE_REGION."  where id='$tid' $andlangbh order by id limit 1";
$row222 = getrow($sql);
//$desp=zbdesp_imgpath($row['desp']);
$name= '【复制】'.$row222['name']; 
$namebz= $row222['namebz']; $pos= $row222['pos']; 
$despjj= $row222['despjj']; 
$blockid= $row222['blockid']; 
//$desp= $row222['desp']; 
//$desptext= $row222['desptext']; 
$arr_cfg= $row222['arr_cfg']; 

//pre($_POST);
       
 $pidnamesub='sreg'.$bshou;
 $ss = "insert into ".TABLE_REGION." (pid,pidname,pbh,name,namebz,pos,despjj,blockid,arr_cfg,lang,dateedit) values ('$abc1','$pidnamesub','$user2510','$name','$namebz','$pos','$despjj','$blockid','$arr_cfg','".LANG."','$dateall')";
   //  echo $ss;exit;
      iquery($ss);  
alert('复制成功！');

 jump($jumpv); 

 }
 


 

 
 
 if($act=='edit')
 {
	$jumpv_insert = $jumpvf.'&act=update&tid='.$tid;
 
	$sql = "SELECT * from ".TABLE_REGION."  where id='$tid' $andlangbh order by id limit 1";
$row = getrow($sql);

$pidnamesub=$row['pidname'];
$name=$row['name'];




?>


 
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">
    <tr>
      <td width="20%" class="tr">要复制的内容：</td>
      <td width="78%"><?php echo $name?>
        </td>
    </tr>

	

    
 
<tr>
      <td class="tr">复制到：</td>
      <td>

     <?php 
        $sql = "SELECT pidname,name from ".TABLE_REGION." where pid='0'     $andlangbh  order by  pos desc,id desc";
          $rowlist = getall($sql);
                if($rowlist<>'no'){   
               // pre($rowlist); 

        ?>
          <select name="movepid">
              <option value="">请选择</option>
              <?php 
              
                  
                    foreach($rowlist as $vcat){
                      // $tidmain=$vcat['id']; //tidmain ,not use tid,for conflict in subedit.php
                       $name=$vcat['name']; 
                     
                       $pidnamecur=$vcat['pidname'];
                   //    $pidstyle=$vcat['pidstyle'];  

                     //  $pidstylev = substr($pidstyle,0,5);
 
//if($pidstylev=='style') $name = '<span class="cyel">'.get_field(TABLE_STYLE,'title',$pidstyle,'pidname').'</span>';
                       //when edit mb, also edit region name.so not use above code

 
                      // if($curstyle == $pidstyle) $selectV = ' selected ';
                      // else $selectV = '  ';
                       $pidvv='';
                       if($pidnamecur==$pid) $pidvv = '(当前)';

                     echo '<option   value="'.$pidnamecur.'">'.$name.$pidvv.'</option>';
                    }

           
              
              ?>
              </select>
      
      <?php 
    }
        else {echo '暂无region';}
        ?>
      </td>
    </tr>
    
    <tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="复制区块"></td>
    </tr>
    
  </table>
</form>
 
 <?php  }
 ?>

 
<script>
function checkhere(thisForm) {
 
 if (thisForm.movepid.value==""){
    alert("请选择区域。");
    thisForm.movepid.focus();
    return (false);
  }


     
  

 
   // return;

}
 

</script>

