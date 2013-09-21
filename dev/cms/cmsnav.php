<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/member/check_auth.php');
if ($_SESSION['admin'] != 1) {
    header('Location: /');
    die();
}
msgbox("Welcome Admin ". $_SESSION['usrdata']['screenname'],"
    <a href=\"/member/\">Normal site</a> | <a href=\"\">Main</a> <br/> 
    <a href=\"/member/admin.php\">News</a> | <a href=\"/cms/blog.php\">Blog</a> <br/> 
    <a href=\"/cms/products.php\">Products</a> | <a href=\"/cms/affiliation.php\">Affiliation</a> <br/> 
    <a href=\"/cms/challenges.php\">Challenges</a> | <a>Forum</a> <br/> 
    <a href=\"http://rawr.infinity-forum.org\">RAWR-edit</a> <br/><br/> changed a bit to <br/>support lower screen <br/>resolutions
    ",0,200,60,25,10,1);
?>
