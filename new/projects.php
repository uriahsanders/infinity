<?php
    define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "start"); // this is what page it is, for the links at the top
    include_once("libs/relax.php"); // use PATH from now on
    include_once(PATH ."core/top.php");
?>
    
<?php
    include_once(PATH ."core/main_end_foot.php");
?>



<script type="text/javascript" src="../js/tinymvc.js"></script>
<script type="text/javascript" src="script.js"></script>