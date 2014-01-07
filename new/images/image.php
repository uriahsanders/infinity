<?php
define("INFINITY", true);
include ("../libs/relax.php");

header('Content-Type: image/jpeg');
if (isset($_GET['id']) && preg_match('/^([0-9a-z]){33}$/', $_GET['id'])) {
	$ext = substr($_GET['id'],-1);
	
	switch($ext)
	{
		case "j":
			$ext = ".jpg";
			break;
		case "p":default:
			$ext = ".png";
			break;
	}	
    $_file = substr($_GET['id'],0,32) . $ext;  
	
	//if (file_exists('/home2/infiniz7/upload/'.$_file)) {
        //echo file_get_contents('/home2/infiniz7/upload/'.$_file);
    if (file_exists(PATH.'upload/'.$_file)) {
        echo file_get_contents(PATH.'/upload/'.$_file);
    } else{
        echo file_get_contents(PATH.'images/profile-photo.jpg');
    }
} 
else
{
	echo file_get_contents(PATH.'images/profile-photo.jpg');
}
?>