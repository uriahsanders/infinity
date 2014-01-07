<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie
///////////////////////////////////
//	Includes
///////////////////////////////////
//include_once("relax2.php"); //new php patterns, better classes and moved functions. Don't fucking edit this file.
include_once($_SERVER['DOCUMENT_ROOT']."/config.php");


///////////////////////////////////
//	Autostart
///////////////////////////////////
System::StartSecureSession();



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
////////////////////////////////////////////////////////////////////////
//	Database ENDS
////////////////////////////////////////////////////////////////////////



/***********************************************************************************************************************************/



////////////////////////////////////////////////////////////////////////
//	Forum
////////////////////////////////////////////////////////////////////////
/**
*	Forum interface
*/
interface iForum {
	
}
/**
*	Forum class
*	
*	@author relax
*/
class Forum implements iForum 
{
		
}

////////////////////////////////////////////////////////////////////////
//	Forum ENDS
////////////////////////////////////////////////////////////////////////



/***********************************************************************************************************************************/



////////////////////////////////////////////////////////////////////////
//	Login
////////////////////////////////////////////////////////////////////////


/**
*	Login interface
*/
interface iLogin {
	public static function getInstance(); //get the instance of self
	public static function checkAuth($silent = false); //checks if the user is logged in.
	public static function logout($planned = true); //loggs the user out
	public function setSessionForUser($ID); //set the login session for the user
	public function loginUser(); //tries to login a user
		//private function BruteForceProtection($usr); //brute force protection for loginUser
	public function ActivateAccount($code); //activate the user account
	public function RegisterUser($POST); // register a new user.
		//private function registerError($msg); //small function for errors in RegisterUser
		//private function addNewUser($usr, $pwd, $email, $code); the function to add the user to the database
		//private function ValidateRegistration($POST); //function to validate the post data for RegisterUser()
		//private function SendActivationMail($username, $email, $code); //send the activation email
}
/**
*	Login class - login functions
*
*	@author relax
*/
class Login implements iLogin
{
	private static $_instance; //self instance
	private $_Members; //member instance
	private $_db;
	private $Bcrypt;
	
	
	public function __construct()
	{
		$this->_Members = Members::getInstance();
		$this->_db = Database::getInstance();	
		$this->Bcrypt = new Bcrypt;
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
	*	checkAuth - check if user is logged in
	*
	*	@static
	*	@access public
	*	@param boolean $silent - silent check? silent = true does not throw eeror or logout
	*	@return boolean|logout - success|fail
	*/
	public static function checkAuth($silent = false)
	{
		if (
			isset($_SESSION["ID"]) && //check id is set
			isset($_SESSION["USR"]) && //check usr set
			isset($_SESSION["UA"]) && //check UA set
			$_SESSION["UA"] == $_SERVER["HTTP_USER_AGENT"] && //check if useragent match current
			isset($_SESSION["IP"]) && //check IP set
			$_SESSION["IP"] == System::getRealIp() && //check if match current
			isset($_SESSION["logged"]) && //check logged
			(boolean)$_SESSION["logged"] // check logged is true
		)
			return true;//user is logged in
		if ($silent)
			return false;
		self::logout(false);
	}
	
	
	/**
	*	logout - logs the user out
	*	
	*	@access public
	*	@static
	*	@param boolean $planned - planned logout or tried to access restricted? true = planned
	*	@return boolean
	*/
	public static function logout($planned = true)
	{
		$_SESSION = array(); //clear the values
		session_regenerate_id(true); //generate new session id.
		$new_id = session_id(); //save the id for later
		session_unset(); //unset session
		session_destroy(); //destroy the session
		session_id($new_id); //set the session id to new generated
		
		if (!$planned)
		{
			header("Location: /restricted/?u=". $_SERVER['REQUEST_URI']);
			die();                
		}
		header("Location: /");
		die();
	}
	/**
	*	setSessionForUser - set the session data for the logged in user
	*
	*	@final
	*	@access public
	*	@param integer $ID - the user ID to set for
	*	@returns boolean
	*/
	final public function setSessionForUser($ID)
	{
		if (!is_int($ID))
			System::Error("'$ID' is not an int"); //kill with error on wrong $ID
		try {
			$row = self::$_instance->_Members->getUserData($ID);
			if ($row == false) 
			{
				System::Error("No user with that ID found");
				return false;
			}
			
			$_SESSION['IP']     	=    	System::getRealIp(); // store the IP to prevent session hijacking
			$_SESSION["UA"]     	=   	$_SERVER["HTTP_USER_AGENT"]; //lets save the useragent as well in case they spoof IP and forget the UA
			$_SESSION['ID']     	=   	$ID; //save the user ID so we know whos logged on
			$_SESSION['USR']     	=   	$row["username"]; // just so it will be faster to retrieve username without calling a class
			$_SESSION['ADMIN']     	=     	(($row["admin"] == "1")?"1":"0");
			$_SESSION['logged']		=		true;
			return true;
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	/**
	* loginUser - try to login the user
	*
	*/
	public function loginUser()
	{
		if (System::ValidateToken() && System::checkPG("POST", array("usr", "pwd"))) //check token and post data
		{
			$usr = $_POST["usr"]; //lättare att skriva $usr
			$pwd = $_POST["pwd"]; //lättare att skriva $pwd 
			if (isset($_POST["u"]))
				if (!preg_match("/http(s)?:\/\/(.*)/", $_POST["u"])); //check so its not cross domain
					$URL = $_POST["u"];
					
					
			$nr = $this->BruteForceProtection($_POST['usr']);//bruteforce protection
			if(is_int($nr)) 
			{
				$data = $this->_Members->getUserData($usr); //get user data
				if ($data == false) //false no data with that username
				{
					$_SESSION['login_error'] = "The username and password does not match.<br />You have ".(6-(int)$nr)." tries left.";
					header("Location: /login/error" . ((!empty($URL))?"/?u=$URL":""));
					die();
				}
				$match = $this->Bcrypt->verify($pwd, $data["password"]); //check pwd
				if (!$match) //wrong pwd/usr
				{
					$_SESSION['login_error'] = "The username and password does not match.<br />You have ".(6-(int)$nr)." tries left.";
					header("Location: /login/error" . ((!empty($URL))?"/?u=$URL":""));
					die();
				}
				else //if match
				{
					$this->_db->query("DELETE FROM login_attempts WHERE IP=? AND username=?", System::getRealIp(), $usr); // logg the trie
		
					$this->setSessionForUser($data["ID"]); //save session 
					include_once("status.php"); //set status
					$Status->changeMyStatus("1"); //online
					
					if (!empty($URL))
					{
						header("Location: ". $URL);//send to right url
						die();
					}
					header("Location: /lounge/");
					die();
				}
			}
		}
		else
		{
			$_SESSION['login_error'] = "The token did not match, refresh the page and try again";
    		header("Location: /login/error".((!empty($URL))?"/?u=$URL":""));
		}
	}
	
	/**
	* BruteForceProtection - protects the user to bruteforece the password
	* @param string $usr - user trying to login
	* @return integer - nr of tries made in total last $time min
	* @access private
	*/
	private function BruteForceProtection($usr) //brute force protection
	{
		$max_tries = 6; //max tries per...
		$time = time() - (60 * 20); //....20 min
		
		$ip = System::getRealIP(); //user ip
		
		$res = $this->_db->query("INSERT INTO login_attempts (IP, username, date) VALUES (?, ?, ?)", $ip, $usr, time()); // logg the trie
		$tries = $this->_db->query("SELECT * FROM login_attempts WHERE (IP=? OR username=?) AND date > ?", $ip, $usr, $time);//get the last tries with ip and username for the last $time min
		$nr = $tries->rowCount();
		if ($nr >= $max_tries) //check if max tries reached
		{
			$_SESSION['login_error'] = "Sorry you have made to many incorrect login attempts.<br/>You are locked out until<br/><div id='tt'></div>\",1); \n var x = new Date(); \n var y = new Date(x.getTime() +(20*60*1000));\n $('#tt').html(y.getHours() + \":\" + y.getMinutes());\n //);";
			header('Location: /login/info'.((!empty($URL))?"/?u=$URL":""));
			die();
		}
		return $nr; //everything is fine, return tries
	}
	
	
	/**
	*	ActivateAccount - activate the account with code
	*	
	*	@access public
	*	@param string $code - activation code
	*	@return integer - error/success codes
	*
	*/
	public function ActivateAccount($code)
	{
		$res = $this->_db->query("SELECT activatecode FROM members WHERE activatecode LIKE ?", "%".$code);
		if (!$res)
		{
			return 0; // error with connection or something 
		} 
		$row = $res->fetch();
		if(substr($row[0],0,2) == "Y-")
		{
			return 2; // already activated	
		}
		else if ($row[0] == $code)
		{
			$res2 = $this->_db->query("UPDATE members SET activatecode=? WHERE activatecode=?", "Y-".$code, $code);
			if ($res2)
				return 1; //activated
			else
				return 0; //error with connection or something
		}
		return 3; //did not find the code
	}
	
	
	/**
	*	RegisterUser - Register a new user
	*
	*	@access public
	*	@param array $POST - The POST data
	*/
	public function RegisterUser($POST)
	{
		if (!System::checkPG("POST", array("reg_usr", "reg_pwd", "reg_pwd2", "reg_email", "reg_code")) && System::cleanPG("POST", false)) //also cleans from nullbyte attack
			$this->registerError("MD");
			
		$Validate = $this->ValidateRegistration($POST); //Validate all the data
		if ($Validate !== true)
			$this->registerError(json_encode($Validate));
			
		$USR 	= $POST["reg_usr"]; //easier to write like this
		$PWD 	= $POST["reg_pwd"]; //same
		$EMAIL 	= $POST["reg_email"]; //same
		$CODE 	= md5("infinity-" . $USR . "-" . $EMAIL . date("Y-m-d H:i:s")); //activation code
		
		if(!$this->addNewUser($USR, $PWD, $EMAIL, $CODE)) //add a new user
			$this->registerError("There was an unexpected error, errorcode:[REG-D1]");
				
		if(!$this->SendActivationMail($USR, $EMAIL, $CODE))
			$a = 0; //$this->registerError("There was an unexpected error, errorcode:[REG-E1]"); //this will throw on localhost if you dont have a smpt server configured
			
		$_SESSION['reg_email'] = $EMAIL;
		$_SESSION['reg_done'] = "YES";
		header('Location: /member/register/done');
		die();
	}
	/**
	*	registerError - throws error for user
	*
	*	@acecess private {@see RegisterUser()}
	*/
	private function registerError($msg)
	{
		$_SESSION['reg_error']=$msg;
		header('Location: /member/register/error');
		die();
	}
	/**
	*	addNewUser - add a new user to database.
	*
	*	@access private {@see RegisterUser()}
	*	@param string $usr, $pwd, $email, $code - data for the new user, $code = activation code from RegisterUser
	*	@return boolean
	*/
	private function addNewUser($usr, $pwd, $email, $code)
	{
		$IP = System::getRealIp();
		$PASSWORD = $this->Bcrypt->hash($pwd); //password with salt and quadro md5
		$DATE     = date("Y-m-d H:i:s"); // date in mysql format
		  
		  
		// [TODO] write a error handeler in Database class and check if theres a way to insert to both talbes at the same time wit same ID.
		$res = $this->_db->query("INSERT INTO members (`username`, `password`, `email`, `date`, `IP`, `activatecode`) VALUES (?, ?, ?, ?, ?, ?)", $usr, $PASSWORD, $email, $DATE, $IP, $code);
		if (!$res)
			return false; //error with insert
		$prevID = $this->_db->lastInsertId();
		//var_dump($prevID);
		//die();
		$res2 = $this->_db->query("INSERT INTO memberinfo (`ID`, `username`) VALUES (?, ?)", $prevID, $usr);
		if (!$res2)
			return false; //error with insert
		return true;		
	}
	
	/**
	*	ValidateRegistration - validates all the data for registration
	*
	*	@access private {@see RegisterUser()}
	*	@returns mixed - Array if validation fails, boolean if validation is successfull
	*/
	private function ValidateRegistration($POST)
	{
		$ERRORMSG = array();
		//Username 
		$USR     	=	$POST['reg_usr'];
		$USR_PAT 	= 	"/^[a-zA-Z0-9_-]*$/";
		$USR_MAX 	= 	16;
		$USR_MIN 	= 	4;
		//Email
		$EMAIL		=	$POST["reg_email"];
		$EMAIL_PAT	=	"/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/";
		$EMAIL_MAX	=	50;
		$EMAIL_MIN	=	6;
		//Password
		$PWD		=	$POST["reg_pwd"];
		$PWD2		=	$POST["reg_pwd2"];
		$PWD_PAT	=	"/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/";
		$PWD_MIN	=	6;
		$PWD_MAX	=	25;
		// Validate Username
		if ($this->_Members->userExist($USR, "username")) 
				array_push($ERRORMSG, "That username is already taken.");
		if (!preg_match($USR_PAT, $USR)) 
				array_push($ERRORMSG, "That's an invalid username.");
		if (strlen($USR) < $USR_MIN || strlen($USR) > $USR_MAX) 
				array_push($ERRORMSG, "The username is to short or long");
			
		// Validate Email
		if ($this->_Members->userExist($EMAIL, "email")) 
				array_push($ERRORMSG, "The email is already used.");
		if (strlen($EMAIL) > $EMAIL_MAX || strlen($EMAIL) < $EMAIL_MIN || !preg_match($EMAIL_PAT, $EMAIL)) 
				array_push($ERRORMSG, "That is not an valid email.");
		
		// Validate Password
		if (!preg_match($PWD_PAT, $PWD)) 
				array_push($ERRORMSG, "That is not an secure password.");
		if (strlen($PWD) < $PWD_MIN || strlen($PWD) > $PWD_MAX) 
				array_push($ERRORMSG, "The password is to short or long.");
		if ($PWD != $PWD2) 
				array_push($ERRORMSG, "The passwords do not match.");
		
		//Validate Terms of agrement
		if (!isset($POST['reg_terms']))
				array_push($ERRORMSG, "You need to accept the terms.");
		//Validate Captcha code
		if (!chk_crypt($_POST['reg_code']))
				array_push($ERRORMSG, "The captcha code is wrong.");
		
		if (count($ERRORMSG) != 0)
			return $ERRORMSG;
		return true;
	}
	
	/**
	*	SebdActivationMail - send the activation mail to the user
	*
	*	@access private
	*	@param string $username, $email, $code - info to send the mail
	*	@return boolean
	*/
	private function SendActivationMail($username, $email, $code)
	{
		$subject = "Activate your account";
		$message =  "<p>Welcome to Infinity,<br />".
					"To validate your account click <a href =\"http://".$_SERVER['HTTP_HOST']."/member/activate/".$code."\"> here.</a><br />".
					"If you have any questions or problems please contact us at support@infinity-forum.org<br />".
					"Thank You,<br />".
					"Infinity Staff<br /></p>";
		$from = "donotreply@infinity-forum.org";
		$headers = "From:" . $from . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .="Content-type: text/html; charset=iso-8859-1" . "\r\n";
		
		$suck = mail($email,$subject,$message,$headers);
		if (!$suck)
			return false;
		return true;
	}
}
////////////////////////////////////////////////////////////////////////
//	Login ENDS
////////////////////////////////////////////////////////////////////////



/***********************************************************************************************************************************/



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
	*	checkDub - checks if email or username alread exist
	*
	*	@param string $what - email or username(Default)
	*	@param string value - the value
	*	@access public
	*	@return integer - number of hits, should max be 1
	*/
	public function checkDub($what = "username", $value)
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



/***********************************************************************************************************************************/



////////////////////////////////////////////////////////////////////////
//	System
////////////////////////////////////////////////////////////////////////
interface iSystem {
	public static function listLinks($page, $path = ""); //list the links
	public static function Error ($msg, $die = true, $logg = false); //our intern error handler
	public static function getRealIp(); //get the IP
	public static function checkPG ($type = "GET", $array); //check if global variables GET or POST is set from array
	public static function ValidateToken(); //validate CSRF token
	public static function StartSecureSession(); //start a secure session
	public static function cleanPG($type = "GET", $xss = true); //clean post/get variables from null-byte and xss for data not storing in database (thats auto in Database::query)
}
/**
*	System class
*
*	@author relax
*/
class System
{
	public static function listLinks($page, $path = "")
	{
		$links = array( //all links that we will have at the top
			"/" => "Start",
			"/member/"=>"",
			"/projects/" => "Projects",
			"/forum/" => "Forum",
			"/about/" => "About",
			"/infinity/" => "Infinity",
			"/help/" => "Help"
		);
		if (Login::checkAuth(true)) // if loggedin show the lounge link as well
			$links["/member/"] = "Lounge";               
	  
		foreach ($links as $k => &$n) {
			if ($n != "") { // only if name is not empty like member is as default
				echo '<a href="'. $path . $k . '"'; //path and key, path in case you need to change it, this should really not be nessesary
				if (strtolower($n) == strtolower($page)) { // lower caps check in case developer typed other then I in the array
					echo ' active'; // set it active 
				}
				echo '>' . $n . '</a> '; // end this
			}
		}
	}
	
	/**
	*	Error - print and logg errors
	*
	*	@param string $msg - message to log/print
	*	@param boolean $die -  default true
	*	@param boolean $logg - default false
	*	@static
	*	@access public
	*
	*	This is just a placeholder for later development of this function.
	*/
	public static function Error ($msg, $die = true, $logg = false)
	{
		if ($die)
			die($msg);		
		echo $msg;
	}
	
	
	/**
	*	getRealIp() - returns the users real IP-adress
	*
	*	@access public
	*	@static
	*	@return string - The IP adress
	*/
	public static function getRealIp() {
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
						return $ip;
					}
				}
			}
		}
	}
	
	/**
	* checkPG() - looping POST or GET to check if data is set
	* @param string $type - type POST or GET
	* @param array $array - variables to check
	* @static
	* @return boolean
	*/
	public static function checkPG ($type = "GET", $array){
		if (!is_array($array)) //check if array
			return false; //not array
		foreach($array as $value)//loop all in array
			if (((strtoupper($type) == "GET")? !isset($_GET[$value]) : !isset($_POST[$value]))) //check isset on post or get
				return false; // isset = false
		return true; //success
	}
	
	/**
	* ValidateToken - validate CSRF token
	*
	* @access public
	* @return boolean
	*/
	public static function ValidateToken() //validera csrf token
	{
		if (isset($_POST["token"]) && $_POST["token"] == $_SESSION["token"]) //check match
			return true; //match
		return false; //not match
	}
	/**
	*	StartSecureSession - Start a secure 2 weeks http_only session
	*
	*	@access public
	*	@static
	*	@final
	*/
	final public static function StartSecureSession() //starting a secure session
	{
		if (session_status() != PHP_SESSION_ACTIVE) //check if there is one atm
		{
			$cookie_name = "infinity";
			$time = time() + 12096000; //2 weeks
			
			if (isset($_COOKIE[$cookie_name]) && !preg_match('/^[a-z0-9-,]{22,40}$/i', $_COOKIE[$cookie_name]))//check session ID so its not manipullated
					unset($_COOKIE[$cookie_name]); //removing cookie, incorrect
			
			$currentCookieParams = session_get_cookie_params(); // getting active session parameters
			
			session_set_cookie_params(  //putting a new secure cookie
				$time,  //this is somehow not working, therefore setcookie at the bottom
				$currentCookieParams["path"],  
				$currentCookieParams["domain"],  
				$currentCookieParams["secure"],  
				true //http_only
			); 
			session_name('infinity'); 
			session_start(); //starting session
			session_regenerate_id(true); //regenerate ID to prevent hijacking
			
			setcookie($cookie_name, //set the current cookie again(to get the time and http_only right) [TODO]
				session_id(), 
				$time,
				$currentCookieParams["path"],
				$currentCookieParams["domain"],
				$currentCookieParams["secure"],
				true
			);
		}
	}
	
	
	/**
	* 	cleanPG() - clear POST/GET data from null-byte attack and xss (optional before output)
	*
	*	@access public
	*	@static
	*	@param string $type - GET or POST
	*	@param string $xss	- clean from xss tries aswell? Default=true
	* 	@return boolean|array - false=found null-byte else array with clean
	*/
	public static function cleanPG($type = "GET", $xss = true)
	{
		$data = array(); // our clean data
		foreach( ((strtoupper($type) == "GET") ? $_GET : $_POST) as $key => $value) //check if get or post
		{	
			if (strpos($value, chr(0))) //check for null-byte
				return false; //null byte found
			if ($xss)
				$data[$key] = htmlspecialchars($value); //clean from xss
		}
		return $data; //return clean array.
	}
}
////////////////////////////////////////////////////////////////////////
//	System ENDS
////////////////////////////////////////////////////////////////////////



