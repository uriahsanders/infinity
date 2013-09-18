<?php
function listlinks($page, $path = "")
{
    $links = array(
        "/" => "Start",
        "/member/"=>"",
        "/projects/" => "Projects",
        "/forum/" => "Forum",
        "/about/" => "About",
        "/infinity/index.php" => "Infinity",
        "/help/" => "Help"
    );
    if (isset($_SESSION["loggedin"] ) && $_SESSION["loggedin"]  == "YES")
        $links["/member/"] = "Lounge";
    $links = array_reverse($links);
    
       
  
    
    echo '<ul>';
    foreach ($links as $k => &$n) {
        if ($n != "") {
            echo '<li><a href="'. $path . $k . '"';
            if (strtolower($n) == strtolower($page)) {
                echo ' id="topbar_active"';
            }
            echo '>' . $n . '</a></li>';
        }
    }
    echo '</ul>';
}
?>