<?php
  // ini_set('display_errors', FALSE);
ini_set('display_errors', FALSE);

define('IN_DEMOSOSO', TRUE);

session_start();

$dirnamefile = dirname(__FILE__);

$dirnamefile=str_replace('\\','/',$dirnamefile);

$heredir_arr = explode('/',$dirnamefile);
$heredir_arr2 = array_slice($heredir_arr,-2,1);

$heredirlen = count($heredir_arr)-2;
$heredir_root = array_slice($heredir_arr,0,$heredirlen);
$heredir_root_string = implode('/', $heredir_root).'/';


define('WEB_ROOT', $heredir_root_string);



$adminstring = $heredir_arr2[0];
if(substr($adminstring,0,8)<>'admindm-'){
  echo '后台目录必须以admindm-开头，比如admindm-yournameyourname*** (admindm-后面不受限制)';
  exit;}



$userdir='';$baseurl='';


ini_set('session.gc_maxlifetime', 7200);





 setcookie("usercookie",'n',time()-1,"/");
 setcookie("isadmin",'n',time()-1,"/");
   setcookie("admindir",'n',time()-1,"/");
      setcookie("mbadmin",'n',time()-1,"/");

    //  session_destroy();
    unset($_SESSION['sessionsec']);
 
   jump('../mod_common/login.php');


function jump($link){
    echo "<script LANGUAGE='javascript'>window.location='$link'</script>";
    exit;
}
?>
