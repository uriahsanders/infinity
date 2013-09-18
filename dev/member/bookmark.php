<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/member/check_auth.php');

$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());

$user = $_SESSION['ID'];
$url = $_SERVER['HTTP_REFERER'];
$desc = cleanQuery($_POST['desc']);
if(isset($url) && $url != ""){

        if(preg_match('/http(s)?\:\/\/(www\.|dev\.)?infinity-forum\.org\/(.)*\/?/', $url)){
            $url = cleanQuery($url);
            $check = mysql_query("SELECT * FROM bookmarks WHERE `url` = '".$url."' AND `user` = '".$user."'")or die(mysql_error());
            $num = mysql_num_rows($check);
            if($num >= 1){
                echo "Youve already bookmarked that url.";
            }else{
                $insert = mysql_query("INSERT INTO bookmarks(`url`, `user`, `desc`) VALUES ('".$url."', '".$user."', '".$desc."')")or die(mysql_error());
                if($insert){
                    header("Location: " . $url);
                }else{
                    echo "Couldnt insert it into the database.";
                }
            }
        }else{
            echo "That url does not belong to infinity-forum.org";
        }
}


?>