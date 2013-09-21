<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');

if (isset($_GET['username'])) {
    echo checkdub('username', $_GET['username']);
} elseif (isset($_GET['email'])) {
    echo checkdub('email', $_GET['email']);
} else {
    die('Sorry that is not allowed');
}
?>