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
		/**
		*Add an identified action of a user to db
		*@access public
		*@static
		*@return void
		*@param string $title - name of the action
		*@param string $content - content or description of the action
		*@param string $category - category of the action (for better management) (Default: null)
		*@example Action::addAction('Forum post', 'Creative arts', 'Forum');
		*/
		public static function addAction($title, $content, $category = null){
			$date = date("Y-m-d"); //temp
			Database::getInstance()->query("INSERT INTO `actions` (`user`, `title`, `content`, `category`, `date`) VALUES (?, ?, ?, ?, ?)",
			 $_SESSION['ID'], $title, $content, $category, $date);
		}
		
		/**
		*Remove an action from the db
		*@access public
		*@static
		*@return void
		*@param int $id - id of the action
		*@example Action::removeAction(297);
		*/
		public static function removeAction($id){
			Database::getInstance()->query("DELETE FROM `actions` WHERE `ID` = ?", $id);
		}
		
		/**
		*Get an multidimensional assoc array of action
		*@access public
		*@static
		*@return array - multidimensional assoc array of action
		*@param int $begin - row to start at
		*@param int $amount - amount of actions to get
		*@param string $search - default false, are we searching for something, and what?
		*@param string $by - default category, are we searching by title or by category?
		*@example Action::getActions(0, Action::getNumActions(), 'Test'); //search all actions for the title 'test'
		*/
		public static function getActions($begin, $amount, $search = false, $by = 'title', $user = $_SESSION['ID']){
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
		*Get the number of actions stored from a user
		*@access public
		*@static
		*@return int - number of actions
		*@example Action::getNumActions();
		*/
		public static function getNumActions($user = $_SESSION['ID']){
			$result = Database::getInstance()->query("SELECT `ID` FROM `actions` WHERE `user` = ?", $user);
			return $result->fetchColumn(); //return number of affected rows
		}

		/**
		*Let db know user read this action
		*@access public
		*@static
		*@return 1 for success else error
		*@param int $id - id that was read
		*/
		public static function readAction($id){
			Database::getInstance()->query("UPDATE `actions` SET `read` = ? WHERE `ID` = ?", 1, $id);
			return 1;
		}
	}