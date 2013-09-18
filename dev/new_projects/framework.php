<?php
    //includes
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    //interfaces
    interface security{
        //security functions
        public function verify_project_access($id);
        public function verify_id_access($id);
        public function verify_privilege_access($which, $projectID, $branch = 'Master');
        public function verify_selected_person_access($projectID, $personID, $type = 1);
    }
    //Classes(Neccesary for privileges)
    class Person implements security{
        //Global data / Security here
        private function end_message($result){
            if(mysql_num_rows($result) == 0){ 
                //Access Denied
                echo '
                    <script>
                        //alert("Run for your life, hacker, im going to fucking kill you. If there\'s been some kind of a mistake, and your really innocent, contact Infinity Staff. Your activity has been logged. And no, you don\'t have access to this project.");
                        alert("I know you hackin bro");
                        //window.location.reload(true);
                    </script>';
                //Log in suspicious activity
                return false;
            }else{
                //Access Granted
                return true;
            }
        }
        public function switch_level($privilege){
            //show 'help' information depending on the privilege
            echo '<br />Privileges from greatest to least: Creator, Manager, Supervisor, Member, Observer.<br /><br />';
            switch($privilege){
                //Creator
                case 0:
                    echo 'You are the Creator of this project.';
                    echo '
                        <br /><br />
                        <b>What you can do:</b><br /><br />
                        1. Full access to everything.<br /><br />
                        2. Add new members.<br /><br />
                        3. Change member privileges.<br /><br />
                        4. Delete your project.<br /><br />
                        5. Assign roles and manage groups.<br /><br />
                        6. Create, edit, and delete all tasks, documents, posts, files, and milestones.<br /><br />
                        7. Manage branches.<br /><br />
                        8. Edit project information/name.<br /><br />
                        9. Send messages<br /><br />
                        10. Launch your project/job to the public.<br /><br />
                        11. Confirm/delete project suggestions
                    ';
                    break;
                //Manager
                case 1:
                    echo 'You are a Manager in this branch.';
                    echo '
                        <br /><br />
                        <b>What you can do:</b><br /><br />
                        1. Create, edit, assign and delete all tasks, documents, files, and milestones.<br /><br />
                        2. Create new branches.<br /><br />
                        3. Make posts.<br /><br />
                        5. Assign roles and manage groups.<br /><br />
                        6. Edit project information/name.<br /><br />
                        7. Send messages.<br /><br />
                        8. Leave the project.<br /><br />
                        9. Make project suggestions.
                    ';
                    break;
                //Supervisor
                case 2:
                    echo 'You are a supervisor in this branch.';
                    echo '
                        <br /><br />
                        <b>What you can do:</b><br /><br />
                        1. Create, edit, and assign all tasks, documents, and files.<br /><br />
                        2. Make posts.<br /><br />
                        3. Assign roles and manage groups.<br /><br />
                        4. Send messages.<br /><br />
                        5. Leave the project.<br /><br />
                        6. Make project suggestions.
                    ';
                    break;
                //Member
                case 3:
                    echo 'You are a member in this branch.';
                    echo '
                        <br /><br />
                        <b>What you can do:</b><br /><br />
                        1. Create documents and files.<br /><br />
                        2. Edit documents.<br /><br />
                        3. Make posts.<br /><br />
                        4. Send messages.<br /><br />
                        5. Leave the project.<br /><br />
                        6. Make project suggestions.
                    ';
                    break;
                //Observer
                case 4:
                    echo 'You are an observer in this branch.';
                    echo '
                        <br /><br />
                        <b>What you can do:</b><br /><br />
                        1. View project information.<br /><br />
                        2. Send messages.<br /><br />
                        3. Make project suggestions.
                    ';
                    break;
                //Observer
                default:
                    //Report suspicious activity: redirect
            }
        }
        public function verify_project_access($id){
            //See if they have legitimite access to project data
            $sql = new SQL;
            $result = $sql->Query("SELECT `id` FROM `projects_invited` WHERE `person` = %d AND `id` = %d", $_SESSION['ID'], $id);
            $this->end_message($result);
        }
        public function verify_id_access($id){
            //See if they have access to the id they are trying to access
            $sql = new SQL;
            $result = $sql->Query("SELECT * FROM projects_data WHERE id = %d", $id);
            $row = mysql_fetch_assoc($result);
            $id2 = $row['name'];
            $result2 = $sql->Query("SELECT * FROM projects_invited WHERE id = %d AND person = %d", $id2, $_SESSION['ID']);
            $this->end_message($result2);
        }
        public function verify_privilege_access($which, $projectID, $branch = 'Master'){
            //See if they have the correct privileges in that branch and projects
            $sql = new SQL;
            $result = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `branch` = %s AND `what` = %s AND `to` = %d AND `level` <= %d", $projectID, $branch, 'privilege', $_SESSION['ID'], $which);
            $this->end_message($result);
        }
        public function verify_selected_person_access($projectID, $personID, $type = 1){
            //For sending messages/groups
            //Makes sure the selected person is actually in the project
            $sql = new SQL;
            if($type == 1){
                //if type == 1, the the person CAN be $_SESSION['ID']
                $result = $sql->Query("SELECT * FROM `projects_invited` WHERE `id` = %d AND `person` = %d", $projectID, $personID);
            }else{
                //if type == 2, the person CANNOT be $_SESSION['ID']
                $result = $sql->Query("SELECT * FROM `projects_invited` WHERE `id` = %d AND `person` = %d AND `person` != %d", $projectID, $personID, $_SESSION['ID']);
            }
            $this->end_message($result);
        }
    }
    class Observer extends Person{
        public function Suggest($name, $branch){
            //form for suggesteing either a task or a document
            echo '
            <br /><br />Suggest a
            <select class="form_select"onchange="switchForm();">
                <option>Document</option>
                <option>Task</option>
            </select>:<br /><br />
            ';
            echo '
                <div class="docform">
                    <input type="text"class="doctitle"placeholder="Title"/><br />
                    <textarea id="bigtxt"class="docbody"></textarea><br /><br />
                    <a id="btn"onclick="docCreate(\''.$name.'\', 2);">Suggest</a><br /><br />
                </div>
            ';
           echo '
           <div class="taskform" style="display:none;">
               Assign to: <select class="taskto">';
               select_users($name, 1);
                echo '</select>';
                echo '
                    <br />
                    <input class="taskname"type="text" placeholder="Task Name"/><br />
                    <input class="taskdate"type="text" placeholder="Due Date"/><br />
                    <textarea id="bigtxt"class="taskdesc"placeholder="Description"></textarea><br /><br />
                    <a id="btn" onclick="createTask(\''.$name.'\', 3)">Suggest</a>
                </div>
            ';
        }
        public function viewTasks($name, $branch){
            $sql = new SQL;
            if($branch == 'Master'){
                $result = $sql->Query("
                SELECT * FROM `projects_data`
                WHERE `name` = %d
                AND `what` = %s
                AND `suggest` = %d
                ORDER BY `date` DESC
                ", $name, 'task', 0);
            }else{
                $result = $sql->Query("
                SELECT * FROM `projects_data`
                WHERE `name` = %d
                AND `what` = %s
                AND `branch` = %s
                AND `suggest` = %d
                ORDER BY `date` DESC
                ", $name, 'task', $branch, 0);
            }
            if(mysql_num_rows($result) == 0){ 
                echo "No tasks have been created yet.";
            }else{
                while($row = mysql_fetch_assoc($result)){
                        echo '
                            <b class="first"style="cursor:pointer;"onclick="$(this).next().next().slideToggle();">'.$row['title'].': '.$row['txtdate'].' ('.$row['txtto'].') Branch: '.$branch.'</b><br />
                            <div id="test" class="member_block"style="display:none;">'.$row['body'].'</div><br />
                        ';
               }
            }
        }
        public function infoLook($name){
            $sql = new SQL;
            //echo "<b>You may not edit project information for this project</b>";
                    $result = $sql->Query("SELECT * FROM `projects` WHERE `id` = %d", $name);
                    while($row = mysql_fetch_assoc($result)){
                             echo '
                                <div id="control">
                                    <b>Category</b><br />
                                    <select class="category"name="category">
                                        <option>'.$row['category'].'</option>
                                        <option>Just for Fun</option>
                                        <option>Art</option>
                                        <option>Technology</option>
                                        <option>Research</option>
                                        <option>Acting</option>
                                        <option>Games</option>
                                        <option>Art</option>
                                        <option>Fashion</option>
                                        <option>Culinary</option>
                                        <option>Music</option>
                                        <option>Medical</option>
                                        <option>Education</option>
                                    </select><br /><br />
                                    <b>Name:</b><div class="name">'.$row['name'].'</div><br />
                                    <b>Description:</b><div class="description">'.$row['description'].'</div><br />
                                    <hr />
                                    <span class="okay"></span>
                                </div>
                             ';
                    }
        }
        public function leaveProject($name){
            //Leave project
            echo '<br /><button onclick="leaveProject(\''.$name.'\', '.$_SESSION["ID"].')">Leave this project</button>';
        }
        public function viewRoles($name, $branch){
            //See project roles
            $sql = new SQL;
            $result = $sql->Query("SELECT * FROM `projects_invited` WHERE `id` = %d AND `accepted` = %s", $name, 'true');
            while($row = mysql_fetch_assoc($result)){
                $role = $row['role'];
                $privilege = $row['privilege'];
                $person = id2user($row['person'], 'id2user');
                $status = $row['status'];
                $result2 = $sql->Query("SELECT * FROM `projects_data` WHERE `to` = %d AND `branch` = %s AND `what` = %s AND `name` = %d", $row['person'], $branch, 'privilege', $name);
                while($row2 = mysql_fetch_assoc($result2)){
                    switch($row2['level']){
                        case 0:
                            $privilege = 'Creator';
                            break;
                        case 1:
                            $privilege = 'Manager';
                            break;
                        case 2:
                            $privilege = 'Supervisor';
                            break;
                        case 3:
                            $privilege = 'Member';
                            break;
                        default:
                            $privilege = 'Observer';
                   }
                    echo '
                        <br />
                        <div class="member_block">
                            <b><a onclick="getUser('.$row['person'].');">'.$person.'</a> : '.$privilege.' in branch '.$branch.'<br /><br />';
                            if($role != '')
                            echo 'Role: </b>'.$role.'<br /><br />';
                            else echo '</b>';
                            if($status != '')
                            echo '<b>Status:</b><br />';
                     echo '
                         '.$status.'
                         </div>
                        ';
            }
            }
        }
        public function viewDocuments($name, $branch){
            $sql = new SQL;
            if($branch == 'Master'){ 
                $result = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` = %s AND `suggest` = %d ORDER BY `date` DESC", $name, 'document', 0);
            }else{
                $result = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` = %s AND `branch` = %s AND `suggest` = %d ORDER BY `date` DESC", $name, 'document', $branch, 0);
            }
            if(mysql_num_rows($result) == 0){ 
                echo "No documents have been created in this branch yet.";
            }else{
                while($row = mysql_fetch_assoc($result)){
                    echo "
                        <div class=\"member_block\"style='margin-bottom:5px;'>
                            <a onclick='getOne(".$row['id'].");'>
                                By: ".id2user($row['by']).", ".$row['date']."<br />
                                <b>".$row['title']."</b><br />
                            </a>
                        </div>
                    ";
                }
            }
        }
    }
    class Member extends Observer{
        public function viewTasks($name, $branch){
            $sql = new SQL;
            if($branch == 'Master'){
                $result = $sql->Query("
                SELECT * FROM `projects_data`
                WHERE `name` = %d
                AND `what` = %s
                AND `suggest` = %d
                ORDER BY `date` DESC
                ", $name, 'task', 0);
            }else{
                $result = $sql->Query("
                SELECT * FROM `projects_data`
                WHERE `name` = %d
                AND `what` = %s
                AND `branch` = %s
                AND `suggest` = %d
                ORDER BY `date` DESC
                ", $name, 'task', $branch, 0);
            }
            if(mysql_num_rows($result) == 0){ 
                echo "No tasks have been created yet.";
            }else{
                while($row = mysql_fetch_assoc($result)){
                    tasks($row['level'], $row['id'], $row['title'], $row['date'], $row['txtto'], $row['body'], 0, $branch);
               }
            }
        }
        public function changeStatus($name){
            echo '
                <br />
                <br />
                <input type="text" class="statustxt" /><br /><br /><a id="btn" onclick="updateStatus(\''.$name.'\', '.$_SESSION['ID'].')">Update Status</a>
            ';
        }
        public function createDocument($name){
            echo '
                Create new document<br />
                <input type="text"class="doctitle" /><br />
                <textarea id="bigtxt"class="docbody"></textarea><br /><br />
                <a id="btn"onclick="docCreate(\''.$name.'\', 1);">Create</a>
            ';
        }
    }
    class Supervisor extends Member{
        public function viewTasks($name, $branch){
            $sql = new SQL;
            if($branch == 'Master'){
                $result = $sql->Query("
                SELECT * FROM `projects_data`
                WHERE `name` = %d
                AND `what` = %s
                 AND `suggest` = %d
                ORDER BY `date` DESC
                ", $name, 'task', 0);
            }else{
                $result = $sql->Query("
                SELECT * FROM `projects_data`
                WHERE `name` = %d
                AND `what` = %s
                AND `branch` = %s
                 AND `suggest` = %d
                ORDER BY `date` DESC
                ", $name, 'task', $branch, 0);
            }
            if(mysql_num_rows($result) == 0){ 
                echo "No tasks have been created yet.";
            }else{
                while($row = mysql_fetch_assoc($result)){
                    tasks($row['level'], $row['id'], $row['title'], $row['date'], $row['txtto'], $row['body'], 1, $branch);
               }
            }
        }
        public function createTask($name){
            echo 'Assign to: <select class="taskto">';
           select_users($name, 1);
            echo '</select>';
                echo '
                <br />
                <input class="taskname"type="text" placeholder="Task Name"/><br />
                <input class="taskdate"type="text" placeholder="Due Date"/><br />
                <textarea id="bigtxt"class="taskdesc"placeholder="Description"></textarea><br /><br />
                <a id="btn" onclick="createTask(\''.$name.'\', 1)">Create</a>
            ';
        }
        public function roleCMS($name){
            //Create/set roles
            echo "<h5>Change/create member roles</h5>";
            echo '<select class="whichMember">';
            select_users($name, 1);
            echo '</select>';
            echo '<br /><input type="text" class="setRoleTXT" /><br /><br /><a id="btn" onclick="setAnotherRole(\''.$name.'\');setRole();">Set Roles</a>';
        }
        public function documentCMS($name){
            echo '<br /><a id="btn" onclick="retrieve(\'docEditMode\');">Edit Mode</a><br /><br />';
        }
        public function editMode($name){
            echo '<div id="head"><h2>Boards</h2></div><br /><div id="content"><a id="btn"onclick="retrieve(\'boards\')">View Mode</a><hr />';
            $sql = new SQL;
            $result = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` = %s AND `suggest` = %d ORDER BY `date` DESC", $name, 'document', 0);
            if(mysql_num_rows($result) == 0) echo "No documents have been created in this branch yet.";
            else{
                while($row = mysql_fetch_assoc($result)){
                    $id = $row['id'];
                    echo "
                        <div class=\"member_block\"style='margin-bottom:5px;'>
                            By: ".id2user($row['by']).", ".$row['date']."<br />
                            <input type='text' value='".$row['title']."' style='width:100%;' class='doctitle".$id."'/><br />
                            <textarea id='bigtxt'style='width:100%;' class='docbody".$id."'>
                            ".$row['body']."
                            </textarea>
                            <br /><br />
                        <a id='btn' onclick='deleteuni(1, ".$id.", \"editmode\")'>Delete</a>&nbsp;<a id='btn' onclick='updateDoc(".$id.")'>Update</a>
                        </div>
                        <br /><br />
                    ";
                }
            }
            echo '</div>';
        }
    }
    class Manager extends Supervisor{
         public function milestoneForm($name, $branch){
             //create milestones
             echo '
             <br />
             <b>Create milestone:</b><br /><br />
             <div id="form">
                    <input type="text" placeholder="Title"name="title" id="title" /><br />
                    <textarea placeholder="Description"id="desc" cols="60" rows="10"></textarea><br />
                    Assign to:<br /><select name="user" id="user">';
                        select_users($name, 1);
                    echo '
                    </select><br />
                    Date:<br /><input type="date" name="date" id="date" /><br /><br />';
                    echo '
                    <a id="btn" onclick="milestoneSubmit();">Create</a><br />
                    </div></div>';
         }
         public function infoEdit($name){
            $sql = new SQL;
            $result = $sql->Query("SELECT * FROM `projects` WHERE `id` = %d", $name);
                    while($row = mysql_fetch_assoc($result)){
                             echo '
                                <div id="control">
                                    <b>Category</b><br />
                                    <select class="category"name="category">
                                       <option>'.$row['category'].'</option>
                                        <option>Just for Fun</option>
                                        <option>Art</option>
                                        <option>Technology</option>
                                        <option>Research</option>
                                        <option>Acting</option>
                                        <option>Games</option>
                                        <option>Art</option>
                                        <option>Fashion</option>
                                        <option>Culinary</option>
                                        <option>Music</option>
                                        <option>Medical</option>
                                        <option>Education</option>
                                    </select><br /><br />
                                    <b>Name:</b><br /><input type="text"class="name" value="'.$row['name'].'"/><br />
                                    <b>Description:</b><br /><textarea id="bigtxt"class="description"contenteditable="true">'.$row['description'].'</textarea><br />
                                    <br /><br />
                                    <a id="btn" onclick="changeInfo();">Change</a><br />
                                    <span class="okay"></span>
                                </div>
                             ';
                    }
        }
        public function branchCMS($name){
            echo '<br /><input type="text" class="branchName"/><br /><br /><a id="btn" onclick="createBranch();">Create new branch</a>';
        }
    }
    class Creator extends Manager{
        public function Suggest($name, $branch){
            /*
            *suggest:
            *0 - confirmed
            *1 - unconfirmed
            */
            $sql = new SQL;
            $result = $sql->Query("SELECT * FROM `projects_data` WHERE `suggest` = %d AND `name` = %d AND `branch` = %s ORDER BY `date` DESC", 1, $name, $branch);
            echo '
                <br />Suggestions for '.$branch.' branch:<br /><br />
            ';
            if(mysql_num_rows($result) == 0){
                echo 'No project suggestions for this branch yet.';
            }else{
                while($row = mysql_fetch_assoc($result)){
                    if($row['what'] == 'task'){
                        $text = ', Assigned to: '.id2user($row['txtto']);
                    }else{
                        $text = '';
                    }
                    echo '
                        <div id="member_block">
                            From : '.id2user($row['by']).': '.$row['what'].' '.$text.'<br />
                            Title: '.$row['title'].'<br />
                            Date: '.$row['date'].'<br />
                            Description:<br /> '.$row['body'].'
                        </div><br />
                        <a id="btn"onclick="confirm('.$row['id'].', '.$name.');">Confirm</a>&nbsp;<a id="btn"onclick="';
                        echo 'deleteuni(0, '.$row['id'].', "suggest");';
                        echo '
                        ">Deny</a>
                        <br /><br />
                    ';
                }
            }
        }
        public function deleteProject($name){
            echo '
                <div>
                    <br />
                    <a id="btn" onclick="
                        var check = confirm(\'Are you sure? this action can not be reversed. All project data will be lost.\');
                        if(check){
                            $.post(\'workspace_script.php\', {
                                name: \''.$name.'\',
                                signal: \'deleteProject\'
                            }, function(data){
                                window.location.reload(true);
                            });
                        }
                    ">Delete this project</a>
                </div>
            ';
        }
        public function deleteBranch($name){
            $row['id'] = '';
            echo '<br />
            <select class="branch_delete">';
                $sql = new SQL;
                $result = $sql->Query("SELECT * FROM `projects_data` WHERE `name` = %d AND `what` = %s", $name, 'branch');
                while($row = mysql_fetch_assoc($result)){
                    if($row['title'] != 'Master'){
                        echo '<option value="'.$row['title'].'">'.$row['title'].'</option>';
                    }
                }
            echo '
            </select>
            <br /><br /><a id="btn" onclick="deleteBranch();">Delete Branch</a>
            ';
        }
        public function creatorLeave($name){
            //Leave project
            echo '<br /><a onclick="$(this).next().slideToggle();"><b>Pass leadership</b></a>';
            echo '
            <div style="display:none;">
                Pass lead to:
                <select class="passleadselect">';
                select_users($name, 2);
            echo '     
                </select>
                <br /><br />
                <a id="btn" onclick="passLead();">Pass leadership</a>
            </div><br />';
        }
        public function removeMember($name){
            //Remove member
            echo '
                <h5>Remove Members</h5>
                <select class="deleteSelect">';
                select_users($name, 2);
            echo    
                '</select><br /><br />
                <a id="btn" onclick="removeMember(\''.$name.'\');">Remove</a>
            ';
        }
        public function privilegeCMS($name){
                $name = $_POST['name'];
                $sql = new SQL;
                $result = $sql->Query("SELECT * FROM projects_data WHERE name = %d AND what = %s ORDER BY id ASC", $name, 'branch');
                $result2 = $sql->Query("SELECT DISTINCT person FROM projects_invited WHERE id = %d ORDER BY id DESC", $name);
                echo '
                    <h5>Change Privileges</h5>
                    <select class="theBranchName">';
                        while($row = mysql_fetch_assoc($result)){
                            echo '<option>'.$row['title'].'</option>';
                        }
                echo '    
                    </select>
                    <select class="theBranchPerson">';
                        select_users($name, 2);
                echo '    
                    </select>
                    <select class="theBranchPrivilege">
                        <option value="4">Observer</option>
                        <option value="3">Member</option>
                        <option value="2">Supervisor</option>
                        <option value="1">Manager</option>
                    </select><br /><br />
                    <a id="btn"onclick="branchPrivilege('.$name.');">Change</a>
                ';
        }
    }
    //functions
    function check($data){
            if($data  == ''){
                return "Not available";
            }else{
                return $data;
            }
    }
    /*function id2projectname($id){
        //This only works one way, since project names arent unique
        //All WHERE's pointing to projectname will change to ID
        //All calls of projectname will switch to ID
        $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
        mysql_select_db(SQL_DB) or die(mysql_error());
        /*$sql = new SQL;
        $result = $sql->Query("SELECT `projectname` FROM `projects_invited` WHERE `id` = %d", $id);
        $result = mysql_query("SELECT projectname FROM projects_invited WHERE id = '$id'")or die(mysql_error());
        $row = mysql_fetch_array($result);
        return $row['projectname'];
    }*/
    //select box of members
    function select_users($projectID, $type = 1){
        $sql = new SQL;
        if($type == 1){
            //Show all members
            $guard = 0;
        }else{
            //Don't show session ID
            $guard = $_SESSION['ID'];
        }
        $result = $sql->Query("SELECT DISTINCT `person` FROM `projects_invited` WHERE `id` = %d AND `person` != %d AND `accepted` = %s ORDER BY `id` DESC", $projectID, $guard, 'true');
        while($row = mysql_fetch_assoc($result)){
            echo '<option value="'.$row['person'].'">'.id2user($row['person']).'</option>';
        }
    }
    function tasks($level, $id, $title, $date, $to, $description, $cms = 1, $branch){
        //if you only want the assigned person to be able to complete tasks, put the select box in an if($to != $_SESSION['ID'])
        switch($level){
                            case 2:
                                echo '
                                    <br />
                                    <select class="taskStatus'.$id.'"onchange="taskStatus('.$id.');" >
                                        <option value="2">Almost</option>
                                        <option value="1">Incomplete</option>
                                        <option value="3">Complete</option>
                                    </select>
                                    <span class="whendone'.$id.'"></span>
                                ';
                                break;
                            case 3:
                                echo '
                                    <br />
                                    <select class="taskStatus'.$id.'"onchange="taskStatus('.$id.');">
                                        <option value="3">Complete</option>
                                        <option value="2">Almost</option>
                                        <option value="1">Incomplete</option>
                                    </select>
                                    <span class="whendone'.$id.'"></span>
                                ';
                                break;
                            default:
                                echo '
                                    <br />
                                    <select class="taskStatus'.$id.'"onchange="taskStatus('.$id.');">
                                        <option value="1">Incomplete</option>
                                        <option value="2">Almost</option>
                                        <option value="3">Complete</option>
                                    </select>
                                    <span class="whendone'.$id.'"></span>
                                ';
                        }
                        $to = ($to > 0) ? id2user($to) : 'Anyone';
                        echo '
                            <b class="first"style="cursor:pointer;"onclick="$(this).next().next().slideToggle();"><a>'.$title.': '.$date.' ('.$to.') Branch: '.$branch.'</a></b><br />
                            <div id="test" class="member_block"style="display:none;">'.$description.'</div>
                            <br />';
                        if($cms == 1){
                            echo '
                                <a id="btn" onclick="getOne('.$id.');">Options</a>
                                <br /><br />
                            ';
                        }
    }
    function insert($usr, $date, $desc, $title, $project){
            $sql = new SQL;
            $result = $sql->Query("INSERT INTO `milestones` (`title`, `description`, `user`, `date`, `creator`, `project`) VALUES (%s, %s, %d, %s, %d, %d)", $title, $desc, $usr, $date, $_SESSION['ID'], $project);
            if($result){
                return "sucess";
            }else{
                return "error";
            }
        }
    function calendar($date, $year){
            $num = cal_days_in_month(CAL_GREGORIAN, $date, $year);
            $months = array("", "January", "Febraury", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $years = array($year - 3, $year - 2, $year - 1, $year, $year + 1, $year + 2, $year + 3);
            $newdate = DateTime::createFromFormat("n", $date);
            $strdate = $newdate->format('F');
            $calendar = "";
            $calendar .= "<table align='center'><caption>".$strdate. " " . $year . "<br />";
            for($i = 0; $i <= count($years); $i++){
                if($i < 7){
                    $calendar .= "<a class='years' id='$date' name='$years[$i]'>$years[$i]</a> ";
                }
            }
            $calendar .= "<br />";
            for($i = 1; $i <= count($months); $i++){
                if($i < 13){
                    $calendar .= "<a class='months' id='$year' name='$i'>$months[$i]</a> ";
                }
            }
            $calendar .= "<script>
                $('document').ready(function (){
                    $('.months').click(function (){
                        var month = this.name;
                        var year = this.id;
                        change(month, year);
                    });
                    $('.years').click( function (){
                        var month = this.id;
                        var year = this.name;
                        change(month, year);
                    });
                });
            </script>";
            $calendar .= "</caption><tr class='headers'><th id='sun'>Sun</th><th id='mon'>Mon</th><th id='tue'>Tue</th><th id='wed'>Wed</th><th id='thu'>Thu</th><th id='fri'>Fri</th><th id='sat'>Sat</th></tr><tr>";
            for($i = 1; $i <= $num; $i++){
                 $calendar .=  "<td class='day'><div class='day'><div class='day-num'>$i</div>";
                 if($i/7 == intval($i/7)) $calendar .= "</td></tr><tr>";
            }
            $calendar .= "<script>
                $('document').ready(function (){
                    $('.day').click(function (){
                        var day = $(this).children().text();
                        var month = $date;
                        var year = $year;
                        var date = year + '-' + month + '-' + day;
                        popup(date);
                    });
                });    
            </script>";
            $calendar .= "</div></tr></table><div id='toPopup'><div class='close'><a>Close</a></div><div id='popup_content'></div></div><div id='backgroundPopup'></div>";
            return $calendar;
        }
     function getData($date, $project){
            $sql = new SQL;
            $result = $sql->Query("SELECT * FROM `milestones` WHERE `date` = %s AND `project` = %d", $date, $project);
            while($row = mysql_fetch_array($result)){
                $title = $row['title'];
                $user = $row['user'];
                $task = $row['description'];
            }
            if(isset($user) && isset($task) && !empty($user) && !empty($task) && isset($title) && !empty($title)){
                return $title . " " . id2user($user) . " " . $task;
            }else{
                return "There are no milestones for this date.";
            }
            echo 'test';
        }
        function showComments($id){
            $sql = new SQL;
            $result = $sql->Query("SELECT * FROM `projects_comments` WHERE `id2` = %d", $id);
            while($row = mysql_fetch_assoc($result)){
                echo '
                    <div id="member_block">
                        By: '.id2user($row['by']).', '.$row['date'].'<br />
                        '.$row['comment'].'
                    </div>
                    <br /><br />
                ';
            }
        }
        //function to add to notifications
        function notify($what, $info){
            //$info is the details of what they did
            //$what is either a update, message, or request
            //for messages/requests, you can set $info to 0, if you want
            $sql = new SQL;
            //$projectID = 0 if not from workspace/projects page
            $result = $sql->Query("SELECT `person` FROM `projects_invited` WHERE `id` = %d", $projectID);
            $date = date("Y:m:d H-i-s");
            while($row = mysql_fetch_assoc($result)){
                $sql->Query("INSERT INTO `notifications` (`user`, `did`, `what`, `date`) VALUES (%d, %d, %d, %s, %s, %s)", $row['person'], $info, $what, $date);
            }
        }