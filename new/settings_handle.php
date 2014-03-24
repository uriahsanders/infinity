<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
include_once('libs/relax.php');
$_db = Database::getInstance();
$member = Members::getInstance();
if(isset($_POST['signal']) && $_POST['signal'] == 'options' && isset($_POST['token']) && $_POST['token'] == $_SESSION['token']){
	$p = $_POST; //shorthand
	$real_pwd = $_db->query("SELECT `password` FROM `members` WHERE `ID` = ?", $_SESSION['ID'])->fetch()['password'];
	$crypt = new Bcrypt();
	if($crypt->verify($p['current-password'], $real_pwd)){
		//updating pwds
		if($p['password'] == $p['verify-password']){
			if(strlen($p['password']) > 2) 
				$_db->query("UPDATE `members` SET `password` = ? WHERE `ID` = ?", $p['password'], $_SESSION['ID']);
		}else{
			die("Your new passwords dont match bro.");
		}
		$_db->query("UPDATE `members` SET `username` = ?, `email` = ? WHERE `ID` = ?",
			$p['username'], $p['email'], $_SESSION['ID']);
		$_db->query("UPDATE `memberinfo` SET `username` = ?, `country` = ?, `age` = ?, `about` = ?, `resume` = ?, `work` = ?, `quote` = ?, `wURL` = ?, `sex` = ? WHERE `ID` = ?",
			$p['username'], $p['country'], $p['age'], $p['about'], $p['resume'], $p['work'], $p['quote'], $p['wURL'], $p['gender'], $_SESSION['ID']);
		$_SESSION['USR'] = $p['username'];
		die("Your stuff was updated.");
	}else{
		echo "Sorry, your password is not correct.";
	}
}