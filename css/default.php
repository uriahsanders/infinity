/*
<?php
// for multiple color themes
if (!isset($_GET['style']))
    die(); //only access with get
    
function opacity($hex = "#000", $a = 1) { //convert hex to rgba and sets opacity on it
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
    return "rgba(".$r.",".$g.",".$b.",".$a.")";
}




switch($_GET['style']) {
    default: // only one theme so far
        $bg             =   "#272727";  //standard gray background
        $text1          =   "#fff";  // text color for the page
        $a              =   "#8c8993"; // link
        $a_h            =   "#fff"; // a:hover 
        $a_s2           =   "#576067"; // link shadow on menu
        $border1        =   "#000"; //border for buttons and some bars
        $border_shadow  =   "#fff"; //small white shadow for buttons and bars
}

header("Content-type: text/css; charset: UTF-8");
?>
*/
html, body {    
    margin:0;
    padding:0;
    background: url('/images/brushed_alu_dark.png');
    color: #fff;
    font-family: 'Droid Sans', sans-serif;
    width:100%;
    min-width:1000px
}

a {
    text-decoration:none;
    color:#8c8993;
    -webkit-transition: all linear 0.2s;
    -moz-transition: all linear 0.2s;
    -ms-transition: all linear 0.2s;
    -o-transition: all linear 0.2s;
    transition: all linear 0.2s;
}
a:hover {
    color: #fff;
}
#top{
    color:#fff;
    border:0;
    border-bottom:6px solid #000;
    border-top:6px solid #000;
    -moz-box-shadow:
        1px 1px 1px rgba(255,255,255,0.2);;
    -webkit-box-shadow:
        1px 1px 1px rgba(255,255,255,0.2);;
    box-shadow:
        1px 1px 1px rgba(255,255,255,0.2);;
    display: inline-box;
    white-space: nowrap;
    min-width: 600px; 
    background: url('/images/broken_noise.png');
    position:relative;
    margin-top:-13px;
    height: 61px; /*61*/
    z-index:1;
}
#logo:after {
    position:absolute;
    top:0;
    left:0;
    height:96px;
    width:340px;
    background:lime;
    background:url(/images/logo8.png);
    content: ' ';
    z-index:2;
}
#logo img {
    z-index:5;
}
#logo {
    width: 400px;
    position:absolute;
    display: inline-box;
    margin-top:4px; 
    left:0;
}

/* The logo does not support different Themes *//* Don't really like this style
#logo {
    font-family: 'Permanent Marker', cursive;
    font-weight: 400;
    font-size: 275%;
    text-shadow: #5e5c5c -2px -2px 1px, rgba(0,0,0,0.9) 0 8px 8px;
    position:relative;
    word-spacing: -8px;
    color: #888888;
    margin-left:19%;
}
#logo:before {
    content: "Infinit y-forum.org";
    position:absolute;
    left:0;
    text-shadow: 1px 1px 2px rgba(255,255,255,.4);
    color: #888888;
    -moz-background-clip: text;
    background-clip: text;
    background: url('/images/brushed_alu_dark.png'); 
    -webkit-text-fill-color: transparent; 
    -webkit-background-clip: text; 
}*/
/*
#logo {
    font-family: 'Permanent Marker', cursive;
    font-weight: 400;
    font-size: 275%;
    margin-left:19%;
    background-color: #666666;
    -webkit-background-clip: text;
    -moz-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: rgba(136,136,136,1) 1px 1px 0;
    position:relative;
    word-spacing: -8px;
    
}
#logo:before {
    content: "Infinit y-forum.org";
    position:absolute;
    left:0;
    text-shadow: 1px 1px 0px rgba(255,255,255,0);
    color: #888888;
    -webkit-background-clip: text;
    -moz-background-clip: text;
    background-clip: text;
background: url('/images/dark_stripes.png'); 
background-position: right bottom;
-webkit-text-fill-color: transparent; 
-webkit-background-clip: text; 
}*/


#top #menu{
    text-align: right;
    font-family: 'Oswald', sans-serif;
    font-size:100%;
    word-spacing:15px;
    white-space: nowrap;
    position:absolute;
    margin-top:35px;
    margin-left:40%;
}
#menu a {
    color: #fff;
    -webkit-transition: all linear 0.2s;
    -moz-transition: all linear 0.2s;
    -ms-transition: all linear 0.2s;
    -o-transition: all linear 0.2s;
    transition: all linear 0.2s;
    text-decoration:none;
}
#menu a:hover {
    color:  #fff;
    text-shadow:    0 0 1.25px  #fff, 
                    0 0 2.5px  #fff, 
                    0 0 3.75px  #fff, 
                    0 0 5px #576067, 
                    0 0 7.5px #576067, 
                    0 0 10px #576067, 
                    0 0 12.5px #576067, 
                    0 0 18px #576067;
}
#middle {
    text-align:center;
    height:370px;
    width:80%;
    min-width:800px;
    position:relative;
    margin: auto auto;
    z-index:1;
}

