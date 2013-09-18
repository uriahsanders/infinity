<?php  
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
mysql_select_db(SQL_DB)or die(mysql_error());
include_once($_SERVER['DOCUMENT_ROOT'].'/cms/cmsnav.html');
if(isset($_GET['empty']) && $_GET['empty'] == "yes"){
    echo "You must fill in all the parts.";
}
$token = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
     ?>
<html>
<head>
<link href="/css/dark.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
if(isset($_GET['edit']) && $_GET['edit'] == "yes" && isset($_GET['id'])){
    echo "<div style='display:none'>";
}
?>
<form action="" enctype="multipart/form-data" method="post">
<p>
<input type="text" name="title" />
<br />
<textarea name="body" cols="100" rows="20" maxlength="5000"></textarea>
<br />
<input type="file" name="uploads" id="uploads" /><input type="submit" value="Post" />
<a href="/infinity/index.php">Show blogs</a>
</p>
</form>
</body>
    <?php 
if(isset($_SESSION['usrdata']['screenname'])){
    $user = $_SESSION['usrdata']['screenname'];
}
if(isset($_GET['update']) && $_GET['update'] == "yes" && isset($_GET['id']) && isset($_POST['title']) && isset($_POST['body'])){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $title = mysql_real_escape_string(htmlspecialchars($_POST['title']));
    $body = mysql_real_escape_string(htmlspecialchars($_POST['body']));
    $update = mysql_query("UPDATE blog SET title = '".$title."', body = '".$body."' WHERE id = '".$id."'")or die(mysql_error());
    if($update){
        header("Location: blog.php");
    }else{
        echo "Couldnt succesfully update the challenge.";
    }
}
if(isset($_POST['title']) && isset($_POST['body']) && !isset($_GET['update']) && isset($_SESSION['token']) && !empty($_SESSION['token']) && preg_match("/infinity-forum\.org$/", $_SERVER['HTTP_HOST']) && preg_match("/infinity-forum\.org$/", $_SERVER['SERVER_NAME'])){
    if(empty($_POST['title']) or empty($_POST['body'])){
        header("Location: blog.php?empty=yes");
    }else{
        $user = $_SESSION['usrdata']['screenname'];
        $title = mysql_real_escape_string(htmlspecialchars($_POST['title']));
        $body = mysql_real_escape_string(htmlspecialchars($_POST['body']));
        $date = date("Y-m-d g:i");
        $result = mysql_query("INSERT INTO blog(`title`, `body`, `user`, `date`) VALUES ('".$title."', '".$body."', '".$user."', '".$date."')")or die(mysql_error());
        if($result){
            if(!empty($_FILES['uploads']['name'])){
                $target_path = "uploads/";
                $filename = basename($title . "_" . $_FILES['uploads']['name']);
                if(move_uploaded_file($_FILES['uploads']['tmp_name'], "$target_path/$filename")){
                    $getid = mysql_query("SELECT * FROM blog WHERE `title` = '".$title."' AND `body` = '".$body."'")or die(mysql_error());
                    while($row = mysql_fetch_array($getid)){
                        $id = $row['id'];
                    }
                    $result = mysql_query("INSERT INTO files(`id`, `name`, `page`) VALUES ('".$id."', '".$filename."', 'blog')")or die(mysql_error());
                    if($result){
                        header("Location: /infinity/index.php");
                    }else{
                        echo "failed to insert into files.";
                    }
                }else{
                    echo "There was an error uploading the file " . $filename . " , please try again! Error: " . $_FILES['uploads']['error'];
                }
            }else{
                header("Location: /infinity/index.php");
            }
        }else{
            echo "<font color='red'>Couldn't successfully post your entry</font>";
        }
    }
}
$getblog = mysql_query("SELECT * FROM blog ORDER BY `date` DESC")or die(mysql_error());
    while($row = mysql_fetch_array($getblog)){
        $id = $row['id'];
        echo "<h2><a href='blog.php?delete=yes&id=$id'>[X]</a> " . $row['title'] . " <a href='blog.php?edit=yes&id=$id'>edit</a></h2>";
        echo $row['body'] . "<br />";
        echo $row['user'] . "<br />";
        echo $row['date'] . "<br />";
    }
if(isset($_GET['edit']) && $_GET['edit'] == "yes" && isset($_GET['id'])){
    echo "</div>";
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $getinfo =  mysql_query("SELECT * FROM blog WHERE `id` = '".$id."'");
    while($row = mysql_fetch_array($getinfo)){
        $title = $row['title'];
        $body = $row['body'];
        echo '<form action="blog.php?update=yes&id='.$id.'" method="post">
        <p>
        <input type="text" name="title" value="'.$title.'" />
        <br />
        <textarea name="body" cols="100" rows="20" maxlength="5000">'.$body.'</textarea>
        <br />
        <input type="submit" value="Update" /><a href="blog.php">Stop editing</a></form>';
    }
}
if(isset($_GET['delete']) && $_GET['delete'] == "yes" && isset($_GET['id']) && !isset($_GET['update'])){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $delete = mysql_query("DELETE FROM blog WHERE `id` = '".$id."'");
    if($delete){
        header("Location: blog.php");
    }else{
        echo "<font color='red'>Couldn't delete the blog.</font>";
    }
}
     ?>
</html>