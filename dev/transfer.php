<?php
if(isset($_SESSION['token']) && !empty($_SESSION['token']) && preg_match("/infinity-forum\.org$/", $_SERVER['HTTP_HOST']) && preg_match("/infinity-forum\.org$/", $_SERVER['SERVER_NAME'])){
    echo "";
}else{
    header("Location: index.php");
}
?>