<?php 
    include_once('../projects/ptop.php'); //DO NOT REMOVE OR CHANGE
include_once('../libs/links.php'); // DO NOT REMOVE OR CHANGE

                                        listlinks("Projects"); // CHANGE TO THE ACTIVE LINK

// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
include_once('status.html')
?>

</div>
<div id="planhead" onload="MsgBox('Small Project','Small projects are projects that do not require the legal procedure and requirements of a business.', null, null, null, 3)"><a href="workspace.php">Workspace</a></div><!--Change to active link-->
<!--<div id="main" style="width:100%; padding-right: 0px">-->
<div id="wrktab1"><a href="/accsummary.php"><?php echo $_SESSION['usrdata']['screenname']; ?></a></div>
<!---->
<div id="mainwrk1">
<br />
<strong style="font-size: 1.5em;">Manage your Projects</strong>
<hr>

<?php
/*session_start();
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
        $comments = mysql_query("SELECT * FROM comments WHERE `projectid` = '".$id."'")or die(mysql_error());
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
}*/
?>
<?php
    include_once('../projects/sidebar.php');
    
    ?>
<b style="font-size: 2.5em;">  </b>
</div>
    Project stream for : <span style="color:rgb(63, 98, 143);font-weight: bold;font-style:italic;">Project_Name</span>    
<br /><br />
<a onclick="$('#stream').slideToggle('slow');">New Post</a><br /><br />
<div id="stream" style="display:none;">
<textarea></textarea><br /><br />
<input type="submit" value="Post" />
</div>
<hr />
</div>
<!---->


<!---->
<?php
include('nav.php');
?>
<hr style="width:500px;" />





<?php 
include_once('../libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>