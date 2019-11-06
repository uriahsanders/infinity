<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SQL class</title>
<style type="text/css">
.box {
	background-color: #CCCCCC;
	border:2px solid #000;
}
h2 { margin:0;}
</style>
</head>

<body>

All varables are cleaned with  mysql_real_escape_string() and htmlspecialchars() to prevent SQL-injection and XSS<br/>
<font color="#FF0000">DO NOT USE any type of quotes in the query eg ' or ", that will be added automaticly before executed</font><br/>

<?php
echo "<h2>Example 1 - simple query</h2>";
echo "<div class=\"box\">";
highlight_string('<?php
	$sql = new SQL();	//will create the connection to the database for you
	$results = $sql->Query("SELECT * FROM information");	//standard query
	while($row = mysql_fetch_array($results))	//rest is same as ordanary MySQL
	{
		[...]
	}
?>');
echo "</div>";
?>
<?php
echo "<h2>Example 2 - query vid variables</h2>";
echo "<div class=\"box\">";
highlight_string('<?php
	$sql = new SQL();	//will create the connection to the database for you
	$id= 10; // int
	$text = "%READ ME%"; // string (dates and times are strings as well)
	$importants = 0.8;  // float
	$results = $sql->Query("
				SELECT * FROM information 
				WHERE 
				id=%d //this is an int so we use %d to make the query know
				OR 
				text LIKE %s // a string is assigned with %s 
				OR 
				importants >= %f // float %f
				", $id, $text, $importants ); // here we give the values that will give have places
				
	while($row = mysql_fetch_array($results))	//rest is same as ordanary MySQL
	{
		[...]
	}
?>');
echo "</div>";
?>
<?php
echo "<h2>Example 3 - query without CleanQuery (dangerous)</h2>";
echo "<div class=\"box\">";
highlight_string('<?php
	$sql = new SQL();	//will create the connection to the database for you
	$sql->CLEAN = false; //will turn off CleanQuery at execution
	$results = $sql->Query("SELECT * FROM information WHERE text LIKE %s", "%IM GOING TO STAY A DIRTY, DIRTY STRING%");
	[...]
?>');
echo "</div>";
?>
<?php
echo "<h2>Example 4 - query with partial CleanQuery (dangerous)</h2>";
echo "<div class=\"box\">";
highlight_string('<?php
	$sql = new SQL();	//will create the connection to the database for you
	$sql->CLEAN = false; //will turn off CleanQuery at execution
	$string = $sql->cleanQuery(
						"%I... am.... weeeeeaaak......%", // the string that you want to partial clean
						false, // this turns the XSS preventation off
						true, // this will replace all new lines \n to <br /> this is good for user inputs, but make sure you have XSS true for this
						true, // this will prevent more then dubble new lines to keep the text short requires the argument before to be true
						);
	$results = $sql->Query("SELECT * FROM information WHERE text LIKE %s", $string); //add the variable you have partially cleaned
	[...]
?>');
echo "</div>";
?>

// Relax
</body>
</html>