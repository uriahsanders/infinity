<?php
define("INFINITY",true);
include_once("../libs/relax.php");
$sql = new SQL;
$res = $sql->Query("SELECT text FROM about WHERE `id`=4");	
$txt = mysql_fetch_array($res);
echo $txt['text'];
?>
