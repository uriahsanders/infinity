<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD);
mysql_select_db(SQL_DB);
include_once($_SERVER['DOCUMENT_ROOT'].'/cms/cmsnav.html');
if(isset($_GET['empty']) && $_GET['empty'] == "yes"){
    echo "You must fill in all the parts.";
}
if(isset($_SESSION['usrdata']['screenname'])){
    $user = $_SESSION['usrdata']['screenname'];
}
$token = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
     ?>
<html>
<head>
<link href="/css/dark.css" rel="stylesheet" type="text/css" />
</head>
    <body><br /><br />
<div>
    <div id="newproject" style="text-align:left;"><br />
<div>
    <div id="main" style="text-align:left;margin-left:100px;">
    <b>Who wants this challenge done?</b><br /><br />
    <form action="" method="post">
        <input type="text" id="c" name="asker" />
    <br /><hr />
     <b>Why is this challenge important?</b><br /><br />
        <input type="text" id="c" name="importance" />
    <br /><hr />
    <b>How the hell do I join this thing? I want some MONEY!!!</b><br /><br />
        <input type="text" id="c" name="join" />
    <br /><hr />
        <b>What categories does your new challenge fall under?</b><br /><br />
    <input type="text" id="c" name="cats" />
    <hr />
        <b>Please check the minumum rank you would like to be able to join this challenge?</b><br /><br />
        <input type="radio" name="rank" value="members" />Members | <input type="radio" name="rank" value="elite" />Elite | <input type="radio" name="rank" value="vip" />VIP | <input type="radio" name="rank" value="staff" />Staff 
    <br /><hr />
    <b>Let's get to the point here....Whats the REWARD!!!!??????</b><br /><br />
    <input type="text" id="c" name="reward" />
    <br /><hr />
    <b>What is the name of this challenge?</b><br /><br />
    <input type="text" id="c" size="80" name="title" /><br /><hr />
    <b>Please provide a detailed description of the challenge.</b><br /><br />
    <textarea rows="10" columns="80" name="body"></textarea><br /><hr />
    <input type="submit" value="Create and Post New Project" id="startplan">
        <br /><br /><a href="/infinity/challenges.php?view=yes">View challenges</a>
    </form>
    <br /><br /><br /><br /><br /><br />   
</div>
</div>
</div>
</body>
    <?php 
if(isset($_POST['title']) && isset($_POST['body']) && isset($_POST['reward']) && isset($_POST['importance']) && isset($_POST['join']) && isset($_POST['rank']) && !isset($_GET['update']) && isset($_SESSION['token']) && !empty($_SESSION['token']) && preg_match("/infinity-forum\.org$/", $_SERVER['HTTP_HOST']) && preg_match("/infinity-forum\.org$/", $_SERVER['SERVER_NAME'])){
    if(empty($_POST['title']) or empty($_POST['body']) or empty($_POST['reward']) or empty($_POST['importance']) or empty($_POST['join']) or empty($_POST['rank'])){
        header("Location: challenges.php?empty=yes");
    }else{
        $title = mysql_real_escape_string(htmlspecialchars($_POST['title']));
        $body = mysql_real_escape_string(htmlspecialchars($_POST['body']));
        $reward = mysql_real_escape_string(htmlspecialchars($_POST['reward']));
        $importance = mysql_real_escape_string(htmlspecialchars($_POST['importance']));
        $join = mysql_real_escape_string(htmlspecialchars($_POST['join']));
        $asker = mysql_real_escape_string(htmlspecialchars($_POST['asker']));
        $rank = mysql_real_escape_string(htmlspecialchars($_POST['rank']));
        $date = date("Y-m-d g:i");
        $user = $_SESSION['usrdata']['screenname'];
        $result = mysql_query("INSERT INTO challenges(`title`, `description`, `reward`, `importance`, `join`, `asker`, `rank`, `date`) VALUES ('".$title."', '".$body."', '".$reward."', '".$importance."', '".$join."', '".$user."', '".$rank."', '".$date."')")or die(mysql_error());
        if($result){
            header("Location: /infinity/challenges.php");
        }else{
            echo "<font color='red'>Couldn't successfully post your challenge.</font>";
        }
    }
}
$getinfo = mysql_query("SELECT * FROM challenges ORDER BY `date` DESC")or die(mysql_error());
    while($row = mysql_fetch_array($getinfo)){
        $id = $row['id'];
        echo "<h2><a href='challenges.php?delete=yes&id=$id'>[X]</a> " . $row['title'] . " <a href='challenges.php?edit=yes&id=$id'>edit</a></h2>";
        echo $row['description'] . "<br />";
        echo $row['reward'] . "<br />";
        echo $row['importance'] . "<br />";
        echo $row['asker'] . "<br />";
    }
