<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
mysql_select_db(SQL_DB)or die(mysql_error());
function create($title, $desc){
    $title = mysql_real_escape_string(htmlspecialchars($title));
    $desc = mysql_real_escape_string(htmlspecialchars($desc));
    $result = mysql_query("INSERT INTO categories(`cat`, `description`, `creator`) VALUES ('".$title."', '".$desc."', '".$_SESSION['ID']."')")or die(mysql_error());
    if($result){
        return "succes";
    }else{
        return "error";
    }
}
function delete($cat){
    $cat = mysql_real_escape_string(htmlspecialchars($cat));
    $result = mysql_query("DELETE FROM categories WHERE cat = '".$cat."'")or die(mysql_error());
    if($result){
        return "succes";
    }else{
        return "error";
    }
}
function search($cat){
    $cat = mysql_real_escape_string(htmlspecialchars($cat));
    $result = mysql_query("SELECT * FROM categories WHERE cat = '".$cat."' OR cat LIKE '%".$cat."%'")or die(mysql_error());
    if($result){
        while($row = mysql_fetch_array($result)){
            $cats = $row['cat'];
        }
        if(isset($cats) && !empty($cats)){
            return $cats;
        }else{
            return "There were no results for " . $cat;
        }
    }else{
        return "error";
    }
}
if(isset($_POST['what']) && !empty($_POST['what'])){
    switch($_POST['what']){
        case "create":
            echo create($_POST['title'], $_POST['desc']);
            break;
        case "delete":
            echo delete($_POST['category']);
            break;
        case "search":
            echo search($_POST['cat']);
            break;
        default:
            die("error");
    }
}
?>