<html>
<head>
<script type="text/javascript" src="nicEdit.js"></script>
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#to').autocomplete({source:'get_username.php', minLength:3
    });
});
</script>
<script type="text/javascript">
function add(){
    var fields = 0;
    if(fields == 12){
        document.write("You can only have 12 input boxes.");
    }else{
        var input = document.CreateElement("input");
        input.setAttribute("name", "to");
        input.setAttribute("maxlength", "30")
        input.setAttribute("value", "");
        document.body.appendChild(input);
    }
}
</script>
<script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
//]]>
</script>
<title>PM</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<nav>
<a href="inbox.php">Inbox</a>
</nav>
<?php
if(isset($_GET['status']) && $_GET['status'] == "empty"){
    echo "<br /><font color='red'>Please fill all the feilds.</font><br />";
}
if(isset($_GET['status']) && $_GET['status'] == "wrong"){
    echo "<br /><font color='red'>You didn't eneter characters that are allowed.</font><br />";
}
if(isset($_GET['status']) && $_GET['status'] == "sent"){
    echo "<br /><font color='green'>Your message has been sent.</font><br />";
}
if(isset($_GET['status']) && $_GET['status'] == "fail"){
    echo "<br /><font color='red'>Sorry, your message couldn't be sent please try again.</font><br />";
}
?>
<form action="send.php" method="post">
<p>
To:<br /><input type="text" name="to[]" maxlength="30" id="to" value="" /> <input type="button" value="add field" onclick="add()" />
<br />
Subject:<br /><input type="text" name="subject" maxlength="100" value="" />
<br />
<br />
<textarea name="body" cols="80" rows="15" maxlength="5000" id="body"></textarea>
<br />
<input type="submit" name="send" value="Send" />
</p>
</form>
</body>
</html>