<?php
global $messagelimit;
$messagelimit = 8;
global $rank;
$rank_steps = array("Banned","Member","Trusted","VIP","MOD","GMOD","Admin");
include_once($_SERVER['DOCUMENT_ROOT']."/libs/relax_clean_lib.php");

 
/*
if(strlen(session_id()) < 1)
{
    sec_session_start();
}
function sec_session_start() {
        $session_name = 'infinity_session';
        ini_set('session.use_only_cookies', 1);
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params("1209600", "/", ".infinity-forum.org", false, true); 
        session_name($session_name);
        session_start();
         session_regenerate_id(true);  
} COMMENTED OUT BECAUSE PHP.INI IS CONFIGURED TO START HTTPONLY COOKIES*/
function karma($id) {
    $con_karma = SQL_connect();
    SQL_selectDB($con_karma);
    $id = cleanQuery($id);
    $p = mysql_query("SELECT ID FROM karma WHERE `2`='$id' AND `pm`='p'") or die(mysql_error());
    $m = mysql_query("SELECT ID FROM karma WHERE `2`='$id' AND `pm`='m'") or die(mysql_error());
    mysql_close($con_karma);
    return array("p" => mysql_num_rows($p), "m" => mysql_num_rows($m));
}
function checkmail() {
    $newmail = "<a href=\"/member/pm/\"><img src=\"/member/images/m.gif\" class=\"mail_icon\" style=\"cursor:pointer;\" title=\"Mail\" border=0 id=\"i\"/></a>";
    $nomail = "<a href=\"/member/pm/\"><img src=\"/member/images/m.png\" class=\"mail_icon\" style=\"cursor:pointer;\" title=\"Mail\" border=0 id=\"i\"/></a>";
    $con = SQL_connect();
    $db = SQL_selectDB($con);
    $res = mysql_query("SELECT ID FROM messages WHERE `to`='$_SESSION[ID]' AND `isread`='0'")or die(mysql_error());
    $nr = mysql_num_rows($res);
    if ($nr != 0)
        return $newmail;
    else
        return $nomail;
}
function lastactiv($id) {
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    $id = cleanQuery($id."");
        $result = mysql_query("SELECT `subject`,`date`,`child_to_t` FROM forum WHERE `by`=".$id." ORDER BY date DESC LIMIT 0,10") or die(mysql_error());
    mysql_close($con);
    $lol = array();
    while($row = mysql_fetch_array($result)){
        array_push($lol, $row);    
    }
    return $lol;
}
function my_session_start()
    {
        if (isset($_COOKIE['PHPSESSID'])) {
            $sessid = $_COOKIE['PHPSESSID'];
        } else {
            session_start();
            return false;
        }
        
        if (!preg_match('/^[a-z0-9]{32}$/', $sessid)) {
            return false;
        }
        session_start();
        
        return true;
    }
