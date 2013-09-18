<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');

if(isset($_GET['add']) && isset($_GET['usr']) && $_GET['usr'] != $_SESSION['usr']){
    $new_friend = id2user($_GET['usr'], "user2id");
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    mysql_query("INSERT INTO friends (id, friend) VALUES ('$_SESSION[ID]', '$new_friend')", $con)or die(mysql_error());
    mysql_close($con)or die(mysql_error());
}

 function check($string){
        if($string == false){
            return "Not available";
        }else{
        return $string;
        }
    }
    
    if (isset($_GET['p']) || isset($_GET['m'])) {
        
            $woot = (isset($_GET['p']) ? "p" : "m");
            $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
            mysql_select_db(SQL_DB) or die(mysql_error());
            $user = (isset($_GET['usr'])) ?  cleanQuery($_GET['usr']) : "";
            if ($user != "") {
                $result = mysql_query("SELECT * FROM memberinfo WHERE username = '$user'", $con)or die(mysql_error());
                
            while($row = mysql_fetch_assoc($result)){
               $new = ($woot == "p") ? $row['plus']+1 : $row['minus']+1;
               mysql_query("UPDATE memberinfo SET ".(($woot=="p") ? "`plus`='$new'" : "`minus`='$new'")." WHERE username = '$user'", $con)or die(mysql_error());
            }
            mysql_close($con);
        }
        }
    
    
                $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
                mysql_select_db(SQL_DB) or die(mysql_error());
                $user = (isset($_GET['usr'])) ?  cleanQuery($_GET['usr']) : $_SESSION['usr'];
                
                $retrieve = mysql_query("SELECT * FROM memberinfo WHERE username = '$user'",$con);
                $num = mysql_num_rows($retrieve);
                
                if ($num === 0)
                    echo "$user could not be found";
                else {
                
                while($row = mysql_fetch_array($retrieve)){
                    $aid = $row['ID'];
                    $gender = check($row['sex']);
                    $location = check($row['location']);
                    $country = check($row['country']);
                    $user_website = check($row['wn']);
                    $user_website_url = check($row['wURL']);
                    $user_website_description = check($row['wd']);
                    $description = check($row['about']);
                    $age = check($row['age']);
                    $portfolio = check($row['portfolio']);
                    $interests = check($row['interests']);
                    $skills = check($row['skills']);
                    $screenname = check($row['screenname']);
                    $resume = check($row['resume']);
                    $img = check($row['image']);
                    $signature = check($row['signature']);
                    $plus = $row['plus'];
                    $minus = $row['minus'];
                }
                
                echo "
                    <div style=\"background-color:#565a64; width:900px; -webkit-border-radius: 5px; 
                                -moz-border-radius: 5px;border-radius: 5px; border: .1em solid rgba(0,0,0, .7); padding-bottom:10px;
                                margin-left:auto; margin-right:auto;
                                position:relative;min-height:400px; font-family:Tahoma;\">
                        <div id=\"prof_top\" style=\"width:100%;padding:10px; 
                                                position:relative; min-height:200px\">
                            <div style=\"float:left; width:202px;\">
                                <img src=\"/images/image.php?id=$img \" height=\"200\" width=\"200\" style=\"-webkit-border-radius: 2px; 
                                                -moz-border-radius: 2px;border-radius: 2px; border: .1em solid rgba(0,0,0, .2);\">
                            </div>
                            <div style=\"float:left; padding-right:20px; padding-left:10px;height:200px;\">
                                <div style=\"padding-left:60px;overflow:hidden; height:170px; width:485px;\"><b>About:</b><br>$description
                                </div>
                                <div style=\"height:30px;font-size:30px; font-weight:bold;\">$screenname
                                </div>
                            </div>
                        </div>
                        
                        <div id=\"prof_bottom\" style=\"width:100%; position:relative;min-height:200px; display:inline-block\">
                        <table style=\"width:100%;height:100%; min-height:200px;\">
                        <tr>
                        <td width=\"33%\" style=\"background-color:rgba(65,69,77,1);\">
                        <table width=\"100%\" height=\"100%\">
                                <tr>
                                <td style=\"font-weight:bold; width: 30px;\">Age:</td><td> $age<td>
                                </tr>
                                <tr>
                                <td style=\"font-weight:bold; width: 30px;\">Gender:</td><td> $gender<td>
                                </tr>
                                <tr>
                                <td style=\"font-weight:bold; width: 30px;\">From:</td><td> $country<td>
                                </tr>
                                <tr>
                                <td style=\"font-weight:bold; width: 30px; vertical-align: top\">Interests:</td><td> $interests<td>
                                </tr>
                                <tr>
                                <td style=\"font-weight:bold; width: 30px;\">Reputation:</td><td> +$plus/-$minus";
                                if(isset($_GET['usr']) && $_GET['usr'] != $_SESSION['usr']){ 
                                    echo "&nbsp;&nbsp;<a href='/user/".$user."/p'>[Praise]</a> <a href='/user/".$user."/m'>[Scorn]</a>"; 
                                }
                                echo "            
                                </td>
                                </tr>
                                <tr>
                                <td style=\"font-weight:bold; width: 30px;\">Website:</td><td> <a href=\"$user_website_url\" target=\"_blank\">$user_website</a><td>
                                </tr>
                                </table>
                        </td>
                        <td width=\"33.8%\" style=\"background-color:rgba(65,69,77,1);\">
                        <table width=\"100%\">
                                <tr>
                                <td style=\"font-weight:bold; width: 30px; vertical-align: top\">Skills:</td><td> $skills<td>
                                </tr>
                                <tr>
                                <td style=\"font-weight:bold; width: 30px;\">Resume:</td><td><a href=\"$resume\">Resume</a><td>
                                </tr>
                                <tr>
                                <td style=\"font-weight:bold; width: 30px;\">Portfolio:</td><td><a href=\"$portfolio\">Portfolio</a><td>
                                </tr>
                                <tr>
                                <td style=\"font-weight:bold; width: 30px; vertical-align: top\">Signature:</td><td>$signature<td>
                                </tr>
                                </table>
                        </td>
                        <td style=\"background-color:rgba(65,69,77,1);\">
                        <table width=\"100%\" height=\"100%\">
                                <tr>
                                    <td colspan=\"2\" style=\"font-weight:bold; width: 30px;\">Last Activity:</td>
                                </tr>";
                                foreach(lastactiv($aid) as $key => $value){
                                    echo "<tr style=\"font-size:8pt\">";
                                    echo "<td>"; 
                                    echo ($value['child_to_t'] == 0) ? "Posted " : "Replied to ";
                                    echo $value['subject'];
                                    echo "</td>";
                                    echo "<td width=\"80px\" align=\"right\"> ".date('j/n/y H:i',strtotime($value['date']))." </td>";
                                    echo "</tr>";
                                }
                          echo "<tr>
                                    <td> </td>
                                
                                </tr>
                                </table>
                        </td>
                        </tr>
                        </table>
                        </div>";
                        if(isset($_GET['usr']) && $_GET['usr'] != $_SESSION['usr']){ 
                                  $usr = $_GET['usr'];
                                  echo " 
                        <table style='font-size:1.3em;padding-right:50px;'>
                        <tr>";
                        
                            
                        echo "
                        <td><a href='/user/".$usr."/add'>Add</a></td>
                        </tr>
                        </table>";
                        }
                        
                    
                      echo "</div>";
                
                
                }


?>