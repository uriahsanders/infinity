<?php
session_start();
require("connection.php");
if(isset($_GET['id'])){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
}else{
    header("Location: inbox.php?status=fail");
}
if(empty($_POST['reply'])){
    header("Location: inbox.php?status=view&id=$id&status=empty");
}else{
    $reply = htmlspecialchars(mysql_real_escape_string($_POST['reply']));
    $time = time();
    $date = date("Y/m/d", $time);
    $username = $_SESSION['usr'];
    $isread = "no";
    $result = mysql_query("SELECT * FROM messages WHERE `to` LIKE '".$username.",%' AND `id` = '".$id."' OR `to` LIKE '%,".$username."' AND `id` = '".$id."' OR `to` = '".$username."' AND `id` = '".$id."'") or die(mysql_error());
    while($row = mysql_fetch_assoc($result)){
        $to = $row['sentby'];
        $subject = "Re:" . $row['subject'];
        break;
    }
    $result2 = mysql_query("INSERT INTO messages (`to`, `subject`, `body`, `sentby`, `date`, `isread`) VALUES ('".$to."', '".$subject."', '".$reply."', '".$username."', '".$date."', '".$isread."')") or die(mysql_error());
    if($result2){
        header("Location: inbox.php?status=sent");
    }else{
        header("Location: inbox.php?status=fail");
    }
}
?>