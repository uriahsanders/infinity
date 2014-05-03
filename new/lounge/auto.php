<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
include_once('../libs/relax.php'); 
$query = Database::getInstance()->query("SELECT `username` FROM `memberinfo` WHERE `username` LIKE ? ORDER BY `username`", "%".$_GET["term"]."%");
 $json=[];
    while($user = $query->fetch()){
         $json[]=[
            'value'=> $user['username']
            ];
    }
die(json_encode($json));