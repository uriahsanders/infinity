<?php
 define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "lounge"); // this is what page it is, for the links at the top
    include_once("../libs/relax.php"); // use PATH from now on
	
    Login::checkAuth();
//code for showing friendlist
$friends = Members::getInstance()->getFriends($_SESSION['ID']);
$list = '<form>';
foreach($friends as $key=>$value)
{
    $list .= "<a href=\"/user/$value[username]\"><img style='height:45px;width:45px;'src=\"/images/user/$value[image]\"  title=\"$value[username]\" /></a>
    <input name='friend-id-".$value['ID']."'type='checkbox'/>";
    $list .= "<br />";        
}
$list .= '</form>';
echo $list;