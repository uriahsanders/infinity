<?php
    /*
     *chat/wall/milestones/files are for relax/arty/jeremy
    */
    include_once($_SERVER['DOCUMENT_ROOT'].'/new_projects/framework.php');
    //Security class
    $sessionusr = new Person;
    //if a token is set, log suspicious if its not the session id, and die();
    if(isset($_POST['token']) && $_POST['token'] != $_SESSION['ID']){
        //log suspicious activity
        die();
    }
    //Set their privileges
    if(isset($_POST['signal']) && $_POST['signal'] == 'cat' && isset($_POST['what'])){ 
        //Categories
        $what = $_POST['what'];
        $name = $_POST['name'];
        $branch = $_POST['branch'];
        $sessionusr->verify_project_access($name);
        $sql = new SQL;
        $onUserID = $_SESSION['ID'];
        //what privilege do they have in this branch in this project?
        $getPrivileges = $sql->Query("SELECT * FROM `projects_data` WHERE `branch` = %s AND `name` = %d AND `to` = %d AND `what` = %s", $branch, $name, $onUserID, 'privilege');
        while($get = mysql_fetch_assoc($getPrivileges)){
            $privilege = $get['level'];
            //set the one correct privilege to true
            switch($privilege){
                //Creator
                case 0:
                    $isCreator = true;
                    $client = new Creator;
                    break;
                //Manager
                case 1:
                    $manager = true;
                    $client = new Manager;
                    break;
                //Supervisor
                case 2:
                    $supervisor = true;
                    $client = new Supervisor;
                    break;
                //Member
                case 3:
                    $member = true;
                    $client = new Member;
                    break;
                //Observer
                case 4:
                    $observer = true;
                    $client = new Observer;
                    break;
                //Observer
                default:
                    //Report suspicious activity: redirect
            }
        }
        //Main code block
        switch($what){
            case 'start':
                //just some styling stuff
                echo '<div id="head"><h2>Start</h2></div><hr /><br />
                <div id="description">Stream from all projects:</div><br /><div id="content">';
                $result = $sql->Query("SELECT `id` FROM `projects_invited` WHERE `person` = %d", $_SESSION['ID']);
                //loop through all data with the project id and selected branch
                while($row = mysql_fetch_assoc($result)){
                    //smaller stuff (updates/comments/messages) are stored in a notifications box. only creations/completions are in the streams
                    //get created data
                    $result2 = $sql->Query("SELECT * FROM `projects_data` WHERE name = %d AND `what` != %s AND `what` != %s AND `what` != %s AND `suggest` = %d ORDER BY `date` DESC LIMIT 10", $row['id'], 'privilege', 'branch', 'message', 0);
                    //get completed tasks/milestones
                    $result3 = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` = %s AND `mark` != %d AND `suggest` = %d ORDER BY `date` DESC LIMIT 4", $row['id'], 'task', 0, 0);
                    if(mysql_num_rows($result2) == 0 && mysql_num_rows($result3) == 0){
                        die('No recent activity.');
                    }else{
                        while($row2 = mysql_fetch_assoc($result2)){
                            $what = $row2['what'];
                            $by = $row2['by'];
                            $to = ($row2['txtto']) == 0 ? 'Anyone' : $row2['txtto'];
                            //echo data creations
                            echo '<span><b>('.id2projectname($row2['name']).') '.ucfirst($what).':</b> '.$row2['title'].', By: <b>'.id2user($by).'</b>, '.$row2['date'].', Assigned to: <b>'.id2user($to).'</b> ('.$row2['branch'].')</span><br /><br /><br />';
                        }
                    }
                    while($row3 = mysql_fetch_assoc($result3)){
                        //echo data completions
                        echo '<span>'.ucfirst(id2user($row3['mark'])).' completed the task: <b>'.$row3['title'].'</b></span><br /><br />';
                    }
                }
                echo '</div>';
                break;
                die();
            //stream is just like 'start' except that it only displays the stream for the current project and branch
            case 'stream':
                //Echo recent activity
                echo '<div id="head"><h2>'.id2projectname($name).' Stream</h2></div><hr /><div id="content"><br />';
                //2 different queries, since the master branch shows all branches
                if($branch != 'Master'){
                    $recent_data = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` != %s AND `what` != %s AND `what` != %s AND `branch` = %s AND `suggest` = %d ORDER BY `date` DESC LIMIT 15", $name, 'message', 'branch', 'privilege', $branch, 0);
                }else{
                    $recent_data = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` != %s AND `what` != %s AND `what` != %s AND `suggest` = %d ORDER BY `date` DESC LIMIT 15", $name, 'message', 'branch', 'privilege', 0);
                }
                if(mysql_num_rows($recent_data) == 0){
                    die('No recent activity in this branch.');
                }else{
                    while($recent = mysql_fetch_assoc($recent_data)){
                        $what = $recent['what'];
                        //link to data
                        echo '<a style="cursor:pointer;" onclick="getOne('.$recent['id'].');"><b>('.$recent['branch'].') '.ucfirst($what).':</b> '.$recent['title'].', By: <b>'.id2user($recent['by']).'</b>, '.$recent['date'].', Assigned to: <b>'.id2user($recent['txtto']).'</b> ('.$recent['branch'].')</a><br /><br />';
                    }
                }
                //do it again for task/milestone completion. it looks the sma ebut its not. SQL just looks redundant no matter what
                if($branch != 'Master'){
                    $result = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` = %s AND `mark` != %d AND `branch` = %s AND `suggest` = %d ORDER BY `date` DESC LIMIT 15", $name, 'task', 0, $branch, 0);
                }else{
                    $result = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` = %s AND `mark` != %d AND `suggest` = %d ORDER BY `date` DESC LIMIT 15", $name, 'task', 0, 0);
                }
                while($row = mysql_fetch_assoc($result)){
                    echo '<a onclick="getOne('.$row['id'].');">'.ucfirst(id2user($row['mark'])).' completed the task: <b>'.$row['title'].'</b> ('.$row['branch'].')</a><br /><br />';
                }
                echo '</div>';
                break;
                die();
            case 'control':
                //control is where you can view/edit project data
                echo "<div id='head'><h2><i>Control Panel</i></h2></div><div id='content'>";
                echo '<a id="btn"onclick="$(this).next().next().slideToggle();">CMS</a><br /><div class="cms"><br />';
                //i hope the functions are pretty self explanatory (check out framework.php)
                //based off of privileges
                if($isCreator){
                    $client->deleteProject($name);
                    //$client->creatorLeave($name);
                    $client->deleteBranch($name);
                    echo '<br />';
                    $client->branchCMS($name);
                    echo '<br /><br />';
                }
                echo "</div><hr />";
                if($isCreator || $manager){ 
                    //Echo form for adding/removing roles
                    $client->infoEdit($name);
                }else{
                    //Inform observer that they have no power
                    if($observer) $client->alert;
                    //Echo, but no content-editable or update button
                    $client->infoLook($name);
                    }
                if(!$isCreator){
                    $client->leaveProject($name);
                }else{
                    //If the creator wants to leave but not delete, he must pass lead to someone else
                    //echo $client->creatorLeave($name);
                }
                echo '</div></div>';
                break;
                die();
            case 'chat':
                //you know what this is :/
                echo "<div id='head'><h2>Chat</h2></div><hr />";
                break;
                die();
            case 'wall':
                echo '<div id="head"><h2>Wall</h2></div><hr />';
                //wall php code here
                break;
                die();
            case 'milestones':
                //Milestone html data select from name
                echo "<div id='head'><h2>Milestones</h2></div><div id='content'><a id='btn' onclick='$(this).next().slideToggle();'>CMS</a><div class='cms'>";
                //milestone php code here
                if($isCreator || $manager){
                    //echo the cms for creating a milestone 
                    $client->milestoneForm($name, $branch);
                }else{
                    echo 'There is no CMS for your privilege.';
                }
                echo '</div><hr />';
                echo '<div id="milestones"></div>';
                echo '</div>';
                break;
                die();
            case 'groups':
                //Groups html data select from name
                echo "<div id='head'><h2>Members and Roles</h2></div><div id='content'>";
                echo '<a id="btn"onclick="$(this).next().next().slideToggle();">CMS</a><br /><div class="cms"><br />';
                if($isCreator){
                    //Allow member deletion
                    $client->privilegeCMS($name);
                    $client->removeMember($name);
                }
                if($isCreator || $manager || $supervisor){
                    //Allow to change/set roles
                    $client->roleCMS($name);
                }
                //Allow to change own status
                if($isCreator || $manager || $supervisor || $member && !$observer) 
                    echo '<br />'.$client->changeStatus($name);
                //Show roles, statuses
                echo '</div><hr />';
                //see all memebers and roles/privileges
                $client->viewRoles($name, $branch);
                echo '</div>';
                break;
                die();
            case 'tasks':
                //Tasks html data select from name
                echo "<div id='head'><h2>Tasks</h2></div><div id='content'>";
                echo '<a id="btn"onclick="$(this).next().next().slideToggle();">CMS</a><br /><div class="cms"><br />';
                if($isCreator || $manager || $supervisor){
                    //Echo form for creating tasks
                    $client->createTask($name);
                    echo '</div><hr />';
                }
                $client->viewTasks($name, $branch);
                echo '</div>';
                break;
                die();
            case 'boards':
                echo "<div id='head'><h2>Boards</h2></div><div id='content'>";
                echo '<a id="btn"onclick="$(this).next().next().slideToggle();">CMS</a><br /><div class="cms"><br />';
                //Boards html data select from name
                if($isCreator || $manager || $supervisor){
                    //Allow editing already created documents
                    $client->documentCMS($name);
                    $client->createDocument($name);
                }else if($isCreator || $member || $manager || $supervisor){
                    //Allow document creation
                    $client->createDocument($name);
                }
                echo '</div><hr />';
                //Show documents
                $client->viewDocuments($name, $branch);
                echo '</div>';
                break;
                die();
            case 'tables':
                echo '<div id="head"><h2>Tables</h2></div><div id="content"><a id="btn" onclick="$(this).next().slideToggle();">CMS</a><div style="display:none;">';
                echo '
                <center>
                    <input type="text"class="tableName"placeholder="Table name..." /><br /><br />
                    <div style="color:black;"id="tableForm">
                        <table class="tableBody" contenteditable="true">
                            <tr class="tableHeaders"></tr>
                        </table>
                    </div>
                    <br />
                    <a id="btn" onclick="addToTable(\'column\');">Add column</a>
                    <a id="btn" onclick="addToTable(\'row\');">Add row</a><br /><br /><a id="btn">Save</a>
                </center></div></div><hr />';
                //$client->viewTables($name, $branch);
                break;
                die();
            case 'docEditMode':
                //display docs in a list like in boards only all of them editable
                $client->editMode($name);
                break;
                die();
            case 'files':
                echo '<div id="head"><h2>Files</h2></div><hr />';
                break;
                die();
            case 'suggest':
                if($isCreator){
                    $text = 'Confirm/delete project suggestions';
                }else{
                    $text = 'Create project suggestions';
                }
                //allow them to suggest documents/tasks/milestones/features to creator
                //creator can confirm or delete suggestions, which arent part of the project until confirmed
                echo '<div id="head"><h2>Suggest</h2></div><hr /><div id="description">'.$text.'</div><div id="content">';
                $client->Suggest($name, $branch);
                echo '</div>';
                break;
                die();
        }
        die();
    }
    //POSTS
    if(isset($_POST['signal']) && $_POST['signal'] == 'setRole'){ 
        //just says you role and privilege
        $sql = new SQL;
        $name = $_POST['name'];
        $test = $sql->Query("SELECT * FROM `projects_invited` WHERE `id` = %d AND `person` = %d OR `creator` = %d AND `accepted` = %s", $name, $_SESSION['ID'], $_SESSION['ID'], 'true');
        if(mysql_num_rows($test) == 0){
            die();
        }else{
            $result = $sql->Query("SELECT * FROM `projects_invited` WHERE `id` = %d AND `person` = %d AND `accepted` = %s", $name, $_SESSION['ID'], 'true');
            while($row = mysql_fetch_assoc($result)){
                $creator = $row['creator'];
                $person = $row['person'];
                $role = $row['role'];
                $privilege = $row['privilege'];
                $priv = array('Creator', 'Manager', 'Supervisor', 'Member', 'Observer');
                for($i = 0; $i < count($priv); $i++){
                    if(!in_array($priv[$i], $priv)){
                        $privilege = 'Observer';
                        //maybe log suspicious? this should never happen
                    }else{
                        switch($privilege){
                            case $i:
                                $privilege = $priv[$i];
                                break;
                        }
                    }
                }
                //echo privilege and role. if no role has been set, just echo privilege
                if($role != '')
                echo $privilege.', '.$role;
                else echo $privilege;
            }
        }
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'getProjects'){
        //just echo out their projects in a select box
        $sql = new SQL;
        $result = $sql->Query("SELECT * FROM `projects` WHERE `creator` = %d", $_SESSION['ID']);
        //Check for invited later too
        while($row = mysql_fetch_assoc($result)){
            $name = $row['name'];
            echo "<option>".$name."</option>";
        }
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'getBranches'){
        //echo out all the project branches in a select box
        $name = $_POST['name'];
        $sql = new SQL;
        $result = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` = %s ORDER BY `id` ASC", $name, 'branch');
        while($row = mysql_fetch_assoc($result)){
            echo '<option>'.$row['title'].'</option>';
        }
        die();
     }
        if(isset($_POST['signal']) && $_POST['signal'] == "create"){
                //create a new workpsace
                    $sql = new SQL;
                    $name = $_POST['name'];
                    $category = $_POST['category'];
                    $description = $_POST['description'];
                    $date = date('Y-m-d H:i:s');
                    $creator = $_SESSION['ID'];
                    $user = $_SESSION['ID'];
                    $sql->Query("
                        INSERT INTO
                        `projects`
                        (`name`, `creator`, `category`, `description`, `date`)
                        VALUES
                        (%s, %d, %s, %s, %s)
                    ", $name, $creator, $category, $description, $date);
                    $newid = mysql_insert_id();
                    $sql->Query("
                        INSERT INTO
                        `projects_invited` 
                        (`id`, `creator`, `projectname`, `person`, `privilege`, `accepted`)
                        VALUES
                        (%d, %d, %s, %d, %d, %s)
                    ", $newid, $creator, $name, $creator, 0, 'true');
                    $sql->Query("
                        INSERT INTO `projects_data`
                        (`name`, `what`, `title`, `to`, `level`)
                        VALUES
                        (%d, %s, %s, %s, %d)
                    ", $newid, 'branch', 'Master', $user, 0);
                    $sql->Query("
                        INSERT INTO `projects_data`
                        (`name`, `what`, `branch`, `to`, `level`)
                        VALUES
                        (%d, %s, %s, %d, %d)
                    ", $newid, 'privilege', 'Master', $user, 0);
                    var_dump();
                    //die('Project has been created.');
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'getMembers'){
        //get all the members from the project in a list
        //no longer implemented, but you might find it useful
        $name = $_POST['name'];
        $sql = new SQL;
        $result = $sql->Query("SELECT DISTINCT `projectname`, `creator`, `person`, `privilege` FROM `projects_invited` WHERE `id` = %d AND `accepted` = %s", $name, 'true');
        if(mysql_num_rows($result) == 0) echo '<script>alert("HOLY FREAKING....!!!!!!! That was a crazy huge error. You might want to refresh, or maybe even run for your life. If problems persist, contact the local law enforcement, or infinity staff.");</script>';
        while($row = mysql_fetch_assoc($result)){
            $creator = $row['creator'];
            $person = $row['person'];
            $privilege = $row['privilege'];
            //Highlight creator bolden user
            if($person == $_SESSION['ID']) $person = '<a onclick="getUser('.$person.');"><b>'.id2user($person, 'id2user').'</b></a>'; 
            elseif($person == $creator) $person = '<a onclick="getUser('.$person.');"><span style="color: gold">'.id2user($person, 'id2user').'</span></a>';
            else $person = id2user($person, 'id2user');
            echo '<a onclick="getUser('.id2user($person, 'user2id').');">'.$person.'</a><br /><br />';
        }
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'change'){
        //update project information
        $sql = new SQL;
        $sql->Query("
            UPDATE `projects`
            SET 
            `name` = %s, `description` = %s, `category` = %s
            WHERE `id` = %s
        ", $_POST['name'], $_POST['description'], $_POST['category'], $_POST['current']);
        $sql->Query("
            UPDATE `projects_invited`
            SET
            `projectname` = %s
            WHERE `id` = %d
        ", $_POST['name'], $_POST['current']);
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'updateStatus'){
        //just change their status to whatever they set
        $sql = new SQL;
        $projectname = $_POST['projectname'];
        $status = $_POST['status'];
        $sql->Query("UPDATE `projects_invited` SET `status` = %s WHERE `id` = %d AND `person` = %d", $status, $projectname, $_SESSION['ID']);
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'deleteProject'){
        $name = $_POST['name'];
        //these functions just make sure they have access to the project and they have the right privilege
        //check out frameowrk.php for more info
        $sessionusr->verify_id_access($name);
        $sessionusr->verify_privilege_access(0, $name);
        $sql = new SQL;
        //delete all data from the trillion different tables i have
        $sql->Query("DELETE FROM `projects` WHERE `id` = %d", $name);
        $sql->Query("DELETE FROM `projects_invited` WHERE `id` = %d", $name);
        $sql->Query("DELETE FROM `projects_data` WHERE `name` = %d", $name);
        $sql->Query("DELETE FROM `projects_comments` WHERE `projectname` = %d", $name);
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'leaveProject'){
        //delete user from projects invited, and delete his privileges from projects data
        //keep all his contributions though
        $projectname = $_POST['projectname'];
        $user = $_POST['user'];
        if($user == $_SESSION['ID']){
            //make sure its not some random guy deleting your stuff
            $sql = new SQL;
            $sql->Query("DELETE FROM `projects_invited` WHERE `id` = %d AND `person` = %d", $projectname, $user);
            $sql->Query("DELETE FROM `projects_data` WHERE `name` = %d AND `to` = %d AND `what` = %s", $projectname, $user, 'privilege');
            die();
        }else{
            //log in suspicious
            die();
        }
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'removeMember'){
        //same thing as above, but this time the creators doing it so different security measures have to be made
        $projectname = $_POST['projectname'];
        $sessionusr->verify_id_access($projectname);
        $sessionusr->verify_privilege_access(0, $projectname);
        $user = $_POST['user'];
        $sessionusr->verify_selected_person_access($projectname, $user, 2);
        $sql = new SQL;
        $sql->Query("DELETE FROM `projects_invited` WHERE `id` = %d AND `person` = %d", $projectname, $user);
        $sql->Query("DELETE FROM `projects_data` WHERE `name` = %d AND `to` = %d AND `what` = %s", $projectname, $user, 'privilege');
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'setAnotherRole'){
        //set the role of somebaody to what they want
        $projectname = $_POST['projectname'];
        $sessionusr->verify_id_access($projectname);
        //only supervisors+ can do this
        $sessionusr->verify_privilege_access(2, $projectname);
        $newRole = $_POST['newRole'];
        $whichMember = $_POST['whichMember'];
        $sessionusr->verify_selected_person_access($projectname, $whichMember, 1);
        $sql = new SQL;
            $sql->Query("
                UPDATE `projects_invited`
                SET `role` = %s
                WHERE `id` = %d
                AND `person` = %d
            ", $newRole, $projectname, $whichMember);
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'requests'){
        //view requests for the selected project
        $projectname = $_POST['projectname'];
        $sql = new SQL;
        $requests = $sql->Query("SELECT * FROM `projects_invited` WHERE `creator` = %d AND `accepted` = %s AND `id` = %d", $_SESSION['ID'], 'false', $projectname);
        echo '<div id="head"><h2>Requests</h2></div><hr /><div id="content">';
        if(mysql_num_rows($requests) == 0){
            die("<h5>You have no requests.</h5>");
        }else{
            while($row = mysql_fetch_assoc($requests)){
                $person = id2user($row['person'], 'id2user');
                $request = $row['request'];
                $name = $row['projectname'];
                echo 'Request for <b>'.$name.'</b>,<br />From: '.$person.'<br /><div class="member_block">'.$request.'</div><br /><button onclick="acceptMember('.id2user($person, 'user2id').', \''.$projectname.'\');">Accept</button> | <button onclick="denyMember('.id2user($person, 'user2id').', \''.$projectname.'\');">Deny</button>';
            }
        }
        die('</div>');
    }
    //handling allowing or denying requests
    if(isset($_POST['signal']) && $_POST['signal'] == 'acceptMember' || $_POST['signal'] == 'denyMember'){
        $sql = new SQL;
        $signal = $_POST['signal'];
        $user = $_POST['user'];
        $projectname = $_POST['projectname'];
        $sessionusr->verify_id_access($projectname);
        $sessionusr->verify_privilege_access(0, $projectname);
        $result = $sql->Query("SELECT `title` FROM `projects_data` WHERE `name` = %d AND `what` = %s", $projectname, 'branch');
        if($signal == 'acceptMember'){
            //insert them into the project
            $sql->Query("
                UPDATE `projects_invited`
                SET
                `accepted` = %s
                WHERE `id` = %d
                AND `person` = %d
            ", 'true', $projectname, $user);
            //give them observer privileges on each branch
            while($row = mysql_fetch_assoc($result)){
                //loop through all the branches and assign them a privilege for each one (observer)
                $branch = $row['title'];
                $sql->Query("INSERT INTO `projects_data` (`name`, `what`, `to`, `level`, `branch`) VALUES (%d, %s, %d, %d, %s)", $projectname, 'privilege', $user, 4, $branch);
            }
            die();
        }elseif($signal == 'denyMember'){
            //delete that shit
            $sql->Query("
                DELETE FROM `projects_invited`
                WHERE `id` = %d
                AND `person` = %d
            ", $projectname, $user);
        }
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'messages'){
        //this is the form and display of messages
        //pretty simple, just echo out the forum with a select box of members
        //then echo out messages they have
        $projectname = $_POST['projectname'];
        echo "
            <div id='head'><h2>Messages</h2></div><div id='content'><a id='btn' onclick='$(this).next().next().next().slideToggle();'>CMS</a><br /><br /><div class='cms'>
            <b>Send To: </b>
            <select class='msgSelect'>";
                $sql = new SQL;
                $result = $sql->Query("
                    SELECT DISTINCT 
                    `projectname`, `creator`, `person`
                    FROM `projects_invited`
                    WHERE `id` = %d
                    AND `accepted` = %s
                ", $projectname, 'true');
                    while($row = mysql_fetch_assoc($result)){
                        $person = $row['person'];
                        if($person != $_SESSION['ID']){
                            echo '<option>'.id2user($person, 'id2user').'</option>';
                        }
                    }
       echo "     
            </select>
            <br /><input class='msgsubject'type='text' placeholder='Subject'/>
            <br /><textarea id='bigtxt'class='msgbody'></textarea><br /><br />
            <a id='btn' onclick='msgSend(\"".$projectname."\")'>Send</a><br /><br /><span class='ifSent'></span>
            </div><hr />
        ";
        $messages = $sql->Query("
            SELECT * FROM
            `projects_data`
            WHERE `to` = %d
            AND `what` = %s
            AND `name` = %d
            ORDER BY `date` DESC
        ", $_SESSION['ID'], 'message', $projectname);
        if(mysql_num_rows($messages) == 0){
            die("You don't have any messages yet.</div>");
        }else{
            while($get = mysql_fetch_assoc($messages)){
                $by = $get['by'];
                $by = id2user($by, 'id2user');
                $date = $get['date'];
                $title = $get['title'];
                $body = $get['body'];
                $id = $get['id'];
                echo "
                    <div class='member_block'>
                        <div><a onclick='alert(\"Maybe show a popup with a reply form. Thats a design prinicple more so then a feature, so ill let relax do it.\");'>Reply</a> | <a onclick='deleteuni(4, ".$id.", \"messages\");'>Delete</a></div>
                        <br />
                        <b>From:</b> ".$by.", ".$date."<br />
                        <b>".$title."</b><br />
                        ".$body."
                    </div><br />
                ";
            }
        }
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'msgSend'){
        //send a message
        $projectname = $_POST['projectname'];
        $subject = $_POST['subject'];
        $body = $_POST['body'];
        $by = $_SESSION['ID'];
        $who = $_POST['who'];
        $who = id2user($who, 'user2id');
        //make sure the person they are sending it to is actually part of the project
        $sessionusr->verify_selected_person_access($projectname, $who, 1);
        $what = 'message';
        $date = date('Y-m-d H:i:s');
        $sql = new SQL;
        //just stick it in
        $sql->Query("
            INSERT INTO `projects_data`
            (`name`, `what`, `by`, `date`, `title`, `body`, `to`)
            VALUES
            (%d, %s, %d, %s, %s, %s, %d)
        ", $projectname, $what, $by, $date, $subject, $body, $who);
        die("Message Sent.");
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'newDoc'){
        //create/suggest a document
        $projectname = $_POST['projectname'];
        $title = $_POST['title'];
        $body = $_POST['body'];
        $date = date('Y-m-d H:i:s');
        $what = 'document';
        $by = $_SESSION['ID'];
        $branch = $_POST['branch'];
        if(strlen($title) > 2 && strlen($body) > 5){
            //make sure they are at least a member
            $sessionusr->verify_id_access($projectname);
            $sessionusr->verify_privilege_access(3, $projectname, $branch);
            $sql = new SQL;
            if($_POST['num'] == 1){
                //create
                $sql->Query("
                    INSERT INTO `projects_data`
                    (`name`, `what`, `by`, `date`, `title`, `body`, `branch`)
                    VALUES
                    (%d, %s, %d, %s, %s, %s, %s)
                ", $projectname, $what, $by, $date, $title, $body, $branch);
            }else{
                //suggest
                $sql->Query("
                    INSERT INTO `projects_data`
                    (`name`, `what`, `by`, `date`, `title`, `body`, `branch`, `suggest`)
                    VALUES
                    (%d, %s, %d, %s, %s, %s, %s, %d)
                ", $projectname, $what, $by, $date, $title, $body, $branch, 1);
            }
        }
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'newTask'){
        //create/update/suggest tasks
        $projectname = $_POST['projectname'];
        $title = $_POST['title'];
        $body = $_POST['body'];
        $date = date("Y:m:d H-i-s");
        $what = $_POST['what'];
        $by = $_SESSION['ID'];
        $txtto = $_POST['to'];
        $branch = $_POST['branch'];
        if(strlen($title) > 2 && strlen($body) > 5){
            //must be a supervisor with access ofc
            $sessionusr->verify_id_access($projectname);
            $sessionusr->verify_privilege_access(2, $projectname, $branch);
            $sql = new SQL;
            if($_POST['num'] == 1){
                //create
                $sql->Query("
                    INSERT INTO `projects_data`
                    (`name`, `what`, `by`, `date`, `title`, `body`, `txtto`, `branch`)
                    VALUES
                    (%d, %s, %d, %s, %s, %s, %d, %s)
                ", $projectname, $what, $by, $date, $title, $body, $txtto, $branch);
            }elseif($_POST['num'] == 3){
                //suggest
                $sql->Query("
                    INSERT INTO `projects_data`
                    (`name`, `what`, `by`, `date`, `title`, `body`, `txtto`, `branch`, `suggest`)
                    VALUES
                    (%d, %s, %d, %s, %s, %s, %d, %s, %d)
                ", $projectname, $what, $by, $txtdate, $title, $body, $txtto, $branch, 1);
            }else{
                //update
                $sql->Query("UPDATE `projects_data` SET `date` = %s, `title` = %s, `body` = %s, `txtto` = %d WHERE `id` = %d", $date, $title, $body, $txtto, $projectname);
            }
        }
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'taskStatus'){
        //complete a task or almost/incomplete it
        $level = $_POST['newStatus'];
        //they completed it! add it to a db
        if($level == 3){
            $mark = $_SESSION['ID'];
        }else{
            //its still incomplete
            $mark = 0;
        }
        $id = $_POST['id'];
        $sessionusr->verify_id_access($id);
        //must be a member
        $sessionusr->verify_privilege_access(3, $id);
        $sql = new SQL;
        //update it
        $sql->Query("
            UPDATE `projects_data`
            SET `level` = %d,
            `mark` = %d
            WHERE `what` = %s
            AND `id` = %d
        ", $level, $mark, 'task', $id);
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'updateDoc'){
        //update a document
        $id = $_POST['id'];
        $doctitle = $_POST['doctitle'];
        $docbody = $_POST['docbody'];
        $sessionusr->verify_id_access($id);
        $sessionusr->verify_privilege_access(3, $id);
        $sql = new SQL;
        $sql->Query("UPDATE projects_data SET title = %s, body = %s WHERE id = %d", $doctitle, $docbody, $id);
        echo $id;
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'deleteBranch'){
        //delete the branch and everything its ever loved
        $branch = $_POST['branch'];
        $pname = $_POST['pname'];
        $sessionusr->verify_id_access($pname);
        $sessionusr->verify_privilege_access(0, $pname);
        if($pname == ''){
            die();
        }
        $sql = new SQL;
        //delete actual branch
        $sql->Query("DELETE FROM projects_data WHERE what = %s AND title = %s AND name = %d", 'branch', $branch, $pname);
        //delete associated stuff
        $sql->Query("DELETE FROM projects_data WHERE branch = %s AND name = %d", $branch, $pname);
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'deleteuni'){
        //this deletes any type of data
        $id = $_POST['id'];
        $priv = $_POST['priv'];
        $sessionusr->verify_id_access($id);
        $sessionusr->verify_privilege_access($priv, $id);
        $sql = new SQL;
        $sql->Query("DELETE FROM `projects_data` WHERE `id` = %d", $id);
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'createBranch'){
        //create a new branch
        $newBranch = $_POST['newBranch'];
        if($newBranch != 'Master'){
            $pname = $_POST['pname'];
            $sessionusr->verify_id_access($pname);
            //must be a manager
            $sessionusr->verify_privilege_access(1, $pname);
            $sql = new SQL;
            //create the actual branch
            $sql->Query("INSERT INTO projects_data (what, title, name) VALUES (%s, %s, %d)", 'branch', $newBranch, $pname);
            $result = $sql->Query("SELECT person, creator FROM projects_invited WHERE id = %d", $pname);
            while($row = mysql_fetch_assoc($result)){
                //loop through all the members of the project and add them to the branch as observers
                $person = $row['person'];
                $creator = $row['creator'];
                $privilege = ($person == $creator) ? 0 : 4;
                //add them as an observer. unless they are the creator, where you add as creator ofc
                $sql->Query("INSERT INTO `projects_data` (`name`, `what`, `branch`, `to`, `level`) VALUES (%d, %s, %s, %d, %d)", $pname, 'privilege', $newBranch, $person, $privilege);
            }
            die();
        }else{
            //Do Nothing
        }
        die();
    }
    //Member page for current project!
    if(isset($_POST['signal']) && $_POST['signal'] == 'getUser'){
        //get a members contributions, pending tasks, and recent activity
        $id = $_POST['id'];
        $project = $_POST['project'];
        $sql = new SQL;
        //created by user
        $result = $sql->Query("SELECT * FROM `projects_data` WHERE `by` = %d AND name = %d AND what != %s AND what != %s AND what != %s AND suggest = %d ORDER BY `date` DESC", $id, $project, 'branch', 'privilege', 'message', 0);
        //created everywhere
        $result2 = $sql->Query("SELECT * FROM projects_data WHERE name = %d AND what != %s AND what != %s AND what != %s AND suggest = %d ORDER BY `date` DESC", $project, 'branch', 'privilege', 'message', 0);
        //completed by user
        $result_tasks = $sql->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `mark` = %d AND name = %d AND suggest = %d ORDER BY `date` DESC", 'task', $id, $project, 0);
        //completed everywhere
        $result_tasks2 = $sql->Query("SELECT * FROM `projects_data` WHERE `mark` != %d AND name = %d AND suggest = %d ORDER BY `date` DESC", 0, $project, 0);
        // a bit of math, just getting how much theyve done compared to others
        $user_done = mysql_num_rows($result) + mysql_num_rows($result_tasks);
        $all_done = mysql_num_rows($result2) + mysql_num_rows($result_tasks2);
        //show a percentage of what theyve contributed
        if($user_done == 0){
            $percent = '0%';
        }else{
            $decimal = $user_done / $all_done;
            $percent = round($decimal * 100);
            $percent = $percent.'%';
        }
        $result3 = $sql->Query("SELECT * FROM projects_data WHERE what = %s AND txtto = %d AND level != %d AND suggest = %d ORDER BY `date` DESC", 'task', $id, 3, 0);
        $result4 = $sql->Query("SELECT * FROM `projects_invited` WHERE `person` = %d AND `id` = %d", $id, $project);
        $row4 = mysql_fetch_assoc($result4);
        //also echo a fraction of what they contributed
        echo '
            <div id="head"><h2>'.ucfirst(id2user($id)).'</h2></div><div id="content"><a id="btn" onclick="retrieve(\'groups\');">Back</a><hr /><br />
            '.$percent.' of this project was contributed by '.id2user($id).' ('.$user_done.'/'.$all_done.').<hr />';
            echo '<h4>Info:</h4>';
            //show their role and status
            echo 'Role: '.$row4['role'].', Status: '.$row4['status'];
            if($row4['person'] == $row4['creator']){
                echo '<br /><br /><b>Project Creator</b>';
            }
            //show their email
            echo '<hr /><h4>Email:</h4>';
            $emailq = $sql->Query("SELECT `email` FROM `members` WHERE `id` = %d", $id);
            $email = mysql_fetch_assoc($emailq);
            echo $email['email'];
            //all tasks/milestones that are incomplete and assigned to them
            echo '
            <hr />
            <h4>Pending Assignments:</h4>';
            if(mysql_num_rows($result3) == 0){
                echo 'No pending tasks or milestones.';
            }
            while($row3 = mysql_fetch_assoc($result3)){
                tasks($row3['level'], $row3['id'], $row3['title'], $row3['txtdate'], $row3['txtto'], $row3['body'], 1, $row3['branch']);
            }
            //all the stuff theyve done recently
            echo
            '<hr />
            <h4>Recent Activity:</h4>
        ';
        //stuff they created
        $result4 = $sql->Query("SELECT * FROM `projects_data` WHERE `by` = %d AND `name` = %d AND `what` != %s AND `what` != %s AND `what` != %s AND `suggest` = %d ORDER BY `date` DESC LIMIT 4", $_POST['id'], $project, 'branch', 'privilege', 'message', 0);
        //stuff they compleetd
        $result5 = $sql->Query("SELECT * FROM `projects_data` WHERE `by` = %d AND `name` = %d AND `what` != %s AND `what` != %s AND `what` != %s AND `mark` = %d AND `suggest` = %d ORDER BY `date` DESC LIMIT 4", $_POST['id'], $project, 'branch', 'privilege', 'message', $id, 0);
        if(mysql_num_rows($result4) == 0 && mysql_num_rows($result5) == 0){
            die('No recent activity.');
        }else{
            while($row4 = mysql_fetch_assoc($result4)){
                $what2 = $row4['what'];
                echo '<a style="cursor:pointer;" onclick="getOne('.$row4['id'].');"><b>('.$row4['branch'].') '.ucfirst($what2).':</b> '.$row4['title'].', By: <b>'.id2user($row4['by']).'</b>, '.$row4['date'].' ('.$row4['branch'].')</a><br /><br /><br />';
            }
            while($row5 = mysql_fetch_assoc($result5)){
                //link to the data
                echo '<a onclick="getOne('.$row5['id'].');">'.ucfirst(id2user($row5['mark'])).' completed the task <b>'.$row5['title'].'</b> ('.$row5['branch'].')</a><br /><br />';
            }
        }
        die('</div>');
    }
    //Get only one specific element from projects_data
    if(isset($_POST['signal']) && $_POST['signal'] == 'getOne'){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $kind = (isset($_POST['kind'])) ? $_POST['kind'] : '';
        $sessionusr->verify_id_access($id);
        $sql = new SQL;
        //make sure the id of the data is there
        $result = $sql->Query("SELECT * FROM projects_data WHERE id = %d AND what != %s AND what != %s ORDER BY date DESC", $id, 'message', 'branch');
        if(mysql_num_rows($result) == 0){
            //Error
            die("That's strange: there must have been some sort of error. The requested data does not exist.");
        }else{
            echo "<div id='head'><h2>".id2projectname($name)."</h2></div><div id='content'><a id='btn' onclick='back();'>Back</a><hr />";
            while($row = mysql_fetch_assoc($result)){
                //what kid of data is it? if they want to edit it, show them an edit form
                //otherwise just show the data
                switch($row['what']){
                    case 'document':
                        if($kind != 'edit'){
                            echo "
                                <br />
                                <div class='member_block'>
                                    <b>".$row['title']."</b>, By: ".id2user($row['by']).": ".$row['date']."<br />
                                    ".$row['body']."
                                </div>
                                <br /><br />
                                <a id='btn' onclick='getOne(".$row['id'].", \"edit\");'>Edit</a>&nbsp;<a id='btn' onclick='deleteuni(1, ".$row['id'].", \"boards\");'>Delete</a>
                                ";
                            echo '<br /><br /><br /><b>Comment:</b><br /><textarea class="commentbox"placeholder="Comment"></textarea><br /><br /><a id="btn" onclick="commentOne('.$row['id'].');">Comment</a><br /><br />';
                            showComments($id);
                        }else{
                            echo "
                                <div class=\"member_block\"style='margin-bottom:5px;'>
                                    By: ".id2user($row['by']).", ".$row['date']."<br />
                                    <input type='text' value='".$row['title']."' style='width:100%;' class='doctitle".$row['id']."'/><br />
                                    <textarea id='bigtxt'style='width:100%;' class='docbody".$row['id']."'>
                                    ".$row['body']."
                                    </textarea><br /><br />
                                <a id='btn' onclick='deleteuni(1, ".$row['id'].", \"boards\")'>Delete</a>&nbsp;<a id='btn' onclick='updateDoc(".$row['id'].")'>Update</a>
                                </div>
                                <br /><br />
                            ";
                        }
                        break;
                        die();
                    case 'task':
                        //tasks($row['level'], $id, $row['title'], $row['date'], $row['to'], $row['body']);
                       if($kind != 'edit'){
                            tasks($row['level'], $id, $row['title'], $row['date'], $row['txtto'], $row['body'], 2, $row['branch']);
                            echo "<br /><a id='btn' onclick='getOne(".$row['id'].", \"edit\");'>Edit</a>&nbsp;<a id='btn' onclick='deleteuni(1, ".$id.", \"tasks\");'>Delete</a>";
                            echo '<br /><br /><br /><b>Comment:</b><br /><textarea class="commentbox"placeholder="Comment"></textarea><br /><br /><a id="btn" onclick="commentOne('.$row['id'].');">Comment</a><br /><br />';
                            showComments($id);
                        }else{
                            echo '
                                Title:<br /> <input class="taskname" type="text" value="'.$row['title'].'"/><br />
                                Date:<br /> <input class="taskdate"type="text" value="'.$row['date'].'"/><br />
                                Description:<br /> <textarea class="taskdesc"id="bigtxt">'.$row['body'].'</textarea><br />
                                ';
                            echo 'Assign to: <select class="taskto">';
                                select_users($name, 1);
                            echo '</select><br />';
                            echo '
                                <br /><br /><a id="btn" onclick="deleteuni(1, '.$row['id'].', \'tasks\')">Delete</a>&nbsp;<a id="btn" onclick="createTask('.$row['id'].', 2)">Update</a>
                            ';
                        }
                        break;
                        die();
                    case 'file':
                        echo "
                        
                        ";
                        break;
                        die();
                    case 'milestone':
                        echo "
                        
                        ";
                        break;
                        die();
                }
            }
        }
        die('</div>');
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'commentOne'){
        //comment on something
        $sql = new SQL;
        $sql->Query("INSERT INTO `projects_comments` (`projectname`, `by`, `comment`, `date`, `id2`) VALUES (%d, %d, %s, %s, %d)", $_POST['name'], $_SESSION['ID'], $_POST['comment'], date('Y:m:d H-i-s'), $_POST['id']);
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'fillSearchSpan'){
        //fill in the search bar and add a search script. must be done in php because it need the current project + security
        //can be done in JS, but a better search function may make that impossible
        $name = $_POST['name'];
        $branch = $_POST['branch'];
        $sql = new SQL;
        $result = $sql->Query("SELECT name FROM projects_data WHERE name = %d AND branch = %s", $name, $branch);
        $row = mysql_fetch_assoc($result);
        die(
            "
            <input type='text' class='searchbar' placeholder='Search' autofocus/>
            <script>
                $('.searchbar').keyup(function(e){
                    if(e.keyCode == 13){
                    search(".$row['name'].");
                    }
                });
            </script>"
        );
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'search'){
        //just so their search results
                $name = $_POST['id'];
                $branch = $_POST['branch'];
                $search = '%'.$_POST['search'].'%';
                echo '<div id="head"><h2>'.id2projectname($name).'</head></h2><hr /><div id="content">';
                $sql = new SQL;
                if($branch != 'Master'){
                    $data = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` != %s AND `what` != %s AND `what` != %s AND `title` LIKE %s AND `suggest` = %d ORDER BY `date` DESC", $name, 'message', 'privilege', 'branch', $search, 0);
                }else{
                    $data = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` != %s AND `what` != %s AND `what` != %s AND `branch` = %s AND `title` LIKE %s AND `suggest` = %d ORDER BY `date` DESC", $name, 'message', 'privilege', 'branch', $branch, $search, 0);
                }
                if(mysql_num_rows($data) == 0){
                    die('No search results.');
                }else{
                    while($recent = mysql_fetch_assoc($data)){
                        echo '<a style="cursor:pointer;" onclick="getOne('.$recent['id'].');"><b>('.$recent['branch'].') '.ucfirst($recent['what']).':</b> '.$recent['title'].', By: <b>'.id2user($recent['by']).'</b>, '.$recent['date'].' ('.$recent['branch'].')</a><br /><br /><br />';
                    }
                }
                die('</div>');
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'branchPrivilege'){
        //allow the project creator to set a privilege for that branch
        $person = $_POST['person'];
        $name = $_POST['name'];
        $id = $_POST['id'];
        $privilege = $_POST['privilege'];
        $sessionusr->verify_id_access($name);
        $sessionusr->verify_privilege_access(0, $name);
        $sessionusr->verify_selected_person_access($name, $person, 1);
        $sql = new SQL;
        $sql->Query("UPDATE `projects_data` SET `level` = %d WHERE `to` = %d AND `branch` = %s AND `name` = %d AND `what` = %s", $privilege, $person, $name, $id, 'privilege');
        die();
    }
    /*
     *For launching projects
     *0 = Not launched
     *1 = Launched as project
     *2 = Launched as a job
    */
    if(isset($_POST['signal']) && $_POST['signal'] == 'launchForm'){
        //show the form for launching a project
        $projectname = $_POST['projectname'];
        $sql = new SQL;
        $result = $sql->Query("SELECT * FROM projects WHERE id = %d", $projectname);
        $row = mysql_fetch_assoc($result);
        if($row['creator'] == $_SESSION['ID']){
            $isCreator = true;
        }else{
            $isCreator = false;
        }
        //only the creator can see this
        if($isCreator){
            //just show them wheteher or not they already launched and as what, else show buttons to launch
            if($row['launched'] == 0){
                echo '<div id="head"><h2>Launch</h2></div><hr /><div id="content">Information:<br /><div class="member_block">
                Launch a project to make it known to the community. You may either launch it as a project, or as a job. Once launched, other people can view and join your project/job.
                </div><br /><br /><a id="btn" onclick="launch(1, '.$projectname.');">Launch as Project</a><br /><br /><a id="btn" onclick="launch(2, '.$projectname.');">Launch as Job</a>';
            }else{
                $what = ($row['launched'] == 1) ? 'project' : 'job';
                echo "<div id='head'><h2>Launch</h2></div><hr /><div id='content'>You have launched this as a ".$what.".<br /><br /><a id='btn' onclick='launch(0, ".$projectname.")'>Un-Launch</a>";
            }
            die();
        }else{
            echo "<div id='head'><h2>Launch</h2></div><hr /><div id='content'>Only the Project Creator can launch the project.</div>";
        }
        die('</div>');
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'launch'){
        $id = $_POST['id'];
        $sessionusr->verify_privilege_access(0, $id);
        $sql = new SQL;
        $sql->Query("UPDATE `projects` SET `launched` = %d WHERE `id` = %d", $_POST['secsignal'], $id);
        die();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'help'){
        echo '<div id="head"><h2>Help</h2></div><hr /><div id="content">';
        $sql = new SQL;
        $branch = $_POST['branch'];
        $name = $_POST['projectname'];
        $onUserID = $_SESSION['ID'];
        $result = $sql->Query("SELECT * FROM `projects_data` WHERE `branch` = %s AND `name` = %d AND `to` = %d AND `what` = %s", $branch, $name, $onUserID, 'privilege');
        $row = mysql_fetch_assoc($result);
        if(mysql_num_rows($result) == 0){
            //log suspicious activity
            //redirect
            die();
        }else{
            //show different info depending on tehir privilege
            $sessionusr->switch_level($row['level']);
        }
        die('</div>');
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'confirm'){
        //Confirm project suggestion
        $sql = new SQL;
        $sessionusr->verify_privilege_access(0, $_POST['projectID']);
        $sql->Query("UPDATE `projects_data` SET `suggest` = %d WHERE `id` = %d", 0, $_POST['id']);
        echo 'done';
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'calendar'){
        if(isset($_POST['user']) && isset($_POST['date']) && isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['project'])){
                    $sessionusr->verify_project_access($_POST['project']);
                    $sessionusr->verify_privilege_access(0, $_POST['project']);
                    echo insert($_POST['user'], $_POST['date'], $_POST['desc'], $_POST['title'], $_POST['project']);
                    die();
                }else if(isset($_POST['calendar']) && isset($_POST['month']) && isset($_POST['year']) && is_numeric($_POST['month']) && is_numeric($_POST['year'])){
                    echo calendar($_POST['month'], $_POST['year']);
                    die();
                }else if(isset($_POST['get']) && $_POST['get'] == "data" && isset($_POST['date']) && isset($_POST['project'])){
                    $sessionusr->verify_project_access($_POST['project']);
                    echo getData($_POST['date'], $_POST['project']);
                    die();
                }else{
                    //die("error");
                    die();
                }
    }