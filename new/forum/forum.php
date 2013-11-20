<?php
if (defined("INFINITY") || !empty($_POST)) //this file will only be accessable with include or post ajax...
{
		@define("INFINITY", true);
		include_once($_SERVER["DOCUMENT_ROOT"] . "/libs/relax.php");
		
		echo "<div class=\"forum_box\">";
	
		$MyRank = $member->getUserRank(0,2); //get the current users rank
    	$forum = new forum; //new forum
		
		$res = $forum->Query("SELECT * FROM categories WHERE min_rank <= %d AND (visible=1 OR %d=%d) ORDER BY index_ desc;", $MyRank, array_search("Admin", $member->ranks), $MyRank);
		// get all the categories that the current users rank has access to and are visible, but show everything to admins and sort dy index...
		
		while($row = mysql_fetch_array($res)) //loop all the categories
		{
			echo "<div class=\"forum\">";
			echo "<div class=\"cat_title\">";
			echo "<span>&nbsp;</span>"; 
			echo $row["name"] ; // category name
			echo "</div>";
			$res2 = $forum->Query("SELECT * FROM subcat WHERE parent_ID = %d AND min_rank <= %d AND (visible=1 OR %d=%d) ORDER BY index_ desc;", $row["ID"], $MyRank, array_search("Admin", $member->ranks), $MyRank);
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
					echo "<td><a href=\"#!/f=$row2[ID]/".$forum->convertName($row2["name"])."\"><b>$row2[name]</b>";
					if (strlen($row2["desc_"]) > 0)
						echo "<br/><i>$row2[desc_]</i>";
					$res3 = $forum->Query("SELECT * FROM subforum WHERE parent_ID = %d AND (visible=1 OR %d=%d) ORDER BY index_ desc;", $row2["ID"], $MyRank, array_search("Admin", $member->ranks), $MyRank);
					if (mysql_num_rows($res3) > 0)
					{
						$subforum = "<i>";
						while($row3 = mysql_fetch_array($res3))
						{
							$subforum .= "&nbsp;<a href=\"#!/f=$row2[ID]/".$forum->convertName($row2["name"])."&s=$row3[ID]/".$forum->convertName($row3["name"])."\">$row3[name]</a>,";
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
		}
   echo "</div>";
}
    ?>