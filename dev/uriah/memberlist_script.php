<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/libs/lib.php');
    include_once('test_framework.php');
    class Memberlist extends SQL{
        const LIMIT = 30;
        const APPEND = 1;
        private static $ranks = array('member' => 1, 'trusted' => 2, 'VIP' => 3, 'MOD' => 4, 'GMOD' => 5, 'admin' => 6);
        private function tr_row($id, $username, $rank, $reg_date){
            return '
                <tr class="memberRow'.$id.'">
                    <td><a>'.$username.'</a></td><td>'.$rank.'</td><td>0</td><td>'.$reg_date.'</td><td>Online</td>
                </tr>
            ';
        }
        public function main(){
            $return = NULL;
            $result = $this->Query("SELECT * FROM `memberinfo` ORDER BY `id` LIMIT %d", self::LIMIT);
            while($row = mysql_fetch_assoc($result)){
                $return .= $this->tr_row($row['ID'], $row['username'], $row['rank'], $row['reg_date']);
            }
            return $return;
        }
        public function user_info($username, $rank, $location, $reg_date, $last_login){
            return '
                <div id="IMG">
                    Profile photo
                </div>
                <div id="head">
                    <a>'.$username.'</a>, Rank: '.$rank.'
                </div>
                <div id="body">
                    Location: '.$location.', Last login: '.$last_login.'<br />
                    Joined: '.$reg_date.'
                </div>
            ';
        }
        private function rank2val($rank){
            return self::$ranks[$rank];
        }
        private function pr($key, $val){
            if($val == NULL || $val == FALSE){
                if(array_key_exists($key, self::$ranks)) return 'rank';
                return $key;
            }else{
                if(array_key_exists($key, self::$ranks)){
                    return $this->rank2val($key);
                }else if($key == 'male' || $key == 'female'){
                    return $key;
                }else if($key == 'username' || $key == 'skills' || $key == 'location'){
                    return '%'.$val.'%';
                }else return $val;
            }
        }
        public function search($filter, $append = FALSE, $limiter = 0){
            if($filter['all'] == TRUE) die($this->main());
            else{
                $return = NULL;
                $action = ($append == FALSE) ? self::LIMIT : self::APPEND;
                $result = $this->Query('SELECT * FROM `memberinfo` WHERE `username` LIKE %s AND `location` LIKE %s 
                AND (`rank` = %s OR `rank` = %s OR `rank` = %s OR `rank` = %s OR `rank` = %s OR `rank` = %s)
                AND `age` = %s AND (`sex` = %s OR `sex` = %s) AND `skills` LIKE %s ORDER BY `reg_date` DESC LIMIT %d, %d',
                $this->pr('username', $filter['username']), $this->pr('location', $filter['location']), $this->pr('member', $filter['member']), $this->pr('trusted', $filter['trusted'])
                , $this->pr('VIP', $filter['VIP']), $this->pr('MOD', $filter['MOD']), $this->pr('GMOD', $filter['GMOD']), $this->pr('admin', $filter['admin'])
                , $this->pr('age', $filter['age']), $this->pr('male', $filter['male']), $this->pr('female', $filter['female']), $this->pr('skills', $filter['skills'])
                , $limiter, $action
                );
                while($row = mysql_fetch_assoc($result)){
                    $return .= $this->tr_row($row['id'], $row['username'], $row['rank'], $row['reg_date']);
                }
                return $return;
            }
        }
    }
    if(isset($_POST['signal'])){
        $memberlist = new Memberlist();
        if(isset($_POST['filtering'])) $filtering = json_decode($_POST['filtering'], TRUE);
        switch($_POST['signal']){
            case 'get':
                $result = $memberlist->Query("SELECT * FROM `memberinfo` WHERE `id` = %d", $_POST['id']);
                $row = mysql_fetch_assoc($result);
                die($memberlist->user_info($row['username'], $row['rank'], $row['location'], $row['reg_date'], $row['last_login']));
            case 'search':
                die($memberlist->search($filtering));
            case 'infiniteScroll':
                die($memberlist->search($filtering, TRUE, $_POST['limiter']));
        }
    }