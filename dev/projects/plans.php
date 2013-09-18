<?php 
include_once('../libs/top.php'); //DO NOT REMOVE OR CHANGE 
include_once('../libs/links.php'); // DO NOT REMOVE OR CHANGE

                                        listlinks("Projects"); // CHANGE TO THE ACTIVE LINK

// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>

<a href="/index.php"><div id="smalllogo"></div><div id="smalltext"></div></a>
</div>
<div id="plansall">
<div id="planhead"><a href="plans.php">Plans</a></div>
<!--<div id="main" style="width:100%; padding-right: 0px">-->
<?php
include('nav.php');
?>
<hr style="width:500px;" />
<div id="window">
    <span id="viewplan"><a>View Created Plans</a></span>
    <br /><br /><br />
    <span id="createplan"><a>Create New Plan</a></span>
</div>
<div id="branch" style="display: none;">
    <h1>Welcome!</h1>
    <hr />
    <p>We are going to begin requesting criteria about your project. When we are finished, you will see a detailed and well
    formatted plan of your project.These plans will help you organize your thoughts, as well as help others better understand your vision.
    Please make your answers as detailed as possible.<br /> Click "Start" to begin.</p>
    
    <input type="button" id="startplan" value="Start" style="margin-top: -14px; width: 50px;" />
</div>
<div id="branch1" style="display: none;">
    <h1>Questions</h1>
    <hr style="margin-top:-5px;">
    <span>Is this a business? Or a small project?:<br /> <input type="radio" name="type" id="businessplanbutton" /> Business
    <input type="radio" name="type" id="smallprojplanbutton" /> Small Project</span>
    <hr />
    <form name="business" id="businessplan" class="planform">
        <span>What is the name of your company?<br /> <input type="text"id="inputpwd" style="width: 363px;" name="bask" value="" /></span><br />
        <span style="display: none;">What type of business is it? <br /><input type="text"id="inputpwd"style="width: 363px;"name="bask1" /></span><br />
        <span style="display: none;">What is your vision?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="bask2" /></span><br />
        <span style="display: none;">What makes your company special?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="bask3" /></span><br />
        <span style="display: none;">Who is your target audience?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="bask4" /></span><br />
        <span style="display: none;">What is your pricing strategy?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="bask5" /></span><br />
        <span style="display: none;">What are your deadlines?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="bask6" /></span><br />
        <span style="display: none;">What are your revenue goals?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="bask7" /></span><br />
        <span style="display: none;">What is your slogan?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="bask8" /></span><br />
        <span style="display: none;">Tasks?(Seperate by commas)<br /> <input type="text"id="inputpwd"style="width: 363px;"name="bask9" /></span><br />
        <span style="display: none;">Anything else you would like to say?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="bask10" /></span><br /><br />
        <input type="submit" value="Submit" id="plansbutton" onClick="setVariables()" /><br /><br />
    </form>
    <form name="business" id="smallprojplan" class="planform">
        <span>What is the name of your project?<br /> <input type="text"id="inputpwd"style="width: 363px;" name="pask" /></span><br />
        <span style="display: none;">What kind of project is this?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="pask1" /></span><br />
        <span style="display: none;">What materials will you need?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="pask2" /></span><br />
        <span style="display: none;">What is your vision?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="pask3" /></span><br />
        <span style="display: none;">What incentive is there for helping?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="pask4" /></span><br />
        <span style="display: none;">What skills will you need?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="pask5" /></span><br />
        <span style="display: none;">Will you be making money? How?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="pask6" /></span><br />
        <span style="display: none;">Tasks?(Seperate by commas)<br /> <input type="text"id="inputpwd"style="width: 363px;"name="pask7" /></span><br />
        <span style="display: none;">Anything else you would like to say?<br /> <input type="text"id="inputpwd"style="width: 363px;"name="pask8" /></span><br />
        <br /><br />
        <input type="submit" id="plansbutton" value="Submit" /><br /><br />
    </form>
</div>
</div>
<div id="madeplans">TESTING!!!!!!!</div>

<!--SCRIPT FOR VIEW PLAN IS BELOW!!!!-->


<div id="doneplan" style="display: none;">

<div id="branch1" style=" margin-top: 0px; margin-left: auto; margin-right: auto; position: relative;\" ><h1><?php $_GET["bask"]; ?></h1><hr style="margin-top:-30px;"><?php $_GET["bask"]; ?><br /><?php $_GET["bask"]; ?></div>

<div id="stuff" style=" position: fixed; margin-left: 0px; margin-top: 1px; width: 100px; length: 1500px; font-size: 1em; text-align:left; opacity: 0.6;"><h3><?php $_GET["bask"]; ?></h3><hr style="margin-top:-12px;"><?php $_GET["bask"]; ?></div>

<div id="branch2" style="margin-left: 120px;"><h4><?php $_GET["bask"]; ?></h4><hr style="margin-top:-15px;"><?php $_GET["bask"]; ?></div>
<div id="branch2" style="margin-left: 420px;"><h4><?php $_GET["bask"]; ?></h4><hr style="margin-top:-15px;"><?php $_GET["bask"]; ?></div>
<div id="branch2" style="margin-left: 1020px;"><h4><?php $_GET["bask"]; ?></h4><hr style="margin-top:-15px;"><?php $_GET["bask"]; ?></div>
<div id="branch2" style="margin-left: 270px; margin-top: 220px;"><h4><?php $_GET["bask"]; ?></h4><hr style="margin-top:-15px;"><?php $_GET["bask"]; ?></div>
<div id="branch2" style="margin-left: 870px; margin-top: 220px;"><h4><?php $_GET["bask"]; ?></h4><hr style="margin-top:-15px;"><?php $_GET["bask"]; ?></div>
<hr style="margin-top: 400px;">

<div id="branch1" style=" margin-top: 0px; margin-left: auto; margin-right: auto; position: relative; margin-top: 20px; padding-bottom: 15px; width: 35%;" ><h2><?php $_GET["bask"]; ?></h2><hr style="margin-top:-30px;"><?php $_GET["bask"]; ?></div>

</div>

        
<!--</div>-->
<!--<span style="display: none;">xxx<input></span>-->
        
        

<?php 
include_once('../libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>