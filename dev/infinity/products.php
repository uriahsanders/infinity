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
<div id="head">Products</div><hr />
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
    $retrieve = mysql_query("SELECT * FROM products ORDER BY `date` DESC LIMIT 10")or die(mysql_error());
    $num = mysql_num_rows($retrieve);
    if($num == 0){
        echo "<b>There aren't any products posted yet.</b>";
        echo "<br /><a href='/cms/products.php'>Go back to form</a>";
    }else{
        while($row = mysql_fetch_array($retrieve)){
            $id = $row['id'];
            $url = $row['url'];
            $title = $row['title'];
            echo "<h2>" . $row['title'] . "</h2>";
            echo "Description: " . $row['description'] . "<br />";
            echo "<a href=$url target='_blank'>" . $row['url'] . "</a><br />";
            echo "Posted by: " . $row['user'] . "<br />";
            $getfile = mysql_query("SELECT * FROM files WHERE `id` = '".$id."' AND `page` = 'products'")or die(mysql_error());
            while($row = mysql_fetch_array($getfile)){
                $filename = $row['name'];
            }
            if(empty($filename)){
                echo "";
            }else{
                if(substr($filename, 0, strlen($title)) === $title){
                    echo "<img src='/cms/uploads/".$filename."' name='".$title."' height='326' width='580' /><br />";
                }
            }
        }
        if($num >= 10){
            echo "<br /><a href='products.php?show=more&page=2'>View older posts</a><br />";
            if(isset($_GET['show']) && $_GET['show'] == "more" && isset($_GET['page'])){
                $page = mysql_real_escape_string(htmlspecialchars($_GET['page'])) * 10;
                $getmore = mysql_query("SELECT * FROM products ORDER BY `date` DESC LIMIT ".$page."")or die(mysql_error());
                while($row = mysql_fetch_array($getmore)){
                    echo "<h2>" . $row['title'] . "</h2>";
                    echo "Description: " . $row['description'] . "<br />";
                    echo "<a href=$url target='_blank'>" . $row['url'] . "</a><br />";
                    echo "Posted by: " . $row['user'] . "<br />";
                    $getfile = mysql_query("SELECT * FROM files WHERE `id` = '".$id."' AND `page` = 'products'")or die(mysql_error());
                    while($row = mysql_fetch_array($getfile)){
                        $filename = $row['name'];
                    }
                    if(empty($filename)){
                        echo "";
                    }else{
                        if(substr($filename, 0, strlen($title)) === $title){
                            echo "<img src='/cms/uploads/".$filename."' name='".$title."' height='326' width='580' /><br />";
                        }
                    }
                }
                $page = mysql_real_escape_string(htmlspecialchars($_GET['page'])) + 1;
                echo "<a href='products.php?show=more&page=$page'>View older posts</a><br />";
                echo "<br /><a href='products.php'>Go back</a><br />";
            }
        }
        echo "<br /><a href='/cms/products.php'>Go back to form</a><br />";
    }
}else{
    $result = mysql_query("SELECT * FROM products ORDER BY `date` DESC LIMIT 10")or die(mysql_error());
    $num = mysql_num_rows($result);
    if($num == 0){
        echo "<b>There are no products posted yet.</b>";
    }else{
        while($row = mysql_fetch_array($result)){
            $id = $row['id'];
            $url = $row['url'];
            $title = $row['title'];
            echo "<h2>" . $row['title'] . "</h2>";
            echo "Description: " . $row['description'] . "<br />";
            echo "<a href=$url target='_blank'>" . $row['url'] . "</a><br />";
            echo "Posted by: " . $row['user'] . "<br />";
            $getfile = mysql_query("SELECT * FROM files WHERE `id` = '".$id."' AND `page` = 'products'")or die(mysql_error());
            while($row = mysql_fetch_array($getfile)){
                $filename = $row['name'];
            }
            if(empty($filename)){
                echo "";
            }else{
                if(substr($filename, 0, strlen($title)) === $title){
                    echo "<img src='/cms/uploads/".$filename."' name='".$title."' height='326' width='580' /><br />";
                }
            }
        }
        if($num >= 10){
            echo "<a href='products.php?view=more&page=2'>View older posts</a>";
            if(isset($_GET['view']) && $_GET['view'] == "more" && isset($_GET['page'])){
                echo "</div>";
                $page = mysql_real_escape_string(htmlspecialchars($_GET['page'])) * 10;
                $getmore = mysql_query("SELECT * FROM produucts ORDER BY `date` DESC LIMIT ".$page."")or die(mysql_error());
                while($row = mysql_fetch_array($getmore)){
                    echo "<h2> " . $row['title'] . "</h2>";
                    echo "Description: " . $row['description'] . "<br />";
                    echo "<a href=$url target='_blank'>" . $row['url'] . "</a><br />";
                    echo "Posted by: " . $row['user'] . "<br />";
                    $getfile = mysql_query("SELECT * FROM files WHERE `id` = '".$id."' AND `page` = 'products'")or die(mysql_error());
                    while($row = mysql_fetch_array($getfile)){
                        $filename = $row['name'];
                    }
                    if(empty($filename)){
                        echo "";
                    }else{
                        if(substr($filename, 0, strlen($title)) === $title){
                            echo "<img src='/cms/uploads/".$filename."' name='".$title."' height='326' width='580' /><br />";
                        }
                    }
                }
                $page = mysql_real_escape_string(htmlspecialchars($_GET['page'])) + 1;
                echo "<a href='products.php?view=more&page=$page'>View older posts</a>";
                echo "<br /><a href='products.php'>Go back</a><br />";
            }
        }
    }
}
     ?>



















<?php
    include_once('../libs/bottom.php'); // DO NOT REMOVE 
?>