<?php
/*
	TODO for relax
		Move this file to a different folder more sutable for it actions and make sure it works.
		A good name would be a folder called actions
		
	/Relax

*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { //ONLY ALLOW POST METHOD
    Header("Location: /");
    die();
}

define("INFINITY", true);
include_once("relax.php");

$cryptinstall="../extra/crypt/cryptographp.fct.php";
include_once $cryptinstall;

$register = Login::getInstance();
$register->RegisterUser($_POST);
?>