<?php
    $_SERVER['DOCUMENT_ROOT'] .= '/infinity/dev'; //uriah
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    $_SESSION['token'] = base64_encode(time() . sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) .uniqid(rand(), TRUE));
    //include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");
    //include_once($_SERVER['DOCUMENT_ROOT'].'/libs/loading.php'); //temp
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Infinity workspace</title>
	<!-- Stylesheets -->
	<link href="workspace.css" rel="stylesheet">
	<!-- Libs -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script src="../modules/NOHTML.js"></script>
	<script src="../modules/tour.js"></script>
	<script src="../modules/SVGGraph.js"></script>
	<!-- RSS -->
	<link rel="alternate" type="application/rss+xml" title="" href="" />
</head>
<body>
	<!-- Top toolbar -->
	<div id="content">
		<nav id="top-bar">
			<ul id="top-bar-options">
				<li id="top-bar-option-" class="top-bar-option link b"><a>Infinity-Forum</a></li>
				<li id="top-bar-option-" class="top-bar-option"><input type="text"placeholder="My Status"id="status"/></li>
				<li class="top-bar-option">
					<a id="top-bar-option-project_select" class="link i">Infinity</a>
					<div id="project_select"class="ctx">
						<a class="link">Project 2</a> <hr class="hr-fancy" />
						<a class="link">Project 3</a> <hr class="hr-fancy" />
						<a class="link">Project 4</a> <hr class="hr-fancy" />
						<a class="link">Project 5</a>
					</div>
				</li><span class="b i">/</span>
				<li class="top-bar-option">
					<a id="top-bar-option-branch_select" class="link i">Master</a>
					<div id="branch_select"class="ctx">
						<a class="link">Branch 2</a> <hr class="hr-fancy" />
						<a class="link">Branch 3</a> <hr class="hr-fancy" />
						<a class="link">Branch 4</a> <hr class="hr-fancy" />
						<a class="link">Branch 5</a>
					</div>
				</li><span class="b i">/</span>
				<li class="top-bar-option">
					<a id="top-bar-option-quick_add" class="link i">Quick Add</a>
					<div id="quick_add"class="ctx">
						<a class="link">Document</a> <hr class="hr-fancy" />
						<a class="link">Task</a> <hr class="hr-fancy" />
						<a class="link">Event</a> <hr  class="hr-fancy"/>
						<a class="link">Table</a> <hr class="hr-fancy">
						<a class="link">Graph</a> <hr class="hr-fancy">
						<a class="link">Note</a> <hr class="hr-fancy">
						<a class="link">File</a> <hr class="hr-fancy">
						<a class="link">Suggestion</a>
					</div>
				</li>
			</ul>
			<ul id="top-bar-options" class="right">
				<li id="top-bar-option-rss" class="top-bar-option link i"><a>RSS</a></li>
				<li id="top-bar-option-" class="top-bar-option link i"><a>General</a></li>
				<li class="top-bar-option link"><a>Logout</a></li>
			</ul>
		</nav>
		<!-- Side CMS bar -->
		<div id="side-bar">
			<ul id="side-bar-options">
				<li id="side-bar-option-" class="side-bar-option link"><img src="/images/w-msgs.png" height="20px"width="20px"></li>
				<li id="side-bar-option-" class="side-bar-option link"><img src="/images/w-reqs.png" height="20px"width="20px"></li>
				<li id="side-bar-option-" class="side-bar-option link"><img src="/images/w-cog.png" height="20px"width="20px"></li>
				<li id="side-bar-option-" class="side-bar-option link"><img src="/images/chat.png" height="20px"width="20px"></li>
				<li id="side-bar-option-" class="side-bar-option link b" style="color:black;">(6)</li>
			</ul>
		</div>
		<!-- Main area -->
		<div id="main">
			<!-- Page Links -->
			<span id="page-title">Stream</span>&nbsp;
			<div id="all-pages">
				<span id="tiny-page-stream" class="link">Stream</span>
				<span id="tiny-page-control" class="link">Control</span>
				<span id="tiny-page-members" class="link">Members</span>
				<span id="tiny-page-documents" class="link">Documents</span>
				<span id="tiny-page-tasks" class="link">Tasks</span>
				<span id="tiny-page-events" class="link">Events</span>
				<span id="tiny-page-tables" class="link">Tables</span>
				<span id="tiny-page-graphs" class="link">Graphs</span>
				<span id="tiny-page-files" class="link">Files</span>
				<span id="tiny-page-notes" class="link">Notes</span>
				<span id="tiny-page-suggested" class="link">Suggested</span>
				<!-- Search -->
				&emsp;
				<input 
					id="search"
					style="background: url('/infinity/dev/images/broken_noise.png');border:1px solid grey;" 
					type="text" 
					placeholder="Search..."
				/>
			</div>
			<br><br>
			<div id="unique_content">
			<!-- Statistics -->
			<div id="workspace-info">
				Welcome, <a class="link">Uriah Sanders</a>
				<hr class="hr-fancy">
				<span class="header">Contributions this Week:</span><br>
				<div id="workspace-graphs">
					
				</div>
			</div>
			<!-- Unique content -->
			<div id="entries">
				<textarea style="float:left;" name="" id="" cols="50" rows="2"></textarea> <button style="margin-top:7px;">Post</button>
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Document</span>
					</div>
					<div class="entry-type-img">
						<img style="float:right"src="/images/documents.png"width="100px"height="100px">
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">created</span> 
						<span class="link">"<a>My First Kiss</a>"</span>
						<br />
						10 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				<!-- Another -->
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Document</span>
					</div>
					<div class="entry-type-img">
						<img style="float:right"src="/images/documents.png"width="100px"height="100px">
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">edited</span> 
						<span class="link">"<a>My First Kiss</a>"</span>
						<br />
						6 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				<!-- Another -->
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Task</span>
					</div>
					<div class="entry-type-img">
						<img style="float:right"src="/images/tasks.png"width="100px"height="100px">
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">assigned</span> 
						<span class="link">"<a>Start coding</a>"</span>
						<br />
						4 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				<!-- Another -->
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Event</span>
					</div>
					<div class="entry-type-img">
						<img style="float:right"src="/images/events.png"width="100px"height="100px">
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">removed</span> 
						<span class="link">"<a>Buy pancakes</a>"</span>
						<br />
						3 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				<!-- Another -->
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Document</span>
					</div>
					<div class="entry-type-img">
						<img style="float:right"src="/images/documents.png"width="100px"height="100px">
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">edited</span> 
						<span class="link">"<a>My First Kiss</a>"</span>
						<br />
						10 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				<!-- Another -->
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Task</span>
					</div>
					<div class="entry-type-img">
						<img style="float:right"src="/images/tasks.png"width="100px"height="100px">
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">created</span> 
						<span class="link">"<a>My First Task</a>"</span>
						<br />
						10 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				<!-- Another -->
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Document</span>
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">edited</span> 
						<span class="link">"<a>My First Kiss</a>"</span>
						<br />
						10 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				<!-- Another -->
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Document</span>
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">edited</span> 
						<span class="link">"<a>My First Kiss</a>"</span>
						<br />
						10 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				<!-- Another -->
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Document</span>
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">edited</span> 
						<span class="link">"<a>My First Kiss</a>"</span>
						<br />
						10 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				<!-- Another -->
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Document</span>
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">edited</span> 
						<span class="link">"<a>My First Kiss</a>"</span>
						<br />
						10 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				<!-- Another -->
				<div class="entry">
					<div class="entry-media">
						<div class="entry-img">
							<img src="/infinity/dev/images/profile-photo.jpg"width="75px"height="75px">
						</div>
						<span class="link">Document</span>
					</div>
					<div class="entry-content">
						<span class="link">Uriah Sanders</span> 
						<span style="color:lightblue">edited</span> 
						<span class="link">"<a>My First Kiss</a>"</span>
						<br />
						10 hours ago
						<br />
						In Branch <span class="link"><a>Master</a></span>, Project <span class="link"><a>Infinity</a></span>
					</div>
					<div class="entry-comments-wrapper">
						<button>View More</button>
					</div>
				</div>
				</div>
			</div>
		</div>
		</div>
	</div>
	<!-- Token -->
	<input type="hidden" id="token" value=<?php echo "\"".$_SESSION['token']."\""; ?>/>
	<!-- Scripts -->
	<script src="workspace.js"></script>
</body>
</html>