function cleanQuery($string, $br=false)
{

    $string = htmlspecialchars($string);
    $string = ($br != false) ? str_replace("\n","<br />",$string) : $string;
    if (phpversion() >= '4.3.0') {
        $string = mysql_real_escape_string($string);
    } else {
        $string = mysql_escape_string($string);
    }

    return $string;
}
function MsgBox($msgbox_title, $msgbox_txt, $icon = 0, $msgbox_width = 300, $msgbox_height = 120, $msgbox_top = -100, $msgbox_left = 301, $msgbox_bottom = 0, $align = "r") {
    if ($msgbox_left == "c" || $msgbox_left == "cc")
        $lolz = true;
    else
        $lolz = false;
    $msgbox_top = "margin-top:". $msgbox_top ."px;"; 
    $msgbox_left = "margin-left:". $msgbox_left ."px;"; 
    $msgbox_icon_w = 50;
    switch ($icon) {
        case 1: $icon = '<img src="images/icons/_0007_Tick.png" border="0">'; break;
        case 2: $icon = '<img src="images/icons/_0006_Cross.png" border="0">'; break;
        case 3: $icon = '<img src="images/icons/_0011_Info.png" border="0">'; break;
        case 4: $icon = '<img src="images/icons/_0010_Alert.png" border="0">'; break;
        case 5: $icon = '<img src="images/icons/_0005_Delete.png" border="0">'; break;
        default: $icon = NULL; $msgbox_icon_w = 0; break;
    }
    $code = rand();
    echo '<div id="msgbox" class="msgbox-'.$code.'" style="width:'.$msgbox_width.'px; padding-bottom:6px;'.$msgbox_top.''.$msgbox_left.'">'. "\n";
    echo ' <div id="msgbox-title">'.$msgbox_title.'</div>'. "\n";
    echo '  <div id="msgbox-text" style="padding-bottom: 0; font-weight: bold; font-size: 12px;">'. "\n";
    echo '   <table id="msgbox-table" style="height: '.$msgbox_height.'px; width:'.$msgbox_width.'px;">'. "\n";
    echo '    <tr>'. "\n";
    echo '       <td valign="middle" align="center" width="'.$msgbox_icon_w.'px">'.$icon.'</td>'."\n";
    echo '     <td valign="middle" ';
    if ($align == "l")
        echo 'align="left"';
    else
        echo 'align="center"';
    echo ' height="100%">'."\n";
    echo '      '.$msgbox_txt.'<br />'. "\n";
    echo '      '. "\n";
    echo '     </td>'. "\n";
    echo '       <td valign="middle" align="center" width="'.$msgbox_icon_w.'px"></td>'."\n";
    echo '    </tr>'. "\n";
    if($msgbox_bottom == 0) {
        echo '    <tr>'. "\n";
        echo '     <td></td>'."\n";
        if($icon != NULL) {echo '     <td valign="top"><div id="msgbox-line"></div></td>'."\n";}
        echo '     <td valign="middle" align="right">'. "\n";
        if($icon == NULL) {echo '     <div id="msgbox-line"></div>'."\n";}
        echo '      <div style="margin-bottom:8px"></div><a href="#" onclick="hideC(\'msgbox-'.$code.'\');" style="font-weight: bold; padding-right: 5px; color: #000;"> Close </a></div>'. "\n";
        echo '     </td>'. "\n";
        if($icon == NULL) {echo '     <td></td>'."\n";}
        echo '    </tr>'. "\n";
    }
    echo '   </table>'. "\n";
    echo '    </div>'. "\n";
    echo '</div>'. "\n";
    if ($lolz === true) {
    echo "
    <script>
    $(document).ready(function(){
        $(\"#msgbox\").css(\"position\",\"absolute\");";
        if ($msgbox_left == "cc")
            echo "$(\"#msgbox\").css(\"top\", ( $(window).height() - $(\"#msgbox\").height() ) / 2+$(window).scrollTop() + \"px\");";
        echo "$(\"#msgbox\").css(\"left\", ( $(window).width() - $(\"#msgbox\").width() ) / 2+$(window).scrollLeft() + \"px\");
    });
    </script>
    ";
}
}

function checkdub($what, $data)
{
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    
    if ($what == "email") {
        $result = mysql_query("SELECT email FROM members WHERE email='" . cleanQuery(strtolower($data)) . "'") or die(mysql_error());
    } else if ($what == "username") {
        $result = mysql_query("SELECT username FROM members WHERE username='" . cleanQuery(strtolower($data)) . "'") or die(mysql_error());
    } else {
        mysql_close($con);
        die('Sorry that is not allowed');
    }
    mysql_close($con);
    return mysql_num_rows($result);
    
}
function id2user($id, $woot = "id2user")
{
    $con2 = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    $db2 = mysql_select_db(SQL_DB) or die(mysql_error());
    $id = cleanQuery($id);
    if ($woot == "id2user")
        $result2 = mysql_query("SELECT username FROM memberinfo WHERE ID='$id'") or die(mysql_error());
    if ($woot == "id2screen")
        $result2 = mysql_query("SELECT screenname FROM memberinfo WHERE ID='$id'") or die(mysql_error());
    if ($woot == "user2id")
        $result2 = mysql_query("SELECT ID FROM memberinfo WHERE username='$id'") or die(mysql_error());
    if ($woot == "screen2id")
        $result2 = mysql_query("SELECT ID FROM memberinfo WHERE screenname='$id'") or die(mysql_error());
    if ($woot == "screen2user")
        $result2 = mysql_query("SELECT username FROM memberinfo WHERE screenname='$id'") or die(mysql_error());
    if ($woot == "user2screen")
        $result2 = mysql_query("SELECT screenname FROM memberinfo WHERE username='$id'") or die(mysql_error());
    
    $row2 = mysql_fetch_array($result2);
    //mysql_close($con2);
     if ($woot == "id2user")
        return $row2['username'];
    if ($woot == "id2screen")
        return $row2['screenname'];
    if ($woot == "user2id")
        return $row2['ID'];
    if ($woot == "screen2id")
        return $row2['ID'];
    if ($woot == "screen2user")
        return $row2['username'];
    if ($woot == "user2screen")
        return $row2['screenname'];
}
function time_diff($t2) {
    $t1 = time();
    $t2 = strtotime($t2);
    $diff = $t1 - $t2;
    $m = 60; $h = $m * 60; $d = $h * 24; $w = $d * 7;
    if ($diff < $h) {
        $diff = intval($diff / $m);
        $time = $diff . (($diff == 1) ? " minute" : " minutes") . " ago";
    } else if ($diff < $d && $diff >= $h) {
        $diff = intval($diff / $h);
        $time = $diff . (($diff == 1) ? " hour" : " hours") . " ago";
    } else if ($diff >= $d && $diff < $w) {
        $time = date("D g:i a", $t2);
    } else if ($diff >= $w) {
        $time = date("jS M g:i a",$t2);
    }
    return $time;
}
function tooltip($name = "name", $link = "#",$text ="text",$title = "title", $type = "classic"){
    $code  = "<a class=\"tooltip\" href=\"$link\">";
    $code .= $name;//
    $code .= "<span class=\"";
    if (preg_match('/(critical|help|info|warning)/',$type)) {
        $type = array("custom " . $type, $type . ".png");
    } else
        $type = array("classic","");
    $code .= $type[0];
    $code .= "\">";
    $code .= ($type[0] != "classic") ? "<img src=\"/images/".$type[1]."\" alt=\"".$name."\" height=\"30\" width=\"30\" />" : "";
    $code .= "<em>";
    $code .= $title;
    $code .= "</em>";
    $code .= $text;
    $code .= "</span></a>";
    return $code;
}
function SQL_connect()
{
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());

    return $con;
}
function SQL_selectDB($conn)
{
    $db = mysql_select_db(SQL_DB, $conn) or die(mysql_error());
    return $db;
}
function SQL_disconnect($conn)
{
    mysql_close($conn);
}

