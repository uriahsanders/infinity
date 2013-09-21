<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');

$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());
$email = cleanQuery(strtolower($_POST['email']));
$result = mysql_query("SELECT email FROM members WHERE email='" . $email . "'")or die(mysql_error());
$num = mysql_num_rows($result);
$expire = time() + 120; // 2min

if($num == 1){
    $code = md5(rand()+date()+time()+$email);
    $from = "support@infinity-forum.org";
    $subject = "Recover your password";
    $message = "Please follow the following link to recover your password. <a href='http://infinity-forum.org/authentication.php?passkey=".$code."'>Click here to recover your password.</a>";
    $mail = mail($email, $from, $subject, $message);
    if($mail){
    
        $IP = getRealIp();
        $DATE = date("Y-m-d H:i:s"); 
        
        $result = mysql_query("SELECT email FROM recover WHERE email='" . $email . "'")or die(mysql_error());
        $num = mysql_num_rows($result);
        if ($num == 0) {
            mysql_query("INSERT INTO recover (IP,time,code,email) VALUES ('".$IP."', '".$DATE."', '".$code."', '".$email."')") or die(mysql_error());
        } else if ($num == 1) {
            mysql_query("UPDATE recover SET IP='".$IP."',time='".$DATE."',code='".$code."' WHERE email='" . $email . "'") or die(mysql_error());
        } else {
            $ERRORMSG = array();
            array_push($ERRORMSG, "hide");
             setcookie("recem", $email, $expire);
            foreach ($ERRORMSG as $key => $value) {
            setcookie("err[" . $key . "]", $value, $expire);
        }
        header("Location: index.php?status=error");
        }
    
         setcookie("recem", $email, $expire);
        header("Location: index.php?status=recmail");
    }else{
    $ERRORMSG = array();
     array_push($ERRORMSG, "hide3");
     setcookie("recem", $email, $expire);
    foreach ($ERRORMSG as $key => $value) {
        setcookie("err[" . $key . "]", $value, $expire);
    }
    header("Location: index.php?status=error");
    }
}else{
    $ERRORMSG = array();
    array_push($ERRORMSG, "hide");
     setcookie("recem", $email, $expire);
    foreach ($ERRORMSG as $key => $value) {
        setcookie("err[" . $key . "]", $value, $expire);
    }
    header("Location: index.php?status=error");
}
?>