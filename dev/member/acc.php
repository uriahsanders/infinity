<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
$aid = (isset($_GET['id']) && preg_match('/^(\d)*$/',$_GET['id'])) ? $_GET['id'] : $_SESSION['ID'];
$act_array = lastactiv($aid);

foreach($act_array as $key => $value){
echo "<tr>";
echo "<td>"; 

echo ($value['child_to_t'] == 0) ? "Posted " : "Replied to ";
echo $value['subject'];


echo "</td>";
echo "<td> ".date('j/n/y H:i',strtotime($value['date']))." </td>";
echo "</tr>";

}
?>