<?php

// -----------------------------------------------
// Cryptographp v1.4
// (c) 2006-2007 Sylvain BRISON 
//
// www.cryptographp.com 
// cryptographp@alphpa.com 
//
// Licence CeCILL modifi�e
// => Voir fichier Licence_CeCILL_V2-fr.txt)
// -----------------------------------------------

//relax.php session_start_secure()
//session_start();
define("INFINITY", true);
include_once("../../libs/relax.php");
System::StartSecureSession();
error_reporting(E_ALL ^ E_NOTICE);
SetCookie("cryptcookietest", "1");
Header("Location: cryptographp.inc.php?cfg=".$_GET['cfg']."&sn=".session_name()."&".SID);
?>
