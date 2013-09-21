<?php
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
$user = $_SESSION['usr'];
?>
<html>
<head>
<title>Blog</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
if(isset($_SESSION['usr']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
if(isset($_GET['view'])){
    echo "<div style='display:none;'>";
}
if(isset($_GET['empty']) && $_GET['empty'] == "yes"){
    echo "<font color='red'>You have to fill in all the fields.</font>";
}
?>
<form action="" method="post">
<input type="text" name="title" />
<br />
<textarea name="body" cols="100" rows="20" maxlength="5000"></textarea>
<br />
<input type="submit" value="Post" />
<p>Images only<input type="file" name="filebutton" value="choose" />
<input type="submit" value="Upload File" />
</p>
</form>
<?php
if(isset($_POST['title']) && isset($_POST['body'])){
    if(empty($_POST['title']) or empty($_POST['body'])){
        header("Location: blog.php?empty=yes");
    }else{
        $title = mysql_real_escape_string(htmlspecialchars($_POST['title']));
        $body = mysql_real_escape_string(htmlspecialchars($_POST['body']));
        $result = mysql_query("INSERT INTO blog(title, body, user) VALUES ('".$title."', '".$body."', '".$user."')")or die(mysql_error());
        if($result){
            $query = mysql_query("SELECT * FROM blog WHERE `title` = '".$title."'")or die(mysql_error());
            while($row = mysql_fetch_array($query)){
                $id = $row['id'];
                break;
            }
            header("Location: blog.php?view=$title&id=$id");
        }else{
            echo "<font color='red'>Couldn't successfully post your entry</font>";
        }
    }
}
if(isset($_GET['view']) && isset($_GET['id'])){
    echo "</div>";
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $title = mysql_real_escape_string(htmlspecialchars($_GET['view']));
    $retrieve = mysql_query("SELECT * FROM blog WHERE `id` = '".$id."'")or die(mysql_error());
    while($row = mysql_fetch_array($retrieve)){
        echo "<h2><a href='blog.php?delete=yes&id=$id'>[X]</a>" . $title . "</h2>";
        echo "Body: " . $row['body'] . "<br />";
        echo "Posted by: " . $row['user'] . "<br />";
        echo "Date posted: " . $row['date'] . "<br />";
        echo "<a href='blog.php?view=$title&id=$id&comment=show'>Show comments</a><br />";
        if(isset($_GET['comment']) && $_GET['comment'] == "show"){
            $getcomments = mysql_query("SELECT * FROM comments")or die(mysql_error());
            while($row = mysql_fetch_array($getcomments)){
                echo $row['comment'] . "<br />";
                echo "Posted by: " . $row['user'] . "<br />";
            }
            echo "<a href='blog.php?view=$title&id=$id'>Hide comments</a><br />";
        }
    }
    echo "<a href='blog.php?view=$title&id=$id&comment=yes'>Comment</a>";
    if(isset($_GET['comment']) && $_GET['comment'] == "yes"){
        echo "<form action='blog.php?comment=post'  method='post'>";
        echo "<textarea name='comment' cols='100' rows='10' maxlength='1000'></textarea>";
        echo "<input type='submit' value='Comment' />";
        echo "</form>";
    }
}
if(isset($_GET['comment']) && $_GET['comment'] == "post" && isset($_POST['comment']) && isset($_GET['view'])){
    $title = mysql_real_escape_string(htmlspecialchars($_GET['view']));
    $comment = mysql_real_escape_string(htmlspecialchars($_POST['comment']));
    $date = date("Y/m/d");
    $insert = mysql_query("INSERT INTO comments(`comment`, `user`, `date`, `blogtitle`) VALUES ('".$comment."', '".$user."', '".$date."', '".$title."')")or die(mysql_error());
    if($insert){
        header("Locaton: blog.php?view=$title&id=$id&comment=show");
    }else{
        echo "<font color='red'>Couldn't post your comment.</font>";
    }
}
if(isset($_GET['delete']) && $_GET['delete'] == "yes" && isset($_GET['id'])){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $delete = mysql_query("DELETE FROM blog WHERE `id` = '".$id."'");
    if($delete){
        echo "<font color='green'>Messages succesfully deleted.</font>";
    }else{
        echo "<font color='red'>Couldnt delete the blog.</font>";
    }
}
}else{
    $retrieve = mysql_query("SELECT * FROM blog")or die(mysql_error());
    $num = mysql_num_rows($retrieve);
    if($num == 0){
        echo "<b>There are no blogs posted yet.</b>";
    }else{
        while($row = mysql_fetch_array($retrieve)){
            $id = $row['id'];
            $title = $row['title'];
            $body = $row['body'];
            $user = $row['user'];
            $date = $row['date'];
            }
            echo "<h2>" . $title . "</h2>";
            echo "Body: " . $body . "<br />";
            echo "Posted by: " . $user . "<br />";
            echo "Date posted: " . $date . "<br />";
            echo "<a href='blog.php?comment=yes&title=$title'>Post comment</a><br />";
            echo "<a href='blog.php?comment=show&title=$title'>Show comments</a><br />";
            if(isset($_GET['comment']) && $_GET['comment'] == "show" && isset($_GET['title'])){
                $getcomments = mysql_query("SELECT * FROM comments WHERE `blogtitle` = '".$title."'")or die(mysql_error());
                while($row = mysql_fetch_array($getcomments)){
                    echo $row['comment'] . "<br />";
                    echo "Posted by: " . $row['user'] . "<br />";
                    echo "Date posted: " . $row['date'] . "<br />";
                }
                echo "<a href='blog.php'>Hide comments</a><br />";
            }
            if(isset($_GET['comment']) && $_GET['comment'] == "yes" && isset($_GET['title'])){
                echo "<form action='blog.php?comment=post&title=$title'  method='post'>";
                echo "<textarea name='comment' cols='100' rows='10' maxlength='1000'></textarea>";
                echo "<input type='submit' value='Comment' />";
                echo "</form>";
            }
            if(isset($_GET['comment']) && $_GET['comment'] == "post" && isset($_POST['comment']) && isset($_GET['title'])){
                $title = mysql_real_escape_string(htmlspecialchars($_GET['title']));
                $comment = mysql_real_escape_string(htmlspecialchars($_POST['comment']));
                $date = date("Y/m/d");
                $insert = mysql_query("INSERT INTO comments(`comment`, `user`, `date`, `blogtitle`) VALUES ('".$comment."', '".$user."', '".$date."', '".$title."')")or die(mysql_error());
                if($insert){
                    header("Locaton: blog.php?comment=show&title=$title");
                }else{
                    echo "<font color='red'>Couldn't post your comment.</font>";
                }
            }
    }
}
?>
</body>
</html>