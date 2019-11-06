<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { //ONLY ALLOW POST METHOD
    Header("Location: /");
    die();
}
define("INFINITY", true);
include_once('relax.php');
$cryptinstall="../extra/crypt/cryptographp.fct.php";
include_once $cryptinstall;
$register = Login::getInstance();
$register->RegisterUser($_POST);
?>