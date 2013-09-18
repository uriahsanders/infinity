<?php 
include_once('../libs/top.php'); //DO NOT REMOVE OR CHANGE 
include_once('../libs/links.php'); // DO NOT REMOVE OR CHANGE

                                        listlinks("Projects", "../"); // CHANGE TO THE ACTIVE LINK

// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>

<a href="/index.php"><div id="smalllogo"></div><div id="smalltext"></div></a>
</div>

<div id="planhead"><a href="workspace.php">Workspace</a></div><!--Change to active link-->
<!--<div id="main" style="width:100%; padding-right: 0px">-->
<div id="wrktab1"><a>Projects</a></div>
<div id="wrktab2"><a>Freelancing</a></div>
<!---->
<div id="mainwrk1">
<br />
<strong style="font-size: 1.5em;">Manage your Projects</strong>
<hr>
<div id="box" style="width:180px; height:740px; border-radius: 2px 2px 2px 2px; border-top: 0.7px solid black; border-right: 0.7px solid black; border-bottom: 0.7px solid black; opacity: 1; text-align: center;">
<b>Active Project:</b><br />
EXAMPLE<hr style="width: 50px;">
<button id="loginbtn">Create New</button>
<br /><br />
<div id="changeactive"><a>CHANGE ACTIVE</a></div><br /><hr style="width:180px;">
<div class="changeactive" id="box" style="display: none; opacity: 1; width: 200px; height: 200px; margin-left: auto; margin-right: auto; border: 1px solid black;">
Choose the project to manage<hr style="width:180px;">
<?php
echo str_repeat("<br />", 8);
?>
<div onclick="this.parentNode.style.display = 'none'" style="text-align: center;"><a>Close</a></div>
</div>
<strong style="font-size: 1.5em;">
<a>Stream</a><br /><hr style="width:180px;">
<a>Chat</a><br /><hr style="width:180px;">
<a>Calendar</a><br /><hr style="width:180px;">
<a>Mail</a><br /><hr style="width:180px;">
<a>Groups</a><br /><hr style="width:180px;">
<a>Tasks</a><br /><hr style="width:180px;">
<a href="boards.php">Boards</a><br /><hr style="width:180px;">
<a>Files</a><br /><hr style="width:180px;">
<a>Updates</a><br /><hr style="width:180px;">
<a>Statuses</a><br /><hr style="width:180px;">
<a>Charts/graphs</a><br /><hr style="width:180px;">
</strong>
<br />
<b style="font-size: 2.5em;">  </b>
</div>

</div>
<!---->
<div id="mainwrk2">
<br />
<strong style="font-size: 1.5em;">Manage your Freelancing</strong>
<hr>
<div id="box" style="width:180px; height:740px; border-radius: 2px 2px 2px 2px; border-top: 0.7px solid black; border-right: 0.7px solid black; border-bottom: 0.7px solid black; opacity: 1; text-align: center;">
<b>Select your interface</b><br />
<div id="cchoose"><b><a>Client</a></b></div>
<div id="echoose"><b><a>Employee</a></b></div>
<hr style="width:180px;">
<div id="cbox">
test cbox
</div>
<div id="ebox" style="display: none;">
test fbox
</div>
</div>
</div>
</div>
<!---->
<?php
include('nav.php');
?>
<hr style="width:500px;" />





<?php 
include_once('../libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>