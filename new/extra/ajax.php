<?php
//////////////////////////
//  relax@infinity-forum.org
//  some ajax things
//
//  Error codes
//  [error]{0}      :       unsupported action
//  [error]{1}      :       missing or missformated POST data
//  [error]{2}      :       Nothing found
//////////////////////////
define("INFINITY",true);

include_once("../libs/relax.php"); //import setting and classes
    if (isset($_POST['action'])) { // check that action is set 
        switch($_POST['action']) {
            case "getNews":
                if (!isset($_POST['id']) || !preg_match('/([0-9])*/', $_POST['id']))
                    die("[error]{1}"); // error
                $sql = new SQL();
                $result = $sql->Query("SELECT * FROM news WHERE id= %d ",$_POST['id']);
                if (mysql_num_rows($result)==1)
                    echo json_encode(mysql_fetch_row($result));
                else
                    die("[error]{2}"); //nothing found
                break;
			case "getAbout":
                if (!isset($_POST['id']) || !preg_match('/([0-9])*/', $_POST['id']))
                    die("[error]{1}"); // error
                $sql = new SQL();
                $result = $sql->Query("SELECT * FROM about WHERE id= %d ",$_POST['id']);
                if (mysql_num_rows($result)==1)
                    echo json_encode(mysql_fetch_row($result));
                else
                    die("[error]{2}"); //nothing found
                break;
            default:
                die("[error]{0}"); // error
        
        }
    } else die("[error]{0}"); // error
?>