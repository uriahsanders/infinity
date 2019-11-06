<?php 
    define("INFINITY", true); // this is so the includes can't get directly accessed
    include_once("../libs/relax.php"); // use PATH from now on
	
    Login::checkAuth();
	$member = Members::getInstance();
  $forum = new Forum();
    $projects = new Projects();
    $data = $member->getUserData($_SESSION['ID'], "ID");
    $image = $data["image"]; 
?>
        <div>
        <!--<?php
          $str = '<div style="margin:10px;font-size:1.5em">Suggested Projects</div>';
          $amnt = 0;
          //handle projects
          foreach(Views::makeSuggestion()['projects'] as $query){
            foreach($query->fetchAll() as $row){
              if(!Views::hasSeen($row['ID'], 'project')){
                $str .= thumbnailTemplate($row['ID'], $row['projectname'], $row['creator'], $row['date'], 
                  $row['popularity'], $row['short'], $row['image']);
                if(++$amnt > 10) break 2;
              }
            }
          }
          $str .= '<div style="margin:10px;font-size:1.5em">Suggested Threads</div>';
          $amnt = 0;
          //handle threads
          // foreach(Views::makeSuggestion()['threads'] as $query){
          //   foreach($query->fetchAll() as $row){
          //     //if(!Views::hasSeen($row['ID'], 'thread')){
          //       $str .= '
          //         '.$row['title'].', by '.$member->get($row['by_'], 'username').'  '.System::timeDiff($row['time_']).'<br>
          //         '.$row['msg'].'<br><br>
          //       ';
          //       if(++$amnt > 10) break 2;
          //     //}
          //   }
          // }
          echo $str;
        ?>-->
        <div style="margin-left:300px;font-size:1.5em">Suggested Projects and Threads Coming Soon</div>
    </div>
