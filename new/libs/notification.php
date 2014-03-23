<?php
/*
	This file will be removed due to a new notification system if being implemented
	
	/relax
*/
    define("INFINITY", true);
        include_once("relax.php");
        
    if (!isset($_GET['ID']))
        die("E");
    
    $ID = $_GET['ID'];
    if ((int)$ID == 0)
    {
        echo $member->ReadNotification();
    }

?>