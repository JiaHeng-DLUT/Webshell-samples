<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>404</title></head><body>
<?php   //from file_inc.php

  header('HTTP/1.1 404 Not Found'); 
header("status: 404 Not Found"); 
 //require_once TPLBASEROOT.'page_404.php';
//echo '404';

global $bsblock404;
 block($bsblock404);


//echo $bsblock404;
 

?>

</body></html>