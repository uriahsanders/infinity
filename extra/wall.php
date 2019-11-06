<?php
define("INFINITY", true);
include_once("../libs/relax.php");
$wall = Wall::getInstance();
if(isset($_POST['action'])){
	if ($_POST['action'] == "post")
	{
		if (!System::checkPG("post", array("txt","to","pri","child", "type")))
			die("0");
		if ((int)$wall->POST($_POST['txt'], $_POST['to'], $_POST['pri'], $_POST['child'], $_POST['type'] || 0, $_SESSION['ID']) == 1)
		 	echo "OK". $wall->lastID;
	}else if($_POST['action'] == 'delete'){
		if (!System::checkPG("post", array('id')))
			die("0");
	}
}

?>