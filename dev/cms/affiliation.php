<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD);
mysql_select_db(SQL_DB);
include_once($_SERVER['DOCUMENT_ROOT'].'/cms/cmsnav.html');
if(isset($_GET['empty']) && $_GET['empty'] == "yes"){
    echo "You must fill in all the fields.";
}
if(isset($_SESSION['usr'])){
    $user = $_SESSION['usr'];
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
    echo "<div style='display:none;'>";
}
?>
<form action="" enctype="multipart/form-data" method="post">
<p>Company name:<br /> <input type="text" name="company" />
<br />
Company url:<br /> <input type="text" name="url" value="http://" />
<br />
Description:<br /> <textarea cols="80" rows="10" name="description"></textarea>
<br />
    <input type="file" name="upload" id="upload" /><input type="submit" value="Post" /><a href="/infinity/affiliation.php?view=yes">View affiliations</a></p>
</form>
</body>
    <?php
if(isset($_POST['company']) && isset($_POST['url']) && isset($_POST['description']) && !isset($_GET['update']) && isset($_SESSION['token']) && !empty($_SESSION['token']) && preg_match("/infinity-forum\.org$/", $_SERVER['HTTP_HOST']) && preg_match("/infinity-forum\.org$/", $_SERVER['SERVER_NAME'])){
    if(empty($_POST['company']) or empty($_POST['url']) or empty($_POST['description'])){
        header("Location: affiliation.php?empty=yes");
    }else{
        if(substr($_POST['url'], 0, 4) === "http" or substr($_POST['url'], 0, 5) === "https"){
            $company = mysql_real_escape_string(htmlspecialchars($_POST['company']));
            $url = mysql_real_escape_string(htmlspecialchars($_POST['url']));
            $description = mysql_real_escape_string(htmlspecialchars($_POST['description']));
            $date = date("Y-m-d g:i");
            $insert = mysql_query("INSERT INTO affiliation(`company`, `url`, `description`, `date`) VALUES ('".$company."', '".$url."', '".$description."', '".$date."')")or die(mysql_error());
            if($insert){
                if(!empty($_FILES['upload']['name'])){
                    $target_path = "uploads/";
                    $filename = basename($company . "_" . $_FILES['upload']['name']);
                    if(move_uploaded_file($_FILES['upload']['tmp_name'], "$target_path/$filename")){
                        $getid = mysql_query("SELECT * FROM affiliation WHERE `company` = '".$company."' AND `description` = '".$description."'")or die(mysql_error());
                        while($row = mysql_fetch_array($getid)){
                            $id = $row['id'];
                        }
                        $result = mysql_query("INSERT INTO files(`name`, `id`, `page`) VALUES ('".$filename."', '".$id."', 'affiliation')")or die(mysql_error());
                        if($result){
                            header("Location: /infinity/affiliation.php");
                        }
                    }else{
                        echo "There was an error uploading the file " . $filename . " , please try again! Error: " . $_FILES['upload']['error'];
                    }
                }else{
                    header("Location: /infinity/affiliation.php");
                }
            }else{
                echo "Couldnt successfully insert it into the database.";
            }
        }else{
            echo "The url must start with http or https.";
        }
    }
}
$getinfo = mysql_query("SELECT * FROM affiliation")or die(mysql_error());
    while($row = mysql_fetch_array($getinfo)){
        $id = $row['id'];
        $url = $row['url'];
        echo "<h2><a href='affiliation.php?delete=yes&id=$id'>[X]</a><a href='$url'> " . $row['company'] . " </a><a href='affiliation.php?edit=yes&id=$id'>edit<a/></h2>";
        echo $row['description'] . "<br />";
    }
    if(isset($_GET['edit']) && $_GET['edit'] == "yes" && isset($_GET['id'])){
        echo "</div>";
        $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
        $getinfo = mysql_query("SELECT * FROM affiliation WHERE `id` = '".$id."'")or die(mysql_error());
        while($row = mysql_fetch_array($getinfo)){
        $company = $row['company'];
        $description = $row['description'];
        $url = $row['url'];
        echo '<form action="affiliation.php?update=yes&id=$id" enctype="multipart/form-data" method="post">
            <p>Company name:<br /> <input type="text" name="company" value="'.$company.'" />
            <br />
            Company url:<br /> <input type="text" name="url" value="'.$url.'" />
            <br />
            description:<br /> <textarea cols="80" rows="10" name="description">'.$description.'</textarea>
            <input type="submit" value="update" /><a href="affiliation.php">stop editing</a></form></p>';
        }
    }
if(isset($_GET['update']) && $_GET['update'] == "yes" && isset($_GET['id']) && isset($_POST['company']) && isset($_POST['url']) && isset($user)){
    $company = mysql_real_escape_string(htmlspecialchars($_POST['company']));
    $url = mysql_real_escape_string(htmlspecialchars($_POST['url']));
    $description = mysql_real_escape_string(htmlspecialchars($_POST['description']));
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
   $update = mysql_query("UPDATE affiliation SET `company` = '".$company."', `url` = '".$url."', `description` = '".$description."' WHERE `id` = '".$id."'")or die(mysql_error());
    if($update){
        header("Location: affiliation.php");
    }else{
        echo "Couldnt succesfully update the challenge.";
    }
}
if(isset($_GET['delete']) && $_GET['delete'] == "yes" && $_GET['id']){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $delete = mysql_query("DELETE FROM affiliation WHERE `id` = '".$id."'")or die(mysql_error());
    if($delete){
        header("Location: affiliation.php");
    }else{
        echo "<font color='red'>Couldn't succesfully delete your challenge.</font>";
    }
}
    ?>
</html>