<?php 
if ($_SESSION["M_login"]=="" || $_SESSION["M_pwd"]=="" || $_SESSION["M_id"]==""){
Header("Location:member_login.php");
die();
}
?>