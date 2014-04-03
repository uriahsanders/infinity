<?php
if (!defined("INFINITY"))
    die('test'); // do not allow direct access to this fie

///////////////////////////////////
//	Includes
///////////////////////////////////

//include config file
include_once($_SERVER['DOCUMENT_ROOT']."/config.php");

//include all classes **(order matters due to reliance)**
require_once("clean/Funcs.php");
require_once("clean/System.php");
require_once("clean/Database.php");
require_once("clean/Action.php");
require_once("clean/Views.php");
require_once("clean/Votes.php");
require_once("clean/Login.php");
require_once("clean/Members.php");
require_once("clean/Upload.php");
require_once("clean/Forum.php");
require_once("clean/Extra.php");
require_once("clean/Projects.php");
require_once("clean/Workspace.php");
require_once("clean/Wall.php");
require_once("clean/Groups.php");
//start a secure session
System::StartSecureSession();