<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    //View Project options
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    $result = mysql_query("SELECT * FROM projects WHERE creator = '$_SESSION[usr]' OR invited = '$_SESSION[usr]'");
    while($row = mysql_fetch_array($result)){
        $name = $row['name'];
        $id = $row['id'];
        echo "<a href='workspace.php?id=\'".$id."\''>".$name."</a>";
    }
?>
<?php
//Workspace Stream
$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());
$username = $_SESSION['usr'];
$retrieve = mysql_query("SELECT * FROM projects WHERE `creator` = '".$username."' OR `invited` = '".$username."'")or die(mysql_error());
$num = mysql_num_rows($retrieve);
if($num == 0){
    echo "<b>No one has made any posts yet.</b>";
}else{
    while($row = mysql_fetch_array($retrieve)){
        $id = $row['id'];
        $title = $row['title'];
        $description = $row['description'];
        $creator = $row['creator'];
    }
    echo $title . "<br />";
    echo $description . "<br />";
    echo $creator . "<br />";
    echo "<a href='workspace.php?comments=show&id=$id'>Show comments</a><br />";
    if(isset($_GET['comments']) && $_GET['comments'] == "show" && isset($_GET['id'])){
        $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
        $comments = mysql_query("SELECT * FROM comments WHERE `id` = '".$id."'")or die(mysql_error());
        $num2 = mysql_num_rows($comments); 
        if($num2 == 0){
            echo "<b>There are no comments posted yet.</b>";
        }else{
            while($row = mysql_fetch_array($comments)){
                echo $row['comment'] . "<br />";
                echo "posted by: " . $row['user'] . "<br />";
            }
        }
        echo "<br /><a href='workspace.php'>Hide comments</a>";
    }
}
?>
<?php
//View assigned roles
$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());
$result = mysql_query("SELECT * FROM projects WHERE creator = '$_SESSION[usr]' OR invited = '$_SESSION[usr]'");
while($row = mysql_fetch_array($result)){
    $invited = $row['invited'];
    $role = $row['role'];
    $invid = $row['invitedid'];
    echo $invited." : ".$role."<a href='workspace.php?form=show&invitedid=$invid'> Change</a>";
}
?>
<?php
//Change assigned Roles
$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());
$result = mysql_query("SELECT * FROM projects WHERE creator = '$_SESSION[usr]' OR invited = '$_SESSION[usr]'");
while($row = mysql_fetch_array($result)){
    $invid = $row['invitedid'];
}
//Form
mysql_query("UPDATE projects SET role = '$role' WHERE invitedid = '$invid'");
?>
<?php
//View Statuses
$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());
$result = mysql_query("SELECT * FROM projects WHERE creator = '$_SESSION[usr]' OR invited = '$_SESSION[usr]'");
while($row = mysql_fetch_array($result)){
    $status = $row['status'];
    $invited = $row['invited'];
    echo $invited."<hr /><br />".$status."<br /><hr />";
}
?>
<?php
//Change Statuses
$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());
$result = mysql_query("SELECT * FROM projects WHERE creator = '$_SESSION[usr]' OR invited = '$_SESSION[usr]'");
while($row = mysql_fetch_array($result)){
    $invid = $row['invitedid'];
}
//Form
mysql_query("UPDATE projects SET status = '$status' WHERE invitedid = '$invid'");
?>
<?php
//View tasks
?>

echo '
            <div style="top:35px;right:5px;position:absolute;"><img src="/images/image.php?id='".$_SESSION['usrdata']['usr_img'].'" id=profileimage"></div> 
            &nbsp;<div style="top:35px;position:absolute;right:50px;"> Welcome <span style="color:rgb(63, 98, 143);font-weight: bold;">'.$_SESSION['usrdata']['screenname'].'</span>';
        echo ($_SESSION['admin'] == 1) ? '<span style="font-weight: bold;font-size:1.1em;position:relative;padding-top:2px;"title="Admin Options"><a href="/member/admin.php"><img style="padding-left:4px;max-height:19px;max-width:24px;"src="/images/trollking.png"></a></span>' : '' ;
        echo '    <br />
         <a style="right:75px;top:20px;position:absolute;"href="/accsummary.php">Profile</a> &nbsp; 
         <a style="right:25px;top:20px;position:absolute;"href="/member/logout.php">Logout</a></div>';
<!--
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
IM AM SO AWESOME GUYS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-->
<script>
//Projects
//Ex.onclick="retrieve(category, technology);" //Will return the tech cat
//type is either category, username, featured, popular, *date, completed, created
//name is either categoryName, sessionusr, true/false, xxx, initialsearch, true/false, friend/me
//for search by friends retrieve(friends, $_SESSION['usr'])
//for your projects retrieve(creator, $_SESSION['usr'])
function retrieve($type, $name){
    $.post('script.php', {type: $type, name: $name}, function(data){  //send type and name to script.php
        $("#main").html(data); //replace data in main area with retrieved 
    });
}
</script>
<?php
if(isset($_POST['type']) && isset($_POST['name']) && $_POST['type'] != "friends"){
    $type = cleanQuery($_POST['type']);
    $name = cleanQuery($_POST['name']);
    if($_POST['type'] = "creator"){
        mysql_query("SELECT * FROM projects WHERE $type = '$name' AND invited = '$name'"); //get all projects based on the parameters
    }else{
        mysql_query("SELECT * FROM projects WHERE $type = '$name'"); //get all projects based on the parameters
    }
}
//default main query
mysql_query("SELECT * FROM projects WHERE completed = 'false'");
//dual query to retrieve projects from friends
if(isset($_POST['type']) && isset($_POST['name']) && $_POST['type'] = "friends"){
    $type = cleanQuery($_POST['type']);
    $name = cleanQuery($_POST['name']);
    $retrieve = mysql_query("SELECT * FROM friends WHERE id = '$name'");
    if(mysql_num_rows($retrieve) == 0) echo "You have no friends yet.";
        else{
            while($row = mysql_fetch_assoc($retrieve)){
                foreach($row as $key => $value){
                    mysql_query("SELECT * FROM projects WHERE creator = '".$value."'");
                }
            }
        }
}
//for popularity, we need to add +1 to the db table with each action towards that project
//Database setup
//Name | creator | invited 

//ADD INTO MAIN php
function verify($who, $project_name){
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    $list = mysql_query("SELECT invited FROM projects WHERE name = '$project_name'", $con)or die(mysql_error());
    $new_list = $list.$who;
    mysql_query("UPDATE projects SET invited = '$new_list' WHERE name = '$project_name'", $con)or die(mysql_error());
    mysql_close($con);
}
?>



























?>
<?php
//End.
?>