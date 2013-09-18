<?php
session_start();
if(isset($_POST['comment']) && isset($_POST['blog']) && isset($_GET['id'])){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $comment = mysql_real_escape_string(htmlspecialchars($_POST['comment']));
    $date = date("Y/m/d");
    $user = $_SESSION['usrdata']['screenname'];
    $insert = mysql_query("INSERT INTO comments(`comment`, `user`, `postid`, `page`) VALUES ('".$comment."', '".$user."', '".$id."', 'blog')")or die(mysql_error());
    if($insert){
        MsgBox("Sucess", "Succesfully added your comment! You may need to refresh to see your comment.");
    }else{
        echo "<font color='red'>There appears to be an error, your comment could not be posted. Please try again later.</font>";
    }
}
if(isset($_POST['comment']) && isset($_POST['challenge']) && isset($_GET['id'])){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $comment = mysql_real_escape_string(htmlspecialchars($_POST['comment']));
    $insert = mysql_query("INSERT INTO comments(`comment`, `user`, `postid`) VALUES ('".$comment."', '".$user."', '".$id."', 'challenges')")or die(mysql_error());
    if($insert){
         MsgBox("Sucess", "You have sucessfully posted a comment! You may need to refresh.");
     }else{
         echo "<font color='red'>Couldn't post your comment.</font>";
     }
}
?>