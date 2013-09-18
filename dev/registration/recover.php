<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/top.php'); //DO NOT REMOVE OR CHANGE 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/links.php'); // DO NOT REMOVE OR CHANGE

                                        listlinks("Start"); // CHANGE TO THE ACTIVE LINK

include_once($_SERVER['DOCUMENT_ROOT'].'/libs/middle.php'); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>

<div id="head">
Forgot Username or Password
</div>
<hr>
<div id="Q">
Please enter your email, and we will send you a link to verify your ownership of this account, and recreate your password.
</div>
<br />

<div id="main">
<?php
if(isset($_GET['errormsg']) && $_GET['errormsg'] == "fail"){
    echo "<font color='red'>There was an error please try again.</font>";
}
if(isset($_GET['status']) && $_GET['status'] == "success" && isset($_GET['email'])){
    echo "You have sucessfully sent a recovery email to" . $_GET['email'] . "Please check your email.";
}
if(isset($_GET['status']) && $_GET['status'] == "new"){
    if(isset($_GET['errormsg']) && $_GET['errormsg'] == "fail"){
        echo "<font color='red'>There was an error please try again.</font>";
    }
    echo "<form action='insert.php' method='post'>";
    echo "Password:<input type='password' name='password' maxlength='30' /><br />";
    echo "Retype password:<input type='password' name='password2' maxlength='30' />";
    echo "<input type='submit' value='submit' /><input type='reset' value='reset' />";
    echo "</form>";
    echo "<div style='display:none;'>";
}
?>
<form action="emailcheck.php" method="post">
<p>
<input type="text" name="email" maxlength="50" id="inputemailforgot2" value="Email Address" />
<input type="submit" value="submit" id="startplan" />
</p>
</form>
<?php 
include_once('../libs/bottom.php'); // DO NOT REMOVE OR CHANGE
if(isset($_GET['status']) && $_GET['status'] == "new"){
    echo "</div>";
}
?>
</div>