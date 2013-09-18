<?php
    /*INCLUDES*/
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    include_once('test_framework.php');
    /*END*/

    if(isset($_POST['token']) && $_POST['token'] != $_SESSION['token']){
        //CSRF defense; end immediately and log
        die(Person::log_suspicious(Person::$pages[1], 6, 'Potential CSRF; token != sessionToken;'));
    }
    if(isset($_POST['signal'])){
        /*SECURITY*/
        $branch = (isset($_POST['branch'])) ? $_POST['branch'] : 'Master';
        if(isset($_POST['projectID'])){
            $projectID = $_POST['projectID'];
            $user = new Person($projectID);
        }
        if(isset($branch) && isset($projectID) && $projectID != 0){
            $priv = $user->get_privs_by_branch($branch, $projectID);
            $user = new $priv(0);
            $_SESSION['PRIV'] = $user->privilege2num($priv);
        }else if($projectID != 0){
            die(Person::log_suspicious(Person::$pages[1], 19, 'Branch and projectID not set.'));
        }
        if(isset($_SESSION['PRIV'])) $privilege = $_SESSION['PRIV'];
        /*END*/

        /*Primary signals*/
        switch($_POST['signal']){
            //first do the cases for retrieving categories
            case 'init':
                $data = array();
                $data['clear'] = Person::workspace_clear();
                if($data['clear'] == TRUE){
                    //echo branches for the selected workspace
                    $data['branch'] = $user->get_branches($projectID); //framework pg.38
                    //get workspace logo
                    $data['logo'] = $user->get_workspace_logo($projectID);
                    //get workspace statistics
                    $data['stats'] = $user->get_workspace_stats($projectID);
                }else{
                    $data['branch'] = NULL;
                    $data['logo'] = NULL;
                    $data['stats'] = NULL;
                }
                die(json_encode($data)); //the entire file is only a switch now, so just die()
            case 'Start':
                //will return cms options and main content
                $data = array();
                 //framework pg.13
                $data['cms'] = '<span class="cms_opt_create"><img src="/images/cog3.png"><br />Create</span>&nbsp;';
                //creator
                if($privilege == 0) $data['cms'] .= '<span class="cms_opt_launch"><img src="/images/laptop.png"><br />Launch</span>&nbsp;';
                $data['cms'] .= '<span class="cms_opt_messages"><b>0</b><br />Messages</span>&nbsp;';
                //manager +
                if($privilege <= 1) $data['cms'] .= '<span class="cms_opt_requests"><b>0</b><br />Requests</span>&nbsp;<span class="cms_opt_add"><b>+</b><br />Add</span>&nbsp;';
                $data['main'] = '
                    <div class="widget"style="margin-bottom:10px;">
                    <div class="head1">Activity graph for branch <b>'.$branch.'</b>:<img style="float:right;margin-right:10px;"src="/images/arrowo.png" id="arrownews1" border="0"></div>
                    <div class="body1">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <th>Content:</th> <th>Number of posts each day:</th>
                            </tr>
                            <tr>
                                <td><canvas id="pie" width="400" height="300">Your browser does not support this graph. Try chrome instead.</canvas></td> <td><canvas id="linear" width="400" height="300">Your browser does not support this graph. Try chrome instead.</canvas></td>
                            </tr>
                        </table>
                    </div>
                </div>
                ';
                die(json_encode($data));
            case 'Stream':
                $data = array();
                //stream cms is universal
                $data['cms'] = '
                    <span class="cms_opt_everything"><b>*</b><br />Everything</span>
                    <span class="cms_opt_document"><img src="/images/list.png"><br />Documents</span>
                    <span class="cms_opt_task"><img src="/images/cog3.png"><br />Tasks</span>
                    <span class="cms_opt_table"><img src="/images/list.png"><br />Tables</span>
                    <span class="cms_opt_event"><img src="/images/cog3.png"><br />events</span>
                    <span class="cms_opt_update"><b>!</b><br />Updates</span>
                ';
                $data['main'] = $user->stream($branch, $projectID); //framework pg.100
                die(json_encode($data));
            case 'Control':
                $data = array();
                //Master branch because the control panel uses global privileges (its the only one)
                //just ordering it logically
                $data['cms'] = NULL;
                //manager +
                if($privilege <= 1) $data['cms'] .= '<span class="cms_opt_branch"><img src="/images/cog3.png"><br />Branch</span>&nbsp;';
                //Creator
                if($privilege == 0) $data['cms'] .= '<span class="cms_opt_delete"><b>x</b><br />Delete</span>&nbsp;';
                $data['cms'] .= '<span class="cms_opt_leave"><img src="/images/list.png"><br />'.($privilege == 0 ? 'Pass Lead' : 'Leave').'</span>&nbsp;';
                $data['main'] = $user->control_panel($projectID); //framework pg.252
                die(json_encode($data));
            case 'Groups':
                $data = array();
                $data['cms'] = NULL;
                $data['cms'] .= '
                    <span class="cms_opt_creator"><img src="/images/cog3.png"><br />Creator</span>
                    <span class="cms_opt_manager"><img src="/images/list.png"><br />Manager</span>
                    <span class="cms_opt_supervisor"><img src="/images/cog3.png"><br />Supervisor</span>
                    <span class="cms_opt_member"><img src="/images/cog3.png"><br />Member</span>
                    <span class="cms_opt_observer"><img src="/images/cog3.png"><br />Observer</span>
                ';
                $data['main'] = $user->workspace_groups($branch, $projectID);
                die(json_encode($data));
            case 'Tasks':
                $data = array();
                $data['cms'] = NULL;
                //supervisor+
                if($privilege <= 2) $data['cms'] .= '<span class="cms_opt_assign-task"><b>+</b><br />Assign</span>&nbsp;';
                //member
                if($privilege <= 3) $data['cms'] .= '<span class="cms_opt_add"><b>*</b><br />All Tasks</span>&nbsp;<span class="cms_opt_add"><b>+</b><br />My Tasks</span>&nbsp;';
                $data['main'] = $user->workspace_tasks($branch, $projectID);
                die(json_encode($data));
            case 'Boards':
                $data = array();
                $data['cms'] = NULL;
                //member
                if($privilege <= 3) $data['cms'] .= '<span class="cms_opt_create-document"><img src="/images/cog3.png"><br />Create</span>&nbsp;';
                if($privilege <= 3) $data['cms'] .= '<span class="cms_opt_add"><b>*</b><br />All Docs</span>&nbsp;<span class="cms_opt_'.$_SESSION['ID'].'"><img src="/images/cog3.png"><br />My Docs</span>&nbsp;';
                $data['main'] = $user->workspace_boards($branch, $projectID);
                die(json_encode($data));
            case 'Notes':
                $data = array();
                $data['cms'] = '
                    <span class="cms_opt_create-note"><img src="/images/cog3.png"><br />Create</span>
                ';
                $data['main'] = $user->workspace_notes($projectID, $branch);
                die(json_encode($data));
            case 'Tables':
                $data = array();
                $data['cms'] = NULL;
                //member
                if($privilege <= 3) $data['cms'] .= '<span class="cms_opt_create-table"><img src="/images/cog3.png"><br />Create</span>&nbsp;';
                if($privilege <= 3) $data['cms'] .= '<span class="cms_opt_add"><b>*</b><br />All Tables</span>&nbsp;<span class="cms_opt_add"><img src="/images/cog3.png"><br />My Tables</span>&nbsp;';
                $data['main'] = $user->workspace_tables($branch, $projectID);
                die(json_encode($data));
            case 'Updates':
                $data = array();
                $data['cms'] = NULL;
                //creator
                if($privilege <= 1) $data['cms'] .= '<span class="cms_opt_new-update"><b>+</b><br />New</span>&nbsp;';
                $data['cms'] .= '<span class="cms_opt_all-updates"><b>*</b><br />All</span>&nbsp;<span class="cms_opt_Public"><img src="/images/list.png"><br />Public</span>&nbsp;<span class="cms_opt_Member">*<br />Member</span>&nbsp;';
                $data['main'] = $user->updates($projectID, $branch);
                die(json_encode($data));
            case 'Wall':
                $data = array();
                $data['cms'] = NULL;
                $data['main'] = NULL;
                die(json_encode($data));
            case 'Events':
                $data = array();
                $data['cms'] = NULL;
                if($privilege <= 2)  $data['cms'] .= '<span class="cms_opt_assign-event"><b>+</b><br />New</span>&nbsp;';
                $data['cms'] .= '<span class="cms_opt_ms-thumbnails"><b>-</b><br />Thumbnails</span> <span class="cms_opt_ms-calendar"><b>-</b><br />Calendar</span>';
                $data['main'] = $user->workspace_events($branch, $projectID);
                die(json_encode($data));
            case 'Suggest':
                $data = array();
                $data['cms'] = '<span class="cms_opt_suggest"><b>+</b><br />New</span>&nbsp;<span class="cms_opt_everything"><b>-</b><br />Everything</span>&nbsp;<span class="cms_opt_document"><b>-</b><br />Documents</span>&nbsp;<span class="cms_opt_table"><b>-</b><br />Tables</span>&nbsp;';
                if($privilege == 0) $data['cms'] .= '<span class="cms_opt_clear-suggestions"><b>x</b><br />Clear</span>';
                $data['main'] = $user->workspace_suggestions($branch, $projectID);
                die(json_encode($data));
            case 'Files':
                $data = array();
                $data['cms'] = NULL;
                if($privilege <= 3) $data['cms'] .= '<span class="cms_opt_new"><b>+</b><br />Upload</span>&nbsp;';
                if($privilege <= 3) $data['cms'] .= '<span class="cms_opt_new"><b>*</b><br />My Files</span>&nbsp;';
                $data['main'] = NULL;
                $data['main'] = '
                    <div class="widget">
                        <div class="head"><b>Files</b> Last added: <b>9/5/13</b></div>
                        <div class="body">
                            <div class="row" style="text-align: center;">
                                <img src="/images/list.png"> <b>Writing.txt</b><br /><br />
                                By: <a>uriahsanders</a> 9/16/12 - 9 kb
                                <br /><br />
                                <a><u>Download</u></a> &nbsp; <a><u>Replace</u></a> &nbsp; <a><u>Delete</u></a>
                            </div>
                            <div class="row" style="text-align: center;">
                                <img src="/images/list.png"> <b>Writing.txt</b><br /><br />
                                By: <a>uriahsanders</a> 9/16/12 - 9 kb
                                <br /><br />
                                <a><u>Download</u></a> &nbsp; <a><u>Replace</u></a> &nbsp; <a><u>Delete</u></a>
                            </div>
                            <div class="row" style="text-align: center;">
                                <img src="/images/list.png"> <b>Writing.txt</b><br /><br />
                                By: <a>uriahsanders</a> 9/16/12 - 9 kb
                                <br /><br />
                                <a><u>Download</u></a> &nbsp; <a><u>Replace</u></a> &nbsp; <a><u>Delete</u></a>
                            </div>
                            <div class="row" style="text-align: center;">
                                <img src="/images/list.png"> <b>Writing.txt</b><br /><br />
                                By: <a>uriahsanders</a> 9/16/12 - 9 kb
                                <br /><br />
                                <a><u>Download</u></a> &nbsp; <a><u>Replace</u></a> &nbsp; <a><u>Delete</u></a>
                            </div>
                            <div class="row" style="text-align: center;">
                                
                            </div>
                        </div>
                    </div>
                ';
                die(json_encode($data));
            /*END*/

            /*Secondary signals*/
            case 'infiniteScroll':
                die($user->add_row_on_scroll($projectID, $branch, $_POST['page'], $_POST['limiter'], $_POST['query']));
            case 'refreshSelect':
                die($user->project_select());
            case 'create':
                die($user->create_new_workspace($_POST['title'], $_POST['category'], $_POST['description']));
            case 'getPlace':
                $data = array();
                $data['my_place'] = $user->get_place($branch, $projectID);
                $data['quick_add'] = $user->quick_add($branch, $projectID);
                $data['action_select'] = $user->action_select($branch, $projectID);
                die(json_encode($data));
            case 'cms':
                $what = $_POST['what'];
                if($what == 'launch' || $what == 'merge' || $what == 'delete'){
                    $scan = 0; //creator
                }else if($what == 'requests' || $what == 'branch' || $what == 'new-update' || $what == 'add'){
                    $scan = 1; //manager
                }else if($what == 'assign-task'){
                    $scan = 2; //supervisor
                }else if($what == 'create-table' || $what == 'new-doc-version' || $what == 'create-document'){
                    $scan = 3; //member
                }else{
                    $scan = 4; //observer
                }
                $user->verify_privilege_access($projectID, 'Master', $scan);
                die($user->cms_popup($what, $projectID, $branch, $_POST['id']));
            case 'launch':
                $user->verify_privilege_access($projectID, 'Master', 0);
                die($user->launch_workspace($_POST['as'], $projectID));
            case 'updateStatus':
                die($user->update_status($_POST['status'], $projectID));
            case 'change':
                $user->verify_privilege_access($projectID, 'Master', 1); 
                die($user->change_workspace_info($projectID, $_POST['title'], $_POST['description'], $_POST['category']));
            case 'createDoc':
                $user->verify_privilege_access($projectID, 'Master', 3);
                die($user->create_new_document($projectID, $branch, $_POST['title'], $_POST['body']));
            case 'manageBranch':
                $factor = $_POST['factor'];
                if($factor == 'create-branch' || $factor == 'rename-branch'){
                    $scan = 1; //manager
                }else{
                    $scan = 0; //creator
                }
                $user->verify_privilege_access($projectID, 'Master', $scan);
                die($user->manage_branch_action($projectID, $factor, $_POST['data'], $_POST['dataSecond']));
            case 'deleteWorkspace':
                $user->verify_privilege_access($projectID, 'Master', 0);
                if(isset($_POST['input']) && $_POST['input'] == 'DELETE'){
                    die($user->delete_workspace($projectID));
                }else{
                    die();
                }
            case 'new-update':
                $user->verify_privilege_access($projectID, 'Master', 1);
                $user->post_new_update($_POST['title'], $_POST['desc'], $_POST['select'], $branch, $projectID);
                die();
            case 'assign-task':
                $user->verify_privilege_access($projectID, 'Master', 2);
                die($user->assign_task($_POST['title'], $_POST['desc'], $_POST['to'], $_POST['date'], $projectID, $branch));
            case 'create-table':
                $user->verify_privilege_access($projectID, 'Master', 3);
                die($user->create_table($projectID, $branch, $_POST['table'], $_POST['title']));
            case 'create-note':
                die($user->create_note($projectID, $branch, $_POST['title'], $_POST['body']));
            case 'getUser':
                $data = array();
                $data['main'] = $user->workspace_groups($branch, $projectID, TRUE, $_POST['userID']);
                $data['head'] = id2user($_POST['userID']);
                die(json_encode($data));
            case 'pie':
                $data = array();
                $categories = array('event', 'task', 'document', 'table', 'file');
                for($i = 0; $i < count($categories); $i++){
                    if($branch == 'Master')
                        $data[$categories[$i]] = mysql_num_rows($user->Query("SELECT `id` FROM `projects_data` WHERE `what` = %s AND `projectID` = %d", $categories[$i], $projectID));
                    else
                        $data[$categories[$i]] = mysql_num_rows($user->Query("SELECT `id` FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `branch` = %s", $categories[$i], $projectID, $branch));
                }
                die(json_encode($data));
            case 'linear':
                $data = array();
                
                die(json_encode($data));
            case 'mark-task':
                die($user->mark_task($_POST['taskID'], $_POST['status']));
            case 'mark-event':
                //same main functionality as above
                die($user->mark_task($_POST['eventID'], $_POST['status']));
            case 'updateElement':
                $page = $_POST['page'];
                $level = ($page == 'Boards') ? $_POST['level'] : NULL;
                if($page == 'Updates' || $page == 'Tasks'){
                    $scan = 2;
                }else if($page == 'Boards' || $page == 'Tables'){
                    $scan = 3;
                }else{
                    $scan = 4;
                }
                $user->verify_privilege_access($projectID, 'Master', $scan);
                die($user->update_update($_POST['elementID'], $_POST['title'], $_POST['body'], $_POST['page'], $level));
            case 'deleteElement':
                $page = $_POST['page'];
                if($page == 'Notes'){
                    $scan = 4;
                }else if($page == 'Boards' || $page == 'Tables'){
                    $scan = 3;
                }else{
                    $scan = 2;
                }
                $user->verify_privilege_access($projectID, 'Master', $scan);
                die($user->delete_element($_POST['elementID'], $_POST['page'], $_POST['level']));
            case 'newDocVersion':
                $user->verify_privilege_access($projectID, 'Master', 3);
                die($user->new_document_version($projectID, $branch, $_POST['mark'], $_POST['level'], $_POST['title'], $_POST['body']));
            case 'search':
                die($user->search($projectID, $branch, $_POST['query']));
            case 'sendMessage':
                die($user->send_message($projectID, $_POST['title'], $_POST['body'], $_POST['to']));
            case 'getVersion':
                die($user->get_version($_POST['mark'], $_POST['version']));
            case 'leave':
                die($user->leave_workspace($projectID));
            case 'passLead':
                $user->verify_privilege_access($projectID, 'Master', 0);
                die($user->pass_lead($_POST['who'], $projectID));
            case 'removeMember':
                $user->verify_privilege_access($projectID, 'Master', 0);
                die($user->remove_member($projectID, $_POST['person']));
            case 'canJoin':
                $user->verify_privilege_access($projectID, 'Master', 0);
                die($user->can_join($projectID, $_POST['person'], $_POST['do']));
            case 'changePrivilege':
                $user->verify_privilege_access($projectID, 'Master', 0);
                die($user->change_privilege($projectID, $branch, $_POST['user'], $_POST['privilege']));
            case 'suggest':
                die($user->suggest($projectID, $branch, $_POST['what'], $_POST['title'], $_POST['main']));
            case 'confirmSuggest':
                $user->verify_privilege_access($projectID, 'Master', 1); //manager or creator
                die($user->confirm_suggest($_POST['elementID']));
            case 'denySuggest':
                $user->verify_privilege_access($projectID, 'Master', 1); 
                die($user->deny_suggest($_POST['elementID']));
            case 'clearSuggestions':
                die($user->clear_suggestions($projectID, $branch));
            case 'assign-event':
                $user->verify_privilege_access($projectID, 'Master', 2);
                die($user->assign_event($_POST['title'], $_POST['from'], $_POST['to'], $branch, $projectID));
            case 'events-calendar-init-day':
                die($user->events_calendar_init_day($branch, $projectID));
            case 'getOne':
                switch($_POST['type']){
                    case 'document':
                        die($user->workspace_boards($branch, $projectID, TRUE, $_POST['id']));
                    case 'update':
                        die($user->updates($projectID, $branch, TRUE, $_POST['id']));
                    case 'task':
                        die($user->workspace_tasks($branch, $projectID, TRUE, $_POST['id']));
                    case 'table':
                        die($user->workspace_tables($branch, $projectID, TRUE, $_POST['id']));
                    case 'event':
                        die($user->workspace_events($branch, $projectID, TRUE, $_POST['id']));
                }
                die();
            /*END*/
            
            default:
                die(Person::log_suspicious(Person::$pages[1], 417, "potential JS tamperer; attempted a non-existant function."));
        }
    }