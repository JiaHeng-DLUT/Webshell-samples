<?php 
//require by common.inc

//echo $mod_previ;  -- admin,normal, other. welcome,and previ_no are other
//echo $usertype;
if($usertype=='normal'){
		if($mod_previ=='admin'){
				 jump('../mod_common/mod_previ_no.php?lang='.LANG);
		}
		else if($mod_previ=='normal'){
				global $mod_previ_except;
			if($mod_previ_except<>'y'){ // $mod_previ_except in mod_album.php
			$strpos = strpos($arrayprevi,$catpid);
			 if(!is_int($strpos)) jump('../mod_common/mod_previ_no.php?lang='.LANG);
			}


		}
		//else if ($mod_previ=='other') --- use in previ_no.php

}
 

?>