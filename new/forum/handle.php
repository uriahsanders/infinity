<?php
define("INFINITY", true);
include_once("../libs/relax.php");
$forum = new Forum;
if(isset($_GET['t'])) echo "&emsp;".$forum->listPageNums($_GET['t'], $_GET['pg'])."<br>";
else if(isset($_POST['signal']) && $_POST['signal'] == 'post'){
	$sql = Database::getInstance();
	if(isset($_POST['t'])){
		$sql->query("INSERT INTO `posts` (`msg`, `IP`, `by_`, `parent_ID`, `time_`) VALUES (?, ?, ?, ?, ?)",
		$_POST['body'], System::getRealIp(), $_SESSION['ID'], $_POST['t'], date('Y-m-d H:i:s'));
	}
	else if(isset($_POST['f'])){
		$sql->query("INSERT INTO `topics` (`title`, `msg`, `IP`, `by_`, `parent_ID`, `time_`) VALUES (?, ?, ?, ?, ?, ?)",
		$_POST['subject'], $_POST['body'], System::getRealIp(), $_SESSION['ID'], $_POST['f'], date('Y-m-d H:i:s'));
	}
	return $sql->lastInsertId();
}