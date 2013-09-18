<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/member/check_auth.php');
 if (isset($_POST['edit'])) {
    //POST CODE
    $con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    mysql_select_db(SQL_DB) or die(mysql_error());
    //$y = cleanQuery($_POST['y']);
    //$m = cleanQuery($_POST['m']);
    //$d = cleanQuery($_POST['d']);
    $age = cleanQuery($_POST['age']);
    //$location = cleanQuery($_POST['location']);
    $country = cleanQuery($_POST['country']);
    $signature = cleanQuery($_POST['signature']);
    $wn = cleanQuery($_POST['wn']);
    //$wd = cleanQuery($_POST['wd']);
    //$rpURL = cleanQuery($_POST['rpURL']);
    $wURL = cleanQuery($_POST['wURL']);
    $about = cleanQuery($_POST['about']);
    $portfolio = cleanQuery($_POST['portfolio']);
    $interests = cleanQuery($_POST['interests']);
    $skills = cleanQuery($_POST['skills']);
    $resume = cleanQuery($_POST['resume']);
    $sex = (isset($_POST['sex'])) ? ($_POST['sex'] == "Male") ? "Male" : "Female" : "";
    $SQL = "UPDATE memberinfo SET sex = '$sex', country = '$country', signature = '$signature', about = '$about', age = '$age', wn = '$wn', portfolio = '$portfolio', interests = '$interests', skills = '$skills', resume = '$resume' WHERE username = '$_SESSION[usr]'";
    $result = mysql_query($SQL)or die(mysql_error());  
    mysql_close($con);
    header('Location: /accsummary.php');
 }
 
include_once($_SERVER['DOCUMENT_ROOT'].'/profiletop.php'); //DO NOT REMOVE OR CHANGE 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/links.php'); // DO NOT REMOVE OR CHANGE
listlinks("Infinity"); // CHANGE TO THE ACTIVE LINK

include_once($_SERVER['DOCUMENT_ROOT'].'/libs/middle.php'); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS ?>
<center><div><a href="/accsummary.php">Summary</a> | <a href="/generalsettings.php">General Settings | <a href="/accsettings.php">Account Settings</a> | <a href="/acclook.php">Look & Layout</a> | <a href="/member/pm/">Mail</a></div></center>
 
<?php 
$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());
$result = mysql_query("SELECT * FROM memberinfo WHERE username = '".$_SESSION['usrdata']['screenname']."'")or die(mysql_error());
while($row = mysql_fetch_array($result)){
$age = $row['age'];
$country = $row['country'];
$signature = $row['signature'];
$wURL = $row['wURL'];
$website = $row['wn'];
$sex = $row['sex'];
$about = $row['about'];
$skills = $row['skills'];
$interests = $row['interests'];
$resume = $row['resume'];
$portfolio = $row['portfolio'];
echo '
<br /><br />

    <div id="box">
    <div id="head">General Settings</div>
    <hr>
    Here you can select what information about yourself you would like to be visible to other members of Infinity-forum.org.
    No information is required, you may provide it at your own discretion.</div>
    <br /><br /><br /><br /><br /><br /><br /><br />
    
    <div id="main">
    
    <b>Upload an avatar:</b><br /><br />
    <table border="1">
            ';
            include_once($_SERVER['DOCUMENT_ROOT'].'/test/upload/upload.php');
            echo '
    <hr>
    <br /><br />
    <form method="post" action="">
    <input type="hidden" name="edit">
    If your resume has its own website, enter the URL here:<br /><br />
        <input type="text" id="c"size="30" name="resume"value="'.$resume.'"placeholder="http://www." />
    <br /><br /><hr>
    If your portfolio has its own website, enter the URL here:<br /><br />
        <input type="text" id="c"size="30" name="portfolio"value="'.$portfolio.'"placeholder="http://www." />
    <br /><br /><hr>
    <b>Choose your gender:</b><br /><br />
    
        <input type="radio" name="sex" value="Male" id="sexM" />Male<br><br>
        <input type="radio" name="sex" value="Female" id="sexF"  />Female
        

    <br /><br />
    <b>How old are you?</b><br /><br />
        <input type="text"name="age" id="c" size="30" value="'.$age.'"/>
    <br /><br />
    <b>Country?</b><br /><br />
        <input type="text"id="c" size="30" name="country" value="'.$country.'" /><br /><br />
    <b>Display a signature that other members can see on your profile and posts:</b><br /><br />
    <input type="text"id="c"size="30" name="signature" value="'.$signature.'"/>
    <br /><br />
    <b>[If you have your own website or blog, fill out the information below:]</b>
    <br /><br />
    <b>Website Name:</b><br /><br />
    <input type="text"id="c"size="30" name="wn"value="'.$website.'" />
    <br /><br />
    <b>Website URL:</b><br /><br />
    <input type="text"id="c"size="30" name="wURL"value="'.$wURL.'"placeholder="http://www." />
    <br /><br />
    <hr>
    <b>Tell the others of Infinity-forum about yourself!</b><br /><br />
    
    <textarea rows="10" columns="35" style="border-radius: 5%;" name="about">'.$about.'</textarea>
    <br /><br />
        <b>What Skills do you have?</b><br /><br />
        <textarea rows="10" columns="35" style="border-radius: 5%;" name="skills">'.$skills.'</textarea>
    <br /><br />
    <b>What are your interests?</b><br /><br />
        <textarea rows="10" columns="35" style="border-radius: 5%;" name="interests">'.$interests.'</textarea><br /><br />
        <input type="hidden" value="submit" />
        <input type="submit" value="Save Changes" id="startplan"/>        
        </form>
    <br /><br /><br /><br />
    
</div>
        <script>
            ' . (($sex == "Male") ? 'document.getElementById("sexM").checked=true;' : '') . '
            ' . (($sex == "Female") ? 'document.getElementById("sexF").checked=true;' : '') . '
        </script>
';
mysql_close($con);
}

?>

<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>


    









