<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
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
    <script src="/js/infinity.js" type="text/javascript"></script> 
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
    
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
    
         
        
    <div id="topbar">

<?php
    
    include_once('../libs/links.php'); // DO NOT REMOVE OR CHANGE

listlinks("Infinity"); // CHANGE TO THE ACTIVE LINK

    include_once('../libs/middle.php'); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS

?>

        <center>
            <h1>CMS Main Page</h1>
            <hr />
            <?php
            include_once('cmsnav.html');
            ?>
            
            
        </center>
<?php
                include_once('../libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>    