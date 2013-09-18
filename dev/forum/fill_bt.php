<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
$con = mysql_connect("localhost", "infiniz7_web", "p,G4?+B@n5~8]XIRP(") or die(mysql_error());
mysql_select_db("infiniz7_infinity") or die(mysql_error());

    $result = mysql_query("SELECT * FROM forum_structure") or die(mysql_error());
    
    while($row = mysql_fetch_array($result)) { //list boards
        if ($row['type'] != 0) {
            $r = rand(8,30);
            $r2 = rand(1, intval($r/2));
            
            for ($k = 0; $k <= $r; $k++){
                 $lo = rand(1,6);$l = array();
                 if ($lo != 1) $lo = 0;
                 $st = rand(1,14);
                 if ($st != 1) $st = 0;
                 $conn = mysql_query("INSERT INTO forum (`ID`, `icon`, `icon2`, `sticky`, `locked`, `subject`, `text`, `by`, `views`, `date`, `child_to_b`, `child_to_t`, `IP`) VALUES (NULL, '0', '0', '".$st."', '".$lo."', '".$row['name']." subject ".$k."', '".$row['name']." text ".$k."', '".rand(1,6)."', '".rand(5,1000)."', '".date("Y-m-d H:i:s",mt_rand(1104562800,1609398000))."', '".$row['ID']."', '0', '127.0.0.1');") or die(mysql_error());
                 array_push($l, mysql_insert_id());
                 $r3 = rand(8,30);
                for ($i = 0; $i <= $r3;$i++) {
                     $conn = mysql_query("INSERT INTO forum (`ID`, `icon`, `icon2`, `sticky`, `locked`, `subject`, `text`, `by`, `views`, `date`, `child_to_b`, `child_to_t`, `IP`) VALUES (NULL, '0', '0', '0', '0','".$row['name']." subject ".$k."', '".$row['name']." subject ".$k." reply ".$i."', '".rand(1,6)."', '0', '".date("Y-m-d H:i:s",mt_rand(1104562800,1609398000))."', '".$row['ID']."', '".$l[0]."', '127.0.0.1');") or die(mysql_error());
                     $iid = mysql_insert_id();
                }
            }
        }
    }

echo "DONE!!";




?>