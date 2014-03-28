<?php
if (defined("INFINITY") || !empty($_POST)) //this file will only be accessable with include or post ajax...
{
		@define("INFINITY", true);
		include_once($_SERVER["DOCUMENT_ROOT"] . "/libs/relax.php");
		
		echo "<div class=\"forum_box\">";
		$member = Members::getInstance();
		$MyRank = $member->getUserRank(0,2); //get the current users rank
    	$forum = new Forum; //new forum
		
		$res = $forum->sql->query("SELECT * FROM `categories` WHERE `min_rank` <= ? AND (`visible`=1 OR ?=?) ORDER BY `index_` DESC;", $MyRank, array_search("Admin", $member->ranks), $MyRank);
		// get all the categories that the current users rank has access to and are visible, but show everything to admins and sort dy index...
		
		while($row = $res->fetch()) //loop all the categories
		{
			echo "<div class=\"forum\">";
			echo "<div class=\"cat_title\">";
			echo "<span>&nbsp;</span>"; 
			echo $row["name"] ; // category name
			echo "</div>";
			$res2 = $forum->sql->query("SELECT * FROM `subcat` WHERE `parent_ID` = ? AND `min_rank` <= ? AND (`visible`=1 OR ?=?) ORDER BY `index_` DESC;", $row["ID"], $MyRank, array_search("Admin", $member->ranks), $MyRank);
			// get all the subcategories that the current users rank has access to and are visible, but show everything to admins and sort dy index...
			$res2Fetch = $res2->fetchAll();
			if (count($res2Fetch) > 0) // if any
			{
				echo "<div class=\"subcat\">";
				echo "<table class=\"tbl_subcat\">";
				echo "<tr>";
				echo "<td>[Name]</td>";// some titles
				echo "<td>[Topics]</td>";
				echo "<td>[Posts]</td>";
				echo "<td>[Last Post]</td>";
				
				foreach($res2Fetch as $row2)
				{
					echo "<tr>";
					echo "<td><a href=\"#f=$row2[ID]/".$forum->convertName($row2["name"])."\"><b>$row2[name]</b>";
					if (strlen($row2["desc_"]) > 0)
						echo "<br/><i>$row2[desc_]</i>";
					$res3 = $forum->sql->query("SELECT * FROM `subforum` WHERE `parent_ID` = ? AND (`visible`=1 OR ?=?) ORDER BY `index_` DESC;", $row2["ID"], $MyRank, array_search("Admin", $member->ranks), $MyRank);
					$res3Fetch = $res3->fetchAll();
					if (count($res3Fetch) > 0)
					{
						$subforum = "<i>";
						foreach($res3Fetch as $row3)
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
		}
   echo "</div>";
}
    ?>