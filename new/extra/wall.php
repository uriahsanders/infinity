<?php
define("INFINITY", true);
include_once("../libs/relax.php");
$wall = new wall;
$sys = new sys;
if (isset($_GET['action']) && $_GET['action'] == "post")
{
	if (!$sys->checkPG("post", array("txt","to","pri","child")))
		die("0");
	if ((int)$wall->POST($_POST['txt'], $_POST['to'], $_POST['pri'], $_POST['child']) == 1)
	 	echo "OK". $wall->lastID;
}

?>