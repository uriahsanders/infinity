<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie
//Projects page
class Projects{
	const LIMIT = 10; //how many results to retrieve
	private $sql; //will hold db instance
	public function __construct(){
		$this->sql = Database::getInstance();
		$this->member = Members::getInstance();
	}
	public function date(){
		return date("Y-m-d H:i:s"); //temp (we want our date to be consistent)
	}

	//end to query with param to specify which row to start at
	private function limit($start){
		return "ORDER BY `date` LIMIT ".$start.", ".self::LIMIT;
	}

	/**
	*	Transform db result to an array
	*	@access private
	*	@return array
	*	@param mixed $result - fetch from db
	*/

	private function db2arr($result){
		$res = [];
		foreach($result->fetchAll(PDO::FETCH_NAMED) as $row){
			array_push($res, $row);
		}
		return $res;
	}

	/**
	*	Return the number of projects user is involved in
	*	@access public
	*	@return int
	*	@param int $userID - ID of user to query for
	*/
	public function numProjects($userID){ //GET
		$result = $this->sql->query("SELECT `projects` FROM `memberinfo` WHERE `ID` = ?", $userID);
		return count(json_decode($result->fetch()['projects'], true));
	}

	/**
	*	Search for projects
	*	@access public
	*	@return array of results
	*	@param string $key - what we are searching for
	*	@param int $start (common) - row to start at
	*/
	public function search($key, $start = 0){ //GET
		//retrieve information neccesary for a thumbnail
		$result = $this->sql->query("SELECT (`ID`, `projectname`, `creator`, `date`, `popularity`, `short`, `image`, `launched`) 
			FROM `projects` WHERE `launched` = ? AND `title` LIKE %?% ".$this->limit($start), 1, $key);
		return $this->db2arr($result);
	}
	
	/**
	*	Get all information from one project alone
	*	@access public
	*	@return array of results
	*	We identify by creator/projectname for sexy URL's. Unique so replaces ID
	*	@param int $creator - ID of project creator
	*	@param string $projectname - name of project
	*/
	public function getOne($creator, $projectname){ //GET
		$result = $this->sql->query("SELECT * FROM `projects` WHERE `projectname` = ? AND `creator` = ?", $projectname, $this->member->get($creator, 'ID'));
		return $result->fetch();
	}
	
	/**
	*	Get all the projects in a category
	*	@access public
	*	@return array of results
	*	@param string $category - category we are retrieving
	*	@param int $start (common) - row to start at
	*/
	public function retrieve($category, $start = 0){ //GET
		//retrieve only information neccesary for a thumbnail
		$query = "SELECT `ID`, `projectname`, `creator`, `date`, `popularity`, `short`, `image`, `launched` 
			FROM `projects` WHERE `launched` = ? ";
		$exec = [1]; //values to execute with
		//handling category sepearately so we can possibly view all projects
		if($category != 'all'){
			$query .= " AND `category` = ? ";
			array_push($category); //add new arg
		}
		$query .= $this->limit($start); //add query end
		$result = $this->sql->query($query, $exec);
		return $this->db2arr($result);
	}
	
	/**
	*	Create a new project, a workspace for it, and insert into memberinfo `projects`
	*	@access public
	*	@return void
	*/
	public function create($projectname, $category, $short, $description, $image, $video){ //POST
		//create project
		//args to execute with so we can better deal with them
		$exec = [$projectname, $category, $_SESSION['ID'], $this->date(), 0, $short, $description, $image, $video];
		doForAllInArray($exec, ['filter']);
		//dont need to filter these
		array_push($exec, json_encode([$_SESSION['ID']]), 1);
		$this->sql->xss_prev = false; //no html entities (&quot;) so we can encode (manual clear XSS)
		$this->sql->query("INSERT INTO `projects` 
			(`projectname`, `category`, `creator`, `date`, `popularity`, `short`, `description`, `image`, `video`, `members`, `launched`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			", $exec);
		//get ID of project
		$projectID = $this->sql->lastInsertId();
		//getting projects from members and putting new project in
		$result = $this->sql->query("SELECT `projects` FROM `memberinfo` WHERE `ID` = ?", $_SESSION['ID']);
		$projects = json_decode($result->fetch()['projects'], true);
		//new array if not already an array
		if(!is_array($projects)) $projects = [];
		array_push($projects, $projectID);
		$this->sql->xss_prev = false;
		$this->sql->query("UPDATE `memberinfo` SET `projects` = ? WHERE `ID` = ?", json_encode($projects), $_SESSION['ID']);
		//create master branch for workspace
		// $this->sql->query("INSERT INTO `workspace_data` (`projectID`, `type`, `title`, `date`, `by`, `branch`)
		// 	VALUES (?, ?, ?, ?, ?, ?)", $projectID, 'branch', 'Master', $this->date(), $_SESSION['ID'], 'Master');
		// //add privilege to workspace
		// $this->sql->query("INSERT INTO `workspace_data` (`projectID`, `type`, `branch`, `to`, `level`)
		// 	VALUES (?, ?, ?, ?, ?, ?)", $projectID, 'privilege', 'Master', $_SESSION['ID'], 5);
	}

	/**
	*	Update project info
	*	@access public
	*	@return void
	*/
	public function update($id, $projectname, $category, $short, $description, $image, $video){ //POST
		$result = $this->sql->query("UPDATE `projects` SET 
			`projectname` = ?, `category` = ?, `short` = ?, `description` = ?, `image` = ?, `video` = ?
			WHERE `ID` = ? AND `creator` = ?", $projectname, $category, $short, $description, $image, $video, $id, $_SESSION['ID']);
	}
	///////////////////////////////MAY BE REMOVED SOON WILL NOT DOCUMENT YET//////////////////////////////////////////////////////////////

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

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	*	Either add or remove a member from project depending on @param $bool
	*	@access public
	*	@return void
	*	@param int $projectID - ID of project to join
	*	@param boolean $bool - true to join, false to leave
	*	@param int $who - ID of member we are "joining"
	*/
	public function join($projectID, $bool, $who){ //POST
		//dont do anything at all if we get an error
		$this->sql->beginTransaction();
		try{
			//get members from project
			$result = $this->sql->query("SELECT `members` FROM `projects` WHERE `ID` = ?", $projectID);
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
			$this->sql->xss_prev = false;
			$this->sql->query("UPDATE `projects` SET `members` = ? WHERE `ID` = ?", json_encode($members), $projectID);
			//and projects back into memberinfo
			$this->sql->xss_prev = false;
			$this->sql->query("UPDATE `memberinfo` SET `projects` = ? WHERE `ID` = ?", json_encode($projects), $who);
			//now create or remove all privileges in the workspace for them based on $bool
			//...to be continued
			$this->sql->commit();
		}catch(Exception $e){
			$this->sql->rollback();
			System::Error($e->getMessage());
		}
	}

	/**
	*	Load more rows based on @param $num and @param action
	*	@access public
	*	@return array of results
	*	@param int $num - row to start at
	*	@param string $action - what are we loading more of?
	*	@param string $category - category for retrieve
	*	@param string $query - query for search
	*/
	public function load_more($num, $action, $category, $query, $projectID){ //GET
		//$num is the number of current results
		switch($action){
			case 'category':
				return $this->retrieve($category, $num);
				break;
			//may be removed
			case 'project':
				return $this->comments($projectID, $num);
				break;
			case 'searching':
				return $this->search($query, $num);
				break;
		}
	}

	/**
	*	Delete a project and all information associated with it
	*	@access public
	*	@param int $projectID - id of project to delete
	*/
	public function delete($projectID){
		//dont do anything at all if we get an error
		$this->sql->beginTransaction();
		try{
			//get all members from project
			$members = json_decode($this->sql->query("SELECT `members` FROM `projects` WHERE `ID` = ?", $projectID)->fetch()['members'], true);
			foreach($members as $member){
				//get all projects from each member
				$projects = json_decode($this->sql->query("SELECT `projects` FROM `memberinfo` WHERE `ID` = ?", $member)->fetch()['projects'], true);
				//remove deleted project from array
				remValueFromArr($projects, $projectID);
				//update members projects
				$this->sql->xss_prev = false;
				$this->sql->query("UPDATE `memberinfo` SET `projects` = ? WHERE `ID` = ?", json_encode($projects), $member);
			}
			//actually delete project
			$this->sql->query("DELETE FROM `projects` WHERE `ID` = ?", $projectID);
			//delete all workspace information for project
			$this->sql->query("DELETE FROM `workspace_data` WHERE `projectID` = ?", $projectID);
			$this->sql->commit();
		}catch(Exception $e){
			$this->sql->rollback();
			System::Error($e->getMessage());
		}
	}
}