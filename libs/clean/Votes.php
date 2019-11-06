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
	*	@example Votes::vote(1, 'forum', 3, 2); //take one point from a member by post of ID 3
	*/
	public static function vote($amount, $what, $id, $vote = 1){ //vote equals 0 for none, 1 for positive, 2 for negative vote
		//if we can vote on this again
		if($this->canVoteAgain($what, $id, $vote)){
			$table = $what == 'forum' ? 'memberinfo' : 'projects';
			$currency = $table == 'memberinfo' ? 'prestige' : 'popularity';
			$sign = $vote == 1 ? '+' : '-';
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
				Database::getInstance()->query("INSERT INTO `votes` (`what`, `by`, `to`, `when`, `vote`) VALUES (?, ?, ?, ?, ?)", 
					$what, $_SESSION['ID'], $id, date('Y-m-d H:i:s'), $vote);
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
	*/
	private function canVoteAgain($what, $id, $vote){
		//how many fresh votes are there?
		$result = Database::getInstance()->query("SELECT `vote` FROM `votes` WHERE `to` = ? AND `what` = ? AND `by` = ?", $to, $what, $_SESSION['ID']);
		$res = $result->fetchAll();
		//we can vote again if there are no more fresh votes with same $vote
		if(count($res == 0) && $res[0]['vote'] != $vote) return true;
		return false;
	}

	//get our current vote on ID $id
	//return 0 if have not voted, 1 if voted positive, 2 if voted negative
	//on ID $id
	//just extra info: grey => 0, green => 1, red => 2
	public static function currentVote($id){
		return Database::getInstance()->query("SELECT `vote` FROM `votes` WHERE `to` = ? AND `by` = ?", $id, $_SESSION['ID'])->fetchColumn();
	}
}