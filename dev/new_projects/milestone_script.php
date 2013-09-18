<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
mysql_select_db(SQL_DB)or die(mysql_error());
function insert($usr, $date, $desc, $title, $project, $duedate){
    $date = mysql_real_escape_string(htmlspecialchars($date));
    $user = mysql_real_escape_string(htmlspecialchars($usr));
    $user = id2user($user, "user2id");
    $desc = mysql_real_escape_string(htmlspecialchars($desc));
    $title = mysql_real_escape_string(htmlspecialchars($title));
    $project = mysql_real_escape_string(htmlspecialchars($project));
    $duedate = mysql_real_escape_string(htmlspecialchars($duedate));
    $result = mysql_query("INSERT INTO milestones(`title`, `description`, `user`, `date`, `creator`, `project`, `finish`, `duedate`) VALUES ('".$title."', '".$desc."', '".$user."', '".$date."', '".$_SESSION['ID']."', '".$project."', 'no', '".$duedate."')")or die(mysql_error());
    if($result){
        return "sucess";
    }else{
        return "error";
    }
}
function calendar($date, $year, $project){
    $project = mysql_real_escape_string(htmlspecialchars($project));
    $num = cal_days_in_month(CAL_GREGORIAN, $date, $year);
    $months = array("", "January", "Febraury", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $years = array($year - 3, $year - 2, $year - 1, $year, $year + 1, $year + 2, $year + 3);
    $newdate = DateTime::createFromFormat("n", $date);
    $strdate = $newdate->format('F');
    $calendar = "<table id='months'><caption>Months</caption><tr>";
    for($i = 0; $i <= count($months); $i++){
        if($i < 13){
            $calendar .= "<td><a class='months' id='$year' name='$i'>$months[$i]</a></td></tr><tr> ";
        }
    }
    $calendar .= "</tr></table><table id='years'><caption>Years</caption>";
    for($i = 1; $i <= count($years); $i++){
        if($i < 7){
            $calendar .= "<td><a class='years' id='$date' name='$years[$i]'>$years[$i]</a></td></tr><tr> ";
        }
    }
    $calendar .= "</tr></table><table id='calendar'><caption>".$strdate. " " . $year . "<br />";
    $calendar .= "<script>
        $('document').ready(function (){
            $('.months').click(function (){
                var month = this.name;
                var year = this.id;
                var project = $project;
                change(month, year, project);
            });
            $('.years').click( function (){
                var month = this.id;
                var year = this.name;
                var project = $project;
                change(month, year, project);
            });
        });
    </script>";
    $calendar .= "</caption><tr class='headers'><th id='sun'>Sun</th><th id='mon'>Mon</th><th id='tue'>Tue</th><th id='wed'>Wed</th><th id='thu'>Thu</th><th id='fri'>Fri</th><th id='sat'>Sat</th></tr><tr>";
    for($i = 1; $i <= $num; $i++){
        $calendar .=  "<td class='day'><div class='day'><div class='day-num'>$i</div>";
        if($i/7 == intval($i/7)) $calendar .= "</td></tr><tr>";
    }
    //findMatch($date, $project);
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
    $date = mysql_real_escape_string(htmlspecialchars($date));
    $project = mysql_real_escape_string(htmlspecialchars($project));
    $result = mysql_query("SELECT * FROM milestones WHERE date = '".$date."' AND project = '".$project."'")or die(mysql_error());
    while($row = mysql_fetch_array($result)){
        $title = $row['title'];
        $user = $row['user'];
        $task = $row['description'];
        $finish = $row['finish'];
        $id = $row['id'];
    }
    if(isset($user) && isset($task) && !empty($user) && !empty($task) && isset($title) && !empty($title)){
        $arr = array($title, id2user($user, "id2user"), $task, $finish, $id);
        return json_encode($arr);
    }else{
        return "There are no milestones for this date.";
    }
}
function delete($id){
    $id = mysql_real_escape_string(htmlspecialchars($id));
    $result = mysql_query("DELETE FROM milestones WHERE id = '".$id."'")or die(mysql_error());
    if($result){
        return "succes";
    }else{
        return "error";
    }
}
function finish($id){
    $id = mysql_real_escape_string(htmlspecialchars($id));
    $result = mysql_query("UPDATE milestones SET finish = 'yes' WHERE id = '".$id."'")or die(mysql_error());
    if($result){
        return "sucess";
    }else{
        return "error";
    }
}
function update($title, $desc, $user, $id){
    $title = mysql_real_escape_string(htmlspecialchars($title));
    $desc = mysql_real_escape_string(htmlspecialchars($desc));
    $user = mysql_real_escape_string(htmlspecialchars($user));
    $user = id2user($user, "user2id");
    $id = mysql_real_escape_string(htmlspecialchars($id));
    $result = mysql_query("UPDATE milestones SET title = '".$title."', description = '".$desc."', user = '".$user."' WHERE id = '".$id."'")or die(mysql_error());
    if($result){
        return "succes";
    }else{
        return "error";
    }
}
function getInfo($id){
    $id = mysql_real_escape_string(htmlspecialchars($id));
    $result = mysql_query("SELECT * FROM milestones WHERE id = '".$id."'")or die(mysql_error());
    if($result){
        while($row = mysql_fetch_array($result)){
            $title = $row['title'];
            $desc = $row['description'];
            $user = $row['user'];
        }
        if(isset($title) && !empty($title) && isset($desc) && !empty($desc) && isset($user) && !empty($user)){
            $arr = array($title, $desc, id2user($user, "id2user"));
            return json_encode($arr);
        }else{
            return "nothing returned";
        }
    }else{
        return "bad query";
    }
}
function findMatch($date, $project){
    $project = mysql_real_escape_string(htmlspecialchars($project));
    $date = mysql_real_escape_string(htmlspecialchars($date));
    $result = mysql_query("SELECT * FROM milestones WHERE project = '".$project."'")or die(mysql_error());
    while($row = mysql_fetch_array($result)){
        $dates = $row['date'];
    }
}
if(isset($_POST['user']) && isset($_POST['date']) && isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['project']) && isset($_POST['duedate'])){
    echo insert($_POST['user'], $_POST['date'], $_POST['desc'], $_POST['title'], $_POST['project'], $_POST['duedate']);
}else if(isset($_POST['calendar']) && isset($_POST['month']) && isset($_POST['year']) && is_numeric($_POST['month']) && is_numeric($_POST['year']) && isset($_POST['project'])){
    echo calendar($_POST['month'], $_POST['year'], $_POST['project']);
}else if(isset($_POST['get']) && $_POST['get'] == "data" && isset($_POST['date']) && isset($_POST['project'])){
   echo getData($_POST['date'], $_POST['project']);
}else if(isset($_POST['what']) && $_POST['what'] == "delete" && isset($_POST['id']) && is_numeric($_POST['id'])){
    echo delete($_POST['id']);
}else if(isset($_POST['what']) && $_POST['what'] == "finish" && isset($_POST['id']) && is_numeric($_POST['id'])){
    echo finish($_POST['id']);
}else if(isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['user']) && isset($_POST['id']) && isset($_POST['what']) && $_POST['what'] == "update"){
    echo update($_POST['title'], $_POST['desc'], $_POST['user'], $_POST['id']);
}else if(isset($_POST['what']) && $_POST['what'] == "getInfo" && isset($_POST['id']) && is_numeric($_POST['id'])){
    echo getInfo($_POST['id']);
}else{
    die("error");
}
?>