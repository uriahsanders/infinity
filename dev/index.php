<?php
$_SERVER['DOCUMENT_ROOT'] .= '/infinity/dev'; //uriah
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/top.php'); //DO NOT REMOVE OR CHANGE 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/links.php'); // DO NOT REMOVE OR CHANGE
$token = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
listlinks("Start"); // CHANGE TO THE ACTIVE LINK

include_once($_SERVER['DOCUMENT_ROOT'].'/libs/middle.php'); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS

include_once($_SERVER['DOCUMENT_ROOT'].'/libs/boxes.php'); //boxes and error codes (only for index.php)
?>








        
        <div id="main"><div id="head">Welcome to Infinity</div><hr> Welcome to Infinity, a place for collaboration and learning! We are glad to have you here. Feel welcome to search through any "up and coming" news,
            browse the forums, and post projects. Also, please take the time to visit the About page, where you can find 
            information about our vision for this website.<br />
            Once you have familiarized yourself with the site, we encourage you to register and start getting involved.<br /> 
            Our philosophy is that knowledge should be shared and that finding people to work with should be easy. 
            Whether you are a seasoned master looking for colleagues, or a curious soul hungry for knowledge, this is the place for you.<br />
            In our forums you will find a wide variety of topics. This is a great place to share what you know as well as learn
            from others.Here, you can make a reputation for yourselves and increase your chances of getting into projects. We
            encourage you to join in.<br />
            In projects you can see what others are creating, offer your skills, or start your own project.We make it easy for 
            you to find a way to make cash doing the things you love, and find the right people to help you along your path to 
            success.<br /> You will also find articles, downloads, and tutorials to add and learn from. As this site expands, so will
            its content and the opportunities it produces.<br />
            So learn, contribute, debate, create, and make some cash.<br />
            We're sure you'll fit right in.<br />
             
            -The Infinity Staff<br /><br />
            
            
<a href="rss/main.rss">Test RSS</a>
</div>
<!--Big news div goes below welcome text, it will always be filled. On launch, it will say something like "Infinity just launched" with some 
details below. It will update with each new big thing.-->
<br /><br /><!--To align new with text-->
        <div id="news">
<?php


mysql_connect(SQL_SERVER,SQL_USR,SQL_PWD) or die(mysql_error());
mysql_select_db(SQL_DB) or die(mysql_error());

$result = mysql_query("SELECT * FROM news ORDER BY date DESC LIMIT 10")
or die(mysql_error());
$i = 0;
    while($row = mysql_fetch_array($result)) {
    $i++;
echo "

<div id=\"newsitem\">\n
                <div id=\"newssub\"><a href=\"javascript:newsSlide('news".$i."')\">".$row['subject']."</a>\n
                <div id=\"newsdate\">".substr($row['date'],0,10)." <a href=\"javascript:newsSlide('news".$i."')\"><img src=\"images/arrowo.png\" id=\"arrownews".$i."\" border=\"0\"/></a></div></div>\n
                <div id=\"news".$i."\" class=\"newstxt\">\n".$row['text']."
                \n</div>\n
            </div><br />\n\n";

    }
    
    
    ?>
            
        </div>
        
        
        
        
<?php
include_once('libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>