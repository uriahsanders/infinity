<?php 
include_once('ptop.php'); //DO NOT REMOVE OR CHANGE 
include_once('../libs/links.php'); // DO NOT REMOVE OR CHANGE

                                        listlinks("Projects"); // CHANGE TO THE ACTIVE LINK
include_once('../libs/loading.php');

// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
include_once('status.html')
?>

</div>

<div id="planhead"><a href="apps.php">Applications</a></div><!--Change to active link-->
<!--<div id="main" style="width:100%; padding-right: 0px">-->
<div id="wrktab1" style="cursor:pointer;"><a>Website Apps</a></div>
<div id="wrktab2" style="width: 120px;cursor:pointer;"><a>Download Apps</a></div>
<div id="mainwrk1">
<br />
    <strong style="font-size: 1.5em;">Use and view Infinity-forum Apps</strong>
    <hr>
    
</div>
<div id="mainwrk2">
<br />
    <strong style="font-size: 1.5em;">Download infinity-forum Apps</strong>
<hr>
</div>
<?php
include('nav.php');
?>
<hr style="width:500px;" />





<?php 
include_once('../libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>