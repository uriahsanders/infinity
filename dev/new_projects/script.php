<?php
    //make sticky notes
    include_once($_SERVER['DOCUMENT_ROOT'].'/new_projects/framework.php');
    function id2projectname($id){
            $sql = new SQL;
            $result = $sql->Query("SELECT `name` FROM `projects` WHERE `id` = %d", $id);
            $row = mysql_fetch_assoc($result);
            return $row['name'];
        }
    if(isset($_POST['token']) && $_POST['token'] != $_SESSION['token']) die();
    //input from AJAX
    if(isset($_POST['signal'])){
        $sql = new SQL;
        switch($_POST['signal']){
            case 'retrieve':
                //get a certain category
                $what = $_POST['what'];
                switch($what){
                    case 'Focus':
                        $what = 'Community Focus';
                        break;
                    case 'Fun':
                        $what = 'Just for Fun';
                        break;
                }
                $whats = array('Start', 'Community Focus', 'Just for Fun', 'Art', 'Technology', 'Research', 'Theatre', 'Games', 'Medical', 'Culinary', 'Fashion', 'Music', 'Education');
                if(in_array($what, $whats)){
                    echo '<div id="head"><h2>'.$what.'</h2></div><hr />';
                    if($what == 'Start'){
                        echo '<div id="description">All projects:</div><br />';
                    }else{
                        echo '<br />';
                    }
                    if($what == 'Start'){
                        $result = $sql->Query("SELECT * FROM `projects` WHERE `launched` = %d ORDER BY `date` DESC LIMIT %d", 1, $_POST['limiter']);
                    }else{
                        $result = $sql->Query("SELECT * FROM `projects` WHERE `category` = %s AND `launched` = %d ORDER BY `date` DESC LIMIT %d", $what, 1, $_POST['limiter']);
                    }
                    if(mysql_num_rows($result) == 0){
                        echo '<div id="content">No projects have been created here yet.</div>';
                        die();
                    }else{
                        while($row = mysql_fetch_assoc($result)){
                            //echo out project links (they will be thumbnails one day)
                            $num_persons = mysql_num_rows($sql->Query("SELECT `person` FROM `projects_invited` WHERE `id` = %d", $row['id']));
                            project_link($row['id'], $row['category'], $row['name'], id2user($row['creator']), $row['date'], $num_persons);
                        }
                    }
                }
                die();
            case 'join':
                //Add user to project confirmation list
                $id = $_POST['id'];
                //check if they have already joined the project
                $check = $sql->Query("SELECT `person` FROM `projects_invited` WHERE `id` = %d AND `person` = %d", $id, $_SESSION['ID']);
                if(mysql_num_rows($check) == 0){
                    $sql->Query("INSERT INTO projects_invited (projectID, person, privilege, request, accepted) VALUES (%d, %d, %d, %s, %s)", $id, $_SESSION['ID'], 4, $_POST['request'], 'false');
                    echo 'Request Sent';
                    die();
                }else{
                    echo 'STOP TRYING TO HACK ME!!!!';
                }
                die();
            case 'search':
                echo '<div id="head"><h2>Results</h2></div><hr /><br />';
                //echo search results
                $what = $_POST['what'];
                $result = $sql->Query("SELECT * FROM `projects` WHERE `name` LIKE %s AND `launched` = %d LIMIT %d", '%'.$what.'%', 1, $_POST['limiter']);
                if(mysql_num_rows($result) == 0){
                    echo '<div id="content">No projects have been found.</div>';
                    die();
                }
                while($row = mysql_fetch_assoc($result)){
                    $num_persons = mysql_num_rows($sql->Query("SELECT `person` FROM `projects_invited` WHERE `id` = %d", $row['id']));
                    project_link($row['id'], $row['category'], $row['name'], id2user($row['creator']), $row['date'], $num_persons);
                }
                die();
            case 'getOne':
                //view entire project page
                $id = $_POST['id'];
                $result = $sql->Query("SELECT * FROM `projects` WHERE `id` = %d AND `launched` = %d", $id, 1);
                //show project info
                echo '<div id="head"><h2>'.id2projectname($id).'</h2></div><div id="content"><a id="btn"class="back">Back</a><hr />';
                while($row = mysql_fetch_assoc($result)){
                    echo '<br />By: <a>'.id2user($row['creator']).'</a>, '.$row['date'].'<br /><br />';
                    echo '<i>'.$row['category'].'</i><br /><br />';
                    echo '<b>Description:</b><br />&nbsp;&nbsp;&nbsp;'.$row['description'];
                }
                echo '<br /><br /><b>Members</b><br />';
                //show project members
                $result2 = $sql->Query("SELECT * FROM `projects_invited` WHERE `id` = %d", $id);
                while($row2 = mysql_fetch_assoc($result2)){
                    echo '&nbsp;&nbsp;&nbsp;<a>'.id2user($row2['person']).'</a><br />';
                }
                $creatorresult = $sql->Query("SELECT `creator` FROM `projects_invited` WHERE `id` = %d", $id);
                $creator = mysql_fetch_assoc($creatorresult);
                $check = $sql->Query("SELECT `person` FROM `projects_invited` WHERE `projectID` = %d AND `person` = %d", $id, $_SESSION['ID']);
                //echo out comment form
                function comment_box($id){
                    $sql = new SQL;
                    echo
                    "
                        <div><textarea id='bigtxt' class='comment_form'></textarea><br /><br /><a id='btn' class='commentbtn".$id."'>Comment</a></div><br /><br />
                        <b>Comments:</b>
                    ";
                    $comments = $sql->Query("SELECT * FROM `projects_comments` WHERE `projectname` = %d AND `id2` = %d ORDER BY `date` DESC", $id, 0);
                    if(mysql_num_rows($comments) == 0){
                        echo '<br />&nbsp;&nbsp;&nbsp;No comments have been posted yet.';
                        die();
                    }else{
                        while($comment = mysql_fetch_assoc($comments)){
                            $by = id2user($comment['by']);
                            $body = $comment['comment'];
                            $date = $comment['date'];
                            echo '<br /><br /><span class="">&nbsp;&nbsp;&nbsp;By: <a>'.$by.'</a>, '.$date.'<br /><br />&nbsp;&nbsp;&nbsp;'.$body.'</span><hr />';
                        }
                    }
                }
                //see if theyve already joined
                if(mysql_num_rows($check) == 0){
                    $result3 = $sql->Query("SELECT * FROM `projects` WHERE `id` = %d AND `launched` = %d", $id, 1);
                    $row3 = mysql_fetch_assoc($result3);
                    echo '<br /><br />
                    <textarea id="bigtxt" class="joinbox"></textarea><br />
                    <input type="hidden" name="token" id="token" value="'.$_SESSION['token'].'" /><br />
                    <a id="btn" class="joinresp'.$id.'">Join</a><br /><br />
                    ';
                    comment_box($id);
                    die();
                }else{
                    echo '<br /><br />
                    <b>You have already joined this project.</b><br /><br />
                    ';
                    comment_box($id);
                }
                echo '</div>';
                die();
            case 'comment':
                //actually make a comment. comments are very basic so i imagine youd like to add another system to it
                $date = date("Y-m-d H:i:s");
                $sql->Query("INSERT INTO `projects_comments` (`projectname`, `by`, `comment`, `date`) VALUES (%d, %d, %s, %s)", $_POST['id'], $_SESSION['ID'], $_POST['mssg'], $date);
                die();
        }
    }
    function project_link($id, $category, $name, $creator, $date, $num_persons){
        echo '<div id="content"><a class="projectlink'.$id.'"><u><b>'.$name.'</b> By: '.$creator.', '.$date.' {'.$num_persons.'}</u></a></div><br /><br />';
    }