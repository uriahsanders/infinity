<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie
//Workspace Data SQL database structure:
//ID | projectID | version | original | type | title | body | date | level | by | to | data | lastUser | branch | suggested | active
class Workspace{
	const LIMIT = 10; //how many results to retrieve
	private $sql;
	private $table = "`workspace_data`";
	public function __construct(){
		$this->sql = Database::getInstance();
	}
	//are they a part of the project?
	public function has_access_to($projectID){
		$members = $this->getMembers($projectID);
		return (array_search($_SESSION['ID'], $members)) ? true : false;
	}
	//lowest required privilege
	public function has_privilege($projectID, $branch, $privilegeNum){
		//privileges are stored in data of type = branch, branch = branch, to = userID, level = privilege
		$result = $this->sql->query("SELECT `level` FROM ".$this->table." 
			WHERE `type` = ? AND `branch` = ? AND `to` = ?", 'privilege', $branch, $_SESSION['ID']);
		return ($privilegeNum >= $result->fetch()['level']) ? true : false; //is privilege equal or better?
	}
	//make sure all REST requests have been made
	public function verify_params($rest, $arr){
		for($i = 0; $i < count($arr); ++$i){
            if(!isset($rest[$arr[$i]])) die();
        }
	}
	private function limit($start){
		return " ORDER BY `date` LIMIT ".$start.", ".self::LIMIT;
	}
	//common phrase
	//private $begin = "SELECT * FROM ".$this->table." WHERE `projectID` = ? AND `branch` = ?";
	private $begin = "SELECT * FROM `workspace_data` WHERE `projectID` = ? AND `branch` = ?";
	//return array from $result
	private function db2arr($result){
		$res = [];
		foreach($result->fetchAll(PDO::FETCH_NAMED) as $row){
			array_push($res, $row);
		}
		return $res;
	}
	public function getBranches($projectID){
		$result = $this->sql->query("SELECT `title` FROM ".$this->table." WHERE `projectID` = ? AND `type` = ?", $projectID, 'branch');
		return $this->arrValues($result, 'title');
	}
	public function getProjects($userID){
		$result = $this->sql->query("SELECT `projects` FROM `memberinfo` WHERE `ID` = ?", $userID);
		return $result->fetchAll();
	}
	public function getMembers($projectID){
		$result = $this->sql->query("SELECT `members` FROM `projects` WHERE `ID` = ?", $projectID);
		return json_decode($result->fetch()['members']);
	}
	//GETS
	public function getApplication($which, $projectID, $branch, $start = 0){
		if($this->has_access_to($projectID)){
			if($which == 'Control'){
				$projects = new Projects();
				return $projects->getOne($projectID);
			}else{
				if($which != 'Suggestions'){
					$type = substr(lcfirst($which), 0, -1); //eg Tasks to task
					$result = $this->sql->query($this->begin." AND `type` = ? AND `suggested` = ?".$this->limit($start),
					 $projectID, $branch, $type, 0);
				}else{
					$result = $this->sql->query($this->begin." AND `suggested` = ?".$this->limit($start),
					 $projectID, $branch, 1);
				}
				return $this->db2arr($result);
			}
		}
	}
	public function getElement($projectID, $branch, $elementID){
		if($this->has_access_to($projectID))
			return $this->db2arr($this->sql->query($this->begin." AND `ID` = ?", $projectID, $branch, $elementID));
	}
	public function search($projectID, $branch, $query, $start = 0){
		if($this->has_access_to($projectID))
			return $this->db2arr($this->sql->query($this->begin." AND `suggested` = ? AND `title` LIKE %?%".$this->limit($start), $projectID, $branch, 0, $query));
	}
	public function load_more($projectID, $branch, $num, $action, $application, $query){
		switch($action){
			case 'application':
				return $this->getApplication($application, $projectID, $branch, $num);
				break;
			case 'searching':
				return $this->search($projectID, $branch,  $query, $num);
				break;
			//later should load more comments from wall if looking at one element
		}
	}
	//POSTS
	private function getReqPrivByType($type, $delete = false){ //get required privilege by type
		if(!$delete && ($type == 'task' || $type == 'event')) return 2; //supervisor
		else if($delete && ($type == 'task' || $type == 'event')) return 3; //manager
		return 1; //member
	}
	public function createElement($projectID, $branch, $type, $title, $body, $level, $to, $data, $suggested){
		//below members can create suggestions so dont check privilege if it is a suggest
		if($this->has_access_to($projectID) && ($suggested == 1 || $this->has_privilege($projectID, $branch, getReqPrivByType($type)))){
			$this->sql->query("INSERT INTO ".$this->table." 
			(`projectID`, `type`, `title`, `body`, `date`, `level`, `by`, `to`, `data`, `branch`, `suggested`, `active`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			", $projectID, $type, $title, $body, date("Y-m-d H:i:s"), $level, $_SESSION['ID'], $to, $data, $branch, $suggested, json_encode([]));
			return $this->sql->lastInsertId(); //return ID of recently created element
		}
	}
	public function createElementVersion($projectID, $branch, $elementID, $version, $type, $title, $body, $level, $to, $data, $suggested){
		if($this->has_access_to($projectID) && ($suggested == 1 || $this->has_privilege($projectID, $branch, getReqPrivByType($type)))){
			$this->sql->query("INSERT INTO ".$this->table." 
			(`projectID`, `type`, `title`, `body`, `date`, `level`, `by`, `to`, `data`, `branch`, `suggested`, `active`, `original`, `version`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			", $projectID, $type, $title, $body, date("Y-m-d H:i:s"), $level, $_SESSION['ID'], $to, $data, $branch, $suggested,
			 json_encode([]), $elementID, ($version + 1));
			return $this->sql->lastInsertId();
		}
	}
	public function updateElement($projectID, $branch, $elementID, $type, $title, $body, $level, $to, $data, $suggested){
		if($this->has_access_to($projectID) && $this->has_privilege($projectID, $branch, getReqPrivByType($type))){
			$this->sql->query("UPDATE ".$this->table." SET `title` = ?, `body` = ?, `level` = ?, `to` = ?, 
				`data` = ?, `lastUser` = ?, `suggested` = ? WHERE `ID` = ?", $title, $body, $level, $to, $data, $_SESSION['ID'], $suggested, $elementID);
		}
	}
	public function isBeingEditedBySession($projectID, $branch, $bool, $elementID){
		if($this->has_access_to($projectID)){
			$result = $this->sql->query("SELECT `active` FROM ".$this->table." 
				WHERE `projectID` = ? AND `branch` = ? AND `ID` = ?", $projectID, $branch, $elementID);
			$editors = json_decode($result->fetch()['active']);
			if($bool) array_push($editors, $_SESSION['ID']);
			else unset($editors[array_search($_SESSION['ID'], $editors)]); //remove from array
			$this->sql->query("UPDATE ".$this->table." SET `active` = ? WHERE `projectID` = ? AND `branch` = ? AND `ID` = ?"
				, $editors, $projectID, $branch, $elementID);
			if($bool) return $editors;
		}
	}
	public function deleteElement($projectID, $branch, $type, $elementID){
		if($this->has_access_to($projectID) && $this->has_privilege($projectID, $branch, getReqPrivByType($type, true)))
			$this->sql->query("DELETE FROM ".$this->table." WHERE `projectID` = ? AND `branch` = ? AND `ID` = ?", $projectID, $branch, $elementID);
	}
	private function arrValues($result, $key){
		$arr = [];
        foreach($result->fetchAll(PDO::FETCH_NAMED) as $row){
			array_push($arr, $row[$key]);
		}
        return $arr;
	}
	private function return_version_array($elementID){ //array of all versions
		$result = $this->sql->query("SELECT `version` FROM ".$this->table." WHERE `original` = ? OR `ID` = ?", $elementID, $elementID);
        return $this->arrValues($result, 'version');
	}
	//make sure versions are in order after deletion
	private function orderElementVersions($elementID){
		$version_array = $this->return_version_array($elementID);
        for($i = 1; $i <= count($version_array); ++$i){
            $this->sql->query("UPDATE ".$this->table." SET `version` = ? WHERE `version` = ? AND `original` = ? OR `ID` = ?"
            	, $i, $version_array[$i - 1], $elementID, $elementID);
        }
	}
	public function deleteElementVersion($projectID, $branch, $type, $elementID){
		if($this->has_access_to($projectID) && $this->has_privilege($projectID, $branch, getReqPrivByType($type, true))){
			$this->deleteElement($projectID, $branch, $type, $elementID);
			$this->orderElementVersions($elementID);
		}
	}
	public function leaveProject($projectID){
		//remove from project members array
		$members = $this->getMembers($projectID);
		unset($members[array_search($_SESSION['ID'], $members)]);
		//now insert members array back into project
		$this->sql->query("UPDATE `projects` SET `members` = ? WHERE `ID` = ?", json_encode($members), $projectID);
		//remove privileges from workspace
		$this->sql->query("DELETE FROM ".$table." WHERE `projectID` = ? AND `type` = ? AND `to` = ?", $projectID, 'privilege', $_SESSION['ID']);
	}
	public function passLead($projectID, $to){
		if($this->has_access_to($projectID) && $this->has_privilege($projectID, 'Master', 5)){ //is creator
			$branches = $this->getBranches($projectID);
			foreach($branches as $value){
				//change session (creator) privilege to admin in all branches
				$this->sql->query("UPDATE ".$table." SET `level` = ? WHERE
				 `level` = ? AND `to` = ? AND `type` = ? AND `branch` = ? AND `projectID` = ?", 
				 4, 5, $_SESSION['ID'], 'privilege', $branches[$value], $projectID);
				//change $to privilege to creator in all branches
				$this->sql->query("UPDATE ".$table." SET `level` = ? WHERE
				 `to` = ? AND `type` = ? AND `branch` = ? AND `projectID` = ?", 
				 5, $to, 'privilege', $branches[$value], $projectID);
			}
		}
	}
	public function deleteProject($projectID){ //and workspace
		if($this->has_access_to($projectID) && $this->has_privilege($projectID, 'Master', 5)){ //is creator
			$this->sql->query("DELETE FROM `projects` WHERE `ID` = ?", $id); //projects data
			$this->sql->query("DELETE FROM ".$table." WHERE `projectID` = ?", $projectID); //workspace data
		}
	}
	public function createBranch($projectID, $title){
		if($this->has_access_to($projectID) && $this->has_privilege($projectID, 'Master', 3)){ //manager
			$this->sql->query("INSERT INTO ".$table." (`projectID`, `type`, `title`, `date`, `by`, `branch`)
				VALUES (?, ?, ?, ?, ?, ?)", $projectID, 'branch', $title, date("Y-m-d H:i:s"), $_SESSION['ID'], $title);
			foreach($this->getMembers($projectID) as $value){
				//add in new privileeges for new branch for each member
				$priv = ($value == $_SESSION['ID'] && $this->has_privilege($projectID, 'Master', 5)) //if creator and this session id
				 ? 5 //then creator in new branch privilege
				 : ($value == $_SESSION['ID'] //else if this is just session id
				 	? 3 //privilege is manager (lowest priv to create branch)
				 	: 0); //else privelege is observer by default
				$this->sql->query("INSERT INTO ".$table." (`projectID`, `type`, `branch`, `to`, `level`)
				VALUES (?, ?, ?, ?, ?, ?)", $projectID, 'privilege', $title, $value, $priv);
			}
		}
	}
	public function updateBranch($projectID, $oldTitle, $newTitle){
		if($this->has_access_to($projectID) && $this->has_privilege($projectID, 'Master', 4)){ //admin
			//update both privileges and branch name
			$this->sql->query("UPDATE ".$table." SET `title` = ? AND `branch` = ? WHERE
			 `projectID` = ? AND `title` = ? AND `type` = ? OR `type` = ?", $newTitle, $newTitle, $projectID, $oldTitle, 'branch', 'privilege');
		}
	}
	public function deleteBranch($projectID, $title){
		if($this->has_access_to($projectID) && $this->has_privilege($projectID, 'Master', 4)){ //admin
			$this->sql->query("DELETE FROM ".$table." WHERE `projectID` = ? AND `branch` = ?", $projectID, $title);
		}
	}
	public function launch($projectID, $bool){ //$bool is 1 or 0
		if($this->has_access_to($projectID) && $this->has_privilege($projectID, 'Master', 4)){ //admin
			$this->sql->query("UPDATE `projects` SET `launched` = ? WHERE `ID` = ?", $bool, $projectID);
		}
	}
	public function changePrivilege($projectID, $branch, $from, $to, $for){
		$req = ($from >= 4) ? 5 : 4; //requires creator to change from admin or creator else requires admin
		if($this->has_access_to($projectID) && $this->has_privilege($projectID, 'Master', $req)){
			$this->sql->query("UPDATE ".$table." SET `level` = ? WHERE 
			`projectID` = ? AND `type` = ? AND `branch` = ? AND `to` = ? AND `level` = ?", $to, $projectID, 'privilege', $branch, $for, $from);
		}
	}
}