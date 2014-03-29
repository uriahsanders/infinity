<?php
//class handles group system, member list, and PM's
class Groups extends Action{
	public function __construct(){
		$this->sql = Database::getInstance();
	}
	const LIMIT = 30;
	//end to query with param to specify which row to start at
	private function limit($start){
		return "ORDER BY `date` LIMIT ".$start.", ".self::LIMIT;
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
	public function sendPM($subject, $body, $from, $to){
		$this->sql->query("INSERT INTO `messages` (`subject`, `body`, `from`, `to`, `date`) VALUES (?, ?, ?, ?, ?)", $subject, $body, $from, $to, date('Y-m-d H:i:s'));
	}
	public function viewPMs($start = 0){
		return $this->sql->query("SELECT `subject`, `from`, `date`, `ID`, `read` FROM `messages` WHERE `to` = ? ".$this->limit($start), $_SESSION['ID']);
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
		return $this->sql->query("SELECT `subject` FROM `messages` WHERE `subject` LIKE %?% ".$this->limit($start), $for);
	}
	public function createGroup($name, $desc){
		$this->sql->query("INSERT INTO `groups` (`name`, `description`, `by`, `date`) VALUES (?, ?, ?, ?)", $name, $desc, $_SESSION['ID'], date('Y-m-d H:i:s'));
		return $this->sql->lastInsertId();
	}
	public function editGroup($ID, $name, $desc){
		$this->sql->query("UPDATE `groups` SET `name` = ?, `description` = ? WHERE `ID` = ?", $name, $desc, $ID);
	}
	public function deleteGroup($ID){
		$this->sql->query("DELETE FROM `groups` WHERE `ID` = ?", $ID);
	}
	//elemID is user id; add them to a group
	public function addToGroup($elemID, $groupID){
		$this->sql->query("INSERT INTO `group_data` (`groupID`, `elemID`) VALUES (?, ?)", $groupID, $elemID);
	}	
	//auto create a group from a project
	//elemID is the ID of the project
	public function autoGroup($name, $desc, $elemID){
		$id = $this->createGroup($name, $desc);
		//go through every member in project and auto add to group
		$members = json_decode($this->sql->query("SELECT `members` FROM `projects` WHERE `ID` = ?", $elemID)->fetch()['members'], true);
		foreach($members as $member){
			$this->addToGroup($member, $id);
		}
	}
	public function searchGroups($start = 0, $for){
		return $this->sql->query("SELECT `name` FROM `groups` WHERE `name` LIKE %?% ".$this->limit($start), $for);
	}
}