<?php
session_start();
require("connection.php");
$username = $_SESSION['usr'];
$result = mysql_query("SELECT * FROM messages WHERE `to` LIKE '".$username.",%' OR `to` LIKE '%,".$username."' OR `to` = '".$username."'") or die(mysql_error());
while($row = mysql_fetch_assoc($result)){
    $isread = $row['isread'];
}
?>
<html>
<head>
<script src="nicEdit.js"></script>
<script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<title>Inbox</title>
</head>
<body>
<nav>
<a href="pm.php">PM</a>
<a href="inbox.php?status=blocklist">View block list</a>
</nav>
<?php
if(isset($_GET['status']) && $_GET['status'] == "empty"){
    echo "<br /><font color='red'>Please fill in all the fields on the reply form.</font><br />";
}
if(isset($_GET['status']) && $_GET['status'] == "delete"){
    echo "<br /><font color='#00A300'>The message has been deleted!</font><br />";
}
if(isset($_GET['status']) && $_GET['status'] == "sent"){
    echo "<br /><font color='#00A300'>Your message has been sent!</font><br />";
}
if(isset($_GET['status']) && $_GET['status'] == "fail"){
    echo "<br /><font color='#CF0000'>Sorry, the action couldn't be completed.</font><br />";
}
if(isset($_GET['status']) && $_GET['status'] == "blocklist"){
    echo "<div style='display:none;'>";
}
$result = mysql_query("SELECT * FROM messages WHERE `to` LIKE '".$username.",%' OR `to` LIKE '%,".$username."' OR `to` = '".$username."'") or die(mysql_error());
if(empty($isread)){
    echo "<br /> <b>You don't have any messages in your inbox.</b>";
}else{
    while($row = mysql_fetch_assoc($result)){
        $id = $row['id'];
        $subjectarray = array($row['subject']);
        if(isset($_GET['status']) && $_GET['status'] == "view" && isset($_GET['id'])){
            echo "<div style='display:none;'>";
        }
        foreach($subjectarray as $subject){
            echo "<h2><a href='delete.php?id=$id'>[X]</a> <a href='inbox.php?status=view&id=$id'>" . $subject; if($isread == "no"){echo "<font color='green'>NEW!</font>";} echo "</a></h2>"; 
            if(isset($_GET['status']) && $_GET['status'] == "view" && isset($_GET['id'])){
                echo "</div>";
                $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
                $retrieve = mysql_query("SELECT * FROM messages WHERE `to` LIKE '".$username.",%' AND `id` = '".$id."' OR `to` LIKE '%,".$username."' AND `id` = '".$id."' OR `to` = '".$username."' AND `id` = '".$id."'") or die(mysql_error());
                while($row = mysql_fetch_assoc($retrieve)){
                    $subject = $row['subject'];
                    $body = $row['body'];
                    $from = $row['sentby'];
                    $date = $row['date'];
                    break;
                }
                $read = "yes";
                mysql_query("UPDATE messages SET `isread` = '".$read."' WHERE `to` LIKE '".$username.",%' AND `id` = '".$id."' OR `to` LIKE '%,".$username."' AND `id` = '".$id."' OR `to` = '".$username."' AND `id` = '".$id."' ") or die(mysql_error());
                if(isset($subject)){echo "<h2><a href='delete.php?id=$id'>[X]</a> <a href='inbox.php?status=view&id=$id'>" . $subject . "</a></h2>";}
                if(isset($body)){echo "Message: " . $body . "<br />";}
                if(isset($from)){echo "From: " . $from . " <a href='inbox.php?status=block&user=$from'>Block user</a><br />";}
                if(isset($date)){echo "Time Sent: " . $date . " <a href='inbox.php'>Close message</a> <br />";}else{echo "Message couldn't be found. Please try again. <div style='display:none;'>";}
                echo "<form action='reply.php?id=$id' method='post'>";
                echo "<br /><textarea name='reply' cols='85' rows='15' maxlength='5000' id='reply'></textarea><br />";
                echo "<input type='submit' value='Reply' />";
                echo "</form>";
                echo "</div>";
                echo "<div style='display:none;'>";
            }
        }
    }
    if(isset($_GET['status']) && $_GET['status'] == "block" && isset($_GET['user'])){
        $from = mysql_real_escape_string(htmlspecialchars($_GET['user']));
        $insert = mysql_query("INSERT INTO block(`blocker`, `blocked`) VALUES ('".$username."', '".$from."')")or die(mysql_error());
        if($insert){
            echo "<font color='green'>User successfullly blocked.</font>";
        }else{
            echo "<font color='red'>Sorry the block failed. Please try again later.</font>";
        }
    }
    if(isset($_GET['status']) && $_GET['status'] == "blocklist"){
        echo "</div>";
        echo "</div>";
        $retrieve = mysql_query("SELECT * FROM block WHERE `blocker` = '".$username."'")or die(mysql_error());
        $num = mysql_num_rows($retrieve);
        echo "<h2>Block List</h2>";
        if($num == 0){
                echo "You haven't blocked anyone.<br />";
            }else{
                while($row = mysql_fetch_assoc($retrieve)){
                    $blocked = $row['blocked'];
                    $id = $row['id'];
                    $userarray = array($blocked);
                    foreach($userarray as $blockeduser){
                        echo $blockeduser . " <a href='inbox.php?status=unblock&user=$blockeduser&id=$id'>Unblock</a><br />";
                    }
                }
            }
        echo "<a href='inbox.php'>Go back to inbox</a>";
    }
    if(isset($_GET['status']) && $_GET['status'] == "unblock" && $_GET['user'] && isset($_GET['id'])){
        $user = mysql_real_escape_string(htmlspecialchars($_GET['user']));
        $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
        $unblock = mysql_query("DELETE FROM block WHERE `blocker` = '".$username."' AND `blocked` = '".$user."' AND `id` = '".$id."'")or die(mysql_error());
        if($unblock){
            echo "<font color='green'>Sucesfully unblocked that user.</font>";
        }else{
            echo "<font color='red'>Couldn't succesfully unblock that person. Please try again later.</font>";
        }
    }
}
?>
</body>
</html>