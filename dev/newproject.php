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
<div id="nav" style="margin-right:270px;"><a href="../projects/projects.php">About</a> | <a href="../projects/workspace.php">Workspace</a> | <a href="../projects/apps.php">Apps</a></div>
<br />

    <div id="newproject">

    <strong style="font-size:1.5em;">Create New Project</strong>
    <hr>
    Create a new project, specify which groups can view it, edit and manage your project blog,
    and create detailed categories and descriptions for it.
    <hr />
    <div>
    <b>Are you starting a small project, business, or team?</b><br />
    <form>
        <input type="radio" name="ptype">Small Project  | <input type="radio" name="ptype">Business  | <input type="radio" name="ptype">Team 
    </form>
    <hr />
        <b>What categories does your new project fall under?</b><br />
       <input type="text" id="c" size="80">

    <hr />
        <b>Please check the minumum rank you would like to be able to join your project.</b><br />
        <form>
            <input type="radio" name="rank" onchange="alert('If you choose this option, you must individually invite people from the workspace.');">Selected | <input type="radio" name="rank">Members | <input type="radio" name="rank">Elite | <input type="radio" name="rank">VIP | <input type="radio" name="rank">Staff 
        </form><hr />
    <b>What incentive is there for people to help you?</b><br /><br />
    <input type="checkbox">Money | <input type="checkbox">Position | <input type="checkbox">Morality | <input type="checkbox">Experience | <input type="checkbox">Other
    <hr />
    <b>What is the name of your project?</b><br />
    <input type="text" id="c" size="80"><hr />
    <b>Please provide a detailed description of your project.</b><br />
    <textarea rows="10" columns="80"></textarea><hr />
        <input type="submit" value="Create and Post New Project" id="startplan"><br />
</div>
</div>

</div>
</div>