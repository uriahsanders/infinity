<?php
define("INFINITY", true);
include ("../libs/relax.php");

//header('Content-Type: image/jpeg');
if (isset($_GET['id']) && preg_match('/^([0-9a-z]){32}(\.png|\.jpge?|\.gif)$/', $_GET['id'])) {
    //$_file = $_GET['id']; 
	$_ext = substr($_GET['id'],strlen($_GET['id'])-1);
	switch ($_ext)
	{
		case "j":
			$_ext = ".jpg";
			break;
		case "g":
			$_ext = ".gif";
			break;
		case "p":default:
			$_ext = ".png";
			break;
	}
	
	//if (file_exists('/home2/infiniz7/upload/'.$_file)) {
        //echo file_get_contents('/home2/infiniz7/upload/'.$_file);
	
    $_file = substr($_GET['id'],0,strlen($_GET['id'])-1).$_ext;
	echo $_file;
    if (file_exists(PATH.'upload/'.$_file)) {
        echo file_get_contents(PATH.'upload/'.$_filet);
    } else{
        echo file_get_contents(PATH.'images/profile-photo.jpg');
    }
} else echo file_get_contents(PATH.'images/profile-photo.jpg');
?>