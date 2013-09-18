<?
include_once($_SERVER['DOCUMENT_ROOT']."/libs/lib.php");
$con = SQL_connect();
SQL_selectDB($con);

$q = mysql_real_escape_string($_POST["q"]);
$rs = mysql_query("SELECT ID AS id, username, screenname,image from memberinfo WHERE username LIKE '%".$q."%' or screenname LIKE '%".$q."%' ORDER BY last_login DESC LIMIT 10");
$arr = array();

while($obj = mysql_fetch_object($rs)) {
    $arr[] = $obj;
}

$json_response = json_encode($arr);
echo $json_response;
?>
