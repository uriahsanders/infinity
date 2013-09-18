<?php
define("INFINITY", true);
include_once("../libs/relax.php");

if (isset($_POST['fee_l']) && isset($_POST['fee_n']) && isset($_POST['fee_f']) && isset($_POST['fee_a'])) {

	$anon = ((isset($_POST["anon"]))? 1 : 0);
	$comm = ((isset($_POST["comments"]))? $_POST['comments']:"");
	$sql = new SQL();
	if ($anon == 1) { // the user wants to be anonumous let him/her
	
			$insert = $sql->Query("INSERT INTO feedback (`fee_l`,`fee_n`,`fee_f`,`fee_a`,`comments`,`date`) VALUES (%d,%d,%d,%d,%s,%s)",$_POST['fee_l'],$_POST['fee_n'],$_POST['fee_f'],$_POST['fee_a'],$comm, date("Y-m-d h:m:s"));
			if ($insert) 
				header("Location: /feedback/thanks");
			else
				header("Location: /feedback/error");
	
	} else { // logg username, IP, browser etc
			// fix this later so it actually takes username and shit
			$insert = $sql->Query("INSERT INTO feedback (`fee_l`,`fee_n`,`fee_f`,`fee_a`,`comments`,`date`) VALUES (%d,%d,%d,%d,%s,%s)",$_POST['fee_l'],$_POST['fee_n'],$_POST['fee_f'],$_POST['fee_a'],$comm, date("Y-m-d h:m:s"));
			if ($insert) 
				header("Location: /feedback/thanks");
			else
				header("Location: /feedback/error");
	}
	
}



?>