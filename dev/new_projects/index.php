<?php
    $token = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
    $_SESSION['token'] = $token;
    include_once($_SERVER['DOCUMENT_ROOT'].'/new_projects/framework.php');
    include_once($_SERVER['DOCUMENT_ROOT']."/libs/loading.php");
    //include_once($_SERVER['DOCUMENT_ROOT'].'/member/check_auth.php'); //Can be commented out during dev
    //Functions (Script externally[script.php], unless you absolutely must for some reason)
?>
<html>
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
        <link rel="shortcut icon" href="/favicon.ico" />
        <meta charset="UTF-8">
        <title>
            Infinity-Projects
        </title>
        <script type="text/javascript" src="projects.js"></script>
        <link rel="stylesheet" type="text/css" href="projects.css" />
    </head>
    <body>
        <div class="container">
            <div id="top">
                <input placeholder="Search"class="searchbar"type="text" autofocus/> 
            </div>
            <div id="sidenav">
                <h3>Navigation</h3>
                <!--
                    Must have those class names to work
                --->
                <ul>
                    <li id="navlink" class="Start">Start</li>
                    <li id="navlink" class="Focus">Community Focus</li>
                    <li id="navlink" class="Fun">Just for Fun</li>
                    <li id="navlink" class="Technology">Technology</li>
                    <li id="navlink" class="Art">Art</li>
                    <li id="navlink" class="Research">Research</li>
                    <li id="navlink" class="Fashion">Fashion</li>
                    <li id="navlink" class="Culinary">Culinary</li>
                    <li id="navlink" class="Theatre">Theatre</li>
                    <li id="navlink" class="Music">Music</li>
                    <li id="navlink" class="Medical">Medical</li>
                    <li id="navlink" class="Education">Education</li>
                    <li id="navlink" class="Games">Games</li>
                </ul>
                <br />
                <a href="workspace.php"style="padding-left:20px;">Workspace</a>
            </div>
            <!--More required class names past here-->
            <div id="main">
            </div>
        </div>
        <?php
            echo '<input type="hidden" id="token" value="'.$token.'"/>';
        ?>
    </body>
</html>