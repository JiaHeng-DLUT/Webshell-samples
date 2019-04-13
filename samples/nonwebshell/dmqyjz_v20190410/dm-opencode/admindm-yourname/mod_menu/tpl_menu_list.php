<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>

 
<?php 
 

	 $sql = "SELECT * from ".TABLE_MENU." where  ppid='$ppid' and pid='0'  $andlangbh  order by pos desc,id";
	 //ECHO $sql;
	 $rowlist = getall($sql);
    if($rowlist == 'no')  echo '<p style="padding:55px;background:#eee">没有菜单，请添加。</p>';
    else {
	?>

 <form method=post action="<?php echo $jumpv;?>&act=pos">
<table class="formtab formtabhovertr" style="width:100%">
  <tr style="font-weight:bold;background:#eeefff">
  <td   align=center>排序号</td>
    <td  align=center>菜单名称</td>    
 
   <td   align="center">操作</td>
     <td  align="center">状态</td>
  </tr> 
  <?php
      foreach($rowlist as $v){
            $tid = $v['id'];
            $pidname = $v['pidname'];
            
            $menu_xiala = $v['menu_xiala'];  
			      $linkurl = $v['linkurl'];

            $typepidname = $v['type'];
            $type =substr($typepidname,0,4);

            $kv = $v['kv'];
            $sta_visi_v = $v['sta_visible']; 
			     $sta_noaccess = $v['sta_noaccess']; 			
            //
            $sta_noaccess_v = string_staaccess($sta_noaccess);
           // menu_changesta($sta_visi_v,$jumpv,$tid);//trbg and tr_hide is in here
			 menu_changesta($sta_visi_v,$jumpv,$tid,'sta_menu');
			  
		
    if($type=="cusm"){    
         $name = '<span class="cblue2">'.decode($v['name']).'</span> ';
		 $jsname = jsdelname($v['name']);
         $sta_cmp_v= '<strong class="cgreen">自定义 </strong> <span class="cgray">(链接：'.$linkurl.')</span>';

          if(ifhasrecord(TABLE_MENU,$pidname,'pid','')) 
            $edit_desp='<a class="but1"   href='.$jumpv.'&file=cusaddedit&act=edit&act2=havesub&tid='.$tid.'><i class="fa fa-pencil-square-o"></i> 修改</a>';
           else 
            $edit_desp='<a class="but1"   href='.$jumpv.'&file=cusaddedit&act=edit&tid='.$tid.'><i class="fa fa-pencil-square-o"></i> 修改</a>';
          //act2=havesub ,mean bec have sub menu.so no parent select.
                  

       }

      else if($type=="page"){			 
               
                  $pagearr = get_fieldarr(TABLE_PAGE,$typepidname,'pidname');
                  if($pagearr=='no') {$name='单页面不存在';
				  $jsname = jsdelname('单页面不存在');	
                  $pageid = '0';
                }
                else {
                  $name = decode($pagearr['name']);
				  $jsname = jsdelname($pagearr['name']);	
                  $pageid = $pagearr['id'];
                }

 $sta_cmp_v='<a href="../mod_page/mod_page_edit.php?lang='.LANG.'&file=edit_desp&act=edit&tid='.$pageid.'" target="_blank">(单页面)</a>';  

            


           // $edit_desp='<a class="but1"   href='.$jumpv.'&file=edit&act=edit&tid='.$tid.'>修改</a>';
		  if(ifhasrecord(TABLE_MENU,$pidname,'pid','')) $edit_desp='';
           else $edit_desp='<a class="but1"   href='.$jumpv.'&file=pageedit&act=edit&tid='.$tid.'><i class="fa fa-pencil-square-o"></i> 修改</a>';
          




				 }
            
     else {
            	


			//	$rowcate = getrow_catebypidname($pidname);	
     
        $sqlcate = "SELECT * from ".TABLE_CATE." where  pidname='$typepidname' $andlangbh order by id desc limit 1";
       $rowcate= getrow($sqlcate); 
       if($rowcate>0)  {

				$name = decode($rowcate['name']);  
       $jsname = jsdelname($rowcate['name']);				
		   $name="<span class='cyel'>$name</span>";
 
           //mod_category/mod_subcate.php?lang=cn&catid=cate20150805_1125344029
      $catelink = '<a target="_blank"  href="../mod_category/mod_subcate.php?lang='.LANG.'&catid='.$typepidname.'">分类</a>';
       $sta_cmp_v='<span class="cyel">'.$catelink.'</span>';
     }
      else  {
        $name = '分类不存在';
        $sta_cmp_v='无分类。';
      }

        $edit_desp='';

	 
    } 

      $delmenu= " <a class='but2'  href=javascript:del('del','$pidname','$jumpv','$jsname')><i class='fa fa-trash-o'></i> 删除</a>";



    ?>
  <tr  <?php echo $tr_hide;?> style="border-top:2px solid #999">
  <td align="center"><input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="5" /></td> 

    <td align="left">
    <strong><?php echo $name;?></strong>
    <?php if($menu_xiala<>'') echo '<br /><span class="cred">(注意： 下拉菜单有内容， 子菜单不会在前台显示)</span>';?>

    <div class="mobhide">标识： <?php echo $pidname; ?></div>
     类型： <?php echo $sta_cmp_v; ?>

    </td>
   
 
 
<?php 
if($kv<>''){ //when dingzhi
//echo   get_thumb($kvsm,'','div');
   //$kv = get_img_def($kv);
 //echo    '<img  src="'.$kv.'" >';
 
  //echo  p2030_imgyt($kvsm,'y','n');

}
?>
 

   <td align="center"><?php  echo $edit_desp.$delmenu?></td>
   <td align="center"> <?php   echo $sta_visible;?></td>      
  </tr>



<?php
//--------------begin sub------

 $sqlsub = "SELECT * from ".TABLE_MENU." where  ppid='$ppid' and pid='$pidname'   $andlangbh  order by pos desc,id";
 //echo $sqlsub;
    $rowlistsub = getall($sqlsub);
     if($rowlistsub<>'no'){
       // echo '<tr><td colspan=7><table width="100%"><tr><td width=80 style="background:#ccc;text-align:center">子菜单:</td><td>';
         foreach($rowlistsub as $vsub){
             $subtid=$vsub['id'];
			       $subpidname=$vsub['pidname']; 
             $sublinkurl=$vsub['linkurl']; 
             $sta_visi_vsub=$vsub['sta_visible'];
             $sub_type=$vsub['type']; //sub only is page	and cusm
             $sub_typefour=substr($sub_type,0,4);

            // echo $sub_type.'====';
 
 if($sub_typefour=="page"){    
         $subpagearr = get_fieldarr(TABLE_PAGE,$sub_type,'pidname');   
             if($subpagearr=='no') {
                    $subname='&nbsp;&nbsp;&nbsp;├单页面不存在';
			              $jsname = jsdelname('单页面不存在');
                    $subpageid = '0';
                }
                else {
                   $subname='&nbsp;&nbsp;&nbsp;├ '.decode($subpagearr['name']); 
                   $subpageid = $subpagearr['id'];
				           $jsname = jsdelname($subpagearr['name']);
                }

    $substa_cmp_v='&nbsp;&nbsp;&nbsp;├<a href="../mod_page/mod_page_edit.php?lang='.LANG.'&file=edit_desp&act=edit&tid='.$subpageid.'" target="_blank">(单页面)</a>';  
     $edittext_sub='<a class="but1"   href='.$jumpv.'&file=pageedit&act=edit&tid='.$subtid.'><i class="fa fa-pencil-square-o"></i> 修改</a>';

  }
  else{
      $subname = '&nbsp;&nbsp;&nbsp;├ <span class="cblue2">'.$vsub['name'].'</span> ';      
      $substa_cmp_v='&nbsp;&nbsp;&nbsp;├<strong class="cgreen">自定义</strong> <span class="cgray">(链接：'.$sublinkurl.')</span>';    
      $edittext_sub='<a class="but1"   href='.$jumpv.'&file=cusaddedit&act=edit&tid='.$subtid.'><i class="fa fa-pencil-square-o"></i> 修改</a>';
    
  }


             		  
	   //menu_changesta($sta_visi_vsub,$php_self,$subtid);
               menu_changesta($sta_visi_vsub,$jumpv,$subtid,'sta_menu'); 
 
			 
			   
			 
			

   $delmenu_sub= " <a class='but2'  href=javascript:del('del','$subpidname','$jumpv','$jsname')><i class='fa fa-trash-o'></i> 删除</a>";
         
             ?>
  <tr  <?php echo $tr_hide;?>>
  <td align="center">&nbsp;&nbsp;├ <input type="text" name="<?php echo $subtid;?>"  value="<?php echo $vsub['pos'];?>" size="3" /></td>

    <td align="left">
          <strong><?php echo $subname;?></strong>
          <div class="mobhide">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  标识： <?php echo $subpidname; ?></div>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  类型： <?php echo $substa_cmp_v; ?>

    </td> 
    
    <td align="center"><?php  echo $edittext_sub.$delmenu_sub?></td>
     <td align="center"> <?php   echo $sta_visible;?></td>  
  
  </tr>
<?php
    }
  }
//-----end sub----

    } ?>
</table>
<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
<br />
<?php echo $sortid_asc?></div>
</form>
 


<?php 
}
?>
 