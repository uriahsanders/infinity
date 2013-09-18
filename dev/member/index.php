<?php
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
include_once($_SERVER['DOCUMENT_ROOT']."/member/m_top.php");
include_once($_SERVER['DOCUMENT_ROOT']."/member/m_side.php");
?>
            <?php 
            
            if (isset($_GET['forum'])) {
                include_once($_SERVER['DOCUMENT_ROOT'].'/forum/index.php');
            } else if (isset($_GET['board'])) {
                include_once($_SERVER['DOCUMENT_ROOT']."/forum/board.php");            
            } else if (isset($_GET['topic'])) {
                include_once($_SERVER['DOCUMENT_ROOT']."/forum/topic.php");  
            } else if (isset($_GET['projects'])){
                //include_once('');
            }else if (isset($_GET['freelancing'])){
                //include_once('');
            }else if (isset($_GET['mail'])){
                //include_once('');
            }else if (isset($_GET['chat'])){
                //include_once('');
            }else if (isset($_GET['options'])){
                //include_once('');
            }else if (isset($_GET['help'])){
                //include_once('');
            }else {
               
               include_once($_SERVER['DOCUMENT_ROOT'].'/member/profile.php');
               echo "<br /><center>Temporary link to the memberlist: <a href='/member/memberlist.php'>Member List</a></center>";
            }
            
            ?>
            
            
<?php
include_once($_SERVER['DOCUMENT_ROOT']."/member/m_bottom.php");
?>