<?php
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
			// "/lounge/"=>"",
			//"/projects/#!/all" => "Projects",
			"/about/" => "About",
			"/contact/" => "Contact",
			"/blog/" => "Blog",
			"/help/" => "Help"
		);
		// if (Login::checkAuth(true)) // if loggedin show the lounge link as well
			// $links["/lounge/"] = "Lounge";               
	  
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
	*	Log suspicious activity in database so we can be aware of potential attacks from IP's
	*	Logs all information from user and activity with custom message as well
	*
	*	@param string $msg - Anything specific you want to say about this?
	*	@param boolean $die -  default true: die() after logging?
	*	@param boolean $alert - default false: tell user they've been logged?
	*	@static
	*	@access public
	*/
	public static function logSuspect($msg, $die = true, $alert = false){
		Database::getInstance()->query("INSERT INTO `suspicious` (`userID`, `IP`, `date`, `message`)
			VALUES (?, ?, ?, ?)
			", $_SESSION['ID'] || 0, self::getRealIp(), date("Y-m-d H:i:s"), $msg);
		$res = $alert ? 'Your activity has been logged due to suspicious activity. If this allegation is incorrect, please contact us.' : '';
		if($die) die($res);
		echo $res;
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
		// this is actually the recomended way sense php 5.4 to check for an active session.
		// or session_status == PHP_SESSION_NONE
		if (session_status() != PHP_SESSION_ACTIVE) //check if there is one atm
		{
			$cookie_name = "Infinity"; //cookie_name
			$time = time() + 12096000; //2 weeks
			
			if (isset($_COOKIE[$cookie_name]) && !preg_match('/^[a-z0-9-,]{22,40}$/i', $_COOKIE[$cookie_name]))//check session ID so value looks OK
				unset($_COOKIE[$cookie_name]); //removing cookie, incorrect value
			
			$currentCookieParams = session_get_cookie_params(); // getting active session parameters

			session_set_cookie_params(  //putting a new secure cookie
				$time, 
				$currentCookieParams["path"],  
				$currentCookieParams["domain"],  
				$currentCookieParams["secure"],  
				true //http_only
			); 
			session_name($cookie_name); //set the name
			
			$timeout = ini_get("max_execution_time"); //get curent setting
			ini_set("max_execution_time", 5); //should never be more then 5 sec to start a session
			session_start(); 
			ini_set("max_execution_time", $timeout); //restore do default
			session_regenerate_id(); //regenerate ID to prevent hijacking
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
	public static function timeDiff($t2) {
		$t1 = time(); //current time
		$t2 = strtotime($t2); //given time
		$diff = $t1 - $t2; //difference between times
		//get values based on seconds:
		//minutes, hours, days, weeks, months
		$m = 60; $h = $m * 60; $d = $h * 24; $w = $d * 7; $mt = $w * 3.6; //cut this down to be safe
		//show different results depending on what time frame we're in
		if($diff <= $m){
			$time = "just now";
		}else if ($diff < $h) { //less than an hour ago
			$diff = intval($diff / $m);
			$time = $diff . (($diff == 1) ? " minute" : " minutes") . " ago";
		} else if ($diff < $d && $diff >= $h) { //more than an hour less than a day
			$diff = intval($diff / $h);
			$time = $diff . (($diff == 1) ? " hour" : " hours") . " ago";
		} else if ($diff >= $d && $diff < $w) { //more than a day less than a week
			$time = date("D g:i a", $t2);
		} else if ($diff >= $w && $diff < $mt) { //more than a week less than a month
			$time = date("jS M g:i a",$t2);
		} else if($diff >= $mt){ //more than a month
			$time = date("jS M g:i a, Y");
		}
		return $time;
	}
	//stick a users name together
	public static function concatName($name){
		//replace spaces with dots
		return preg_replace('/\s/i', '.', $name);
	}
}