

<tr style="background:#dce8f4">
        <td class="tr fb">效果文件：</td>
        <td>
 <?php

 
 
if($ppid=='common')  $filedir = BLOCKROOT.$type.'/';
if($ppid4=='styl')  $filedir = TPLCURROOT.'selfblock/'.$type.'/';
if($ppid4=='dmre')  $filedir = REGIONROOT.$ppid.'/'.$type.'/';

if(is_dir($filedir))  {
    $filearr = getFile($filedir);
    if($filearr[0]=='')  $filearr = array('nofile'=>'无文件');
}
else $filearr = array('nofile'=>'无文件');
 

//pre($filearr);
 //$filedirself = TPLCURROOT.'selfblock/'.$type.'/';
 //echo $filedirself;
// if(is_dir($filedirself)) {
 //$filearr2 = getFile($filedirself);
 //$filearr = array_merge($filearr,$filearr2);
 // }

//$filedir = BLOCKROOT.$type.'/';
//$filedirself = TPLCURROOTADMIN.'mbblock/'.$type.'/';
echo  '<select name="template">';
select_from_arr2($filearr,$template,'');
 //select_from_filearr($filedir,$template);
//select_from_filearr2($filedir,$filedirself,$template);
echo '</select>';




  if($template<>'') {
     
    if($ppid=='common')  $file =  BLOCKROOT.$type.'/'.$template;
if($ppid4=='styl')  $file =  TPLCURROOT.'/selfblock/'.$type.'/'.$template;
if($ppid4=='dmre')  $file = REGIONROOT.$ppid.'/'.$type.'/'.$template;

 
     // echo '<br />效果文件：';
      checkfile($file) ;

  }


    ?>



</td>
    </tr>
