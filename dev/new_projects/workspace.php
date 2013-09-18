<?php
    $token = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
    $_SESSION['token'] = $token;
    include_once($_SERVER['DOCUMENT_ROOT'].'/new_projects/framework.php');
    include_once($_SERVER['DOCUMENT_ROOT']."/libs/loading.php");
    include_once($_SERVER['DOCUMENT_ROOT'].'/member/check_auth.php'); //Can be commented out during dev
    //Functions (Script externally[script.php], unless you absolutely must for some reason)
?>
<html>
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="projects.css" />
        <meta charset="UTF-8">
        <title>
            Infinity-Workspace
        </title>
        <script type="text/javascript" src="workspace.js"></script>
        <script>
            $(document).ready(function(){
                $('li#navlink').click(function(){
                    $('li#navlink').removeClass("active");
                    $(this).addClass("active");
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div id="top">
                <span class="role"></span> | 
                <select class="project_select"onchange="changeOnFly(1);">
                    <?php
                         //Changing projects. Coded in main file for first priority
                         $sql = new SQL;
                         //Get unique returns from database, oldest -> newest
                         $result = $sql->Query("
                             SELECT DISTINCT
                             `id`, `projectname`
                             FROM `projects_invited` 
                             WHERE `creator` = %d OR `person` = %d
                             AND `accepted` = %s
                             GROUP BY `id` ASC
                         ", $_SESSION['ID'], $_SESSION['ID'], 'true');
                         if(mysql_num_rows($result) == 0){
                             echo '<option>0</option>';
                         }else{
                             while($row = mysql_fetch_assoc($result)){
                                 $id = $row['id'];
                                 $name = id2projectname($id);
                                 //actual .val() is $id
                                 echo "<option value='".$id."'>".$name."</option>";
                             } 
                         }
                    ?>
                </select> 
                <select class="branch_select"onchange="changeOnFly(2);">
                    <option>Master</option>
                </select>
                | <a class="new">Create</a> | <a class="messages">Messages</a> | <a class="requests">Requests</a> | <a class="launch">Launch</a> | <a class="help">Help</a> | <a target="_blank"href="index.php">Projects</a> 
                | 
                <span class="searchspan">
                </span>
            </div>
            <div id="sidenav">
                <h3>Navigation</h3>
                <ul>
                    <li id="navlink" class="start">Start</li>
                    <li id="navlink" class="stream">Stream</li>
                    <li id="navlink" class="control">Control</li>
                    <li id="navlink" class="chat">Chat</li>
                    <li id="navlink" class="wall">Wall</li>
                    <li id="navlink" class="milestones">Milestones</li>
                    <li id="navlink" class="groups">Groups</li>
                    <li id="navlink" class="tasks">Tasks</li>
                    <li id="navlink" class="boards">Boards</li>
                    <li id="navlink" class="tables">Tables</li>
                    <li id="navlink" class="files">Files</li>
                    <li id="navlink" class="suggest">Suggest</li>
                </ul>
            </div>
            <div id="main">
                <div id="head">
                    <h2>Start</h2><hr />
                </div>
                <div id="description">
                    Stream from all projects:
                </div>
                <br />
                <div id="content">
                    
                </div>
            </div>
        </div>
        <br /><br /><br /><br />
        <!--<div id="foot">Copyright Infinity 2013</div>
        DO NOT REMOVE OR CHANGE-->
     <span style="display:none;">
         <?php
             echo '<input type="hidden" id="token" value="'.$token.'" />';
         ?>
         <input type="hidden" class="currentSelect"/>
         <input type="hidden" class="lastfunction"/>
         <input type="hidden" class="currentfunction"/>
         <input type="hidden" class="extra"/>
     </span>
    </body>
</html>