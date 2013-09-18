<?php
define("INFINITY", true);
include_once("relax.php");


//http://new2.infinity-forum.org/about/
if (!preg_match("/^http(s)?\:\/\/([a-zA-Z0-9]*)?\.?infinity-forum\.org\/?/", $_SERVER['HTTP_REFERER']))// only allow this file to be accessed from our servers
    header("Location: /"); 

if(!isset($_SESSION['token']) || empty($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] != $_POST['token']) //check token
{
    $_SESSION['login_error'] = "The token did not match, refresh the page and try again";
    header("Location: /login/error");
}
if (!isset($_POST['usr']) || !isset($_POST['pwd']))
{
    $_SESSION['login_error'] = "The data was empty, refresh the page and try again";
    header("Location: /login/error");
}

$member = new member;
$sys = new sys;
$usr = $_POST['usr']; // faster to write $usr
$pwd = $_POST['pwd']; // same lol
$ip  = $sys->getRealIp();

$res = $member->Query("INSERT INTO login_attempts (`IP`,`username`, `date`, `date2`) VALUES (%s, %s, %d, %s)", $ip, $usr, time(), date("Y-m-d H:i:s", time()));

if (!$res)
{
    $_SESSION['login_error'] = "There was an error, please contact suport with errorcode:[LD-1]";
    header("Location: /login/error");
    die();
}

$time = time() - (60 * 20); //20min
$tries = $member->Query("SELECT * FROM login_attempts WHERE (`IP`=%s OR `username`=%s) AND `date` > %d", $ip, $usr, $time);
$nr = mysql_num_rows($tries);

if($nr >= 6) {
    
    
    $_SESSION['login_error'] = "Sorry you have made to many incorrect login attempts.<br/>You are locked out until<br/><div id='tt'></div>\",1); \n var x = new Date(); \n var y = new Date(x.getTime() +(20*60*1000));\n $('#tt').html(y.getHours() + \":\" + y.getMinutes());\n //);";
    header('Location: /login/info');
    die();
}

$bcrypt = new Bcrypt;
$res = $member->Query("SELECT ID, username, password, admin FROM members WHERE username=%s", $usr);

if (!$res)
{
    $_SESSION['login_error'] = "There was an error, please contact suport with errorcode:[LD-2]";
    header("Location: /login/error");
    die();
}

$row = mysql_fetch_row($res);

if ($bcrypt->verify($pwd, $row[2]))
{
    //login was successfull, now we need to set all the data that we are going to use later
    $res2 = @$member->Query("DELETE FROM login_attempts WHERE (`IP`=%s OR `username`=%s) AND `date` > %s", $ip, $usr, $time);
    $_SESSION['IP']     =     $ip; // store the IP to prevent session hijacking
    $_SESSION["UA"]     =     $_SERVER["HTTP_USER_AGENT"]; //lets save the useragent as well in case they spoof IP and forget the UA
    $_SESSION['ID']     =     $row[0]; //save the user ID so we know whos logged on
    $_SESSION['USR']     =     $row[1]; // just so it will be faster to retrieve username without calling a class
    $_SESSION['ADMIN']     =     (($row[3] == "1")?"1":"0");
    header("Location: /lounge/");
    die();
}
else
{
    $_SESSION['login_error'] = "The username and password does not match.<br />You have ".(6-(int)$nr)." tries left.";
    header("Location: /login/error");
    die();
}

?>