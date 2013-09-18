<?php
    header("Content-Type: text/xml; charset=ISO-8859-1");
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    include('test_framework.php');
    if(isset($_GET['feed'])){
        $sql = new SQL;
        $result = $sql->Query("SELECT * FROM `projects_data` WHERE `projectID` = %d AND `what` != %s AND `what` != %s AND `what` != %s ORDER BY `date` DESC LIMIT 10", $_GET['feed'], 'branch', 'message', 'note');
        $return = NULL;
        $workspace_dir = $_SERVER['DOCUMENT_ROOT'].'/uriah/test.php/';
        if(mysql_num_rows($result) == 0){
            $return .= '
                <item>
                    <title>Nothing here!</title>
                    <link>http://infinity-forum.org/workspace</link>
                    <description>There has been no activity in your workspace yet. Please try again later.</description>
                </item>
            ';
        }else{
            while($row = mysql_fetch_assoc($result)){
                $what = $row['what'];
                $action = 'created';
                $by = id2user($row['by']);
                $body = NULL;
                if($what == 'document' || $what == 'update'){
                    $body = $row['body'];
                }else if($what == 'task'){
                    $to = json_decode($row['big_array']);
                    $assigned_to = NULL;
                    for($i = 0; $i < count($to); $i++){
                        $assigned_to .= '<a>'.id2user($to[$i]).'</a>, ';
                    }
                    $assigned_to = substr($assigned_to, 0, -2);
                    if($assigned_to == NULL){ 
                        $assigned_to = 'Everyone';
                    }
                    $body = 'Assigned to: '.$assigned_to;
                    $action = ($row['mark'] == 0) ? 'created' : 'completed';
                    $by = ($action == 'completed') ? id2user($row['mark']) : $by;
                }else if($what == 'event'){
                   $body = 'From: '.$row['due']." to ".$row['due2'];
                }
                if($what == 'document' || $what == 'task' || $what == 'table'){
                    $extra = ' in branch \''.$row['branch'].'\'';
                    if($what == 'document'){
                         $extra .= ', Version #'.$row['level'];
                    }else if($what == 'task'){
                        switch($row['level']){
                            case 0:
                                $status = 'Incomplete';
                                break;
                            case 1:
                                $status = 'Almost complete';
                                break;
                            case 2:
                                $status = 'Complete';
                                break;
                        }
                        $extra .= ', '.$status;
                    }
                }else{
                    $extra = NULL;
                }
                if(strlen($row['body']) > 0){
                   $body .= '<![CDATA[<br />'.substr($row['body'], 0, 20).'...]]>';
                }
                $return .= '
                    <item>
                        <title>'.$row['title'].', '.$action.' by: '.$by.''.$extra.': '.$row['date'].' ('.$row['what'].')</title>
                        <link>'.$workspace_dir.$row['what'].'/'.$row['id'].'</link>
                        <description>
                            '.$body.'
                        </description>
                    </item>
                ';
            }
        }
        echo '<?xml version="1.0" encoding="ISO-8859-1" ?>
            <rss version="2.0">
                <channel>
                    <category>Workspace</category>
                    <copyright>Infinity-forum.org 2013 all rights reserved</copyright>
                    <language>en-us</language>
                    <title>
                        '.Person::id2projectname($_GET['feed']).' RSS feed
                    </title>
                    <link>
                        http://infinity-forum.org
                    </link>
                    <description>
                        Workspace stream for '.Person::id2projectname($_GET['feed']).'
                    </description>
                    '.$return.'
                </channel>
            </rss>
        ';
    }
