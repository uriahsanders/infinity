<?php
if(strlen(session_id()) < 1)
 {
      // session has NOT been started
     session_start();
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
        <style type="text/css">
        .ui-datepicker {  
    width: 250px;  
   
    margin: 5px auto 0;  
    font: 9pt Arial, sans-serif;  
    -webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .5);  
    -moz-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .5);  
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .5);  
}  
   .ui-datepicker a {  
    text-decoration: none;  
}       
.ui-datepicker table {  
    width: 100%;  
}  

.ui-datepicker-prev {  
    float: left;  
    background-position: center -30px;  
                cursor:pointer;
}  
.ui-datepicker-next {  
    float: right;  
    background-position: center 0px;  
                cursor:pointer;
}  
.ui-datepicker thead {  
    background-color: #f7f7f7;  
    background-image: -moz-linear-gradient(top,  #f7f7f7 0%, #f1f1f1 100%);  
    background-image: -webkit-gradient(linear, left top, left bottombottom, color-stop(0%,#f7f7f7), color-stop(100%,#f1f1f1));  
    background-image: -webkit-linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
    background-image: -o-linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
    background-image: -ms-linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
    background-image: linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f7', endColorstr='#f1f1f1',GradientType=0 );  
    border-bottom: 1px solid #bbb;  
}  
.ui-datepicker th {  
    text-transform: uppercase;  
    font-size: 6pt;  
    padding: 5px 0;  
    color: #666666;  
    text-shadow: 1px 0px 0px #fff;  
    filter: dropshadow(color=#fff, offx=1, offy=0);  
}  
.ui-datepicker tbody td {  
    padding: 0;  
    border-right: 1px solid #bbb;  
}  
.ui-datepicker tbody td:last-child {  
    border-right: 0px;  
}  
.ui-datepicker tbody tr {  
    border-bottom: 1px solid #bbb;  
}  
.ui-datepicker tbody tr:last-child {  
    border-bottom: 0px;  
}  
.ui-datepicker td span, .ui-datepicker td a {  
    display: inline-block;  
    font-weight: bold;  
    text-align: center;  
    width: 30px;  
    height: 30px;  
    line-height: 30px;  
    color: #666666;  
    text-shadow: 1px 1px 0px #fff;  
    filter: dropshadow(color=#fff, offx=1, offy=1);  
}  
.ui-datepicker-calendar .ui-state-default {  
    background: #ededed;  
    background: -moz-linear-gradient(top,  #ededed 0%, #dedede 100%);  
    background: -webkit-gradient(linear, left top, left bottombottom, color-stop(0%,#ededed), color-stop(100%,#dedede));  
    background: -webkit-linear-gradient(top,  #ededed 0%,#dedede 100%);  
    background: -o-linear-gradient(top,  #ededed 0%,#dedede 100%);  
    background: -ms-linear-gradient(top,  #ededed 0%,#dedede 100%);  
    background: linear-gradient(top,  #ededed 0%,#dedede 100%);  
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ededed', endColorstr='#dedede',GradientType=0 );  
    -webkit-box-shadow: inset 1px 1px 0px 0px rgba(250, 250, 250, .5);  
    -moz-box-shadow: inset 1px 1px 0px 0px rgba(250, 250, 250, .5);  
    box-shadow: inset 1px 1px 0px 0px rgba(250, 250, 250, .5);  
}  
.ui-datepicker-unselectable .ui-state-default {  
    background: #f4f4f4;  
    color: #b4b3b3;  
}  
.ui-datepicker-calendar .ui-state-hover {  
    background: #f7f7f7;  
}  
.ui-datepicker-calendar .ui-state-active {  
    background: #6eafbf;  
    -webkit-box-shadow: inset 0px 0px 10px 0px rgba(0, 0, 0, .1);  
    -moz-box-shadow: inset 0px 0px 10px 0px rgba(0, 0, 0, .1);  
    box-shadow: inset 0px 0px 10px 0px rgba(0, 0, 0, .1);  
    color: #e0e0e0;  
    text-shadow: 0px 1px 0px #4d7a85;  
    filter: dropshadow(color=#4d7a85, offx=0, offy=1);  
    border: 1px solid #55838f;  
    position: relative;  
    margin: -1px;  
}  

</style>
  
  <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
        
    
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
<?php 
include_once('../libs/links.php'); // DO NOT REMOVE OR CHANGE

                                        listlinks("Projects"); // CHANGE TO THE ACTIVE LINK

// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
include_once('status.html');

include('nav.php');

?>
</div>
<script>

  $(function() {
    $( ".newproject" ).draggable();
    $(".changeactive").draggable();
    $(".addmember").draggable();
    $(".dcats").draggable();

  });
  $(function(){  
        $('#datepicker').datepicker({  
            inline: true,  
            showOtherMonths: true,  
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],  
        });  
    });  
  
</script>

<div id="planhead" onload="MsgBox('Small Project','Small projects are projects that do not require the legal procedure and requirements of a business.', null, null, null, 3)"><a href="workspace.php">Workspace</a></div><!--Change to active link-->
<!--<div id="main" style="width:100%; padding-right: 0px">-->
<div id="wrktab1"><a href="/accsummary.php"><?php echo $_SESSION['usrdata']['screenname']; ?></a></div>
<!---->
<div id="mainwrk1">
<br />
<strong style="font-size: 1.5em;">Manage your Projects</strong>
<hr>
<?php
    include_once('../projects/sidebar.php');
?>
<b style="font-size: 2.5em;">  </b>
</div>
    Milestones : <span style="color:rgb(63, 98, 143);font-weight: bold;font-style:italic;">Project_Name</span><br /> <br />
    <a href="#" onclick="$('#datepicker').slideToggle('slow');">New Milestone</a><br />
    <div id="datepicker" style="display:none;"><br /><input type="text" placeholder="Date" style="width:50px;border-radius:3px 3px 3px 3px;"autofocus />
    <input type="text" placeholder="For" style="width:50px;border-radius:3px 3px 3px 3px;"autofocus /><br /><input type="text" placeholder="Description" style="border-radius:3px 3px 3px 3px;"autofocus />
    </div><br /><hr />
    The Calendar for viewing existing Milestones will be here.








<?php 
include_once('../libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>