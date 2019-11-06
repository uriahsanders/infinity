<?php
	define("INFINITY", true);
	include("relax.php");
	$member = Members::getInstance();
	if(!Login::checkAuth()) 
	{
		die("AD");
	}
	if (isset($_GET['acttion']) && ($_GET['action'] != "accept" || $_GET['action'] != "decline"))
		if (!isset($_GET['token']) || @$_GET['token'] != md5($_SESSION['ID'] . $_SESSION['USR'] . $_GET['ID']))
			die("000");

	if (!isset($_GET['action']) || !preg_match('/^(add|accept|remove|block|unblock|decline)$/',$_GET['action']))
	{
		die("0");	 // action error
	}	
	if (!isset($_GET['ID']) ||!preg_match('/^([0-9]*)$/', $_GET['ID']))
	{
		die("00");//error with ID
	}
	if (!$member->getUserData($_GET['ID']))
	{
		die("2");	// no user with that ID
	}
	if (isset($_GET['action']) && $_GET['action'] == "add")
	{
		$status = $member->Friend($_GET['ID'], "add");
		die("F-".$status);
	}
	else if (isset($_GET['action']) && $_GET['action'] == "accept")
	{
		$status = $member->Friend($_GET['ID'], "accept");
		die("A-".$status);
	}
	else if (isset($_GET['action']) && ($_GET['action'] == "remove" || $_GET['action'] == "decline"))
	{
		$status = $member->Friend($_GET['ID'], "remove");
		die("R-".$status);
	}
	else if (isset($_GET['action']) && $_GET['action'] == "block")
	{
		$status = $member->Friend($_GET['ID'], "block");
		die("B-".$status);
	}
	else if (isset($_GET['action']) && $_GET['action'] == "unblock")
	{
		$status = $member->Friend($_GET['ID'], "unblock");
		die("U-".$status);
	}
	
	
		////////////////////////////////////
		//	error codes
		///////////////
		// 	0: connection error
		//	3: not friends
		//	9: sucessfull
		//	666: you are blocked by the other user
		///////////////
		//	add
		// -1: can't friend yourself
		//	1: already sent a friend request but not accepted
		//	2: already friends
		///////////////
		//	accept
		//	3: no friend request
		///////////////
		//	block
		//	5: nothing to unblock
		///////////////
		//	unblock
		//  4: you do not own this block
		/////////////////////////////////////
?>