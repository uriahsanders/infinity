<?php
//class handles group system, member list, and PM's
class Groups extends Action{
	public function __construct(){
		$this->sql = Database::getInstance();
	}
	const LIMIT = 30;
	//end to query with param to specify which row to start at
	private function limit($start){
		return "ORDER BY `date` DESC LIMIT ".$start.", ".self::LIMIT;
	}
	public function listMembers($start = 0){
		$this->sql->query("SELECT * FROM `memberinfo` ".$this->limit($start));
	}
	public function searchMembers($start = 0, $for){
		return $this->sql->query("SELECT `username` FROM `memberinfo` WHERE `username` LIKE %?% ".$this->limit($start), $for);
	}
	//JSON for autocomplete generation
	public function searchJSON($for){
		$result = $this->sql->query("SELECT `username` FROM `memberinfo` WHERE `username` LIKE %?% ORDER BY `username` LIMIT 10", $for);
		$json = [];
		while($member = $result->fetch()){
			$json[] = [
				'value' => $member['username'],
				'label' => $member['username']
			];
		}
		return json_encode($json);
	}
	public function sendPM($subject, $body, $from, $to, $all){
		$this->sql->query("INSERT INTO `messages` (`subject`, `body`, `from`, `to`, `date`, `all`) VALUES (?, ?, ?, ?, ?, ?)", $subject, $body, $from, $to, date('Y-m-d H:i:s'), $all);
	}
	public function viewPMs($start = 0){
		return $this->sql->query("SELECT * FROM `messages` WHERE `to` = ? ".$this->limit($start), $_SESSION['ID']);
	}
	//mark PM as read
	private function PMRead($ID){
		$this->sql->query("UPDATE `messages` SET `read` = ? WHERE `ID` = ?", 1, $ID);
	}
	public function viewPM($ID){
		$this->PMRead($ID);
		return $this->sql->query("SELECT * FROM `messages` WHERE `ID` = ?", $ID);
	}
	public function deletePM($ID){
		$this->sql->query("DELETE FROM `messages` WHERE `ID` = ?", $ID);
	}
	public function searchPMs($start = 0, $for){
		return $this->sql->query("SELECT `subject` FROM `messages` WHERE `subject` LIKE %?% AND `to` = ? OR `by` = ?".$this->limit($start), $for, $_SESSION['ID'], $_SESSION['ID']);
	}
	//$assoc is any id we want to associate this with
	public function createGroup($name, $desc, $assoc = 0){
		$this->sql->query("INSERT INTO `groups` (`name`, `description`, `by`, `date`, `assoc`) VALUES (?, ?, ?, ?, ?)", $name, $desc, $_SESSION['ID'], date('Y-m-d H:i:s'), $assoc);
		return $this->sql->lastInsertId();
	}
	public function editGroup($ID, $name, $desc){
		$this->sql->query("UPDATE `groups` SET `name` = ?, `description` = ? WHERE `ID` = ?", $name, $desc, $ID);
	}
	public function deleteGroup($ID){
		$this->sql->beginTransaction();
		try{
			//delete group
			$this->sql->query("DELETE FROM `groups` WHERE `ID` = ?", $ID);
			//delete all info for group
			$this->sql->query("DELETE FROM `group_data` WHERE `groupID` = ?", $ID);
			$this->sql->commit();
		}catch(Exception $e){
			$this->sql->rollback();
			System::Error($e->getMessage());
		}
	}
	//elemID is user id; add them to a group
	public function addToGroup($elemID, $groupID){
		$this->sql->query("INSERT INTO `group_data` (`groupID`, `elemID`) VALUES (?, ?)", $groupID, $elemID);
	}	
	//auto create a group from a project
	//elemID is the ID of the project
	public function autoGroup($name, $desc, $elemID){
		$id = $this->createGroup($name, $desc, $elemID);
		//go through every member in project and auto add to group
		$members = json_decode($this->sql->query("SELECT `members` FROM `projects` WHERE `ID` = ?", $elemID)->fetch()['members'], true);
		foreach($members as $member){
			$this->addToGroup($member, $id);
		}
	}
	public function searchGroups($start = 0, $for){
		return $this->sql->query("SELECT `name` FROM `groups` WHERE `name` LIKE %?% ".$this->limit($start), $for);
	}
	//get a group id from its associated project id
	public function project2groupID($projectID){
		return $this->sql->query("SELECT `ID` FROM `groups` WHERE `assoc` = ?", $projectID)->fetchColumn();
	}
	//remove a member from a group (remember each client has own set of groups)
	public function removeFromGroup($who, $groupID){
	    $this->sql->query("DELETE FROM `group_data` WHERE `elemID` = ? AND `groupID` = ?", $who, $groupID);
	}
	//view sent PM's
	public function viewSent($start = 0){
	    return $this->sql->query("SELECT * FROM `messages` WHERE `from` = ? ".$this->limit($start), $_SESSION['ID']);
	}
	//get data for a bunch of groups
	public function viewGroups(){
	    return $this->sql->query("SELECT * FROM `groups` WHERE `by` = ?", $_SESSION['ID']);
	}
	//get data for one group
	public function viewGroup($groupID){
	    return $this->sql->query("SELECT * FROM `group_data` WHERE `ID` = ?", $groupID)->fetch();
	}
}