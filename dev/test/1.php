<?php

$input = array("red", "green", "blue", "yellow");
array_splice($input, 3, 0, "purple");
// $input is now array("red", "green",
//          "blue", "purple", "yellow");

$name = array("my", "name");
    array_push($name, "relax");
array_splice($name,2,0,"is");
asort($name);
    print_r($name);
?>