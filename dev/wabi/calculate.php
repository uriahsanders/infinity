<html>
<head>
<title>Celsius/Fahrenheit Converter</title>
</head>
<body bgcolor=#888888>
    <p align=center style="font-size:50"> Celsius/Fahrenheit Converter</p>
    <form name="temp" align=center action="calculate.php" method="POST" style= "fot-size: 25">
    Temperature: <input type="text" name="temp">
    <input type="radio" name="cf" value="Celsius"> Celsius
    <input type="radio" name="cf" value="Fahrenheit"> Fahrenheit
    <input type="submit" value="Convert" style="font-size: 17">
</form>
</body>
</html>
<?php
$temp = $_POST["temp"];
$type = (isset($_POST['cf']))?$_POST['cf']:"";
if ($type == "Celsius"){
    $result = 1.8 * $temp + 32;
        echo "<p align=center style=\"font-size:40\">$result Degrees Fahrenheit</p>";
} else if ($type == "Fahrenheit"){
    $result = ($temp - 32) * 0.56;
        echo "<p align=center style=\"font-size:40\">$result Degrees Celsius</p>";
} else {
        echo "<p align=center style=\"font-size:40\"> Please select Celsius or Fahrenheit.</p>";}

?>