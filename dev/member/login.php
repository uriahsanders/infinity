<?php
$_SERVER['DOCUMENT_ROOT'] .= '/infinity/dev'; //uriah
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
if(isset($_SESSION['token']) && !empty($_SESSION['token']) /*&& preg_match("/infinity-forum\.org$/", $_SERVER['HTTP_HOST']) && preg_match("/infinity-forum\.org$/", $_SERVER['SERVER_NAME'])*/){
    echo SQL_USR;

        $con = mysql_connect(SQL_SERVER,SQL_USR,SQL_PWD) or die(mysql_error());
        mysql_select_db(SQL_DB) or die(mysql_error());
        $usr = cleanQuery($_POST['usr']);
        $url = $_SERVER['HTTP_REFERER'];
        mysql_query("INSERT INTO login_attempts (`IP`,`username`, `date`, `date2`) VALUES ('".getRealIp()."', '".$usr."', '".time()."', NOW())") or die(mysql_error());
        $time = time() - (60 * 20); //20min
        $tries = mysql_query("SELECT * FROM login_attempts WHERE (`IP`='".getRealIp()."' OR `username`='".$usr."') AND `date` > '$time'") or die(mysql_error());
        
        $nr = mysql_num_rows($tries);
        mysql_close($con);
if($nr >= 6) {
    header('Location: /index.php?login=2');
    die();
} else {
    $code = checklogin($_POST['usr'], $_POST['pwd']);

    switch ($code) {
        case 0: //wrong pwd usr or not match
                header('Location: /index.php?login=0');
                die();
        case 1: //not activated
                header('Location: /index.php?login=1');
                die();
        case 2: //login as standard
                login(2);
                break;
        case 3: //login as admin
                login(3);
                break;
    }
    
    

}
}else{
   header("Location: /index.php");
}


function login($type) {
    $con = SQL_connect(); SQL_selectDB($con);
    mysql_query("DELETE FROM login_attempts WHERE (`IP`='".getRealIp()."' OR `username`='".$usr."') AND `date` > '$time'") or die(mysql_error()); 
    mysql_close($con); 
$_SESSION["IP"] = getRealIp();
$_SESSION["data"] = $_SERVER["HTTP_USER_AGENT"];
$dataa = getUsrInfo($_POST["usr"], $_POST["pwd"]);
$_SESSION["usrdata"] = $dataa;
$_SESSION["ID"] = $dataa['ID'];
$_SESSION["usr"] = $dataa['username'];
$_SESSION["loggedin"] = "YES";
$_SESSION["screenname"] = $dataa['screenname'];
last_login_update($dataa['ID']);
    if($type == 3){
        $_SESSION["admin"] = 1; 
        header('Location: /cms/wall_beta.php');
        die();
    }else{
        $_SESSION["admin"] = 0;
        header('Location: /member/index.php');
        die();
    }

}










?>