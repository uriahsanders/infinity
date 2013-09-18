<?php
    define("INFINITY", true);
    include_once('relax.php');
    
    if (!isset($_GET['username']) && !isset($_GET['email']))
        die();
    else
        $sql = new SQL();
        
        
    if (isset($_GET['username'])) {
        $results = $sql->Query("SELECT username FROM members WHERE `username` = %s",$_GET['username']);
    } elseif (isset($_GET['email'])) {
        $results = $sql->Query("SELECT email FROM members WHERE `email` = %s",$_GET['email']);
    } else {
        die();
    }
    echo mysql_num_rows($results);
?>