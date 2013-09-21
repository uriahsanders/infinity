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
<div id="head">Challenges</div><hr />
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
    $retrieve = mysql_query("SELECT * FROM challenges ORDER BY `date` DESC LIMIT 10")or die(mysql_error());
    $num = mysql_num_rows($retrieve);
    if($num == 0){
        echo "<b>There are no challenges posted yet.</b>";
    }else{
        while($row = mysql_fetch_array($retrieve)){
            $title = $row['title'];
            $id = $row['id'];
            echo "<div class='posts'>";
            echo "<h2>" . $title . "</h2>";
            echo "Description: " . $row['description'] . "<br />";
            echo "Reward: " . $row['reward'] . "<br />";
            echo "Importance: " . $row['importance'] . "<br />";
            echo "Posted by: " . $row['asker'] . "<br />";
            echo "<div id='text' style='display:none;'>";
            echo "What rank can join: " . $row['rank'] . "<br />";
            echo "Why you should join: " . $row['join'] . "<br />";
            echo "</div>";
            echo "<a class='more'>Read more</a><br />";
            if(isset($_SESSION['usr']))echo "<a class='comment'>Post comment</a><br />";
            echo "<a class='show'>Show comments</a><br />";
            echo "<div id='form' style='display:none;'><form action='challenges.php?comment=post&id=$id'  method='post'>
                   <textarea name='comment' cols='100' rows='10' maxlength='1000'></textarea>
                   <input type='submit' value='Comment' /><br />
                   </form></div>";
            echo "<div id='comments' style='display:none;'>";
            $getcomments = mysql_query("SELECT * FROM comments WHERE `postid` = '".$id."' AND `page` = 'challenges'")or die(mysql_error());
            if(mysql_num_rows($getcomments) == 0){
                echo "There are no comments posted yet.";
            }else{
                while($row = mysql_fetch_array($getcomments)){
                    echo $row['comment'] . "<br />";
                    echo "Posted by: " . $row['user'] . "<br />";
                }
            }
            echo "</div>";
            echo "</div>";
        }
        $retrieve = mysql_query("SELECT * FROM challenges")or die(mysql_error());
        $num = mysql_num_rows($retrieve);
        if($num >= 10){
            echo "<br /><a href='challenges.php?show=more&page=2'>View older posts</a><br />";
            if(isset($_GET['show']) && $_GET['show'] == "more" && isset($_GET['page'])){
                $page = mysql_real_escape_string(htmlspecialchars($_GET['page'])) * 10;
                 echo "</div>";
                $getmore = mysql_query("SELECT * FROM challenges ORDER BY `date` DESC LIMIT ".$page."")or die(mysql_error());
                $number = mysql_num_rows($getmore);
                if($number == 0){
                    echo "<b>There are no more challenges post.</b>";
                    echo "<a href='challenges.php'>Go back</a>";
                }else{
                    while($row = mysql_fetch_array($getmore)){
                        echo "<h2>" . $row['title'] . "</h2>";
                        echo "Description: " . $row['description'] . "<br />";
                        echo "Reward: " . $row['reward'] . "<br />";
                        echo "Importance: " . $row['importance'] . "<br />";
                        echo "Posted by: " . $row['asker'] . "<br />";
                        echo "<a href='challenges.php?show=full&id=$id'>Read more</a><br />";
                    }
                    $page = $_GET['page'] + 1;
                    echo "<br /><a href='challenges.php?show=more&page=$page'>View older posts</a><br />";
                    echo "<br /><a href='challenges.php'>Go back</a><br />";
                }
            }
        }
    }
    echo "<br /><a href='/cms/challenges.php'>Go back to form</a>";