function checklogin($usr, $pwd)
{
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    $usr = cleanQuery($usr);
    $pwd = md5(md5("infinity-") . md5(cleanQuery($pwd)) . md5("-46258"));
    $result = mysql_query("SELECT username,password,activatecode,admin,ID FROM members WHERE username='" . $usr . "' AND password='" . $pwd . "'") or die(mysql_error());
    $row = mysql_fetch_array($result);
    mysql_close($con);
    if (mysql_num_rows($result) == 1) {
        if (!preg_match('/^(Y-).*$/', $row['activatecode'])) {
            return 1; // account not acctivated
        } else if ($row['admin'] == 1) {
            return 3; //is Admin
        } else {
            return 2; //is standard user
        }
    } else {
        return 0; // wrong password or username or dossent exist
    }
}
function last_login_update($ID)
{
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    $ID = cleanQuery($ID);
    $result = mysql_query("UPDATE memberinfo SET last_login='".date("Y-m-d H:i:s")."' WHERE ID=".$ID) or die(mysql_error());
}



function getUsrInfo($optUsr, $optPwd)
{
    
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    
    $usr = cleanQuery($optUsr);
    $pwd = md5(md5("infinity-") . md5(cleanQuery($optPwd)) . md5("-46258"));
    
    $result = mysql_query("SELECT ID,admin,username,email,(SELECT `screenname` FROM memberinfo WHERE members.ID=memberinfo.ID) AS `screenname`,(SELECT `image` FROM memberinfo WHERE memberinfo.username = '".$usr."') AS `usr_img` FROM members WHERE username='" . $usr . "' AND password='" . $pwd . "'") or die(mysql_error());
    $row = mysql_fetch_array($result);
    mysql_close($con);
    
    if (mysql_num_rows($result) == 1) {
        return $row;
    } else {
        return 0; // dident find anything
    }
}
function getUsrName($ID)
{
    return id2user($ID, "id2user");
}
function logg_act() {
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    $arra = array();
    foreach($_SESSION as $key => $value) {
            if (is_array($value)){
                foreach($value as $key2 => $value2) {
                    array_push($arra, $key2." = ".$value2);
                }
            } else {
                 array_push($arra, $key ." = ".$value);
            }
    }
    $session = implode(",",$arra);
    $data = "POST: " . implode(",",$_POST) . "GET: " . implode(",", $_GET);
    mysql_query("INSERT INTO suspicious_activity (`IP`, `data`, `session`, `date`) VALUES ('".getRealIp()."', '".$data."','".$session."', NOW())") or die(mysql_error());
    mysql_close($con);
}

