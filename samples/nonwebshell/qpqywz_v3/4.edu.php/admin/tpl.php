<?php 
$page=$_GET["page"];
$pagex=explode("^",file_get_contents("tpl.html"));
echo $pagex[$page];
?>