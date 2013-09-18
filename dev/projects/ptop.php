<?php
if(strlen(session_id()) < 1)
 {
      // session has NOT been started
     session_start();
     include('../member/check_auth.php');
 } 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml", id="html">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
      <title>Infinity - cycle of knowledge</title>
      <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="/css/dark.css" />
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script src="/js/calendar.js" type="text/javascript"></script>    
    <script src="/js/infinity.js" type="text/javascript"></script> 
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="/css/member.css" />
    <script>
            function changeStatus(status, title){
                $("#firststatus a img").attr("src", status);
                $("#firststatus a img").attr("title", title);
            }
        </script>
   
    
      <script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
      <!--[if gte IE 9]>
      <style type="text/css">
        .gradient {filter: none;}
      </style>
      <![endif]--><!-- so we have the gradient on the buttons even on old IE browsers-->
    </head>
    <body>
    
         <?php
    include_once('/home2/infiniz7/public_html/dev/libs/lib.php');
    ?>
    <div id="topbar">