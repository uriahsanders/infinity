<?php
	/*
		Allways do a defined("INFINITY") check for all files, this is for security, ever though its just a class in the file and does not output anything
		Else then that this file looks clean, I would not call SESSION[ID] as default but do that in the function, one extra line yes but a chanse to catch later on.
		Try using a tad more blank lines so its easier to read between function and dockblock.
		Also maybe use [TAB] between the text and the star in dockblock so its easier to read.
		
		I don't know whare and what data you use in getMemberData but that looks risky as fuck for injections.
		How about fetching all data with select * and then only returning the specified?
		
		yes right now we need to use ?'s I'll recode so you can use array keys as well. like
		Query("SELCT * FROM ? WHERE username=:user AND password=:password", "members", [":user"=>"relax", ":password"=>"Test123"]); 
		
		You can move this file to clean and include it in relax.php when you feel for it.
		
		/Relax
	*/
	
	
	/**
	*Profile interface
	*/
	interface iProfile{
		public function getMemberData($columns, $user);
		public function setMemberData($columns, $user);
	}
	
	/**
	*Class for profile page related methods
	*Getting and Setting member data
	*Table: `memberinfo`
	*/
	class Profile implements iProfile{
		private $sql; //SQL call handler
		private $table = '`memberinfo`';
		
		public function __construct(){
			$this->sql = Database::getInstance();
		}
		
		/**
		*Give an array of columns to get back their values for given user
		*@access public
		*@return assoc array - 'column' => 'value' of given $columns
		*@param array $columns - which columns to retrieve from db
		*@param int $user - ID of user (default: $_SESSION['ID'])
		*@example $profile->getMemberData(['location', 'username', 'ID']);
		*/
		public function getMemberData($columns, $user = $_SESSION['ID']){
			$cols = implode('`, `', $columns); //join array with back ticks and commas
			$result = $this->sql->query("SELECT `".$cols."` FROM ".$table." WHERE `ID` = ?", $user);
			return $result->fetch(); //return associative array of 'column' => 'value'
		}
		
		/**
		*Give a key => value array (assoc array) of 'columnName' => 'newValue' and make change in db
		*@access public
		*@return void
		*@param assoc array $columns: 'column' => 'value'
		*@param int $user - ID of user (default: $_SESSION['ID'])
		*@example $profile->setMemberData(['location' => 'US', 'username' => 'Uriah', 'ID' => 3]);
		*/
		public function setMemberData($columns, $user = $_SESSION['ID']){
			$query = "UPDATE ".$table." SET";
			$newValues = []; //we need to use ?'s, so lets store actual values here in order
			$i = -1; //so we can know our numerical index
			$len = count($columns);
			foreach($columns as $key => $value){
				++$i;
				$query .= " `".$key."` = ?";
				if($i != $len - 1) $query .= ', '; //add a comma and space unless this is our last element
				array_push($newValues, $value); //log the value corresponding to above "?"
			}
			array_push($newValues, $user); //$user is final argument for execution array
			$this->sql->query($query." WHERE `ID` = ?", $newValues);
		}
	}
	
	/**
	*Storing and removing actions of members
	*Table: `actions`, (search & replace this to change all (no instance data 'cause static methods))
	*Columns: `ID`, `user`, `title`, `content`, `category`, `date`
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
	}