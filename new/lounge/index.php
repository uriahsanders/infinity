<?php 
    define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "lounge"); // this is what page it is, for the links at the top
    include_once("../libs/relax.php"); // use PATH from now on
	
    Login::checkAuth();
	
    include_once(PATH ."core/top.php");
    if(defined("PAGE") && PAGE == "start") 
    {
        include_once(PATH ."core/slide.php");
    }
    include_once(PATH ."core/bar_main_start.php");
?>

    <div id="lounge-nav">
        <br><br><br><br><br><br>
        <a class="fa fa-home fa-2x lounge-icon gold active"></a>&emsp;
        <a class="fa fa-envelope-o fa-2x lounge-icon white"></a>&emsp;
        <a class="fa fa-user fa-2x lounge-icon yellow"></a>&emsp;
        <a class="fa fa-comments fa-2x lounge-icon lightgreen"></a>&emsp;
        <a class="fa fa-cogs fa-2x lounge-icon grey"></a>&emsp;
        <a class="fa fa-folder fa-2x lounge-icon grey"></a>
    </div>
    <br><br>
    <div>
        <div class="panel">
                    <div class="panel-heading">
                      <span class="panel-title">News</span>
                    </div>
                    <div class="panel-body">
                      <div class="panel-text">
                      This is some new from Infinity-Forum. This is also just a bunch of random boring text. And if you're still reading this random boring text you should
                      probably get a life. I wrote this just so I can have some content to look at while testing the Lounge. Theres also quite a it of text here
                      because i need quite a bit of text to work with. Are you seriously still reading this! Shouldnt you be working on Infinity or something?
                      OMG you have no life! GET ONE! Wow, seriously stop reading this.
                      </div>
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
                      <span class="panel-title">Notification</span>
                    </div>
                    <div class="panel-body">
                      <a>Jeremy</a> commented on "My Essay" in branch "test" of project "Infinity"
                      <br><br>
                      <button class="btn btn-primary">Dismiss</button>
                    </div>
                </div>
                <br>
            </div>
            </div>
    </div>
