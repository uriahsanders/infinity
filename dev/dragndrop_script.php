<?php
$_SERVER['DOCUMENT_ROOT'] .= '/infinity/dev';
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
mysql_select_db(SQL_DB)or die(mysql_error());

function getGroups(){
    $result = mysql_query("SELECT * FROM groups WHERE creator = '".$_SESSION['ID']."'")or die(mysql_error());
    $groups = array();
    while($row = mysql_fetch_array($result)){
        $group = $row['group'];
        array_push($groups, $group);
    }
    if(isset($groups) && !empty($groups)){
        return json_encode($groups);
    }else{
        return;
    }
}

function delete($item, $name){
    $item = mysql_real_escape_string(htmlspecialchars($item));
    $name = mysql_real_escape_string(htmlspecialchars($name));
    if($item == "group") $result = mysql_query("DELETE FROM groups WHERE group = '".$name."' AND creator = '".$_SESSION['ID']."'")or die(mysql_error());
    else $result = mysql_query("DELETE FROM groups WHERE member = '".$name."' AND creator = '".$_SESSION['ID']."'")or die(mysql_error());
    if($result){
        return "success";
    }else{
        return "error";
    }
}

function createGroup($group, $members){
    $group = mysql_real_escape_string(htmlspecialchars($group));
    $members = mysql_real_escape_string(htmlspecialchars($members));
    $result = mysql_query("INSERT INTO groups (`group`, `creator`, `members`) VALUES ('".$group."', '".$_SESSION['ID']."', '".$members."')")or die(mysql_error());
    if($result){
        return "success";
    }else{
        return "error";
    }
}

function getMembers($group){
    $result = mysql_query("SELECT * FROM groups WHERE group = '".$group."'")or die(mysql_error());
    if($result){
        while($row = mysql_fetch_array($result)){
            $members = $row['members'];
        }
        if(isset($members) && !empty($members)){
            return json_encode($members);
        }else{
            return;
        }
    }else{
        return "bad query";
    }
}

if(isset($_POST['group']) && isset($_POST['members'])){
    echo createGroup($_POST['group'], $_POST['members']);
}else if(isset($_POST['get']) && $_POST['get'] == "groups"){
    echo getGroups();
}else if(isset($_POST['del']) && $_POST['del'] == "group" || $_POST['del'] == "member" && isset($_POST['name'])){
    echo delete($_POST['del'], $_POST['name']);
}else if(isset($_POST['get']) && $_POST['get'] == "members"){
    echo getMembers($_POST['group']);
}else{
    die("error");
}
?>
