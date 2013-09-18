<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");
include_once($_SERVER['DOCUMENT_ROOT']."/profiletop.php"); //DO NOT REMOVE OR CHANGE 
include_once($_SERVER['DOCUMENT_ROOT']."/libs/links.php"); // DO NOT REMOVE OR CHANGE
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
listlinks("Infinity"); // CHANGE TO THE ACTIVE LINK

include_once($_SERVER['DOCUMENT_ROOT']."/libs/middle.php"); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>
    <center><div><a href="/accsummary.php">Summary</a> | <a href="/generalsettings.php">General Settings | <a href="/accsettings.php">Account Settings</a> | <a href="/acclook.php">Look & Layout</a> | <a href="/member/pm/">Mail</a></div></center>
<br /><br />
    <div id="main">
    <?php
if (isset($_POST['css'])) {
    if (!preg_match('(dark|darkblue|redblack|whitebrown)', $_POST['css'])) {
        logg_act();
        echo '<p id="suspicious_error">Your IP address has been logged due to suspicious activity.</p>';
   } else {
        $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
        mysql_select_db(SQL_DB) or die(mysql_error());
        $css = cleanQuery($_POST['css']);
        $SQL = "UPDATE memberinfo SET css = '$css' WHERE username = '$_SESSION[usr]'";
        mysql_query($SQL, $con)or die(mysql_error());
    }
}?>
<br /><br />
            <div style="background-color:#565a64; width:900px; -webkit-border-radius: 5px; 
                                -moz-border-radius: 5px;border-radius: 5px; border: .1em solid rgba(0,0,0, .7);
                                margin-left:auto; margin-right:auto;
                                position:relative;font-family:Tahoma;
               
               ">
               <table style='text-align:center;'cellspacing='10' >
               <form method="post" action="">
                   <tr>
                       <th>Select your favorite theme</th>
                   </tr>
                   <tr>
                       <td>
                           <select name="css" style="background: #757987; border-radius: 3px 3px 3px 3px;">
                                <option value="dark">Dark</option>
                                <option value="darkblue">Darkblue</option>
                                <option value="redblack">Redblack</option>
                                <option value="whitebrown">White Brown</option>
                            </select>
                       </td>
                   </tr>
               </form>
               </table>
               </div>
            
</div>


<?
include_once('libs/bottom.php'); // DO NOT REMOVE OR CHANGE
    ?>
