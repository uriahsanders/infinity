<?php

if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie

////////////////////////////////////////////////////////////////////////
//	Members 
////////////////////////////////////////////////////////////////////////

/**
*	Members interface
*/
interface iMembers {
	public static function getInstance(); //get the instance of self
	public function getUserData($find, $what = "."); //returns the data for the user with ID or username match
	public function userExist($find, $what = "."); //return boolean true if user ID or username exist
	public function getUsrPicture($ID);
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
	*	getUsrPicture - get the picture of the user
	*
	*	@access public
	*	@param mixed $ID - can be username, ID or email
	*	@return string - file name
	*/
	public function getUsrPicture($ID) {
		$data = $this->getUserData($ID);
		return $data['image'];	
	}
}

////////////////////////////////////////////////////////////////////////
//	Members ENDS
////////////////////////////////////////////////////////////////////////


?>