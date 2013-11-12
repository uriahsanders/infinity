<?php
    $_SERVER['DOCUMENT_ROOT'] .= '/infinity/dev';
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    interface Security{
        public function verify_params($rest, $arr);
    }
    class Person implements Security{
        public $DATA = [];
        //check array for isset
        public function verify_params($rest, $arr){
            for($i = 0; $i < count($arr); $i++){
                $j = $arr[$i];
                if(!isset($rest[$j])){
                    die(self::suspect('Required parameter not set.'));
                }
            }
        }
        //log suspicious activity
        public static function suspect($info = ''){

        }
        //convert array into pdo notation
        private function arr2PDO(&$arr){
            $new = [];
            foreach($arr as $key => $value){
                $new[':'+$key] = $value;
            }
            $arr = $new;
        }
        public function create_workspace($arr){
            $pdo = PDO();
            $st = $pdo->prepare("INSERT INTO `workspace`
             (`name`, `creator`, `date`, `popularity`, `category`, `description`, `launched`)
             VALUES (:name, :creator, :date, :popularity, :category, :description, :launched)
             ");
            $this->arr2PDO($arr);
            $st->execute($arr);
        }
        //does user already have a workspace?
        public function workspace_exists(){
            $pdo = PDO();
            $st = $pdo->prepare('SELECT `id` FROM `workspace` WHERE `creator` = ? LIMIT 1');
            $args = [$_SESSION['ID']];
            $st->execute($args);
            $data = '';
            foreach($st->fetchAll(PDO::FETCH_NAMED) as $row){
                $data .= $row['id'];
            }
            if($data == '') return 'false';
            return $data;
        }
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
    class Workspace extends Creator{
        
    }