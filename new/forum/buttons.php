<?php
define("INFINITY", true);
include_once("../libs/relax.php");
$forum = new Forum;
echo "&emsp;".$forum->listPageNums($_GET['t'], $_GET['pg'])."<br>";