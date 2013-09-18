<?php
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
    if ($_SESSION["loggedin"] != "YES") {
        if (isset($_GET['usr']))
            header('Location: /user/2/'.$_GET['usr']);
        else {
            log_me("loggedin != yes  ");
            header('Location: /index.php?login=3');
        }
        die();
    } else if($_SESSION["IP"] == getRealIp() && $_SESSION["loggedin"] == "YES" && $_SESSION["data"] == $_SERVER["HTTP_USER_AGENT"]) {
                                                    
    } else {
        if ( isset( $_COOKIE[session_name()] ) )
            setcookie( session_name(), "", time()-3600, "/" );
        $_SESSION = array();
        session_destroy();
           log_me("loggedin == yes but rest NO ");
        header('Location: /index.php?login=4');
        die();
    }    
    
    function log_me($where) {
    $con = mysql_connect(SQL_SERVER,SQL_USR,SQL_PWD) or die(mysql_error());
        mysql_select_db(SQL_DB) or die(mysql_error());
        $url = cleanQuery($_SERVER['HTTP_REFERER']);
        $ip = getRealIp();
        $post = cleanQuery(implode(",",$_POST));
        $get = cleanQuery(implode(",",$_get));
        $arra = array();
        foreach($_SESSION as $key => $value) {
                if (is_array($value)){
                    foreach($value as $key2 => $value2)
                        array_push($arra, $key2." = ".$value2);
                }else
                     array_push($arra, $key ." = ".$value);
        }
        $session = cleanQuery(implode(",",$arra));
        $if = cleanQuery($_SESSION["IP"] ."==". getRealIp() ."&&". $_SESSION["loggedin"] ."==". "YES" ."&&". $_SESSION["data"] ."==". $_SERVER["HTTP_USER_AGENT"]);
        mysql_query("INSERT INTO check_auth_debug (`IP`,`post`,`get`,`session`,`if`,`url`) VALUES ('".$ip."','".$post."','".$get."','".$session."','".$if."','".$where.$url."')") or die(mysql_error());
        mysql_close($con); 
    
    
    }
?>