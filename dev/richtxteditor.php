<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
    <title>Rich Text editor</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery
/1.3.2/jquery.min.js">
    </script>
    <link rel="stylesheet" type="text/css" href="/css/dark.css" />
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <style>
body{
       background-color: #2d3035; 
       font-family: Arial;
}

#rte {
       width:40%;
       height:250px;
       border: 1px solid grey;
       
       
       background-color:#FFF;
       
       
}
#menu {
        width:40%;
        height:20%;
        
      
        
        text-align:center;
        font-weight:bold;
        
}
        
.emotes{
  cursor:pointer;
}
a:hover {
        color:white;
}
a:active{
        color:grey;
}
a{
  text-decoration:done;
   font-style:none;
}
.head1{
        font-style:italic;
            font-size:1.5em;
        }
        .head2{
         }
#italic{
        font-style:italic;
}
#underline{
        font-style:underline;
}
        
        .form{
            text-align:center;
            cursor:pointer;
        }
        .style{
       cursor:pointer;
        }
        #choice{
            cursor:pointer;
        }
        #box{
    font-size: 1em;
    font-weight: bold;
    text-align: center;
    opacity: 0.8;
    border-radius: 5px 5px 5px 5px;
    box-shadow: 0 0 4px #000000;
    text-align: center;
    margin-top: 0px;
    margin-bottom: 150px;
    width: 800px;
    height: 100px;
    padding-right: 2px;
    padding-left: 2px;
    box-shadow: 1px 1px 1px black;
    padding-bottom: 2px;
    padding-top: 5px;
    opacity: 0.8;
    position: absolute;
}
#vr{
color:grey;
}
.options{
color:rgb(63, 98, 143);
}
#select{
border-radius:3px 3px 3px 3px;
background-color:silver;
}
        
       
        

    </style>
    <script type="text/javascript">
        
$(function(){
    $('#rte').focus();
    $('#bold').click(function(){document.execCommand('bold', false, null);
        $('#rte').focus();return false;});
    $('#italic').click(function(){document.execCommand('italic', false, null);
        $('#rte').focus();return false;});
    $('#underline').click(function(){document.execCommand('underline', false, null);
        $('#rte').focus();return false;});
    $('#red').change(function(){document.execCommand('foreColor', false, 'red');
        $('#rte').focus();return false;});
    $('#center').click(function(){document.execCommand('justifyCenter', false, null);
        $('#rte').focus();return false;});
    $('#left').click(function(){document.execCommand('justifyLeft', false, null);
        $('#rte').focus();return false;});
    $('#right').click(function(){document.execCommand('justifyRight', false, null);
        $('#rte').focus();return false;});
    $('#st').click(function(){document.execCommand('strikeThrough', false, null);
        $('#rte').focus();return false;});
    $('#ol').click(function(){document.execCommand('insertOrderedList', false, null);
        $('#rte').focus();return false;});
    $('#ul').click(function(){document.execCommand('insertUnorderedList', false, null);
        $('#rte').focus();return false;});
     $('#rmv').click(function(){document.execCommand('removeFormat', false, null);
        $('#rte').focus();return false;});
    $('#sub').click(function(){document.execCommand('subscript', false, null);
        $('#rte').focus();return false;});
    $('#sup').click(function(){document.execCommand('superscript', false, null);
        $('#rte').focus();return false;});
});
        function changeRed(){
        document.execCommand('foreColor', false, 'red');
        $('#rte').focus();return false;
        }
    </script>
 
