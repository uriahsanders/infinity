<?php
$_SERVER['DOCUMENT_ROOT'] .= '/infinity/dev';
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

try{
	$con = new PDO("mysql:host=" . SQL_SERVER . ";dbname=" . SQL_DB, SQL_USR, SQL_PWD); //make the pdo connection
}catch(PDOException $e){ //check for an error
	die($e->getMessage());
}

function getGroups($con){
    $groups = array();
    $query = $con->prepare("SELECT * FROM `groups` WHERE `creator` = '".$_SESSION['ID']."'");
    $query->execute();
    $row = $query->fetchAll(PDO::FETCH_OBJ);
    //return json_encode($row[0]->group);\
    if(isset($row) && !empty($row)){
   		for($i = 0; $i <= count($row) - 1; $i++){
    		@array_push($groups, $row[$i]->group);
    	}
    	return json_encode($groups);
    }else{
    	return json_encode(array("no groups"));
    }
}

function delete($item, $name, $con){
    $item = mysql_real_escape_string(htmlspecialchars($item));
    $name = mysql_real_escape_string(htmlspecialchars($name));
    if($item == "group"){
    	$id = getID($name, $con);
    	$query = $con->prepare("DELETE FROM `groups` WHERE `group` = '".$name."' AND `creator` = '".$_SESSION['ID']."'")or die(mysql_error()); //delete group
    	$query2 = $con->prepare("DELETE FROM `group_members` WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //delete members
    	$query->execute();
    	$query2->execute();
    	return "success";
    }
    else if($item == "member" && isset($_POST['group'])){
    	$group = mysql_real_escape_string(htmlspecialchars($_POST['group']));
    	$id = getID($group, $con);
    	$query = $con->prepare("DELETE FROM `group_members` WHERE `member` = '".$name."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //delete members
    	$query->execute();
    	if($query){
    	    return "success";
    	}else{
    	    return "error";
    	}
    }else{
    	return "unknown type: " . $item;
    }
}

function createGroup($group, $members, $con){
    $group = mysql_real_escape_string(htmlspecialchars($group));
    $members = mysql_real_escape_string(htmlspecialchars($members));
    $query = $con->prepare("INSERT INTO groups (`group`, `creator`) VALUES ('".$group."', '".$_SESSION['ID']."')")or die(mysql_error()); //insert all the info for the group
    $query->execute();
    if($query){
        $id = getID($group, $con);
        $query2 = $con->prepare("INSERT INTO `group_members` (`groupId`,`member`,`groupCreator`) VALUES ('".$id."', '".$members."', '".$_SESSION['ID']."')")or die(mysql_error()); //insert all the info for the members
        $query2->execute();
        if($query2){
        	return "Successfully created group and inserted members";
        }else{
        	return "error inserting members";
        }
    }else{
        return "error";
    }
}

function getMembers($group, $con){
	$group = mysql_real_escape_string(htmlspecialchars($group));
	$id = getID($group, $con);
   	$result = $con->prepare("SELECT * FROM `group_members` WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //get the member
   	$result->execute();
   	$members = array();
   	$query = $con->prepare("SELECT * FROM `group_members` WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'");
   	$query->execute();
   	$row = $query->fetchAll(PDO::FETCH_OBJ);
   	for($i = 0; $i <= count($row) - 1; $i++){
   		@array_push($members, $row[$i]->member);
   	}
   	return json_encode($members);
}

function editInfo($type, $name, $group, $con){
	$group = mysql_real_escape_string(htmlspecialchars($group));
	$name = mysql_real_escape_string(htmlspecialchars($name));
	if($type == "member"){
		$id = getID($group, $con);
		$query = $con->prepare("UPDATE `group_members` SET `member` = '".$name."' WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //update member name
		$query->execute();
		if($query){
			return "success";
		}else{
			return "error";
		}
	}else if($type == "group"){
		$id = getID($group, $con);
		$query = $con->prepare("UPDATE `groups` SET `group` = '".$name."' WHERE `creator` = '".$_SESSION['ID']."' AND `id` = '".$id."'")or die(mysql_error()); //update group name
		$query->execute();
		if($query){
			return "success";
		}else{
			return "error";
		}
	}else{
		return "unknown type: " . $type;
	}
}

function getID($group, $con){
	$group = mysql_real_escape_string(htmlspecialchars($group));
	$query = $con->prepare("SELECT * FROM `groups` WHERE `group` = '".$group."' AND creator = '".$_SESSION['ID']."'");
	$query->execute();
	$row = $query->fetch(PDO::FETCH_OBJ);
	return $row->id;
}

function copyMember($group, $member, $con){
	$group = mysql_real_escape_string(htmlspecialchars($group));
	$member = mysql_real_escape_string(htmlspecialchars($member));
	$id = getID($group, $con);
	$result = $con->prepare("INSERT INTO `group_members` (`groupCreator`, `groupId`, `member`) VALUES ('".$_SESSION['ID']."', '".$id."', '".$member."')")or die(mysql_error()); //insert the info for the member
	$result->execute();
	if($result){
		return "success";
	}else{
		return "error";
	}
}

function search($query, $con){
	$query = mysql_real_escape_string(htmlspecialchars($query));
	$results = array();
	$sql = $con->prepare("SELECT * FROM `groups` WHERE `group` LIKE '".$query."' OR `group` = '".$query."' OR `group` LIKE '%".$query."' OR `group` LIKE '".$query."%' AND `creator` = '".$_SESSION['ID']."' ORDER BY id DESC");
	$sql->execute();
	$row = $sql->fetchAll(PDO::FETCH_OBJ);
	for($i = 0; $i <= count($row) - 1; $i++){
		@array_push($results, $row[$i]->group);
	}
	return json_encode($results);
	/*foreach($con->query("SELECT * FROM `groups` WHERE `group` LIKE '".$query."' OR `group` = '".$query."' OR `group` LIKE '%".$query."' OR `group` LIKE '".$query."%' AND `creator` = '".$_SESSION['ID']."' ORDER BY id DESC") as $row){
		$group = $row['group'];
		array_push($results, $group); //put all results into an array
	}
	if(isset($results) && !empty($results)){
		return json_encode($results); //return results
	}else{
		return json_encode(array("No results."));
	}*/
}

if(isset($_POST['group']) && isset($_POST['members'])){
	define("LAST_GROUP", $_POST['group']); //define the last group made
    echo createGroup($_POST['group'], $_POST['members'], $con);
}else if(isset($_POST['get']) && $_POST['get'] == "groups"){
    echo getGroups($con);
}else if(isset($_POST['get']) && $_POST['get'] == "members" && isset($_POST['group'])){
    echo getMembers($_POST['group'], $con);
}else if(isset($_POST['group']) && isset($_POST['member']) && isset($_POST['do']) == "copy"){
	echo copyMember($_POST['group'], $_POST['member'], $con);
}else if(isset($_POST['query'])){
	echo search($_POST['query'], $con);
}else if(@isset($_POST['del']) && $_POST['del'] == "group" || $_POST['del'] == "member" && isset($_POST['name'])){
    echo delete($_POST['del'], $_POST['name'], $con);
}else if(@isset($_POST['edit']) && $_POST['edit'] == "member" || $_POST['edit'] == "group" && isset($_POST['group']) && isset($_POST['name'])){
	echo editInfo($_POST['edit'], $_POST['name'], $_POST['group'], $con);
}else{
    die("error"); //if no requirements are met return error
}
?>l
