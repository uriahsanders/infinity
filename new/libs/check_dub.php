<?php
    define("INFINITY", true);
    include_once('relax.php');
    
    if (!isset($_GET['username']) && !isset($_GET['email']))
        die();
    else
        $members = Members::getInstance();
        
        
    if (isset($_GET['username'])) {
        $results = $members->checkDub("username", $_GET["username"]);
    } elseif (isset($_GET['email'])) {
        $results = $members->checkDub("email", $_GET["email"]);
    } else {
        die();
    }
	if ($results)
		echo 1;
	else
		echo 0;
?>