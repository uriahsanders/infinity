<?php
class Wall{
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
	public $lastID = 0;
	
	function POST($txt = "",$to = 0, $pri = 0, $child = 0) {
		$sys = new System;
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
		$res = $this->_db->query("INSERT INTO `wall` (`by`, `to`, `privacy`, `date`, `txt`, `child`, `IP`, `geo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", $data['by'], $data['to'], $data['privacy'], $data['date'], $data['txt'], $data['child'], $data['IP'], $data['geo']);
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
		$res = $this->_db->query("SELECT * FROM `wall` WHERE `to` = ? AND `child` = 0 ORDER BY `date` desc LIMIT $start, $end", $ID);
		if (!$res)
			return 0;
		return $res;
	}
	function getWallA($ID = "0")
	{
		$res = $this->_db->query("SELECT * FROM `wall` WHERE `child` = ? ORDER BY `date` asc", $ID);
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