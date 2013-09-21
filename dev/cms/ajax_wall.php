<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
    $minchar = 5;
    $maxchar = 2000;
    $table = "wall";
    if(isset($_POST['action']) && $_POST['action'] == "get") {
    ?>
    

    
    
    <?
    }    
    if (isset($_POST['action'])) { 
        $con = mysql_connect(SQL_SERVER,SQL_USR,SQL_PWD) or die(mysql_error());
        mysql_select_db(SQL_DB) or die(mysql_error());
    } else die("error with post data");
    
    if (isset($_POST['action']) && $_POST['action'] == "add" && isset($_POST['txt']) && strlen($_POST['txt']) >= $minchar && strlen($_POST['txt']) <= $maxchar) {
        $txt = cleanQuery($_POST['txt'],true);
        while (preg_match('~<br /><br /><br />~',$txt)) {
            $txt = preg_replace('~<br /><br /><br />~', "<br /><br />", $txt);
        }
        if (substr($txt,-12) == "<br /><br />")
            $txt = substr($txt,0,-12);
        else if (substr($txt,-6) == "<br />")
            $txt = substr($txt,0,-6);
        mysql_query("INSERT INTO $table (`by`, `date`, `txt`, `IP`) VALUES ('".$_SESSION['ID']."', NOW(), '".$txt."', '".getRealIp()."')") or die(mysql_error());
    } else if (isset($_POST['action']) && $_POST['action'] == "del" && isset($_POST['id']) && preg_match("/^([0-9])*$/", $_POST['id'])) {
        $id = cleanQuery($_POST['id']);
        mysql_query("DELETE FROM $table WHERE id='$id' AND `by`='$_SESSION[ID]'") or die(mysql_error());
    } else if (isset($_POST['action']) && $_POST['action'] == "rep" && isset($_POST['txt']) && strlen($_POST['txt']) > $minchar && strlen($_POST['txt']) <= $maxchar && isset($_POST['id']) && preg_match("/^([0-9])*$/", $_POST['id'])) {
        $txt = cleanQuery($_POST['txt'],true);
        $id = cleanQuery($_POST['id']);
        while (preg_match('~<br /><br />~',$txt)) {
            $txt = preg_replace('~<br /><br />~', "<br />", $txt);
        }
        if (substr($txt,-6) == "<br />")
            $txt = substr($txt,0,-6);
        mysql_query("INSERT INTO $table (`by`, `date`, `txt`, `child`, `IP`) VALUES ('".$_SESSION['ID']."', NOW(), '".$txt."', '".$id."', '".getRealIp()."')") or die(mysql_error());
    }

    if (isset($_POST['action']))
        mysql_close($con);    
    else 
        die("error with post data");
?>