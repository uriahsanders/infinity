<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
define("PAGE", "about"); // this is what page it is, for the links at the top
include_once("libs/relax.php"); // use PATH from now on
include_once(PATH ."core/top.php");
include_once(PATH ."core/bar_main_start.php");
?>
  <i class="fa fa-globe"style="font-size:25em;color:grey"title="BIG LOGO HERE"></i>
  <div style="background:url('/images/broken_noise.png');padding:20px;border:1px solid #000; width: 60%;margin:auto;line-height:1.5em">
    Infinity-Forum is a social network built around creativity, collaboration, and information. All in one place, you can bring a project from start to finish, using the unique resources only offered at Infinity. Our mission is to make project development easy, so that anyone can make their dreams come true, regardless of their starting point.
  </div>
  <br>
  <strong>After you Register:</strong>
  <br><br><br>
  <div>
    <a href="/forum/#"><button style="font-size:1.3em;padding:15px"class="pr-btn">Learn</button></a>&emsp;
    <a href="/projects/"><button style="font-size:1.3em;padding:15px"class="pr-btn">Discover</button></a>&emsp;
    <a href="/workspace/"><button style="font-size:1.3em;padding:15px"class="pr-btn">Create</button></a>&emsp;
    <a href=""><button style="font-size:1.3em;padding:15px"class="pr-btn">Collaborate</button></a>&emsp;
  </div>
<?php
 include_once(PATH ."core/main_end_foot.php");
?>