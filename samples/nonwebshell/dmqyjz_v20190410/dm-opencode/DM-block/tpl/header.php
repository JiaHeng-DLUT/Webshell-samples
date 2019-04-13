<?php
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
?>
 <?php 
  if(substr($header_pc,0,5)=='self_')  $file =  TPLCURROOT.'selfblock/header/'.$header_pc;
   else  $file = BLOCKROOT.'header/'.$header_pc;
if(checkfile($file)) require $file;

 
//如果移动端要不同的html，可以下面写法

// if(isdmmobile())  {
  // ......
 //} 
 //else {
    // ......
 //}   
?>
   