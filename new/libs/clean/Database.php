<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie


////////////////////////////////////////////////////////////////////////
//	Database
////////////////////////////////////////////////////////////////////////
/**
*	Database interface
*/
interface iDatabase {
	public static function getInstance(); //get the instance of Database
	public function query($query); //run the query
	public function lastInsertId(); //get the last inserted ID
}
/**
* Database - singelton databas class
*
* @author relax
* @example $_db = Database::getInstance();
* @see query();
*/
class Database implements iDatabase
{	
	/**
	* Private variables to connect to the database
	* @access private
	*/
    private $SQL_USR = SQL_USR; //username to sql server
    private $SQL_PWD = SQL_PWD; //password
    private $SQL_SERVER = SQL_SERVER; //server
    private $SQL_DB = SQL_DB; //database
	
	private $_db; //connection will lie here
	private static $_instance; //the instance here
	
	//all variables exept this are private
	public $xss_prev = true; //utom denna
	
	/**
	*	Standard __construct.
	*	starting a pdo connection with utf charset (same as mysql server) and
	*	sets emurate attributes toi false to prevent outofcharset sql injections
	*	@access private
	*/
	private function __construct() // private so only 1 connection at a time can be made
	{
		$this->_db = new PDO("mysql:host=$this->SQL_SERVER;dbname=$this->SQL_DB;charset=utf8", $this->SQL_USR, $this->SQL_PWD); //PDO connection
		$this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		//källa http://stackoverflow.com/a/12202218 
	} 
	/**
	*	clone protection (singelton pattern)
	*	@access private
	*/
	private function __clone() {} 
	
	/**
	*	so you can get an instance
	*	@access public
	*	@static
	*	@return mixed - returns self
	*/
	public static function getInstance()
	{
		if (!(self::$_instance instanceof self)) //check if we don't alread have an instance of self
			self::$_instance = new self(); //if not create one, the only one
		return self::$_instance; //return self
	}
	/**
	*	query()
	*
	*	Fast secure query with xss and sql-injection preventation
	*
	*	@access public
	*	@argument bool $xss_rev automaticly sets to true after each run. true = xss preventation, false = xss vurlerable
	*	@param string $query the query
	*	@param mixed $other other parametrar
	*	@return mixed - returns the results
	*
	*	@example query("SELECT * FROM users WHERE username=? AND ID=?", "admin", 1);
	*/
	public function query($query)//own prepered query
	{
		try {
			$res = $this->_db->prepare($query); //starting prepared statement
			if (!$res)
				throw new Exception("wrong with query...");
			$args = func_get_args();  //Get all arguments
			array_shift($args);//hides the $query argument
			if (count($args) >= 1) // one or more?
			{  
				for ($i = 0; $i<count($args); $i++) //loop all others
					$args[$i] = ($this->xss_prev)? htmlspecialchars($args[$i]) : $args[$i]; //xss preventation 
			}
			$res->execute($args);//exec the query later, works both with and without extra arguments
			$this->xss_prev = true; //reset xss preventation to true
			
			return $res; //returns results
		} catch (Exception $e) {
			System::Error($e->getMessage());
		}
	}
	
	/**
	*	lastInsertId - PDO function to get last id
	*	
	*	@access public
	*/
	public function lastInsertId()
	{
		return $this->_db->lastInsertId();
	}
}