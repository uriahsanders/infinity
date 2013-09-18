<?php
            include_once('../libs/loading.php');
        ?>
<div id="box" style="position:absolute;width:180px; height:740px; border-radius: 2px 2px 2px 2px; border-top: 0.7px solid black; border-right: 0.7px solid black; border-bottom: 0.7px solid black; opacity: 1; text-align: center;">
<b>Active Project:</b><br />
<span style="color:rgb(63, 98, 143);font-weight: bold;font-style:italic;">Project_Name</span><hr style="width:180px;">
<strong style="font-size: 1.5em;">
    <a id="changeactive">Change</a><br /><hr style="width:180px;"></strong>
    <div class="changeactive" id="box" style="font-weight:normal;display: none; opacity: 1; width: 200px; height: 200px; margin-left: auto; margin-right: auto; border: 1px solid black;overflow-y:scroll;">
Choose the project to manage<hr style="width:180px;">
<?php
echo str_repeat("<br />", 9);
?>
<div class="close" onclick="$('.changeactive').fadeOut('slow');" style="text-align: center;"><a href="#">Close</a></div>
</div>

<strong style="font-size: 1.5em;">
<a href="workspace.php">Stream</a><br /><hr style="width:180px;">
<a href="chat.php">Chat</a><br /><hr style="width:180px;">
<a href="calendar.php">Milestones</a><br /><hr style="width:180px;">
<a href="groups.php">Groups</a><br /><hr style="width:180px;">
<a href="tasks.php">Tasks</a><br /><hr style="width:180px;">
<a href="boards.php">Boards</a><br /><hr style="width:180px;">
<a href="files.php">Files</a><br /><hr style="width:180px;">
<a href="statuses.php">Statuses</a><br /><hr style="width:180px;">
<a href="viewprojects.php">Projects</a><br /><hr style="width:180px;">
</strong>
