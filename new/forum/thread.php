<?php
if (defined("INFINITY") || !empty($_POST)) //this file will only be accessable with include or post ajax...
{
		define("INFINITY", true);
		include_once("../libs/relax.php");
		$member = Members::getInstance();
		$MyRank = $member->getUserRank(0,2); //get the current users rank
		$ranks = $member->ranks;
    	$forum = new Forum; //new forum
		
		echo "<div class=\"forum_box\">";
		$res = $forum->sql->query("	SELECT topics.*, 
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
								WHERE topics.ID =?
								AND topics.parent_ID = subcat.ID
								AND (
									subcat.visible =1
									OR ?=?
								)
								AND (
									subcat.min_rank <= ?
								)", $_POST["t"], array_search("Admin", $member->ranks), $MyRank, $MyRank);
		$row = $res->fetchAll();						
		if (count($row) === 0)
			die("could not find the thread"); //or don't have access
			
			//if we are on the first page show init post
				echo "<input type='hidden'id='last-page'value='".$forum->numPagesInThread($_POST['t'])."'/><div class=\"thread\">";
				if($_POST['pg'] == 1){
					echo "<br><div class=\"thread_title\">";
					echo "<span>&nbsp;</span>"; 
					echo $row[0]["title"]." - ".System::timeDiff($row[0]["time_"]); // topic title
					echo "</div>";
					echo "<div class=\"post\">";
					echo "<table class=\"tbl_post\"><tr><td>";
					echo "<div class=\"post_usr\">";
					$poster = $member->getUserData($row[0]["by_"]);
					echo "<a href=\"/user/$poster[username]\">$poster[username]</a><br/>"; //username
					echo "<span class=\"status\" id=\"offline\" title=\"offline\">&nbsp;</span>"; //online status
					echo "<img src=\"/images/user/$poster[image]\" alt=\"$poster[username]\" />"; //picture
					echo "<span class=\"usr_rank\">".($poster['special'] !== 'Member' && $poster['special'] !== '' ? $poster['special'] : $ranks[$poster["rank"]])."</span><br><br>"; //rank
					echo "<table class=\"usr_info\">";
					echo "<tr><td width=10>Posts:</td><td>". $forum->getPostCountByUser($poster["ID"])."</td></tr>"; //post count
					echo "<tr><td>Prestige:</td><td>". $poster["points"]."</td></tr>"; //ask points
					
					echo "</table>";
					echo "</div>";
					echo "</td><td>";
					echo "<div class=\"post_msg\">";
					echo $row[0]["msg"];
					echo "</div>";
					echo "<div class=\"post_msg_btm\">";
						echo "
							<a>Quote</a> ".($_SESSION['ID'] == $row2['by_'] ? "&emsp; <a>Modify</a> &emsp; <a>Remove</a>" : "&emsp; <a>Report</a>");
						echo "</div>";
					echo "</td></tr></table>";
					echo "</div>";
					echo "</div>";
				}			
			$res = $forum->sql->query("SELECT * FROM `posts` WHERE `parent_ID`=? ORDER BY `time_` ASC LIMIT ".($forum->beginAtRow($_POST['pg'])).", ".Forum::LIMIT, $row[0]["ID"]);
			$resFetch = $res->fetchAll();
			$count = count($resFetch);
			$counter = 0;
			foreach($resFetch as $row2)
			{
				echo "<br/>";
				echo "<div id='thread-".$row['ID']."'class=\"thread\">";
				echo "<div class=\"thread_title\">";
				echo "<span>&nbsp;</span>"; 
				echo "Re: ".$row[0]["title"]." - ".System::timeDiff($row2["time_"]); // topic title
				echo "</div>";
				echo "<div class=\"post\">";
				echo "<table class=\"tbl_post\"><tr><td>";
				echo "<div class=\"post_usr\">";
				$poster = $member->getUserData($row2["by_"]);
				echo "<a href=\"/user/$poster[username]\">$poster[username]</a><br/>"; //username
				echo "<span class=\"status\" id=\"offline\" title=\"offline\">&nbsp;</span>"; //online status
				echo "<img src=\"/images/user/$poster[image]\" alt=\"$poster[username]\" />"; //picture
				echo "<span class=\"usr_rank\">".($poster['special'] !== 'Member' && $poster['special'] !== '' ? $poster['special'] : $ranks[$poster["rank"]])."</span><br><br>"; //rank
				echo "<table class=\"usr_info\">";
				echo "<tr><td width=10>Posts:</td><td>". $forum->getPostCountByUser($poster["ID"])."</td></tr>"; //post count
				echo "<tr><td>Prestige:</td><td>". $poster["points"]."</td></tr>"; //ask points
				
				echo "</table>";
				echo "</div>";
				echo "</td><td>";
				echo "<div class=\"post_msg\">";
				echo $row2["msg"];
				echo "</div>";
				
				echo "<div class=\"post_msg_btm\">";
				echo "
					<a>Quote</a> ".($_SESSION['ID'] == $row2['by_'] ? "&emsp; <a>Modify</a> &emsp; <a>Remove</a>" : "&emsp; <a>Report</a>");
				echo "</div>";
				
				echo "</td></tr></table>";
				echo "</div>";
				//last row
				if(++$counter == $count) echo "<br><button id='forum-post'>New Post</button>&emsp;".$forum->listPageNums($_POST['t'], $_POST['pg'])."<br>";
				echo "</div>";
			}
			
			
			echo "</div>";
			
			if (isset($row[0]['cat_ID'])) //if subforum post, so we get right back on track
				$script  = "<input type=\"hidden\" value=\"".base64_encode($row[0]["cat_name"])."|".$row[0]['cat_ID']."/".$forum->convertName($row[0]["cat_name2"])."&s=".$row[0]["parent_ID"]."\" class=\"hdn_cat\"/>";
			else
				$script  = "<input type=\"hidden\" value=\"".base64_encode($row[0]["cat_name"])."|".$row[0]["parent_ID"]."\" class=\"hdn_cat\"/>";
			$script .= "<input type=\"hidden\" value=\"".base64_encode($row[0]["title"])."|".$row[0]["ID"]."\" class=\"hdn_thr\"/>";
			echo $script;
			
			//var_dump($row);
			
			
}
    ?>