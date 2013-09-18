<?php
    /*
    *`notifications` table structure:
    *`id`, `user`, `did`, `what`, `date`
    *data is added to the table in a while loop, making a row for each person in the group
    *the rows are then deleted once they become old new to that user
    *`statuses` table structure:
    *`id`, `status`, `user`
    */
    if(isset($_POST['signal'])){
        switch($_POST['signal']){
            //getting notifications
            case 'poll':
                $sql = new SQL;
                //last request time
                $timestamp = (isset($_POST['timestamp'])) ? $_POST['timestamp'] : 0;
                //array to send response back in with JSON
                $response = array();
                //get most recent update
                $result = $sql->Query("SELECT * FROM `notifications` AND `user` = %d ORDER BY `id` LIMIT 1 ASC", $_SESSION['ID']);
                if(mysql_num_rows($result) == 0){
                    //No data has been sent yet. So send everything as empty.
                    $response['updates'] = 'No recent updates.';
                    $response['comments'] = 'No recent comments.';
                    $response['messages'] = '';
                    $response['requests'] = '';
                    //dont display old data
                    $response['check'] = 2;
                    die();
                }else{
                    $row = mysql_fetch_assoc($result);
                    //update the timestamp to make sure we dont get old updates
                    while($timestamp <= $row['date']){
                        //wait 10 seconds. DOS defense from editing JS
                        usleep(10000);
                        $timestamp = $row['date'];
                    }
                    //set the $results with a quick function
                    //get latest of each
                    $updates = results('update');
                    $messages = results('message');
                    $requests = results('request');
                    //set initial variables
                    $response['notifications'] = 'Notifications:<hr />';
                    //set easy JS vars
                    //in `did` for these is set to zero, just add a number next to link, otherwise, do that AND add to notifications box
                    while($rowMessages = mysql_fetch_assoc($messages)){
                        if($rowMessages['did'] == 0){
                            $response['messages'] = mysql_num_rows($messages);
                        }else{
                            $response['notifications'] .= $rowMessages['did'].'<br />';
                        }
                    }
                    while($rowRequests = mysql_fetch_assoc($requests)){
                        if($rowRequests['did'] == 0){
                            $response['requests'] = mysql_num_rows($requests);
                        }else{
                            $response['notifications'] .= $rowRequests['did'].'<br />';
                        }
                    }
                    //loop through each and add to the response what each person did for the update
                    while($rowUpdates = mysql_fetch_assoc($updates)){
                        $response['notifications'] .= $rowUpdates['did'].'<br />';
                    }
                    //display old data with new data
                    $response['check'] = 1;
                }
                //set the JS timestamp to the updated one
                $response['timestamp'] = $timestamp;
                //after the 20th request in a row (after 10 minutes)....
                if($_POST['x'] == 20){
                    //delete stuff in the database that is too old and associated with the project and user
                    $sql->Query("DELETE FROM `notifications` WHERE `date` < %s AND `user` = %d ", $timestamp, $_SESSION['ID']);
                    $response['check'] = 2;
                }
                //echo everything out as array
                echo json_encode($response);
                break;
                die();
            //changing how often new notifications are grabbed depending on the number of online users
            case 'getCurrentUsers':
                $sql = new SQL;
                //set them as offline or online
                if($_POST['type'] == 1){
                    setStatus('online');
                }else{
                    setStatus('offline');
                    die();
                }
                //if they're online
                $result = $sql->Query("SELECT * FROM `statuses` WHERE `status` = %s", 'online');
                //number of people online
                $num = mysql_num_rows($result);
                //reaches full speed at 290 users
                //more users = notifications are grabbed MORE often
                $min = 10000; //will NOT go faster than 10 seconds so our server isnt raped
                $max = 300000; //5 minutes is slowest possible time
                //during dev comment out timer script so we can see stuff in 10 seconds
                /*
                $tick = $max - ($num * 1000); //change to * 10 for slower increment
                */
                $tick = $min; //for dev
                if($tick < $min){
                    //too fast! make it take 10 seconds
                    $tick = $min;
                }else if($tick > $max){
                    //just to account for a possilbe algorithmic error :O
                    $tick = $max;
                }
                $response['tick'] = $tick;
                break;
            case 'notify':
                notify($_POST['what'], $_POST['info']);
                break;
        }
    }
    //function to add to notifications
    function notify($what, $info){
        //$info is the details of what they did
        //$what is either a update, message, or request
        //for updates/requests, you can set $info to 0, if you want
        $sql = new SQL;
        //$projectID = 0 if not from workspace/projects page
        $result = $sql->Query("SELECT `person` FROM `projects_invited` WHERE `id` = %d", $projectID);
        $date = date("Y:m:d H-i-s");
        while($row = mysql_fetch_assoc($result)){
            $sql->Query("INSERT INTO `notifications` (`user`, `did`, `what`, `date`) VALUES (%d, %d, %d, %s, %s, %s)", $row['person'], $info, $what, $date);
        }
    }
    //Gets results of new inserts of the chosen type (`what`)
    function results($what){
        $sql = new SQL;
        return $sql->Query("SELECT * FROM `notifications` WHERE `user` = %d AND `what` = %s AND `date` > %s ORDER BY `id` LIMIT 20 ASC", $what, $timestamp);
    }
    //sets the status to the given value
    function setStatus($to){
        $sql = new SQL;
        $sql->Query("UPDATE `statuses` SET `status` = %s WHERE `user` = %d", $to, $_SESSION['ID']);
    }