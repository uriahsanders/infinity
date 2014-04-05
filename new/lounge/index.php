<?php 
    define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "lounge"); // this is what page it is, for the links at the top
    include_once("../libs/relax.php"); // use PATH from now on
	
    Login::checkAuth();
	$member = Members::getInstance();
    $projects = new Projects();
    if (isset($_GET['user']) && !empty($_GET['user']))
    {    
        $ID = $member->get($_GET['user'],"ID");
        
    }
    else 
    {
        $ID = $_SESSION['ID'];
    }
    include_once(PATH ."core/top.php");
    if(defined("PAGE") && PAGE == "start") 
    {
        include_once(PATH ."core/slide.php");
    }
    include_once(PATH ."core/bar_main_start.php");
    if (empty($ID))
        {
            $start = "<script type=\"text/javascript\">\n $(document).ready(function(){\n";
            $end   = " \n});</script>";
            echo $start . "MsgBox(\"Error\", \"The user \\\"$_GET[user]\\\" does not exist.\",3);" . $end;
            $ID = $_SESSION['ID'];
        }
    $data = $member->getUserData($ID, "ID");
    $image = $data["image"]; 
?>
<input type="hidden" value="<?php echo $ID; ?>" id="usr_id" /> 
<div id="pro_side">
    <div id="pro_user_pic">
        <?php
            if($ID == $_SESSION['ID'])
            {
                echo '<span><img src="/images/s.png" title="settings"/>';
                echo '<span><b class="user-pic-upload"id="upload">Upload</b><b id="remove">Delete</b></span>';                
                echo '</span>';
            }
        ?>
      <img src="/images/user/<?php echo $image; ?>" id="pro_profile_p"/>
      <div id="pro_user_type">
        <?php 
        if (!empty($data['special']))
        {
            echo "$data[special]";
        }
        ?></div>
    </div>
    <div id="pro_info"style="text-align:center;border-radius:0px;padding:20px">
    <?php 
      echo "<br><a style='font-size:1.4em'>Projects: <b>".$projects->numProjects($ID)."</b></a><br /><br>";
      echo "<a style='font-size:1.4em'>Posts: <b>1244</b></a><br /><br>";
      echo "<a style='font-size:1.4em'>Prestige: <b>".$data['prestige']."</a></b><br /><br>";
    ?>
    </div><br>
    <a class="fa fa-home fa-2x lounge-icon gold active"></a>&emsp;
        <a href="pm.php"class="fa fa-envelope-o fa-2x lounge-icon white"></a>&emsp;
        <a href="groups.php"class="fa fa-users fa-2x lounge-icon yellow"></a>&emsp;
        <a href="settings.php"class="fa fa-cogs fa-2x lounge-icon grey"></a>&emsp;
        <a href="suggestions.php"class="fa fa-folder fa-2x lounge-icon grey"></a>
</div>
        <div>
        <div class="panel">
                    <div class="panel-heading">
                      <span class="panel-title">News</span>
                    </div>
                    <div class="panel-body">
                      This is some new from Infinity-Forum. This is also just a bunch of random boring text. And if you're still reading this random boring text you should
                      probably get a life. I wrote this just so I can have some content to look at while testing the Lounge. Theres also quite a it of text here
                      because i need quite a bit of text to work with. Are you seriously still reading this! Shouldnt you be working on Infinity or something?
                      OMG you have no life! GET ONE! Wow, seriously stop reading this.
                      <br><br>
                      <button class="btn btn-primary">Dismiss</button>
                    </div>
                </div>
                <br>
                <div class="panel">
                    <div class="panel-heading">
                      <span class="panel-title">Project Request from <a>Infinity-Forum</a></span>
                    </div>
                    <div class="panel-body">
                      Hey Uriah. This is Arty from project Infinity. We were wondering if you would like to join sometime? <br>
                      If you decide to join, we'll see you in the workspace! Dont forget to PM me your resume. <br>
                      It's not on your profile for some reason.
                      <br><br>
                      <button class="btn btn-success">Join</button>&nbsp;<button class="btn btn-danger">Refuse</button>
                    </div>
                </div>
                <br>
            <div class="panel">
                    <div class="panel-heading">
                      <span class="panel-title">New friend request from <a>Relax</a></span>
                    </div>
                    <div class="panel-body">
                      "Hey Uriah, this is Relax. Add me as soon as possible so we can get started!"
                      <br><br>
                      <button class="btn btn-success">Accept</button>&nbsp;<button class="btn btn-danger">Deny</button>
                    </div>
                </div>
                <br>
                <div class="panel">
                    <div class="panel-heading">
                      <span class="panel-title"><a>Relax</a> posted on your wall:</span>
                    </div>
                    <div class="panel-body">
                      "What's up? I heard you recently got into that big project Jeremy started."
                      <br><br>
                      <textarea class="form-control"style="height:75px;background-color: rgba(255, 255, 255, .7);"></textarea><br><br>
                      <button class="btn btn-success">Reply</button>
                    </div>
                </div>
                <br>
                <div class="panel">
                    <div class="panel-heading">
                      <span class="panel-title">Notification</span>
                    </div>
                    <div class="panel-body">
                      <a>Jeremy</a> commented on "My Essay" in branch "test" of project "Infinity"
                      <br><br>
                      <button class="btn btn-primary">Dismiss</button>
                    </div>
                    <br>
                <!-- <button class="pr-btn btn-primary">Load More</button> -->
                <br><br><br><br><br><br><br>
                </div>
            </div>
            </div>
    </div>
