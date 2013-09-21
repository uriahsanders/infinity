<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
if(isset($_POST['status']) && $_POST['status'] != ""){
    if(isset($_SESSION['ID'])){
        $id = $_SESSION['ID'];
    }
    mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
    mysql_select_db(SQL_DB)or die(mysql_error());
    $status = mysql_real_escape_string(htmlspecialchars($_POST['status']));
    if($status != "" && $id != ""){
        if($status == "online") $status = 3;
        else if($status == "away") $status = 2;
        else if($status == "busy") $status = 1;
        else $status = 0;
        $date = date("Y-m-d g:i");
        $check = mysql_query("SELECT * FROM status WHERE `id` = '".$id."'")or die(mysql_error());
        if(mysql_num_rows($check) != 1){
            $update = mysql_query("INSERT INTO status (`id`, `status`, `date`) VALUES ('".$id."', '".$status."', '".$date."')")or die(mysql_error());
            if($update){
                echo "";
            }else{
               MsgBox("Error", "Failed to update your status", 4);
            }
        }else{
            $update = mysql_query("UPDATE status SET `status` = '".$status."', `date` = '".$date."' WHERE `id` = '".$id."'")or die(mysql_error());
            if($update){
                echo "";
            }else{
                 MsgBox("Error", "Failed to update your status", 4);
            }
        }
    }else{
        MsgBox("Error", "Invalid status or id", 4);
    }
}
?>