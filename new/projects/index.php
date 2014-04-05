<?php 
    define("INFINITY", true); // this is so the includes can't get directly accessed
    define("PAGE", "projects"); // this is what page it is, for the links at the top
    include_once("../libs/relax.php"); // use PATH from now on
	
    Login::checkAuth();
	
    include_once(PATH ."core/top.php");
    if(defined("PAGE") && PAGE == "start") 
    {
        include_once(PATH ."core/slide.php");
    }
    include_once(PATH ."core/bar_main_start.php");
    $_SESSION['token'] = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
?>
    <div id="pr-navigation">
      <div class="nav"style="margin:auto;font-size:2em;">
        View <a href="">All</a> projects sorted by <a href="">Date</a>
        <!-- <br> -->
        <!-- <button id="new-project"class="pr-btn btn-success">New Project</button> -->
      </div>
      <br>
        Search: <input class="form-control"/>
      <br><br>
    </div>
    <input id="token"type="hidden"value=<?php echo '"'.$_SESSION['token'].'"'; ?>/>
    <div id="meat"></div>
    <script type="text/javascript"src="/js/tinymvc.js"></script>
    <script type="text/javascript"src="script.js"></script>