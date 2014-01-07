<?php
if (!defined("INFINITY"))
    die(); // do not allow direct access to this fie
//////////////////////////////////////////
// session start and include all libs etc
//////////////////////////////////////////
include_once(PATH ."libs/relax.php");
$token = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
$_SESSION['token'] = $token;

$logged = Login::checkAuth(true);
if(!$logged) 
{
    $cryptinstall="./extra/crypt/cryptographp.fct.php"; 
    include_once($cryptinstall); //catcha code
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml", id="html", lang="en">
    <head>
    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <title>Infinity - cycle of knowledge</title>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php
            include_once(PATH . "extra/loading/loading.php");
			echo "\n";
        ?>
        <link rel="stylesheet" type="text/css" href="/css/default.css" /><!--php?style=default-->
        <?php
            if ($logged)
                echo '<link rel="stylesheet" type="text/css" href="/css/member.css" />'."\n";        
        ?>
        <link href='http://fonts.googleapis.com/css?family=Oswald:300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="/js/jquery-1.9.0.min.js"></script>
        
        <script src="/js/jquery-ui.min.js" type="text/javascript"></script> 
        <script src="/js/mix.js" type="text/javascript"></script>
        
        <?php 
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
				
				//echo '<script src="/js/wall.js"></script>';
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
    <!--<script type="text/javascript" src="/extra/loading.js"></script>-->
    <div class="body" style="position:relative; min-height:100%">
    <div class="extra">
        <div id="donate">Infinity-forum is free for non-profit users and we have chose not to have adds and annoying popups that will molest your <br/>
        mind for all eternity or make you missclick on an add and acidently close wrong tab <br/>
        so your work is lost or your music stops or even worse... <br />
        WHAT HAPPENS IF YOU ACIDENTLY CLOSE DOWN YOUR PRESSIOUS FACEBOOK :S <br/>
        to avode us getting adds to run we rely on your donations<br />
        <div id="slider-result">15$</div>  
        <div class="Dslider"></div>
        <input type="hidden" id="hidden"/>
        <div id="donate_btn">Donate</div>
        
        </div>
        <div id="feedback">
            <form action="/feedback/send" method="post" id="send_feedback">
            <div id="feed_box">
                <div id="feed_box_1">
                    <table id="feed_box_1_tbl">
                        <tr>
                            <th>Leave feedback 1/4<hr /></th>
                        </tr>
                        <tr>
                            <td>Please leave feedback here to help us make this site better; you can choose to be anonymous.<br/>
        We look over the feedback to know how we can improve the site and get what users want.</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <?php
                            if ($logged)
                            {
                                echo '<tr><td>Do you want to be anonymous when leaving feedback?</td></tr>';
                                echo '<tr><td><input type="checkbox" name="anon" id="fee_anon" /> Check for Yes</td></tr>';    
                            }
                        ?>
                        
                    </table>
                    <div class="btn" id="feed_next_1">Next</div>
                </div>
                
                
                <div id="feed_box_2">
                    <table id="feed_box_2_tbl">
                        <tr>
                            <th colspan="13">Leave feedback 2/4<hr /></th>
                        </tr>
                        <tr>
                            <td colspan="13">What is your overall impression of the layout?</td>
                        </tr>   
                        <tr>
                            <td align="right">Terrible</td>
                            <td width="35px" align="right"><input type="radio" name="fee_l" value="0" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="1" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="2" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="3" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="4" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="5" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="6" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="7" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="8" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="9" class="fee_l" /></td>
                            <td width="35px" align="left"><input type="radio" name="fee_l" value="10" class="fee_l" /></td> 
                            <td align="left">AWESOME!!!</td>
                        </tr>                     
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td colspan="13">How easy is it to navigate the site?</td>
                        </tr>
                        <tr>
                            <td align="right">Extremely easy</td>
                            <td width="35px" align="right"><input type="radio" name="fee_n" value="0" class="fee_l" /></td>
                            <td><input type="radio" name="fee_n" value="1" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="2" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="3" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="4" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="5" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="6" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="7" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="8" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="9" class="fee_n" /></td>
                            <td width="35px" align="left"><input type="radio" name="fee_n" value="10" class="fee_n" /></td>
                            <td align="left">How do I get out of here?</td>
                        </tr>
                    </table>
                    <div class="btn" id="feed_next_2">Next</div>
                </div>
            
            
            <div id="feed_box_3">
                    <table id="feed_box_3_tbl">
                        <tr>
                            <th colspan="13">Leave feedback 3/4<hr /></th>
                        </tr>
                        <tr>
                            <td colspan="13">What is your overall impression of the functionality?</td>
                        </tr>
                        <tr>
                            <td align="right">You call that functionality? </td>
                            <td width="35px" align="right"><input type="radio" name="fee_f" value="0" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="1" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="2" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="3" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="4" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="5" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="6" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="7" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="8" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="9" class="fee_f" /></td>
                            <td width="35px" align="left"><input type="radio" name="fee_f" value="10" class="fee_f" /></td>
                            <td align="left">Excellent!</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td colspan="13">How easy was it to understand what the site is about?</td>
                        </tr>
                        <tr>
                            <td align="right">I still have no clue. </td>
                            <td width="35px" align="right"><input type="radio" name="fee_a" value="0" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="1" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="2" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="3" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="4" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="5" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="6" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="7" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="8" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="9" class="fee_a" /></td>
                            <td width="35px" align="left"><input type="radio" name="fee_a" value="10" class="fee_a" /></td>
                            <td align="left">I knew it before I came here!</td>
                        </tr>
                    </table>
                    <div class="btn" id="feed_next_3">Next</div>
                </div>
            
            
                   <div id="feed_box_4">
                    <table id="feed_box_4_tbl">
                        <tr>
                            <th colspan="13">Leave feedback 4/4</th>
                        </tr>
                        <tr>
                            <td colspan="13">Leave comments or suggestions here.</td>
                        </tr>
                    </table>
                    <textarea id="feed_com" name="comments"></textarea>
                    <div class="btn" id="feed_next_4">Send</div>
                </div>
            </div>
            <div id="fee_err">Something went wrong; please check that you have marked all questions.</div>
            </form>
        </div>
    </div>
    <div id="top">
        <span id="logo" onclick="window.location = '/';">&nbsp;</span><span id="extra"></span><span id="extra2"></span><!--
        --><span id="menu">
        <?php
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
                echo "
                <div class=\"member_bar\">
                    <div id=\"member_bar_body\">Welcome <b><a href=\"/user/\">$_SESSION[USR]</a></b>!
                        <div id=\"member_bar_links\">
                            <a class='member_link'href=\"/lounge/\">Lounge</a>&nbsp;
                            <!--<a class='member_link'href=\"/projects/\">Projects</a>&nbsp;-->
                            <a class='member_link'href=\"/workspace/\">Workspace</a>&nbsp;
                            <a class='member_link'href=\"/workspace/\">Members</a>&nbsp;
                            <a class='member_link'href=\"/workspace/\">Unread</a>&nbsp;
                            <!--
                            <a href=\"http://retube.com\">Porn</a>&nbsp;
                            <a href=\"http://pornhub.com\">MORE!!!</a>
                            -->
                        </div>
                    </div>
                    <div id=\"member_bar_icons\">";
                        echo "<div id=\"status_icon\"><img src=\"/images/status/0.png\" class=\"status_icon\" alt=\"status\" title=\"status\">";
						echo "<span>";
						$status = [
								1 => "Online",
								2 => "Away",
								3 => "Busy",		
								0 => "Invisible"					
							];
						foreach($status as $id=>$name)
							echo "<label><img src=\"/images/status/$id.png\" alt=\"$id\" title=\"$name\"/>$name</label>";
						echo "</span>";
						echo "</div>";
						
						 /* commenting out this because it will be redone completely...
                        $res = $member->GetNotification();
                        $res2 = $member->GetNotification(1);
                        echo "<span id=\"member_notification\" ".((mysql_num_rows($res2) > 0)? "new":"")."><h6>". mysql_num_rows($res2) . "</h6>";
                        
                       echo "<div id=\"member_notifications\">";
                                
                                
                                echo "<i>Your events:</i>";
                                while($row = mysql_fetch_array($res))
                                {
                                    echo "<b".(($row['read_']==0)?" new":"").">$row[text_]";
                                    if ((int)$row['type_'] == 1)
                                        echo "<i id=\"n_f_".$row['extra_ID']."\"><img src=\"/images/tick.png\" title=\"accept\" class=\"n_f_a\"/>&nbsp;<img src=\"/images/cross.png\" title=\"decline\" class=\"n_f_d\"/></i>";
                                        
                                    echo "</b>";
                                }
                                
                                
                                
                                
                            echo "</div>
                        </span>*/
						
						
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
                        <input type="text" tabindex="1" name="usr" id="login_usr" maxlength="20" /><br/>
                        Password:<br/>
                        <input type="password" tabindex="2" name="pwd" id="login_pwd" autocomplete="off" maxlength="30" /><br />
                        <input type="hidden" name="token" value="<?php echo $token; ?>" />
                    	<?php
						$url = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "u=")+2); //doing this with code instead of htaccess
							if (strtolower($url) !== "estricted/") //checking that url exist
								echo "<input type=\"hidden\" name=\"u\" value=\"$url\" />"; //hidden redirect
						?>
                    <input type="button" tabindex="3" class="login_btn" value="Login"><br /><br /></form>
                </div>
            </div>
            <div class="inner_box2">
                <div id="box_top">
                    <div id="box_title">Register</div>
                    <div class="box_icon2"></div>
                </div>
                <div class="box_cont">
                   <form action="#" method="post" id="reg_form">
                          <div id="reg_errors">
                           <div class="reg_error_usr">
                               [+] Must be between 3 and 20 cahars, characters allowed are A-Z, a-z, 0-9, _- and .<br />
                               [+] Might already be a user with that name.
                           </div><div style="height:0px"></div>
                           <div class="reg_error_pwd">
                               [+] Must be between 6 and 25 cahars.<br />
                               [+] The password must contain a capitalized and lower-case letter, and a number.
                           </div>
                           <div class="reg_error_pwd2">
                               [+] Password does not match.
                           </div>
                           <div class="reg_error_email">
                               [+] Email is not valid.<br />
                               [+] There might already be a user with that email registered.
                           </div><div style="height:65px"></div>
                           <div class="reg_error_code">
                               [+] You need to enter the code from above here.
                           </div>
                       </div>
                       Username:<br/>
                       
                       <input type="text" name="reg_usr" id="reg_usr" maxlength="20" /><br/>
                       Password:<br/>
                       <input type="password" name="reg_pwd" id="reg_pwd" autocomplete="off" maxlength="30" /><br />
                       Confirm Password:<br/>
                       <input type="password" name="reg_pwd2" id="reg_pwd2" autocomplete="off" maxlength="30" /><br />
                       Email:<br/>
                       <input type="email" name="reg_email" id="reg_email" autocomplete="off" maxlength="80" /><br />
                       <input type="checkbox" name="reg_terms" id="reg_term" value="yes" /><label> Yes i accept the <a href="#" id="show_terms">Terms</a></label><br /><br />
                       <?php dsp_crypt(0,0); ?>
                       Code:<br />
                       <input type="text" name="reg_code" id="captcha"><br />
                       <input type="hidden" name="reg_token" value="<?php echo $token; ?>" />
                   </form>
                   <div class="reg_btn">Register</div><br /><br />
                </div>
            </div>
            <div class="inner_box3">
                <div id="box_top">
                    <div id="box_title">Recover</div>
                    <div class="box_icon3"></div>
                </div>
                <div class="box_cont">
                   <form action="/recover/" method="post" id="rec_form">
                   <div id="rec_errors">
                           <div class="rec_error_usr">
                               [+] Theres no one with that email or username registered.
                           </div>
                       </div>
                          Username or Email:<br/>
                       <input type="text" name="rec_usr" id="rec_usr" maxlength="30" /><br/>
                       <input type="hidden" name="token" value="<?php echo $token; ?>" />
                   </form>
                   <div class="rec_btn">Recover</div><br /><br />
                </div>
            </div>
    
        </div>
       <?php
        }
    ?> 
        
        
        
        
        
        
    