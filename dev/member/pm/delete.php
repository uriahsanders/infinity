<?php
session_start();
require("connection.php");
if(isset($_GET['id'])){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
}else{
    header("Location: inbox.php?status=fail");
}
$username = $_SESSION['usr'];
$result = mysql_query("DELETE FROM messages WHERE `to` LIKE '".$username.",%' AND `id` = '".$id."' OR `to` LIKE '%,".$username."' AND `id` = '".$id."' OR `to` = '".$username."' AND `id` = '".$id."'") or die(mysql_error());
if($result){
    header("Location: inbox.php?status=delete");
}else{
    header("Location: inbox.php?status=fail");
}
?>