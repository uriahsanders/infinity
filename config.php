<?php
if (!defined("INFINITY"))
	die("");
/////////////////////////////////
// global variables
/////////////////////////////////
define("PATH", '/var/www/');//str_replace("/","\\",substr($_SERVER["SCRIPT_FILENAME"],0, strripos($_SERVER["SCRIPT_FILENAME"],"/")))."\\"); //full PATH to THE current, Directory...
define("SQL_USR", "root"); // MySQL username
define("SQL_PWD", "--xYzzaFfair-7"); //MySQL password
define("SQL_SERVER", "localhost"); // MySQL Server
define("SQL_DB", "infinity"); // Database
?>