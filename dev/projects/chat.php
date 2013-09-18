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
Chat for: <span style="color:rgb(63, 98, 143);font-weight: bold;font-style:italic;">Project_name</span>
    
</div>
<!---->
<?php
include('nav.php');
?>
<hr style="width:500px;" />





<?php 
include_once('../libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>