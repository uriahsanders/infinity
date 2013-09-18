<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
define("PAGE", "start"); // this is what page it is, for the links at the top
include_once("libs/relax.php"); // use PATH from now on
include_once(PATH ."core/top.php");
include_once(PATH ."core/slide.php");
include_once(PATH ."core/bar_main_start.php");
?>
        <br />
            <div class="btn_box" id="boxiz">
            <div id="mnu_left" data="News">
            <ul>
                <?php
                $sql = new SQL(); 
                $res = $sql->Query("SELECT * FROM news ORDER BY date DESC LIMIT 8");
                while($row = mysql_fetch_array($res)){
                    echo "<li id=\"$row[id]\" ".(($row['id']==0)?"active":"").">$row[subject]</li>\n";
                    if ($row['id']==0)
                        $welcome = $row;
                }
                ?>
            </ul>
            </div>
            <div id="mnu_main">
                <?php
                    echo @$welcome['text'];
                ?>
            </div>
            </div><br /><br />
<?php
include_once(PATH ."core/main_end_foot.php");
?>