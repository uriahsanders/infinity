<?php
if (defined("INFINITY") || !empty($_POST)) //this file will only be accessable with include or post ajax...
{
		define("INFINITY",true);
		include_once("../libs/relax.php");
		echo "<div class=\"forum_box\">";
			$MyRank = $member->getUserRank(0,2); //get the current users rank
			$forum = new forum; //new forum
			
			$res = $forum->Query("SELECT * FROM subcat WHERE ID = %d AND min_rank <= %d AND (visible=1 OR %d=%d)",$_POST['f'],$MyRank, array_search("Admin", $member->ranks), $MyRank);
			if (mysql_num_rows($res) === 0)
				die("Wrong ID"); //so you can't access hidden/restricted categories with javascript manipulation
			$name = mysql_fetch_array($res);
			echo "<div class=\"forum\">";
			echo "<div class=\"cat_title\">";
			echo "<span>&nbsp;</span>"; 
			echo $name["name"]; // category name
			echo "</div>";
				
			$res2 = $forum->Query("SELECT * FROM topics WHERE parent_ID=%d",$_POST['f']);
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
					echo "<td><a href=\"#t=$row2[ID]/".$forum->convertName($row2["title"])."\"><b>$row2[title]</b>";
					$u = $forum->getUsrInfo($row2['by_'])["username"];
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
		
			//$script  = "<intput type=\"hidden\" value=\"".$name["name"]."\" id=\"hdn_cat\"/>";
            $script = "<script>";
			$script .= "var cat = 0;";
			$script .= "</script>";
			echo $script;
}
    ?>