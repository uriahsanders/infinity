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
    $member = Members::getInstance();
    $_SESSION['token'] = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
    $sex = $member->getUserData($_SESSION['ID'], "ID")['sex']; //get the users sex
?> 
  <div onsubmit="return false;"style="width:80%;margin:auto;padding:10px;border-radius:5px;"class="text-center">
    <div class="lead i fa-2x"style="margin:auto">Profile Options</div><br>
    <form id="options"style="border:2px solid #000;width:75%;margin:auto;background:url('/images/gray_sand.png');padding:20px;height:100%;border-radius:5px;">
        <input type="password"class="form-control"name="current-password"style="display:inline;width:80%"placeholder="Current Password (Required)">
        <br><br>
        <div class="lead">Account</div><br>
        <input name="username"type="text"class="form-control"style="display:inline;width:80%"value=<?php echo '"'.$member->get($_SESSION['ID'], 'username').'"'; ?>placeholder="Username..."><br><br>
        <input type="password"class="form-control"name="password"style="display:inline;width:80%"placeholder="New Password..."><br><br>
        <input type="password"class="form-control"name="verify-password"style="display:inline;width:80%"placeholder="Verify New Password..."><br><br>
        <input type="text"class="form-control"name="email"style="display:inline;width:80%"value=<?php echo '"'.$member->get($_SESSION['ID'], 'email').'"'; ?>placeholder="Email..."><br><br>
        <div class="lead">Profile</div><br>
        Choose Avatar: <input type="file"class="form-control"style="display:inline;">
        <br><br>
        Age:<br>
        <input type="text"class="form-control"name="age"style="display:inline;width:80%"value=<?php echo '"'.$member->get($_SESSION['ID'], 'age').'"'; ?>placeholder="Age..."><br><br>
        Country:<br> <input type="text"class="form-control"name="country"style="display:inline;width:80%"value=<?php echo '"'.$member->get($_SESSION['ID'], 'country').'"'; ?>placeholder="Country..."><br><br>
        Work:<br> <input type="text"class="form-control"name="work"style="display:inline;width:80%"value=<?php echo '"'.$member->get($_SESSION['ID'], 'work').'"'; ?>placeholder="Work..."><br><br>
        Quote:<br> <input type="text"class="form-control"name="quote"style="display:inline;width:80%"value=<?php echo '"'.$member->get($_SESSION['ID'], 'quote').'"'; ?>placeholder="Quote..."><br><br>
        Website:<br> <input type="text"class="form-control"name="wURL"style="display:inline;width:80%"value=<?php echo '"'.$member->get($_SESSION['ID'], 'wURL').'"'; ?>placeholder="Website URL..."><br><br>
        Who can send me personal messages: <select class="form-control"style="display:inline;"name="" id="">
            <option value="">All members not on my ignore list</option>
            <option value="">All members</option>
            <option value="">Only friends</option>
            <option value="">Noone except for Infinity Staff</option>
        </select>
        <br><br>
        About Me:<br><br>
        <textarea class="tinymce"name="about">
            <?php echo $member->get($_SESSION['ID'], 'about'); ?>
        </textarea><br><br>
        Resume:<br><br>
        <textarea class="tinymce"name="resume">
            <?php echo $member->get($_SESSION['ID'], 'resume'); ?>
        </textarea>
        <br><br>
        <input type="text"class="form-control"style="display:inline;width:67%"placeholder="New Skill">&emsp;<button type="button"class="btn btn-info">Add Skill</button><br><br>
        <textarea style="display:inline;width:80%"name="" id="" cols="30" rows="5"class="form-control"placeholder="Skills..."disabled></textarea>
        <br><br>
        Gender:&emsp;<input id="Male" type="radio" name="gender" value="Male"/> Male&emsp;<input id="Female" type="radio" name="gender" value="Female"/> Female&emsp;<input id="Other" type="radio" name="gender" value="Other"/> Other&emsp;<input id="Undisclosed" type="radio" name="gender" value="Undisclosed"/> Undisclosed
        <br><br>
        <input type="checkbox"> Allow Infinity to send me emails.
        <input type="hidden"name="token"value=<?php echo '"'.$_SESSION['token'].'"'; ?>/> 
        <input type="hidden"name="signal"value="options"/> 
        <br><br>
       <button id="#update"class="btn btn-success">Update</button>
            <br><br>
    </form><br>
        <br><br>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var sex = "<?php echo $sex ?>";
        $('#' + sex).attr("checked", true); //make the radio ticked
    });
    $('#options').on('submit', function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        $.ajax({
            url: '../settings_handle.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                window.location.reload(true);
            }
        });
    });
</script>
