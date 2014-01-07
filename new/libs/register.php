<?php

// [TODO] - rewrite with classes in relax.php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    Header("Location: /");
    die();
}

define("INFINITY", true);
include_once('relax.php');
$cryptinstall="../extra/crypt/cryptographp.fct.php";
include_once $cryptinstall;

if (!System::checkPG("POST", array("reg_usr", "reg_pwd", "reg_pwd2", "reg_email", "reg_code"))){
    $_SESSION['reg_error']="MD";
    header("Location: /member/register/error");
    die();    
}
$member   = Members::getInstance();
$ERRORMSG = array();
$USR      = $_POST['reg_usr'];
$PWD      = $_POST['reg_pwd'];
$PWD2     = $_POST['reg_pwd2'];
$EMAIL    = $_POST['reg_email'];
$CODE      = $_POST['reg_code'];


if ($member->checkDub("username", $USR) != 0) 
    array_push($ERRORMSG, "That username is already taken.");
if (!preg_match('/^[a-zA-Z0-9_-]*$/', $USR)) 
    array_push($ERRORMSG, "That's an invalid username.");
if (strlen($USR) < 4 || strlen($USR) > 16) 
    array_push($ERRORMSG, "The username is to short.");
if ($member->checkDub("email", $EMAIL) != 0) 
    array_push($ERRORMSG, "The email is already used.");
if (strlen($EMAIL) > 50 || strlen($EMAIL) < 6 || !preg_match('/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/', $EMAIL)) 
    array_push($ERRORMSG, "That is not an valid email.");
if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/', $PWD)) 
    array_push($ERRORMSG, "That is not an secure password.");
if (strlen($PWD) < 6 || strlen($PWD) > 25) 
    array_push($ERRORMSG, "The password is to short.");
if ($PWD != $PWD2) 
    array_push($ERRORMSG, "The passwords do not match.");
if (!isset($_POST['reg_terms']))
    array_push($ERRORMSG, "You need to accept the terms.");
if (!chk_crypt($_POST['reg_code']))
    array_push($ERRORMSG, "The captcha code is wrong.");
    
if (count($ERRORMSG) != 0) {
    $_SESSION['reg_error'] = json_encode($ERRORMSG);
    header('Location: /member/register/error');
    die();
} else {
    $bcrypt = new Bcrypt;
    $sql = Database::getInstance();
    $IP = System::getRealIp();
    $acode    = md5("infinity-" . $USR . "-" . $EMAIL . date("Y-m-d H:i:s")); //activation code
    $PASSWORD = $bcrypt->hash($PWD); //password with salt and quadro md5
    $DATE     = date("Y-m-d H:i:s"); // date in mysql format
      
    $res = $sql->Query("INSERT INTO members (`username`, `password`, `email`, `date`, `IP`, `activatecode`) VALUES (?, ?, ?, ?, ?, ?)", $USR, $PASSWORD, $EMAIL, $DATE, $IP, $acode);
    if (!$res) {
        $_SESSION['reg_error']="There was an unexpected error, errorcode:[REG-D1]";
        header('Location: /member/register/error');
        die();
    }
    $prevID = mysql_insert_id();
    $res2 = $sql->Query("INSERT INTO memberinfo (`ID`, `username`) VALUES (?, ?)", $prevID, $USR);
    if (!$res2) {
        $_SESSION['reg_error']="There was an unexpected error, errorcode:[REG-D2]";
        header('Location: /member/register/error');
        die();
    }

    $to = $EMAIL;
    $subject = "Activate your account";
    $message =  "<p>Welcome to Infinity,<br />".
                "To validate your account click <a href =\"http://".$_SERVER['HTTP_HOST']."/member/activate/".$acode."\"> here.</a><br />".
                "If you have any questions or problems please contact us at support@infinity-forum.org<br />".
                "Thank You,<br />".
                "Infinity Staff<br /></p>";
    $from = "donotreply@infinity-forum.org";
    $headers = "From:" . $from . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .="Content-type: text/html; charset=iso-8859-1" . "\r\n";
    
    $suck = mail($to,$subject,$message,$headers); 
    $_SESSION['reg_email'] = $EMAIL;
    $_SESSION['reg_done'] = "YES";
    header('Location: /member/register/done');
}

?>