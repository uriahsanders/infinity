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
    foreach($con->query("SELECT * FROM `groups` WHERE `creator` = '".$_SESSION['ID']."'") as $row){
   		$group = $row['group'];
   	 	/*if(@defined(LAST_GROUP) && LAST_GROUP != $group){
   	  		array_push($groups, $group);	
   	  	}else{
		   	array_push($groups, $group);
		}*/
		array_push($groups, $group);
    }
   	if(isset($groups) && !empty($groups)){ //check if the groups array is set and not empty
        return json_encode($groups); //return json encoded array
    }else{
    	return json_encode(array("no groups"));
   	}
}

function delete($item, $name, $con){
    $item = mysql_real_escape_string(htmlspecialchars($item));
    $name = mysql_real_escape_string(htmlspecialchars($name));
    if($item == "group"){
    	$id = getID($name, $con);
    	$result = $con->query("DELETE FROM `groups` WHERE `group` = '".$name."' AND `creator` = '".$_SESSION['ID']."'")or die(mysql_error()); //delete group
    	$result2 = $con->query("DELETE FROM `group_members` WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //delete members
    	return "success";
    }
    else if($item == "member" && isset($_POST['group'])){
    	$group = mysql_real_escape_string(htmlspecialchars($_POST['group']));
    	$id = getID($group, $con);
    	$result = $con->query("DELETE FROM `group_members` WHERE `member` = '".$name."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //delete members
    	if($result){
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
    $result = $con->query("INSERT INTO groups (`group`, `creator`) VALUES ('".$group."', '".$_SESSION['ID']."')")or die(mysql_error()); //insert all the info for the group
    if($result){
        $id = getID($group, $con);
        $result2 = $con->query("INSERT INTO `group_members` (`groupId`,`member`,`groupCreator`) VALUES ('".$id."', '".$members."', '".$_SESSION['ID']."')")or die(mysql_error()); //insert all the info for the members
        if($result2){
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
   	$result = $con->query("SELECT * FROM `group_members` WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //get the member
   	$members = array();
   	foreach($con->query("SELECT * FROM `group_members` WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'") as $row){ //fetch all the rows in the table
   		$member = $row['member'];
   	    array_push($members, $member); //push all members into the members array
   	}
   	if(isset($members) && !empty($members)){ //check if the members array is set and not empty
   		return json_encode($members); //return json encoded array
	}else{
        return json_encode(array("no members"));
    }
}

function editInfo($type, $name, $group, $con){
	$group = mysql_real_escape_string(htmlspecialchars($group));
	$name = mysql_real_escape_string(htmlspecialchars($name));
	if($type == "member"){
		$id = getID($group, $con);
		$result = $con->query("UPDATE `group_members` SET `member` = '".$name."' WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //update member name
		if($result){
			return "success";
		}else{
			return "error";
		}
	}else if($type == "group"){
		$id = getID($group, $con);
		$result = $con->query("UPDATE `groups` SET `group` = '".$name."' WHERE `creator` = '".$_SESSION['ID']."' AND `id` = '".$id."'")or die(mysql_error()); //update group name
		if($result){
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
	$getID = $con->query("SELECT * FROM `groups` WHERE `group` = '".$group."'")or die(mysql_error()); //get the group id
	foreach($con->query("SELECT * FROM `groups` WHERE `group` = '".$group."'") as $row){
		$id = $row['id'];
	}
	return $id;
}

function copyMember($group, $member, $con){
	$group = mysql_real_escape_string(htmlspecialchars($group));
	$member = mysql_real_escape_string(htmlspecialchars($member));
	$id = getID($group, $con);
	$result = $con->query("INSERT INTO `group_members` (`groupCreator`, `groupId`, `member`) VALUES ('".$_SESSION['ID']."', '".$id."', '".$member."')")or die(mysql_error()); //insert the info for the member
	if($result){
		return "success";
	}else{
		return "error";
	}
}

function search($query, $con){
	$query = mysql_real_escape_string(htmlspecialchars($query));
	$results = array();
	foreach($con->query("SELECT * FROM `groups` WHERE `group` LIKE '".$query."' OR `group` = '".$query."' OR `group` LIKE '%".$query."' OR `group` LIKE '".$query."%' AND `creator` = '".$_SESSION['ID']."' ORDER BY id DESC") as $row){
		$group = $row['group'];
		array_push($results, $group); //put all results into an array
	}
	if(isset($results) && !empty($results)){
		return json_encode($results); //return results
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
}else if(isset($_POST['del']) && $_POST['del'] == "group" || $_POST['del'] == "member" && isset($_POST['name'])){
    echo delete($_POST['del'], $_POST['name'], $con);
}else if(isset($_POST['edit']) && $_POST['edit'] == "member" || $_POST['edit'] == "group" && isset($_POST['group']) && isset($_POST['name'])){
	echo editInfo($_POST['edit'], $_POST['name'], $_POST['group'], $con);
}else{
    die("error"); //if no requirements are met return error
}
?>l
