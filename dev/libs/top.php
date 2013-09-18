<?php
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml", id="html">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
      <title>Infinity - cycle of knowledge</title>
      <link rel="shortcut icon" href="/favicon.ico" />
    
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script src="/js/calendar.js" type="text/javascript"></script>    
    <script src="/js/infinity.js" type="text/javascript"></script> 
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
        <?php /*Change Style Script, commented out until styles are done.
         include_once('/home2/infiniz7/public_html/dev/libs/lib.php');
        if(isset($_SESSION["IP"]) && $_SESSION["IP"] == getRealIp() && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == "YES" && isset($_SESSION["data"]) &&  $_SESSION["data"] == $_SERVER["HTTP_USER_AGENT"]) {
         $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
      $stylesheet = mysql_query("SELECT * FROM members WHERE username = '$_SESSION[usr]'", $con);
    while($row = mysql_fetch_array($stylesheet)){
        if($row['css'] == ""){
        echo "<link rel='stylesheet' type='text/css' href='/css/dark.css' />";
        }else{
        echo "<link rel='stylesheet' type='text/css' href='/css/".$row['css'].".css' />";
        }
    }
    mysql_close($con);
    }else{
    echo '<link rel="stylesheet" type="text/css" href="/css/dark.css" />';
    }*/
    ?>
    <link rel="stylesheet" type="text/css" href="/css/dark.css" />
      <script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
        <script>
            function changeStatus(status, title){
                $("#firststatus a img").attr("src", status);
                $("#firststatus a img").attr("title", title);
            }
        </script>
      <!--[if gte IE 9]>
      <style type="text/css">
        .gradient {filter: none;}
      </style>
      <![endif]--><!-- so we have the gradient on the buttons even on old IE browsers-->
    </head>
    <body>
    
         <?php
        // Basically, the really long and stupid thing ahead means... am I fucking logged in, or just regularly logged 
    if(isset($_SESSION["IP"]) && $_SESSION["IP"] == getRealIp() && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == "YES" && isset($_SESSION["data"]) &&  $_SESSION["data"] == $_SERVER["HTTP_USER_AGENT"]) {
        mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD)or die(mysql_error());
        mysql_select_db(SQL_DB);
        $result = mysql_query("SELECT * FROM status WHERE id = '".$_SESSION['ID']."'")or die(mysql_error());
        if(mysql_num_rows($result) == 0){
            echo "";
            $status = "online";
        }else{
            while($row = mysql_fetch_array($result)){
                $stat = $row['status'];
                if($stat == 3) $status = "online";
                else if($stat == 2) $status = "yellowdot";
                else if($stat == 1) $status = "reddot";
                else $status = "offline";
            }
        }
        echo '<div style="position:absolute;top:6px;left:7px;cursor:pointer;"><a href="javascript:bookmarkadd()"><img src="/member/images/b+.png" title="Bookmark"></a></div>';
        echo '<div id="firststatus" style="position:absolute;top:8px;margin-left:35px;cursor:pointer;"><a><img class="status" src="/member/images/'.$status.'.png" title="Online" onmouseover="$(\'#menu\').fadeToggle(\'slow\');" style="height:17px;"></a></div>';
        echo '<div id="menu" style="display:none;">';
        echo '<div style="position:absolute;top:6px;margin-left:58px;cursor:pointer;" onclick="changeStatus(\'/member/images/online.png\',\'Online\')"><a id="online"><img class="status" src="/member/images/online.png" title="Online" onclick="$(\'#menu\').fadeToggle(\'slow\');" /></a></div>';
        echo '<div style="position:absolute;top:6px;margin-left:88px;cursor:pointer;" onclick="changeStatus(\'/images/reddot.png\',\'Busy\')"><a id="busy"><img class="status" src="/images/reddot.png" title="Busy" onclick="$(\'#menu\').fadeToggle(\'slow\');" style="height:15.5px;width:12px;" /></a></div>';
        echo '<div style="position:absolute;top:6px;margin-left:73px;cursor:pointer;" onclick="changeStatus(\'/images/yellowdot.png\',\'Away\')"><a id="away"><img class="status" src="/images/yellowdot.png" title="Away" onclick="$(\'#menu\').fadeToggle(\'slow\');" /></a></div>';
        echo '<div style="position:absolute;top:6px;margin-left:103px;cursor:pointer;" onclick="changeStatus(\'/member/images/offline.png\',\'Invisible\')"><a id="offline"><img class="status" src="/member/images/offline.png" title="Invisible" onclick="$(\'#menu\').fadeToggle(\'slow\');" /></a></div>';
        /*COMMENTING OUT FOR NOW, WILL ONLY BE OPTIONS FOR VIP+ :D
        echo '<div style="position:absolute;top:6px;margin-left:120px;cursor:pointer;" onclick="changeStatus(\'/member/images/youdont.png\',\'You Dont Say!?\')"><a><img class="status" src="/member/images/youdont.png" title="You Don\'t Say!? " onclick="$(\'#menu\').fadeToggle(\'slow\');"></a></div>';
        echo '<div style="position:absolute;top:6px;margin-left:133.5px;cursor:pointer;" onclick="changeStatus(\'/member/images/troll.png\',\'Troll\')"><a><img class="status" src="/member/images/troll.png" title="Troll" onclick="$(\'#menu\').fadeToggle(\'slow\');"></a></div>';
        echo '<div style="position:absolute;top:6px;margin-left:150.5px;cursor:pointer;" onclick="changeStatus(\'/member/images/rawr.png\',\'Troll\')"><a><img class="status" src="/member/images/rawr.png" title="RAWR!!!" onclick="$(\'#menu\').fadeToggle(\'slow\');"></a></div>';
        */
        echo '</div>';
    }
    ?>
    <script type="text/javascript">
    $('#offline').click(function(){
        $.post("libs/script.php", {status: "offline"}, function (){
            
        });
    });
    $('#busy').click(function(){
        $.post("libs/script.php", {status: "busy"}, function (){
            
        });
    });
    $('#away').click(function(){
        $.post("libs/script.php", {status: "away"}, function (){
            
        });
    });
    $('#online').click(function(){
        $.post("libs/script.php", {status: "online"}, function (){
            
        });
    });
    $(document).ready(function (){
        var timer;
        $(document).mousemove(function() {
            clearTimeout(timer);
            timer = setTimeout('away();', 10 * 60 * 1000);
        });
    });
    function away(){
        $.post("libs/script.php", {status: "away"});
    }
    </script>
        
    <div id="topbar">
