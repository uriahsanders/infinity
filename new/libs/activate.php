<?php
    if (isset($_GET['code']) && strlen($_GET['code']) == 32) {
        define("INFINITY", true);
        include_once('relax.php');
        $login = Login::getInstance();
        
        $status = $login->ActivateAccount($_GET['code']);    
        ////////// $status /////////
        // 0 = connection error
        // 1 = activated
        // 2 = already activated
        // 3 = did not find the code
        ////////////////////////////
        switch ($status)
        {
            case 0:
                header("Location: /member/activate/error");
                die();
            case 1:
                header("Location: /member/activate/done"); 
                die();
            case 2:
                header("Location: /member/activate/active");
                die();
            case 3:
                header("Location: /member/activate/notfound");
                die();
        }
    }
?>