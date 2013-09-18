<?php
include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");
$con = SQL_connect();
$db = SQL_selectDB($con);
if (isset($_POST['action']) && $_POST['action'] == "fetch_inbox") {

    $data = mysql_query("SELECT * FROM messages WHERE `to`='$_SESSION[ID]' ORDER BY `date` DESC") or die(mysql_error());
    $result = array();
    while($row = mysql_fetch_array($data)) {
        $tmp = array();
        array_push($tmp, $row['isread'],$row['subject'],$row['body'],id2user($row['sentby']),time_diff($row['date']),$row['ID'],$row['sentby']);        
        array_push($result, $tmp);    
    }
    echo json_encode($result);
} else if (isset($_POST['action']) && $_POST['action'] == "isread" && isset($_POST['id']) && preg_match('/([0-9])*/', $_POST['id'])) {
    $data = mysql_query("UPDATE messages SET `isread` = '1' WHERE `ID`='$_POST[id]'") or die(mysql_error());
} else if (isset($_POST['action']) && $_POST['action'] == "fetch_sent") {
    echo "get the sent items";
} else if (isset($_POST['q'])) {
    $q = mysql_real_escape_string($_POST["q"]);
    $rs = mysql_query("SELECT ID, username, screenname,image from memberinfo WHERE username LIKE '%".$q."%' or screenname LIKE '%".$q."%' ORDER BY last_login DESC LIMIT 10");
    $arr = array();
    while($obj = mysql_fetch_object($rs)) {
        $arr[] = $obj;
    }
    $json_response = json_encode($arr);
    echo $json_response;
} else if (isset($_POST['action']) && $_POST['action'] == "send"){
    $err = 0;
    if (!isset($_POST['to']) || !preg_match('/([0-9],)*/', $_POST['to'])) {
        echo "error with recipient<br />"; $err++;}
    if (!isset($_POST['sub'])) {
        echo "error with subject<br/>"; $err++;}
    if (!isset($_POST['txt'])) {
        echo "error with message<br/>"; $err++;}
    if (!isset($_SESSION['ID'])) {
        echo "you need to be logged <br/>in to send a message<br/>"; $err++;}
    if ($err==0) {
            $to = cleanQuery($_POST['to']);
            $sub = cleanQuery($_POST['sub'], true);
            while (preg_match('~<br />~',$sub)) {
                $sub = preg_replace('~<br />~', " ", $sub);
            }
            $txt = cleanQuery($_POST['txt'], true);
            
            $group = explode(",",$to);
            foreach($group as $to2) {
                $result = mysql_query("INSERT INTO messages(`to`,`subject`,`body`,`sentby`,`date`) VALUES ('$to2','$sub','$txt','$_SESSION[ID]', NOW())") or die(mysql_error());
            }
            echo "Your message has been sent";
    
    }
} else if (isset($_POST['action']) && $_POST['action'] == "check_new") {
    $res = mysql_query("SELECT ID FROM messages WHERE `to`='$_SESSION[ID]' AND `isread`='0'")or die(mysql_error());
    $arr = array();
    $nr = mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
        array_push($arr, $row['ID']);   
    }
    if ($nr == 0) {
        echo "no";
    } else if (isset($_SESSION['PM']) && $_SESSION['PM'] == implode(",",$arr)) {
        echo "ignore";
    } else {
        if (isset($_SESSION['PM'])) {
            $ch = false;
            $old = explode(",",$_SESSION['PM']);
            foreach($arr as $idd) {
                if(!in_array($idd, $old)) {
                    $ch = true;
                }
            }
            if ($ch == true) {
                echo "new";
                $_SESSION['PM'] = implode(",",$arr);
            } else {
                echo "ignore";        
                $_SESSION['PM'] = implode(",",$arr);   
            }
        } else {
            echo "new";
            $_SESSION['PM'] = implode(",",$arr);
        }
    }
} else if (isset($_POST['action']) && $_POST['action'] == "del" && preg_match('/([0-9]*)/', $_POST['id'])) {
    $r = mysql_query("DELETE FROM messages WHERE `id`='$_POST[id]' and `to`='$_SESSION[ID]'")or die(mysql_error());
    if ($r) {echo "done";}else{echo "error";}
}
mysql_close($con);
?>