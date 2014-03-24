<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
include_once('../libs/relax.php');
$projects = new Projects();
switch($_SERVER['REQUEST_METHOD']){
	case 'POST':
		if(!$_POST['token'] || $_POST['token'] != $_SESSION['token']) die(); //CSRF defense
		switch($_POST['signal']){
			case 'create':
				die($projects->create($_POST['projectName'], $_POST['category'], $_POST['short'], $_POST['description'], $_POST['image'], $_POST['video']));
			case 'delete':
				die($projects->delete($_POST['id']));
			case 'update':
				die($projects->update($_POST['id'], $_POST['category'], $_POST['projectName'], $_POST['short'], $_POST['description'], $_POST['image'], $_POST['video']));
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
				$res = $projects->getOne($_GET['creator'], $_GET['projectname']);
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
		$member = Members::getInstance();
		$username = $member->get($creator, 'username');
		return "<a>
        <div id=\"$username-$projectname-$id\"class=\"project\">
          <div class=\"lead project-title\">$projectname</div>
          <div class=\"project-img\">
            <br>
            <i class=\"fa fa-star gold\"style=\"font-size:9em\"></i>
          </div>
          <div class=\"project-info\">
            By ".$username." <br><br>
            Created: ".System::timeDiff($date)." <br><br>
            $short
          </div>
        </div>
      </a>";
	}
	function projectTemplate($id, $projectname, $creator, $date, $popularity, $members, $short, $description, $image, $video){
		$member = Members::getInstance();
		$username = $member->get($creator, 'username');
		$members = json_decode($members);
		$memberList = "<br>Members:<br><br>";
		$thisMember = null;
		foreach((array)$members as $value){
			$thisMember = $member->get($value, 'username');
			$memberList .= "<a target=\"_blank\"href=\"/user/$thisMember\">".$thisMember.'</a><br>';
		}
		$work = ($creator == $_SESSION['ID']) ? "<button class=\"pr-btn\">Workspace</button> &emsp; <button class='pr-btn'>Edit</button>" : '';
		return "
			<div style='width:75%;background:url(\"/images/broken_noise.png\");margin:auto;padding:15px;border-radius:5px;text-align:center'>
				<button class='pr-btn'id='pr-discover'>Discover</button>&emsp;<button class='pr-btn'id='pr-posts'>Posts</button>&emsp;
				<button class='pr-btn'id='pr-posts'>Stats</button>&emsp;<button class='pr-btn'id='pr-posts'>Join</button>&emsp;
				$work<br><br>
				<span class='lead'style='font-size: 3em;'>$projectname</span><br><br> by <a target=\"_blank\"href=\"/user/$username\">$username</a><br><br>
				<div style='background:#000;width:80%;height:400px;margin:auto'></div>
				<br><br>
				<div style='padding:10px;border-radius:5px;margin:auto;width:85%;background:url(\"/images/gray_sand.png\");'>$description</div>
			</div>
		";
	}
	function commentTemplate($id, $projectID, $date, $posterID, $body){
		return 'comment';
	}
	//repetition safe function
	function show($what, $res){
		$done = '';
		$i = 0;
		foreach($res as $attr){
			++$i;
			$done .= ($what == 'projects') ?
			thumbnailTemplate($attr['ID'], $attr['projectname'], $attr['creator'], $attr['date'], $attr['popularity'], $attr['short'], $attr['image'])
			:
			commentTemplate($attr['ID'], $attr['projectID'], $attr['date'], $attr['posterID'], $attr['body']);
		}
		if($done == '') $done = '<br>No projects have been created yet.';
		return $done;
	}