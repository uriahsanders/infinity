<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
mysql_connect(SQL_SERVER, SQ_USR, SQL_PWD)or die(mysql_error());
mysql_select_db(SQL_DB);
$email = mysql_real_escape_string(htmlspecialchars($_GET['email']));
$passwordx = mysql_real_escape_string(htmlspecialchars($_POST['password']));
$password2x = mysql_real_escape_string(htmlspecialchars($_POST['password2']));
$password = md5(md5("infinity-") . md5($passwordx) . md5("-46258"));
$password2 = md5(md5("infinity-") . md5($password2x) . md5("-46258"));
if($password == $passowrd2){
    $result = mysql_query("INSERT INTO menmberinfo(password) WHERE email = '".$email."' VALUES('$password')")or die(mysql_error());
    if($result){
        header("Location: index.php");
    }else{
         $ERRORMSG = array();
         array_push($ERRORMSG, "hide");
         $expire = time() + 120; // 2min
        foreach ($ERRORMSG as $key => $value) {
            setcookie("err[" . $key . "]", $value, $expire);
        }
        header("Location: index.php?status=error");
    }
}else{
     $ERRORMSG = array();
     array_push($ERRORMSG, "hide");
     $expire = time() + 120; // 2min
    foreach ($ERRORMSG as $key => $value) {
        setcookie("err[" . $key . "]", $value, $expire);
    }
    header("Location: index.php?status=error");
    
}
?>