.bar {    
    padding:10px 0;
    font-weight:bold;
    font-size:65%;
    text-align:center;
    background: url('/images/broken_noise.png'); /* TEST */
    border-top: 6px solid rgba(0,0,0,1);
    border-bottom: 6px solid rgba(0,0,0,1);
    -moz-box-shadow:
        1px 1px 1px rgba(255,255,255,1),
        inset 0 1px 1px rgba(255,255,255,0.2);
    -webkit-box-shadow:
        1px 1px 1px rgba(255,255,255,1),
        inset 0 1px 1px rgba(255,255,255,0.2);
    box-shadow:
        1px 1px 0.1px rgba(255,255,255,0.2),
        inset 0 1px 1px rgba(255,255,255,0.2);
    display:inline-block;
    width:100%;
}


#main {
    position: relative;
    width:100%;
    background:url(/images/dark_stripes.png);
}
#main-body {
    width: 70%;
    margin: auto auto;
    position:relative;
    text-align:center;
}
#foot {
    position:relative;
    bottom:0px;
}

::-webkit-scrollbar              { width:10px; height:10px; background:rgba(27,27,27,1);}
::-webkit-scrollbar-button       { 
  background: -webkit-gradient(linear, left top, right top, color-stop(0%, #4d4d4d), color-stop(100%, #333333));
  border: 1px solid #0d0d0d;
  height: 10px;
  width: 10px;
  border-top: 1px solid #666666;
  border-left: 1px solid #666666; }
::-webkit-scrollbar-button:vertical:increment {background: rgb(27,27,27); background:url(/images/down.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:vertical:increment:active, ::-webkit-scrollbar-button:vertical:increment:hover { background:url(/images/down2.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:vertical:decrement {background: rgb(27,27,27);background:url(/images/up.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:vertical:decrement:active, ::-webkit-scrollbar-button:vertical:decrement:hover { background:url(/images/up2.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:horizontal:increment { background:url(/images/right.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:horizontal:increment:active, ::-webkit-scrollbar-button:horizontal:increment:hover { background:url(/images/right2.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:horizontal:decrement { background:url(/images/left.png) no-repeat; background-size:6px; background-position:center} 
::-webkit-scrollbar-button:horizontal:decrement:active, ::-webkit-scrollbar-button:horizontal:decrement:hover { background:url(/images/left2.png) no-repeat; background-size:6px; background-position:center} 

::-webkit-scrollbar-track        { }
::-webkit-scrollbar-track-piece  {background:rgba(79,79,79,1);}
::-webkit-resizer                {  }
::-webkit-scrollbar-thumb { 
  background: rgba(27,27,27,1);
  opacity: 0.5;
  border: 1px solid #0d0d0d;
  border-top: 1px solid #666666;
  border-left: 1px solid #666666;}
::-webkit-scrollbar-thumb:hover  { background:rgba(27,27,27,.6)}
::-webkit-scrollbar-corner       {  }


.btn_box, .btn, .tour-main {
    padding: 10px;
    font-weight:bold;
    font-size:65%;
    text-align:center;
    background: url('/images/broken_noise.png');
    border: 6px solid rgba(0,0,0,1);
    -moz-box-shadow:
        1px 1px 1px rgba(255,255,255,1),
        inset 0 1px 1px rgba(255,255,255,0.2);
    -webkit-box-shadow:
        1px 1px 1px rgba(255,255,255,1),
        inset 0 1px 1px rgba(255,255,255,0.2);
    box-shadow:
        1px 1px 0.1px rgba(255,255,255,0.2),
        inset 0 1px 1px rgba(255,255,255,0.2);
    display:inline-block;
}

#boxiz {
    position: relative;
    width:90%;
    min-height:340px;
    text-align:left;
    padding:0;
    margin:0;
    height:auto;
}
#mnu_left {
    float:left;
    width:20%;
    min-height:inherit;
    border-right: 6px solid rgba(0,0,0,1);
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    height:inherit;
}
#mnu_main {
    float:right;  
    width:80%;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    position:relative;
    min-height: inherit;
}

#mnu_left ul {
    list-style:none;
    padding:0;
    font-size:125%;
    margin:0;
    padding-bottom:2px;
}
#mnu_left li {
    margin:0;
    padding: 11px 0;
    border-bottom:2px solid #000;
    -moz-box-shadow:
        0px 1px 1px rgba(255,255,255,1);
    -webkit-box-shadow:
        0px 1px 1px rgba(255,255,255,1);
    box-shadow:
        0px 1px 0.1px rgba(255,255,255,0.2);
        
    -webkit-transition: all linear 0.2s;
    -moz-transition: all linear 0.2s;
    -ms-transition: all linear 0.2s;
    -o-transition: all linear 0.2s;
    transition: all linear 0.2s;
    
    padding-left:25px;
}
#mnu_left li[active], #mnu_left li:hover {
    background: rgba(255,255,255,.2);
    cursor:pointer;
    
}
.notification {
    position:absolute;
    width:300px;
    text-align:center;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    z-index: 50;
    padding: 7px;
    border:2px solid rgba(255,255,255,.3);
    font-weight:bold;
    font-size:75%;
    right: 5px;
    bottom: 10px;
    display:none;
}

.tour {
    width:100%;
    height:100%;
    z-index:100;
    position:fixed;
    top:0;
    left:0;
    background: #000;
    background: rgba(0,0,0,.7);
    display:none;
}
.tour-main {
    position: absolute;
}



















