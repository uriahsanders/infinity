<?php
interface iForum {
	
}
/**
*	Forum class
*	
*	@author relax
*/
class Forum extends Members implements iForum 
{
	public function __construct(){
		$this->sql = Database::getInstance();
	}
	const LIMIT = 5; //limit of posts per thread (does not include topic)
	public function getTopicCount($ForumID) //how many topics in the forum
	{
		$res = $this->sql->query("SELECT COUNT(*) FROM `topics` WHERE `parent_ID`=?", $ForumID);
		return $res->fetchColumn(); //return the number of results
	}
	public function getPostCount($TopicID) // how many posts in the Topic (can be an array with many)
	{
		if (is_array($TopicID)) //check if array
		{
			if (sizeof($TopicID) === 0) //check that the array is not empty
				return 0;
			$query = "SELECT COUNT(*) FROM `posts` WHERE `parent_ID`="; //start of query
			foreach($TopicID as $id) //list through the array
			{
				$query .= $id . " OR parent_ID="; //append to the query
			}
			$query =  substr($query,0, strripos($query, "OR")); // stripp the last OR parent_ID=
			$res = $this->sql->query($query); //run
			return $res->fetchColumn();//return results
		}
		else //only 1 ID
		{
			$res = $this->sql->query("SELECT COUNT(*) FROM `posts` WHERE `parent_ID`= ?", $TopicID);
			return $res->fetchColumn(); //return the number of results
		}
	}
	public function getPostCountByForum($ForumID) //if you want to check a whole subcat instead of individual topics
	{
		$res = $this->sql->query("SELECT * FROM `topics` WHERE `parent_ID`= ?", $ForumID); //get all the topics from the subcat
		$array = array();
		while ($row = $res->fetch())
		{
			array_push($array, $row["ID"]); //pusch all the ID's to an array
		}
		return $this->getPostCount($array); //send to the post count with all the ID's and then return the results
	}
	//get an array of all posters in thread
	public function getPostersInThread($id){
		$posters = $this->sql->query("SELECT `by_` FROM `posts` WHERE `parent_ID` = ?", $id);
		$arr = [];
		while($row = $posters->fetch()){
			array_push($arr, $row['by_']);
		}
		return $arr;
	}
	public function getLastPost($TopicID) //last post of a topic
	{
		if (is_array($TopicID)) //check if array 
		{
			if (sizeof($TopicID) === 0) //check so its not empty
				return "";
			$query = "SELECT * FROM `posts` WHERE ";//start of query
			foreach($TopicID as $id)
			{
				$query .= "`parent_ID`=".$id." OR ";//append query
			}
			$query =  substr($query,0, strripos($query, "OR")) . "ORDER BY `time_` DESC"; //remove the last OR parent_ID= from query
			$res = $this->sql->query($query);//run the query
			
			$query = "SELECT * FROM `topics` WHERE ";//start of query
			foreach($TopicID as $id)
			{
				$query .= "ID=".$id." OR ";//append query
			}
			$query =  substr($query,0, strripos($query, "OR")) . "ORDER BY `time_` DESC"; //remove the last OR parent_ID= from query
			$res2 = $this->sql->query($query);//run the query
		}
		else //only checking 1 ID
		{
			$res = $this->sql->query("SELECT * FROM `posts` WHERE `parent_ID`=? ORDER BY `time_` DESC", $TopicID);
			$res2 = $this->sql->query("SELECT * FROM `topics` WHERE `ID` = ? ORDER BY `time_` DESC", $TopicID);
		}
		
		$row = $res->fetch();//because we are sorting by date desc we only want the oldest post
		$row2 = $res2->fetch();
		if ($row2["time_"] > $row["time_"])
			$row = $row2;
		$member = Members::getInstance();
		$data = $member->getUserData($row["by_"]); //get the info from the user
		return "by <a href=\"/user/$data[username]\">".$data["username"]."</a> 
		&nbsp;&nbsp;<span title=\"".$this->getTopicName($row["parent_ID"]).":\n".substr($row["msg"],0,100)."\">
		</span><br/>".System::timeDiff($row["time_"]) . "&nbsp;&nbsp;<a href=\"#t=".$row["parent_ID"]."&p=".$row["ID"]."\">&raquo;</a>";	
		//return our costumized "last post"-text
	}
	public function getTopicName($TopicID)
	{
		$res = $this->sql->query("SELECT `title` FROM `topics` WHERE `ID`=?", $TopicID);
		return $res->fetch()["title"];	//return the name of the topic
	}
	public function convertName($name)
	{
		return str_replace(" ","_",$name);
	}
	public function getLastPostByForum($ForumID)//check by forum/subcat instead of only 1 topic
	{
		$res = $this->sql->query("SELECT * FROM `topics` WHERE `parent_ID`=?", $ForumID);
		$array = array();
		while ($row = $res->fetch())
		{
			array_push($array, $row["ID"]); //push resulted ID's to array
		}
		return $this->getLastPost($array); //run the ormal function but with an array
	}
	public function getPostCountByUser($userID)
	{
		$res = $this->sql->query("SELECT COUNT(`by_`) FROM `posts` WHERE `by_`= ?", $userID);
		$a = $res->fetchColumn();
		$res = $this->sql->query("SELECT COUNT(`by_`) FROM `topics` WHERE `by_`= ?", $userID);
		return $res->fetchColumn() + $a;
	}
	//get the number of pages in a thread
	public function numPagesInThread($threadID){
		$res = $this->sql->query("SELECT COUNT(*) FROM `posts` WHERE `parent_ID` = ?", $threadID)->fetchColumn();
		return ceil($res / self::LIMIT);
	}
	public function listPageNums($threadID, $pg = 1){
		$res = 'Pages: ';
		//make sure we always have at least one page (cause OP isnt counted)
		$num = $this->numPagesInThread($threadID) >= 1 ? $this->numPagesInThread($threadID) : 1;
		for($i = 1; $i <= $num; ++$i){
			$res .= ($pg != $i) ? "<a class='pg-link'id='change-pg-".$i."'>".$i."</a> " : '['.$i.'] ';
		}
		return $res;
	}
	public function beginAtRow($pn){
		return self::LIMIT * ($pn - 1);
	}
	public function newThread($subject, $body, $parent){
		$this->sql->query("INSERT INTO `topics` (`title`, `msg`, `IP`, `by_`, `parent_ID`, `time_`, `category`) VALUES (?, ?, ?, ?, ?, ?, ?)",
		$subject, $body, System::getRealIp(), $_SESSION['ID'], $parent, date('Y-m-d H:i:s'), $this->nameOfSub($parent));
		Action::addAction('created a new thread: '.$subject, 
			preview($body)."<br></br><button class=\"btn btn-primary\">Dismiss</button>", 'forum', $this->sql->lastInsertId());
	}
	public function post($body, $parent){
		$this->sql->query("INSERT INTO `posts` (`msg`, `IP`, `by_`, `parent_ID`, `time_`) VALUES (?, ?, ?, ?, ?)",
		$body, System::getRealIp(), $_SESSION['ID'], $parent, date('Y-m-d H:i:s'));
	}
	//return ture if this was created by the current session user
	private function sessionCreated($id, $what){ //$what is either topics or posts
		$bool = $this->sql->query("SELECT `by_` FROM `".$what."` WHERE `ID` = ?", $id)->fetchColumn() == $_SESSION['ID'];
		if($bool == false)
			System::logSuspect('Potential HTML tampering; user is attempting 
				to manipulate a post or topic (from table '.$what.') that they did not create.', false);
		return $bool;
	}
	public function delete($id, $what){ //$what is either topics or posts
		if($what == 'topics'){
			if($this->getPostCount($id) != 0){
				System::logSuspect('User attempted to remove a topic with more than 0 replies. 
					Potential HTML tampering to allow this action.');
			}
		}
		if($this->sessionCreated($id, $what)) $this->sql->query("DELETE FROM `".$what."` WHERE `ID` = ?", $id);
	}
	public function updateThread($id, $subject, $body){
		if($this->sessionCreated($id, 'topics')) $this->sql->query("UPDATE `topics` SET `title` = ?, `msg` = ? WHERE `ID` = ?", $subject, $body, $id);
		else die('failure');
	}
	public function updatePost($id, $body){
		if($this->sessionCreated($id, 'posts')) $this->sql->query("UPDATE `posts` SET `msg` = ? WHERE `ID` = ?", $body, $id);
	}
	//for topics only atm
	public function postTemplate($row){
		$member = Members::getInstance();
		$ranks = $member->ranks;
		$poster = $member->getUserData($row[0]["by_"]);
		$id = $row[0]['ID'];
		//only show remove is no replies to topic yet
		$remove = ($this->getPostCount($row[0]["ID"]) == 0) ? ' &emsp; <a id="forum-remove-topics-'.$id.'">Remove</a>' : '';
		return "<br><div class=\"thread_title\">
		<span>&nbsp;</span>".
		$row[0]["title"]." - ".System::timeDiff($row[0]["time_"]). // topic title
		"</div>
		<div class=\"post\">
		<table class=\"tbl_post\"><tr><td>
		<div class=\"post_usr\"><a href=\"/user/$poster[username]\">$poster[username]</a><br/>
		<span class=\"status\" id=\"".$member->status2name($poster['status'])."\" title=\"".$member->status2name($poster['status'])."\">&nbsp;</span>
		<img src=\"/images/user/$poster[image]\" alt=\"$poster[username]\" />
		<span class=\"usr_rank\">".($poster['special'] !== 'Member' && $poster['special'] !== '' ? $poster['special'] : $ranks[$poster["rank"]])."</span><br><br>
		<table class=\"usr_info\">
		<tr><td width=10>Posts:</td><td>". $this->getPostCountByUser($poster["ID"])."</td></tr>
		<tr><td>Prestige:</td><td>". $poster["prestige"]."</td></tr>
		</table>
		</div>
		</td><td><input type='hidden'id='threadID'value='".$id."'/>
		<div class=\"post_msg\"><div style='width:100%;height:100%'id='epicedit-".$id."'><textarea id='epic-".$id."'class='epic-text'>".$row[0]['msg']."</textarea></div></div>
		<div class=\"post_msg_btm\">
			<span style='cursor:pointer'>Quote</span> ".($_SESSION['ID'] == $row[0]['by_'] ? "&emsp; <span style='cursor:pointer'id='forum-modify-topics-".$id."'>Modify</span>".$remove : "&emsp; <a class='fa fa-plus'></a> &emsp;<a class='fa fa-minus'></a>").
		"</div>
		</td></tr></table>
		</div>
		</div>";
	}
	public function getPostData($id, $what){
		return $this->sql->query("SELECT * FROM `".$what."` WHERE `ID` = ?", $id)->fetch();
	}
	//get name of subcat through ID
	public function nameOfSub($id){
		return $this->sql->query("SELECT `name` FROM `subcat` WHERE `ID` = ?", $id)->fetchColumn();
	}
	public function getCategoryFromThread($id){
		$cat = $this->sql->query("SELECT `parent_ID` FROM `topics` WHERE `ID` = ?", $id)->fetchColumn();
		$category = $this->sql->query("SELECT `name` FROM `subcat` WHERE `ID` = ?", $cat)->fetchColumn();
		return $category;
	}
}