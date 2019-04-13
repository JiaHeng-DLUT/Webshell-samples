<?php 
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

$type = @htmlentitdm($_GET['type']);
$tid = @htmlentitdm($_GET['tid']);
$cate = @htmlentitdm($_GET['cate']);
$callback = @htmlentitdm($_GET['callback']);

 function api_jsonp_encode($json)
    {  global $callback;
        if (!empty($callback)) {
            return $callback . '(' . $json . ')'; // jsonp
        }
        return $json; // json
	}
	
 
if($type=='nodelist') require_once WEB_ROOT.'api/apihtml/nodelist.php';
else if($type=='nodedetail') require_once WEB_ROOT.'api/apihtml/nodedetail.php';
else { echo '404'; exit;} 
?>