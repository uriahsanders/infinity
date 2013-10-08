<?php
if (defined("INFINITY") || !empty($_POST)) //this file will only be accessable with include or post ajax...
{
		define("INFINITY", true);
		include_once("../libs/relax.php");
		$MyRank = $member->getUserRank(0,2); //get the current users rank
		$ranks = $member->ranks;
    	$forum = new forum; //new forum
		
		echo "<div class=\"forum_box\">";
		$res = $forum->Query("	SELECT topics . * 
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
				echo "</td></tr></table>";
				echo "</div>";
				echo "</div>";
			}
			
			
			echo "</div>";
			
			
			
			
			
			
			
			/*$res2 = $forum->Query("SELECT * FROM subcat WHERE parent_ID = %d AND min_rank <= %d AND (visible=1 OR %d=%d) ORDER BY index_ desc;", $row["ID"], $MyRank, array_search("Admin", $member->ranks), $MyRank);
			// get all the subcategories that the current users rank has access to and are visible, but show everything to admins and sort dy index...
			
			if (mysql_num_rows($res2) > 0) // if any
			{
				echo "<div class=\"subcat\">";
				echo "<table class=\"tbl_subcat\">";
				echo "<tr>";
				echo "<td>[Name]</td>";// some titles
				echo "<td>[Topics]</td>";
				echo "<td>[Posts]</td>";
				echo "<td>[Last Post]</td>";
				
				while($row2 = mysql_fetch_array($res2))
				{
					echo "<tr>";
					echo "<td><a href=\"#f=$row2[ID]/".$forum->convertName($row2["name"])."\"><b>$row2[name]</b>";
					if (strlen($row2["desc_"]) > 0)
						echo "<br/><i>$row2[desc_]</i>";
					$res3 = $forum->Query("SELECT * FROM subforum WHERE parent_ID = %d AND (visible=1 OR %d=%d) ORDER BY index_ desc;", $row2["ID"], $MyRank, array_search("Admin", $member->ranks), $MyRank);
					if (mysql_num_rows($res3) > 0)
					{
						$subforum = "<i>";
						while($row3 = mysql_fetch_array($res3))
						{
							$subforum .= "&nbsp;<a href=\"#f=$row2[ID]/".$forum->convertName($row2["name"])."&s=$row3[ID]/".$forum->convertName($row3["name"])."\">$row3[name]</a>,";
						}
						echo substr($subforum,0,-1)."</i>";
					}
					
					
					
					echo "</a></td>"; //pring name and description
					echo "<td>".$forum->getTopicCount($row2["ID"])."</td>"; //show how many topics in this subcat
					echo "<td>".$forum->getPostCountByForum($row2["ID"])."</td>"; //show how many post are in this subcat
					echo "<td>".$forum->getLastPostByForum($row2["ID"])."</td>"; //get last message
					echo "</tr>";
				}
				echo "</table>";
				echo "</div><br/>";
			}
			echo "</div>";
		
   echo "</div>";*/
}
    ?>