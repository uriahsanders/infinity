<?php 
    define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "about"); // this is what page it is, for the links at the top
    include_once("libs/relax.php"); // use PATH from now on
    include_once(PATH ."core/top.php");
    include_once(PATH ."core/top.php");
    if(defined("PAGE") && PAGE == "start") 
    {
        include_once(PATH ."core/slide.php");
    }
    include_once(PATH ."core/bar_main_start.php");
?>
<script type="text/javascript" src="/js/about.js"></script>
<script> var token = "<?php echo $token; ?>";
<?php
    if (isset($_GET['status'])) {
        echo "$(document).ready(function(e) {";
             switch($_GET['status']) {
                case "thanks":
                     echo 'MsgBox("Thank you.","Thank you for contacting us; we will get back to you as soon as possible.",0);';
                     break;
                case 1:
                     echo 'MsgBox("Ooops :(.","Seems like your subject is a little short there.",3);';
                     break;
                case 2:
                     echo 'MsgBox("OMG","That is not an email dude or babe. Whatever you are, that is not cool.",3);';
                     break;
                case 3:
                     echo 'MsgBox("Hmmm...","Wouldn\'t it be nicer if you wrote a longer message to us? We promise we will read it.",3);';
                     break;
                case 4:
                     echo 'MsgBox("HACKER!!!","We are sorry but we try to deny Hackers access to our server, we apologize if this is an inconvenience for you.",3);';
                     break;
                case 5:
                     echo 'MsgBox("Error","Please contact us at support@infinity-forum.org. Make sure you include error code: 666 in the mail.",3);';
                     break;
             }             
        echo "});";
    }
?>
</script>
<br /> 
            <div class="btn_box" id="boxiz">
            <div id="mnu_left" data="About">
            <ul>
                <?php
            
                
                $sql = new SQL(); 
                $res = $sql->Query("SELECT * FROM about") or die(mysqli_error($sql->CON));
                while($row = mysql_fetch_array($res)){
                    echo "<li id=\"$row[ID]\" ".(($row['ID']==1)?"active":"").">$row[subject]</li>\n";
                    if ($row['ID']==1)
                        $welcome = $row['text'];
                }
                ?>
            </ul>
            </div>
            <div id="mnu_main">
                <?php
                    echo @$welcome;    
                ?>
            </div>
            </div>
            <br /><br />
<?php
include_once(PATH ."core/main_end_foot.php");
?>