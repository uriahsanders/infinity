<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this file
//manage "karma" system, which are "votes",
//which add prestige to members and popularity to projects
//works in the context that the person voting is the $_SESSION['ID']
class Votes{
	/**
	*	Give or take a vote from a member or project
	*	@access public
	*	@static
	*	@param int $amount - how many votes to give
	*	@param string $what - is this for a member or a project?
	*	@param int $id -ID of member or project
	*	@example Votes::vote(1, 'member', 3, true); //take one point from a member
	*/
	public static function vote($amount, $what, $id, $take = false){
		//if we can vote on this again
		if($this->reqTimePassed($what, $id)){
			$table = $what == 'member' ? 'memberinfo' : 'projects';
			$currency = $table == 'memberinfo' ? 'prestige' : 'popularity';
			$this->sql->beginTransaction();
			try{
				Database::getInstance()->query("UPDATE `".$table."` SET `".$currency."` = `".$currency."` + ? WHERE `ID` = ?", $id, $amount);
				//tell db we voted and when
				Database::getInstance()->query("INSERT INTO `votes` (`what`, `by`, `to`, `when`) VALUES (?, ?, ?, ?)", 
					$what, $_SESSION['ID'], $id, date('Y-m-d H:i:s'));
				$this->sql->commit();
			}catch(Exception $e){
				$this->sql->rollback();
				System::Error($e->getMessage());
			}
		}
	}

	/**
	*	Get a list of the most popular members or projects
	*	@access public
	*	@static
	*	@return array - array returned ID's
	*	@param string $what - is this for a member or a project?
	*	@param int $start - row to start at
	*	@example Votes::mostPopular('projects', 0, 20); //top 20 projects by popularity
	*/
	public static function mostPopular($what, $start, $limit){
		$table = $what == 'member' ? 'memberinfo' : 'projects';
		$currency = $table == 'memberinfo' ? 'prestige' : 'popularity';
		return Database::getInstance()->query("SELECT `ID` FROM `".$table."` ORDER BY `".$currency."` LIMIT ?, ?", $start, $limit);
	}

	/**
	*	delete all votes more than an hour old and then allow if no votes on given $id remaining
	*	@access public
	*	@static
	*	@param string $what - is this for a member or a project?
	*	@param int $id -ID of member or project
	*	@example Votes::vote(1, 'member', 3, true); //take one point from a member
	*/
	private function reqTimePassed($what, $id){
		$this->sql->beginTransaction();
		try{
			//delete all old votes (hour ago) for same `ID` and `by`
			Database::getInstance()->query("DELETE FROM `votes` WHERE `when` < (NOW() - INTERVAL 60 MINUTE) AND `to` = ? AND `what` = ? AND `by` = ?", $id, $what, $_SESSION['ID']);
			//how many fresh votes are there?
			$result = Database::getInstance()->query("SELECT COUNT(*) FROM `votes` WHERE `to` = ? AND `what` = ? AND `by` = ?", $to, $what, $_SESSION['ID']);
			$this->sql->commit();
			//we can vote again if there are no more fresh votes
			if($result->fetchColumn() == 0) return true;
			return false;
		}catch(Exception $e){
			$this->sql->rollback();
			System::Error($e->getMessage());
		}
	}
}