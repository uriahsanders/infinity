<?php
if (!defined("INFINITY"))
    die('test'); // do not allow direct access to this fie

///////////////////////////////////
//	Includes
///////////////////////////////////

//include config file
include_once($_SERVER['DOCUMENT_ROOT']."/config.php");

//include all classes
require_once("clean/Database.php");
require_once("clean/Forum.php");
require_once("clean/Login.php");
require_once("clean/Members.php");
require_once("clean/System.php");
require_once("clean/Extra.php");
require_once("clean/Projects.php");
require_once("clean/Workspace.php");
require_once("clean/Wall.php");

//start a secure session
System::StartSecureSession();