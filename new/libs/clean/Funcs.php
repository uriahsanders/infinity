<?php
//This file contains general purpose functions

//remove value $val from array $arr
function remValueFromArr(&$arr, $val){
	if(($key = array_search($val, $arr)) !== false) {
	    unset($arr[$key]);
	}
}

//perform a each function in array $funcs for each index in array $arr
function doForAllInArray(&$arr, $funcs){
	foreach($arr as $key => $value){
		foreach($funcs as $func){
			$arr[$key] = call_user_func($func, $value);
		}
	}
}

//if preventing xss but still need some args to be filtered use this standard
function filter($input){
	return htmlspecialchars($input);
}