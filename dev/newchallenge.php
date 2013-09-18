<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/top.php'); //DO NOT REMOVE OR CHANGE 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/links.php'); // DO NOT REMOVE OR CHANGE

listlinks("Projects"); // CHANGE TO THE ACTIVE LINK

include_once($_SERVER['DOCUMENT_ROOT'].'/libs/middle.php'); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>
<div id="box" style="height:850px;text-align:center;position:relative;">
    <div id="newproject" style="text-align:center;">
<div id="box">
    <div id="head">Create New Challenge</div>
    <hr>
    Create a new challenge, this is an admin only form so you can figure the rest out yourself. HAHAHAHAHAHA! :D
    Good luck! Good luck! Boy, are you in for a RIIIIIDEEEEE!! Wow, im so bored :/</div>
    <br /><br /><br /><br /><br /><br /><br /><br />
    <div id="main" style="text-align:center;margin-left:100px;">
    <b>Who wants this challenge done?</b><br /><br />
    <form>
        <input type="text" id="c">
    </form>
    <br /><hr />
     <b>Why is this challenge important?</b><br /><br />
    <form>
        <input type="text" id="c">
    </form>
    <br /><hr />
    <b>How the hell do I join this thing? I want some MONEY!!!</b><br /><br />
    <form>
        <input type="text" id="c">
    </form>
    <br /><hr />
    <b>What categories does your new challenge fall under?</b><br />
    <a href="#" class="cats" onclick="$('.dcats').slideToggle();" style="font-weight:bold;font-size:1em;color:grey;">View Categories</a>
    <div class="dcats" style="display:none;"><br />Test</div>
    <hr />
        <b>Please check the minumum rank you would like to be able to join this challenge?</b><br /><br />
        <form>
        <input type="radio" name="rank">Members | <input type="radio" name="rank">Elite | <input type="radio" name="rank">VIP | <input type="radio" name="rank">Staff 
    </form><br /><hr />
    <b>Let's get to the point here....Whats the REWARD!!!!??????</b><br /><br />
    <input type="text" id="c">
    <br /><hr />
    <b>What is the name of this challenge?</b><br /><br />
    <input type="text" id="c" size="80"><br /><hr />
    <b>Please provide a detailed description of the challenge.</b><br /><br />
    <textarea rows="10" columns="80"></textarea><br /><hr />
    <input type="submit" value="Create and Post New Project" id="startplan">
    <br /><br /><br /><br /><br /><br />
    
</div>
</div>
</div>