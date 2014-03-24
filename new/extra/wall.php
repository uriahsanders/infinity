<?php
define("INFINITY", true);
include_once("../libs/relax.php");
$wall = Wall::getInstance();
if (isset($_GET['action']) && $_GET['action'] == "post")
{
	if (!System::checkPG("post", array("txt","to","pri","child")))
		die("0");
	if ((int)$wall->POST($_POST['txt'], $_POST['to'], $_POST['pri'], $_POST['child'], $_POST['type'] || 0) == 1)
	 	echo "OK". $wall->lastID;
}

?>