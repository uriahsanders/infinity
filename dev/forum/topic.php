<?php
include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");


$con = SQL_connect();
$db = SQL_selectDB($con);

if (!isset($_GET['t']) || !preg_match('/([0-9]*)/', $_GET['t'])) {
    include_once($_SERVER['DOCUMENT_ROOT'].'/error/404.htm');
    die();
}
?>

<style type="text/css">

#m_box {
    background: #2d3035;
    color:#8b8e9f;
    border: 1px solid rgba(0,0,0,1);
    border-radius:2px;
    width:140px;
}
.plus, .minus {
    font-weight:bold;
}

</style>
<script>

$(document).ready(function(){
    $(".plus, .minus").click(function(){
        idd = $(this).attr('id');
        id = idd.substring(5);
        $.ajax({
                type: "POST",
                url: "/forum/script.php",
                data: { "action" : $(this).attr('class'), "id": id}    
        }).done(function (data) {
                if (data != "done") {
                    MsgBox("Karma error",data);
                } else {
                    pm = idd.substring(0,1);
                    li = idd.lastIndexOf("_")+1;
                    val = parseInt($(".s"+pm+"_"+idd.substring(li)).html())+1;
                    $(".s"+pm+"_"+idd.substring(li)).html(val);
                }
        });
    });
});

</script>

<?php
$top = cleanQuery($_GET['t']);
$top = 1;
$res = mysql_query("SELECT * FROM `forum` WHERE `ID`='$top'") or die(mysql_error());

if (mysql_num_rows($res) == 0) header("Location: /error/404.htm");

while($row = mysql_fetch_array($res)) {
    echo "\n<div id=\"forum\">\n <div id=\"forum-title\">\n  <table style=\"color:black\">\n";
    echo "   <tr>\n";
    echo "     <td width=\"140\" valign=\"top\"></td>\n";
    echo "     <td align=\"left\">Topic: $row[subject] (Read $row[views] times)</td>\n";
    echo "   </tr></table></div>";
    echo "<table style=\"color:black\">";
}
$res = mysql_query("SELECT *,
                    (SELECT image FROM `memberinfo` WHERE `ID`=forum.by) AS 'image',
                    (SELECT plus FROM `memberinfo` WHERE `ID`=forum.by) AS 'plus',
                    (SELECT minus FROM `memberinfo` WHERE `ID`=forum.by) AS 'minus',
                    (SELECT rank FROM `memberinfo` WHERE `ID`=forum.by) AS 'rank'
                    FROM `forum` WHERE `ID`='$top' or `child_to_t`='$top' ORDER BY `ID` ASC") or die(mysql_error());
                    
                
while ($row = mysql_fetch_array($res)) {
    echo "<tr><td>";
    echo "<table><tr><td align='center'>".id2user($row['by'])."</td></tr>";
    echo "<tr><td align='center' id='m_box'>".$rank_steps[$row['rank']]."</td></tr>";
    echo "<tr><td align='center'><img src='/images/image.php?id=$row[image]' width='100' height='100'></td></tr>";
    echo "<tr><td align='center' id='m_box'>Karma: ".(($row['by'] == $_SESSION['ID']) ? "" : "<a class=\"plus\" id=\"p_ID_$row[ID]_$row[by]\">+</a>")." <span class='sp_$row[by]'>".karma($row['by'])['p']."</span> / ".(($row['by'] == $_SESSION['ID']) ? "" : "<a class=\"minus\" id=\"m_ID_$row[ID]_$row[by]\">-</a>")." <span class='sm_$row[by]'>".karma($row['by'])['m']."</span></td></tr>";
    echo "</table>";
    echo "</td><td width='660' valign='top'>".$row['text']."</td></tr>";
    echo "</td><td colspan='2'><hr style='opacity:0.2; width:100%'></td></tr>";
}






echo "</table></div>";

@mysql_close($con);

?>
<br /><br /><br /><br />