<?php
session_start_secure();
//echo "yes";
include_once($_SERVER['DOCUMENT_ROOT']."/config.php");
///////////////////////////////////////////
//  SQL with cleanQuery
///////////////////////////////////////////
class SQL{ 
    private $SQL_USR = SQL_USR; //username to sql server
    private $SQL_PWD = SQL_PWD; //password
    private $SQL_SERVER = SQL_SERVER; //server
    private $SQL_DB = SQL_DB; //database
    public $CON;  //the connection will be here
    public $RESULTS; //results if you need em again
	private $die_on_error = true; //kill on error, should ALWAYS be true
	//private $errors = false; //production mode
	private $errors = true; //developing mode
	
    function __construct() // at init
	{ 
        $this->CON = mysql_connect($this->SQL_SERVER, $this->SQL_USR, $this->SQL_PWD) or (($this->die_on_error)? die((($this->errors)?mysql_error():"")) :""); //create connection
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
				$args[$i] = $this->cleanQuery($args[$i]); //clean the arguments one by one
			}
			foreach($args as $key=>$value) //do an extra check if int, float or string
				$args[$key] = ((preg_match('/^([0-9]*)$/',$value) || is_int($value))?intval($value):((preg_match('/^([0-9]*)\.([0-9]*)$/',$value) || is_float($value))?floatval($value) : "'".$value."'"));  
			$query = call_user_func_array('sprintf', array_merge((array)$query, $args)); //merge the arguments with the query
        }
		$this->RESULTS = mysql_query($query) or (($this->die_on_error)? die((($this->errors)?mysql_error():"")) :"");  // execute the done query 
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
//////////////////////////////////
// secure session
//////////////////////////////////
function session_start_secure() //starting a secure session
{
	if (session_status() != PHP_SESSION_ACTIVE) //check if there is one atm
	{
		if (isset($_COOKIE['PHPSESSID']) && !preg_match('/^[a-z0-9-,]{22,40}$/i', $_COOKIE['PHPSESSID']))//check session ID so its not manipullated
				unset($_COOKIE['PHPSESSID']); //removing cookie, incorrect
		
		$currentCookieParams = session_get_cookie_params(); // getting active session parameters
		session_set_cookie_params(  //putting a new secure cookie
			$currentCookieParams["lifetime"],  
			$currentCookieParams["path"],  
			$currentCookieParams["domain"],  
			$currentCookieParams["secure"],  
			true //http_only
		); 
		session_start(); //starting session
		session_regenerate_id(); //regenerate ID to prevent hojacking
	}
}

?>