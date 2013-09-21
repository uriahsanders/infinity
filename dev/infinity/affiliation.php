<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/top.php'); //DO NOT REMOVE OR CHANGE 
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/links.php'); // DO NOT REMOVE OR CHANGE

listlinks("Infinity"); // CHANGE TO THE ACTIVE LINK

    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/middle.php'); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>
<?php
$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
if(isset($_SESSION['usrdata']['screenname'])){
    $user = $_SESSION['usrdata']['screenname'];
}

?>
<div id="head">Affiliation</div><hr />
<div id="links">
<div id="linksitem">
<div id="linkssub">Links</div>
<div class="linkstxt">
<a href="index.php">Blog</a><br />
<a href="challenges.php">Challenges</a><br />
<a href="products.php">Products</a><br />
<a href="affiliation.php">Affiliation</a><br />
</div>
</div>
</div>
 <?php 
if(isset($user) && isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
    $retrieve = mysql_query("SELECT * FROM affiliation ORDER BY `date` DESC")or die(mysql_error());
    $num = mysql_num_rows($retrieve);
    if($num == 0){
        echo "<b>We havent affiliated with anyone yet.</b><br />";
        echo "<a href='affiliation.php'>Go back to form</a>";
    }else{
        while($row = mysql_fetch_array($retrieve)){
            $url = $row['url'];
            $id = $row['id'];
            $company = $row['company'];
            echo "<h2><a href=$url target='_blank'>" . $row['company'] . "</a></h2>" . $row['description'] . "<br />";
            $getfile = mysql_query("SELECT * FROM files WHERE `id` = '".$id."' AND `page` = 'affiliation'")or die(mysql_error());
            while($row = mysql_fetch_array($getfile)){
                $filename = $row['name'];
            }
            if(empty($filename)){
                echo "There is no logo for this company.<br />";
            }else{
                if(substr($filename, 0, strlen($company)) === $company){
                    echo "<img src='/cms/uploads/".$filename."' name='".$company."' height='35' width='85' /><br />";
                }
            }
        }
        echo "<br /><a href='/cms/affiliation.php'>Go back to form</a>";
    }
}else{
    $retrieve = mysql_query("SELECT * FROM affiliation ORDER BY `date` DESC")or die(mysql_error());
    $num = mysql_num_rows($retrieve);
    if($num == 0){
        echo "<b>We havent affiliated with anyone yet.</b>";
    }else{
        while($row = mysql_fetch_array($retrieve)){
            $url = $row['url'];
            $id = $row['id'];
            $company = $row['company'];
            echo "<h2><a href=$url target='_blank'>" . $row['company'] . "</a></h2>" .  $row['description']. "<br />";
            $getfile = mysql_query("SELECT * FROM files WHERE `id` = '".$id."' AND `page` = 'affiliation'")or die(mysql_error());
            while($row = mysql_fetch_array($getfile)){
                $filename = $row['name'];
            }
            if(empty($filename)){
                echo "There is no logo for this company.";
            }else{
                if(substr($filename, 0, strlen($company)) === $company){
                    echo "<img src='/cms/uploads/".$filename."' name='".$title."' height='35' width='85' /><br />";
                }
            }
        }
    }
}
     ?>
                

        </div>
   





















<?php
    include_once('../libs/bottom.php'); // DO NOT REMOVE 
?>