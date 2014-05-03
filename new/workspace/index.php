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
   	<div id="workspace-sidebar">
   		<br>
   		<ul>
   			<li><input id="workspace-search"value="Search..."placeholder="Search..."></li>
   			<br>
   			<li class="workspace-main-li workspace-li-has-more active"><i class="fa fa-star fa-lg"></i>&emsp;Discover</li>
   			<ul style="display:none">
   				<li>All</li>
   				<li>Technology</li>
   				<li>Art</li>
   				<li>Music</li>
   				<li>Culinary</li>
   				<li>Fashion</li>
   				<li>Film</li>
   			</ul>
   			<li class="workspace-main-li"><i class="fa fa-comments fa-lg"></i>&emsp;Stream</li>
   			<li class="workspace-main-li"><i class="fa fa-dashboard fa-lg"></i>&emsp;Control</li>
   			<li class="workspace-main-li"><i class="fa fa-users fa-lg"></i>&emsp;Members</li>
   			<li class="workspace-main-li"><i class="fa fa-clipboard fa-lg"></i>&emsp;Documents</li>
   			<li class="workspace-main-li"><i class="fa fa-tasks fa-lg"></i>&emsp;Tasks</li>
   			<li class="workspace-main-li"><i class="fa fa-calendar fa-lg"></i>&emsp;Events</li>
   			<li class="workspace-main-li"><i class="fa fa-bar-chart-o fa-lg"></i>&emsp;Graphs</li>
   			<li class="workspace-main-li"><i class="fa fa-pencil fa-lg"></i>&emsp;Sketches</li>
   			<li class="workspace-main-li"><i class="fa fa-file fa-lg"></i>&emsp;Files</li>
   			<li class="workspace-main-li"><i class="fa fa-paperclip fa-lg"></i>&emsp;Notes</li>
   			<li class="workspace-main-li"><i class="fa fa-question fa-lg"></i>&emsp;Suggestions</li>
   		</ul>
   	</div>
   	<div id="workspace-title">
   		<span id="workspace-place"><i class="fa fa-star"></i> Discover</span> <hr class="hr-black">
      <div id="workspace-options">
        <!-- <button id="workspace-ctx"data-val="No Project Selected"class="pr-btn btn-dropdown">No Project Selected <i class="fa fa-caret-down"></i></button>
        <div id="workspace-ctx-content"class="workspace-dropdown"style="font-size:0.5em;width:150px;">
          <span class="workspace-ctx-item ctx-project">No Project Selected</span>
          <span class="workspace-ctx-item ctx-project">Project 1</span>
          <span class="workspace-ctx-item ctx-project">Project 2</span>
          <span class="workspace-ctx-item ctx-project">Project 3</span>
          <span class="workspace-ctx-item ctx-project">Project 4</span>
        </div> -->
        <!-- <span style="font-size:.55em"> -->
          <span style="font-size:.55em">Search</span> <button data-val="All"id="workspace-discover-category"class="pr-btn btn-dropdown">All <i class="fa fa-caret-down"></i></button>
          <div id="workspace-discover-category-content"class="workspace-dropdown"style="font-size:0.5em;width:150px;margin-left:50px">
          <span class="workspace-discover-category-item dropdown-li">All</span>
          <span class="workspace-discover-category-item dropdown-li">Technology</span>
          <span class="workspace-discover-category-item dropdown-li">Art</span>
          <span class="workspace-discover-category-item dropdown-li">Music</span>
          <span class="workspace-discover-category-item dropdown-li">Film</span>
          <span class="workspace-discover-category-item dropdown-li">Fashion</span>
          <span class="workspace-discover-category-item dropdown-li">Culinary</span>
          <span class="workspace-discover-category-item dropdown-li">Education</span>
          <span class="workspace-discover-category-item dropdown-li">Activism</span>
        </div>
          <span style="font-size:.55em">Projects By</span> <button data-val="Date"id="workspace-discover-by"class="pr-btn btn-dropdown">Date <i class="fa fa-caret-down"></i></button>
          <div id="workspace-discover-by-content"class="workspace-dropdown"style="font-size:0.5em;width:150px;margin-left:200px;">
          <span class="workspace-discover-by-item dropdown-li">Date</span>
          <span class="workspace-discover-by-item dropdown-li">Popularity</span>
        </div>
        <!-- </span> -->
      </div>
   	</div>
   	<br>
   	<div id="workspace-main">
   		
   	</div>
    <input id="token"type="hidden"value=<?php echo '"'.$_SESSION['token'].'"'; ?>/>
    <script type="text/javascript"src="/js/tinymvc.js"></script>
    <script type="text/javascript"src="script.js"></script>
    <?php
 include_once(PATH ."core/main_end_foot.php");
?>