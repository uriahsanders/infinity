<?php
define("INFINITY", true);
include_once("../libs/relax.php");
include_once("../libs/status.php");
$Status->change_status("0"); //offline
$member->logout();
?>