function getThreadInfo($ID,$bid, $woot)
{
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    
    $ID = cleanQuery($ID);
    $bid = cleanQuery($bid);
    $woot = cleanQuery($woot);
    if ($woot == "r")
        $result = mysql_query("SELECT child_to_b, child_to_t FROM forum WHERE child_to_b=".$bid." AND child_to_t=".$ID) or die(mysql_error());
    if ($woot == "v")
        $result = mysql_query("SELECT child_to_b, views, ID FROM forum WHERE child_to_b=".$bid." AND ID=".$ID) or die(mysql_error());
    if ($woot == "lp")
        $result = mysql_query("SELECT * FROM forum WHERE child_to_b=".$bid." AND (ID=".$ID." OR child_to_t=".$ID.") ORDER BY date DESC") or die(mysql_error());
    if ($woot == "re")
        $result = mysql_query("SELECT * FROM forum WHERE child_to_b=".$bid." AND child_to_t=".$ID." AND `by`='".$_SESSION['ID']."'") or die(mysql_error());
    
    $row = mysql_fetch_array($result);
    mysql_close($con);
    if ($woot == "r")
        return mysql_num_rows($result);
    if ($woot == "re")
        return mysql_num_rows($result);
    if ($woot == "v")
        return $row['views'];
    if ($woot == "lp") {
        return array(getUsrName($row['by']), date('D M j, Y h:i a', strtotime($row['date'])), $row['ID']);
    }
    
}


function cryptAES($data, $way) {
    $encryptionMethod = "AES-256-CBC";  // AES is used by the U.S. gov't to encrypt top secret documents.
    $secretHash = "e306a8f31fcebdd7b14a8f5eca566247";
    
    if ($way == "e") {
        return openssl_encrypt($data, $encryptionMethod, $secretHash);
    } else {
        return openssl_decrypt($data, $encryptionMethod, $secretHash);
    }
}

function getRealIp() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        if (substr($ip,0,5) == "83.23")
                            return "127.0.0.rawr";
                        return $ip;
                }
            }
        }
    }
}
?>