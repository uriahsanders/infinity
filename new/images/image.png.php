<?php
define("INFINITY", true);
include ("../libs/relax.php");

header('Content-Type: image/jpeg');
if (isset($_GET['id']) && preg_match('/^([0-9a-z]){32}(\.png|\.jpge?|\.gif)$/', $_GET['id'])) {
    $_file = $_GET['id']; 
    if (file_exists('/home2/infiniz7/upload/'.$_file)) {
        echo file_get_contents('/home2/infiniz7/upload/'.$_file);
    } else{
        echo file_get_contents(PATH.'images/profile-photo.jpg');
    }
} else echo file_get_contents(PATH.'images/profile-photo.jpg');
?>