</head>
<body>
    <center>
    <br /><br /><br /><br /><br />
    <div id="all">
    <div id="menu" class="head1" >Create New Post</div><hr style="width:40%;" />
        <div id="menu" class="head2">Subject:<br /><input type="text" size="35" style="border-radius:3px 3px 3px 3px;"></div>
        <hr style="width:40%;" />
        <form>
        <select id="select" onchange="
            switch(this.value){
            case 'red': changeRed(); break;
            }
        ">
        <option selected>Font-Color</option>
        <option>Black</option>
            <option><a value="red">Red</a></option>
        <option>Yellow</option>
        <option>Pink</option>
        <option>Green</option>
        <option>Orange</option>
        <option>Purple</option>
        <option>Blue</option>
        <option>Beige</option>
        <option>Brown</option>
        <option>Teal</option>
        <option>Navy</option>
        <option>Maroon</option>
        <option>Green</option>
        <option>White</option>
        </select>
        
        
        
        
        <select id="select">
        <option selected>Font-Size</option>
        <option>8</option>
        <option>10</option>
        <option>12</option>
        <option>14</option>
        <option>18</option>
        <option>24</option>
        <option>36</option>
        </select>
        
         
        
        <select id="select">
        <option selected>Font-Family</option>
        <option>Courier</option>
        <option>Arial</option>
        <option>Arial Black</option>
        <option>Impact</option>
        <option>Verdana</option>
        <option>Times New Roman</option>
        <option>Georgia</option>
        <option>Andale Mono</option>
        <option>Trebuchet MS</option>
        <option>Comic Sans MS</option>
        </select>
        
        <select id="select">
        <option selected>Code</option>
        <option>Javascript</option>
        <option>HTML</option>
        <option>MYSQL</option>
        <option>PHP</option>
        <option>XML</option>
        </select>
        
        </form>
        <hr style="width:40%;" />
        <a id="bold" href="#" class="options" title="Bold">B</a>
        <b id="vr">|</b>
        <a id="italic" href="#" class="options" title="Italic">I</a>
        <b id="vr">|</b>
        <a id="underline" href="#" class="options" title="Underline">U</a>
        <b id="vr">|</b>
        <a id="st" href="#" class="options" title="Strikethrough">S</a>
        <b id="vr">|</b>
        <a id="left" href="#" class="options" title="Justify Left">Left</a>
        <b id="vr">|</b>
        <a id="center" href="#" class="options" title="Center Text">Center</a>
        <b id="vr">|</b>
        <a id="right" href="#" class="options" title="Justify Right">Right</a>
        <b id="vr">|</b>
        <a id="rmv" href="#" class="options" title="Remove Formatting">X</a>
        <b id="vr">|</b>
        <a id="sup" href="#" class="options" title="Superscript">Sup</a>
        <b id="vr">|</b>
        <a id="sub" href="#" class="options" title="Subscript">Sub</a>
        <b id="vr">|</b>
        <a id="hyper" href="#" class="options" title="Insert Hyperlink">Hyper</a>
        <b id="vr">|</b>
        <a id="ol" href="#" class="options" title="Ordered List">Ol</a>
        <b id="vr">|</b>
        <a id="ul" href="#" class="options" title="Un-ordered List">Ul</a>
        <hr style="width:40%;" />
    <div>
    <img style="cursor:pointer;"src="/images/cool.gif" title="Cool" onclick="document.getElementById('rte').innerHTML+='<img src=\'/images/cool.gif\'>';">
    &nbsp;<img style="cursor:pointer;"src="/images/smile.gif" title="Smile" onclick="document.getElementById('rte').innerHTML+='<img src=\'/images/smile.gif\'> ';">
    &nbsp;<img style="cursor:pointer;"src="/images/laugh.png" title="Laugh"onclick="document.getElementById('rte').innerHTML+='<img src=\'/images/laugh.png\'> ';">
    &nbsp;<img style="cursor:pointer;"src="/images/serious.png" title="Serious"onclick="document.getElementById('rte').innerHTML+='<img src=\'/images/serious.png\'> ';">
    &nbsp;<img style="cursor:pointer;"src="/images/tongue.png" title="Tongue"onclick="document.getElementById('rte').innerHTML+='<img src=\'/images/tongue.png\'> ';">
    &nbsp;<img style="cursor:pointer;"src="/images/wink.gif" title="Wink"onclick="document.getElementById('rte').innerHTML+='<img src=\'/images/wink.gif\'> ';">
 
    <!--Special Emoticons--><!--
    &nbsp;<img style="cursor:pointer;"src="/member/images/troll.png" title="Wink"onclick="document.getElementById('rte').innerHTML+='<img src=\'/member/images/troll.png\'> ';">
    &nbsp;<img style="cursor:pointer;"src="/member/images/youdont.png" title="Wink"onclick="document.getElementById('rte').innerHTML+='<img src=\'/member/images/youdont.png\'> ';">
    
    -->
    </div>
        
        <div id="rte" contenteditable="true" unselectable="off" style="color:black;text-align:left;border-radius:3px 3px 3px 3px;"></div>
        <div id="menu" class="menu style" style="padding-bottom: 5px;padding-top: 5px;"><input style="background-color:silver;border-radius:3px 3px 3px 3px;"type="submit" value="Post" onclick="putEmotes()" ></div>
    </div>
    </center>
    
</body>
</html>