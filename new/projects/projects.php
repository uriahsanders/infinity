<?php
//Projects page
class Projects{
	/*
	Projects Page SQL database structure: ("short" is short description)
	ID | projectname | creator | Date | Popularity | Members | short | description | category | image | video
	Projects Comments SQL database Structure:
	ID | projectID | date | posterID | body
	Workspace Data SQL database structure:
	ID | projectID | type | title | body | date | level | user | data | lastUser | branch
	*/
	//Ill just make all public stuff static because we only need one instance of Projects
	const LIMIT = 10; //how many results to retrieve
	public static $pdo = PDO();
	public static $date = date("Y:m:d"); //temp (we want our date to be consistent)
	public static function numProjects($userID){ //GET
		$sth = $pdo->prepare("SELECT COUNT(*) FROM `projects` WHERE `creator` = ?");
		$sth->execute([$userID]);
		return $sth->fetchColumn();
	}
	public static function search($key, $start = 0){ //GET
		//retrieve information neccesary for a thumbnail
		$sth = $pdo->prepare("SELECT (`ID`, `projectname`, `creator`, `date`, `popularity`, `short`, `image`) FROM `projects` WHERE `title` LIKE %?% ORDER BY `date` LIMIT ".$start.", ".self::LIMIT);
		$sth->execute([$key]);
		$res = [];
		foreach($sth->fetchAll(PDO::FETCH_NAMED) as $row){
			array_push($res, $row);
		}
		return $res;
	}
	//get one project
	public static function getOne($id){ //GET
		$sth = $pdo->prepare("SELECT * FROM `projects` WHERE `ID` = ?");
		$sth->execute([$id]);
		return $sth->fetch();
	}
	//get all projects in category
	public static function retrieve($category, $start = 0){ //GET
		//retrieve only information neccesary for a thumbnail
		$sth = $pdo->prepare("SELECT (`ID`, `projectname`, `creator`, `date`, `popularity`, `short`, `image`) FROM `projects` WHERE `category` = ? ORDER BY `date` LIMIT ".$start.", ".self::LIMIT);
		$sth->execute([$category]);
		$res = [];
		foreach($sth->fetchAll(PDO::FETCH_NAMED) as $row){
			array_push($res, $row);
		}
		return $res;
	}
	//create a new project
	public static function create($projectname, $short, $description, $image, $video){ //POST
		$sth = $pdo->prepare("INSERT INTO `projects` 
			(`projectname`, `creator`, `date`, `popularity`, `short`, `description`, `image`, `video`, `members`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?)
			");
		$sth->execute([$id, $projectname, $_SESSION['ID'], self::$date, 0, $short, $description, $image, $video, json_encode($creator)]);
	}
	public static function delete($id){ //POST
		$sth = $pdo->prepare("DELETE FROM `projects` WHERE `ID` = ? AND `creator` = ?");
		$sth->execute([$id, $_SESSION['ID']]);
	}
	public static function update($id, $projectname, $short, $description, $image, $video){ //POST
		$sth = $pdo->prepare("UPDATE `projects` SET 
			`projectname` = ?, `short` = ?, `description` = ?, `image` = ?, `video` = ?
			WHERE `ID` = ? AND `creator` = ?");
		$sth->execute([$projectname, $short, $description, $image, $video, $id, $_SESSION['ID']]);
	}
	public static function comment($id, $body){ //POST
		$sth = $pdo->prepare("INSERT INTO `projects_comments` (`projectID`, `date`, `posterID`, `body`)
			VALUES (?, ?, ?, ?)
			");
		$sth->execute($id, self::$date, $_SESSION['ID'], $body);
	}
	//viewing comments for a project
	public static function comments($id, $start = 0){ //GET
		$sth = $pdo->prepare("SELECT * FROM `projects_comments` WHERE `projectID` = ? ORDER BY `date` LIMIT ".$start.", ".self::LIMIT);
		$sth->execute([$id]);
		$res = [];
		foreach($sth->fetchAll(PDO::FETCH_NAMED) as $row){
			array_push($res, $row);
		}
		return $res;
	}
	//perhaps a bit misleading name. join() either removes or adds a member
	public static function join($projectID, $bool){ //POST
		//get members from project
		$sth = $pdo->prepare("SELECT `members` FROM `projects` WHERE `ID` = ?");
		$sth->execute([$projectID]);
		//either add user to members or delete from it
		$members = json_decode($sth->fetch()['members']);
		if($key = array_search($_SESSION['ID'], $members) >= 0){ //they are already a member
			if($bool == false){ //they want to leave
				unset($members[$key]);
			}
		}else{ //they are not yet a member
			if($bool == true){ //they want to join
				array_push($members, $_SESSION['ID']);
			}
		}
		//now insert members back into project
		$sth = $pdo->prepare("UPDATE `projects` SET `members` = ? WHERE `ID` = ?");
		$sth->execute([json_encode($members), $projectID]);
	}
	public static function load_more($num, $action, $category, $query, $projectID){ //GET
		//$num is the number of current results
		switch($action){
			case 'category':
				return self::retrieve($category, $num);
				break;
			case 'project':
				return self::comments($projectID, $num);
				break;
			case 'searching':
				return self::search($query, $num);
				break;
		}
	}
}