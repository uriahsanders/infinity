<?php 

include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");
?>
           <div id="mem_main">
            <div id="mem_left_menu">
                <div id="mem_left_menu_bookmarks">
                    <div id="mem_left_menu_headers">Bookmarks</div><div style=" height:6px;"></div>
                    <div id="bookmark_list">
                    
                    
                    
                    <?php
    
$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());

$result = mysql_query("SELECT * FROM bookmarks WHERE `user` = '".$_SESSION['ID']."'")or die(mysql_error());
$num = mysql_num_rows($result);
if($num == 0){
    echo "You haven't bookmarked anything yet.<br />";
}else{
    while($row = mysql_fetch_array($result)){
        $id = $row['user'];
        $url = $row['url'];
        $title = $row['desc'];
        echo '
        <div class="bookmark_list_item">
            <div id="bookmark_list_icon"><img src="/member/images/star.png" />&nbsp;</div>
            <div id="bookmark_list_cont"><a href="'.$row['url'].'">'.$row['desc'].'</a></div>
            <div class="bookmark_list_btns"><img src="/member/images/be.png" height="12px"/><img src="/member/images/b-.png" height="12px" /></div>
        </div>
        ';
        }
}
             ?>       
                    
                    
                        </div>
                        <div id="bookmark_list_scroll">
                     <img src="/member/images/up.png" id="bookmark_scroll_up" /><div id="bookmark_list_space">&nbsp;</div><img src="/member/images/down.png" id="bookmark_scroll_down" />
                    
                      </div>
                </div><div style=" line-height:2px;">&nbsp;</div>
                <div id="mem_left_menu_projects">
                    <div id="mem_left_menu_headers">Projects</div><div style=" height:6px;"></div>
                    <div id="project_list">
                         <div id="project_list_item">
                            <div id="project_list_icon"><img src="/member/images/project.png" />&nbsp;</div>
                            <div id="project_list_cont">Infinity-forum.org</div>
                        </div><div style=" height:6px;"></div><br />
                        <div id="project_list_item">
                            <div id="project_list_icon"><img src="/member/images/project.png" />&nbsp;</div>
                            <div id="project_list_cont">Mastermind Inc</div>
                        </div>
                        <div id="project_list_scroll">
                     <img src="/member/images/up.png" id="project_scroll_up" style="display:none"/><div id="project_list_space">&nbsp;</div><img src="/member/images/down.png" id="project_scroll_down" style="display:none" />
                    </div>
                      </div>
                </div>
                <div id="mem_left_menu_friends">
                    <div id="mem_left_menu_headers">Contacts</div><div style=" height:6px;"></div>
                    
            
                    <div id="friends_list">
                    <?php
                     $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
                     mysql_select_db(SQL_DB) or die(mysql_error());
                     $result = mysql_query("SELECT * FROM friends WHERE id = '$_SESSION[ID]'", $con)or die(mysql_error());
                     if(mysql_num_rows($result) == 0){
                         echo '<div id="friend_list_item">
                                 <div id="friend_list_cont">You have not added any friends yet.</div>
                               </div>';
                     }else{
                         while($row = mysql_fetch_assoc($result)){
                             $friend = $row['friend'];
                             $friend = id2user($friend, "id2user");
                             
                             echo '<div id="friend_list_item">
                                   <div id="friend_list_icon"><img src="/member/images/online.png" />&nbsp;</div>
                                   <div id="friend_list_cont"><a href="/user/'.$friend.'">'.$friend.'</a></div>
                                   </div><div style=" height:6px;"></div><br />';
                         }
                     } 
                  
                    mysql_close($con);
                    ?>
                    </div>
                    <!--
                    <div id="friends_list">
                         <div id="friend_list_item">
                            <div id="friend_list_icon"><img src="/member/images/online.png" />&nbsp;</div>
                            <div id="friend_list_cont">Arty</div>
                        </div><div style=" height:6px;"></div><br />
                        <div id="friend_list_item">
                            <div id="friend_list_icon"><img src="/member/images/online.png" />&nbsp;</div>
                            <div id="friend_list_cont">Jeremy</div>
                        </div><div style=" height:6px;"></div><br />
                        <div id="friend_list_item">
                            <div id="friend_list_icon"><img src="/member/images/online.png" />&nbsp;</div>
                            <div id="friend_list_cont">Uriah</div>
                        </div><div style=" height:6px;"></div><br />
                        <div id="friend_list_item">
                            <div id="friend_list_icon"><img src="/member/images/online.png" />&nbsp;</div>
                            <div id="friend_list_cont">Wabi</div>
                        </div><div style=" height:6px;"></div><br />
                        <div id="friend_list_item">
                            <div id="friend_list_icon"><img src="/member/images/offline.png" />&nbsp;</div>
                            <div id="friend_list_cont">Kulver</div>
                        </div><div style=" height:6px;"></div><br />
                        <div id="friend_list_item">
                            <div id="friend_list_icon"><img src="/member/images/offline.png" />&nbsp;</div>
                            <div id="friend_list_cont">Namespace7</div>
                        </div><div style=" height:6px;"></div><br />
                        <div id="friend_list_item">
                            <div id="friend_list_icon"><img src="/member/images/offline.png" />&nbsp;</div>
                            <div id="friend_list_cont" style="float:left">Halfblood</div>
                        </div><div style=" height:6px;"></div><br />
                        <div id="friend_list_item">
                            <div id="friend_list_icon"><img src="/member/images/offline.png" />&nbsp;</div>
                            <div id="friend_list_cont">Hanorotu</div>
                        </div><div style=" height:6px;"></div>
                      -->                          
                      </div>
                    <div id="friends_list_scroll">
                     <img src="/member/images/up.png" id="friends_scroll_up"/><div id="friend_list_space">&nbsp;</div><img src="/member/images/down.png" id="friends_scroll_down" />
                    </div><div style=" line-height:10px;">&nbsp;</div>
                    &nbsp;<input type="text" style=" width: 200px; height:1.4em;"><div id="mem_left_menu_bottom_buttons">
                    <img src="/member/images/search.png" height="20" width="20" id="mem_left_menu_search"/>&nbsp;&nbsp;
                    <img src="/member/images/pin.png" height="20" width="20" id="mem_left_menu_stick" style=" padding-right:5px;"/>
                </div>
            </div></div>
            <div id="mem_left_show"><img src="/member/images/arrow.png"style="cursor:pointer;" /></div>
         </div>
        <div id="rawr" style="" ><div id="content" style="min-height:1px;"></div>