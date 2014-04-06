<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
    include_once("../libs/relax.php"); // use PATH from now on
$res = '<div style="margin-left:300px;font-size:1.5em;">Memberlist</div><br><table cellpadding="10"cellspacing="6"style="margin-left:400px;background:url(/images/gray_sand.png);width:600px;text-align:center;
padding:10px;border-collapse:collapse">';
$members = Database::getInstance()->query("SELECT * FROM `memberinfo` ORDER BY `prestige` DESC");
while($member = $members->fetch()){
	$res .= '
		<tr style="border-bottom:1px solid #000">
		<td style="padding:20px"><a target="_blank"href="/user/'.$member['username'].'">'.$member['username'].'</a></td>
		<td style="padding:20px">'.$member['prestige'].' prestige</td>
		<td style="padding:20px">'.($member['special'] != 'Member' ? $member['special'] : Members::getInstance()->ranks[$member['rank']]).'</td>
		<td style="padding:20px">'.Members::getInstance()->numPosts($member['ID']).' Posts</td>
		</tr>
	';
}
die($res.'</table>');