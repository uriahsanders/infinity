<?php
include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");

if (isset($_POST['action']) && ($_POST['action']=="plus" || $_POST['action']=="minus") && preg_match('/([0-9_]*)/',$_POST['id'])) {
    $pm = ($_POST['action']=="plus") ? "p" : "m";  
    $con = SQL_connect();
    SQL_selectDB($con);
    $time = time() - (60 * 60);
    $postID = substr($_POST['id'],0,strpos($_POST['id'],"_"));
    $usrID = substr($_POST['id'],strpos($_POST['id'],"_")+1);
    if ($_SESSION['ID'] == $usrID) { echo "You can't use a karma action on yourself"; die();}
    $res = mysql_query("SELECT ID FROM karma WHERE `1`='$_SESSION[ID]' AND `2`='$usrID' AND `time`>'$time'") or die(mysql_error());
    if (mysql_num_rows($res) != 0) { echo "You can only make one karma action per hour, per user"; die();}
    $res = mysql_query("SELECT ID FROM karma WHERE `1`='$_SESSION[ID]' AND `2`='$usrID' AND `post`='$postID'") or die(mysql_error());
    if (mysql_num_rows($res) != 0) { echo "You can't make more then one karma action per post"; die();}
    $res = mysql_query("SELECT * FROM forum WHERE `ID`='$postID' and `by`='$usrID'") or die(mysql_error());
    if (mysql_num_rows($res) == 0) { echo "That post ID does not belong to that user, Your activity has been saved and we will look into it"; logg_act(); die();}
    $res = mysql_query("INSERT INTO karma (`1`,`2`,`time`,`pm`,`post`) VALUES ('$_SESSION[ID]','$usrID','".time()."','$pm','$postID')") or die(mysql_error());
    if ($res) echo "done"; else echo "fail";
    mysql_close($con);
}
?>