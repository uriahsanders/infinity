<?php
function geturl(){
    if(isset($SERVER['HTTP_REFERER'])){
        $url = $_SERVER['HTTP_REFERER'];
        echo "<a href=$url>Back</a>";
    }
}
?>