/***********************************************************************************************************************************/



////////////////////////////////////////////////////////////////////////
//	Other Functions and classes
////////////////////////////////////////////////////////////////////////

/**
*	Bcrypt - password hashing class
*
*	@url http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php/6337021#6337021
*	@author Andrew Moore, Robert Kosek
*/
class Bcrypt {
  private $rounds;
  private $prefix;
  public function __construct($prefix = '', $rounds = 12) {
    if(CRYPT_BLOWFISH != 1) {
      throw new Exception("bcrypt not supported in this installation. See http://php.net/crypt");
    }
    $this->rounds = $rounds;
    $this->prefix = $prefix;
  }
  /**
  *	hash - hash the clear text password
  *	
  *	@access public
  *	@param string $input - the password to hash
  *	@return string - the hashed password
  *
  */
  public function hash($input) {
    $hash = crypt($input, $this->getSalt());
    if(strlen($hash) > 13)
      return $hash;
    return false;
  }
  
  
  /**
  *	verify - veryfy a cleartext password with an existing hash
  *	
  *	@access public
  *	@param string $input - the cleartext password to check if same as existing hash
  *	@param string $existingHash - the existing hash to compare with
  *	@return boolean - true = match
  *
  */
  public function verify($input, $existingHash) {
    $hash = crypt($input, $existingHash);
    return $hash === $existingHash;
  }
  
  
  private function getSalt() {
    // the base64 function uses +'s and ending ='s; translate the first, and cut out the latter
    return sprintf('$2a$%02d$%s', $this->rounds, substr(strtr(base64_encode($this->getBytes()), '+', '.'), 0, 22));
  }
  private function getBytes() {
    $bytes = '';
    if(function_exists('openssl_random_pseudo_bytes') &&
        (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')) { // OpenSSL slow on Win
      $bytes = openssl_random_pseudo_bytes(18);
    }
    if($bytes === '' && is_readable('/dev/urandom') &&
       ($hRand = @fopen('/dev/urandom', 'rb')) !== FALSE) {
      $bytes = fread($hRand, 18);
      fclose($hRand);
    }
    if($bytes === '') {
      $key = uniqid($this->prefix, true); 
      // 12 rounds of HMAC must be reproduced / created verbatim, no known shortcuts.
      // Changed the hash algorithm from salsa20, which has been removed from PHP 5.4.
      for($i = 0; $i < 12; $i++) {
        $bytes = hash_hmac('snefru256', microtime() . $bytes, $key, true);
        usleep(10);
      }
    }
    return $bytes;
  }
}



////////////////////////////////////////////////////////////////////////
//	Other Functions and classes ENDS
////////////////////////////////////////////////////////////////////////











































































/*
///////////////////////////////////
//	Global variables
///////////////////////////////////


///////////////////////////////////
// function for the link
///////////////////////////////////
function listlinks($page, $path = "")
{
    $links = array( //all links that we will have at the top
        "/" => "Start",
        "/member/"=>"",
        "/projects/" => "Projects",
        "/forum/" => "Forum",
        "/about/" => "About",
        "/infinity/" => "Infinity",
        "/help/" => "Help"
    );
    if (isset($_SESSION["loggedin"] ) && $_SESSION["loggedin"]  == "YES") // if loggedin show the lounge link as well
        $links["/member/"] = "Lounge";               
  
    foreach ($links as $k => &$n) {
        if ($n != "") { // only if name is not empty like member is as default
            echo '<a href="'. $path . $k . '"'; //path and key, path in case you need to change it, this should really not be nessesary
            if (strtolower($n) == strtolower($page)) { // lower caps check in case developer typed other then I in the array
                echo ' active'; // set it active 
            }
            echo '>' . $n . '</a> '; // end this
        }
    }
}
function session_start_secure() //starting a secure session
{
	if (session_status() != PHP_SESSION_ACTIVE) //check if there is one atm
	{
		$cookie_name = "infinity";
		$time = time() + 12096000; //2 weeks
		
		if (isset($_COOKIE[$cookie_name]) && !preg_match('/^[a-z0-9-,]{22,40}$/i', $_COOKIE[$cookie_name]))//check session ID so its not manipullated
				unset($_COOKIE[$cookie_name]); //removing cookie, incorrect
		
		$currentCookieParams = session_get_cookie_params(); // getting active session parameters
		
		session_set_cookie_params(  //putting a new secure cookie
			$time,  //this is somehow not working, therefore setcookie at the bottom
			$currentCookieParams["path"],  
			$currentCookieParams["domain"],  
			$currentCookieParams["secure"],  
			true //http_only
		); 
		session_name('infinity'); 
		session_start(); //starting session
		session_regenerate_id(true); //regenerate ID to prevent hijacking
		
		setcookie($cookie_name, //set the current cookie again(to get the time and http_only right) [TODO]
			session_id(), 
			$time,
			$currentCookieParams["path"],
			$currentCookieParams["domain"],
			$currentCookieParams["secure"],
			true
		);
	}
}



///////////////////////////////////////////
//  SQL with cleanQuery
///////////////////////////////////////////

function _PDO()
{
	return new PDO("mysql:host=".SQL_SERVER.";dbname=".SQL_DB, SQL_USR, SQL_PWD);		
}


/**
*	SQL
*	@depriciated
*	@see Database - Database singelton class in relax2.php
*/
/*
class SQL{ 
    private $SQL_USR = SQL_USR; //username to sql server
    private $SQL_PWD = SQL_PWD; //password
    private $SQL_SERVER = SQL_SERVER; //server
    private $SQL_DB = SQL_DB; //database
    public $CON;  //the connection will be here
    public $RESULTS; //results if you need em again
	private $die_on_error = true; //kill on error, should ALWAYS be true
	public $CLEAN = true;
	//private $errors = false; //production mode
	private $errors = true; //developing mode
	
    function __construct() // at init
	{ 
        $this->CON = @mysql_connect($this->SQL_SERVER, $this->SQL_USR, $this->SQL_PWD) or (($this->die_on_error)? die((($this->errors)?mysql_error():"")) :""); //create connection
        mysql_select_db($this->SQL_DB, $this->CON) or (($this->die_on_error)? die((($this->errors)?mysql_error():"")) :""); //select db
    }
	
    function Query($query)  //the query, will trow error if empty
	{
        $args = func_get_args();  // get all the arguments from the call
        if (count($args) > 1) // check if its a query with our without parameters
		{  
			array_shift($args);//shift to hide the first argument (the query)
			for ($i = 0; $i < count($args); $i++) //loop all arguments
			{ 
				if (!$this->CLEAN) // if clean is off
					$args[$i] = $args[$i]; // same
				else
					$args[$i] = $this->cleanQuery($args[$i]); //clean the arguments one by one

			}
			foreach($args as $key=>$value) //do an extra check if int, float or string
				$args[$key] = ((preg_match('/^([0-9]*)$/',$value) || is_int($value))?intval($value):((preg_match('/^([0-9]*)\.([0-9]*)$/',$value) || is_float($value))?floatval($value) : "'".$value."'"));  
			$query = call_user_func_array('sprintf', array_merge((array)$query, $args)); //merge the arguments with the query
        }
		$this->RESULTS = @mysql_query($query) or (($this->die_on_error)? die((($this->errors)?mysql_error():"")) :"");  // execute the done query 
        return $this->RESULTS; //return the results
    }
    function cleanQuery($string, $xss = true, $br = false, $br2 = false) { //if you clean by yourseld call with this parameters
	    $string = ($xss === true) ? htmlspecialchars($string) : $string; // XSS preventation, SHOULD ALWAYS BE ON, ask relax about situations where you can turn this off
        $string = ($br != false) ? str_replace("\n","<br />",$string) : $string; // replace new lines to BR, used in WALL and FORUM
        $string = (phpversion() >= '4.3.0') ? mysql_real_escape_string($string) : mysql_escape_string($string); // sql injection preventation, you can't turn this off
  
        if ($br2 != false) { // to stripp multiple br
            while (preg_match('~<br /><br /><br />~',$string)) { $string = preg_replace('~<br /><br /><br />~', "<br /><br />", $string); } //replace 3br to 2br
            if (substr($string,-12) == "<br /><br />") $string = substr($string,0,-12); else if (substr($string,-6) == "<br />") $string = substr($string,0,-6); //remove br from the end
        }
        return $string; //return
    }
	function __destruct() {
       @mysql_close($this->CON); //kill connection when destroyed
   }
}

////////////////////////////////////////////////
//	Member class to use for all info functions
////////////////////////////////////////////////
/*class member extends SQL{
	public $ranks = array("Banned","Member","Trusted","VIP","MOD","GMOD","Admin"); //this will be changed from values from the database....

		function UpdateRanks() { // cant have __construct() because that will apperantly break the SQL __construct() :/
			$ran = $this->Query("SELECT * FROM ranks"); //fix the ranks from db...
			$this->ranks = array();
			while ($row = mysql_fetch_array($ran))
			{
				array_push($this->ranks,  $row["name"]);	//pusch all the ranks into the array
			}
		}
		
		function checkDub($what, $value) //check if email or username already exists in database
		{
			if ($what == "username") //what can only be username or email here
				$results = $this->Query("SELECT username FROM members WHERE `username` = %s",$value);
			elseif ($what == "email") 
				$results = $this->Query("SELECT email FROM members WHERE `email` = %s",$value);
			else 
				return "Please specify the $what variable as username or email";
			return mysql_num_rows($results); //if >1 then it exist.... clearly >.>
		}
		
		function getUsrData($id) //return all data for the $id... should not be used because the pwd hash will come with this too.... use $this->getUsrInfo instead
		{
			$res = $this->Query("SELECT * FROM members WHERE `ID` = %d", $id);
			return mysql_fetch_array($res); //return the array
		}
		
		function getUsrPicture($id) {
			$data = $this->getUsrInfo($id);
			return $data['image'];	
		}
		function isFriends($ID, $a=1) 
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
		function isBlocked($ID)
		{
			$res = $this->Query("SELECT * FROM friends WHERE (`usr_ID`=%d OR `friend_id`=%d) AND `block`=1 AND `block_by`=%d", $ID, $ID, $_SESSION['ID']);	
			if (!$res)
			{
				return 0; //connection error
			}
			if (mysql_num_rows($res) != 0)
				return true;
			return false;
		}
		function getFriends($ID, $a=1)
		{
			$res = $this->Query("SELECT * FROM friends WHERE `usr_ID`=%d OR `friend_id`=%d", $ID, $ID);	
			if (!$res)
			{
				return 0; //connection error
			}
			$friends = array();
			$friend	 = array();			
			while ($row = mysql_fetch_array($res))
			{
				if ((int)$row['block'] == 1 )
					continue;
				if ((int)$row['accepted'] == 0 && $a==1)
					continue;
				$FriendID = (($row['usr_ID']==$ID)?$row['friend_ID']:$row['usr_ID']);
				$info = $this->getUsrInfo($FriendID);
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
		
		///////////////////////////////////////
		//	TYPE
		//	1 : friends request
		//	2 : friends accepted
		//
		//
		//
		///////////////////////////////////////
		function AddNotification($type, $txt, $to, $from = 0)
		{
			$res = $this->Query("SELECT * FROM notifications WHERE `usr_ID`=%d AND `type_`=%d AND `text_`=%s", $to, $type, $txt);
			if (!$res)
				return 0;
			if (mysql_num_rows($res) != 0)
				return 1; // that notification already exist
			$res = $this->Query("INSERT INTO notifications SET `usr_ID`=%d, `type_`=%d, `text_`=%s, `extra_ID`=%d, `date_`=%s", $to, $type, $txt, $from, date("Y-m-d H:i:s"));
			if (!$res)
				return 0; //error
			return 9; // YAY			
		}
		function GetNotification($re = 0)
		{
			if ($re == 0)
			{
				$res = $this->Query("SELECT * FROM notifications WHERE `usr_ID`=%d ORDER BY `read_` asc, `date_` desc LIMIT 15", $_SESSION['ID']);
			}
			else if ($re == 1)
			{
				$res = $this->Query("SELECT * FROM notifications WHERE `usr_ID`=%d AND `read_`=0 ORDER BY `read_` asc, `date_` desc LIMIT 15", $_SESSION['ID']);
			}
			if (!$res)
				return 0; // connection error
			return $res;
		}
		function RemoveNotification($type, $to)
		{
			$res = $this->Query("SELECT * FROM notifications WHERE `extra_ID`=%d AND `type_`=%d AND `usr_ID`=%d", $to, $type, $_SESSION['ID']);
			if (!$res)
				return 0;
			if (mysql_num_rows($res) == 0)
				return 1; // that notification already exist
			$res = $this->Query("DELETE FROM notifications WHERE `extra_ID`=%d AND `type_`=%d AND `usr_ID`=%d", $to, $type, $_SESSION['ID']);
			if (!$res)
				return 0; //error

			return 9; // YAY	
		} 
		function ReadNotification() // this is to clear the notifications from read, didn't want to change the function before because that one works and MEH!!!
		{
			$res = $this->Query("UPDATE notifications SET `read_`=1 WHERE `usr_ID`=%d", $_SESSION['ID']);
			if (!$res)
				return 0;
			return 1;
		}
		function Friend($idToFriend, $woot)
		////////////////////////////////////
		//	error codes
		///////////////
		// 	0: connection error
		//	3: not friends
		//	9: sucessfull
		//	666: you are blocked by the other user
		///////////////
		//	add
		// -1: can't friend yourself
		//	1: already sent a friend request but not accepted
		//	2: already friends
		///////////////
		//	accept
		//	3: no friend request
		///////////////
		//	block
		//	5: nothing to unblock
		///////////////
		//	unblock
		//  4: you do not own this block
		/////////////////////////////////////		
		{	
			switch($woot)
			{
				case "add":
					if ($idToFriend == $_SESSION['ID'])
					{
						return -1; // I feel sorry for you trying to add yourself as a friend? go out and get some...
					}
					$res = $this->Query("SELECT * FROM friends WHERE (`usr_ID`=%d AND `friend_id`=%d) OR (`friend_ID`=%d AND `usr_ID`=%d)", $_SESSION['ID'], $idToFriend, $_SESSION['ID'], $idToFriend);	
					break;	
				case "accept":
					$res = $this->Query("SELECT * FROM friends WHERE (`friend_id`=%d AND `usr_ID`=%d)", $_SESSION['ID'], $idToFriend);
					break;
				case "remove": case "block": case "unblock":
					$res = $this->Query("SELECT * FROM friends WHERE (`usr_ID`=%d AND `friend_id`=%d) OR (`friend_ID`=%d AND `usr_ID`=%d)", $_SESSION['ID'], $idToFriend, $_SESSION['ID'], $idToFriend);
					break;
			}
			if (!$res)
			{
				return 0; // urg connection error
			}
			
			
			
			if ($woot == "block")
				{
					if (mysql_num_rows($res) != 0)
						$res = $this->Query("UPDATE friends SET `block`=1, `block_by`=%d WHERE (`usr_ID`=%d AND `friend_id`=%d) OR (`friend_ID`=%d AND `usr_ID`=%d)", $_SESSION['ID'], $_SESSION['ID'], $idToFriend, $_SESSION['ID'], $idToFriend);
					else
						$res = $this->Query("INSERT INTO friends SET `block`=1, `block_by`=%d, `usr_ID`=%d, `friend_id`=%d", $_SESSION['ID'], $_SESSION['ID'], $idToFriend);
					if (!$res)
					{
						return 0; // urg connection error
					}
					return 9; // YAY
				} 
			
			if (mysql_num_rows($res) != 0) //There is something here :)
			{
				$row = mysql_fetch_array($res);
				if ($woot == "unblock")
				{
					if ($row['block'] != 1)
					{
						return 5; // nothing to unblock
					}
					if ($row['block_by'] != $_SESSION['ID'])
					{
						return 4; //you do not own this block
					}
					$res = $this->Query("UPDATE friends SET `block`=0, `block_by`=0 WHERE (`usr_ID`=%d AND `friend_id`=%d) OR (`friend_ID`=%d AND `usr_ID`=%d)",$_SESSION['ID'], $idToFriend, $_SESSION['ID'], $idToFriend);
					if (!$res)
					{
						return 0; // urg connection error
					}
					return 9;
				}
				if ($row['block'] == 1)
				{
					return 666; // this "friend" has blocked you rofl	
				}
				
				if ($woot == "remove")
				{
					$res = $this->Query("DELETE FROM friends WHERE (`usr_ID`=%d AND `friend_id`=%d) OR (`friend_ID`=%d AND `usr_ID`=%d)", $_SESSION['ID'], $idToFriend, $_SESSION['ID'], $idToFriend);
					if (!$res)
					{
						return 0; // urg connection error
					}
					return 9; // friend removed, and thank god I'll comment else this would be so comfusing lol
				}
				if ($row['accepted'] != 1) // not accepted
				{	
					if ($woot == "add")
					{
						return 1; // already sent a friend request but not accepted	
					}
					else if ($woot == "accept")
					{
						$res = $this->Query("UPDATE friends SET `accepted`=1 WHERE (`friend_id`=%d AND `usr_ID`=%d)", $_SESSION['ID'], $idToFriend);	
						if (!$res)
						{
							return 0; // urg connection error
						}						
						return 9; // YAY
					}
				}
				else 
				{
					return 2; // already frineds
				}
			}
			else
			{
				if ($woot == "add") 
				{
					$res = $this->Query("INSERT INTO friends (`usr_ID`,`friend_ID`,`date`) VALUES (%d, %d, %s)", $_SESSION['ID'], $idToFriend, date("Y-m-d H:i:s"));
					if (!$res)
					{
						return 0; // urg connection error
					}
					$this->AddNotification(1, "$_SESSION[USR] wants to be your friend", $idToFriend, $_SESSION['ID']);
					return 9; //yay friend request sent
				}
				return 3; // no friend request
			}
		}		
		
		
		function getUsrInfo($id)
		{
			$res = $this->Query("SELECT * FROM memberinfo WHERE `ID` = %d", $id);
			if (!$res)
			{
				return false;
			}
			return mysql_fetch_array($res);
		}
		function getID($usr, $woot="username") 
		{
			$C = $this->CLEAN;
			$this->CLEAN = false;
			$usr = $this->cleanQuery($usr,false);
			$Q = "SELECT * FROM members WHERE `$woot`='$usr'";
			$res = $this->Query($Q);
			$this->CLEAN = $C;
			if (!$res)
			{
				return false;
			}
			$row = mysql_fetch_array($res);
			return $row['ID'];
		}
		function activate($code) 
		{
				$res = $this->Query("SELECT activatecode FROM members WHERE activatecode LIKE %s", "%".$code);
				if (!$res)
				{
					return 0; // error with connection or something 
				} 
				$row = mysql_fetch_row($res);
				var_dump($row);
				if(substr($row[0],0,2) == "Y-")
				{
					return 2; // already activated	
				}
				else if ($row[0] == $code)
				{
					$res2 = $this->Query("UPDATE members SET activatecode=%s WHERE activatecode=%s", "Y-".$code, $code);
					if ($res2)
						return 1; //activated
					else
						return 0; //error with connection or something
				}
				return 3; //did not find the code
		}
		
		
		
	
		/**
		* logged - check if user is logged in
		*
		* @access public
		* @depriciated {@see checkAuth()}
		* @returns boolean
		*/
		/*function logged()
		{	
			if (
					isset($_SESSION['IP']) &&
					$_SESSION['IP'] == System::getRealIp() &&
					isset($_SESSION['UA']) &&
					$_SESSION["UA"] == $_SERVER["HTTP_USER_AGENT"] &&
					isset($_SESSION['ID'])
				)
				return true;
			return false;
		}*/
		
