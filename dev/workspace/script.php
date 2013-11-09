<?php
	$_SERVER['DOCUMENT_ROOT'] .= '/infinity/dev'; //uriah
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    if(isset($_POST['token']) && $_POST['token'] != $_SESSION['token']){
        //CSRF defense; end immediately and log
        die();
    }
    interface Security{

    }
    class Person extends SQL implements Security{

    }
    class Observer extends Person{

    }
    class Member extends Observer{

    }
    class Supervisor extends Member{

    }
	class Manager extends Supervisor{

	}
	Class Creator extends Manager{

	}
	if(isset($_POST['signal'])){
		switch($_POST['signal']){

		}
	}
	if(isset($_GET['signal'])){
		switch($_GET['signal']){

		}
	}