if(isset($_GET['comment']) && $_GET['comment'] == "post" && isset($_POST['comment']) && isset($_GET['id']) && isset($user)){
    $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
    $comment = mysql_real_escape_string(htmlspecialchars($_POST['comment']));
    $insert = mysql_query("INSERT INTO comments(`comment`, `user`, `postid`, `page`) VALUES ('".$comment."', '".$user."', '".$id."', 'challenges')")or die(mysql_error());
    if($insert){
        echo "Comment successfully posted.";
    }else{
        echo "<font color='red'>Couldn't post your comment.</font>";
    }
}
}else{
    $result = mysql_query("SELECT * FROM challenges ORDER BY `date` DESC LIMIT 10")or die(mysql_error());
    $num = mysql_num_rows($result);
    if($num == 0){
        echo "<b>There are no challenges posted yet.</b>";
    }else{
        while($row = mysql_fetch_array($result)){
            $id = $row['id'];
            echo "<div class='posts'>";
            echo "<h2> " . $row['title'] . " </h2>";
            echo "Description: " . $row['description'] . "<br />";
            echo "Reward: " . $row['reward'] . "<br />";
            echo "Importance: " . $row['importance'] . "<br />";
            echo "Posted by: " . $row['asker'] . "<br />";
            echo "<div id='text' style='display:none;'>";
            echo "What rank can join: " . $row['rank'] . "<br />";
            echo "Why you should join: " . $row['join'] . "<br />";
            echo "</div>";
            echo "<a class='more'>Read more</a><br />";
            if(isset($_SESSION['usr']))echo "<a class='comment'>Post comment</a><br />";
            echo "<a class='show'>Show comments</a><br />";
            echo "<div id='comments' style='display:none;>";
            $getcomments = mysql_query("SELECT * FROM comments WHERE `postid` = '".$id."' AND `page` = 'challenges'")or die(mysql_error());
            if(mysql_num_rows($getcomments) == 0){
                echo "There are no comments posted yet.";
            }else{
                while($row = mysql_fetch_array($getcomments)){
                    echo $row['comment'] . "<br />";
                    echo "Posted by: " . $row['user'] . "<br />";
                }
            }
            echo "</div>";
            echo "<div id='form' style='display:none;'><form action='challenges.php?comment=post&id=$id'  method='post'>
                  <textarea name='comment' cols='100' rows='10' maxlength='1000'></textarea>
                  <input type='submit' value='Comment' />
                  <br />
                  <a href='challenges.php'>Close commment form</a>
                  </form></div>";
            echo "</div>";
        }
        if($num >= 10){
            echo "<br /><a href='challenges.php?view=more&page=2'>View older posts</a><br />";
            if(isset($_GET['view']) && $_GET['view'] == "more" && isset($_GET['page'])){
                echo "</div>";
                $page = mysql_real_escape_string(htmlspecialchars($_GET['page'])) * 10;
                $getmore = mysql_query("SELECT * FROM challenges ORDER BY `date` DESC LIMIT ".$page."")or die(mysql_error());
                while($row = mysql_fetch_array($getmore)){
                    echo "<h2>" . $row['title'] . "</h2>";
                    echo "Description: " . $row['description'] . "<br />";
                    echo "Reward: " . $row['reward'] . "<br />";
                    echo "Importance: " . $row['importance'] . "<br />";
                    echo "Posted by: " . $row['asker'] . "<br />";
                    echo "<a href='challenges.php?show=full&id=$id'>Read more</a><br />";
                }
                $page = $_GET['page'] + 1;
                echo "<a href='challenges.php?view=more&page=$page'>View older posts</a>";
                echo "<br /><a href='challenges.php'>Go back</a>";
            }
        }
        if(isset($_GET['comment']) && $_GET['comment'] == "post" && isset($_POST['comment']) && isset($_GET['id']) && isset($user)){
            $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
            $comment = mysql_real_escape_string(htmlspecialchars($_POST['comment']));
            $insert = mysql_query("INSERT INTO comments(`comment`, `user`, `postid`) VALUES ('".$comment."', '".$user."', '".$id."', 'challenges')")or die(mysql_error());
            if($insert){
                MsgBox("Sucess", "You have sucessfully posted a comment! You may need to refresh.");
            }else{
                echo "<font color='red'>Couldn't post your comment.</font>";
            }
        }
        if(isset($_GET['show']) && $_GET['show'] == "full" && isset($_GET['id'])){
            echo "</div>";
            $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
            $getchallenge = mysql_query("SELECT * FROM challenges WHERE `id` = '".$id."'")or die(mysql_error());
            $num = mysql_num_rows($getchallenge);
            if($num >= 0){
                echo "<b>Couldnt find the blog you were looking for.</b><br />";
                echo "<a href='challenges.php'>Go back</a><br />";
            }else{
                while($row = mysql_fetch_array($getchallenge)){
                    echo "<h2>" . $row['title'] . "</h2>";
                    echo "Description: " . $row['body'] . "<br />";
                    echo "Reward: " . $row['reward'] . "<br />";
                    echo "Importance: " . $row['importance'] . "<br />";
                    echo "What rank can join: " . $row['rank'] . "<br />";
                    echo "Why you should join: " . $row['join'] . "<br />";
                    echo "Who wants this done: " . $row['asker'] . "<br />";
                    echo "Posted by: " . $row['user'] . "<br />";
                    echo "<a href='challenges.php'>Show less</a><br />";
                    echo "<a href='challenges.php?comment=yes&id=$id'>Post comment</a><br />";
                    echo "<a href='challenges.php?comment=show&id=$id'>Show comments</a><br />";
                }
            }
        }
    }
}
     ?>




<script src='/js/jquery-1.8.3.min.js'></script>
<script type="text/javascript">
    //show comments
    $("a[class^=show]").toggle(function (){
        $(this).text('Hide comments').next();
        $(this).parent('.posts').children('#comments').slideToggle('fast');
    }, function (){
        $(this).text('Show comments').next();
        $(this).parent('.posts').children('#comments').slideToggle('fast');
    });
    //comment
    $('a[class^=comment]').toggle(function (){
          $(this).text('Hide comment form').next();
          $(this).parent('.posts').children('#form').slideToggle('fast');
     }, function (){
          $(this).text('Comment').next();
          $(this).parent('.posts').children('#form').slideToggle('fast');
     });
     //read more
     $('a[class^=more]').toggle(function (){
         $(this).text('Show less').next();
         $(this).parent('.posts').children('#text').slideToggle('fast');
     }, function (){
         $(this).text('Read more').next();
         $(this).parent('.posts').children('#text').slideToggle('fast');
     });
</script>

















<?php
    include_once('../libs/bottom.php'); // DO NOT REMOVE 
?>