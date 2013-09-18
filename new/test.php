<!--<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
</head>
<script type="text/javascript">

function Lol()
{
	var sel = document.getSelection();var txt = sel.toString();var regex = /\[\/?[a-z=0-9]+]/i;while (txt.match(regex)){txt = txt.toString().replace(regex, "");}alert(txt);
}


</script>
<body>-->
<?php
	$str = '<div class="" active>';
	$regex = '/class=\"(.+)?\"/';
	$new_class = "NO_ME_RULES";
	echo preg_replace($regex,"class=\"".$new_class."\"", $str);
?>
<!--

<textarea class="editor">
ahjskdh [B]lol[/B] asdasdasd
</textarea>
</body>
</html>-->