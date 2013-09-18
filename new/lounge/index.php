<!DOCTYPE html>
<?php 
    define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "lounge"); // this is what page it is, for the links at the top
    include_once("../libs/relax.php"); // use PATH from now on
    $member->check_auth();
    include_once(PATH ."core/top.php");
    if(defined("PAGE") && PAGE == "start") 
    {
        include_once(PATH ."core/slide.php");
    }
    include_once(PATH ."core/bar_main_start.php");
?>
<style type="text/css">
    .t {
        font-size: 500%;
        text-align: center;
    }
    .tagline{
        text-align: center;
        font-size: 120%;
        margin-top: -5em;
    }
    .pics img {
        width: 150px;
        height: 100px;
        border: 1px dotted #f22;
        padding: 2px 2px 2px 2px;
        margin: 10px 10px 10px 10px;
    }
    .pics {
        height: 126px;
        width: 1232px;
        border: 1px solid #eee;
        margin-left: auto;
        margin-right: auto;
    }
    .bitch {
        text-align: center;
        font-size: 200%;
    }
    .f {
        text-align: center;
        margin-top: 10em;
    }
    #l {
        
        color: #6ff;
    }
    </style>
    <div id="l">
    <p class="t">Relax.Uwh</p>
    <p class="tagline">The best person in the world!</p>
    <div class="pics"><a href="http://www.cba-va.org/Portals/26530/images/2-red-heart.png"><img src="http://www.cba-va.org/Portals/26530/images/2-red-heart.png" /></a><a href="https://lh5.googleusercontent.com/-f4nzsqGjVYk/UKq0H7QMMjE/AAAAAAAAAD0/ESgNKLqQ3yA/s250-c-k/ScrapbookPhotos"><img src="https://lh5.googleusercontent.com/-f4nzsqGjVYk/UKq0H7QMMjE/AAAAAAAAAD0/ESgNKLqQ3yA/s250-c-k/ScrapbookPhotos" /></a><a href="http://4.bp.blogspot.com/--jqVxkF-Zm4/UTpxXGZTymI/AAAAAAAAAY4/hbWQktm_vZA/s1600/relax3.jpe"><img src="http://4.bp.blogspot.com/--jqVxkF-Zm4/UTpxXGZTymI/AAAAAAAAAY4/hbWQktm_vZA/s1600/relax3.jpe" /></a><a href="https://lh5.googleusercontent.com/-pgT5A3AfNQI/UKqy-J2ii6I/AAAAAAAAABo/Ztf5xSEvvws/avatar_8008_1348133191.png"><img src="https://lh5.googleusercontent.com/-pgT5A3AfNQI/UKqy-J2ii6I/AAAAAAAAABo/Ztf5xSEvvws/avatar_8008_1348133191.png" /></a><a href="https://lh4.googleusercontent.com/-aP8DBXVzzJs/AAAAAAAAAAI/AAAAAAAAACI/zG0tMKWtifk/s250-c/photo.jpg"><img src="https://lh4.googleusercontent.com/-aP8DBXVzzJs/AAAAAAAAAAI/AAAAAAAAACI/zG0tMKWtifk/s250-c/photo.jpg" /></a><a href="http://i.ebayimg.com/00/s/ODAwWDEwMDA=/z/790AAMXQHDlRdRf-/$%28KGrHqR,!l!FFyUWhZObBRdRf-nr-w~~60_35.JPG"><img src="http://i.ebayimg.com/00/s/ODAwWDEwMDA=/z/790AAMXQHDlRdRf-/$%28KGrHqR,!l!FFyUWhZObBRdRf-nr-w~~60_35.JPG" /></a><a href="http://ecx.images-amazon.com/images/I/81uwhXdYYGL._SL1500_.jpg"><img src="http://ecx.images-amazon.com/images/I/81uwhXdYYGL._SL1500_.jpg" /></a></div><br /><br /><p class="bitch">HE WILL FUCK YOU TO DEATH, BITCH!<br />HE IS THE BEST!!!<br /><br /><b><em>IF YOU ARE NOT HIM, YOU SUCK <u>COCK</u> MOTHAFLIPPER!</em></b></p><p class="f">BTW, this is his profile page.</p>
    </div>
            
<?php 
include_once(PATH ."core/main_end_foot.php");
?>
