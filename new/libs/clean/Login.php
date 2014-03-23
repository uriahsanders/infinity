<?php

if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie

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
		//session_regenerate_id(true); //generate new session id.
		//$new_id = session_id(); //save the id for later
		session_unset(); //unset session
		session_destroy(); //destroy the session
		//session_id($new_id); //set the session id to new generated
		
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
			$this->registerError("There was an unexpected error, errorcode:[REG-E1]"); //this will throw on localhost if you dont have a smpt server configured
			
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


?>