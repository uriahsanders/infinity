<?php 
// [TODO] - fix this fucking page
    define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "profile"); // this is what page it is, for the links at the top
    include_once("libs/relax.php"); // use PATH from now on
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
    <div id="pro_info">
    <?php 
        if (!empty($data['age']))
        {
            echo "Age <b>$data[age]</b><br />";
        }
        if (!empty($data['country']))
        {
            echo "Lives in <b>$data[country]</b><br />";
        }
        if (!empty($data['work']))
        {
            if (strtolower($data['work']) == "student")
            {
                echo "Is a <b>Student</b><br />";
            }
            else
            {
                echo "Works at <b>$data[work]</b><br/>";
            }
        }
        if (!empty($data['active_p']))
        {
            echo "Active project: <b>$data[active_p]</b><br />";
        }
        if (!empty($data['wURL']))
        {
            echo "Website: <b><a href='$data[wURL]' target='_blank'>$data[wURL]</a></b><br />";
        }
    ?>
    </div>
    
    <div id="pro_inf_info">
        <table id="pro_inf_info_tbl">
            <tr>
                <?php
                    $num = $projects->numProjects($ID);
                    echo "<td><b>".$num."*</b><br/>Project".($num == 1 ? '' : 's')."<br /><br /></td>
                    <td><b>1244*</b><br/>Forum Posts<br /><br /></td>";
                ?>
            </tr>
            <tr>
                <td colspan="2">
                <?php if (isset($data['points']))
                {
                    echo "<b>$data[points]</b><br />";
                }
                ?>
                Prestige</td>
            </tr>
        </table>
    </div>
    <div id="pro_user_friends">
        <div id="pro_user_friends_title">
        <?php // <--- THAT MOTHERFUCKER DID THE RANDOM LOGOUTS!!!!!! WHAT THA FUCK!!!!!!
            $friends = $member->getFriends($ID);
            echo "<span>".count($friends)." Friends</span>";
        ?>
        </div>
        <div id="pro_user_friends_pics">
            <?php
                $i = 0;
                foreach($friends as $key=>$value)
                {
                    $i++;
                    if ($i >= 13)
                        break;
                    echo "<a href=\"/user/$value[username]\"><img src=\"/images/user/$value[image]\"  title=\"$value[username]\" /></a>";
                    echo "&nbsp;&nbsp;&nbsp;" . ((($i/4)==((int)($i/4)))?"<br />":"");        
                    
                }
                if (count($friends) > 12)
                    echo "<a href=\"#\">...</a>";
            ?>
        </div>
    </div>
</div>
<div id="pro_main">
    <div id="pro_title">
    <?php  
    echo $data['username']; 
    if (!empty($data['quote']))
        {
            echo "<span>\"$data[quote]\"<span>";
        }
    ?></div>
    <div id="pro_bg_strip">
    <?php
        if($ID == $_SESSION['ID'])
        {
            echo '<span><img src="/images/s.png" title="settings"/>';
            echo '<span><b id="upload">Upload</b><b id="remove">Delete</b></span>';                
            echo '</span>';
        }
        
        
    
        if (!empty($data['banner']))
        {
            echo "<img src=\"/images/user/$data[banner]\" />";
        }
        else 
        {
            echo "<img src=\"/images/def_banner.jpg\" />";
        }
    ?>
    </div>
        <?php
            if ($ID !== $_SESSION['ID'])
            {
                $ft = md5($_SESSION['ID'] . $_SESSION['USR'] . $ID);
                echo "<input type=\"hidden\" id=\"f_t\" value=\"$ft\" />";
                echo "<span id=\"pro_usr_friend\" uId=\"$ID\">Friend";
                
                echo "<div id=\"pro_usr_friend_m\">";
                $f = $member->isFriends($ID, 0);
                
                
                if ($member->isBlocked($ID))
                    echo "<b aID=\"4\">Unblock</b>";
                else
                {
                    if($f == "y")
                        echo "<b aID=\"2\">Remove</b>";
                    else if($f == "a")
                        echo "<b aID=\"2\">Remove request</b>";
                    else
                        echo "<b aID=\"1\">Add</b>";
                    echo "<b aID=\"3\">Block</b>";
                }
                
                echo "</div>";
                
                echo "</span>";
            }
        ?>
        
        
    <span id="pro_usr_menu">
        <span  id="stream"class="pro_usr_menu"active="true">Stream</span>
        <span id="about"class="pro_usr_menu">About</span>
        <span id="resume"class="pro_usr_menu">Resume</span>
        <span id="skills"class="pro_usr_menu">Skills</span>
        <span id="photos"class="pro_usr_menu">Photos</span>
    </span>
    <div id="pro_usr_main">
        <div id="pro_usr_stream"class="pro_usr_ele">
        <?php
           include_once("wall.php");        
        ?>
        </div>
        <div id="pro_usr_about"class="pro_usr_ele"style="display:none">
            
        </div>
        <div id="pro_usr_resume"class="pro_usr_ele"style="display:none">
            
        </div>
        <div id="pro_usr_skills"class="pro_usr_ele"style="display:none">
           
        </div>
        <div id="pro_usr_photos"class="pro_usr_ele"style="display:none">
           
        </div>
    </div>
</div>