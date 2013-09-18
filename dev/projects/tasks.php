<?php 
include_once('../projects/ptop.php'); //DO NOT REMOVE OR CHANGE
include_once('../libs/links.php'); // DO NOT REMOVE OR CHANGE

                                        listlinks("Projects"); // CHANGE TO THE ACTIVE LINK

// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
include_once('status.html')
?>
</div>

<div id="planhead"><a href="workspace.php">Workspace</a></div><!--Change to active link-->
<!--<div id="main" style="width:100%; padding-right: 0px">-->
<div id="wrktab1"><a href="/accsummary.php"><?php echo $_SESSION['usrdata']['screenname']; ?></a></div>

<!---->
<div id="mainwrk1">
<br />
<strong style="font-size: 1.5em;">Manage your Projects</strong>
<hr>
<?php
    include_once('../projects/sidebar.php');
?>
<b style="font-size: 2.5em;">  </b>
</div>
<!--Your stuff here-->
   Tasks for : <span style="color:rgb(63, 98, 143);font-weight: bold;font-style:italic;">Project_Name</span> 
<br /><br /><a onclick="$('#existingTasks').slideToggle('slow');">New Task</a><br /><br />
<div id="existingTasks" style="display:none;">
    <form>
        Name:<br /><input type="text"style="border-radius:3px 3px 3px 3px;" autofocus /><br />
        Assigned To:<br /><input type="text"style="border-radius:3px 3px 3px 3px;" /><br />
        Due By:<br /><input type="text" style="width:40px;"placeholder="M"style="border-radius:4px 4px 4px 4px;" /> <input type="text" style="width:40px;"placeholder="D"style="border-radius:4px 4px 4px 4px;" /> <input type="text" style="width:40px;"placeholder="Y" style="border-radius:4px 4px 4px 4px;"/>
        <br />
        Description:<br /><textarea style="border-radius:3px 3px 3px 3px;" ></textarea><br />
        <input type="submit" style="border-radius:3px 3px 3px 3px;" />
    </form>
</div>
<hr />
Existing Tasks &nbsp; <?php echo date("M d, Y") ?>
<br />

    </div>
</div>
<!---->

<!---->
<?php
include('nav.php');
?>
<hr style="width:500px;" />





<?php 
include_once('../libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>