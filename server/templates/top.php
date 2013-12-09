<!doctype html>
<html lang="en">
<!-- Contains top bar -->
<head>
	<meta charset="UTF-8">
	<title>Infinity-Forum</title>
	<!-- Bootstrap and Font Awesome and CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
	<link href="css/dark.css" rel="stylesheet">
	<link href="css/psform.css" rel="stylesheet">
	
		<!-- for forum only, temp: -->
		<style>
			tr:not(:last-child){
				border-bottom: 1px solid #000;
			}
		</style>
	
	<!-- JS scripts at bottom -->
</head>
<body>
	<span id="topmost"></span>
	<div id="scrollup">
		<a href="#topmost"class="fa fa-arrow-up fa-3x"></a>
	</div>
	<div id="container">
		<!-- Top Bar -->
		<div id="top">
			<!-- Should be able to access most content through drop-down -->
			<div class="top"id="links">
				<a href="index.php"class="fa fa-home truelink"></a>
				<span class="dropdown">
				  <span class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
				    General
				    <i class="fa fa-caret-down"></i>
				  </span>
				  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
				  	<li role="presentation"><a class="truelink"role="menuitem" tabindex="-1" href="index.php">Start</a></li>
				    <li role="presentation"><a class="truelink"role="menuitem" tabindex="-1" href="about.php">About</a></li>
				    <li role="presentation"><a class="truelink"role="menuitem" tabindex="-1" href="blog.php">Blog</a></li>
				    <li role="presentation"><a class="truelink"role="menuitem" tabindex="-1" href="help.php">Help</a></li>
				    <li role="presentation"><a class=""role="menuitem" tabindex="-1" id="contact">Contact</a></li>
				  </ul>
				</span>
				<span class="dropdown">
				  <span class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
				    Community
				    <i class="fa fa-caret-down"></i>
				  </span>
				  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
				  	<li role="presentation"><a class="truelink"role="menuitem" tabindex="-1" href="lounge.php">Lounge</a></li>
				    <li role="presentation"><a class="truelink"role="menuitem" tabindex="-1" href="forum.php">Forum</a></li>
				    <li role="presentation"><a class="truelink"role="menuitem" tabindex="-1" href="projects.php">Projects</a></li>
				    <li role="presentation"><a class="truelink"role="menuitem" tabindex="-1" href="workspace.php">Workspace</a></li>
				  </ul>
				</span>
				&emsp;&emsp;
				<!-- Search -->
				<span class="dropdown">
				  <span class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
				    Search
				    <i class="fa fa-caret-down"></i>
				  </span>
				  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
				  	<li role="presentation"><a role="menuitem" tabindex="-1">Projects</a></li>
				    <li role="presentation"><a role="menuitem" tabindex="-1">Members</a></li>
				    <li role="presentation"><a role="menuitem" tabindex="-1">Threads</a></li>
				    <li role="presentation"><a role="menuitem" tabindex="-1">Blog</a></li>
				  </ul>
				</span>
				<input id="search"class="form-control"type="text"placeholder="Projects...">
				<i class="fa fa-search white pointer"></i>
				&emsp;&emsp;
				<!-- Control -->
				<span class="top"id="control">
					<!-- All User options in one link -->
					<span class="dropdown">
					  <span class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
					    <span>Welcome, Guest</span>
					    <i class="fa fa-caret-down"></i>
					  </span>
					  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					  	<!-- Profile only when logged in -->
					  	<li role="presentation"><a role="menuitem" tabindex="-1" href="profile.php">Profile</a></li>
					    <li role="presentation"><a role="menuitem" tabindex="-1" id="login">Login</a></li>
					    <li role="presentation"><a role="menuitem" tabindex="-1" id="register">Register</a></li>
					    <li role="presentation"><a role="menuitem" tabindex="-1" id="recover">Recover</a></li>
					  </ul>
					</span>
					<span class="dropdown">
					  <span class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
					    <a class="fa fa-user fa-lg lightgreen"></a>
					  </span>
					  <ul class="dropdown-menu" style="min-width:0px"role="menu" aria-labelledby="dropdownMenu1">
					  	<li role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-user fa-lg lightgreen"></i></a></li>
					    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-user fa-lg yellow"></i></a></li>
					    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-user fa-lg red"></i></a></li>
					    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-user fa-lg grey"></i></a></li>
					  </ul>
					</span>
					<a class="fa fa-cog fa-lg grey"></a>&emsp;<a class="fa fa-question fa-lg white"></a>&emsp;<a class="fa fa-dollar fa-lg gold"></a>
					<span class="dropdown">
					  <span class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
					    <a id="orgcss"title="theme"class="fa fa-circle fa-lg black"></a>
					  </span>
					  <ul class="dropdown-menu" style="min-width:0px"role="menu" aria-labelledby="dropdownMenu1">
					  	<li role="presentation"id="darkcss"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle fa-lg black"></i></a></li>
					    <li role="presentation"id="whitecss"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle fa-lg white"></i></a></li>
					  </ul>
					</span>
				</span>
				</div>
			</div>
		</div>
		<!-- /top -->