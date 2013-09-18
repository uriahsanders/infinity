<!DOCTYPE html>
<?php
    $token = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
    $_SESSION['token'] = $token;
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    include_once('test_framework.php');
    include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/loading.php'); //temp
?>
<html>
    <head>
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="tour.js"></script>
        <script type="text/javascript" src="test.js"></script>
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/dark-hive/jquery-ui.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="test.css" />
        <title>Infinity Workspace</title>
    </head>
    <body>
        <div id="top">
           <ul id="top_opt">
               <li id="project">
                   <select id="project_select" class="fly0">
                       <?php echo Person::project_select(); ?>
                    </select>
               </li>
               <li id="branch">
               </li>
               <li id="my_place"></li>
               <li style="line-height: 25px;"><select id="quick_add"></select></li>
               <li style="line-height: 25px;"><select id="action_select"></select></li>
           </ul>
           <ul id="top_opt"style="float:right;">
               <li>
               <a target="_blank"id="rss_link"style="line-height: 25px;"href="">RSS</a>
               </li>
               <li style="line-height: 25px;"><a target="_blank"href="/help#workspace" id="help">Help</a></li>
               <li style="line-height: 25px;"><a href="/lounge">Lounge</a></li>
               <li style="line-height: 25px;"><a>Logout</a></li>
               <li> </li>
           </ul>
        </div> 
        <br /><br /><br />
        <div id="logo"></div>
        <br /><br /><br /><br /><br />
        <div id="side">
            <div id="navigation">
                <ul>
                    <li><input id="searchbar"placeholder="Search this branch..."autofocus /></li>
                    <li class="Start">Start</li>
                    <li class="Stream">Stream</li>
                    <li class="Wall">Wall</li>
                    <li class="Control">Control Panel</li>
                    <li class="Updates">Updates</li>
                    <li class="Groups">Groups</li>
                    <li class="Tasks">Tasks</li>
                    <li class="Events">Events</li>
                    <li class="Boards">Boards</li>
                    <li class="Tables">Tables</li>
                    <li class="Notes">Notes</li>
                    <li class="Files">Files</li>
                    <li class="Suggest">Suggest</li>
                </ul>
            </div>
        </div>
        <div id="stats"></div>
        <br />
        <div id="content">
            <div id="head"></div>
            <div id="cms"></div>
            <div id="main"></div>
            <br />
        </div>
        <div id="loader" style="display:none;">Loading...</div>
        <input id="params" type="hidden" value=<?php  
           $return = (count($_GET) > 0) ? NULL : 0;
           foreach($_GET as $key => $value){
              $return .= $key."=>".$value;
              break;
           }
           echo "\"".$return."\"";
        ?>/>
        <input type="hidden" id="token" value=<?php echo "\"".$_SESSION['token']."\""; ?>/>
    </body>
</html>
