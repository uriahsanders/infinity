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
	const LIMIT = 3; //limit of pages per thread
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
	private function numPagesInThread($threadID){
		$res = $this->sql->query("SELECT COUNT(*) FROM `posts` WHERE `parent_ID` = ?", $threadID)->fetchColumn();
		return ceil($res / self::LIMIT);
	}
	public function listPageNums($threadID, $pg = 1){
		$res = 'Pages: ';
		for($i = 1; $i <= $this->numPagesInThread($threadID); ++$i){
			$res .= ($pg != $i) ? "<a class='pg-link'id='change-pg-".$i."'>".$i."</a> " : '['.$i.'] ';
		}
		return $res;
	}
	public function beginAtRow($pn){
		return self::LIMIT * ($pn - 1);
	}
}