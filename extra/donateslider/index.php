<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Papermashup.com | jQuery UI Slider Demo</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> 
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script> 
        <style type="text/css"> 
#container{
background:url(bg.jpg)!important;
padding:100px 50px 0px 50px;
}

/*the slider background*/
.slider {
width:230px;
height:11px;
background:url(slider-bg.png);
position:relative;
margin:0;
padding:0 10px;
}

/*Style for the slider button*/
.ui-slider-handle {
width:24px;
height:24px;
position:absolute;
top:-7px;
margin-left:-12px;
z-index:200;
background:url(slider-button.png);
}

/*Result div where the slider value is displayed*/
#slider-result {
font-size:50px;
height:200px;
font-family:Arial, Helvetica, sans-serif;
color:#fff;
width:250px;
text-align:center;
text-shadow:0 1px 1px #000;
font-weight:700;
padding:20px 0;
}

/*This is the fill bar colour*/
.ui-widget-header {
background:url(fill.png) no-repeat left;
height:8px;
left:1px;
top:1px;
position:absolute;
}

a {
outline:none;
-moz-outline-style:none;
}

	 
        </style> 
</head>
<body>
<?php include '../includes/header.php';
        $link = '| <a href="http://papermashup.com/jquery-growl-notification-plugin/">Back To Tutorial</a>';
?>


  
        <div class="slider"></div> 
        <div id="slider-result">50</div>   
  		<input type="hidden" id="hidden"/>
  
           <script> 
         
	             $( ".slider" ).slider({
			    animate: true,
                range: "min",
                value: 50,
                min: 10,
                max: 100,
				step: 10,
                
				//this gets a live reading of the value and prints it on the page
                slide: function( event, ui ) {
                    $( "#slider-result" ).html( ui.value );
                },

				//this updates the hidden form field so we can submit the data using a form
                change: function(event, ui) { 
                $('#hidden').attr('value', ui.value);
                }
			
				});


        </script> 


<?php include '../includes/footer.php';?>
</body>
</html>