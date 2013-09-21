<?php
    //classes for privileges
    interface Security{
        //that essential stuff
        public function get_privilege($branch, $projectID);
        public function verify_project_access($projectID);
        public function verify_privilege_access($projectID, $branch, $privilege);
    }
    class Person extends SQL implements Security{
        public function __construct($projectID){
            if($projectID != 0) $this->verify_project_access($projectID);
        }
        const LIMIT = 20; //how many results to filter out
        const APPEND = 1; //how many results to append on scroll
        const ORDER = 'ORDER BY `date` DESC';
        protected static $DATA = array(
            'pages' => array(
                'workspace.php', 
                'workspace_script.php', 
                'workspace_framework.php'
            ),
            'section_elements' => array(
                "Stream" => 'element',
                "Updates" => 'update',
                "Tasks" => 'task',
                "Boards" => 'document',
                "Tables" => 'table',
                "Notes" => 'note',
                "Suggest" => 'element'
            ),
            //keys are constants
            'privileges' => array(
                0 => 'Creator', 
                1 => 'Manager', 
                2 => 'Supervisor', 
                3 => 'Member', 
                4 => 'Observer'
            ),
            'categories' => array(
                'Just for Fun',
                'Art',
                'Technology',
                'Research',
                'Acting',
                'Games',
                'Art',
                'Fashion',
                'Culinary',
                'Music',
                'Medical',
                'Education'
            ),
            'columns' => array(
                'id',
                'projectID', 
                'what', 
                'by', 
                'date', 
                'title', 
                'body', 
                'to', 
                'level', 
                'branch', 
                'privilege', 
                'mark', 
                'suggest', 
                'big_array'
            )
        );
        public static function project_select(){
            $sql = new SQL;
            //Get unique returns from database, oldest -> newest
            $result = $sql->Query("SELECT DISTINCT `projectID` FROM `projects_invited` WHERE `person` = %d AND `accepted` = %d GROUP BY `projectID` ASC", $_SESSION['ID'], 1);
            $return = NULL;
            if(mysql_num_rows($result) == 0){
                return "<option value='0'>0</option>";
            }else{
                while($row = mysql_fetch_assoc($result)){
                    //actual .val() is $id
                    $return .=  "<option value='".$row['projectID']."'>".self::id2projectname($row['projectID'])."</option>";
                }
            }
            return $return;
        }
        protected function alter_this($what, $to, $input){
            return preg_replace('/'.$what.'=\"(.+)?\"/', $what."=\"".$to."\"", $input);
        }
        public static function verify_input($type = 'default'){
            $args = func_get_args();
            array_shift($args);
            if($type == 'default'){
                for($i = 0; $i <= count($args); $i++){
                    if(strlen((string) $args[$i]) > 0){
                        return TRUE;
                    }else{
                        return FALSE;
                        die(self::log_suspicious($pages[2], 81, "Potential JS tamperer, element length bypassed."));
                    }
                }
            }
        }
        public static function column_length($column){
            $sql = new SQL;
            $result = $sql->Query("SELECT `".$column."` FROM `projects_data` LIMIT 1");
            $property = mysql_fetch_field($result);
            return $property->max_length();
        }
        protected function verify_column_lengths($values, $columns){
            if(count($values) == count($columns)){
                for($i = 0; $i <= count($values); $i++){
                    if(in_array($columns[$i], self::$DATA['columns'])){
                        if($values[$i] > self::column_length($columns[$i])){
                            return FALSE;
                        }return TRUE;
                    }
                }
            }
        }
        public static function verify_issets($array, $type = "get"){ 
            foreach($array as $value){
                if (((strtolower($type) == "get")? !isset($_GET[$value]) : !isset($_POST[$value]))){
                    return false; 
                    die(self::log_suspicious(self::$pages[2], 122, 'Issets not set.'));
                }
            }return TRUE;
        }
        protected function privilege_select($choice, $exclude = TRUE){
            $return = NULL;
            foreach(self::$DATA['privileges'] as $key => $value){
                $std = '<option value="'.$key.'">'.$value.'</option>';
                if($exclude == TRUE){
                    if($key != $choice) $return .= $std;
                }else{
                    $return .= ($key == $choice) ? '<option value="'.$key.'" selected>'.$value.'</option>' : $std;
                }
            }
            return '<select class="privilege_select">'.$return.'</select>';
        }
        public static function workspace_clear(){
           $sql = new SQL;
           $result = $sql->Query("SELECT DISTINCT `projectID` FROM `projects_invited` WHERE `person` = %d AND `accepted` = %d GROUP BY `projectID` ASC", $_SESSION['ID'], 1);
           if(mysql_num_rows($result) == 0){
               return FALSE;
           }return TRUE;
        }
        public static $pages = array('workspace.php', 'workspace_script.php', 'workspace_framework.php');
        public static function log_suspicious($page, $line, $info, $do = 'redirect'){
            $sql = new SQL;
            $sql->Query("INSERT INTO `suspicious_activity` (`page`, `line`, `info`, `date`, `user`, `ip`) VALUES %s, %d, %s, %s, %s, %s", $page, $line, $info, date("Y:m:d h-i-s"), id2user($_SESSION['ID']), getRealIp());
            if($do == 'redirect'){
                header('Location: /');
                exit();
            }else{
                die($do);
            }
        }
        public static function num_projects($id){
            $sql = new SQL;
            return mysql_num_rows($sql->Query("SELECT `id` FROM `projects_invited` WHERE `projectID` = %d AND `person` = %d", $id, $_SESSION['ID']));
        }
        public static function id2projectname($id){
            $sql = new SQL;
            $result = $sql->Query("SELECT `name` FROM `projects` WHERE `id` = %d", $id);
            $row = mysql_fetch_assoc($result);
            return $row['name'];
        }
        public function get_privilege($branch = 'Master', $projectID){
            $result = $this->Query("SELECT `privilege` FROM `projects_data` WHERE `what` = %s AND `branch` = %s AND `projectID` = %d AND `to` = %d", 'branch', $branch, $projectID, $_SESSION['ID']);
            $row = mysql_fetch_assoc($result);
            return $row['privilege'];
        }
        private function verify_end($result, $info, $privilege = NULL, $projectID = NULL){ //not zero for newcomers
            if((mysql_num_rows($result) == 0 || $privilege < 0 || $privilege > 4) && ($projectID > 0 || $projectID < 0)){
                //they shouldnt have access
                return FALSE;
                die(self::log_suspicious($pages[2], 42, "Potential JS tamperer: ".$info));
            }else return TRUE; //their clear
        }
        //make sure the input matches the dictated JS requirements
        protected function verify_length($title, $body){
            if(strlen($title) > 2 && strlen($body) > 5){
                return TRUE;
            }else{
                return FALSE;
                die(self::log_suspicious($pages[2], 54, "potential JS tamperer, element length bypassed."));
            }
        }
        public function verify_project_access($projectID){
            $info = 'does not have access to this project: '.self::id2projectname($projectID);
            $result = $this->Query("SELECT `id` FROM `projects_invited` WHERE `person` = %d AND `accepted` = %d AND `projectID` = %d", $_SESSION['ID'], 1, $projectID);
            $this->verify_end($result, $info, NULL, $projectID);
        }
        public function verify_privilege_access($projectID, $branch = 'Master', $privilege){
            $info = 'does not have the correct privilege ('.$privilege.') in branch ('.$branch.'), project: '.self::id2projectname($projectID);
            $result = $this->Query("SELECT `id` FROM `projects_data` WHERE `what` = %s AND `privilege` <= %d AND `projectID` = %d AND `to` = %d AND `title` = %s", 'branch', $privilege, $projectID, $_SESSION['ID'], $branch);
            $this->verify_end($result, $info, $privilege);
        }
        public static function add_popularity($projectID, $action = 'view'){
            $amount = ($action == 'view') ? 1 : ($action == 'request' ? 2 : 1);
            $sql = new SQL;
            $this->Query("UPDATE `projects` SET `popularity` += %d WHERE `projectID` = %d", $amount, $projectID);
        }
        public function get_privs_by_branch($branch, $projectID){
            return $this->num2privilege($this->get_privilege($branch, $projectID));
        }
        public function get_branches($projectID, $full = FALSE, $master = TRUE){
            $branches_q = $this->Query("SELECT `title` FROM `projects_data` WHERE `what` = %s AND `projectID` = %d ".self::ORDER."", 'branch', $projectID);
            $return = NULL;
            if($full == FALSE) $return = '<select id="branch_select" class="fly1">';
            while($branch = mysql_fetch_assoc($branches_q)){
                $title = $branch['title'];
                if($master == TRUE){
                    $extra = ($title == 'Master') ? 'selected' : NULL;
                    $return .= '<option '.$extra.'>'.$title.'</option>';
                }else{
                    if($title != 'Master'){
                        $return .= '<option>'.$title.'</option>';
                    }
                }
            }
            if($full == FALSE){
                $return .= '</select>';
            }else{
                if($return == NULL){
                    $return .= '<option>-</option>';
                }
            } 
            return $return;
        }
        public function privilege2num($privilege){
            foreach(self::$DATA['privileges'] as $key => $value){
                if($value == $privilege){
                    return $key;
                }
            }
        }
        protected function num2privilege($num){
            return self::$DATA['privileges'][$num];
        }
        public function get_workspace_logo($projectID){
            //in the future actually get user logo :P
            return "url('/images/logo99.png') no-repeat"; //temp
        }
        protected function date_difference($start_date, $end_date){
            $date1 = new DateTime($start_date);
            $date2 = new DateTime(date($end_date));
            $date = $date1->diff($date2);
            return ($date->days < 31) ? array($date->days, 'Days') : ($date->days >= 31 ? array($date->months, 'Months') : 0);
        }
        public function get_workspace_stats($projectID){
            $result = $this->Query("SELECT `person`, `privilege`, `date` FROM `projects_invited` WHERE `accepted` = %d AND `projectID` = %d", 1, $projectID);
            $members = mysql_num_rows($result);
            $member_string = ($members == 1) ? 'Member' : 'Members';
            while($row = mysql_fetch_assoc($result)){
                if($row['privilege'] == 0){
                    $start_date = $row['date'];
                    break;
                }
            }
            $date = $this->date_difference($start_date, date("Y-m-d h:i:s"));
            //do more intricate functions later to get further info
            return '<span class="badge"><b>Statistics:</b></span>&nbsp;
            <span class="badge"><b>'.$members.'</b><br />'.$member_string.'</span>&nbsp;
            <span class="badge"><b>'.$date[0].'</b><br />'.$date[1].'</span>&nbsp;
            <span class="badge"><b>0</b><br />Points</span>&nbsp;
            <span class="badge"><b>0</b><br />Popularity</span>&nbsp;';
        }
        //get privilege/status/name
        public function get_place($branch, $projectID){
            $place_q = $this->Query("SELECT `privilege` FROM `projects_data` WHERE `what` = %s AND `branch` = %s AND `projectID` = %d AND `to` = %d", 'branch', $branch, $projectID, $_SESSION['ID']);
            $person_q = $this->Query("SELECT `status` FROM `projects_invited` WHERE `person` = %d AND `projectID` = %d", $_SESSION['ID'], $projectID);
            $person = mysql_fetch_assoc($person_q);
            $place = mysql_fetch_assoc($place_q);
            $privilege = $this->num2privilege($place['privilege']);
            return '
                <b><a class="profile_'.$_SESSION['ID'].'">'.id2user($_SESSION['ID']).'</a></b> : '.$privilege.'
                <input id="inputStatus" type="text" value="'.$person['status'].'" placeholder="Update status"/>
            ';
        }
        protected function get_every_x_in_x($privilege, $branch, $projectID, $self = TRUE){
            //returns the id of every privilege in branch as array
            $result = $this->Query("SELECT * FROM `projects_data` WHERE `privilege` = %d AND `title` = %s AND `what` = %s AND `projectID` = %d", $privilege, $branch, 'branch', $projectID);
            $return = array();
            while($row = mysql_fetch_assoc($result)){
                $to = $row['to'];
                if($self == FALSE){
                    if($to != $_SESSION['ID']){
                        array_push($return, $to);
                    }
                }else{
                    array_push($return, $to);
                }
            }
            return $return;
        }
        private static function select_loop($array, $first, $last, $search){
            $finish = NULL;
            $first = substr($first, 0, -1);
            if($search == TRUE){
                $end = substr($last, 1);
                $finish .= '<'.$end.'<input type="text" />'.$last;
            }
            if(count($array) == 0){
                return '<b>This project has no other members.</b>';
            }else{
                for($i = 0; $i < count($array); $i++){
                    $memberID = id2user($array[$i], 'user2id');
                    $tag = ($last == '</label>') ? 'a class="profile_'.$memberID.'"' : 'span';
                    $finish .= $first.' class="member_check_'.$memberID.'"><'.$tag.'>'.$array[$i].'</'.$tag.'>'.$last;
                }
            }
            return $finish;
        }
        public function member_select($type, $projectID, $self = TRUE, $search = FALSE){
            //list all members, potentially excluding the active user, with the chosen display
            $result = $this->Query("SELECT `person` FROM `projects_invited` WHERE `projectID` = %d", $projectID);
            $array = array();
            while($row = mysql_fetch_assoc($result)){
                array_push($array, id2user($row['person']));
            }
            if($self == FALSE){
                $key = array_search(id2user($_SESSION['ID']), $array);
                unset($array[$key]);
            }
            if($type == 'checkbox'){
                $main = self::select_loop($array, '<label><input type="checkbox">', '</label>', $search);
            }else{
                $main = '<select class="member_select">';
                for($i = 0; $i < count($array); $i++){
                    $memberID = id2user($array[$i], 'user2id');
                    $main .= '<option value="'.$memberID.'">'.$array[$i].'</option>';
                }
                $main .= '</select>';
            }
            return $main;
        }
        protected function tag_form($which, $id){
            return '
                <div class="row" style="text-align: center;">
                    <input type="text"placeholder="Tag name" /><br />
                    <button>Add Tag</button><br />
                    <textarea readonly></textarea><br /><br />
                    <select>
                    
                    </select>
                    <button>Remove Tag</button>
                </div>
            ';
        }
        public static function create_new_workspace($name, $category, $description){
            $sql = new SQL;
            //create a new workpsace
            $date = date('Y-m-d h:i:s A');
            $user = $_SESSION['ID'];
            $sql->Query("INSERT INTO `projects` (`name`, `creator`, `category`, `description`, `date`, `completed`, `popularity`) VALUES (%s, %d, %s, %s, %s, %d, %d) ", $name, $user, $category, $description, $date, 0, 0);
            $newid = mysql_insert_id();
            $sql->Query("INSERT INTO `projects_invited` (`projectID`, `creator`, `projectname`, `person`, `privilege`, `accepted`, `date`) VALUES (%d, %d, %s, %d, %d, %d, %s) ", $newid, $user, $name, $user, 0, 1, date('Y-m-d h:i:s'));
            $sql->Query("INSERT INTO `projects_data` (`projectID`, `what`, `title`, `to`, `level`, `privilege`, `branch`) VALUES (%d, %s, %s, %d, %d, %d, %s) ", $newid, 'branch', 'Master', $user, 0, 0, 'Master');
        }
        public function project_categories($selected_category = 'Just for Fun'){
            $result = NULL;
            for($i = 0; $i < count(self::$DATA['categories']); $i++){
                if(self::$DATA['categories'][$i] == $selected_category){
                    $plus = 'selected';
                }else $plus = '';
                $result .= '<option '.$plus.'>'.self::$DATA['categories'][$i].'</option>';
            }
            return $result;
        }
    }
    class Observer extends Person{
        public function date_time_form($id = '', $class = ''){
            return '<input type="text"id="'.$id.'"class="datepicker '.$class.'"placeholder="Date" />';
        }    
        protected function is_date_between($what, $begin, $end){
            return ($what >= $begin && $what <= $end);
        }
        protected function return_calendar($title, $body){
            return '
                <div id="events_calendar">
                <div id="events_calendar_head">
                <span id="events_calendar_options">
                    <strong>View by:</strong> <select id="events_calendar_interval"><option>Day</option><option>Week</option><option>Month</option></select>
                    <input id="events_calendar_find-date"style="width:90px;padding:3px;"type="text"placeholder="Find Date" />
                </span>
                <span id="events_calendar_title">'.$title.'</span>
                </div>
                <div id="events_calendar_body">'.$body.'</div>
                </div>
            ';
        }
        protected function abbrev_day($day){
            return substr($day, 0, 3);
        }
        protected $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        protected $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        protected $num_days = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        protected function std_time_display($from, $to){
            if($from == date('Y-m-d h:i:s', strtotime($from))){

            }else{

            }
        }
        public function events_calendar_init_month($month, $year, $branch, $projectID){
            $first_day_in_month = mktime(0, 0, 0, $month, 1, $year) ; 
            $first_day_of_week = date('D', $first_day_in_month) ; 
            foreach($this->$days as $day) if($first_day_of_week == $this->abbrev_day($day)) $offset = array_search($day, $days);
            $body = '<tr>';
            $days_in_this_month = ($month != 'February') ? $this->$num_days[array_search($month, $this->$months)] : ((date('L', $year) == 0) ? 28 : 29);
            $days_in_this_month += $offset;
            for($i = 0; $i <= count($this->$days); $i++) $body .= '<th>'.$this->abbrev_day($days[$i]).'</th>';
            $body .= '</tr><tr>';
            for($i = 1; $i <= $days_in_this_month; $i++){
                if($i > $offset) $body .= '<td>'.$i.'</td>';
                else $body .= '<td></td>';
                if($i % 7 == 0) $body .= '</tr><tr>';
            }
            $body .= '</tr>';
            die($this->return_calendar($month, $body));
        }
        public function events_calendar_init_week($month){

        }
        public function events_calendar_init_day($branch, $projectID){
            $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `branch` = %s AND `what` = %s AND (`due` = %s OR `due2` = %s)", $projectID, $branch, 'event', date("Y-m-d"), date("Y-m-d"));
            if(mysql_num_rows($result) == 0){
                die($this->return_calendar('<span id="bt_go-left"><a>&lt;</a></span>'.date("F d, Y").'<span id="bt_go-right"><a>&gt;</a></span>', '<h1>No events here</h1>'));
            }else{
                while($row = mysql_fetch_assoc($result)){

                }
            }
        }
        public function quick_add($branch, $projectID){
            $return = '<option selected>Quick Add</option>';
            $privilege = $this->get_privilege($branch, $projectID);
            if($privilege <= 3){
                $return .= '
                   <option value="create-document">Document</option>
                   <option value="create-table">Table</option>
                   <option>File</option>
                ';
            }
            if($privilege <= 2){
                $return .= '<option value="assign-task">Task</option>';
            }
            if($privilege <= 1){
                $return .= '
                    <option value="assign-event">event</option>
                    <option value="new-update">Update</option>
                ';
            }
            $return .= '<option value="create-note">Note</option><option value="suggest">Suggest</option>';
            return $return;
        }
        public function action_select($branch, $projectID){
            $return = '<option selected>Actions</option>';
            $privilege = $this->get_privilege($branch, $projectID);
            if($privilege <= 1){
                $return .= '<option value="add">Add</option>';
            }
            if($privilege == 0){
                $return .= '<option value="launch">Launch</option>';
            }
            $return .= '
                   <option value="messages">Messages</option>
                   <option value="requests">Requests</option>
            ';
            if($privilege == 0){
                $return .= '<option value="delete">Delete</option>';
            }
            return $return;
        }
        private function stream_row($mark, $what, $level, $id, $title, $by, $date, $branch, $suggest){
            $action = ($what == 'task' && $level > 0) ? 'Completed' : 'Created';
            if ($what == 'document' && $level > 0) $action .= ' (v:'.$level.')';
            if($suggest == 1) $action = 'Suggested';
            return '
                <tr class="stream_link '.$what.' '.$what.'-'.$id.' everything wiu">
                    <td>'.ucfirst($what).'</td><td>'.$action.'</td><td>'.$title.'</td><td>'.($action != 'Completed' ? id2user($by) : id2user($mark)).'</td><td>'.$date.'</td><td>'.$branch.'</td>
                </tr>
            ';
        }
        private function version_select($id){
            $array = $this->return_version_array($id);
            $version = max($array);
            $finish = '<select class="version_select'.$id.'">';
            for($i = 0; $i <= $version; $i++){
                $finish .= '<option>'.$i.'</option>';
            }
            $finish .= '</select>';
            return $finish;
        }
        private function board_row($level, $by, $id, $title, $branch, $date, $style, $getOne, $mark, $title, $body, $suggest){
                $person = id2user($by);
                $style = ($style == TRUE) ? 'style="display:none;"' : NULL;
                $return = '
                    <div class="widget wiu doc_'.$by.'">
                        <div class="head'.$id.'">
                           <b>'.$title.'</b>, Branch: <b>'.$branch.'</b>. Version <b>#'.$level.'</b> | '.$date.'<img style="float:right;margin-right:10px;"src="/images/arrowo.png" id="arrownews1" border="0">
                        </div>
                        <div class="body'.$id.'" '.$style.'>';
                if($getOne == TRUE && $suggest == 0) $return .= '            
                           <div class="row">
                                <label>Change version:</label> '.$this->version_select($mark).'
                            </div>';
                else if($suggest == 1) $return .= '<div class="row"><b>(Suggestion)</b></div>';
                $return .= '
                            <div class="row">
                                <label>By:</label> <a class="profile_'.id2user($person, 'user2id').'">'.$person.'</a>
                            </div>
                            <div class="row">
                                <label>Last updated:</label> '.$date.'
                            </div>
                            <div class="row">
                                <label>Title:</label> '.($getOne == FALSE ? $title : '<br /><input class="page_update-title"type="text"value="'.$title.'" style="margin-left:5%;"/>').'
                            </div>
                            <div class="row">
                                <label>Description:</label><br />'.($getOne == FALSE ? $body.'<a class="more_document-'.$id.'">...View More.</a>' : '<br /><textarea class="page_update-body"style="margin-left:5%;">'.$body.'</textarea>').'
                            </div>';
                /*if($getOne == TRUE){
                    $finish .= $this->tag_form('element', $row['id']);
                }*/            
                $return .= '            
                            <div class="row" style="text-align: center;">
                                <input type="hidden"class="element-id"value="'.$mark.'"/>
                                <input type="hidden"class="doc_level"value="'.$level.'"/>
                                <input type="hidden"class="doc_dd'.$mark.'"value="'.$level.'"/>
                                <br />';
                if($getOne == FALSE) $return .= '<button class="more_document-'.$id.'">More</button> &nbsp; ';
                else $return .= '<button class="button_update-element">Update</button> &nbsp; '.($suggest == 0 ? '<button class="'.$mark.'version">New Version</button>&nbsp;' : '<button class="confirm-suggest'.$id.'">Confirm</button>&nbsp;');
                $return .= '
                                <button class="button_delete-element"id="dd'.$mark.'">'.($suggest == 1 ? 'Deny' : 'Delete Version').'</button>
                            </div>
                        </div>
                    </div>
                ';
                return $return;
        }
        private function update_row($level, $style, $id, $title, $date, $by, $body, $getOne){
                $level = ($level == 0) ? 'Public' : 'Member';
                $style = ($style == TRUE) ? 'style="display:none;"' : NULL;
                $return = '
                    <div class="widget wiu '.$level.' all-updates">
                        <div class="head'.$id.'"><b>'.$title.'</b>: '.$level.' Update- '.$date.'<img style="float:right;margin-right:10px;"src="/images/arrowo.png" id="arrownews1" border="0"></div>
                        <div class="body'.$id.'" '.$style.'>
                            <div class="row">
                                <label>By:</label>  <a class="profile_'.$by.'">'.id2user($by).'</a>
                            </div>
                            <div class="row">
                                <label>Title:</label>  '.($getOne == FALSE ? $title : '<br /><br /><input class="page_update-title"style="margin-left:5%;"type="text"value="'.$title.'"/>').'
                            </div>
                            <div class="row">
                                <label>Description:</label>  '.($getOne == FALSE ? $body : '<br /><br /><textarea class="page_update-body"style="margin-left:5%;">'.$body.'</textarea>').'<a class="more_update-'.$id.'">'.($getOne == FALSE ? '<a class="more_update-'.$id.'">...View More</a>' : '').'
                            </div>
                            <input type="hidden"value="'.$id.'"class="element-id"/>
                            <div class="row" style="text-align: center;">
                                <br />';
                if($getOne == TRUE) $return .= '<button class="button_update-element">Update</button>';
                else $return .= '<button class="more_update-'.$id.'">More</button>';
                $return .= '
                                &nbsp;<button class="button_delete-element"id="dd'.$id.'">Delete</button>
                            </div>
                        </div>
                    </div>
                ';
                return $return;    
        }
        //return array with status and inputs
        private function task_radio_select($level, $id){
            $array = array('Incomplete', 'Almost complete', 'Complete');
            $status = $array[$level];
            $return = NULL;
            for($i = 0; $i < count($array); $i++){
                $check = ($array[$i] == $array[$level]) ? 'checked' : '';
                $return .= '<input type="radio" name="status'.$id.'"value="'.$i.'" '.$check.' /> '.$array[$i].' <br />';
            }
            return array($status, $return);
        }
        public static function return_assigned_people($to){
            $assigned_to = NULL;
            for($i = 0; $i < count($to); $i++){
                $assigned_to .= '<a class="profile_'.$to[$i].'">'.id2user($to[$i]).'</a>, ';
            }
            $assigned_to = substr($assigned_to, 0, -2);
            return $assigned_to;
        }
        private function current_assigned_people($to, $projectID){
            $c_q = $this->Query("SELECT `person` FROM `projects_invited` WHERE `projectID` = %d", $projectID);
            $current = NULL;
            while($c = mysql_fetch_assoc($c_q)){
                if(in_array($c['person'], $to)){
                    $check = 'checked';
                }else{
                    $check = NULL;
                }
                $current .= '<input type="checkbox" '.$check.'>'.id2user($c['person']);
            }
            return $current;
        }
        private function task_row($id, $level, $big_array, $title, $branch, $date, $getOne, $projectID, $by, $body, $due){
            $checkbox = $this->event_level_checkbox($level, $id);
            if($getOne == FALSE){
                $due1 = date('d', strtotime($due)); //Day due
                $color = NULL;
                if(time() > $due){
                    $color = 'red';
                    $perm = 'red';
                }
                if($level == 1) $color = 'green';
                $due1 = '<span id="event-color'.$id.'"style="color:'.$color.'"class="event_'.$perm.'">'.$due1.'</span>';
                return '
                    <div id="event-div'.$id.'">
                        <ul>
                            <li id="event-day">'.$due1.'</li>
                            <li id="event-check"><b>'.$checkbox.'</b></li>
                            <li id="event-date">Due: '.$due.'</li>
                            <li id="event-name"><b>'.$title.'</b></li>
                        </ul>
                    </div>
                ';
            }else{
                $to = json_decode($big_array);
                $current = $this->current_assigned_people($to, $projectID);
                $status = ($level == 0) ? 'Incomplete' : 'Complete';
                return '
                    <div class="widget wiu">
                        <div class="head'.$id.'"><b>'.$title.'</b>. Branch: <b>'.$branch.'</b>. <b>'.$status.'. Due: '.$due.'</b><img style="float:right;margin-right:10px;"src="/images/arrowo.png" id="arrownews1" border="0"></div>
                        <div class="body'.$id.'">
                            <div class="row">
                                <label>Assigned:</label> '.$date.'
                            </div>
                            <div class="row">
                                <label>Due:</label> <br /><input class="datepicker"style="margin-left:5%;"type="text"value="'.$due.'"/><br />
                            </div>
                            <div class="row">
                                <label>Title:</label> <br /><input type="text" style="margin-left:5%;"value="'.$title.'"/>
                            </div>
                            <div class="row">
                                <label>Assigned By:</label> <a class="profile_'.$by.'">'.id2user($by).'</a><br /><br />
                                <label>To:</label> '.$current.'
                            </div>
                            <div class="row">
                                <!--Radio select-->
                                '.$checkbox.'<span id="mi-status">'.$status.'</span>
                            </div><br />Description:<br /><br /><textarea style="margin-left:5%;">'.$body.'</textarea>
                            <div class="row" style="text-align: center;">
                                <br />
                                <button>Update</button>&nbsp;<button class="button_delete-element"id="dd'.$id.'">Delete</button>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        private function event_level_checkbox($level, $id){
            $checked = ($level == 0) ? '' : 'checked';
            return '<input type="checkbox"name="status'.$id.'" '.$checked.'>';
        }
        private function event_row($id, $level, $title, $branch, $date, $getOne, $projectID, $by, $due, $due2){
            if($getOne == FALSE){
                $due1 = date('d', strtotime($due)); //Day due
                return '
                    <div id="event-div'.$id.'">
                        <ul>
                            <li id="event-day">'.$due1.'</li>
                            <li id="event-date">Starts: 9/7/13</li>
                            <li id="event-date">Ends: 9/12/13</li>
                            <li id="event-name"><b>'.$title.'</b></li>
                        </ul>
                    </div>
                ';
            }else{
                return '
                    <div class="widget wiu">
                        <div class="head'.$id.'"><b>'.$title.'</b>. Branch: <b>'.$branch.'</b></b><img style="float:right;margin-right:10px;"src="/images/arrowo.png" id="arrownews1" border="0"></div>
                        <div class="body'.$id.'">
                            <div class="row">
                                <label>From:</label> <br /><input class="datepicker"style="margin-left:5%;"type="text"value="'.$due.'"/><br />
                                <label>To:</label> <br /><input class="datepicker"style="margin-left:5%;"type="text"value="'.$due2.'"/><br />
                            </div>
                            <div class="row">
                                <label>Event:</label> <br /><input type="text" style="margin-left:5%;"value="'.$title.'"/>
                            </div>
                            <div class="row" style="text-align: center;">
                                <br />
                                <button>Update</button>&nbsp;<button class="button_delete-element"id="dd'.$id.'">Delete</button>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        private function table_row($id, $title, $style, $branch, $date, $by, $getOne, $big_array){
                $style = ($style == TRUE) ? 'style="display:none;"' : NULL;
                return '
                    <div class="widget wiu">
                        <div class="head'.$id.'"><b>'.$title.'</b>. Branch: <b>'.$branch.'</b> '.$date.'</b></div>
                        <div class="body'.$id.'" '.$style.'style="overflow-x:auto;">
                            <div class="row">
                                &nbsp;<label>By:</label> <a class="profile_'.$by.'">'.id2user($by).'</a>, <label>Last updated:</label> <b>'.$date.'</b>
                            </div>
                            '.($getOne == TRUE ? '
                            <div class="row" style="text-align:center;">
                                '.$this->table_edit_menu().'
                            </div>' : '').'
                            <div class="row" style="text-align:center;">
                                &nbsp;'.($getOne == FALSE ? '<b style="font-size:1.5em;font-style: italic;">'.$title.'</b>' : '<input type="text"value="'.$title.'"style="text-align:center;font-weight:bold;font-size:1.5em;font-style:italic;"/>').'<br /><br />
                                <table cellpadding="0" cellspacing="0" width="100%" contenteditable="false">
                                    '.htmlspecialchars_decode($big_array).'
                                </table>
                            </div>
                            <div class="row" style="text-align: center;">
                                <br />
                                '.($getOne == FALSE ? '<button class="more_table-'.$id.'">More</button>' : '<button>Update</button>').'&nbsp;<button class="button_delete-element"id="dd'.$id.'">Delete</button>
                            </div>
                        </div>
                    </div>
                ';
        }
        private function note_row($id, $title, $date, $body){
            return '
                    <div class="'.$id.'note">
                        <div class="note_head" style="font-style:italic;text-align: center;"><b>'.$title.'</b></div><br />
                        <div class="note_date" style="text-align: center;"><i>'.$date.'</i></div><br />
                        <div class="note_body">
                            '.$body.'
                        </div>
                    </div>
                ';
        }
        private function search_row($what, $level, $id, $title, $by, $date, $branch){
            $what = $what;
            $what2 = ($what == 'document') ? $what.'(v:'.$level.')' : $what;
            return '<a style="font-size:1.2em;text-decoration:underline;"class="more_'.$what.'-'.$id.'"><strong>'.$title.'</strong>, '.$what2.'. By: '.id2user($by).', '.$date.'. Branch: '.$branch.'</a><br /><br />';
        }
        private function page2element($page){
            foreach(self::$DATA['section_elements'] as $key => $value){
                if($key == $page) return $value;
            }
            return FALSE;
        }
        private function suggest_row($projectID, $id, $what, $by, $style, $main, $title, $date, $branch){
            $privilege = $this->get_privilege('Master', $projectID);
            return '
                <div class="widget wiu '.$what.' everything">
                    <div class="head'.$id.'">'.ucfirst($what).': <b>'.$title.'</b>. Branch: <b>'.$branch.'</b> '.$date.'</b></div>
                        <div class="body'.$id.'" '.$style.'style="overflow-x:auto;">
                            <div class="row">
                                &nbsp;<label>Title:</label> '.$title.'
                            </div>
                            <div class="row">
                                &nbsp;<label>By:</label> <a class="profile_'.$by.'">'.id2user($by).'</a>
                            </div>
                            <div class="row">
                                    '.($what == 'table' ? '<table cellpadding="0" cellspacing="0" width="100%" contenteditable="false">'.htmlspecialchars_decode($main).'</table>' : 'Description:<br />'.$main.'...<a class="more_document-'.$id.'">View more.</a>').'
                            </div>
                                '.($privilege <= 1 ? '<div class="row" style="text-align: center;"><br /><button class="more_'.$what.'-'.$id.'">More</button>&nbsp;<button class="confirm-suggest'.$id.'">Confirm</button>&nbsp;<button class="deny-suggest'.$id.'">Deny</button></div>' : '').'
                        </div>
                </div>
            ';
        }
        public function add_row_on_scroll($projectID, $branch, $page, $limiter, $query){
            //return 5 extra elements
            $getOne = FALSE;
            if($page == 'Tasks' || $page == 'Tables' || $page == 'events'){
                if($branch != 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `branch` = %s AND `what` = %s AND `suggest` = %d ".self::ORDER." LIMIT %d, %d", $projectID, $branch, $this->page2element($page), 0, $limiter, self::APPEND);
                else $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `what` = %s AND `suggest` = %d ".self::ORDER." LIMIT %d, %d", $projectID, $this->page2element($page), 0, $limiter, 1);
            }
            switch($page){
                case 'Stream':
                    if($branch != 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `branch` = %s AND `what` != %s AND `what` != %s AND `what` != %s AND `suggest` = %d ".self::ORDER." LIMIT %d, %d", $projectID, $branch, 'message', 'branch', 'note', 0, $limiter, self::APPEND);
                    else $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `what` != %s AND `what` != %s AND `what` != %s AND `suggest` = %d ".self::ORDER." LIMIT %d, %d", $projectID, 'message', 'branch', 'note', 0, $limiter, self::APPEND);
                    while($row = mysql_fetch_assoc($result)){
                        die($this->stream_row($row['mark'], $row['what'], $row['level'], $row['id'], $row['title'], $row['by'], $row['date'], $row['branch'], $row['suggest']));
                    }
                    break;
                case 'Boards':
                    if($branch != 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `branch` = %s AND `what` = %s AND `level` = %d AND `suggest` = %d ".self::ORDER." LIMIT %d, %d", $projectID, $branch, 'document', 0, 0, $limiter, self::APPEND);
                    else $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `what` = %s AND `level` = %d AND `suggest` = %d ".self::ORDER." LIMIT %d, %d", $projectID, 'document', 0, 0, $limiter, self::APPEND);
                    while($row = mysql_fetch_assoc($result)){
                        die($this->board_row($row['level'], $row['by'], $row['id'], $row['title'], $row['branch'], $row['date'], FALSE, $getOne, $row['mark'], $row['title'], $row['body'], $row['suggest']));
                    }
                    break;
                case 'Updates':
                    if($branch == 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `suggest` = %d ".self::ORDER." LIMIT %d, %d", 'update', $projectID, 0, $limiter, self::APPEND);
                    else $result = $this->Query("SELECT * FROM `projects_data` WHERE (`what` = %s AND `projectID` = %d) AND (`branch` = %s OR `level` = %d) AND `suggest` = %d ".self::ORDER." LIMIT %d, %d", 'update', $projectID, $branch, 0, 0, $limiter, self::APPEND);
                    while($row = mysql_fetch_assoc($result)){
                        die($this->update_row($row['level'], FALSE, $row['id'], $row['title'], $row['date'], $row['by'], $row['body'], $getOne));
                    }
                    break;
                case 'Tasks':
                    while($row = mysql_fetch_assoc($result)){
                        die($this->task_row($row['id'], $row['level'], $row['big_array'], $row['title'], $row['branch'], $row['date'], $getOne, $projectID, $row['by'], $row['body'], $row['due']));
                    }
                    break;
                case 'Tables':
                    while($row = mysql_fetch_assoc($result)){
                        die($this->table_row($row['id'], $row['title'], FALSE, $row['branch'], $row['date'], $row['by'], $getOne, $row['big_array']));
                    }
                    break;
                case 'Notes':
                    if($branch != 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `branch` = %s AND `what` = %s AND `by` = %d ".self::ORDER." LIMIT %d, %d", $projectID, $branch, 'note', $_SESSION['ID'], $limiter, self::APPEND);
                    else $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `what` = %s AND `by` = %d ".self::ORDER." LIMIT %d, %d", $projectID, 'note', $_SESSION['ID'], $limiter, 1);
                    while($row = mysql_fetch_assoc($result)){
                        die($this->note_row($row['id'], $row['title'], $row['date'], $row['body']));
                    }
                    break;
               case 'events':
                    while($row = mysql_fetch_assoc($result)){
                        die($this->event_row($row['id'], $row['level'], $row['title'], $row['branch'], $row['date'], $getOne, $projectID, $row['by'], $row['due'], $row['due2']));
                    }
                    break;
               case 'search':
                   $query = '%'.$query.'%';
                   $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` != %s AND `what` != %s AND `title` LIKE %s AND `projectID` = %d  AND `what` != %s AND `suggest` = %d ORDER BY `date` LIMIT %d, %d", 'message', 'branch', $query, $projectID, 'note', 0, $limiter, self::APPEND);
                   while($row = mysql_fetch_assoc($result)){
                        die($this->search_row($row['what'], $row['level'], $row['id'], $row['title'], $row['by'], $row['date'], $row['branch']));
                   }
                   break;
                case 'Suggest':
                   $result = $this->Query("SELECT * FROM `projects_data` WHERE `suggest` = %d AND `projectID` = %d AND `branch` = %s ORDER BY `date` LIMIT %d, %d", 1, $projectID, $branch, $limiter, self::APPEND);
                   while ($row = mysql_fetch_assoc($result)) {
                       $main = ($row['what'] == 'document') ? $row['body'] : $row['big_array'];
                       die($this->suggest_row($projectID, $row['id'], $row['what'], $row['by'], FALSE, $main, $row['title'], $row['date'], $row['branch']));
                   }
                   break;
            }
            die();
        }
        public function workspace_suggestions($branch, $projectID){
            $result = $this->Query("SELECT * FROM `projects_data` WHERE `suggest` = %d AND `projectID` = %d AND `branch` = %s ".self::ORDER." LIMIT ".self::LIMIT."", 1, $projectID, $branch);
            $return = NULL;
            $style = FALSE;
            while($row = mysql_fetch_assoc($result)){
                //$return .= ($row['what'] == 'document') ? $this->board_row($row['level'], $row['by'], $row['id'], $row['title'], $row['branch'], $row['date'], $style, FALSE, $row['mark'], $row['title'], $row['body']) : $this->table_row($row['id'], $row['title'], $style, $row['branch'], $row['date'], $row['by'], FALSE, $row['big_array']);
                $main = ($row['what'] == 'document') ? $row['body'] : $row['big_array'];
                $return .= $this->suggest_row($projectID, $row['id'], $row['what'], $row['by'], $style, $main, $row['title'], $row['date'], $row['branch']);
                $style = TRUE;
            }
            return $return;
        }
        public function stream($branch, $projectID){
            $top = '
                <div class="widget">
                    <div class="head"><img src="/images/list.png">&nbsp;Recent activity in branch: <b>'.$branch.'</b><img style="float:right;margin-right:10px;"src="/images/arrowo.png" id="arrownews1" border="0"></div>
                    <div class="body">
                        <table cellpadding="0" cellspacing="0" width="100%" class="stream_table">
                            <thead>
                                <tr>
                                    <th><u>Type</u></th><th><u>Action</u></th><th><u>Title</u></th><th><u>By</u></th><th><u>Date</u></th><th><u>Branch</u></th>
                                </tr>
                            </thead>
                            <tbody>
            ';
            $middle = NULL;
            if($branch == "Master") $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `what` != %s AND `what` != %s AND `what` != %s ".self::ORDER." LIMIT ".self::LIMIT."", $projectID, 'branch', 'message', 'note');
            else $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `branch` = %s AND `what` != %s AND `what` != %s AND `what` != %s ".self::ORDER." LIMIT ".self::LIMIT."", $projectID, $branch, 'branch', 'message', 'note');
            //replace this with added link for when members join
            if(mysql_num_rows($result) == 0){
                $middle = NULL;
            }else{
                while($row = mysql_fetch_assoc($result)){
                    $middle .= $this->stream_row($row['mark'], $row['what'], $row['level'], $row['id'], $row['title'], $row['by'], $row['date'], $row['branch'], $row['suggest']);
                    }
            }
            $bottom = '
                            </tbody>
                        </table>
                    </div>
                </div>
            ';
            if(mysql_num_rows($result) == 0) 
                return '';
            else
                return $top.$middle.$bottom;
        }
        public function updates($projectID, $branch = 'Master', $getOne = FALSE, $updateID = NULL){
            $return = NULL;
            $style = FALSE;
            if($getOne == FALSE && $branch == 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `suggest` = %d ".self::ORDER." LIMIT ".self::LIMIT."", 'update', $projectID, 0);
            else if($getOne == FALSE && $branch != 'Master')$result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND (`branch` = %s OR `level` = %d) ".self::ORDER." LIMIT ".self::LIMIT."", 'update', $projectID, $branch, 0);
            else if($getOne == TRUE) $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `id` = %d", 'update', $projectID, $updateID);
            while($row = mysql_fetch_assoc($result)){
                $return .= $this->update_row($row['level'], $style, $row['id'], $row['title'], $row['date'], $row['by'], $row['body'], $getOne);
                $style = TRUE;
            }
            return $return;
        }
        public function control_panel($projectID){
            $top = '
                <div class="widget">
                    <div class="head"><img src="/images/list.png">&nbsp;Control Panel:<img style="float:right;margin-right:10px;"src="/images/arrowo.png" id="arrownews1" border="0"></div>
                    <div class="body">
            ';
            $privilege = $this->get_privilege('Master', $projectID);
            $result = $this->Query("SELECT `id`, `name`, `category`, `description` FROM `projects` WHERE `id` = %d", $projectID);
            $row = mysql_fetch_assoc($result);
            $type = ($privilege <= 1) ? 
            //manager+
            array('input value="'.$row['name'].'"type="text"class="project_title" /', 'textarea class="project_description"', '', $row['description']) 
            : 
            //else
            array('div', 'div', $row['name'], $row['description']);
            $middle = '
                <div class="row">
                    <label>Category:</label>&nbsp;
                        <select class="project_category">
                            '.$this->project_categories($row['category']).'
                        </select>
                </div>
                <div class="row">
                   <label>Name:</label><br /><br /><span style="margin-left:5%;"><'.$type[0].'>'.$type[2].'</'.$type[0].'></span>
                </div>
                <div class="row">
                    <label>Description:</label><br /><br /><span style="margin-left:5%;"><'.$type[1].'>'.$type[3].'</'.$type[1].'></span>
                </div>';
                /*if($privilege <= 1){
                    $middle .= $this->tag_form('workspace', $row['id']);
                }*/
            if($privilege <= 1) $middle .= '<div class="row" style="text-align: center;"><br /><button class="button_change">Change</button></div>';
            $bottom = '
                </div>
            </div>
            ';
            return $top.$middle.$bottom;
        }
        private function my_tasks($projectID, $branch, $who){
            $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `branch` = %s LIMIT 10", 'task', $projectID, $branch);
            $return = '<br /><br />';
            if(mysql_num_rows($result) == 0) return '<b>None</b>';
            while($row = mysql_fetch_assoc($result)){
                $to = json_decode($row['big_array']);
                if(in_array($who, $to) && $row['level'] != 2){
                    $return .= '<a class="more_task-'.$row['id'].'"><b>'.$row['title'].'</b>, Assigned by: '.id2user($row['by']).'. Due: '.$row['date'].'</a><br /><br />';
                }
            }
            if($return == '<br /><br />') return '<b>None</b>';
            return $return;
        }
        public function workspace_groups($branch, $projectID, $getUser = FALSE, $userID = NULL){
            $finish = NULL;
            if($getUser == TRUE) $result = $this->Query("SELECT * FROM `projects_invited` WHERE `projectID` = %d AND `accepted` = %d AND `person` = %d", $projectID, 1, $userID);
            else $result = $this->Query("SELECT * FROM `projects_invited` WHERE `projectID` = %d AND `accepted` = %d", $projectID, 1);
            //created everywhere
            $created_everywhere = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `what` != %s AND `what` != %s AND `suggest` = %d AND `branch` = %s ".self::ORDER."", $projectID, 'branch', 'message', 0, $branch);
            //completed everywhere
            $result_tasks2 = $this->Query("SELECT * FROM `projects_data` WHERE `mark` != %d AND `what` = %s AND `projectID` = %d AND `suggest` = %d AND `branch` = %s ".self::ORDER."", 0, 'task', $projectID, 0, $branch);
            $style = NULL;
            while($row = mysql_fetch_assoc($result)){
                $status = ($row['status'] == '') ? '<b>N/A</b>' : $row['status'];
                //created by user
                $created_user = $this->Query("SELECT * FROM `projects_data` WHERE `by` = %d AND `projectID` = %d AND `what` != %s AND `what` != %s AND `suggest` = %d AND `branch` = %s ".self::ORDER."", $row['person'], $projectID, 'branch', 'message', 0, $branch);
                //completed by user
                $result_tasks = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `mark` = %d AND `projectID` = %d AND `suggest` = %d AND `branch` = %s ".self::ORDER."", 'task', $row['person'], $projectID, 0, $branch);
                // a bit of math, just getting how much theyve done compared to others
                $user_done = mysql_num_rows($created_user) + mysql_num_rows($result_tasks);
                $all_done = mysql_num_rows($created_everywhere) + mysql_num_rows($result_tasks2);
                //show a percentage of what theyve contributed
                if($user_done == 0){
                    $percent = '0%';
                }else{
                    $decimal = $user_done / $all_done;
                    $percent = round($decimal * 100);
                    $percent = $percent.'%';
                }
                $privilege = $this->num2privilege($_SESSION['PRIV']);
                $person = id2user($row['person']);
                $finish .= '
                    <div class="widget group '.lcfirst($privilege).' wiu">
                        <div class="head'.$row['person'].'">'.$person.': '.$privilege.'<img style="float:right;margin-right:10px;"src="/images/arrowo.png" id="arrownews1" border="0"></div>
                        <div class="body'.$row['person'].'" '.$style.'>
                            '.($getUser == TRUE && $_SESSION['PRIV'] == 0 && $row['privilege'] != 0 ? '<div class="row"><button class="button_remove-member">Remove Member</button></div>' : '').'
                            <div class="row">
                                <label>Contributed:</label> '.$percent.' of branch '.$branch.'. ('.$user_done.' / '.$all_done.')
                            </div>
                            <div class="row">
                                <label>Joined:</label> '.$row['date'].'
                            </div>
                            <div class="row">
                                <label>Privilege in branch '.$branch.':</label><b> '.($getUser == TRUE && $privilege != 'Creator' ? $this->alter_this('class', 'group_privilege_select', $this->privilege_select($privilege, FALSE)) : $privilege).'</b>
                            </div>
                            <div class="row">
                                <label>Status:</label> '.$status.'
                            </div>'.
                            ($getUser == FALSE ? '<div class="row">
                                <label><a class="profile_'.$row['person'].'">More...</a></label> 
                            </div>' : '
                                <div class="row">
                                    <label>Pending tasks:</label>
                                    '.$this->my_tasks($projectID, $branch, $row['person']).'
                                </div>
                                <div class="row">
                                    <label>Graphs:</label><br /><br />
                                </div>
                            ').'
                            <div class="row" style="text-align: center;">
                                <br />
                                '.($getUser == TRUE ? '<input type="hidden"value="'.$row['person'].'"class="userID" />' : '').'
                                <a target="_blank" href="/user/'.$person.'">Full Profile</a>
                            </div>
                        </div>
                    </div>
                ';
                $style = 'style="display:none;"';
            }
            return $finish;
        }
        public function workspace_tasks($branch, $projectID, $getOne = FALSE, $taskID = NULL, $user = NULL){
            if($getOne == FALSE && $branch == 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `suggest` = %d ".self::ORDER." LIMIT ".self::LIMIT."", 'task', $projectID, 0);
            else if($getOne == TRUE) $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `id` = %d", 'task', $projectID, $taskID);
            else $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `branch` = %s AND `projectID` = %d ".self::ORDER." LIMIT ".self::LIMIT."", 'task', $branch, $projectID);
            $return = NULL;
            while($row = mysql_fetch_assoc($result)){
                $return .= $this->task_row($row['id'], $row['level'], $row['big_array'], $row['title'], $row['branch'], $row['date'], $getOne, $projectID, $row['by'], $row['body'], $row['due']);
            }
            return $return;
        }
        public function workspace_events($branch, $projectID, $getOne = FALSE, $eventID = NULL){
            if($getOne == FALSE && $branch == 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `suggest` = %d ".self::ORDER." LIMIT ".self::LIMIT."", 'event', $projectID, 0);
            else if($getOne == TRUE) $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `id` = %d", 'event', $projectID, $eventID);
            else $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `branch` = %s AND `projectID` = %d ".self::ORDER." LIMIT ".self::LIMIT."", 'event', $branch, $projectID);
            $return = NULL;
            $style = FALSE;
            while($row = mysql_fetch_assoc($result)){
                $return .= $this->event_row($row['id'], $row['level'], $row['title'], $row['branch'], $row['date'], $getOne, $projectID, $row['by'], $row['due'], $row['due2']);
                $style = TRUE;
            }
            return $return;
        }
        public function update_status($status, $projectID){
            $this->Query("UPDATE `projects_invited` SET `status` = %s WHERE `person` = %d AND `projectID` = %d", $status, $_SESSION['ID'], $projectID);
        }
        protected function return_version_array($id){
            $result = $this->Query("SELECT `level` FROM `projects_data` WHERE `mark` = %d ORDER BY `level` ASC", $id);
            $array = array();
            while($row = mysql_fetch_assoc($result)){
                array_push($array, $row['level']);
            }
            return $array;
        } 
        public function workspace_boards($branch, $projectID, $getOne = FALSE, $docID = NULL){
            if($getOne == FALSE && $branch == 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `suggest` = %d AND `level` = %d ".self::ORDER." LIMIT ".self::LIMIT."", 'document', $projectID, 0, 0);
            else if($getOne == FALSE) $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `branch` = %s AND `suggest` = %d AND `level` = %d ".self::ORDER." LIMIT ".self::LIMIT."", 'document', $projectID, $branch, 0, 0);
            else $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `id` = %d ".self::ORDER." LIMIT ".self::LIMIT."", 'document', $projectID, $docID);
            $return = NULL;
            $style = FALSE;
            while($row = mysql_fetch_array($result)){
                $return .= $this->board_row($row['level'], $row['by'], $row['id'], $row['title'], $row['branch'], $row['date'], $style, $getOne, $row['mark'], $row['title'], $row['body'], $row['suggest']);
                $style = TRUE;
            }
            return $return;
        }
        public function workspace_tables($branch, $projectID, $getOne = FALSE, $tableID = NULL){
            if($getOne == FALSE && $branch == 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `suggest` = %d ".self::ORDER." LIMIT ".self::LIMIT."", 'table', $projectID, 0);
            else if($getOne == TRUE) $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `branch` = %s AND `id` = %d", 'table', $projectID, $branch, $tableID);
            else $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `branch` = %s ".self::ORDER." LIMIT ".self::LIMIT."", 'table', $projectID, $branch);
            $return = NULL;
            $style = FALSE;
            while($row = mysql_fetch_assoc($result)){
                $return .= $this->table_row($row['id'], $row['title'], $style, $row['branch'], $row['date'], $row['by'], $getOne, $row['big_array']);
                $style = TRUE;
            }
            return $return;
        }
        public function create_note($projectID, $branch, $title, $body){
            $this->Query("INSERT INTO `projects_data` (`projectID`, `branch`, `what`, `title`, `body`, `date`, `by`) VALUES (%d, %s, %s, %s, %s, %s, %d)", $projectID, $branch, 'note', $title, $body, date("Y:m:d h-i-s"), $_SESSION['ID']);
        }
        public function workspace_notes($projectID, $branch){
            if($branch == 'Master') $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `by` = %d ".self::ORDER." LIMIT ".self::LIMIT."", 'note', $projectID, $_SESSION['ID']);
            else $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `by` = %d AND `branch` = %s ".self::ORDER." LIMIT ".self::LIMIT."", 'note', $projectID, $_SESSION['ID'], $branch);
            $return = NULL;
            while($row = mysql_fetch_assoc($result)){
                $return .= $this->note_row($row['id'], $row['title'], $row['date'], $row['body']);
            }
            return $return;
        }
        public function search($projectID, $branch, $query){
            $return = NULL;
            $query = '%'.$query.'%';
            $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` != %s AND `what` != %s AND `title` LIKE %s AND `projectID` = %d AND `what` != %s ORDER BY `date` LIMIT ".self::LIMIT, 'message', 'branch', $query, $projectID, 'note');
            if(mysql_num_rows($result) == 0) return 'No results found.';
            else{
                while($row = mysql_fetch_assoc($result)){
                    $return .= $this->search_row($row['what'], $row['level'], $row['id'], $row['title'], $row['by'], $row['date'], $row['branch']);
                }
            }
            return $return;
        }
        public function send_message($projectID, $title, $body, $to){
            $this->CLEAN = FALSE;
            $this->Query("INSERT INTO `projects_data` (`projectID`, `title`, `body`, `big_array`, `by`, `date`) VALUES %d, %s, %s, %s, %d, %s", $projectID, $title, $body, $to, $_SESSION['ID'], date("Y-m-d h:i:s"));
        }
        public function get_version($mark, $version){
            $result = $this->Query("SELECT * FROM `projects_data` WHERE `what` = %s AND `mark` = %d AND `level` = %d", 'document', $mark, $version);
            $row = mysql_fetch_assoc($result);
            return $this->board_row($row['level'], $row['by'], $row['id'], $row['title'], $row['branch'], $row['date'], FALSE, TRUE, $row['mark'], $row['title'], $row['body'], 0);
        }
        public function cms_popup($what, $projectID, $branch, $id = NULL, $help = NULL){
            switch($what){
                case 'create':
                    $cms_description = 'Create a new workspace.';
                    $select = $this->project_categories();
                    $cms_body = '
                        <select class="create_category">
                            '.$select.'
                        </select><br />
                        <input type="text" class="create_title" placeholder="Title" autofocus/><br />
                        <textarea class="create_body" placeholder="Description"></textarea>
                        <br />
                        <button class="button_create">Create</button>
                    ';
                    break;
                case 'launch':
                    $cms_description = 'Make your idea public.';
                    $result = $this->Query("SELECT `launched` FROM `projects` WHERE `id` = %d", $projectID);
                    $row = mysql_fetch_assoc($result);
                    if($row['launched'] > 0){
                        $what = ($row['launched'] == 1) ? 'project' : 'job';
                        $cms_body = '<br /><b><select class="launch_select" style="display:none;"><option value="0">0</option></select>You have already launched as a '.$what.'.</b><br /><br /><button class="button_launch">Un-launch</button>';
                    }else{
                        $cms_body = '
                            <select class="launch_select">
                                <option value="1">Project</option>
                                <option value="2">Job</option>
                            </select>
                            <button class="button_launch">Launch</button>
                            <br /><br />
                            <div class="launch_info">
                                <b>Info:</b><br />
                                Open your project to the public, allowing people to request permission to join your project.
                                Projects are group of people working together to create something, where everyone plays a 
                                part in a major goal, for whatever the chosen incentive. If you would rather just pay a few
                                people to do a task, no questions asked, launch this as a job.
                            </div>
                        ';
                    }
                    break;
                case 'requests':
                    $cms_description = 'Choose who you\'d like to allow into your workspace.';
                    $cms_body = NULL;
                    $result = $this->Query("SELECT * FROM `projects_invited` WHERE `projectID` = %d AND `accepted` = %d", $projectID, 0);
                    if(mysql_num_rows($result) == 0) $cms_body = '<b>You have no requests yet.</b>';
                    else{
                        while($row = mysql_fetch_assoc($result)){
                            $cms_body .= '<span class="request_link'.$row['id'].'"><span class="request_head"><button class="button_accept-member">Accept</button> | <button class="button_deny-member">Deny</button></span>
                            <br /><a>'.id2user($row['person']).'</a>('.$row['date'].'):<br /> '.$row['request'].'</span>';
                        }
                    }
                    $cms_body .= '<input type="hidden"class="canJoin"value=""/>';
                    break;
                 case 'messages':
                    $cms_description = 'Manage workspace messages.';
                    $result = $this->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `what` = %s AND `to` = %d", $projectID, 'message', $_SESSION['ID']);
                    $cms_body = '
                        <a class="message_send_link">Send Message</a>
                        <br /><br />
                        <div class="message_form"style="display:none;">
                            <div class="multiselect">
                                <b>Send to individuals:</b><br /><br />
                                '.$this->member_select('checkbox', $projectID, FALSE).'
                            </div><br />
                            <input type="text" class="msg_title" placeholder="Subject"><br />
                            <textarea class="msg_body"></textarea><br />
                            <button>Send</button>
                        </div>
                        <hr />
                    ';
                    if(mysql_num_rows($result) == 0) $cms_body .= '<b>Inbox is empty.</b>';
                    else{
                        while($row = mysql_fetch_assoc($result)){
                            $cms_body .= '
                                <span class="message_link">
                                    <span class="message_head"><a>Reply</a> | <a>Delete</a></span>
                                    <div class="message_reply">
                                        <input type="text" /><br />
                                        <textarea></textarea>
                                    </div>
                                    <br />
                                    <a>'.id2user($row['by']).'</a>('.$row['date'].'):<br /> '.$row['message'].'
                                </span>
                            ';
                        }
                    }
                    break;
                 case 'add':
                    $cms_description = 'Request that someone joins your workspace.';
                    $cms_body = '
                        <div class="add_member_list">
                            <b>Find:</b>
                            <br /><br />
                            <input type="text" placeholder="Username"autofocus/><br />
                            <textarea placeholder="Request"></textarea><br />
                            <button class="button_request_user">Add</button>
                        </div>
                    ';
                    break;
                case 'branch':
                    $privilege = $this->get_privilege('Master', $projectID);
                    $cms_description = 'Manage workspace branches.';
                    $cms_body = '
                            <div class="row">
                                <input type="text"placeholder="Branch name..."class="branch_title" autofocus/><br />
                                <button class="button_create-branch">Create</button>
                            </div>
                            <div class="row">
                                <select class="branch_rename-select">'.$this->get_branches($projectID, TRUE, FALSE).'</select><br /> 
                                <input type="text" placeholder="Rename branch..."class="branch_rename-title" /><br />
                                <button class="button_rename-branch">Rename</button>
                            </div>
                    ';
                    if($privilege == 0) $cms_body .= '
                        <br />
                        <div class="row">
                            <select class="branch_delete-select">'.$this->get_branches($projectID, TRUE, FALSE).'</select>
                            <button class="button_delete-branch">Delete</button>
                        </div>
                    ';
                    break;
                case 'delete':
                    $cms_description = 'Delete this workspace, and everything associated with it.';
                    $cms_body = '<input class="delete_input"type="text"placeholder="Type DELETE here" autofocus/><br /><button class="button_delete-workspace">Delete</button>';
                    break;
                case 'leave':
                    $privilege = $this->get_privilege('Master', $projectID);
                    $cms_description = ($privilege == 0) ? 'Pass lead.' : 'Leave this project.';
                    $cms_body = (
                    $privilege != 0 ? '<input class="leave_input"type="text"placeholder="Type LEAVE here" autofocus/><br /><button class="button_leave-workspace">Leave</button>'
                    : 'Pass lead to: '.$this->alter_this('class', 'pass_member_select', $this->member_select('select', $projectID, FALSE)).'<br /><br /><button class="button_pass-lead">Pass Lead</button>'
                    );
                    break;
                case 'create-table':
                    $cms_description = 'Create a new table.';
                    $cms_body = '
                        <div class="widget">
                            '.$this->table_edit_menu().' 
                            <br />
                            <input type="text" placeholder="Name" class="table_name"/>
                            <br /><br />
                            <div class="body" style="overflow-x: auto;">
                                <span>
                                    <table class="tableBody">
                                        <tbody id="tbody" contenteditable="true">
                                            <tr>
                                                <td>data</td>
                                                <td>data</td>
                                            </tr>
                                            <tr>
                                                <td>data</td>
                                                <td>data</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </span>
                            </div>
                        </div>
                    ';
                    break;
                case 'assign-task':
                    $cms_description = 'Create and assign a new task.';
                    $cms_body = '
                        <div class="message_form">
                            <div class="multiselect">
                                <b>Assign to individuals:</b><br /><br />
                                '.$this->member_select('checkbox', $projectID, FALSE).'
                            </div>
                            <br />
                            <b>and</b>
                            <input type="checkbox"class="member_check_'.$_SESSION['ID'].'" /> myself
                            <br /><br />
                            <input type="text" placeholder="Title"class="task_title"/><br />
                            <input type="text" placeholder="Due"class="datepicker"class="task_due"/><br />
                            <textarea placeholder="Task description"class="task_desc"></textarea><br />
                            <button class="button_assign-task">Assign</button>
                        </div>
                    ';
                    break;
                case 'create-document':
                    $cms_description = 'Create a new document for branch '.$branch.'.';
                    $cms_body = '
                        <input placeholder="Title"type="text"class="doc_title" /><br />
                        <textarea class="doc_body"></textarea><br />
                        <button class="button_create-doc">Create</button>
                    ';
                    break;
                case 'new-update':
                    $cms_description = 'Create a new update, either for the public or just your team.';
                    $cms_body = '
                        <select class="update_select"><option value="0">Public</option><option value="1">Member</option></select><br />
                        <input type="text"placeholder="Title"class="update_title" /><br />
                        <textarea class="update_desc"></textarea><br /><button class="button_post-update">Post</button>
                    ';
                    break;
                case 'create-note':
                    $cms_description = 'Make a note that only you can see.';
                    $cms_body = '
                        <input type="text"placeholder="Title"class="note_title" /><br />
                        <textarea class="note_desc"></textarea><br />
                        <button class="button_create-note">Create</button>
                    ';
                    break;
                case 'note':
                    $cms_description = 'Edit this note.';
                    $result = $this->Query("SELECT * FROM `projects_data` WHERE `id` = %d", $id);
                    $row = mysql_fetch_assoc($result);
                    $cms_body = '
                        <input type="text"placeholder="Title"class="page_update-title"value="'.$row['title'].'" /><br />
                        <textarea class="page_update-body">'.$row['body'].'</textarea><br />
                        <button class="button_update-element">Update</button><br /><br />
                        <input type="hidden"class="element-id"value="'.$row['id'].'"/>
                        <button class="button_delete-element">Remove Note</button>
                        '.($_SESSION['PRIV'] <= 3 ? '<br /><br /><a class="note-transform">Create a document from this note for branch '.$branch.'.</a>' : '').'
                    ';
                    break;
                case 'new-doc-version':
                    $array = $this->return_version_array($id);
                    $result2 = $this->Query("SELECT * FROM `projects_data` WHERE `mark` = %d", $id);
                    $row = mysql_fetch_assoc($result2);
                    $version = max($array) + 1;
                    $cms_description = 'Create version <b>'.$version.'</b> of this document.';
                    $cms_body = '
                        <input placeholder="Title"type="text"class="version-doc-title"value="'.$row['title'].'" /><br />
                        <textarea class="version-doc-body">'.$row['body'].'</textarea><br />
                        <input type="hidden"class="version-doc-level"value="'.$version.'"/>
                        <input type="hidden"class="version-doc-mark"value="'.$row['mark'].'"/>
                        <button class="button_new-doc-version">Create</button>
                    ';
                    break;
               case 'suggest':
                    $cms_description = 'Suggest a new document or table for this branch.';
                    $cms_body = '
                        <select class="suggest_select">
                            <option value="document">Document</option>
                            <option value="table">Table</option>
                        </select>
                        <br />
                        <div class="suggest_interface">
                            <input type="text"class="suggest_title" /><br />
                            <textarea class="suggest_body"></textarea><br />
                            <button class="button_suggest">Suggest Document</button>
                        </div>
                    ';
                    break;
                case 'clear-suggestions':
                    $cms_description = 'Delete all suggestions in this branch.';
                    $cms_body = '<button class="button_clear-suggests">Clear All</button>';
                    break;
                case 'assign-event':
                    $cms_description = 'Create a new event.';
                    $cms_body = '
                        <input id="event_title"type="text"placeholder="Event name" /><br />
                        <input id="event_from"class="datepicker"type="text"placeholder="From" /><br />
                        <input id="event_to"class="datepicker"type="text"placeholder="To" /><br />
                        <button class="button_assign-event">Create</button>
                    ';
                    break;
                default:
                    die(self::log_suspicious(self::$pages[2], 720, "Potential HTML tamperer, cms button value altered, nonexistant. False request name: ".$what));
            }
            $what = str_replace('-', ' ', $what);
            return '
                <div class="dim"></div>
                <div class="cms_popup">
                    <div class="cms_popup_head">
                        <span class="cms_popup_options"></span>
                        <br />
                        <b style="font-size:1em;">'.ucfirst($what).'</b>
                        <br /><br />
                        '.$cms_description.'
                    </div>
                    <div class="cms_popup_body">
                        '.$cms_body.'
                    </div>
                    <div class="cms_foot">Close</div>
                </div>
            ';
        }
        public function leave_workspace($projectID){
            $this->Query("DELETE FROM `projects_invited` WHERE `person` = %d AND `projectID` = %d", $_SESSION['ID'], $projectID);
        }
        public function suggest($projectID, $branch, $what, $title, $main){
            $x = ($what == 'document') ? 'body' : 'big_array';
            $this->Query("INSERT INTO `projects_data` (`projectID`, `what`, `by`, `date`, `title`, `body`, `branch`, `suggest`) VALUES (%d, %s, %d, %s, %s, %s, %s, %d)", $projectID, $what, $_SESSION['ID'], date("Y:m:d h-i-s"), $title, $main, $branch, 1);
            if($what == 'document'){
                $this->Query("UPDATE `projects_data` SET `mark` = %d WHERE `id` = %d", mysql_insert_id(), mysql_insert_id());
            }
        }
        protected function table_edit_menu($which = 'create'){
            if($which == 'create' || $which == 'update'){
                return '
                    <div id="edit_menu">
                        <button class="button_add-up" >+</button><br />
                        <button type="button" class="button_add-left">+</button>
                        <button type="button" class="button_add-right">+</button><br />
                        <button type="button" class="button_add-down">+</button><br /><br />
                        <button id="edit_menu_delete_row_column" type="button" class="button_delete-menu">Delete Mode</button><br />
                        <button type="button" class="button_'.lcfirst($which).'-table">'.ucfirst($which).'</button>
                    </div>
                ';
            }
        }
    }
    class Member extends Observer{
        public function create_new_document($projectID, $branch, $title, $body){
            $this->Query("INSERT INTO `projects_data` (`projectID`, `what`, `by`, `date`, `title`, `body`, `branch`, `level`, `suggest`) VALUES (%d, %s, %d, %s, %s, %s, %s, %d, %d)", $projectID, 'document', $_SESSION['ID'], date("Y-m-d h:i:s"), $title, $body, $branch, 0, 0);
            $this->Query("UPDATE `projects_data` SET `mark` = %d WHERE `id` = %d", mysql_insert_id(), mysql_insert_id());
        }
        public function create_table($projectID, $branch, $table, $title){
            $this->Query("INSERT INTO `projects_data` (`projectID`, `what`, `by`, `date`, `title`, `big_array`, `branch`, `suggest`) VALUES (%d, %s, %d, %s, %s, %s, %s, %d)", $projectID, 'table', $_SESSION['ID'], date("Y:m:d h-i-s"), $title, $table, $branch, 0);
        }
        public function mark_task($taskID, $status){
            $mark = ($status == 2) ? $_SESSION['ID'] : 0;
            $this->Query("UPDATE `projects_data` SET `level` = %d, `mark` = %d WHERE `id` = %d", $status, $mark, $taskID);
        }
        public function update_update($id, $title, $body, $page, $level){
            if($page == 'Notes' || $page == 'Updates'){
                $this->Query("UPDATE `projects_data` SET `title` = %s, `body` = %s WHERE `id` = %d", $title, $body, $id);
            }else if($page == 'Boards'){
                $this->Query("UPDATE `projects_data` SET `title` = %s, `body` = %s, `date` = %s WHERE `mark` = %d AND `level` = %d", $title, $body, date("Y-m-d h:i:s"), $id, $level);
            }
        }
        public function new_document_version($projectID, $branch, $mark, $level, $title, $body){
            $this->Query("INSERT INTO `projects_data` (`projectID`, `what`, `by`, `date`, `title`, `body`, `branch`, `level`, `suggest`, `mark`) VALUES (%d, %s, %d, %s, %s, %s, %s, %d, %d, %d)", $projectID, 'document', $_SESSION['ID'], date("Y-m-d h:i:s"), $title, $body, $branch, $level, 0, $mark);
        }
    }
    class Supervisor extends Member{
        protected function order_version_nums($id){
            $version_array = $this->return_version_array($id);
            for($i = 1; $i <= count($version_array); $i++){
                $this->Query("UPDATE `projects_data` SET `level` = %d WHERE `level` = %d AND `mark` = %d AND `what` = %s", $i - 1, $version_array[$i - 1], $id, 'document');
            }
        }
        public function delete_element($id, $page, $level){
            if($page == 'Boards'){
                $this->Query("DELETE FROM `projects_data` WHERE `mark` = %d AND `level` = %d", $id, $level);
                $this->order_version_nums($id);
            }else{
                $this->Query("DELETE FROM `projects_data` WHERE `id` = %d", $id);
            }
        }
        public function assign_task($title, $desc, $to, $date, $projectID, $branch){
            $this->CLEAN = FALSE;
            $this->Query("INSERT INTO `projects_data` (`projectID`, `branch`, `title`, `body`, `what`, `date`, `level`, `by`, `big_array`, `mark`, `due`) VALUES (%d, %s, %s, %s, %s, %s, %d, %d, %s, %d, %s)", $projectID, $branch, $title, $desc, 'task', date("Y:m:d h-i-s"), 0, $_SESSION['ID'], $to, 0, $date);
            $this->CLEAN = 1;
        }
        public function assign_event($title, $from, $to, $branch, $projectID){
            $this->Query("INSERT INTO `projects_data` (`projectID`, `branch`, `title`, `what`, `date`, `level`, `by`, `due`, `due2`) VALUES (%d, %s, %s, %s, %s, %d, %d, %s, %s)", $projectID, $branch, $title, 'event', date("Y:m:d h-i-s"), 0, $_SESSION['ID'], $from, $to);
        }
    }
    class Manager extends Supervisor{
        public function confirm_suggest($id){
            $this->Query("UPDATE `projects_data` SET `suggest` = %d WHERE `id` = %d", 0, $id);
            return 'worked';
        }
        public function deny_suggest($id){
            $this->Query("DELETE FROM `projects_data` WHERE `id` = %d", $id);
        }
        public function change_workspace_info($projectID, $title, $description, $category){
            $this->Query("UPDATE `projects` SET `name` = %s, `description` = %s, `category` = %s WHERE `id` = %d", $title, $description, $category, $projectID);
        }
        public function manage_branch_action($projectID, $factor, $data, $dataSecond){
            if($data != 'Master'){
                switch($factor){
                    case 'create-branch':
                        $result = $this->Query("SELECT `person`, `creator` FROM `projects_invited` WHERE `projectID` = %d AND `accepted` = %d", $projectID, 1);
                        while($row = mysql_fetch_assoc($result)){
                            $privilege = ($row['person'] == $row['creator']) ? 0 : 4;
                            $this->Query("INSERT INTO `projects_data` (`projectID`, `branch`, `title`, `privilege`, `what`, `date`, `by`, `to`) VALUES (%d, %s, %s, %d, %s, %s, %d, %d)", $projectID, $data, $data, $privilege, 'branch', date("Y:m:d h-i-s A"), $_SESSION['ID'], $row['person']);
                        }
                        break;
                    case 'rename-branch':
                        $this->Query("UPDATE `projects_data` SET `title` = %s, `branch` = %s WHERE (`what` = %s AND `title` = %s AND `projectID` = %d) AND (`branch` = %s)", $dataSecond, $dataSecond, 'branch', $data, $projectID, $data);
                        break;
                    case 'delete-branch':
                        $this->Query("DELETE FROM `projects_data` WHERE (`what` = %s AND `title` = %s AND `projectID` = %d) AND (`branch` = %s)", 'branch', $data, $projectID, $data);
                        break;
                }
            }
        }
        public function post_new_update($title, $desc, $select, $branch, $projectID){
            $this->Query("INSERT INTO `projects_data` (`projectID`, `branch`, `title`, `what`, `date`, `body`, `level`, `by`) VALUES (%d, %s, %s, %s, %s, %s, %d, %d)", $projectID, $branch, $title, 'update', date("Y:m:d h-i-s"), $desc, $select, $_SESSION['ID']);
        }
    }
    class Creator extends Manager{
        public function can_join($projectID, $person, $bool = TRUE){
            if($bool == FALSE) $this->Query("DELETE FROM `projects_invited` WHERE `person` = %d AND `projectID` = %d", $person, $projectID);
            else{
                $this->Query("UPDATE `projects_data` SET `accepted` = %d WHERE `projectID` = %d AND `person` = %d", 1, $projectID, $person);
                $result = $this->Query("SELECT `title` FROM `projects_data` WHERE `projectID` = %d AND `what` = %s", $projectID, 'branch');
                while($row = mysql_fetch_assoc($result)){
                    $this->Query("INSERT INTO `projects_data` (`projectID`, `what`, `title`, `to`, `level`, `privilege`, `branch`) VALUES (%d, %s, %s, %d, %d, %d, %s) ", $projectID, 'branch', $row['title'], $person, 0, 4, $row['title']);
                }
            }
        }
        public function remove_member($projectID, $person){
            $this->can_join($projectID, $person, FALSE); 
            $this->Query("DELETE FROM `projects_data` WHERE `what` = %s AND `projectID` = %d AND `to` = %d", 'message', $projectID, $person);
        }
        public function launch_workspace($as, $projectID){
            $this->Query("UPDATE `projects` SET `launched` = %d WHERE `id` = %d", $as, $projectID);
        }
        public function delete_workspace($projectID){
            $this->Query("DELETE FROM `projects` WHERE `id` = %d", $projectID);
            $this->Query("DELETE FROM `projects_invited` WHERE `projectID` = %d", $projectID);
            $this->Query("DELETE FROM `projects_data` WHERE `projectID` = %d", $projectID);
        }
        public function change_privilege($projectID, $branch, $user, $privilege){
            $this->Query("UPDATE `projects_data` SET `privilege` = %d WHERE `projectID` = %d AND `branch` = %s AND `user` = %d", $privilege, $projectID, $branch, $user);
        }
        public function pass_lead($who, $projectID){
            $this->Query("UPDATE `projects_invited` SET `privilege` = %d WHERE `person` = %d AND `projectID` = %d", 1, $_SESSION['ID'], $projectID);
            $this->Query("UPDATE `projects_invited` SET `privilege` = %d WHERE `person` = %d AND `projectID` = %d", 0, $who, $projectID);
        }
        public function clear_suggestions($projectID, $branch){
            $this->Query("DELETE FROM `projects_data` WHERE `suggest` = %d AND `projectID` = %d AND `branch` = %s AND `what` != %s", 1, $projectID, $branch, 'branch');
        }
    }