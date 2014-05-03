<?php
 define("INFINITY", true); // this is so the includes can't get directly accessed
    include_once("../libs/relax.php"); // use PATH from now on
          //get last ten actions
        $str = '';
          foreach(Action::getActions($_SESSION['ID'], 10) as $row){
            $str .= '
               <div class="panel">
                    <div class="panel-heading">
                      <span class="panel-title">ggggggggggggggg'.$row['user'].' '.$row['title'].' -'.$row['date'].'</span>
                    </div>
                    <div class="panel-body">
                      '.$row['content'].'
                      <br><br>
                      <button class="btn btn-primary">Dismiss</button>
                    </div>
                </div>
                <br>
            ';
          }
          if($str != '') die($str);
          else die('
            <div class="panel">
                    <div class="panel-heading">
                      <span class="panel-title">hhhInformation</span>
                    </div>
                    <div class="panel-body">
                      Welcome to the lounge! <br><br>As you interact with the site more you will see recent information and
                      notifications here, in this format.<br> Sometimes you will even be able to reply to posts and accept requests from here.<br>
                      Until then, how about heading over to the Forum to fill this page up?
                      <br><br>
                      <a href="/forum/#"><button class="btn btn-primary">Forum</button></a>
                    </div>
                </div>
          ');