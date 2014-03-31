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
<br>
    <div id="pr-navigation">
      <div class="nav"style="margin:auto;width:100%;margin-left:1%">
        <button id="new-project"class="pr-btn btn-success">New Project</button><br><br>
        View <button class="pr-btn btn-success">All <i class="fa fa-caret-down"></i></button>&nbsp;
        Projects sorted by &nbsp;
        <button class="pr-btn btn-success">Date <i class="fa fa-caret-down"></i></button>
        <br><br>
        <input class="form-control"placeholder="Search..."/>
      </div>
      <br>
    </div>
    <input id="token"type="hidden"value=<?php echo '"'.$_SESSION['token'].'"'; ?>/>
    <div id="meat"></div>
    <script type="text/javascript"src="/js/tinymvc.js"></script>
    <script type="text/javascript"src="script.js"></script>