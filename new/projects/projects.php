<?php
//Projects page
class Projects{
	/*
	Projects Page SQL database structure: ("short" is short description)
	ID | projectname | creator | Date | Popularity | Members | short | description | category | image | video | launched
	Projects Comments SQL database Structure:
	ID | projectID | date | posterID | body
	Workspace Data SQL database structure:
	ID | projectID | type | title | body | date | level | by | data | lastUser | branch
	will require added column to member info: 'projects' containing user's projects
	*/
	const LIMIT = 10; //how many results to retrieve
	private $sql;
	public function __construct(){
		$this->sql = Database::getInstance();
	}
	public function date(){
		return date("Y:m:d"); //temp (we want our date to be consistent)
	}
	private function limit($start){
		return "ORDER BY `date` LIMIT ".$start.", ".self::LIMIT;
	}
	//return array from $result
	private function db2arr($result){
		$res = [];
		foreach($result->fetchAll(PDO::FETCH_NAMED) as $row){
			array_push($res, $row);
		}
		return $res;
	}
	public function numProjects($userID){ //GET
		$result = $this->sql->query("SELECT COUNT(*) FROM `projects` WHERE `creator` = ?", $userID);
		return $result->fetchColumn();
	}
	public function search($key, $start = 0){ //GET
		//retrieve information neccesary for a thumbnail
		$result = $this->sql->query("SELECT (`ID`, `projectname`, `creator`, `date`, `popularity`, `short`, `image`, `launched`) 
			FROM `projects` WHERE `launched` = ? AND `title` LIKE %?% ".$this->limit($start), 1, $key);
		return $this->db2arr($result);
	}
	//get one project
	public function getOne($id){ //GET
		$result = $this->sql->query("SELECT * FROM `projects` WHERE `ID` = ?", $id);
		return $result->fetch();
	}
	//get all projects in category
	public function retrieve($category, $start = 0){ //GET
		//retrieve only information neccesary for a thumbnail
		$result = $this->sql->query("SELECT (`ID`, `projectname`, `creator`, `date`, `popularity`, `short`, `image`, `launched`) 
			FROM `projects` WHERE `launched` = ? AND `category` = ? ".$this->limit($start), 1, $category);
		return $this->db2arr($result);
	}
	//create a new project and a workspace for it
	public function create($projectname, $short, $description, $image, $video){ //POST
		//create project
		$this->sql->query("INSERT INTO `projects` 
			(`projectname`, `creator`, `date`, `popularity`, `short`, `description`, `image`, `video`, `members`, `launched`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
			", $projectname, $_SESSION['ID'], $this->date(), 0, $short, $description, $image, $video, json_encode($_SESSION['ID']), 0);
		$projectID = $this->sql->lastInsertId();
		//create master branch for workspace
		$this->sql->query("INSERT INTO `workspace_data` (`projectID`, `type`, `title`, `date`, `by`, `branch`)
			VALUES (?, ?, ?, ?, ?, ?)", $projectID, 'branch', 'Master', $this->date(), $_SESSION['ID'], 'Master');
		//add privilege to workspace
		$this->sql->query("INSERT INTO `workspace_data` (`projectID`, `type`, `branch`, `to`, `level`)
			VALUES (?, ?, ?, ?, ?, ?)", $projectID, 'privilege', 'Master', $_SESSION['ID'], 5);
	}
	public function update($id, $projectname, $short, $description, $image, $video){ //POST
		$result = $this->sql->query("UPDATE `projects` SET 
			`projectname` = ?, `short` = ?, `description` = ?, `image` = ?, `video` = ?
			WHERE `ID` = ? AND `creator` = ?", $projectname, $short, $description, $image, $video, $id, $_SESSION['ID']);
	}
	public function comment($id, $body){ //POST
		$result = $this->sql->query("INSERT INTO `projects_comments` (`projectID`, `date`, `posterID`, `body`)
			VALUES (?, ?, ?, ?)
			", $id, $this->date(), $_SESSION['ID'], $body);
	}
	//viewing comments for a project
	public function comments($id, $start = 0){ //GET
		$result = $this->sql->query("SELECT * FROM `projects_comments` WHERE `projectID` = ? ".$this->limit($start), $id);
		return $this->db2arr($result);
	}
	//perhaps a bit misleading name. join() either removes or adds a member
	public function join($projectID, $bool, $who = $_SESSION['ID']){ //POST
		//get members from project
		$result = $this->sql->query("SELECT `members` FROM `projects` WHERE `ID` = ?", $projectID);
		//get projects from session info
		$result2 = $this->sql->query("SELECT `projects` FROM `memberinfo` WHERE `ID` = ?", $who);
		//either add user to members or delete from it
		$members = json_decode($result->fetch()['members']);
		$projects = json_decode($result2->fetch()['projects']);
		$key1 = array_search($who, $members);
		$key2 = array_search($projectID, $projects);
		if($key1 >= 0 || $key2 >= 0){ //they are already a member
			if($bool == false){ //they want to leave
				unset($members[$key1]);
				unset($projects[$key2]);
			}
		}else{ //they are not yet a member
			if($bool == true){ //they want to join
				array_push($members, $who);
				array_push($projects, $projectID);
			}
		}
		//now insert members back into project
		$this->sql->query("UPDATE `projects` SET `members` = ? WHERE `ID` = ?", json_encode($members), $projectID);
		//and projects back into memberinfo
		$this->sql->query("UPDATE `memberinfo` SET `projects` = ? WHERE `ID` = ?", json_encode($projects), $who);
		//now create or remove all privileges in the workspace for them based on $bool
	}
	public function load_more($num, $action, $category, $query, $projectID){ //GET
		//$num is the number of current results
		switch($action){
			case 'category':
				return $this->retrieve($category, $num);
				break;
			case 'project':
				return $this->comments($projectID, $num);
				break;
			case 'searching':
				return $this->search($query, $num);
				break;
		}
	}
}