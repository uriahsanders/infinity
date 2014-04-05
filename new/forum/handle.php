<?php
define("INFINITY", true);
include_once("../libs/relax.php");
$forum = new Forum;
if(isset($_GET['t'])){
	die("&emsp;".$forum->listPageNums($_GET['t'], $_GET['pg'])."<br>");
}
else if(isset($_POST['signal']) && $_POST['signal'] == 'post'){
	if(isset($_POST['t'])){
		die($forum->post($_POST['body'], $_POST['t']));
	}
	else if(isset($_POST['f'])){
		die($forum->newThread($_POST['subject'], $_POST['body'], $_POST['f']));
	}
}
else if(isset($_POST['signal']) && $_POST['signal'] == 'delete'){
	if(isset($_POST['t'])) $what = 'posts';
	else if(isset($_POST['f'])) $what = 'topics';
	die($forum->delete($_POST['id'], $what));
}
else if(isset($_POST['signal']) && $_POST['signal'] == 'update'){
	if(isset($_POST['t'])){
		die($forum->updatePost($_POST['id'], $_POST['body']));
	}
	else if(isset($_POST['f'])){
		die($forum->updateThread($_POST['id'], $_POST['subject'], $_POST['body']));
	}
}