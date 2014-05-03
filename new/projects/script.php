<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
include_once('../libs/relax.php');
$workspace = new Workspace();
$projects = new Projects();
if(isset($_POST['signal'])){
	if(!isset($_POST['token']) || $_POST['token'] != $_SESSION['token']){
		System::logSuspect('Unauthorized token whilst attempting to make a POST request to the workspace.');
	}
	switch($_POST['signal']){

	}
}
else if(isset($_GET['signal'])){
	switch($_GET['signal']){
		case 'showProjects':
			show('pr-thumbnail', $projects->retrieve($_GET['category']));
	}
}
function pr_thumbnail($id, $name, $creator, $date, $short, $desc, $img){
	return '
		<div class="pr-thumbnail">
		<div class="prt-img"></div><div class="prt-name"><span style="font-size:1.2em;font-weight:bold;">'.$name.'</span><br><br> By <a>'.Members::getInstance()->get($creator, 'username').'</a>
		</div> 
		<div class="prt-short">'.$short.'</div>
		<div class="prt-desc">'.$short.'</div>
		</div>
	';
}
function show($what, $res){
		$done = '';
		foreach($res as $attr){
			switch($what){
				case 'pr-thumbnail':
					$done .= pr_thumbnail($attr['ID'], $attr['projectname'], $attr['creator'], $attr['date'], 
						$attr['short'], $attr['description'], $attr['image']);
			}
		}
		if($done == '') $done = '<br><div style="background:url(\'/images/broken_noise.png\');padding:100px;
					border:1px solid #000;width: 60%;margin:auto;font-size:2em">
					There are no projects here yet.
					</div>';
		die($done);
}