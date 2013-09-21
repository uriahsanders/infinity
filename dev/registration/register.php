<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    Header("Location: ../index.php");
    die();
}
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
$con      = SQL_connect();
$ERRORMSG = array();
$USR      = cleanQuery($_POST['username']);
$NAME     = str_replace("  ", " ", cleanQuery($_POST['name']));
$PWD      = cleanQuery($_POST['password']);
$PWD2     = cleanQuery($_POST['password2']);
$EMAIL    = cleanQuery($_POST['email']);

if (checkDub("username", $USR) == 1) {
    array_push($ERRORMSG, "errusr3");
}
if (!preg_match('/^[a-zA-Z0-9_-]*$/', $USR)) {
    array_push($ERRORMSG, "errusr");
}
if (strlen($USR) < 4 || strlen($USR) > 16) {
    array_push($ERRORMSG, "errusr2");
}

if (!preg_match('/^[\. a-zA-Z0-9_-]*$/', $NAME)) {
    array_push($ERRORMSG, "errname");
}
if (strlen($USR) < 4 || strlen($USR) > 16) {
    array_push($ERRORMSG, "errname2");
}

if (checkDub("email", $EMAIL) == 1) {
    array_push($ERRORMSG, "erremail2");
}
if (strlen($EMAIL) > 50 || strlen($EMAIL) < 6 || !preg_match('/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/', $EMAIL)) {
    array_push($ERRORMSG, "erremail");
}

if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/', $PWD)) {
    array_push($ERRORMSG, "errpwd");
}
if (strlen($PWD) < 6 || strlen($USR) > 16) {
    array_push($ERRORMSG, "errpwd3");
}

if ($PWD != $PWD2) {
    array_push($ERRORMSG, "errpwd2");
}
if (file_get_contents("http://www.opencaptcha.com/validate.php?ans=" . $_POST['code'] . "&img=" . $_POST['img']) == 'pass') {
} else {
    array_push($ERRORMSG, "errcap");
}

if (count($ERRORMSG) != 0) {
    $expire = time() + 60*60*2;
   foreach ($ERRORMSG as $key => $value) {
        setcookie('err['.$key.']', $value, $expire, "/");
   }
    if(strlen(session_id()) < 1)
 {
      // session has NOT been started
      session_start();
 }
 /* print_r($_COOKIE["err"]);/*
    echo ' : ';
    print_r($ERRORMSG);
    die();*/
    setcookie("usr", $USR, $expire, "/");
    setcookie("name", $NAME, $expire, "/");
    setcookie("email", $EMAIL, $expire, "/");
    
    
    /*
    print_r($ERRORMSG); 
    echo ' : ';
    print_r($_COOKIE['err']);
    
    echo ' : '.$ERRORMSG . ' : ';
    
    echo $_COOKIE["err"];
    die();
    */
    header('Location: ../index.php?status=error');
    
} else {
    $IP = getRealIp();
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    $acode    = md5("infinity-" . $USR . "-" . $EMAIL . date("Y-m-d H:i:s")); //activation code
    $PASSWORD = md5(md5("infinity-") . md5($PWD) . md5("-46258")); //password with salt and quadro md5
    $DATE     = date("Y-m-d H:i:s"); // date in mysql format
    
    mysql_query("INSERT INTO members (username,password,email,date,IP,activatecode) VALUES ('" . $USR . "','" . $PASSWORD . "','" . strtolower($EMAIL) . "','" . $DATE . "','" . $IP . "','" . $acode . "')") or die(mysql_error());
    $iii = mysql_insert_id();
    echo $iii;
    mysql_query("INSERT INTO `memberinfo`(`ID`, `username`, `screenname`) VALUES ($iii, '$USR', '$NAME')") or die(mysql_error());

    mysql_close($con);
    

    $to = $EMAIL;
    $subject = "Activate your account";
    $message =  "<p>Welcome to Infinity,<br />".
                "To validate your account click <a href =\"/index.php?status=activate&code=".$acode."\"> here.</a><br />".
                "If you have any questions or problems please contact us at support@infinity-forum.org<br />".
                "Thank You,<br />".
                "Infinity Staff<br /></p>";
    $from = "donotreply@infinity-forum.org";
    $headers = "From:" . $from . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .="Content-type: text/html; charset=iso-8859-1" . "\r\n";
    
    $suck = mail($to,$subject,$message,$headers); 
    
    
    setcookie("email", $EMAIL, time() + 600, "/");
    header('Location: ../index.php?status=done');
    exit();
}
?>