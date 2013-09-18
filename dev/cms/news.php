<?php
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
 
include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");
    if ($_SESSION['admin'] != 1) {
    header('Location: /');
        die();
    }
$token = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
    


mysql_connect(SQL_SERVER,SQL_USR,SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());


    if (isset($_GET['id']) && isset($_GET['c']) && $_GET['c'] == 2 && preg_match('/([0-9])*/', $_GET['id'])) {

    $e_id = cleanQuery($_GET['id']);
    
$result = mysql_query("SELECT * FROM news WHERE id=".$e_id."")
or die(mysql_error());

    while($row = mysql_fetch_array($result)) {
        $e_sub = $row['subject'];
        $e_txt = $row['text'];
    }
    }

    ?>
    
    <html>
        <br />
    <?php
    include_once('cmsnav.html'); ?>
        <br /><br />
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/dark.css" />
    
        <p><b>Post Your News</b></p>

<div id="subject">
<form method="post" action="" id="news">
    <input type="text" name="subject" size="30" maxlength="255" style="position:absolute;left:1px;"
    value="<?php if(isset($e_sub)) echo $e_sub; ?>" />
</div>
    <br /><br />
<div id="text">
<textarea name="text" cols="45" rows="10"><?php if(isset($e_txt)) echo str_replace("<br />","",$e_txt);?>
</textarea>
<br />
<input type="hidden" name="c" value="" id="c"/>
<input type="hidden" name="id" value="<?php if (isset($_GET['id'])) echo $_GET['id']; ?> " />
    <input type="button" value="New" onclick="$('#c').val('1'); $('#news').submit();"/><br /><br />
<?php
if (isset($_GET['c']) && $_GET['c'] == 2)
    echo "<input type=\"button\" value=\"Edit\" onclick=\"$('#c').val('2'); $('#news').submit();\"/>";
?>
</form>
</div>
</html>
    
    <?php
if(isset($_SESSION['token']) && !empty($_SESSION['token']) && preg_match("/infinity-forum\.org$/", $_SERVER['HTTP_HOST']) && preg_match("/infinity-forum\.org$/", $_SERVER['SERVER_NAME'])){
if (isset($_POST['subject']))
    $sub = cleanQuery($_POST['subject']);
if (isset($_POST['text']))
    $text = mysql_real_escape_string(nl2br($_POST['text']));
if (isset($_GET['id']))
    $id = cleanQuery($_GET['id']);

    /* mysql_query("CREATE TABLE IF NOT EXISTS news (
id INT(4) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (id),
 subject VARCHAR(255) NOT NULL,
 text text NOT NULL,
 date datetime NOT NULL) ")
    or die(mysql_error()); */
   
if(isset($_POST['c']) && $_POST['c'] == 1) {
$result = mysql_query("SELECT * FROM news WHERE subject='$sub' AND text='$text'")
or die(mysql_error());
    if (mysql_num_rows($result) == 0) {
        mysql_query("INSERT INTO news
            (`subject`,`text`,`date`) VALUES('".$sub."','".$text."',NOW())") or die(mysql_error());
        
        echo '<meta http-equiv="REFRESH" content="0;url=news.php">';
    }
}

if(isset($_GET['delete'])) {
mysql_query("DELETE FROM news WHERE id='".$id."'")
 or die(mysql_error());
 
 echo '<meta http-equiv="REFRESH" content="0;url=news.php">';
}

if(isset($_POST['c']) && $_POST['c'] == 2) {
$id = cleanQuery($_POST['id']);
mysql_query("UPDATE news SET text='".$text."', subject='".$sub."', date=NOW() WHERE id='".$id."'")
 or die(mysql_error());
 echo '<meta http-equiv="REFRESH" content="0;url=news.php">';
}

$result = mysql_query("SELECT * FROM news ORDER BY date DESC LIMIT 10")
or die(mysql_error());

echo "<table width=\"50%\">";
    while($row = mysql_fetch_array($result)) {
        /*echo "<a href=\"news.php?delete&id=".$row['id']."\">delete</a> ";
     echo "<a href=\"news.php?subject=".$row['subject']."&text=".$row['text']."&c=2&id=".$row['id']."\">edit</a><br />";
     echo "subject: ".$row['subject']."<br>text: ".$row['text']."<br /><br/>";
        */
        echo "<tr><td width=\"75%\">".$row['subject']."</td><td width=\"25%\" align=\"right\">".$row['date']."</td></tr>";
        echo "<tr><td>".$row['text']."</td><td align=\"right\">
        <a href=\"news.php?delete&id=".$row['id']."\">delete</a><br />
        <a href=\"news.php?c=2&id=".$row['id']."\">edit</a><br />
        
        </td></tr>";
        echo "<tr><td colspan=\"2\"><hr></td></tr>";
    }
echo "</table>";
}
?>
