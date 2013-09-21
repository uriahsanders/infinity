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
    <?php
    if(isset($_GET['edit']) && $_GET['edit'] == "yes" && isset($_GET['id'])){
        echo "<div style='display:none;'>";
    }
    ?>
<form action="" method="post" enctype="multipart/form-data">
<input type="text" name="title" maxlength="50" />
<br />
<input type="text" name="url" value="http://" maxlength="100" />
<br />
<textarea cols="100" rows="20" name="description" maxlength="1000"></textarea>
<input type="file" name="upload" id="upload" /><input type="submit" value="Post" /><a href="ifininity/products.php?view=yes">View products</a>
</form>
</body>
    <?php 
if(isset($_POST['description']) && isset($_POST['title']) && isset($_POST['url']) && !isset($_GET['update']) && isset($_SESSION['token']) && !empty($_SESSION['token']) && preg_match("/infinity-forum\.org$/", $_SERVER['HTTP_HOST']) && preg_match("/infinity-forum\.org$/", $_SERVER['SERVER_NAME'])){
    if(empty($_POST['description']) && empty($_POST['title']) or empty($_POST['url'])){
        echo "You must fill in all the fields.";
    }else{
        if(substr($_POST['url'], 0, 4) === "http" or substr($_POST['url'], 0, 5) === "https"){
            $description = mysql_real_escape_string(htmlspecialchars($_POST['description']));
            $title = mysql_real_escape_string(htmlspecialchars($_POST['title']));
            $url = mysql_real_escape_string(htmlspecialchars($_POST['url']));
            $date = date("Y-m-d g:i");
            $user = $_SESSION['usrdata']['screenname'];
            $insert = mysql_query("INSERT INTO products(`title`, `description`, `url`, `user`, `date`) VALUES ('".$title."', '".$description."', '".$url."', '".$user."', '".$date."')")or die(mysql_error());
            if($insert){
                if(!empty($_FILES['upload']['name'])){
                    $target_path = "uploads/";
                    $filename = basename($title . "_" . $_FILES['upload']['name']);
                    if(move_uploaded_file($_FILES['upload']['tmp_name'], "$target_path/$filename")){
                        $getid = mysql_query("SELECT id FROM products WHERE `title` = '".$title."' AND `description` = '".$description."'")or die(mysql_error());
                        while($row = mysql_fetch_array($getid)){
                            $id = $row['id'];
                        }
                        $result = mysql_query("INSERT INTO files (`name`, `id`, `page`) VALUES ('".$filename."', '".$id."', 'products')")or die(mysql_error());
                        if($result){
                            header("Location: /infinity/products.php");
                        }
                    }else{
                        echo "There was an error uploading the file " . $filename . " , please try again! Error: " . $_FILES['upload']['error'];
                    }
                }else{
                    header("Location: /infinity/products.php");
                }
            }else{
                echo "Couldn't succesfully insert the product into the database.";
            }
        }else{
            echo "You must have http:// or https:// in it.";
        }
    }
}
    $getinfo = mysql_query("SELECT * FROM products ORDER BY `date` DESC")or die(mysql_error());
    while($row = mysql_fetch_array($getinfo)){
        $id = $row['id'];
        $url = $row['url'];
        echo "<h2><a href='products.php?delete=yes&id=$id'>[X]</a> " . $row['title'] . " <a href='products.php?edit=yes&id=$id'>edit<a/></h2>";
        echo $row['description'] . "<br />";
        echo "<a href='$url'>" . $url . "</a><br />";
        echo $row['user'] . "<br />";
    }
    if(isset($_GET['delete']) && $_GET['delete'] == "yes" && isset($_GET['id'])){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $delete = mysql_query("DELETE FROM products WHERE `id` = '".$id."'")or die(mysql_error());
    if($delete){
        header("Location: products.php");
    }else{
        echo "<font color='red'>Couldnt delete the product.</font>";
    }
}
if(isset($_GET['edit']) && $_GET['edit'] == "yes" && isset($_GET['id'])){
    echo "</div>";
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $getinfo = mysql_query("SELECT * FROM products WHERE `id` = '".$id."'")or die(mysql_error());
    while($row = mysql_fetch_array($getinfo)){
        $title = $row['title'];
        $description = $row['description'];
        $url = $row['url'];
        echo '<form action="products.php?update=yes&id='.$id.'" method="post">
        <input type="text" name="title" maxlength="50" value="'.$title.'" />
        <br />
        <input type="text" name="url" value="'.$url.'" />
        <br />
        <textarea cols="100" rows="20" name="description" maxlength="1000">'.$description.'</textarea>
        <input type="submit" value="Post" />
        <a href="products.php?view=yes">View products</a>
        </form>';
    }
}
if(isset($_GET['update']) && $_GET['update'] == "yes" && isset($_GET['id']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['url'])){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $title = mysql_real_escape_string(htmlspecialchars($_POST['title']));
    $description = mysql_real_escape_string(htmlspecialchars($_POST['description']));
    $url = mysql_real_escape_string(htmlspecialchars($_POST['url']));
    $update = mysql_query("UPDATE products SET title = '".$title."', description = '".$description."', `url` = '".$url."' WHERE `id` = '".$id."'")or die(mysql_error());
    if($update){
        header("Location: infinity/products.php");
    }else{
        echo "Update failed. Please try again.";
    }
}
     ?>
</html>