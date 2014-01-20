<?php
$projects = new Projects();
switch($_SERVER['REQUEST_METHOD']){
	case 'POST':
		if(!$_POST['token'] || $_POST['token'] != $_SESSION['token']) die(); //CSRF defense
		switch($_POST['signal']){
			case 'create':
				die($projects->create($_POST['projectName'], $_POST['short'], $_POST['description'], $_POST['image'], $_POST['video']));
			case 'delete':
				die($projects->delete($_POST['id']));
			case 'update':
				die($projects->update($_POST['id'], $_POST['projectName'], $_POST['short'], $_POST['description'], $_POST['image'], $_POST['video']));
			case 'comment':
				die($projects->comment($_POST['id'], $_POST['comment']));
			case 'join':
				die($projects->join($_POST['id'], $_POST['bool']));
		}
		die();
	case 'GET':
		switch($_GET['signal']){
			case 'search':
				$res = $projects->search($_GET['query']);
				die(show('projects', $res));
			case 'getOne':
				$res = $projects->getOne($_GET['id']);
				die(projectTemplate($res['ID'], $res['projectname'], $res['creator'], $res['date'], $res['popularity'], $res['members'], $res['short'], $res['description'], $res['image'], $res['video']));
			case 'retrieve':
				$res = $projects->retrieve($_GET['category']);
				die(show('projects', $res));
			case 'comments':
				$res = $projects->comments($_GET['projectID']);
				die(show('comments', $res));
			case 'loadMore':
				$action = $_GET['action'];
				$res = $projects->load_more($_GET['results'], $action, $_GET['category'], $_GET['query'], $_GET['projectID']);
				if($action == 'project'){
					die(show('comments', $res));
				}else if($action == 'searching' || $action == 'category'){
					die(show('projects', $res));
				}
				die();
		}
		die();
}
	//HTML insertion functions
	function thumbnailTemplate($id, $projectname, $creator, $date, $popularity, $short, $image){
		return '';
	}
	function projectTemplate($id, $projectname, $creator, $date, $popularity, $members, $short, $description, $image, $video){
		return '';
	}
	function commentTemplate($id, $projectID, $date, $posterID, $body){
		return '';
	}
	//repetition safe function
	function show($what, $res){
		$done = '';
		foreach($res as $attr){
			$done .= ($what == 'projects') ?
			thumbnailTemplate($attr['ID'], $attr['projectname'], $attr['creator'], $attr['date'], $attr['popularity'], $attr['short'], $attr['image']);
			:
			commentTemplate($attr['ID'], $attr['projectID'], $attr['date'], $attr['posterID'], $attr['body']);
		}
		return $done;
	}