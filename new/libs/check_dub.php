<?php
/*
	this file is called from ajax.
*/
    define("INFINITY", true);
    include_once('relax.php');
    
    if (!isset($_GET['reg_usr']) && !isset($_GET['reg_email']))
        die();
    else
        $members = Members::getInstance();
    if (isset($_GET['reg_usr'])) {
        $results = $members->userExist($_GET["reg_usr"], "username");
    } elseif (isset($_GET['reg_email'])) {
        $results = $members->userExist($_GET["reg_email"], "email");
    } else {
        die();
    }
	if ($results)
		echo 1;
	else
		echo 0;
?>