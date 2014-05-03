<?php
//This file contains general purpose functions

//remove value $val from array $arr
function remValueFromArr(&$arr, $val){
	if(($key = array_search($val, $arr)) !== false) {
	    unset($arr[$key]);
	}
}

//perform a each function in array $funcs for each index in array $arr
function doForAllInArray(&$arr, $funcs){
	foreach($arr as $key => $value){
		foreach($funcs as $func){
			$arr[$key] = call_user_func($func, $value);
		}
	}
}

//if preventing xss but still need some args to be filtered use this standard
function filter($input){
	return htmlspecialchars($input);
}

//HTML insertion functions
	function thumbnailTemplate($id, $projectname, $creator, $date, $popularity, $short, $image){
		$member = Members::getInstance();
		$username = $member->get($creator, 'username');
		return "<a>
        <div id=\"$username-$projectname-$id\"class=\"project\">
          <div class=\"lead project-title\">$projectname</div><br>
          <div class=\"project-img\">
            <img src='/images/profile-photo.jpg'style='height:200px;width:200px'>
          </div>
          <div class=\"project-info\">
            By ".$username.",  ".System::timeDiff($date)."<br><br>
            $short
          </div>
        </div>
      </a>";
	}
	function projectTemplate($id, $projectname, $creator, $date, $popularity, $members, $short, $description, $image, $video){
		$member = Members::getInstance();
		$username = $member->get($creator, 'username');
		$members = json_decode($members);
		$memberList = "<br>Members:<br><br>";
		$thisMember = null;
		foreach((array)$members as $value){
			$thisMember = $member->get($value, 'username');
			$memberList .= "<a target=\"_blank\"href=\"/user/$thisMember\">".$thisMember.'</a><br>';
		}
		return "
			<button class='pr-btn'id='pr-discover'>See More Projects</button><br><br>
			<div id='project-main'style='width:75%;background:url(\"/images/broken_noise.png\");margin:auto;padding:15px;border-radius:5px;text-align:center'>
				<div id='pr-nav'>
				<input type='hidden'value='".$id."'id='usr_id'/>
				<input id='projectID'type='hidden'value='".$id."'/>
				<button class='pr-btn'id='pr-about'>About</button>&emsp;<button class='pr-btn'id='pr-posts'>Wall</button>&emsp;
				<button class='pr-btn'id='pr-join'>Join</button>&emsp;
				</div>
				<br><br>
				<span class='lead'style='font-size: 3em;'>$projectname</span><br><br> by <a target=\"_blank\"href=\"/user/$username\">$username</a><br><br>
				<div style='background:#000;width:80%;height:400px;margin:auto'></div>
				<br><br>
				<div id='epicdisplay-desc'style='padding:10px;border-radius:5px;margin:auto;width:85%;background:url(\"/images/gray_sand.png\");'><textarea class='epic-text'id='display-desc'>$description</textarea></div>
			</div>
			<div id='project-wall'style='display:none;width:75%;background:url(\"/images/broken_noise.png\");margin:auto;padding:15px;border-radius:5px;text-align:center'></div>
		";
	}
	//turn a long post or something into a preview of it
	function preview($msg){
		if(strlen($msg) > 50){
			return substr($msg, -strlen($msg) + 50);
		}else{
			return $msg;
		}
	}
	//create a link for user
	function userLink($name){
		return '<a href="/user/'.$name.'">'.$name.'</a>';
	}