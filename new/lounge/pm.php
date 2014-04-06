<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
    include_once("../libs/relax.php"); // use PATH from now on
    Login::checkAuth();
    $member = Members::getInstance();
    $groups = new Groups();
$what = $groups->viewPms(0);
            $res = '';
            while($row = $what->fetch()){
                $res .= '
                <div id="pm-row"class="pm-read-'.$row['read'].'">
                    '.$row['subject'].', from .'.$row['from'].' | '.$row['date'].'
                </div>';
            }
            if($res == '') $res = '<div style="margin-left:300px;font-size:1.5em;">No PM\'s to show.</div>';
            die($res);