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
    $query = $con->prepare("SELECT * FROM `groups` WHERE `creator` = :SID");
    $query->execute(array(
    ":SID" => $_SESSION['ID']
    ));
    $row = $query->fetchAll(PDO::FETCH_OBJ);
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
    if($item == "group"){
    	$id = getID($name, $con);
    	$query = $con->prepare("DELETE FROM `groups` WHERE `group` = :group AND `creator` = :SID")or die(mysql_error()); //delete group
    	$query2 = $con->prepare("DELETE FROM `group_members` WHERE `groupId` = :ID AND `groupCreator` = :SID")or die(mysql_error()); //delete members
    	$query->execute(array(
		":group" => $name,
		":SID" => $_SESSION['ID']
		));
    	$query2->execute(array(
    	":ID" => $id,
    	":SID" => $_SESSION['ID']
    	));
    	return "success";
    }
    else if($item == "member" && isset($_POST['group'])){
    	$id = getID($_POST['group'], $con);
    	$query = $con->prepare("DELETE FROM `group_members` WHERE `member` = '".$name."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //delete members
    	$query->execute(array(
    	":group" => $name,
    	":SID" => $_SESSION['ID']
    	));
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
    $query = $con->prepare("INSERT INTO groups (`group`, `creator`) VALUES ('".$group."', '".$_SESSION['ID']."')")or die(mysql_error()); //insert all the info for the group
    $query->execute(array(
    ":group" => $group,
    ":SID" => $_SESSION['ID']
    ));
    if($query){
        $id = getID($group, $con);
        $query2 = $con->prepare("INSERT INTO `group_members` (`groupId`,`member`,`groupCreator`) VALUES (:ID, :member, :SID)")or die(mysql_error()); //insert all the info for the members
        $query2->execute(array(
        ":ID" => $id,
        ":member" => $members,
        ":SID" => $_SESSION['ID']
        ));
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
	$id = getID($group, $con);
   	$result = $con->prepare("SELECT * FROM `group_members` WHERE `groupId` = :ID AND `groupCreator` = :SID")or die(mysql_error()); //get the group id
   	$result->execute(array(
   	":ID" => $id,
   	":SID" => $_SESSION['ID']
   	));
   	$members = array();
   	$query = $con->prepare("SELECT * FROM `group_members` WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'"); //get the members
   	$query->execute();
   	$row = $query->fetchAll(PDO::FETCH_OBJ);
   	for($i = 0; $i <= count($row) - 1; $i++){
   		@array_push($members, $row[$i]->member);
   	}
   	if(isset($members) && !empty($members)){
   		return json_encode($members);
   	}else{
   		return json_encode(array("no members"));
   	}
}

function editInfo($type, $name, $group, $con){
	if($type == "member"){
		$id = getID($group, $con);
		$query = $con->prepare("UPDATE `group_members` SET `member` = :member WHERE `groupId` = :ID AND `groupCreator` = :SID")or die(mysql_error()); //update member name
		$query->execute(array(
		":member" => $name,
		":ID" => $id,
		":SID" => $_SESSION['ID']
		));
		if($query){
			return "success";
		}else{
			return "error";
		}
	}else if($type == "group"){
		$id = getID($group, $con);
		$query = $con->prepare("UPDATE `groups` SET `group` = :group WHERE `creator` = :SID AND `id` = :ID")or die(mysql_error()); //update group name
		$query->execute(array(
		":group" => $group,
		":SID" => $_SESSION['ID'],
		":ID" => $id
		));
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
	$query = $con->prepare("SELECT * FROM `groups` WHERE `group` = :group AND creator = :SID");
	$query->execute(array(
	":group" => $group,
	":SID" => $_SESSION['ID']
	));
	$row = $query->fetch(PDO::FETCH_OBJ);
	return $row->id;
}

function copyMember($group, $member, $con){
	$id = getID($group, $con);
	$result = $con->prepare("INSERT INTO `group_members` (`groupCreator`, `groupId`, `member`) VALUES (:SID, :ID, :member)")or die(mysql_error()); //insert the info for the member
	$result->execute(array(
	":SID" => $_SESSION['ID'],
	":ID" => $id,
	":member" => $member
	));
	if($result){
		return "success";
	}else{
		return "error";
	}
}

function search($query, $con){
	$results = array();
	$sql = $con->prepare("SELECT * FROM `groups` WHERE `group` LIKE :query OR `group` = :query OR `group` LIKE '%".$query."' OR `group` LIKE '".$query."%' AND `creator` = :SID ORDER BY id DESC");
	$sql->execute(array(
	":query" => $query,
	":SID" => $_SESSION['ID']
	));
	$row = $sql->fetchAll(PDO::FETCH_OBJ);
	for($i = 0; $i <= count($row) - 1; $i++){
		@array_push($results, $row[$i]->group);
	}
	if(isset($results) && !empty($results)){
		return json_encode($results);
	}else{
		return json_encode(array("No results."));
	}
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
}else if(isset($_POST['del']) && isset($_POST['name']) && $_POST['del'] == "group" || $_POST['del'] == "member"){
    echo delete($_POST['del'], $_POST['name'], $con);
}else if(isset($_POST['edit']) && isset($_POST['group']) && isset($_POST['name']) && $_POST['edit'] == "member" || $_POST['edit'] == "group"){
	echo editInfo($_POST['edit'], $_POST['name'], $_POST['group'], $con);
}else{
    die("error"); //if no requirements are met return error
}
?>l
