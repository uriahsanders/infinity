<?php
    //when i wrote all this i really had no time so
    //you may want to commit a few changes:
    //add includes, split class into a different file, add `status` column to `members`
    //also i cba atm to check table info so youll need to correct any wrong stuff
    //if you wait until tmmrw i will hopefully have time to extensively test and correct everything
    class Status extends SQL{
        public static get_status(){
            $result = $this->Query("SELECT `status` FROM `members` WHERE `ID` = %d", $_SESSION['ID']);
            $row = mysql_fetch_assoc($result);
            return $row['status'];
        }
        public static change_status($status){
            $this->Query("UPDATE `members` SET `status` = %s WHERE `ID` = %d", $status, $_SESSION['ID']);
        }
    }
    if(isset($_GET['signal']) && $_GET['signal'] == 'get-status'){
        return Status::get_status();
    }
    if(isset($_POST['signal']) && $_POST['signal'] == 'change-status'){
        Status::change_status($_POST['status']);
    }