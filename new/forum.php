<?php 
    define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "forum"); // this is what page it is, for the links at the top
    include_once("libs/relax.php"); // use PATH from now on
    include_once(PATH ."core/top.php");
    include_once(PATH ."core/top.php");
    if(defined("PAGE") && PAGE == "start") 
    {
        include_once(PATH ."core/slide.php");
    }
    include_once(PATH ."core/bar_main_start.php");
?>
<div id="side_left">
    <div id="navigation">
        <ul>
            <li><input type="text"style="width:100px;"placeholder="Search..." /></li>
            <li class="active">Category</li>
            <li>Category</li>
            <li>Category</li>
            <li>Category</li>
            <li>Category</li>
            <li>Category</li>
            <li>Category</li>
            <li>Category</li>
            <li>Category</li>
            <li>Category</li>
            <li>Category</li>
            <li>Category</li>
            <li>Category</li>
        </ul>
    </div>
</div>
<div id="category_title">
    <span id="hero">General Discussion</span>
</div>
<br />
<div id="category_description">Stuff wihout a specific topic. Just hangin' out.</div>
<br />
<div id="forum_sort">
    <span id="pro_usr_menu">
        <span active>Recent</span>
        <span>My Posts</span>
        <span>Popularity</span>
        <span>Friends</span>
    </span>
</div>
<br /><br /><br />
<div id="forum_opt">
    <a href="#"class="big_button" style="padding-top:10px;padding-bottom:10px;font-size: 1em;padding-left:25px;padding-right:25px;">New Thread</a>
</div>
<br />
<div id="forum_main">
    <article class="thread">
        <div class="thread_image">
            <img src="/images/user/c402818a1b9928d876535643fe487c55j" id="pro_profile_p" style="margin-right:700px;border-radius:3px;">
        </div>
        <div class="thread_title">
            My first Thread - <a href="/user/relax">Relax</a>: 9/17/13
        </div>
        <div class="thread_body pro_stream_box">
            Hello everyone I'm really happy to announce that i just made my first thread ever! OMG!!!! I never thought id ever make it to such wondrous heights.
            First off, id like to thank God, then all of my hoes. I'm a real pimp now! Like pinnochio but with a fatter nose. I really like to drink Sofiero but
            that's not much of a lie now is it!? Also, Wabi, will you<a href="#">...View More.</a>
        </div>
        <div class="thread_icons">
             icons
        </div>
    </article>
    <article class="thread">
        <div class="thread_image">
            <img src="/images/user/c402818a1b9928d876535643fe487c55j" id="pro_profile_p" style="margin-right:700px;border-radius:3px;">
        </div>
        <div class="thread_title">
            My first Thread - <a href="/user/relax">Relax</a>: 9/17/13
        </div>
        <div class="thread_body pro_stream_box">
            Hello everyone I'm really happy to announce that i just made my first thread ever! OMG!!!! I never thought id ever make it to such wondrous heights.
            First off, id like to thank God, then all of my hoes. I'm a real pimp now! Like pinnochio but with a fatter nose. I really like to drink Sofiero but
            that's not much of a lie now is it!? Also, Wabi, will you<a href="#">...View More.</a>
        </div>
        <div class="thread_icons">
             icons
        </div>
    </article>
    <article class="thread">
        <div class="thread_image">
            <img src="/images/user/c402818a1b9928d876535643fe487c55j" id="pro_profile_p" style="margin-right:700px;border-radius:3px;">
        </div>
        <div class="thread_title">
            My first Thread - <a href="/user/relax">Relax</a>: 9/17/13
        </div>
        <div class="thread_body pro_stream_box">
            Hello everyone I'm really happy to announce that i just made my first thread ever! OMG!!!! I never thought id ever make it to such wondrous heights.
            First off, id like to thank God, then all of my hoes. I'm a real pimp now! Like pinnochio but with a fatter nose. I really like to drink Sofiero but
            that's not much of a lie now is it!? Also, Wabi, will you<a href="#">...View More.</a>
        </div>
        <div class="thread_icons">
             icons
        </div>
    </article>
    <article class="thread">
        <div class="thread_image">
            <img src="/images/user/c402818a1b9928d876535643fe487c55j" id="pro_profile_p" style="margin-right:700px;border-radius:3px;">
        </div>
        <div class="thread_title">
            My first Thread - <a href="/user/relax">Relax</a>: 9/17/13
        </div>
        <div class="thread_body pro_stream_box">
            Hello everyone I'm really happy to announce that i just made my first thread ever! OMG!!!! I never thought id ever make it to such wondrous heights.
            First off, id like to thank God, then all of my hoes. I'm a real pimp now! Like pinnochio but with a fatter nose. I really like to drink Sofiero but
            that's not much of a lie now is it!? Also, Wabi, will you<a href="#">...View More.</a>
        </div>
        <div class="thread_icons">
             icons
        </div>
    </article>
</div>
<!--
    <div id="forum_categories">
    <ul>
        <li style="border:1px solid grey;">General<span class="category_num">3</span></li>
        <ul class="thread_sub_1">
            <li class="active">- General Discussion</li>
            <li>- Members Introductions</li>
            <li>- Random</li>
        </ul>
        <li>Infinity<span class="category_num">2</span></li>
        <ul class="thread_sub_1">
            <li>Announcements</li>
            <li>Suggestions<span class="category_num">3</span></li>
            <ul class="thread_sub_2">
                <li>Questions</li>
                <li>Comments</li>
                <li>Support</li>
            </ul>
        </ul>
        <li>World<span class="category_num">8</span></li>
        <ul class="thread_sub_1">
            <li>History</li>
            <li>Language</li>
            <li>Literature</li>
            <li>Economics</li>
            <li>Politics</li>
            <li>Business</li>
            <li>Philosophy</li>
            <li>Athletics</li>
        </ul>
        <li>Arts<span class="category_num">3</span></li>
        <ul class="thread_sub_1">
            <li>Culinary</li>
            <li>General</li>
            <li>Performing</li>
        </ul>
        <li>Sciences<span class="category_num">6</span></li>
        <ul class="thread_sub_1">
            <li>Math</li>
            <li>Psychology</li>
            <li>Biological</li>
            <li>Physical</li>
            <li>Computer<span class="category_num">2</span></li>
            <ul class="thread_sub_2">
                <li>Programming</li>
                <li>Security</li>
            </ul>
            <li>Medical</li>
        </ul>
        <li>Integrated<span class="category_num">3</span></li>
    </ul>
</div>
-->

