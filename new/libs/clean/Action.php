<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie
	/**
	*I suppose this file is a type of notification class, but more versatile
	*Storing and removing actions of members
	*Table: `actions`, (search & replace this to change all (no instance data 'cause static methods))
	*Columns: `ID`, `user`, `title`, `content`, `category`, `date` `read`
	*/
	class Action{
		//categories of actions so we can sort through
		//public $categories = ['forum', 'profile', 'projects', 'PM'];
		//one query function to be performed in multiples by public equivalent
		private function newAction($user, $title, $content, $category){
			Database::getInstance()->query("INSERT INTO `actions` (`user`, `title`, `content`, `category`, `date`) VALUES (?, ?, ?, ?, ?)",
			 $user, $title, $content, $category, date("Y-m-d H:i:s"));
		}
		/**
		*	Add an identified action of a user to db
		*	@access public
		*	@static
		*	@return void
		*	@param string $title - name of the action
		*	@param string $content - content or description of the action
		*	@param string $category - category of the action (for better management) (Default: null)
		*	@param int $id - if we are in a category that requires an ID provide it here
		*	@example Action::addAction('Forum post', 'Creative arts', 'forum', 12);
		*/
		public static function addAction($title, $content, $category = null, $id = 0){
			switch($category){
				case 'forum':
					$forum = new Forum();
					//tell each poster in the thread about this action as well
					foreach($forum->getPostersInThread($id) as $poster){
						if($poster != $_SESSION['ID']) $this->newAction($poster, $title, $content, $category);
					}
					break;
				case 'profile':
					$member = Members::getInstance();
					//tell all friends about this action as well
					foreach($member->getFriends($_SESSION['ID']) as $friend){
						$this->newAction($friend['ID'], $title, $content, $category);
					}
					break;
				case 'projects':
					$projects = new Projects();
					//tell all members in the project about this action as well
					foreach($projects->getMembers($id) as $member){
						if($member != $_SESSION['ID']) $this->newAction($member, $title, $content, $category);
					}
					break;
				case 'PM':
					//basically creating an action for one other person
					$this->newAction($id, $title, $content, $category);
					break;
				default:
					//only add action for current user
					$this->newAction($_SESSION['ID'], $title, $content, $category);
			}
		}
		
		/**
		*	Remove an action from the db
		*	@access public
		*	@static
		*	@return void
		*	@param int $id - id of the action
		*	@example Action::removeAction(297);
		*/
		public static function removeAction($id){
			Database::getInstance()->query("DELETE FROM `actions` WHERE `ID` = ?", $id);
		}
		
		/**
		*	Get an multidimensional assoc array of action
		*	@access public
		*	@static
		*	@return array - multidimensional assoc array of action
		*	@param int $begin - row to start at
		*	@param int $amount - amount of actions to get
		*	@param string $search - default false, are we searching for something, and what?
		*	@param string $by - default category, are we searching by title or by category?
		*	@example:
		*	//search all actions of session for the title 'test'
		*	Action::getActions($_SESSION['ID'], 0, Action::getNumActions(), 'Test');
		*/
		public static function getActions($user, $begin, $amount, $search = false, $by = 'title'){
			$execs = [$user]; //array or values to execute query with
			$query = "SELECT * FROM `actions` WHERE `ID` = ?"; //begin query
			//if we're searching choose correct column and use LIKE, add on to query
			if($search != false){
				$query .= " AND `".$by."` LIKE %?%"; //search might be from user so filter
				array_push($execs, $search); //add $search to execution array
			}
			$query .= " ORDER BY `date` LIMIT ".$begin.", ".$amount; //finish query
			$result = Database::getInstance()->query($query, $execs);
			return $result->fetchAll();
		}
		
		/**
		*	Get the number of actions stored from a user
		*	@access public
		*	@static
		*	@return int - number of actions
		*	@example Action::getNumActions($_SESSION['ID']);
		*/
		public static function getNumActions($user){
			$result = Database::getInstance()->query("SELECT COUNT(*) FROM `actions` WHERE `user` = ?", $user);
			return $result->fetchColumn(); //return number of affected rows
		}

		/**
		*	Let db know user read this action
		*	@access public
		*	@static
		*	@param int $id - id that was read
		*/
		public static function readAction($id){
			Database::getInstance()->query("UPDATE `actions` SET `read` = ? WHERE `ID` = ?", 1, $id);
		}
	}