		/**
		* logout - log the user out
		* @param integer $x - 1 = tried to acecess restricted page
		* @access public
		*/
		/*public function logout($x)
		{
			var_dump($_SESSION);
			die("logout");
			$_SESSION = array(); //clear all session values
			session_regenerate_id(); //regenerate id
			$new_id = session_id(); //save the new id
			session_unset(); //unset session
			session_destroy(); //destroy the session
			session_id($new_id); //put a the regenerated session id as active one incase php does not end after this
            if ((int)$x === 1)
            {
                header("Location: /restricted/?u=". $_SERVER['REQUEST_URI']);
                die();                
            }
			header("Location: /");
			die();
		}
		function check_auth()
		{
			if (!$this->logged())
				$this->logout(1);	
		}*/
		/*
		function getUserRank($ID = 0, $type = "name"){ // default is active user and to return the name of the rank.
			if ($ID === 0)
				$ID = $_SESSION['ID'];
			$res = $this->Query("SELECT rank FROM memberinfo WHERE ID=%d", $ID);
			$row = mysql_fetch_row($res);
			if ($type === "name")
				return $this->ranks[$row[0]];
			return $row[0];
			
		}
		
		function setUsrData($what, $value)
		{
			$res = $this->Query("UPDATE memberinfo SET $what=%s WHERE `ID`=%d", $value, $_SESSION['ID']);
			if (!$res)
				return 0;
			else
				return 1;	
		}	
}*//*
class member{}
///////////////////////////////////////////
//	member wall
///////////////////////////////////////////
class wall extends member {
	public $lastID = 0;
	
	function POST($txt = "",$to = 0, $pri = 0, $child = 0) {
		$sys = new sys;
		$data = array(
				"by" => $_SESSION['ID'],
				"to" => $to,
				"privacy" => $pri,
				"date" => date("Y-m-d H:i:s"),
				"txt" => $txt,
				"child" => $child,
				"IP" => System::getRealIp(),
				"geo" => "NONE" 
		);
		$res = $this->Query("INSERT INTO wall (`by`, `to`, `privacy`, `date`, `txt`, `child`, `IP`, `geo`) VALUES (%u, %u, %u, %s, %s, %u, %s, %s)", $data['by'], $data['to'], $data['privacy'], $data['date'], $data['txt'], $data['child'], $data['IP'], $data['geo']);
		if (!$res)
			return 0; // error
		$this->lastID = mysql_insert_id($this->CON);
		return 1;
	}
	
	
	function getWall($ID = "0", $start = 0)
	{
		$ID = (((int)$ID==0)?$_SESSION['ID']:$ID); //current user if not set :P
		$start = (((int)$start == 0) ? 0 : (int)$start * 25);
		$end = $start + 25;
		$res = $this->Query("SELECT * FROM wall WHERE `to` = %u AND `child` = 0 ORDER BY `date` desc LIMIT $start, $end", $ID);
		if (!$res)
			return 0;
		return $res;
	}
	function getWallA($ID = "0")
	{
		$res = $this->Query("SELECT * FROM wall WHERE `child` = %u ORDER BY `date` asc", $ID);
		if (!$res)
			return 0;
		return $res;
	}
	
	function getLikesCount($text = "")
	{
		if (strlen($text)==0)
			return "0";
		$ids = array();
		$member = new member;
		preg_match_all("|\|([0-9]+)|U", $text, $out, PREG_PATTERN_ORDER);
		for ($o = 0; $o <= count($out); $o++)
			array_push($ids, @$out[1][$o]);
		return count($ids); //count just for now, changing later for full
	}
}
///////////////////////////////////////////
// Mixed functions that we will use around the site
///////////////////////////////////////////
class sys {
	
	function checkPG ($type = "get", $array){
		foreach($array as $value)
		{
			if ((($type == "get")? !isset($_GET[$value]) : !isset($_POST[$value])))
				return false;	
		}
		return true;
	}
	
	function timeDiff($t2) {
		$t1 = time();
		$t2 = strtotime($t2);
		$diff = $t1 - $t2;
		$m = 60; $h = $m * 60; $d = $h * 24; $w = $d * 7;
		if ($diff < $h) {
			$diff = intval($diff / $m);
			$time = $diff . (($diff == 1) ? " minute" : " minutes") . " ago";
		} else if ($diff < $d && $diff >= $h) {
			$diff = intval($diff / $h);
			$time = $diff . (($diff == 1) ? " hour" : " hours") . " ago";
		} else if ($diff >= $d && $diff < $w) {
			$time = date("D g:i a", $t2);
		} else if ($diff >= $w) {
			$time = date("jS M g:i a",$t2);
		}
		return $time;
	}
	
}





//////////////////////////////////////////////
//	Forum function
//////////////////////////////////////////////

class forum_depriciated extends member {
	function getTopicCount($ForumID) //how many topics in the forum
	{
		$res = $this->Query("SELECT * FROM topics WHERE parent_ID=%d", $ForumID);
		return mysql_num_rows($res); //return the number of results
	}
	function getPostCount($TopicID) // how many posts in the Topic (can be an array with many)
	{
		if (is_array($TopicID)) //check if array
		{
			if (sizeof($TopicID) === 0) //check that the array is not empty
				return 0;
			$query = "SELECT * FROM posts WHERE parent_ID="; //start of query
			foreach($TopicID as $id) //list through the array
			{
				$query .= $id . " OR parent_ID="; //append to the query
			}
			$query =  substr($query,0, strripos($query, "OR")); // stripp the last OR parent_ID=
			$res = $this->Query($query); //run
			return mysql_num_rows($res);//return results
		}
		else //only 1 ID
		{
			$res = $this->Query("SELECT * FROM posts WHERE parent_ID=%d", $TopicID);
			return mysql_num_rows($res); //return the number of results
		}
	}
	function getPostCountByForum($ForumID) //if you want to check a whole subcat instead of individual topics
	{
		$res = $this->Query("SELECT * FROM topics WHERE parent_ID=%d", $ForumID); //get all the topics from the subcat
		$array = array();
		while ($row = mysql_fetch_array($res))
		{
			array_push($array, $row["ID"]); //pusch all the ID's to an array
		}
		return $this->getPostCount($array); //send to the post count with all the ID's and then return the results
	}
	
	function getLastPost($TopicID) //last post of a topic
	{
		$sys = new sys; //we need this for the timediff function
		if (is_array($TopicID)) //check if array 
		{
			if (sizeof($TopicID) === 0) //check so its not empty
				return "";
			$query = "SELECT * FROM posts WHERE ";//start of query
			foreach($TopicID as $id)
			{
				$query .= "parent_ID=".$id." OR ";//append query
			}
			$query =  substr($query,0, strripos($query, "OR")) . "ORDER BY time_ desc"; //remove the last OR parent_ID= from query
			$res = $this->Query($query);//run the query
			
			$query = "SELECT * FROM topics WHERE ";//start of query
			foreach($TopicID as $id)
			{
				$query .= "ID=".$id." OR ";//append query
			}
			$query =  substr($query,0, strripos($query, "OR")) . "ORDER BY time_ desc"; //remove the last OR parent_ID= from query
			$res2 = $this->Query($query);//run the query
		}
		else //only checking 1 ID
		{
			$res = $this->Query("SELECT * FROM posts WHERE parent_ID=%d ORDER BY time_ desc", $TopicID);
			$res2 = $this->Query("SELECT * FROM topics WHERE ID = %d ORDER BY time_ desc", $TopicID);
		}
		
		$row = mysql_fetch_array($res);//because we are sorting by date desc we only want the oldest post
		$row2 = mysql_fetch_array($res2);
		if ($row2["time_"] > $row["time_"])
			$row = $row2;
		$data = $this->getUsrInfo($row["by_"]); //get the info from the user
		return "by <a href=\"/user/$data[username]\">".$data["username"]."</a> &nbsp;&nbsp;<span title=\"".$this->getTopicName($row["parent_ID"]).":\n".substr($row["msg"],0,100)."\">&iexcl;</span><br/>".$sys->timeDiff($row["time_"]) . "&nbsp;&nbsp;<a href=\"#t=".$row["parent_ID"]."&p=".$row["ID"]."\">&raquo;</a>";	
		//return our costumized "last post"-text
		
	}
	
	function getTopicName($TopicID)
	{
		$res = $this->Query("SELECT title FROM topics WHERE ID=%d", $TopicID);
		return mysql_fetch_array($res)["title"];	//return the name of the topic
	}
	function convertName($name)
	{
		return str_replace(" ","_",$name);
	}
	function getLastPostByForum($ForumID)//check by forum/subcat instead of only 1 topic
	{
		$res = $this->Query("SELECT * FROM topics WHERE parent_ID=%d", $ForumID);
		$array = array();
		while ($row = mysql_fetch_array($res))
		{
			array_push($array, $row["ID"]); //push resulted ID's to array
		}
		return $this->getLastPost($array); //run the ormal function but with an array
	}
	function getPostCountByUser($userID)
	{
		$res = $this->Query("SELECT by_ FROM posts WHERE by_=%u", $userID);
		$a = mysql_num_rows($res);
		$res = $this->Query("SELECT by_ FROM topics WHERE by_=%u", $userID);
		return mysql_num_rows($res) + $a;
	}
}
//perform a function for each index in an array
function doForAllInArray(&$arr, $funcs){
	foreach($arr as $key => $value){
		foreach($funcs as $func){
			$arr[$key] = call_user_func($func, $value);
		}
	}
}









////////////////////////////////////////////
//    auto run
////////////////////////////////////////////
$member	= new member;
//$member->UpdateRanks();
*/
?>