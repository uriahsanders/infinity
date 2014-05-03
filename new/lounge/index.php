<?php 
    define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "lounge"); // this is what page it is, for the links at the top
    include_once("../libs/relax.php"); // use PATH from now on
    Login::checkAuth();
	$member = Members::getInstance();
    $projects = new Projects();
    include_once(PATH ."core/top.php");
    if(defined("PAGE") && PAGE == "start") 
    {
        include_once(PATH ."core/slide.php");
    }
    include_once(PATH ."core/bar_main_start.php");
    $data = $member->getUserData($_SESSION['ID'], "ID");
    $image = $data["image"]; 
?>
<input type="hidden" value="<?php echo $ID; ?>" id="usr_id" /> 
<div id="pro_side"style="background:url('/images/broken_noise.png');padding:10px;border-radius:5px;min-height:300px;border:2px solid #000">
    <div id="pro_user_pic">
        <?php
                echo '<span><img src="/images/s.png" title="settings"/>';
                echo '<span><b class="user-pic-upload"id="upload">Upload</b><b id="remove">Delete</b></span>';                
                echo '</span>';
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
    <div style="margin:auto;text-aling:center">
    <br>
    <?php 
      echo "<br><a style='font-size:1.4em'>Projects: <b>".$projects->numProjects($_SESSION['ID'])."</b></a><br /><br>";
      echo "<a style='font-size:1.4em'>Posts: <b>".$member->numPosts($_SESSION['ID'])."</b></a><br /><br>";
      echo "<span style='font-size:1.4em'>Prestige: <b>".$data['prestige']."</span></b><br /><br>";
    ?>
    </div><br>
    <div style="background:url('/images/gray_sand.png');padding:10px">
        <a href="#"class="fa fa-home fa-2x lounge-icon gold active"></a>&emsp;
        <a href="#!/pm"class="fa fa-envelope-o fa-2x lounge-icon white"></a>&emsp;
        <a href="#!/members"class="fa fa-users fa-2x lounge-icon grey"></a>&emsp;
        <a href="#!/settings"class="fa fa-cogs fa-2x lounge-icon grey"></a>&emsp;
        <a href="#!/suggestions"class="fa fa-folder fa-2x lounge-icon grey"></a>
        </div>
</div>
        <div id="lounge-main">
        
    </div>
    <script type="text/javascript"src="script.js"></script>
<?php
 include_once(PATH ."core/main_end_foot.php");
?>