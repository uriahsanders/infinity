<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie
//////////////////////////////////////////
// session start and include all libs etc
//////////////////////////////////////////

include_once(PATH ."libs/relax.php"); //this should already be included at every page at the top forore the include to this file, not removing it from here yet though


//CSRF token
$token = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
$_SESSION['token'] = $token;

//check if logged in, if not we need captcha
$logged = Login::checkAuth(true);
if(!$logged) 
{
    $cryptinstall="./extra/crypt/cryptographp.fct.php"; 
    include_once($cryptinstall); //catcha code
}

//page starts after this
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <title>Infinity - cycle of knowledge</title>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php
			//loading for each page
            include_once(PATH . "extra/loading/loading.php");
			echo "\n"; //nicer source code
        ?>
        <link rel="stylesheet" type="text/css" href="/css/default.css" />
        <?php
            if ($logged) //member css for logged in memers
                echo '<link rel="stylesheet" type="text/css" href="/css/member.css" />'."\n";        
        ?>
        <link href='http://fonts.googleapis.com/css?family=Oswald:300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="/js/jquery-1.9.0.min.js"></script>
        <script src="/js/jquery-ui.min.js" type="text/javascript"></script> 
        <script src="/js/mix.js" type="text/javascript"></script>
        
        <?php 
			/*
				having different css for each page is stupid, I take the blame for that one.
				It gets messy and you have to rewrite code multiple times and still you will get pages to look differently.
				I'm going to rewrite this later to fewer files			
			*/
            if(defined("PAGE") && PAGE == "start") 
            { 
                echo '<link rel="stylesheet" type="text/css" href="/extra/slider/slide.css" />'; 
                echo '<script type="text/javascript" src="/extra/slider/jquery.nivo.slider.js"></script>';
            }
            else if(defined("PAGE") && PAGE == "profile") 
            {
                echo '<link rel="stylesheet" type="text/css" href="/css/profile.css" />';
                echo '<script src="/js/profile.js" type="text/javascript"></script>';
				echo '<link href="/extra/imgUpload/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />';
	        	echo '<script src="/extra/imgUpload/js/jquery.Jcrop.min.js"></script>';
        		echo '<script src="/extra/imgUpload/js/script.js"></script>';
            }
            else if(defined("PAGE") && PAGE == "forum") 
            {
                echo '<link rel="stylesheet" type="text/css" href="/css/forum.css" />';
                echo '<script src="/js/forum.js" type="text/javascript"></script>';
            }
            if ($logged)
			{
                echo '<script src="/js/lmember.js" type="text/javascript"></script>';
                echo '<script src="/js/status.js" type="text/javascript"></script>';
			}
			else 
                echo '<script src="/js/member.js" type="text/javascript"></script>';
        ?>
    </head>
    <body>
    <div class="body" style="position:relative; min-height:100%">
    <?php
		include_once(PATH . "extra/donate.php"); //doing a include here not to clog this file
	?>
    <div id="top">
        <span id="logo" onclick="window.location = '/';">&nbsp;</span><span id="extra"></span><span id="extra2"></span><!--
        --><span id="menu">
        <?php
			//absolute top links as list
            System::listLinks(PAGE);
        ?>
        </span>
        
        <div class="extra-btn1">
            <div class="extra_icon1"></div>
        </div>
        <div class="extra-btn2">
            <div class="extra_icon2"></div>
        </div>
        <?php
            if ($logged)
            {
				//logged in memeber bar
				echo "
					<div class=\"member_bar\">
					<div id=\"member_bar_body\">Welcome <b><a href=\"/user/\">$_SESSION[USR]</a></b>!
					<div id=\"member_bar_links\">
					<a class='member_link'href=\"/lounge/\">Lounge</a>&nbsp;
					<!--<a class='member_link'href=\"/projects/\">Projects</a>&nbsp;-->
					<a class='member_link'href=\"/workspace/\">Workspace</a>&nbsp;
					<a class='member_link'href=\"/users/\">Members</a>&nbsp;
					<a class='member_link'href=\"/pm/\">Unread</a>&nbsp;
					</div>
					</div>
					<div id=\"member_bar_icons\">";
				
				//status icon
				echo "<div id=\"status_icon\"><img src=\"/images/status/0.png\" class=\"status_icon\" alt=\"status\" title=\"status\">";
				echo "<span>";
				$status = array(
					1 => "Online",
					2 => "Away",
					3 => "Busy",		
					0 => "Invisible"					
				);
				foreach($status as $id=>$name)
				echo "<label><img src=\"/images/status/$id.png\" alt=\"$id\" title=\"$name\"/>$name</label>";
				echo "</span>";
				echo "</div>";
				echo "<a href=\"/member/settings\"><img src=\"/images/s.png\" alt=\"settings\" title=\"settings\" border=\"0\"/></a>
					<!--Need messages icon here-->
					<a href=\"/lounge/logout\"><img src=\"/images/logout.png\" alt=\"logout\" title=\"logout\" border=\"0\"/></a>
					</div>
					</div>";
            }
        ?>
    </div>
    <?php
        if (!$logged)
        {
        	if (preg_match("/\/restricted\/.*/", $_SERVER['REQUEST_URI']))
				echo "<script>$(document).ready(function(e){
					$(\"#box_top\").click();
				});</script>";
    ?>
        <div class="member_box">
            <div class="inner_box1">
                <div id="box_top">
                    <div id="box_title">Member Login</div>
                    <div class="box_icon1"></div>
                </div>
                <div class="box_cont">
                    <form action="/login/" method="post" id="login_frm">
                        Username:<br/>
                        <input type="text" tabindex="1" name="usr" required pattern=".{3,16}" placeholder="Enter your username" id="login_usr" maxlength="20" /><br/>
                        Password:<br/>
                        <input type="password" tabindex="2" name="pwd" required pattern=".{3,16}" placeholder="Enter your password" id="login_pwd" autocomplete="off" maxlength="30" /><br />
                        <input type="hidden" name="token" value="<?php echo $token; ?>" />
                    	<?php
						if (strpos($_SERVER['REQUEST_URI'], "?u=") !== false)
						{
							$url = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "?u=")+3); //doing this with code instead of htaccess
									echo "<input type=\"hidden\" name=\"u\" value=\"$url\" />"; //hidden redirect
						}
						?>
                    <input type="submit" tabindex="3" class="login_btn" value="Login"><br /><br /></form>
                </div>
            </div>
            <div class="inner_box2">
                <div id="box_top">
                    <div id="box_title">Register</div>
                    <div class="box_icon2"></div>
                </div>
                <div class="box_cont">
                   <form action="/member/register" method="post" id="reg_form">
                       Username:<br/>
                       <input type="text" name="reg_usr" id="reg_usr" maxlength="16" onblur="validate.checkDub(this)" required pattern="[a-zA-Z0-9_-]{3,16}" placeholder="Enter a username" title="Must be between 3 and 16 cahars, characters allowed are A-Z, a-z, 0-9, _- and ."/><br/>
                       Password:<br/>
                       <input type="password" name="reg_pwd" id="reg_pwd" autocomplete="off" maxlength="25" required pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" placeholder="Enter a password" title="The password be between 6 and 25 chars and must contain a capitalized and lower-case letter, and a number."/><br />
                       Confirm Password:<br/>
                       <input type="password" name="reg_pwd2" id="reg_pwd2" autocomplete="off" maxlength="25" onblur="validate.register()" required pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" placeholder="Confirm password"/><br />
                       Email:<br/>
                       <input type="email" name="reg_email" id="reg_email" onblur="validate.checkDub(this)" autocomplete="off" maxlength="50" required pattern="^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$" placeholder="Enter your email" title="Enter a valid email"/><br />
                       <input type="checkbox" name="reg_terms" id="reg_term" value="yes" required /><label> Yes i accept the <a href="#" id="show_terms">Terms</a></label><br /><br />
                       <?php dsp_crypt(0,0); ?>
                       Code:<br />
                       <input type="text" name="reg_code" id="captcha" required pattern=".+" placeholder="Enter code shown above"><br />
                       <input type="hidden" name="reg_token" value="<?php echo $token; ?>" />
                       <input type="submit" class="reg_btn" id="reg_sub" value="Register" onclick="validate.register();"/><br /><br />
                   </form>
                </div>
            </div>
            <div class="inner_box3">
                <div id="box_top">
                    <div id="box_title">Recover</div>
                    <div class="box_icon3"></div>
                </div>
                <div class="box_cont">
                   <form action="/recover/" method="post" id="rec_form">
                        Username or Email:<br/>
                       <input type="text" name="rec_usr" required pattern=".{3,50}" id="rec_usr" maxlength="30" placeholder="Input username or email"/><br/>
                       <input type="hidden" name="token" value="<?php echo $token; ?>" />
                       <input type="submit" value="Recover" class="rec_btn" />
                   </form>
                   <br /><br />
                </div>
            </div>
    
        </div>
       <?php
        }
    ?> 
        
        
        
        
        
        
    