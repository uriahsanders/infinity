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
        public $DATA = [];
    }
    class Observer extends Person{

    }
    class Member extends Observer{

    }
    class Supervisor extends Member{

    }
	class Manager extends Supervisor{

	}
	class Creator extends Manager{

	}
	if(isset($_POST['signal'])){
		switch($_POST['signal']){

		}
	}
	if(isset($_GET['signal'])){
        $type = $_GET['type'];
        $desc = '';
		switch($_GET['signal']){
            case 'getPopup':
                switch($type){
                    case 'messages':
                        $desc .= '';
                        break;
                    case 'requests':
                        $desc .= '';
                        break;
                    case 'options':
                        $desc .= '';
                        break;
                    case 'current':
                        $desc .= '';
                        break;
                }
                $popup = '<div class="dim"></div>
                <div class="cms_popup">
                    <div class="cms_popup_head">
                        <b style="font-size:1em;">'.ucfirst($type).'</b>
                    </div>
                    <br /><br />
                    <div class="cms_popup_body">
                        '.$desc.'
                    </div>
                    <br /><br />
                    <button class="close">Close</button>
                </div>';
                die($popup);
                break;
		}
	}
