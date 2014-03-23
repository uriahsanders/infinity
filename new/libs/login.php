<?php
define("INFINITY", true);
include_once("relax.php");


/*
	un-comment when going live!
	regex so only login will be possile from our own site
*/
//http://new2.infinity-forum.org/about/
//if (!preg_match("/^http(s)?\:\/\/([a-zA-Z0-9]*)?\.?infinity-forum\.org\/?/", $_SERVER['HTTP_REFERER']))// only allow this file to be accessed from our servers
  //  header("Location: /"); 

$login = Login::getInstance();

$login->loginUser();
?>