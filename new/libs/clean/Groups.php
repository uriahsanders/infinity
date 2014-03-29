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
	public function searchMembers(){

	}
	public function sendPM(){

	}
	public function viewPMs(){

	}
	public function viewPM(){

	}
	public function createGroup(){

	}
	public function editGroup(){

	}
	public function deleteGroup(){

	}
	//cannot not be deleted without assoc deleted
	public function autoGroup(){

	}
	public function searchGroups(){

	}
}