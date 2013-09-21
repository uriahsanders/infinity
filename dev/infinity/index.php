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
<div id="head">Blog</div><hr />
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
    $retrieve = mysql_query("SELECT * FROM blog ORDER BY `date` DESC LIMIT 10")or die(mysql_error());
    $num = mysql_num_rows($retrieve);
    if($num == 0){
        echo "<b>There arent any blogs posted yet.</b>";
    }else{
        while($row = mysql_fetch_array($retrieve)){
            $id = $row['id'];
            $title = $row['title'];
            $body = $row['body'];
            $user = $row['user'];
            echo "<div class='posts'>";
            echo "<h2>" . $row['title'] . "</h2>";
            echo "By <b>".$user."</b>, " . $row['date'] . "<br />";
            $getfile = mysql_query("SELECT * FROM files WHERE `id` = '".$id."' AND `page` = 'blog'")or die(mysql_error());
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
           echo $body . "<br />";
           if(isset($_SESSION['usr'])) echo "<a class='comment'>Comment</a><br />";
           echo "<a class='show".$id."'>Show comments</a><br /><hr style='width:500px;float:left;' /><br />";
           echo "<div id='comments' style='display:none;'>";
           $getcomments = mysql_query("SELECT * FROM comments WHERE `postid` = '".$id."' AND `page` = 'blog'")or die(mysql_error());
           if(mysql_num_rows($getcomments) == 0){
               echo "There are no comments yet.";
           }else{
               while($row = mysql_fetch_array($getcomments)){
                    echo "<br />" . $row['comment'] . "<br />";
                    echo "Posted by: " . $row['user'] . "<br /><br /><hr style='width:500px;float:left;' />";
                }
            }
            echo "</div>";
            echo "<div id='form' style='display:none;'><form action='' method='post'>";
            echo "<textarea name='comment' cols='100' rows='10' maxlength='1000'></textarea>";
            echo "<input type='hidden name='blog' value='' /'>";
            echo "<input type='submit' value='Comment' id='post' />";
            echo "<br />";
            echo "</form></div>";
            echo "</div>";
         }
            echo "<br /><a href='/cms/blog.php'>Go back to form.</a>";
    }
    if(isset($_POST['comment']) && $_GET['id']){
        $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
        $comment = mysql_real_escape_string(htmlspecialchars($_POST['comment']));
    }
    $retrieve = mysql_query("SELECT * FROM blog ORDER BY `date` DESC LIMIT 10")or die(mysql_error());
    $num = mysql_num_rows($retrieve);
    if($num >= 10){
        echo "<br /><a href='index.php?show=more&page=2'>View older posts</a><br />";
        if(isset($_GET['show']) && $_GET['show'] == "more" && isset($_GET['page'])){
            $page = mysql_real_escape_string(htmlspecialchars($_GET['page'])) * 10;
            $getmore = mysql_query("SELECT * FROM blog ORDER BY `date` DESC LIMIT ".$page."")or die(mysql_error());
            echo "<div style='width:30;'>";
            while($row = mysql_fetch_array($getmore)){
                $title = $row['title'];
                $id = $row['id'];
                $body = $row['body'];
                $user = $row['user'];
                echo "<h2>" . $row['title'] . "</h2>";
                echo "By <b>".$user."</b>, " . $row['date'] . "<br />";
                $getfile = mysql_query("SELECT * FROM files WHERE `id` = '".$id."'")or die(mysql_error());
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
                echo $body . "<br />";
                echo "<a class='comment'>Comment</a><br />";
                echo "<a class='show'>Show comments</a><br /><br /><hr style='width:500px;float:left;' />";
            }
            $page = mysql_real_escape_string(htmlspecialchars($_GET['page'])) + 1;
            echo "<br /><a href='index.php?show=more&page=$page'>View older posts</a><br />";
            echo "<br /><a href='index.php'>Go back</a><br />";
            echo "</div>";
        }
    }