if(isset($_GET['edit']) && $_GET['edit'] == "yes" && isset($_GET['id'])){
    echo "</div>";
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $getchallenge = mysql_query("SELECT * FROM challenges WHERE `id` = '".$id."'")or die(mysql_error());
    while($row = mysql_fetch_array($getchallenge)){
        $title = $row['title'];
        $reward = $row['reward'];
        $importance = $row['importance'];
        $asker = $row['asker'];
        $join = $row['join'];
        $rank = $row['rank'];
        $body = $row['description'];
    echo '<div id="box" style="height:850px;text-align:center;position:relative;">
    <div id="newproject" style="text-align:center;">
<div id="box">
    <div id="head">Create New Challenge</div>
    <hr>
    Create a new challenge, this is an admin only form so you can figure the rest out yourself. HAHAHAHAHAHA! :D
    Good luck! Good luck! Boy, are you in for a RIIIIIDEEEEE!! Wow, im so bored :/</div>
    <br /><br /><br /><br /><br /><br /><br /><br />
    <div id="main" style="text-align:center;margin-left:100px;">
    <b>Who wants this challenge done?</b><br /><br />
    <form action="challenges.php?update=yes&id='.$id.'" method="post">
        <input type="text" id="c" name="asker" value="'.$asker.'" />
    <br /><hr />
     <b>Why is this challenge important?</b><br /><br />
        <input type="text" id="c" name="importance" value="'.$importance.'" />
    <br /><hr />
    <b>How the hell do I join this thing? I want some MONEY!!!</b><br /><br />
        <input type="text" id="c" name="join" value="'.$join.'" />
    <br /><hr />
    <b>What categories does your new challenge fall under?</b><br />
    <a href="#" class="cats" onclick="$(\'.dcats\').slideToggle();" style="font-weight:bold;font-size:1em;color:grey;">View Categories</a>
    <div class="dcats" style="display:none;"><br />Test</div>
    <hr />
        <b>Please check the minumum rank you would like to be able to join this challenge?</b><br /><br />
        <input type="radio" name="rank" value="members" />Members | <input type="radio" name="rank" value="elite" />Elite | <input type="radio" name="rank" value="vip" />VIP | <input type="radio" name="rank" value="staff" />Staff 
    <br /><hr />
    <b>Let\'s get to the point here....Whats the REWARD!!!!??????</b><br /><br />
    <input type="text" id="c" name="reward" value="'.$reward.'" />
    <br /><hr />
    <b>What is the name of this challenge?</b><br /><br />
    <input type="text" id="c" size="80" name="title" value="'.$title.'" /><br /><hr />
    <b>Please provide a detailed description of the challenge.</b><br /><br />
    <textarea rows="10" columns="80" name="body">'.$body.'</textarea><br /><hr />
    <input type="submit" value="Update Challenge" id="startplan">
    <br /><a href="challenges.php">Stop editing</a>
    </form>
    <br /><br /><br /><br /><br /><br />
    
</div>
</div>
</div>';
    }
}
if(isset($_GET['update']) && $_GET['update'] == "yes" && isset($_GET['id']) && isset($_POST['title']) && isset($_POST['body']) && isset($_POST['reward']) && isset($_POST['importance']) && isset($_POST['join']) && isset($user)){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $title = mysql_real_escape_string(htmlspecialchars($_POST['title']));
    $body = mysql_real_escape_string(htmlspecialchars($_POST['body']));
    $reward = mysql_real_escape_string(htmlspecialchars($_POST['reward']));
    $importance = mysql_real_escape_string(htmlspecialchars($_POST['importance']));
    $join = mysql_real_escape_string(htmlspecialchars($_POST['join']));
    $asker = mysql_real_escape_string(htmlspecialchars($_POST['asker']));
    $update = mysql_query("UPDATE challenges SET `title` = '".$title."', `description` = '".$body."', `reward` = '".$reward."', `importance` = '".$importance."', `join` = '".$join."', `asker` = '".$asker."' WHERE `id` = '".$id."'")or die(mysql_error());
    if($update){
        header("Location: challenges.php");
    }else{
        echo "Couldnt succesfully update the challenge.";
    }
}
if(isset($_GET['delete']) && $_GET['delete'] == "yes" && $_GET['id']){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $delete = mysql_query("DELETE FROM challenges WHERE `id` = '".$id."'")or die(mysql_error());
    if($delete){
        header("Location: challenges.php");
    }else{
        echo "<font color='red'>Couldn't succesfully delete your challenge.</font>";
    }
}
     ?>
</html>