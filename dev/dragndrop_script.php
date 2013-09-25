<?php
$_SERVER['DOCUMENT_ROOT'] .= '/infinity/dev';
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
mysql_select_db(SQL_DB)or die(mysql_error());

function getGroups(){
    $result = mysql_query("SELECT * FROM `groups` WHERE `creator` = '".$_SESSION['ID']."'")or die(mysql_error());
    $groups = array();
    while($row = mysql_fetch_array($result)){
        $group = $row['group'];
        array_push($groups, $group); //push all the groups into an array
    }
    if(isset($groups) && !empty($groups)){ //check if the groups array is set and not empty
        return json_encode($groups); //return json encoded array
    }else{
        return "no groups";
    }
}

function delete($item, $name){
    $item = mysql_real_escape_string(htmlspecialchars($item));
    $name = mysql_real_escape_string(htmlspecialchars($name));
    if($item == "group"){
    	$id = getID($name);
    	$result = mysql_query("DELETE FROM `groups` WHERE `group` = '".$name."' AND `creator` = '".$_SESSION['ID']."'")or die(mysql_error()); //delete group
    	$result2 = mysql_query("DELETE FROM `group_members` WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //delete members
    }
    else{
    	$id = getID($name);
    	$result = mysql_query("DELETE FROM `group_members` WHERE `group` = '".$id."' AND `member` = '".$name."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //delete members
    }
    if($result){
        return "success";
    }else{
        return "error";
    }
}

function createGroup($group, $members){
    $group = mysql_real_escape_string(htmlspecialchars($group));
    $members = mysql_real_escape_string(htmlspecialchars($members));
    $result = mysql_query("INSERT INTO groups (`group`, `creator`) VALUES ('".$group."', '".$_SESSION['ID']."')")or die(mysql_error()); //insert all the info for the group
    if($result){
        $id = getID($group);
        $result2 = mysql_query("INSERT INTO group_members (`groupId`,`member`,`groupCreator`) VALUES ('".$id."', '".$members."', '".$_SESSION['ID']."')")or die(mysql_error()); //insert all the info for the members
        if($result2){
        	return "Successfully created group and inserted members";
        }else{
        	return "error inserting members";
        }
    }else{
        return "error";
    }
}

function getMembers($group){
	$group = mysql_real_escape_string(htmlspecialchars($group));
	$id = getID($group);
    $result = mysql_query("SELECT * FROM `group_members` WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error()); //get the members
    if($result){
    	$members = array();
        while($row = mysql_fetch_array($result)){ //fetch all the rows in the table
            $member = $row['member'];
            array_push($members, $member); //push all members into the members array
        }
        if(isset($members) && !empty($members)){ //check if the members array is set and not empty
            return json_encode($members); //return json encoded array
        }else{
            return "no members";
        }
    }else{
        return "bad query";
    }
}

function editInfo($type, $name, $group){
	$name = mysql_real_escape_string(htmlspecialchars($name));
	$group = mysql_real_escape_string(htmlspecialchars($group));
	if($type == "member"){
		$id = getID($group);
		$result = mysql_query("UPDATE `group_members` SET `member` = '".$name."' WHERE `groupId` = '".$id."' AND `groupCreator` = '".$_SESSION['ID']."'")or die(mysql_error());
		if($result){
			return "success";
		}else{
			return "error";
		}
	}else if($type == "group"){
		$id = getID($group);
		$result = mysql_query("UPDATE `groups` SET `group` = '".$group."' WHERE `creator` = '".$_SESSION['ID']."' AND `id` = '".$id."'")or die(mysql_error());
		if($result){
			return "success";
		}else{
			return "error";
		}
	}else{
		return "unknown type: " . $type;
	}
}

function getID($group){
	$group = mysql_real_escape_string(htmlspecialchars($group));
	$getID = mysql_query("SELECT * FROM `groups` WHERE `group` = '".$group."'")or die(mysql_error()); //get the group id
	while($row = mysql_fetch_array($getID)){
		$id = $row['id'];
	}
	return $id;
}

if(isset($_POST['group']) && isset($_POST['members'])){
    echo createGroup($_POST['group'], $_POST['members']);
}else if(isset($_POST['get']) && $_POST['get'] == "groups"){
    echo getGroups();
}else if(isset($_POST['get']) && $_POST['get'] == "members" && isset($_POST['group'])){
    echo getMembers($_POST['group']);
}else if(isset($_POST['del']) && $_POST['del'] == "group" || $_POST['del'] == "member" && isset($_POST['name'])){
    echo delete($_POST['del'], $_POST['name']);
}else if(isset($_POST['edit']) && $_POST['edit'] == "member" || $_POST['edit'] == "group" && isset($_POST['name']) && isset($_POST['group'])){
	echo editInfo($_POST['edit'], $_POST['name'], $_POST['group']);
}else{
    die("error"); //if no requirements are met return error
}
?>
