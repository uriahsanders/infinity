<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
include_once($_SERVER['DOCUMENT_ROOT']."/profiletop.php"); //DO NOT REMOVE OR CHANGE 
include_once($_SERVER['DOCUMENT_ROOT']."/libs/links.php");

listlinks("Infinity"); // CHANGE TO THE ACTIVE LINK

include_once($_SERVER['DOCUMENT_ROOT']."/libs/middle.php"); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>   
<center><div><a href="/accsummary.php">Summary</a> | <a href="/generalsettings.php">General Settings | <a href="/accsettings.php">Account Settings</a> | <a href="/acclook.php">Look & Layout</a> | <a href="/member/pm/">Mail</a></div></center>  
<br />
<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/member/profile.php");
?>

