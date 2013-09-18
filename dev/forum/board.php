<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    if (isset($_GET['b'])&& preg_match('/^([0-9]*)$/', $_GET['b'])) { //
    
        //$string = $_GET['b'];
        //$string = htmlspecialchars($string);
    $bid = cleanQuery($_GET['b']);
echo $bid;
        // $bid = $string;
    } else {
        include_once($_SERVER['DOCUMENT_ROOT'].'/error/404.htm');
        die();
    }
    
    $start = 0;
    $end = 25;
    if (isset($_GET['page']) && preg_match("/([\d]*)/",$_GET['page']) ) {
        $start = intval($_GET['page']) * 25 - 25;
        $end = intval($_GET['page']) * 25;
    }
    //$result = mysql_query("SELECT * FROM forum WHERE child_to_t=0 AND child_to_b='".$bid."' ORDER BY sticky DESC, date DESC") or die(mysql_error()); 
    $result = mysql_query("SELECT * FROM forum WHERE child_to_t=0 AND child_to_b=".$bid." ORDER BY sticky DESC, date DESC LIMIT ".$start.", ".$end) or die(mysql_error());
    mysql_close($con);
    $disp = mysql_num_rows($result);
    if ($disp == 0)
    {
        include_once($_SERVER['DOCUMENT_ROOT'].'/error/404.htm');
        die();
    }
    $result_list = array();
    $stick = 0; 
    while($row = mysql_fetch_array($result)) { 
        array_push($result_list, $row); 
        if ($row['sticky']==1) 
            $stick++;
            
    }
    
    echo "\n<div id=\"forum\">\n <div id=\"forum-title\">\n  <table style=\"color:black\">\n";
    echo "   <tr>\n";
    echo "\t<td width=\"15\"></td>\n";
    echo "     <td width=\"455\" style=\"font-weight:bold;\" valign=\"top\" colspan=\"2\">Subject</td>\n";
    echo "\t<td width=\"30\"></td>";
    echo "     <td width=\"130\" align=\"center\">Replies/Views</td>\n";
    echo "     <td width=\"185\">Last Post</td>\n";
    echo "   </tr>\n  </table>\n </div>\n";
      
    if ($stick > 0) 
        echo " <table style=\"color:black; background-color: rgba(45,48,53,0.4);\">\n";
    else 
        echo " <table style=\"color:black\">\n";
    
    $r = 0;
    foreach($result_list as $row) {
        $r++;
        if ($r > 1) { echo "    <th colspan=\"5\">\n     <div id=\"forum-line\"></div>\n    </th>\n"; }
        
        echo "    <tr>\n";
        if ($stick > 0 && $stick+1 == $r)
             echo "    <table style=\"color:black\">\n";
        
       $rep = getThreadInfo($row['ID'],$bid, "r");
        $re = getThreadInfo($row['ID'],$bid, "re");
        $ico = ($rep >= 20) ? 1 : 0;
        $ico = ($re > 0) ? $ico + 10 : $ico;
        echo "";
        if ($stick > 0 && $r == 1)
            echo "<td width=\"28\"><img src=\"/forum/images/bolt.png\" style=\"position:absolute;margin-top:-14px;margin-left:-3px;\"><img src=\"/forum/images/".$ico.".png\"></td>\n";
        else if ($stick > 0 && $stick == $r)
            echo "<td width=\"28\"><img src=\"/forum/images/bolt.png\" style=\"position:absolute; margin-top:22px;margin-left:-3px;\"><img src=\"/forum/images/".$ico.".png\"></td>\n";
        else
            echo "<td width=\"28\"><img src=\"/forum/images/".$ico.".png\"></td>";

        echo "    <td width=\"405\"><b><a href=\"/member/?topic&b=".$bid."&t=".$row['ID']."\" style='color:black'>".$row['subject']."</a></b><br />\n";
        $u = getUsrName($row['by']);
        echo "    started by: <a href=\"/user/".$u."\">". $u."</a>\n";
        echo "   </td>\n";
        echo "<td align=\"right\" width=\"40\">";
        
        echo ($row['locked'] == 1) ? "<img src=\"/forum/images/l.png\">&nbsp;&nbsp;&nbsp;" : "";
        echo ($row['sticky'] == 1) ? "<img src=\"/forum/images/s.png\">" : "";
        
        echo "</td>";
        echo "   <td width=\"120\" align=\"center\">\n";
        echo "    <table style='width:120px'>\n     <tr>\n";
        echo "      <td align=\"right\">".$rep."</td>\n";
        echo "      <td width=\"60%\">Replies</td>\n     </tr>\n";
        echo "     <tr>\n      <td align=\"right\">".getThreadInfo($row['ID'],$bid, "v")."</td>\n";
        echo "      <td>Views</td>\n     </tr>\n    </table>\n";
        echo "    </td>\n";
        $dda = getThreadInfo($row['ID'],$bid, "lp");
        if ($stick > 0 && $r == 1){
            echo "     <td width=\"185\">\n<div style=\"text-align:right; width:93%\">\n";
            echo "      <img src=\"/forum/images/bolt.png\" style=\"position:absolute;margin-top:-8px; margin-left:2px;\">\n</div>by <a href=\"/member/u/".$dda[0]."\">".$dda[0]."</a>\n";
            echo "      <a href=\"/member/?b=".$bid."&t=".$row['ID']."#".$dda[2]."\"> \n";
            echo "<img border=\"0\" src=\"/forum/images/goto.png\"></a><br>\n";
            echo "     </div></div>\n";
        } else {
            echo "     <td width=\"185\">\n      by <a href=\"/user/".$dda[0]."\">".$dda[0]."</a>\n";
            echo "      &nbsp;&nbsp;&nbsp;\n";
            echo "      <a href=\"/member/?topic&b=".$bid."&t=".$row['ID']."#".$dda[2]."\"> \n";
            echo "      <img border=\"0\" src=\"/forum/images/goto.png\"></a><br />\n";
        }
        echo "      " . $dda[1] . "\n";
        if ($stick > 0 && $stick == $r){
            echo "     <br>\n     <div style=\"width:93%; text-align:right;\">\n";
            echo "      <img src=\"/forum/images/bolt.png\" style=\"position:absolute;margin-top:-4px; margin-left:2px;\">\n     </div>\n";
    }
        echo "    </td>\n";               
        echo "   </tr>\n";
                      
        if ($stick > 0 && $stick == $r)
            echo "   </table>\n";           
        }
echo "  </table>\n</div>\n<br />\n";
    if ($start > 0) {
    echo "<a href='?board&page=".(($start / 25))."'><< pref</a>";
    }
    if ($disp == 25) {
    echo "<a href='?board&page=".(($end / 25)+1)."'>next >></a>";
    }/**/
?>