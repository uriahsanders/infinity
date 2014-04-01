<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this file
//manage "karma" system, which are "votes",
//which add prestige to members and popularity to projects
//works in the context that the person voting is the $_SESSION['ID']
//members can "vote" on either forum posts or projects. Prestige/popularity will update accordingly
class Votes{
	/**
	*	Give or take a vote from a member or project
	*	@access public
	*	@static
	*	@param int $amount - how many votes to give
	*	@param string $what - is this for a member or a project?
	*	@param int $id -ID of member or project
	*	@example Votes::vote(1, 'forum', 3, true); //take one point from a member by post of ID 3
	*/
	public static function vote($amount, $what, $id, $take = 0){ //take equals 0 for NOT taking away (subtracting) a vote, 1 if we are
		//if we can vote on this again
		if($this->canVoteAgain($what, $id, $take)){
			$table = $what == 'forum' ? 'memberinfo' : 'projects';
			$currency = $table == 'memberinfo' ? 'prestige' : 'popularity';
			$sign = $take == 0 ? '+' : '-';
			$this->sql->beginTransaction();
			try{
				//update prestige or popularity for members/project
				Database::getInstance()->query("UPDATE `".$table."` SET `".$currency."` = `".$currency."` ".$sign." ? WHERE `ID` = ?", $id, $amount);
				if($what == 'forum'){
					//also add votes to forum topic or post if required
					Database::getInstance()->query("UPDATE `posts` SET `popularity` = `popularity` ".$sign." ? WHERE `ID` = ?", $id, $amount);
					Database::getInstance()->query("UPDATE `topics` SET `popularity` = `popularity` ".$sign." ? WHERE `ID` = ?", $id, $amount);
				}
				//tell db we voted and when
				Database::getInstance()->query("INSERT INTO `votes` (`what`, `by`, `to`, `when`, `take`) VALUES (?, ?, ?, ?, ?)", 
					$what, $_SESSION['ID'], $id, date('Y-m-d H:i:s'), $take);
				$this->sql->commit();
			}catch(Exception $e){
				$this->sql->rollback();
				System::Error($e->getMessage());
			}
		}
	}

	/**
	*	Get a list of the most popular members, forum posts, or projects
	*	@access public
	*	@static
	*	@return array - array returned ID's
	*	@param string $what - is this for a member or a project?
	*	@param int $start - row to start at
	*	@example Votes::mostPopular('projects', 0, 20); //top 20 projects by popularity
	*/
	public static function mostPopular($what, $start, $limit){
		if($what == 'member'){
			$table = 'memberinfo';
		}else if($what == 'posts' || $what == 'topics'){
			$table = $what;
		}else{
			$table = 'projects';
		}
		$currency = $table == 'memberinfo' ? 'prestige' : 'popularity';
		return Database::getInstance()->query("SELECT `ID` FROM `".$table."` ORDER BY `".$currency."` LIMIT ?, ?", $start, $limit);
	}

	/**
	*	Dont allow another equal vote if $id has been voted on already
	*	@access public
	*	@static
	*	@param string $what - is this for a forum post or a project?
	*	@param int $id -ID of member or project
	*	@example Votes::vote(1, 'member', 3, true); //take one point from a member
	*/
	private function canVoteAgain($what, $id, $take){
		$this->sql->beginTransaction();
		try{
			//how many fresh votes are there?
			$result = Database::getInstance()->query("SELECT `take` FROM `votes` WHERE `to` = ? AND `what` = ? AND `by` = ?", $to, $what, $_SESSION['ID']);
			$this->sql->commit();
			$res = $result->fetchAll();
			//we can vote again if there are no more fresh votes with same $take
			if(count($res == 0) && $res[0]['take'] != $take) return true;
			return false;
		}catch(Exception $e){
			$this->sql->rollback();
			System::Error($e->getMessage());
		}
	}
}