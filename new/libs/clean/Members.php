<?php
/**
*	Members interface
*/
interface iMembers {
	public static function getInstance(); //get the instance of self
	public function getUserData($find, $what = "."); //returns the data for the user with ID or username match
	public function userExist($find, $what = "."); //return boolean true if user ID or username exist
}
/**
*	Members class - all ported and rewritten Members function
*
*	@author relax
*/
class Members implements iMembers 
{
	private $_db; //the database instance will lie here
	private static $_instance; //own instance 
	
	private function __construct()
	{
		$this->_db = Database::getInstance(); //get the database instance
	}
	
	
	/**
	*	getInstance - get an instance of self
	*
	*	@access public
	*	@static
	*	@return self::$instance
	*/
	public static function getInstance() //så man kan få instans av kalssen
	{
		if (!(self::$_instance instanceof self)) //kollar om $_instance inte redan är en instans av sig själv
			self::$_instance = new self(); //om den inte redan är det sätter den så att den är det
		return self::$_instance; //returnerar sig själv :P
	}
	
	
	
	/**
	*	getUserData - returns all the user data
	*
	*	@access public
	*	@param integer $find - the ID or username of the user to get data from
	*	@param string $what - NEW specify instead of autodetect email|ID|username
	*	@return boolean|mixed false = no user|mixed = data for user
	*/
	public function getUserData($find, $what = ".")
	{
		try {
			if (preg_match("/^([0-9]+)$/", $find) || $what == "ID")
				$result = $this->_db->query("SELECT * FROM members WHERE `ID`=?", $find); //get all data for user with ID
			else if (preg_match('/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/', $find) || $what == "email")
				$result = $this->_db->query("SELECT * FROM members WHERE `email`=?", $find); //get all data for user with email			
			else if (is_string($find) || $what == "username")
				$result = $this->_db->query("SELECT * FROM members WHERE `username`=?", $find); //get all data for user with username
			else
				System::Error("invalid argument in ". __METHOD__);
				
			if ($result->rowCount() === 0)
				return false; //no matches, return false
			// Also get data from membersInfo
			$first = $result->fetch(PDO::FETCH_BOTH);
			$result2 = $this->_db->query("SELECT * FROM memberinfo WHERE ID=?", $first["ID"]);
			$second = $result2->fetch();
			return array_merge($first, $second); //return all the data
		}
		catch (Exception $e)
		{
			System::Error($e->__toString()); //throw error
		}
	}
	
	/**
	*	userExist - checks if the user exist 
	*
	*	@acess public
	*	@returns boolean
	*	@param string $find - username, email or ID
	*	@param string $what	- specify what $find is username|email|ID
	*/
	public function userExist($find, $what = ".")
	{
		if ($this->getUserData($find, $what) == false)
			return false; //does not exist
		return true; //does exist
	}
	
	/**
	*	checkDub - checks if email or username alread exist
	*
	*	@param string $what - email or username(Default)
	*	@param string value - the value
	*	@access public
	*	@return integer - number of hits, should max be 1
	*/
	/*public function checkDub($what = "username", $value)
	{
		if (strlen($value) <= 0 || strlen($value) >= 60)
			System::Error("Incorrect size on value");
			
		if ($what == "username")
			if ($this->userExist($value))
				return true;
		else 
		{
			$result = $this->_db->query("SELECT * FROM members WHERE `email`=?", $value);
			if ($result->rowCount() !== 0)
				return true;
		}
		return false;
	}*/
	//ex: get($_SESSION['ID'], 'image'); //returns usr image
	public function get($ID, $what){
		return $this->getUserData($ID)[$what];
	}
	public function setUsrData($what, $value){
		$this->_db->query("UPDATE `memberinfo` SET $what = ? WHERE `ID`= ?", $value, $_SESSION['ID']);
	}
	public function getFriends($ID, $a=1)
		{
			$res = $this->_db->query("SELECT * FROM `friends` WHERE `usr_ID` = ? OR `friend_ID` = ?", $ID, $ID);
			if (!$res)
			{
				return 0; //connection error
			}
			$friends = array();
			$friend	 = array();			
			while ($row = $res->fetch())
			{
				if ((int)$row['block'] == 1)
					continue;
				if ((int)$row['accepted'] == 0 && $a==1)
					continue;
				$FriendID = (($row['usr_ID']==$ID)?$row['friend_ID']:$row['usr_ID']);
				$info = $this->getUserData($FriendID);
				$friend = array(
					"ID" => $FriendID,
					"username" => $info['username'],
					"image"	=> $info['image'],
					"a" => $row['accepted'],
					"data" => $info // in case you want more data while we already fetche it
				);
				array_push($friends, $friend);
			}
			return $friends;
		}
		public function isFriends($ID, $a=1) 
		{
			$friends = $this->getFriends($ID, $a);
			foreach($friends as $key=>$value)
			{
				if ($_SESSION['ID']==$value['ID'] && $value['a'] == 1)
					return "y";
				else if ($_SESSION['ID']==$value['ID'] && $value['a'] == 0)
					return "a";
			}
			return "n";
		}
		public function isBlocked($ID)
		{
			$res = $this->_db->query("SELECT * FROM `friends` WHERE (`usr_ID`=? OR `friend_id`=?) AND `block`=1 AND `block_by`=?", $ID, $ID, $_SESSION['ID']);	
			if (!$res)
			{
				return 0; //connection error
			}
			if ($res->rowCount() != 0)
				return true;
			return false;
		}
		public $ranks = array("Banned","Member","Trusted","VIP","MOD","GMOD","Admin");
		public function getUserRank($ID = 0, $type = "name"){ // default is active user and to return the name of the rank.
			if ($ID === 0)
				$ID = $_SESSION['ID'];
			$res = $this->_db->query("SELECT `rank` FROM `memberinfo` WHERE `ID`=?", $ID);
			$row = $res->fetchColumn();
			if ($type === "name")
				return $this->ranks[$row[0]];
			return $row[0];
			
		}
}
