<?php
if (__FILE__ == $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']){
header('Location: /');
  die();
}
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    $result = mysql_query("SELECT * FROM forum_structure") or die(mysql_error());
    mysql_close($con);
    $cat = array(); $sub = array(); $sub2 = array();
    
    while($row = mysql_fetch_array($result)) {
        if ($row['type'] == 0) {
            $temp = array(
                "ID" => $row['ID'],
                "child_to" => $row['child_to'],
                "type" => $row['type'],
                "name" => $row['name'],
                "mods" => $row['mods'],
                "visible_to" => $row['visible_to'],
                "index_" => $row['index_'] 
            );
            array_push($cat,$temp);
        }
        if ($row['type'] == 1) {
            $temp = array(
                "ID" => $row['ID'],
                "child_to" => $row['child_to'],
                "type" => $row['type'],
                "name" => $row['name'],
                "mods" => $row['mods'],
                "visible_to" => $row['visible_to'],
                "index_" => $row['index_'],
                "desc" => $row['desc']              
            );
            array_push($sub,$temp);
        }
        if ($row['type'] == 2) {
            $temp = array(
                "ID" => $row['ID'],
                "child_to" => $row['child_to'],
                "type" => $row['type'],
                "name" => $row['name'],
                "mods" => $row['mods'],
                "visible_to" => $row['visible_to'],
                "index_" => $row['index_']            
            );
            array_push($sub2,$temp);
        }
        
    }
    unset($temp);

    function IndexSort($a, $b) {
        return strcmp($a['index_'], $b['index_']);
    }
    usort($cat, 'IndexSort');
    usort($sub, 'IndexSort');
    usort($sub2, 'IndexSort');
    /*
    TO ADD
    [+] hide categorys ect
    [+] do a small admin cms for strukcture
    [+] design it with all options    
    */
    for ($i = 0; $i < sizeof($cat); $i++) {
        /*echo "\n<div id=\"forum\">\n".
          "  <div id=\"forum-title\">".$cat[$i]["name"]. "\n" .
          "    <div id=\"forum-title-lp\">Last Post</div>\n".
          "    <div id=\"forum-title-p\">Posts</div>\n".
          "    <div id=\"forum-title-t\">Topics</div>\n".
        "  </div>\n  <table style=\"color:black\">\n";*/
          
        echo "<div id=\"forum\"><div id=\"forum-title\"><table style=\"color:black\">
      <tr>
      <td width=\"530\" style=\"font-weight:bold;\" valign=\"top\" colspan=\"2\">".$cat[$i]["name"]."</td>
      <td width=\"60\" align=\"center\">Topics</td>
      <td width=\"60\" align=\"center\">Posts</td>
      <td width=\"140\">Last Post</td>
      </tr></table></div><table style=\"color:black\">";
        $r = 0;
        foreach($sub as $key => $value) {
            if ($cat[$i]["ID"]==$value["child_to"]) {
            $r++;
                if ($r > 1) { echo "    <th colspan=\"5\"><div id=\"forum-line\"></div></th>\n"; }
                echo "    <tr>\n      <td>".
                    "<img src=\"/forum/images/f.png\" width=\"55\"></td>\n".
                    "      <td width=\"480\" style=\"font-weight:bold;\" valign=\"top\">";
                //echo "<a href=\"".urlencode($cat[$i]["name"])."/".urlencode($value['name'])."\">".$value['name']."</a><br />\n        <div style=\"font-weight:normal;\">". $value['desc'];
                echo "<a href=\"/member/?board&b=".$value['ID']."\">".$value['name']."</a><br />\n        <div style=\"font-weight:normal;\">". $value['desc'];
                if ($value['desc'] === "")
                    echo "<br>";
                echo "</div>\n";
                $f = 0;
                foreach($sub2 as $key2 => $value2) {
                    if ($value["ID"]==$value2["child_to"]) { 
                        if ($f == 0) { echo "        <div style=\"font-weight:normal\">\n          <b>subforum:</b>\n            ";$f++;} else { echo ",\n            "; }
                        //    echo "<a href=\"?forum=".urlencode($cat[$i]["name"])."/".urlencode($value['name'])."/".urlencode($value2['name'])."\">".$value2["name"]."</a>"; // Prints the sub category of the sub category :P
                        echo "<a href=\"/member/?board&b=".$value2['ID']."\">".$value2["name"]."</a>"; // Prints the sub category of the sub category :P
                    }
                }
                if ($f>0) { echo "\n        </div>\n"; }
                echo "      </td>\n".
                      "      <td width=\"60\" align=\"center\">10</td>\n".
                      "      <td width=\"60\" align=\"center\">100</td>\n".
                      "      <td width=\"140\">by relax<br />Thu Jan 17, 2013 03:24 pm</td>\n".                
                      "    </tr>\n";
            }
        }
        echo "  </table>\n</div>\n<br />\n";
    }
    ?>