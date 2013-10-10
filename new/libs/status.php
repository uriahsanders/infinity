<?php
	@define("INFINITY", true);
	include_once("relax.php");
    //when i wrote all this i really had no time so
    //you may want to commit a few changes:
    //add includes, split class into a different file, add `status` column to `members`
    //also i cba atm to check table info so youll need to correct any wrong stuff
    //if you wait until tmmrw i will hopefully have time to extensively test and correct everything
    class Status extends SQL{
        //i thought a class might be neccesary since more functions may eventually be added
        //always good to be prepared
        function get_status(){
            $result = $this->Query("SELECT status,status_time FROM `memberinfo` WHERE `ID` = %d", $_SESSION['ID']); //changed to mamberinfo because we don't want things in members (pwd hash and core member info is there(eg if a vurln if found there or something happens there the user can be deleted or corrupt)
			//also get status_time
            $row = mysql_fetch_assoc($result);
            return $row['status'];
        }
        function change_status($status){
            $this->Query("UPDATE `memberinfo` SET `status` = %d, `status_time` = %s WHERE `ID` = %d", $status, date("Y-d-m H:i:s"), $_SESSION['ID']); // update the status_time as well...
        }
    }
	$Status = new Status;
	
    if(isset($_GET['signal']) && $_GET['signal'] == 'get-status'){
        echo $Status->get_status();
    }
	if(isset($_POST['signal']) && $_POST['signal'] == 'change-status' && isset($_POST['status']) && preg_match("/^([0-9]+)$/", $_POST['status'])){ 
		//check the post status as well and we will be using int's to store
        $Status->change_status($_POST['status']);
    }
	
?>