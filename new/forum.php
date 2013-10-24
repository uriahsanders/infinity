<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
define("PAGE", "forum"); // this is what page it is, for the links at the top
include_once("libs/relax.php"); // use PATH from now on
include_once(PATH ."core/top.php");
$member->check_auth();




?>




<div id="forum_nav">
	<div id="forum_nav_1"><a href="#">Infinity-forum</a></div><i>---------</i><!--
    --><div id="forum_nav_2"><span></span><span><?php 
	echo "<ul>";
	$MyRank = $member->getUserRank(0,"getIndex"); //get the current users rank
	$forum = new forum;

	$res = $forum->Query("SELECT * FROM categories WHERE min_rank <= %d AND (visible=1 OR %d=%d) ORDER BY index_ desc;", $MyRank, array_search("Admin", $member->ranks), $MyRank);
	while ($row3 = mysql_fetch_array($res))
	{
		echo "<li><b>$row3[name]</b></li>";
		$cats = $forum->Query("SELECT * FROM subcat WHERE parent_ID=%d AND min_rank <= %d AND (visible=1 OR %d=%d) ORDER BY index_ desc;",$row3["ID"],  $MyRank, array_search("Admin", $member->ranks), $MyRank);
		while ($row = mysql_fetch_array($cats))
		{
			echo "<li><a href=\"#f=$row[ID]/".$forum->convertName($row["name"])."\">$row[name]</a></li>";
			$subcat = $forum->Query("SELECT * FROM subforum WHERE parent_ID = %d AND (visible=1 OR %d=%d) ORDER BY index_ desc;", $row["ID"], $MyRank, array_search("Admin", $member->ranks), $MyRank);
			while ($row2 = mysql_fetch_array($subcat))
			{
				echo "<li><a href=\"#f=$row[ID]/".$forum->convertName($row["name"])."&s=$row2[ID]/".$forum->convertName($row2["name"])."\">$row2[name]</a> &#171;</li>";
			}
		}
		echo "<li>&nbsp;</li>";
	}

	echo "</ul>";
	unset($forum);
	?></span></div><i>---------</i><!--
    --><div id="forum_nav_3" class="forum_nav_active"><span></span></div><i>---------</i><!--
    --><div id="forum_nav_4"></div>
</div><br/>
<div id="main">
	<div class="forum_1">
	<?php
		//include_once(PATH."forum/forum.php");
	?>
    </div>
</div>
<?php
include_once(PATH ."core/main_end_foot.php");
?>