<?php
if (defined("INFINITY") || !empty($_POST)) //this file will only be accessable with include or post ajax...
{
		define("INFINITY", true);
		include_once("../libs/relax.php");
		$MyRank = $member->getUserRank(0,2); //get the current users rank
		$ranks = $member->ranks;
    	$forum = new forum; //new forum
		
		echo "<div class=\"forum_box\">";
		$res = $forum->Query("	SELECT topics.*, 
												CASE WHEN 
													sub=0 
												THEN 
													(SELECT subcat.name FROM subcat WHERE subcat.ID=topics.parent_ID) 
												ELSE 
													(SELECT subforum.name FROM subforum WHERE subforum.ID=topics.parent_ID) 
												END 
												AS 
													cat_name,
												CASE WHEN 
													sub=1 
												THEN 
													(SELECT subforum.parent_ID FROM subforum WHERE subforum.ID=topics.parent_ID) 
												END 
												AS 
													cat_ID,
												(SELECT subcat.name FROM subcat WHERE subcat.ID=topics.parent_ID)
												AS
													cat_name2 
								FROM topics, subcat
								WHERE topics.ID =%d
								AND topics.parent_ID = subcat.ID
								AND (
									subcat.visible =1
									OR %d=%d
								)
								AND (
									subcat.min_rank <= %d
								)", $_POST["t"], array_search("Admin", $member->ranks), $MyRank, $MyRank);
								
		if (mysql_num_rows($res) === 0)
			die("could not find the thread"); //or don't have access
			
		$row = mysql_fetch_array($res);
		
			echo "<div class=\"thread\">";
			echo "<div class=\"thread_title\">";
			echo "<span>&nbsp;</span>"; 
			echo $row["title"] ; // topic title
			echo "</div>";
			echo "<div class=\"post\">";
			echo "<table class=\"tbl_post\"><tr><td>";
			echo "<div class=\"post_usr\">";
			$poster = $forum->getUsrInfo($row["by_"]);
			echo "<a href=\"/user/$poster[username]\">$poster[username]</a><br/>"; //username
			echo "<span class=\"status\" id=\"offline\" title=\"offline\">&nbsp;</span>"; //online status
			echo "<img src=\"/images/user/$poster[image]\" alt=\"$poster[username]\" />"; //picture
			echo "<span class=\"usr_rank\">".$ranks[$poster["rank"]]."</span>"; //rank
			echo "<table class=\"usr_info\">";
			echo "<tr><td width=10>Posts:</td><td>". $forum->getPostCountByUser($poster["ID"])."</td></tr>"; //post count
			echo "<tr><td>Ash:</td><td>". $poster["points"]."</td></tr>"; //ask points
			
			echo "</table>";
			echo "</div>";
			echo "</td><td>";
			echo "<div class=\"post_msg\">";
			echo $row["msg"];
			echo "</div>";
			echo "</td></tr></table>";
			echo "</div>";
			echo "</div>";
			
			$res = $forum->Query("SELECT * FROM posts WHERE parent_ID=%d", $row["ID"]);
			
			while ($row2 = mysql_fetch_array($res))
			{
				echo "<br/>";
				echo "<div class=\"thread\">";
				echo "<div class=\"thread_title2\">";
				echo "<span>&nbsp;</span>"; 
				//echo ">> ".$row["title"] ; // topic title
				echo "</div>";
				echo "<div class=\"post\">";
				echo "<table class=\"tbl_post\"><tr><td>";
				echo "<div class=\"post_usr\">";
				$poster = $forum->getUsrInfo($row2["by_"]);
				echo "<a href=\"/user/$poster[username]\">$poster[username]</a><br/>"; //username
				echo "<span class=\"status\" id=\"offline\" title=\"offline\">&nbsp;</span>"; //online status
				echo "<img src=\"/images/user/$poster[image]\" alt=\"$poster[username]\" />"; //picture
				echo "<span class=\"usr_rank\">".$ranks[$poster["rank"]]."</span>"; //rank
				echo "<table class=\"usr_info\">";
				echo "<tr><td width=10>Posts:</td><td>". $forum->getPostCountByUser($poster["ID"])."</td></tr>"; //post count
				echo "<tr><td>Ash:</td><td>". $poster["points"]."</td></tr>"; //ask points
				
				echo "</table>";
				echo "</div>";
				echo "</td><td>";
				echo "<div class=\"post_msg\">";
				echo $row2["msg"];
				echo "</div>";
				
				echo "<div class=\"post_msg_btm\">";
				echo "will add a menu here with post actions (only placeholder atm)";
				echo "</div>";
				
				echo "</td></tr></table>";
				echo "</div>";
				echo "</div>";
			}
			
			
			echo "</div>";
			
			if (isset($row['cat_ID'])) //if subforum post, so we get right back on track
				$script  = "<input type=\"hidden\" value=\"".base64_encode($row["cat_name"])."|".$row['cat_ID']."/".$forum->convertName($row["cat_name2"])."&s=".$row["parent_ID"]."\" class=\"hdn_cat\"/>";
			else
				$script  = "<input type=\"hidden\" value=\"".base64_encode($row["cat_name"])."|".$row["parent_ID"]."\" class=\"hdn_cat\"/>";
			$script .= "<input type=\"hidden\" value=\"".base64_encode($row["title"])."|".$row["ID"]."\" class=\"hdn_thr\"/>";
			echo $script;
			
			//var_dump($row);
			
			
}
    ?>