if(isset($_GET['comment']) && $_GET['comment'] == "post" && isset($_POST['comment']) && isset($_GET['id'])){
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
}else{
    $retrieve = mysql_query("SELECT * FROM blog ORDER BY `date` DESC LIMIT 10")or die(mysql_error());
    $num = mysql_num_rows($retrieve);
    if($num == 0){
        echo "<b>There are no blog posts yet.</b>";
    }else{
        while($row = mysql_fetch_array($retrieve)){
            $id = $row['id'];
            $title = $row['title'];
            $body = $row['body'];
            $user = $row['user'];
            echo "<div class='posts'>";
            echo "<h2>" . $row['title'] . "</h2>";
            echo "By <b>".$user."</b>, " . $row['date'] . "<br />";
            $getfile = mysql_query("SELECT * FROM files WHERE `id` = '".$id."' AND `page` = 'blog'")or die(mysql_error());
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
            echo $body . "<br />";
            if(isset($_SESSION['usr']))echo "<a class='comment'>Post comment</a><br />";
            echo "<a class='show'>Show comments</a><br /><br /><hr style='width:500px;float:left;' /><br />";
            echo "<div id='comments' style='display:none;'>";
            $getcomments = mysql_query("SELECT * FROM comments WHERE `postid` = '".$id."' AND `page` = 'blog'")or die(mysql_error());
            if(mysql_num_rows($getcomments) == 0){
                echo "There are no comments yet.";
            }else{
                while($row = mysql_fetch_array($getcomments)){
                    echo "<br />" . $row['comment'] . "<br />";
                    echo "Posted by: " . $row['user'] . "<br /><br /><hr style='width:500px;float:left;' />";
                }
            }
            echo "</div>";
            echo "<div id='form' style='display:none;'><form action='index.php?comment=post&id=$id' method='post'>
                  <textarea name='comment' cols='100' rows='10' maxlength='1000'></textarea>
                  <input type='submit' value='Comment' />
                  <br />
                  <a href='index.php'>Hide comment form</a>
                  </form></div>";
                  echo "</div>";
        }
        if($num >= 10){
            echo "<br /><a href='index.php?show=more&page=2'>View older posts</a><br />";
            if(isset($_GET['show']) && $_GET['show'] == "more" && isset($_GET['page'])){
                echo "</div>";
                $page = mysql_real_escape_string(htmlspecialchars($_GET['page'])) * 10;
                $getmore = mysql_query("SELECT * FROM blog ORDER BY `date` DESC LIMIT ".$page."")or die(mysql_error());
                while($row = mysql_fetch_array($getmore)){
                    $title = $row['title'];
                    $body = $row['body'];
                    echo "<h2>" . $row['title'] . "</h2>";
                    echo "By <b>".$user."</b>, " . $row['date'] . "<br />";
                    $getfile = mysql_query("SELECT * FROM files WHERE `id` = '".$id."'")or die(mysql_error());
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
                    echo $body . "<br />";
                    echo "<a class='comment'>Post comment</a><br />";
                    echo "<a class='show'>Show comments</a><br /><br /><hr style='width:500px;float:left;' />";
                }
                $page = mysql_real_escape_string(htmlspecialchars($_GET['page'])) + 1;
                echo "<a href='index.php?show=more&page=$page'>View older posts</a><br />";
                echo "<br /><a href='index.php'>Go back</a><br />";
            }
        }
        if(isset($_GET['comment']) && $_GET['comment'] == "post" && isset($_POST['comment']) && isset($_GET['id']) && isset($user)){
            $id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
            $comment = mysql_real_escape_string(htmlspecialchars($_POST['comment']));
            $date = date("Y/m/d");
            $insert = mysql_query("INSERT INTO comments(`comment`, `user`, `date`, `postid`) VALUES ('".$comment."', '".$user."', '".$date."', '".$id."', 'blog')")or die(mysql_error());
            if($insert){
                MsgBox("Succes", "Succesfully added your comment! You may need to refresh to see your comment.");
            }else{
                echo "<font color='red'>Couldn't post your comment.</font>";
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
     $(document).ready(function (){
         $('#post').click(function (){
             $.post("comment.php", {comment: "<?php $comment ?>" id: "<?php $id ?>" blog: ""});
         });
     });
</script>
     

            
            
            
            
        
















<?php
    include_once('../libs/bottom.php'); // DO NOT REMOVE 
?>