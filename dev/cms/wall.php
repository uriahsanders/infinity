<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/member/check_auth.php');
if ($_SESSION['admin'] != 1) {
    header('Location: /');
    die();
}
include_once($_SERVER['DOCUMENT_ROOT']."/cms/cmsnav.php");
$table = "wall_beta";
?>
<style type="text/css">
html a{ color:#cbc9c9; text-decoration:none;cursor:pointer;}
html a:hover{ color: #ffffff; text-decoration:none;}

        .tooltip {
            outline: none;
            cursor: help; text-decoration: none;
            position: relative;
        }
        .tooltip span {
            margin-left: -999em;
            position: absolute;
        }
        .tooltip:hover span {
            border-radius: 5px 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; 
            box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); -moz-box-shadow: 5px 5px rgba(0, 0, 0, 0.1);
            font-family: Calibri, Tahoma, Geneva, sans-serif;
            position: absolute; left: -18em; top: 2em; z-index: 99;
            margin-left: 0; width: 250px;
            text-align:left;
            padding:10px 20px;
            width:auto;
        }
        .tooltip:hover img {
            border: 0; margin: -10px 0 0 -35px;
            float: left; position: absolute;
        }
        .tooltip:hover em {
            font-family: Candara, Tahoma, Geneva, sans-serif; font-size: 1.2em; font-weight: bold;
            display: block; padding: 0.2em 0 0.6em 0;
        }
        .classic { padding: 0.8em 1em; }
        .custom { padding: 0.5em 0.8em 0.8em 2em; }
        * html a:hover { background: transparent; }
        .classic, .critical, .help, .info, .warning { background: #424c5c; border: 2px solid #4f5a6e; }


body {
    background-color:#2d3035;
    color:white;
    font-family: tahoma;
    padding-bottom:60px;
}
.read_more, .read_less {
 color:#cbc9c9; text-decoration:none;cursor:pointer;
}
.read_less {
    display:none;
}
.read_more:hover, .read_less:hover {
 color: #ffffff; text-decoration:none;
}
#wall {
    width:100%;
}
#wall_tbl{
    margin-left:auto;
    margin-right:auto;
    max-width: 750px;
    font-size:13px;
}
table#wall_tbl_rep {
    width:100%;
    font-size:11px;
    border-spacing:0;
}
table td #wall_tbl_rep_b, table td #wall_tbl_rep_b_f {
    background-color:rgba(0,0,0,.1);
    
}
table td #wall_tbl_rep_b_f {
    border-top: 2px solid rgba(45,48,53,1);
}
.btn_rep {
    position:absolute;
}
.rep_txt {
    line-height:18px;
}
#btn_new {
    height:100%;
}
.btn_del, #btn_new, .btn_rep, .btn_ip {
color:#cbc9c9;
    background-color: #505050;
    background-image: linear-gradient(bottom, #505050 0%, #707070 100%);
    background-image: -o-linear-gradient(bottom, #505050 0%, #707070 100%);
    background-image: -moz-linear-gradient(bottom, #505050 0%, #707070 100%);
    background-image: -webkit-linear-gradient(bottom, #505050 0%, #707070 100%);
    background-image: -ms-linear-gradient(bottom, #505050 0%, #707070 100%);
    background-image: -webkit-gradient(
        linear,
        left bottom,
        left top,
        color-stop(0, #505050),
        color-stop(1, #707070)
    );
    background-position: center top;
    background-repeat: no-repeat;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;
    border-radius: 30px;
    border: 2px solid #808080;
    font: bold 12px Arial, Helvetica, sans-serif;
    text-align: center;
    text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
}
.btn_del:hover, #btn_new:hover, .btn_rep:hover, .btn_ip:hover {
    background-color: #606060;
    background-image: linear-gradient(top, #606060 0%, #808080 100%);
    background-image: -o-linear-gradient(top, #606060 0%, #808080 100%);
    background-image: -moz-linear-gradient(top, #606060 0%, #808080 100%);
    background-image: -webkit-linear-gradient(top, #606060 0%, #808080 100%);
    background-image: -ms-linear-gradient(top, #606060 0%, #808080 100%);
    color:#fff;
    background-image: -webkit-gradient(
        linear,
        left bottom,
        left top,
        color-stop(0, #606060),
        color-stop(1, #808080)
    );
    background-position: center bottom;
}
</style>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
$(document).ready(function () { 
   $('#btn_new').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        post_new();
   });
   $('.btn_del').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        if (confirm("Are you sure you want to delete this post?")) {
            post_del(e.target.id.substring(4));
        }
   });
   $('.btn_rep').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        post_rep(e.target.id.substring(8));
        
   });
    $('.read_more').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        id = e.target.id.substring(10);
        if ($("#more_"+id).is(":hidden")) {
            $("#read_more_"+id).hide();
            $("#more_"+id).show(500);
            $("#read_less_"+id).show();
        }
   });
   $('.read_less').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        id = e.target.id.substring(10);
        if ($("#more_"+id).is(":visible")) {
            $("#read_more_"+id).show();
            $("#more_"+id).hide(500);
            $("#more_"+id).css('display','none');
            $("#read_less_"+id).hide();
        }
   });
   $('.rep_txt').focus(function(e){
        e.preventDefault();
        e.stopPropagation();
        var he = $(this).css('height');
        he = parseFloat(he.substring(0,he.length -2));

        $("#"+e.target.id).animate({
            height: (he + (18*2)) + 'px'
          }, 300, function() {
            $(this).css('resize','vertical');
            $(this).css('max-height','150px');
          });
        
        
   });
   $('.rep_txt').blur(function(e){
        var lines = $(this).val().split(/\r|\r\n|\n/).length;
        lin = lines * 18 + 4;
        
        $("#"+e.target.id).animate({
            height: lin + 'px'
          }, 300, function() {
            $(this).css('resize','none');
          });
   });
});
function post_new() {
    if ($("#txt").val().length < 5) {
        alert("You need to write atleast 5 characters.");
    }else if ($("#txt").val().length > 2000) {
        alert("You have to many characters");
    }else{
        $.ajax({
             type: "POST",
             url: "ajax_<?php echo $table; ?>.php",
             data: { "action" : "add", "txt" : $("#txt").val() },
             success: function (data) {
                 window.location.reload(true);
             }    
        });
    }
}
function post_del(id) {
    $.ajax({
         type: "POST",
         url: "ajax_<?php echo $table; ?>.php",
         data: {"action" : "del", "id" : id },
         success: function (data) {
             window.location.reload(true);
         }    
    });
}
function post_rep(id) {
    $.ajax({
         type: "POST",
         url: "ajax_<?php echo $table; ?>.php",
         data: {"action" : "rep", "id" : id, "txt" : $("#rep_"+id).val()},
         success: function (data) {
         //alert(data);
             window.location.reload(true);
         }    
    });
}
/*
setInterval(function()
{ 
   // get();
}, 10000);//time in milliseconds 
get();
function get() {
$.ajax({
         type: "POST",
         url: "ajax_wall.php",
         data: {"action" : "get"},
         success: function (data) {
             $("#wall").html(data);
             $("#wall").fadeIn(500);
         }    
    });
}*/
</script>
<div id="wall">
        <table id="wall_tbl">
        <tr>
            <td colspan="2">
                <textarea rows="3" cols= "80" style="resize:none" id="txt"></textarea>
            </td>
            <td>
                <input type="button" value="Post update" id="btn_new">
            </td>
        </tr>
        <?php
            $con = mysql_connect(SQL_SERVER,SQL_USR,SQL_PWD) or die(mysql_error());
            $db = mysql_select_db(SQL_DB) or die(mysql_error());
            $con_r = mysql_connect(SQL_SERVER,SQL_USR,SQL_PWD) or die(mysql_error());
            $result = mysql_query("SELECT *,(SELECT image FROM memberinfo WHERE ID=`by`) AS `img` FROM $table WHERE `child`=0 ORDER BY date DESC LIMIT 0,25", $con) or die(mysql_error());
            /*$arr = array();
            for ($i = 0; $i < 20;$i++){
                array_push($arr, $i*20); //380 replies
            }*/
            while($row = mysql_fetch_array($result)) {
                echo "<tr>\n";
                echo "<td>\n";
                echo "<a href=\"/user/".id2user($row['by'], "id2user")."\">" . id2user($row['by'], "id2screen") . "</a>\n";
                echo "</td>\n";
                echo "<td align=\"right\" colspan=\"2\" width=\"500\">\n";
                echo "" . time_diff($row['date']) . "\n";
                echo "</td>\n";
                echo "<td>" . 
                (($row['by'] == $_SESSION['ID']) ? "<span style=\"cursor:default;text-align:center\" class=\"btn_del\" id=\"del_".$row['ID']."\">&nbsp;x&nbsp;</span>\n" : "");
                echo "</td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "<td width=\"75\" valign=\"top\">\n";
                echo "<img src=\"/images/image.php?id=".$row['img']."\" width=\"75\">\n";
                echo "</td>\n";
                echo "<td>\n";
                echo "";
                $len = 500;
                if (strlen($row['txt']) < $len) {
                    echo $row['txt'];
                } else {
                    for ($i = $len;$i<strlen($row['txt']);$i++) {
                        if(substr($row['txt'],$i,1) == " ")
                            break;
                    }
                    echo substr($row['txt'],0,$i) . "<span id=\"read_more_".$row['ID']."\" class=\"read_more\">... Read more</span>";
                    echo "<span id=\"more_".$row['ID']."\" class=\"more\" style=\"display:none;\">".substr($row['txt'],$i)."</span>";
                } 
                
                echo "\n</td>\n";
                echo "</tr>\n";
                echo "<tr>";
                echo "<td></td>";
                echo "<td align=\"right\"><span id=\"read_less_".$row['ID']."\" class=\"read_less\">Hide</span>   ".(($row['by'] == $_SESSION['ID']) ?tooltip("&nbsp;?&nbsp&nbsp&nbsp;","#","We logg you IP for security purpuse<br />Only you and admins can see your IP<br />You can't see other users IP",$row['IP'],"info") : "" )."</td>";              
                echo "</tr>";
                $result2 = mysql_query("SELECT *,(SELECT image FROM memberinfo WHERE ID=`by`) AS `img` FROM $table WHERE `child`='".$row['ID']."' AND `child`>0 ORDER BY date ASC LIMIT 0,3", $con_r) or die(mysql_error());
                $count = mysql_num_rows($result2);
                if ($count > 0) {
                    echo "<tr>\n";
                    echo "<td>\n";
                    echo "</td>\n";
                    echo "<td colspan=2>\n";
                    echo "<table id=\"wall_tbl_rep\">\n"; 
                    $co = 0;
                    while($row2 = mysql_fetch_array($result2)) {
                        $co++;
                        echo "<tr>\n";
                        echo "<td id=\"wall_tbl_rep_b".(($co==1)?"":"_f")."\"d>\n";
                        echo "<a href=\"/user/".id2user($row['by'], "id2user")."\">" . id2user($row['by'], "id2screen") . "</a>\n";
                        echo "</td>\n";
                        echo "<td align=\"right\" colspan=\"2\" id=\"wall_tbl_rep_b".(($co==1)?"":"_f")."\">\n";
                        echo time_diff($row2['date']) . "\n";
                        echo "</td>\n";
                        echo "<td aligment=\"left\" width=\"115\">\n";
                        echo (($row2['by'] == $_SESSION['ID']) ? "<span style=\"cursor:default;text-align:center\" class=\"btn_del\" id=\"del_".$row2['ID']."\">&nbsp;x&nbsp;</span>" : "&nbsp;") . "\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                        echo "<tr>\n";
                        echo "<td id=\"wall_tbl_rep_b\" style=\"padding-bottom:3px; vertical-align:top;\">";
                        echo "<img src=\"/images/image.php?id=".$row2['img']."\" width=\"35\">";
                        echo "</td>\n";
                        echo "<td colspan=\"2\" width=\"820\" id=\"wall_tbl_rep_b\">\n";
                        $len = 300;
                        if (strlen($row2['txt']) < $len) {
                            echo $row2['txt'];
                        } else {
                            for ($i = $len;$i<strlen($row2['txt']);$i++) {
                                if(substr($row2['txt'],$i,1) == " ")
                                    break;
                            }
                            echo substr($row2['txt'],0,$i) . "<span id=\"read_more_".$row2['ID']."\" class=\"read_more\">... Read more</span>";
                            echo "<span id=\"more_".$row2['ID']."\" class=\"more\" style=\"display:none;\">".substr($row2['txt'],$i)."</span>";
                        } 
                        echo "</td>\n";
                        echo "</tr>\n";
                        echo "<tr>";
                        echo "<td id=\"wall_tbl_rep_b\"></td><td id=\"wall_tbl_rep_b\"></td>";
                        echo "<td align=\"right\" id=\"wall_tbl_rep_b\"><span id=\"read_less_".$row2['ID']."\" class=\"read_less\">Hide</span>   ".(($row2['by'] == $_SESSION['ID']) ?tooltip("&nbsp;?&nbsp;","#","We logg you IP for security purpuse<br />Only you and admins can see your IP<br />You can't see other users IP",$row2['IP'],"info") : "" )."</td>";              
                        echo "</tr>";
                    }
                    echo "</table>\n";
                    echo "</td>\n<td></td></tr>\n";
                }
                echo "<tr>\n<td>\n</td>\n<td>\n<textarea rows=\"1\" id=\"rep_".$row['ID']."\" class=\"rep_txt\" style=\"width:90%;resize:none\"></textarea>\n<input type=\"button\" value=\"Reply\" class=\"btn_rep\" id=\"btn_rep_".$row['ID']."\">\n</td>\n<td></td>\n</tr>";
            }
            mysql_close($con);
        ?>
    </table>
</div>