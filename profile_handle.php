<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
include_once('libs/relax.php');
//basically just return proper data from db on request from profile page
if(isset($_GET['signal']) && $_GET['signal'] === 'getInfo'){
	$member = Members::getInstance();
	echo $member->get($_GET['username'] == '' ? $_SESSION['ID'] : $_GET['username'], $_GET['what']);
}