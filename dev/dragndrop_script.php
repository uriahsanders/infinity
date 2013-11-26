<?php
$_SERVER['DOCUMENT_ROOT'] .= '/infinity/dev';
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

try{
	$con = new PDO("mysql:host=" . SQL_SERVER . ";dbname=" . SQL_DB, SQL_USR, SQL_PWD); //make the pdo connection
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}catch(PDOException $e){ //check for an error
	die($e->getMessage());
}

function getGroups($con){
    $groups = array();
    $query = $con->prepare("SELECT * FROM `groups` WHERE `creator` = :SID ORDER BY id DESC");
    $query->execute(array(
    ":SID" => $_SESSION['ID']
    ));
    $row = $query->fetchAll(PDO::FETCH_OBJ);
    if(isset($row) && !empty($row)){
   		for($i = 0; $i < count($row); $i++){
    		array_push($groups, $row[$i]->group);
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
    	if($query && $query2){
    		return "success";
    	}else{
    		return "error";
    	}
    }
    else if($item == "member" && isset($_POST['group'])){
    	$id = getID($_POST['group'], $con);
    	$query = $con->prepare("DELETE FROM `group_members` WHERE `member` = :member AND `groupCreator` = :SID")or die(mysql_error()); //delete members
    	$query->execute(array(
    	":member" => $name,
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

function createGroup($group, $con){
    $query = $con->prepare("INSERT INTO groups (`group`, `creator`) VALUES (:group, :SID)")or die(mysql_error()); //insert all the info for the group
    $query->execute(array(
    ":group" => $group,
    ":SID" => $_SESSION['ID']
    ));
    if($query){
        return "sucess";
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
   	$query = $con->prepare("SELECT * FROM `group_members` WHERE `groupId` = :ID AND `groupCreator` = :SID"); //get the members
   	$query->execute(array(
   	":ID" => $id,
   	":SID" => $_SESSION['ID']
   	));
   	$row = $query->fetchAll(PDO::FETCH_OBJ);
   	for($i = 0; $i < count($row) - 1; $i++){
   		array_push($members, $row[$i]->member);
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
		":group" => $name,
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
	try{
		$query = $con->prepare("SELECT * FROM `groups` WHERE `group` = :group AND creator = :SID");
		$query->execute(array(
		":group" => $group,
		":SID" => $_SESSION['ID']
		));
		$row = $query->fetch(PDO::FETCH_OBJ);
		return $row->id;
	}catch(PDOException $e){
		return $e->getMessage();
	}
}

function copyMember($group, $member, $con){
	$id = getID($group, $con);
	try{
		$result = $con->prepare("INSERT INTO `group_members` (`groupCreator`, `groupId`, `member`) VALUES (:SID, :ID, :member)"); //insert the info for the member
		$result->execute(array(
		":SID" => $_SESSION['ID'],
		":ID" => $id,
		":member" => $member
		));
	}catch(PDOException $e){
		return $e->getMessage();
	}
	if($result){
		return "success";
	}else{
		return "error";
	}
}

function search($query, $what, $con){
	if($what == "groups"){
		$results = array();
		$sql = $con->prepare("SELECT * FROM `groups` WHERE `group` = :query OR `group` LIKE :likeQuery AND `creator` = :SID ORDER BY id DESC");
		$sql->execute(array(
		":query" => $query,
		":likeQuery" => '%' . $query . '%',
		":SID" => $_SESSION['ID']
		));
		$row = $sql->fetchAll(PDO::FETCH_OBJ);
		for($i = 0; $i < count($row); $i++){
			array_push($results, $row[$i]->group);
		}
		if(isset($results) && !empty($results)){
			return json_encode($results);
		}else{
			return json_encode(array("No results."));
		}
	}else{
		$contacts = array();
		$sql = $con->prepare("SELECT * FROM `friends` WHERE `friend` = :contact OR `friend` LIKE :likeQuery AND `id` = :SID");
		$sql->execute(array(
		":SID" => $_SESSION['ID'],
		":contact" => $query,
		":likeQuery" => '%' . $query . '%'
		));
		$row = $sql->fetchAll(PDO::FETCH_OBJ);
		for($i = 0; $i < count($row); $i++){
			array_push($contacts, id2user($row[$i]->friend));
		}
		if(isset($contacts) && !empty($contacts)){
			return json_encode($contacts);
		}else{
			return json_encode(array("No results."));
		}
	}
}

function getContacts($con){
	$query = $con->prepare("SELECT * FROM friends WHERE `id` = :SID");
	$query->execute(array(
	":SID" => $_SESSION['ID']
	));
	$contacts = array();
	$row = $query->fetchAll(PDO::FETCH_OBJ);
	for($i = 0; $i < count($row); $i++){
		array_push($contacts, id2user($row[$i]->friend));
	}
	if(isset($contacts) && !empty($contacts)){
		return json_encode($contacts);
	}else{
		return json_encode(array("No contacts"));
	}
}

function getInfo($what, $name, $con){
	if($what == "group"){
		$query = $con->prepare("SELECT * FROM `groups` WHERE `group` = :group AND `creator` = :SID");
		$query->execute(array(
		":group" => $name,
		":SID" => $_SESSION['ID']
		));
		$row = $query->fetchAll(PDO::FETCH_OBJ);
		$info = array();
		for($i = 0; $i < count($row); $i++){
			array_push($info, $row[$i]);
		}
		if(isset($info) && !empty($info)){
			return json_encode($info);
		}else{
			return json_encode(array("error"));
		}
	}else{
		$id = id2user($name, "user2id");
		$query = $con->prepare("SELECT * FROM `members` WHERE `id` = :ID");
		$query->execute(array(
		":ID" => $id
		));
		$row = $query->fetchAll(PDO::FETCH_OBJ);
		$userinfo = array($row[0]->username, $row[0]->email, $row[0]->date);
		if(!empty($userinfo) && isset($userinfo)){
			return json_encode($userinfo);
		}else{
			return json_encode(array("error"));
		}
	}
}

if(isset($_POST['group']) && isset($_POST['do']) && $_POST['do'] == "create"){
    echo createGroup($_POST['group'], $con);
}else if(isset($_POST['get']) && $_POST['get'] == "groups"){
    echo getGroups($con);
}else if(isset($_POST['get']) && isset($_POST['group']) && $_POST['get'] == "members"){
    echo getMembers($_POST['group'], $con);
}else if(isset($_POST['group']) && isset($_POST['member']) && isset($_POST['do']) && $_POST['do'] == "copy"){
	echo copyMember($_POST['group'], $_POST['member'], $con);
}else if(isset($_POST['query']) && isset($_POST['what'])){
	echo search($_POST['query'], $_POST['what'], $con);
}else if(isset($_POST['del']) && isset($_POST['name']) && @$_POST['del'] == "group" || @$_POST['del'] == "member"){
    echo delete($_POST['del'], $_POST['name'], $con);
}else if(isset($_POST['edit']) && isset($_POST['group']) && isset($_POST['name']) && @$_POST['edit'] == "member" || @$_POST['edit'] == "group"){
	echo editInfo($_POST['edit'], $_POST['name'], $_POST['group'], $con);
}else if(isset($_POST['get']) && $_POST['get'] == "contacts"){
	echo getContacts($con);
}else if(isset($_POST['what']) && isset($_POST['name'])){
	echo getInfo($_POST['what'], $_POST['name'], $con);
}else{
    die("error"); //if no requirements are met return error
}
?>l
