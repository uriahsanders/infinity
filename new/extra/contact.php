<?php
if (isset($_POST['subject']) && isset($_POST['email']) && isset($_POST['msg'])) {
	if (strlen($_POST['subject']) <= 3) { header("Location: /about/err/1"); die("");}
	if (!preg_match('/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/', $_POST['email'])){ header("Location: /about/err/2");die("");}
	if (strlen($_POST['msg']) < 30){ header("Location: /about/err/3");die("");}
	if ($_POST['token'] != $_SESSION['token']){ header("Location: /about/err/4"); die("");}
	
	define("INFINITY", true);
	include_once("../config/settings.php");
	$sql = new SQL();
	$sql->CLEAN = false;
	$sub = $sql->cleanQuery($_POST['subject'], true, true, true);
	$email = $sql->cleanQuery($_POST['email'], true, true, true);
	$msg = $sql->cleanQuery($_POST['msg'], true, true, true);
	
	$res = $sql->query("INSERT INTO infinity_messages (`subject`, `email`, `msg`, `date`, `IP`) VALUES (%s , %s , %s , '".date("Y-m-d H:i:s")."', '". getRealIp() ."')", $sub, $email, $msg);
	if ($res) {
		header("Location: /about/thanks");
		die("");
	} else {
		header("Location: /about/err/5");	
		die("");
	}
} else {
	header("Location: /about/");
	die("");
}


?>