<?php
	define("INFINITY", true);
	include_once("relax.php");
	
	// [TODO] - fix file with new classes and functions
	$sql = Database::getInstance();
	$members = Members::getInstance();
	
	if (isset($_GET['change']))
	{
		if (!isset($_POST['code']) || !isset($_POST['rec_f_pwd']) || !isset($_POST['rec_f_pwd2']) || !isset($_POST['token']) || @$_POST['token'] != $_SESSION['token'])
		{
			error("There was a problem with some data, please try again.");	
		}
		if ($_POST['rec_f_pwd'] != $_POST['rec_f_pwd2'])
		{
			error("Passwords does not match");
		}
		else if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/', $_POST['rec_f_pwd'])) 
		{
			error("Password is not secure enough.");
		}
		$res = $sql->query("SELECT code, ID_usr FROM recover WHERE `code`=?", $_POST['code']);
		if (!$res)
		{
			error("There was a problem, try again or contact suport with errorcode:[RCC-1]");
		}
		if ($res->rowCount() !== 1)
		{
			error("There was a problem with the recovery code, please try again");
		}
		$row = mysql_fetch_row($res);
		$ID  = $row[1];
		$bcrype = new Bcrypt;
		$PWD = $bcrype->hash($_POST['rec_f_pwd']);
		$res = $sql->query("UPDATE members SET `password`=? WHERE `ID`=?", $PWD, $ID);
		if (!$res)
		{
			error("There was a problem, try again or contact suport with errorcode:[RCC-2]");
		}
		$res = $sql->query("DELETE FROM recover WHERE `code`=?", $_POST['code']);
		header("Location: /recover/done");
		die();
	}
	
	if (!isset($_POST['rec_usr']) || strlen($_POST['rec_usr']) < 3)
	{
		error("Data missing or to short,<br>try again please.");
	}
	if (preg_match('/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/', $_POST['rec_usr'])) 
	{
		$type= "E";
		$data = $members->getUserData($_POST['rec_usr'], "email");
	}
	else
	{
		$type = "U";
		$data = $members->getUserData($_POST['rec_usr'], "username");
	}	
	if ($data == false) 
	{
		error("That " . (($type == "E")? "email" : "username") . " was not found in our database.");
	}
	//$data 	= $member->getUsrData($ID); // i know we might already have the email but this way we are 100% sure we have it right
	$ID = $data["ID"];
	$email 	= $data['email']; //there we go
	$usr	= $data['username'];
	
	$time	= date("Y-m-d H:m:s");
	$code   = md5(rand().time().$_POST['rec_usr']);
	$IP		= System::getRealIp();
	$res 	= $sql->query("INSERT INTO recover (`ID_usr`, `code`, `IP`, `time`) VALUES (?,?,?,?)", $ID, $code, $IP, $time);
	if (!$res)
	{
		error("There was an error, contact suport with errorcode: [RcD-1]");
	}

	$to = $email;
    $subject =  "Recover your password";
    $message =  "<p>Hi $usr!<br />".
                "To recover your password click <a href =\"http://".$_SERVER['HTTP_HOST']."/recover/code/".$code."\"> here.</a><br />".
                "If you have any questions or problems please contact us at support@infinity-forum.org<br />".
                "Thank You,<br />".
                "Infinity Staff<br /></p>";
    $from = "donotreply@infinity-forum.org";
    $headers = "From:" . $from . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .="Content-type: text/html; charset=iso-8859-1" . "\r\n";
    $suck = mail($to,$subject,$message,$headers); 
	if (!$suck)
	{
		//error("There was an problem sending the mail, contact suport with errorcode: [RcE-1]");
	}
	$hideemail  = strpos($email,"@"); //because of information disclosure we will not show them the full email registered
	$hidelen 	= $hideemail - 3;
	$emailtoshow = substr($email, 0, 1);
	for ($i = 0; $i<=$hidelen;$i++)
		$emailtoshow .= "*";
	$emailtoshow .= substr($email, $hidelen+2);
	 
	$_SESSION['rec_email'] = $emailtoshow;
	if ($email == $_POST['rec_usr'])
		$_SESSION['rec_email'] = $_POST['rec_usr'];

	header("Location: /recover/email");



	function error($msg)
	{
		$_SESSION['rec_error'] = $msg;
		header("Location: /recover/error");
		die();
	}
?>