<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
mysql_select_db(SQL_DB)or die(mysql_error());
function page($limit){
    $limit = mysql_real_escape_string(htmlspecialchars($limit));
    $oldlimit = $limit - 6;
    $result = mysql_query("SELECT * FROM projects WHERE completed = 'false' LIMIT $oldlimit, $limit")or die(mysql_error());
    if(mysql_num_rows($result) == 0) return "No results";
    $info = "";
    while(($row = mysql_fetch_array($result)) != null){
        $data = array(
        "titles" => $row['name'],
        "desc" => $row['description'],
        "short" => $row['short'],
        "creator" => id2user($row['creator'], "id2user"),
        "health" => $row['health'],
        "skills" => $row['skills'],
        "category" => $row['category'],
        "rewards" => $row['rewards'],
        "form" => $row['form'],
        "invited" => $row['invited'],
        "date" => $row['date'],
        "popular" => $row['popularity'],
        "rewards" => $row['rewards'],
        "level" => "standard",
        "slogan" => $row['slogan'],
        "risks" => $row['risks'],
        "completed" => $row['completed'],
        "end" => "end"
        );
        $info .= implode(" ", $data);
    }
    return $info;
}
if(isset($_POST['limit']) && $_POST['limit'] != 0 && $_POST['limit'] >= 6){
    echo page($_POST['limit']);
}else{
    return "Invalid request";
}
?>