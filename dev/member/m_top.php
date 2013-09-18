<?php 

include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml", id="html">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
      <title>Infinity - cycle of knowledge</title>
        <?php
            include_once($_SERVER['DOCUMENT_ROOT']."/libs/loading.php");
        ?>


      <link rel="shortcut icon" href="/favicon.ico" />
      <link rel="stylesheet" type="text/css" href="/css/dark.css" /> 
      <link rel="stylesheet" type="text/css" href="/css/member.css" /> 
      <link rel="stylesheet" type="text/css" href="/css/forum.css" /> 
      <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
      <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
      <script src="/js/infinity.js" type="text/javascript"></script>
      <script src="/js/member.js" type="text/javascript"></script>

      <script type="text/javascript">
            function changeStatus(status, title){
                $(".status2").attr("src", status);
                $(".status2").attr("title", title);
            }       

        setInterval(function()
        { 
            $.ajax({
              type:"post",
              url:"/member/pm/ajax/script.php",
              data: { "action" : "check_new"},
              success:function(data)
              {
                  //alert(data);
                  if (data == "no") {
                      $(".mail_icon").attr('src',"/member/images/m.png");
                  } else if (data == "new") {
                      $(".mail_icon").attr('src',"/member/images/m.gif");
                      MsgBox("New!", "You have a new PM");
                  } else if (data == "ignore") {
                      $(".mail_icon").attr('src',"/member/images/m.gif");
                  }
              }
            });
        }, 10000);
      </script>
      <style type="text/css">
          .status {
              margin-bottom:6px;
              display:none;
          }
      </style>
      <!--[if gte IE 9]>
      <style type="text/css">
        .gradient {filter: none;}
      </style>
      <![endif]-->
    </head>
    <body>

        <div id="mem_top">
            <div id="mem_top_left"><a href="javascript:bookmarkadd()"><img border=0 src="/member/images/b+.png"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/">Infinity-forum.org</a></div><div id="mem_top_left2"><img style="cursor:pointer;" src="/member/images/donate.png" class="donate_btn" id="i"/></div> 
            <div id="mem_top_right"><?php
        // Basically, the really long and stupid thing ahead means... am I fucking logged in, or just regularly logged 
    if(isset($_SESSION["IP"]) && $_SESSION["IP"] == getRealIp() && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == "YES" && isset($_SESSION["data"]) &&  $_SESSION["data"] == $_SERVER["HTTP_USER_AGENT"]) {
       /*COMMENTING OUT FOR NOW, WILL ONLY BE OPTIONS FOR VIP+ :D
        echo '<div id="firststatus" style="position:relative;top:8px;left:87%;cursor:pointer;"><a><img class="status" src="/member/images/online.png" title="Online" onmouseover="$(\'#menu\').fadeToggle(\'slow\');" style="height:18.5px;"></a></div>';
        echo '<div id="menu" style="display:none;">';
        echo '<div style="position:absolute;top:6px;left:85.5%;cursor:pointer;" onclick="changeStatus(\'/member/images/online.png\',\'Online\')"><a><img class="status" src="/member/images/online.png" title="Online" onclick="$(\'#menu\').fadeToggle(\'slow\');"></a></div>';
        echo '<div style="position:absolute;top:6px;left:84.5%;cursor:pointer;" onclick="changeStatus(\'/images/reddot.png\',\'Busy\')"><a><img class="status" src="/images/reddot.png" title="Busy" onclick="$(\'#menu\').fadeToggle(\'slow\');" style="height:15.5px;width:12px;"></a></div>';
        echo '<div style="position:absolute;top:6px;left:83.5%;cursor:pointer;" onclick="changeStatus(\'/images/yellowdot.png\',\'Away\')"><a><img class="status" src="/images/yellowdot.png" title="Away" onclick="$(\'#menu\').fadeToggle(\'slow\');"></a></div>';
        echo '<div style="position:absolute;top:6px;left:82.5%;cursor:pointer;" onclick="changeStatus(\'/member/images/offline.png\',\'Invisible\')"><a><img class="status" src="/member/images/offline.png" title="Invisible" onclick="$(\'#menu\').fadeToggle(\'slow\');"></a></div>';
        
        echo '<div style="position:absolute;top:6px;margin-left:120px;cursor:pointer;" onclick="changeStatus(\'/member/images/youdont.png\',\'You Dont Say!?\')"><a><img class="status" src="/member/images/youdont.png" title="You Don\'t Say!? " onclick="$(\'#menu\').fadeToggle(\'slow\');"></a></div>';
        echo '<div style="position:absolute;top:6px;margin-left:133.5px;cursor:pointer;" onclick="changeStatus(\'/member/images/troll.png\',\'Troll\')"><a><img class="status" src="/member/images/troll.png" title="Troll" onclick="$(\'#menu\').fadeToggle(\'slow\');"></a></div>';
        echo '<div style="position:absolute;top:6px;margin-left:150.5px;cursor:pointer;" onclick="changeStatus(\'/member/images/rawr.png\',\'Troll\')"><a><img class="status" src="/member/images/rawr.png" title="RAWR!!!" onclick="$(\'#menu\').fadeToggle(\'slow\');"></a></div>';
        
        echo '</div>';*/
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
        echo '<a id="online"><img class="status" src="/member/images/online.png" title="Online" onclick="changeStatus(\'/member/images/online.png\',\'Online\'); $(\'.status\').fadeToggle(\'slow\');">&nbsp;</a>';
        echo '<a id="busy"><img class="status" src="/images/reddot.png" title="Busy" onclick="changeStatus(\'/images/reddot.png\',\'Busy\'); $(\'.status\').fadeToggle(\'slow\');">&nbsp;</a>';
        echo '<a id="away"><img class="status" src="/images/yellowdot.png" title="Away" onclick="changeStatus(\'/images/yellowdot.png\',\'Away\');$(\'.status\').fadeToggle(\'slow\');">&nbsp;</a>';
        echo '<a id="offline"><img class="status" src="/member/images/offline.png" title="Invisible" onclick="changeStatus(\'/member/images/offline.png\',\'Invisible\');$(\'.status\').fadeToggle(\'slow\');">&nbsp;</a>';
        echo '<img class="status2" style=\"position:relative;margin-bottom:6px;height:18.5px;\" src="/member/images/'.$status.'.png" title="Online" onmouseover="$(\'.status\').fadeToggle(\'slow\');"></a>';
        

        
    }
    echo ($_SESSION['admin']==1) ? "<a href=\"/member/admin.php\" border=\"0\"><img id=\"i\" style=\"position:relative;height:20px;width:28px;margin-bottom:6px;\" src=\"/images/trollking.png\"></a>" : ""; ?><?php echo checkmail(); ?><img src="/member/images/c.png" style="cursor:pointer;" title="Chat" border=0 id="i"/><a href="/accsettings.php" border="0"><img src="/member/images/s.png" style="cursor:pointer;" title="Settings" border=0 id="i" /></a><img src="/member/images/h.png" style="cursor:pointer;" title="Help" border=0 id="i" /><a href="logout.php" border="0"><img src="/member/images/q.png" title="Logout" border=0 id="i" /></a></div>
            <div id="mem_top_middle">
                <div id="mem_top_middle_icons">
                    <a href="/member/"><img src="/member/images/2.png" id="mem_top_middle_icon" onmouseover="lol(this);" onmouseout="lol(this, 'h');"/></a>
                    <a href="/member/forum/"><img src="/member/images/5.png" id="mem_top_middle_icon" onmouseover="lol(this);" onmouseout="lol(this, 'h');"/></a>
                    <a href="?projects"><img src="/member/images/3.png" id="mem_top_middle_icon" onmouseover="lol(this);" onmouseout="lol(this, 'h');"/></a>
                    <a href="?freelancing"><img src="/member/images/1.png" id="mem_top_middle_icon" onmouseover="lol(this);" onmouseout="lol(this, 'h');"/></a>
                </div>
            </div>
        </div>
        
        <script type="text/javascript">
    $('#offline').click(function(){
        $.post("/libs/script.php", {status: "offline"}, function (){
            
        });
    });
    $('#busy').click(function(){
        $.post("/libs/script.php", {status: "busy"}, function (){
            
        });
    });
    $('#away').click(function(){
        $.post("/libs/script.php", {status: "away"}, function (){
            
        });
    });
    $('#online').click(function(){
        $.post("/libs/script.php", {status: "online"}, function (){
            
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
        $.post("/libs/script.php", {status: "away"});
    }
    </script>