<?php
include_once('projects.php');
$projects = new Projects();
$member = Members::getInstance();
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
		$member = Members::getInstance();
		return "<a>
        <div class=\"project\">
          <div class=\"lead project-title\">$projectname</div>
          <div class=\"project-img\">
            <br>
            <i class=\"fa fa-star gold\"style=\"font-size:9em\"></i>
          </div>
          <div class=\"project-info\">
            By ".$member->get($creator, 'username')." <br><br>
            $short
          <!--<div class=\"progress\">
            <div class=\"progress-bar progress-bar-success black\" role=\"progressbar\" aria-valuenow=\"85\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 85%;\">
              <span>$popularity Popularity</span>
            </div>
          </div>-->
          </div>
        </div>
      </a>";
	}
	function projectTemplate($id, $projectname, $creator, $date, $popularity, $members, $short, $description, $image, $video){
		return 'project';
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