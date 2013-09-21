       <?php
include_once('libs/lib.php');
       
      
if (isset($_GET['status']) && $_GET['status'] == 'error' && isset($_COOKIE['err'])) {
    echo '<script type="text/javascript">$(document).ready(function(){';
    if ($_COOKIE['err'][0] == "hide" || $_COOKIE['err'][0] == "hide2" || $_COOKIE['err'][0] == "hide3") {
        echo '$("#recover").fadeIn(500);';
    //    echo '$("#inputemailforgot").val() == "'.$_COOKIE["recem"].'"';
    } else {
        echo '$("#register").fadeIn(500);';
        echo '$("#inputusername").val("' . $_COOKIE['usr'] . '");$("#inputname").val("' . $_COOKIE['name'] . '");$("#inputemail").val("' . $_COOKIE['email'] . '");';
    }
    foreach ($_COOKIE['err'] as $name => $value) {
        echo '$("#' . $value . '").show();';
    }
    echo '});</script>';
}
    if (isset($_GET["login"]) && $_GET["login"] == "0") {
        MsgBox("Error","Wrong username or password!",5);
    }else if (isset($_GET["login"]) && $_GET["login"] == "1") {
        MsgBox("Error","Sorry this account is not activated!",5);
    }else if (isset($_GET["login"]) && $_GET["login"] == "2") {
        $time = time() + (60*20);
        MsgBox("Error","Sorry you have made to many incorrect attempts!<br />You are locked out for 20min", 5);
    }else if (isset($_GET["login"]) && $_GET["login"] == "3") {
        MsgBox("Error","Sorry you need to be logged in to see this page <br>", 5);
    }else if (isset($_GET["login"]) && $_GET["login"] == "4") {
        MsgBox("Error","Sorry you have been logged out for security reasons <br>", 5);
    }
    
if (isset($_GET["status"]) && $_GET["status"] == "done" && isset($_COOKIE["email"]) ) { // ) {
    MsgBox("Activation","An activation email has been sent to<br />" . $_COOKIE["email"] . "<br />Be sure to check your spam folder", 3);
  // echo '</div>';
} elseif (isset($_GET["status"]) && $_GET["status"] == "recmail" && isset($_COOKIE["recem"])) {
    MsgBox("Activation","An recovery email has been sent to<br />" . $_COOKIE["recem"] . "<br />Be sure to check your spam folder", 3);
} else if (isset($_GET["status"]) && $_GET["status"] == "activate") {
    if (isset($_GET['code']) && strlen($_GET['code']) == 32) {
        include_once('lib.php');
        $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
        mysql_select_db(SQL_DB) or die(mysql_error());
        
        $result = mysql_query("SELECT 'activatecode' FROM members WHERE activatecode='" . cleanQuery($_GET['code']) . "'") or die(mysql_error());
        if (mysql_num_rows($result) == 1) {
            $result = mysql_query("UPDATE members SET activatecode='Y-" . cleanQuery($_GET['code']) . "' WHERE activatecode='" . cleanQuery($_GET['code']) . "'") or die(mysql_error());
            MsgBox("Activation","Your account is now activated", 1);
        } else {
            $result = mysql_query("SELECT 'activatecode' FROM members WHERE activatecode='Y-" . cleanQuery($_GET['code']) . "'") or die(mysql_error());
            if (mysql_num_rows($result) == 1) {
                MsgBox("Activation","Your account is already activated", 3);
            } else {
                MsgBox("Activation","Can't find that activation code", 4);
            }
        }
        mysql_close($con);
    } else {
        MsgBox("Activation","Error with code", 2);
    }
}else if (isset($_GET["status"]) && $_GET["status"] == "recover") {
    if (isset($_GET['recover']) && strlen($_GET['recover']) == 32) {
        $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
        mysql_select_db(SQL_DB) or die(mysql_error());
        
        $result = mysql_query("SELECT code FROM recover WHERE code='" . cleanQuery($_GET['code']) . "'") or die(mysql_error());
        if (mysql_num_rows($result) == 1) {
            MsgBox("Recovery","input form for new passord here");
        } else {
            MsgBox("Recovery","Can't find that recovery code", 2);
        }
        mysql_close($con);
    } else {
        MsgBox("Recovery","Error with code, please contact support");
    }
}
?>