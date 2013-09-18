<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/top.php'); //DO NOT REMOVE OR CHANGE 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/links.php'); // DO NOT REMOVE OR CHANGE
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
listlinks("Forum"); // CHANGE TO THE ACTIVE LINK

include_once($_SERVER['DOCUMENT_ROOT'].'/libs/middle.php'); //DO NOT REMOVE OR CHANGE
// UNDER HERE THE DIV content
// REMEMBER DIV ID=MAIN
// REMEMBER DIV ID=NEWS or LINKS
?>

      <link rel="stylesheet" type="text/css" href="/css/forum.css" /> 
<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/forum/index.php');
?>


<?php
    // msgbox('test','test');

?>




        
<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/bottom.php'); // DO NOT REMOVE OR CHANGE
?>
