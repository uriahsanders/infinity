<?php
function checkUrl($url){
    if(preg_match("/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/", $url)){
        return "true";
    }else{
        return "false";
    }
}
function getUrl($url){
    $result = checkUrl($url);
    if($result == "true"){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $data = curl_exec($ch);
        curl_close($ch);
        findTags($url, $data);
    }else{
        die("Unable to continue. " . $url . " is not a url.");
    }
}
function findTags($url, $html){
    preg_match("/<title>(.*)<\/title>/i", $html, $titles);
    if(count($titles) == 0){
        $titles = array("", $url);
    }
    echo json_encode($titles[1]) . "<br />";
    preg_match("/rel=\"shortcut icon\" (?:href=[\'\"]([^\'\"]+)[\'\"])?/", $html, $favicon);
    echo json_encode($favicon) . "<br />";
    $tags = get_meta_tags($url);
    if(count($tags) != 0){
        echo json_encode($tags) . "<br />";
    }else{
        $striped = strip_tags($html);
        $plaintxt = str_replace(array("\r\n", "\r", "\n", "\t"), " ", substr($striped, 0, 200));
        echo json_encode($plaintxt);
    }
}
if(isset($_GET['url']) && !empty($_GET['url'])){
    getUrl($_GET['url']);
}else{
    die("Error: There is not url set.");
}
?>