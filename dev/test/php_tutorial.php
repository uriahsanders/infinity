<?php
    require_once 'tutorial/luminous.php';
echo "<html><head>";
echo luminous::head_html(); // outputs CSS includes, intended to go in <head>
echo "</head><body>";

    $source =  fopen( "part1.txt", "r" );
    $language = 'php';
    
    $contents = ''; 
    while (!feof($source)) 
    { 
    $contents .= fread($source, 8192); 
    } 
    fclose($source);
    
    
echo luminous::highlight('c', $contents);
echo "</body></html>";
?>
