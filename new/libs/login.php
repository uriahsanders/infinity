<?php
define("INFINITY", true);
include_once("relax.php");


//http://new2.infinity-forum.org/about/
//if (!preg_match("/^http(s)?\:\/\/([a-zA-Z0-9]*)?\.?infinity-forum\.org\/?/", $_SERVER['HTTP_REFERER']))// only allow this file to be accessed from our servers
  //  header("Location: /"); 
  
  


		
		
$login = Login::getInstance();

$login->loginUser();

/*			
if(!isset($_SESSION['token']) || empty($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] != $_POST['token']) //check token
{
    $_SESSION['login_error'] = "The token did not match, refresh the page and try again";
    header("Location: /login/error".((!empty($URL))?"/?u=$URL":""));
}
if (!isset($_POST['usr']) || !isset($_POST['pwd']))
{
    $_SESSION['login_error'] = "The data was empty, refresh the page and try again";
    header("Location: /login/error".((!empty($URL))?"/?u=$URL":""));
}

$usr = $_POST['usr']; // faster to write $usr
$pwd = $_POST['pwd']; // same lol
$ip  = System::getRealIp();

$res = $member->Query("INSERT INTO login_attempts (`IP`,`username`, `date`, `date2`) VALUES (%s, %s, %d, %s)", $ip, $usr, time(), date("Y-m-d H:i:s", time()));

if (!$res)
{
    $_SESSION['login_error'] = "There was an error, please contact suport with errorcode:[LD-1]";
    header("Location: /login/error".((!empty($URL))?"/?u=$URL":""));
    die();
}

$time = time() - (60 * 20); //20min
$tries = $member->Query("SELECT * FROM login_attempts WHERE (`IP`=%s OR `username`=%s) AND `date` > %d", $ip, $usr, $time);
$nr = mysql_num_rows($tries);

if($nr >= 6) {
    $_SESSION['login_error'] = "Sorry you have made to many incorrect login attempts.<br/>You are locked out until<br/><div id='tt'></div>\",1); \n var x = new Date(); \n var y = new Date(x.getTime() +(20*60*1000));\n $('#tt').html(y.getHours() + \":\" + y.getMinutes());\n //);";
    header('Location: /login/info'.((!empty($URL))?"/?u=$URL":""));
    die();
}

$bcrypt = new Bcrypt;
$members = Members::getInstance();

//$res = $member->Query("SELECT ID, username, password, admin FROM members WHERE username=%s", $usr);
try {
	$row = $members->getUserData($usr);
} catch (Exception $e) {
    $_SESSION['login_error'] = "There was an error, please contact suport with errorcode:[LD-2]";
    header("Location: /login/error".((!empty($URL))?"/?u=$URL":""));
    die();
}
/*
if (!$res)
{
    $_SESSION['login_error'] = "There was an error, please contact suport with errorcode:[LD-2]";
    header("Location: /login/error".((!empty($URL))?"/?u=$URL":""));
    die();
}

$row = mysql_fetch_array($res);

if ($bcrypt->verify($pwd, $row["password"]))
{
    //login was successfull, now we need to set all the data that we are going to use later
    
	$members->setSessionForUser($row["ID"]); //set the session
	// I will rewrite this whole file to use relax2.php when all functions are implemented
	// but this will do for now to fix the bug on gitbucket.
	
	include_once("status.php"); //set status
	$Status->changeMyStatus("1");
	if (!empty($URL))
	{
		header("Location: ". $URL);//send to right url
		die();
	}
	header("Location: /lounge/");
    die();
}
else
{
    $_SESSION['login_error'] = "The username and password does not match.<br />You have ".(6-(int)$nr)." tries left.";
    header("Location: /login/error" . ((!empty($URL))?"/?u=$URL":""));
    die();
}
*/
?>