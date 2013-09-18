<?php
 include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
 mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
 mysql_select_db(SQL_DB)or die(mysql_error());
 $result = mysql_query("UPDATE status SET status = '0' WHERE id = '".$_SESSION['ID']."'")or die(mysql_error());
 $_SESSION["loggedin"] = "NO";
 $_SESSION["IP"] = 0;
 $_SESSION["data"] = "Infinity";
        if ( isset( $_COOKIE[session_name()] ) )
            setcookie( session_name(), "", time()-3600, "/" );
        if ( isset( $_COOKIE["PHPSESSID"] ) )
            setcookie( session_name(), "", time()-3600, "/" );
        $_SESSION = array();
        session_destroy();
    header('Location: /');
        die();
?>