<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
define("PAGE", "forum"); // this is what page it is, for the links at the top
include_once("libs/relax.php"); // use PATH from now on
Login::checkAuth();
include_once(PATH ."core/top.php");




?>




<div id="forum_nav">
	<div id="forum_nav_1"><a href="#">Infinity-forum</a></div>&nbsp;<i class="fa fa-long-arrow-right fa-lg"></i>&nbsp;<!--
    --><div id="forum_nav_2"><span></span><span><?php 
	echo "<ul>";
	$member = Members::getInstance();
	$MyRank = $member->getUserRank(0,"getIndex"); //get the current users rank
	$forum = new Forum();

	$res = $forum->sql->query("SELECT * FROM `categories` WHERE `min_rank` <= ? AND (`visible`=1 OR ?=?) ORDER BY `index_` DESC", $MyRank, array_search("Admin", $member->ranks), $MyRank);
	while ($row3 = $res->fetch())
	{
		echo "<li><b>".$row3['name']."</b></li>";
		$cats = $forum->sql->query("SELECT * FROM `subcat` WHERE `parent_ID`=? AND `min_rank` <= ? AND (`visible`=1 OR ?=?) ORDER BY `index_` DESC",$row3["ID"],  $MyRank, array_search("Admin", $member->ranks), $MyRank);
		while ($row = $cats->fetch())
		{
			echo "<li><a href=\"#f=$row[ID]/".$forum->convertName($row["name"])."\">$row[name]</a></li>";
			$subcat = $forum->sql->query("SELECT * FROM `subforum` WHERE `parent_ID` = ? AND (`visible`=1 OR ?=?) ORDER BY `index_` DESC", $row["ID"], $MyRank, array_search("Admin", $member->ranks), $MyRank);
			while ($row2 = $subcat->fetch())
			{
				echo "<li><a href=\"#f=$row[ID]/".$forum->convertName($row["name"])."&s=$row2[ID]/".$forum->convertName($row2["name"])."\">$row2[name]</a> &#171;</li>";
			}
		}
		echo "<li>&nbsp;</li>";
	}

	echo "</ul>";
	unset($forum);
	?></span></div>&nbsp;<i class="fa fa-long-arrow-right fa-lg"></i>&nbsp;<!--
    --><div id="forum_nav_3" class="forum_nav_active"><span></span></div>&nbsp;<i class="fa fa-long-arrow-right fa-lg"></i>&nbsp;<!--
    --><div id="forum_nav_4"></div>
    <!--
    <script type="text/javascript">
	    var hash = window.location.hash;
	    if (hash.indexOf("t=")!= -1){
	    	var threadID = parseInt(hash.substr(hash.indexOf('t=')+2,hash.indexOf('/')-2), 10);
		    var pg = 1;
		    pg = hash.split('/')[hash.split('/').length - 1]; //get last part of url for page number
			if(pg == false || isNaN(pg)) pg = 1; //fail safe
		    $('#forum_nav').append("<button id='forum-post'>+</button>&emsp;<?php $forum = new Forum(); echo $forum->listPageNums(1); ?>");
	    }
    </script>
    -->
    <br><br>
    <div id="forum-pages">
    	
    </div>
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