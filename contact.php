<?php
define("INFINITY", true); // this is so the includes can't get directly accessed
define("PAGE", "contact"); // this is what page it is, for the links at the top
include_once("libs/relax.php"); // use PATH from now on
include_once(PATH ."core/top.php");
include_once(PATH ."core/bar_main_start.php");
?>
  <br><br>
  <div style="background:url('/images/broken_noise.png');padding:20px;border:1px solid #000; width: 60%;margin:auto;line-height:1.5em">
    Contact us here for any special requests (press, affiliation, etc), or security issues. If you have any questions, comments, concerns, suggestions, or otherwise, please post in the "Infinity" board of the Forum after logging in. We try our best to read most of this stuff.
    <br><br>
    <form>
      Subject: <select class="form-control">
        <option>Press</option>
        <option>Affiliation</option>
        <option>Security</option>
        <option>Other</option>
      </select><br><br>
      <input style="width:80%;height:20px"class="form-control"placeholder="Subject..."><br><br>
      <textarea class="form-control"></textarea>
      <br><br>
      <button id="contact-send"class="pr-btn">Send</button>
    </form>
  </div>
  <script type="text/javascript">
  $(document).on('click', '#contact-send', function(e){
    e.preventDefault();
    MsgBox('Contact', 'Your message has been sent.', -1);
  });
  </script>
<?php
 include_once(PATH ."core/main_end_foot.php");
?>