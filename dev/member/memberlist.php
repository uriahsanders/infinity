<?php
include_once($_SERVER['DOCUMENT_ROOT']."/member/m_top.php");
include_once($_SERVER['DOCUMENT_ROOT']."/member/m_side.php");

               //MEMBER LIST Rank and Reputation are hardcoded atm
               $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
               mysql_select_db(SQL_DB) or die(mysql_error());
               $result = mysql_query("SELECT * FROM memberinfo");
               echo "<center><h1>Infinity-Forum Member List</h1></center><hr />";
               echo "<div style=\"background-color:#565a64; width:900px; -webkit-border-radius: 5px; 
                                -moz-border-radius: 5px;border-radius: 5px; border: .1em solid rgba(0,0,0, .7);
                                margin-left:auto; margin-right:auto;
                                position:relative;font-family:Tahoma;
               
               \">
               <table cellspacing='10'>
               <tr><th width='900'><u>Username:</u></th>
               <th width='950'><u>Screenname:</u></th>
               <th width='950'><u>Rank:</u></th>
               <th width='950'><u>Reputation:</u></th>
               <th width='950'><u>Last Login:</u></th>
               <th width='950'><u>Join Date:</u><th>
               <th width='950'><u>Status:</u></th>
               </tr>
               </div>
               ";
               while($row = mysql_fetch_array($result)){
                   $name = $row['screenname'];
                   $username = $row['username'];
                   $plus = $row['plus'];
                   $minus = $row['minus'];
                   $rank = $rank_steps[$row['rank']];
                   $id = $row['ID']; 
               echo "
               <tr>
                   <td><a href='/member/?usr=".$username."'>".$username."</a></td>
                   <td>".$name."</td>
                   <td>".$rank."</td>
                   <td>+".$plus."/-".$minus."</td>
                   <td>".$row['last_login']."</td>
                   <td>".$row['reg_date']."</td>";
                   $getstatus = mysql_query("SELECT * FROM status")or die(mysql_error());
                    while($row2 = mysql_fetch_array($getstatus)){
                       $stat = $row2['status'];
                       $usrid = $row2['id'];
                       if($stat == 3) $statname = "online";
                       else if($stat == 2) $statname = "away";
                       else if($stat == 1) $statname = "busy";
                       else $statname = "offline";
                   }
                   $arr = array();
                   array_push($arr, $statname);
                   $i = 0;
                   while($i != count($arr)){
                       echo "<td>".$arr[$i]."</td></tr>";
                       $i++;
                   }
             }
                   
               
               
            
            
            

include_once($_SERVER['DOCUMENT_ROOT']."/member/m_bottom.php");
?>