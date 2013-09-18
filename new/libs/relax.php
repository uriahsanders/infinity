<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie
	
define("PATH", "/home2/infiniz7/public_html/new/"); // so we can try using presice path in includes

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

////////////////////////////////////////////////
//	Member class to use for all info functions
////////////////////////////////////////////////
class member extends SQL{
		function checkDub($what, $value) 
		{
			if ($what == "username") 
			{
				$results = $this->Query("SELECT username FROM members WHERE `username` = %s",$value);
			} 
			elseif ($what == "email") 
			{
				$results = $this->Query("SELECT email FROM members WHERE `email` = %s",$value);
			} 
			else 
			{
				return "Please specify the $what variable as username or email";
			}
			return mysql_num_rows($results);	
		}
		function getUsrData($id)
		{
			$res = $this->Query("SELECT * FROM members WHERE `ID` = %d", $id);
			if (!$res)
			{
				return false;
			}
			return mysql_fetch_array($res);
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
		
		function logged()
		{	
			$sys = new sys;
			if (
					isset($_SESSION['IP']) &&
					$_SESSION['IP'] == $sys->getRealIp() &&
					isset($_SESSION['UA']) &&
					$_SESSION["UA"] == $_SERVER["HTTP_USER_AGENT"] &&
					isset($_SESSION['ID'])
				)
				return true;
			return false;
		}
		function logout($x)
		{
			session_unset();
			session_destroy();
            if ((int)$x === 1)
            {
                header("Location: /restricted/");
                die();                
            }
			header("Location: /");
			die();
		}
		function check_auth()
		{
			if (!$this->logged())
				$this->logout(1);	
		}
		
		
		
		function setUsrData($what, $value)
		{
			$res = $this->Query("UPDATE memberinfo SET $what=%s WHERE `ID`=%d", $value, $_SESSION['ID']);
			if (!$res)
				return 0;
			else
				return 1;	
		}	
}

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
				"IP" => $sys->getRealIp(),
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
	function getRealIp() {
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
							if (substr($ip,0,5) == "83.23")
								return "127.0.0.1";
							return $ip;
					}
				}
			}
		}
	}
	
	
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
///////////////////////////////////////////
//	Bcrypt
///////////////////////////////////////////
// Originally by Andrew Moore
// Src: http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php/6337021#6337021
// Heavily modified by Robert Kosek, from data at php.net/crypt
///////////////////////////////////////////
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
  public function hash($input) {
    $hash = crypt($input, $this->getSalt());
    if(strlen($hash) > 13)
      return $hash;
    return false;
  }
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
///////////////////////////////////////////
//  SQL with cleanQuery
///////////////////////////////////////////
class SQL{
    private $SQL_USR = "infiniz7_web";
    private $SQL_PWD = "p,G4?+B@n5~8]XIRP(";
    private $SQL_SERVER = "localhost";
    private $SQL_DB = "infiniz7_new2";
    public $CON; //the connection will lie here
    public  $RESULTS;
    public  $CLEAN = true; // if its going to be cleaned or not
    function __construct() { 
        $this->CON = mysql_connect($this->SQL_SERVER, $this->SQL_USR, $this->SQL_PWD) or die(mysql_error()); //connect
        mysql_select_db($this->SQL_DB, $this->CON) or die(mysql_error()); // select db
    }
    function Query($query = "") { //standard query with or without args
        $args = func_get_args(); // get rest of arguments
        if (count($args) < 1) { $this->Error(__METHOD__.' No arguments'); return;}; // not even a query as an argument
        array_shift($args); // hide the query so we can work with the args
        if ($this->CLEAN === true) { for ($i = 0; $i < count($args); $i++) { $args[$i] = $this->cleanQuery($args[$i]); }} // clean all args if clean is true
        foreach($args as $key=>$value)
            $args[$key] = ((preg_match('/^([0-9]*)$/',$value) || is_int($value))?intval($value):((preg_match('/^([0-9]*)\.([0-9]*)$/',$value) || is_float($value))?floatval($value) : "'".$value."'")); //small modification so not all arguments will be strings
        $query = call_user_func_array('sprintf', array_merge((array)$query, $args));  // merge the query with the arguments
        $this->RESULTS = mysql_query($query) or die(mysql_error()); // RUUUUUUUUUNNNN!!!
        return $this->RESULTS; // send back
    }
    function cleanQuery($string, $xss = true, $br = false, $br2 = false) { //if you clean by yourseld
        $string = ($xss === true) ? htmlspecialchars($string) : $string; // XSS preventation
        $string = ($br != false) ? str_replace("\n","<br />",$string) : $string; // replace new lines to BR
        $string = (phpversion() >= '4.3.0') ? mysql_real_escape_string($string) : mysql_escape_string($string); // sql injection preventation, you can't turn this off
        
        if ($br2 != false) { // to stripp multiple br
            while (preg_match('~<br /><br /><br />~',$string)) { $string = preg_replace('~<br /><br /><br />~', "<br /><br />", $string); } //replace 3br to 2br
            if (substr($string,-12) == "<br /><br />") $string = substr($string,0,-12); else if (substr($string,-6) == "<br />") $string = substr($string,0,-6); //remove br from the end
        }
        return $string; //return
    }
}

////////////////////////////////////////////
//    the classes
////////////////////////////////////////////
$member		= 	new member;
?>