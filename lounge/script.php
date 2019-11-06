<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
include_once('../libs/relax.php');
Login::checkAuth();
 $groups = new Groups();
 $member = Members::getInstance();
//do things for script.js
if(isset($_GET['signal'])){
        switch($_GET['signal']){
            case 'list-pms':
                $what = $_GET['sent'] == 'true' ? $groups->viewSent(0) : $groups->viewPms(0);
                $all = $what->fetchAll();
                if(!isset($_GET['mini'])){
                    // $res = '<form id="pm-form"style="display:none;width:55%;margin-left:400px;background:url(\'/images/gray_sand.png\');padding:10px;border-radius:5px;">
                    //     <br>
                    //     <input type="hidden"name="signal"value="send-pm"/>
                    //     <input name="pm-to"id="pm-to"/><br>
                    //     <input name="pm-subject"placeholder="Subject..."style="padding:10px;width:60%"class="form-control"/><br><br>
                    //     <div style="height:500px"id="epicedit-pm-body">
                    //     <textarea id="epic-pm-body"class="epic-text"name="pm-body"></textarea>
                    //     </div><br>
                    //     <button class="pr-btn">Send</button>
                    // </form>';
                    $res .= '<div id="pm-holder"><span style="font-size:1.3em">Personal Messages</span><br><br>';
                }
               // if(isset($_GET['mini'])){
                    $res .= '
                    <div style="margin-bottom:10px"><div id="pm-row-0">
                        Compose Message
                    </div><div id="pm-body-0"style="display:none;">
                        <form id="pm-form">
                        <input type="hidden"name="signal"value="send-pm"/>
                        <input name="pm-to"id="pm-to"/><br>
                        <input name="pm-subject"placeholder="Subject..."style="padding:10px;width:60%"class="form-control"/><br><br>
                        <textarea name="pm-body"class="form-control"></textarea>
                        <br><br>
                        <button class="pr-btn">Send</button>
                        </form>
                    <br><br></div></div>
                    ';
                //}
                if(count($all) == 0){
                    $res .= '
                        <div id="pm-row-00">
                            There are no messages to display.
                        </div>';
                }
                else{
                    $subjects = [];
                    foreach($all as $row){
                        //no duplicate subjects
                        if(!in_array($row['subject'], $subjects)){
                            $res .= '
                            <div style="margin-bottom:10px"><div id="pm-row-'.$row['ID'].'"class="pm-read-'.$row['read'].'">
                                '.$row['subject'].', from '.$member->getUserData($row['from'])['username'].', '.System::timeDiff($row['date']).'
                            </div><div id="pm-body-'.$row['ID'].'"style="display:none;"><hr style="margin-top:-10px;height: 1px;
background: rgb(0, 0, 0);
border: 0;
box-shadow: 0 -1px 1px 0 rgba(255, 255, 255, .2);">'.$row['body'].'<br><br></div></div>';
                        }
                        array_push($subjects, $row['subject']);
                    }
                    if(isset($_GET['mini'])){
                        $res .= '
                        <br><br>
                        <a href="/lounge/#!/pm"><button id="pm-mini-more"class="pr-btn">View More</button></a>
                        <br><br><br>
                        ';
                    }
                    $res .= '</div>';
                }
                die($res);
        }
    }
else if(isset($_POST['signal'])){
	switch($_POST['signal']){
		case 'dismiss-action':
				Action::removeAction($_POST['id'], $_SESSION['ID']);
				die();
        case 'send-pm':
            $people = explode(',', $_POST['pm-to']);
            //check all usernames
            foreach($people as $to){
                if(!$member->userExist($to)) die("Noone has the username ".$to.".");
            }
            //send to each username
            foreach($people as $to){
                $id = $member->getUserData($to)['ID'];
                Action::addAction('sent you a new PM', preview($_POST['pm-body']), $_SESSION['USR'], 'PM', $id);
                $groups->sendPM($_POST['pm-subject'], $_POST['pm-body'], $_SESSION['ID'], $id, $_POST['pm-to']);
            }
            die("Your message has been sent.");
	}
}