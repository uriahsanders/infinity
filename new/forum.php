<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
define("PAGE", "forum"); // this is what page it is, for the links at the top
include_once("libs/relax.php"); // use PATH from now on
include_once(PATH ."core/top.php");
$member->check_auth();
?>




<div id="forum_nav">
	<div id="forum_nav_1"><a href="#">Infinity-forum</a></div><i>---------</i><!--
    --><div id="forum_nav_2"><b>&#171;</b></div><i>---------</i><!--
    --><div id="forum_nav_3" class="forum_nav_active"><b>&#171;</b></div><i>---------</i><!--
    --><div id="forum_nav_4"></div>
</div><br/>
<div id="main">
	<div class="forum_1">
	<?php
		include_once(PATH."forum/forum.php");
	?>
    </div>
</div>
<?php
include_once(PATH ."core/main_end_foot.php");
?>