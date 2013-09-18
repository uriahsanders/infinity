<?php
header('Content-Type: image/jpeg');
if (isset($_GET['id']) && preg_match('/^([0-9a-z]){32}(\.png|\.jpge?|\.gif)$/', $_GET['id'])) {
    $_file = $_GET['id']; 
    if (file_exists('/home2/infiniz7/upload/'.$_file)) {
        echo file_get_contents('/home2/infiniz7/upload/'.$_file);
    } else{
        echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/images/not_found.jpg');
    }
} else echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/images/not_found.jpg');
?>
