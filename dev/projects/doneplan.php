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
<div id="planhead"><a href="plans.php">Plans</a></div><!--Change to active link-->
<!--<div id="main" style="width:100%; padding-right: 0px">-->
<?php
include('nav.php');
?>
<hr style="width:500px;" />
<!--SCRIPT FOR VIEW PLAN IS BELOW!!!!-->
<script type="text/javascript">
//6 for business
//6 for small project
//Page if 'business':
document.write("<div id=\"doneplan\" style=\"display: none;\">"); //To hide all/show all.
//Main Branch.
document.write("<div id=\"branch1\" style=\" margin-top: 0px; margin-left: auto; margin-right: auto; position: relative;\" ><h1>Business Name</h1><hr style=\"margin-top:-30px;\">Infinity-forum.org<br />Our goal is being awesome.</div>");
//Side Bar.
document.write("<div id=\"stuff\" style=\" position: fixed; margin-left: 0px; margin-top: 1px; width: 100px; length: 1500px; font-size: 1em; text-align:left; opacity: 0.6;\"><h3>STUFF!</h3><hr style=\"margin-top:-12px;\">WED LIKE TO BLAH BLAH BLAH TESTING 1 2 3 !!!</div>");
//Sub Branches:
document.write("<div id=\"branch2\" style=\"margin-left: 120px;\"><h4>YO THIS IS A TEST, LIKE IT OR NOT!</h4><hr style=\"margin-top:-15px;\">YEAH MAN, LIKE I WAS SAYING, THIS IS A TEST!</div>");
document.write("<div id=\"branch2\" style=\"margin-left: 420px;\"><h4>YO THIS IS A TEST, LIKE IT OR NOT!</h4><hr style=\"margin-top:-15px;\">YEAH MAN, LIKE I WAS SAYING, THIS IS A TEST!</div>");
document.write("<div id=\"branch2\" style=\"margin-left: 720px;\"><h4>YO THIS IS A TEST, LIKE IT OR NOT!</h4><hr style=\"margin-top:-15px;\">YEAH MAN, LIKE I WAS SAYING, THIS IS A TEST!</div>");
document.write("<div id=\"branch2\" style=\"margin-left: 1020px;\"><h4>YO THIS IS A TEST, LIKE IT OR NOT!</h4><hr style=\"margin-top:-15px;\">YEAH MAN, LIKE I WAS SAYING, THIS IS A TEST!</div>");
document.write("<div id=\"branch2\" style=\"margin-left: 270px; margin-top: 220px;\"><h4>YO THIS IS A TEST, LIKE IT OR NOT!</h4><hr style=\"margin-top:-15px;\">YEAH MAN, LIKE I WAS SAYING, THIS IS A TEST!</div>");
document.write("<div id=\"branch2\" style=\"margin-left: 870px; margin-top: 220px;\"><h4>YO THIS IS A TEST, LIKE IT OR NOT!</h4><hr style=\"margin-top:-15px;\">YEAH MAN, LIKE I WAS SAYING, THIS IS A TEST!</div>");
document.write("<hr style=\"margin-top: 400px;\">")
//Goal
document.write("<div id=\"branch1\" style=\" margin-top: 0px; margin-left: auto; margin-right: auto; position: relative; margin-top: 20px; padding-bottom: 15px; width: 35%;\" ><h2>GOAL</h2><hr style=\"margin-top:-30px;\">To be an international company, ya hear?</div>");

document.write("</div>"); //close #doneplan.
</script>





<?php 
include_once('../libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>