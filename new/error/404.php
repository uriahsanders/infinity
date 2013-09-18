<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml", id="html">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
      <title>Infinity - 404 not found</title>
      <link rel="shortcut icon" href="/favicon.ico" />
      <link rel="stylesheet" type="text/css" href="/css/default.css" />
      <link href='http://fonts.googleapis.com/css?family=Oswald:300' rel='stylesheet' type='text/css'>
      <script type="text/javascript" src="/js/jquery-1.9.0.min.js"></script>
      <script>
	  	$(document).ready(function(e) {
            $(window).resize(function(){
				$("#m").height($(window).height()- $("#top").height() - $("#foot").height() - 38);
				$("html").css("overflow-y", "auto");
			});
	  	$(window).trigger("resize");
        });
	  </script>  
    </head>
    <body background="/images/dark_stripes.png">
    <div id="top">
        <span id="logo" onclick="window.location='/'">&nbsp;</span><span id="extra"></span><span id="extra2"></span><!--
        --><span id="menu">
        <?php
			define("INFINITY", true);
			include_once("../libs/relax.php");
			listlinks("");
			
			
		?>
        
    </div>
        <div style="text-align:center; height:100%; position:relative; min-height:500px" id="m">
            <img src="/error/images/404.png" border="0" style="height:90%"><br />
            	<div class="btn" onclick="history.go(-1)">Go Back</div>
        </div>
        <div id="foot" class="bar" style="position: relative;bottom:0 !important;">
            © Copyright 2013 <a href="/" title="Infinity-forum.org">Infinity-forum.org</a> - All Rights Reserved.
        </div>
    </body>
<html> 