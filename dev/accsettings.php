<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/profiletop.php"); //DO NOT REMOVE OR CHANGE 
include_once($_SERVER['DOCUMENT_ROOT']."/libs/links.php"); // DO NOT REMOVE OR CHANGE
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");

listlinks("Infinity"); // CHANGE TO THE ACTIVE LINK

include_once($_SERVER['DOCUMENT_ROOT']."/libs/middle.php"); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>
    <center><div><a href="/accsummary.php">Summary</a> | <a href="/generalsettings.php">General Settings | <a href="/accsettings.php">Account Settings</a> | <a href="/acclook.php">Look & Layout</a> | <a href="/mail.php">Mail</a></div></center> 
    <br />
<?php

    $user = $_SESSION['screenname'];
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    $result = mysql_query("SELECT * FROM members WHERE username = '$_SESSION[usr]'", $con)or die(mysql_error());
    while($row = mysql_fetch_assoc($result)){
    $email = $row['email'];
    
               echo "<div style=\"background-color:#565a64; width:900px; -webkit-border-radius: 5px; 
                                -moz-border-radius: 5px;border-radius: 5px; border: .1em solid rgba(0,0,0, .7);
                                margin-left:auto; margin-right:auto;
                                position:relative;font-family:Tahoma;
               
               \">
               <form method='post' action=''>
                   <table cellspacing='10'>
                       <tr>
                           <td><b>New Screen Name</b></td><td><input name='newscreen'type='text'value='$user' style='border-radius:4px 4px 4px 4px;' ></td><td> </td><td><b>Hide contact information?</b></td><td><input type='checkbox' /></td>
                       </tr>
                       <tr>
                           <td><b>New Email</b></td><td><input name='newemail'type='text'value='$email' style='border-radius:4px 4px 4px 4px;'></td><td></td><td><b>Recieve news emails from Infinity?</b></td><td><input type='checkbox' /></td>
                       </tr>
                       <tr>
                           <td><b>New Password</b></td><td><input name='newpassword'type='password' style='border-radius:4px 4px 4px 4px;'></td><td> </td><td><b>Recieve emails of other members activities?</b></td><td><input type='checkbox' /></td>
                       </tr>
                       <tr>
                           <td><b>Verify New Password</b></td><td><input name='newpassword2'type='password' style='border-radius:4px 4px 4px 4px;'></td><td></td>
                       
                       </tr>
                       <tr>
                           <td><b>* Current Password</b></td><td><input name='password'type='password' style='border-radius:4px 4px 4px 4px;'></td><td></td><td><input type='submit'id='startplan'value='Change Settings' /></td>
                       </tr>
                   </table>
               </form>
               <table cellspacing='10'style='background-color:rgba(65,69,77,1);'>
                   <tr>
                       <td>For security reasons, you must enter your current password to make any changes.</td></tr>
                   <tr><td>A verification email will be sent before anything is altered.</td>
                   </tr>
                   <tr>
                       <td>* Denotes a required field.</td>
                   </tr>
               </table>
               </div>
               ";
          }    
            mysql_close($con);
    if(isset($_POST['submit'])){        
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    $new_screen = cleanQuery($_POST['newscreen']);
    if($new_screen == ""){
        $new_screen = mysql_query("SELECT * FROM memberinfo WHERE username = '$_SESSION[usr]'");
    }else{
        $new_screen = cleanQuery($_POST['newscreen']);
    }
    $new_email = cleanQuery($_POST['newemail']);
    if($new_email == ""){
        $new_email = mysql_query("SELECT * FROM members WHERE username = '$_SESSION[usr]'");
    }else{
        $new_email = cleanQuery($_POST['newemail']);
    }
    $new_password = cleanQuery($_POST['newpassword']);
    $verify_new_password = cleanQuery($_POST['newpassword2']);
    if($new_password == "" && $verify_new_password == ""){
        $new_password = mysql_query("SELECT * FROM members WHERE username = '$_SESSION[usr]'");
    }else{
        $new_password = cleanQuery($_POST['newpassword']);
    }
    $current_password = cleanQuery($_POST['password']);
    $sessionpwd = mysql_query("SELECT * FROM members WHERE username = '$_SESSION[usr]'");
    if($new_password != $verify_new_password){
        echo '<br /><br /><span style="color:red;">The two new passwords you entered were not the same.</span>';
    }else if($current_password != $sessionpwd){
        echo '<br /><br /><span style="color:red;">The password you entered was incorrect.</span>';
    }else if($current_password == ""){
        echo '<br /><br /><span style="color:red;">You need to submit your current password to make any changes.</span>';
    }else{
        mysql_query("UPDATE members SET email = '$new_email', password = '$new_password' WHERE username = '$_SESSION[usr]'", $con)or die(mysql_error());
        mysql_query("UPDATE memberinfo SET screenname = '$new_screen' WHERE username = '$_SESSION[usr]'", $con)or die(mysql_error());
        mysql_close($con);
    }
    } 
include_once('libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>
