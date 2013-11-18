<?php
if (defined("INFINITY") || !empty($_POST)) //this file will only be accessable with include or post ajax...
{
		define("INFINITY",true);
		include_once("../libs/relax.php");
		echo "<div class=\"forum_box\">";
			$MyRank = $member->getUserRank(0,2); //get the current users rank
			$forum = new forum; //new forum
			$s = false;
			if (isset($_POST['s']))
				$s = true;
			if ($s)
				$res = $forum->Query("SELECT * FROM subforum WHERE ID = %d AND min_rank <= %d AND (visible=1 OR %d=%d)",$_POST['s'],$MyRank, array_search("Admin", $member->ranks), $MyRank);
			else
				$res = $forum->Query("SELECT * FROM subcat WHERE ID = %d AND min_rank <= %d AND (visible=1 OR %d=%d)",$_POST['f'],$MyRank, array_search("Admin", $member->ranks), $MyRank);
			
			if (mysql_num_rows($res) === 0)
				die("Wrong ID"); //so you can't access hidden/restricted categories with javascript manipulation
			$name = mysql_fetch_array($res);
			echo "<div class=\"forum\">";
			echo "<div class=\"cat_title\">";
			echo "<span>&nbsp;</span>"; 
			echo $name["name"]; // category name
			echo "</div>";
			
			if ($s)
				$res2 = $forum->Query("SELECT * FROM topics WHERE parent_ID=%d AND sub=1",$_POST['s']);
			else
				$res2 = $forum->Query("SELECT * FROM topics WHERE parent_ID=%d AND sub=0",$_POST['f']);
			if (mysql_num_rows($res2) > 0) // if any
			{
				echo "<div class=\"subcat\">";
				echo "<table class=\"tbl_subcat\">";
				echo "<tr>";
				echo "<td>[Subject]</td>";// some titles
				echo "<td>[Replies]</td>";
				echo "<td>[Views]</td>";
				echo "<td>[Last Post]</td>";
				
				while($row2 = mysql_fetch_array($res2))
				{
					echo "<tr>";
					echo "<td><a href=\"#!t=$row2[ID]/".$forum->convertName($row2["title"])."\"><b>$row2[title]</b>";
					$i = $forum->getUsrInfo($row2['by_']);
					$u = $i["username"];
					echo "<br/><i><a href=\"/user/$u\">Started by: $u</a></i>";
					echo "</a></td>"; //pring name and description
					echo "<td>".$forum->getPostCount($row2["ID"])."</td>"; //show posts in th thread
					echo "<td>0</td>"; //show how many post are in this subcat
					echo "<td>".$forum->getLastPost($row2["ID"])."</td>"; //get last message
					echo "</tr>";
				}
				echo "</table>";
				echo "</div><br/>";
			}
			echo "</div>";
   		echo "</div>";
		
			$script  = "<input type=\"hidden\" value=\"".base64_encode($name["name"])."|".$name["ID"]."\" class=\"hdn_cat\" />";
			echo $script;
}
    ?>