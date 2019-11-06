<?php
	@define("INFINITY", true);
	include_once("relax.php");
    //when i wrote all this i really had no time so
    //you may want to commit a few changes:
    //add includes, split class into a different file, add `status` column to `members`
    //also i cba atm to check table info so youll need to correct any wrong stuff
    //if you wait until tmmrw i will hopefully have time to extensively test and correct everything
    class Status{
        //i thought a class might be neccesary since more functions may eventually be added
        //always good to be prepared
		private $_db;
		
		public function __construct()
		{
			// [TODO] - fix this class
			$this->_db = Database::getInstance();	
		}
        function getStatus($ID = 0){
			if ($ID == 0) // if not specified
				$ID = @$_SESSION['ID']; //current user
				
            $result = $this->_db->query("SELECT status,status_time FROM `memberinfo` WHERE `ID` = ?", $ID); //changed to mamberinfo because we don't want things in members (pwd hash and core member info is there(eg if a vurln if found there or something happens there the user can be deleted or corrupt)
			//also get status_time
            $row = $result->fetch();
			
			if ($ID == $_SESSION['ID']) //if the current user check status
				$this->_db->query("UPDATE `memberinfo` SET `status` = ?, `status_time`=? WHERE `ID` = ?", $row['status'], date("Y-m-d H:i:s"), $ID); //update the timestamp so it on't show offline.
			else if (strtotime($row['status_time']) <= strtotime("-30 min")) //more than 30 min sience last update
				return 0; //show as offline
				
				
            return $row['status'];
        }
        function changeMyStatus($status){
			$this->_db->query("  UPDATE 
								`memberinfo` 
							SET 
								`status` = ?,
								`status_time`=?
							WHERE 
								`ID` = ?"
							, $status, date("Y-m-d H:i:s"), $_SESSION['ID']); // update the status_time as well...
			
        }
    }
	$Status = new Status;
	
    if(isset($_GET['signal']) && $_GET['signal'] == 'get-status'){
        echo $Status->getStatus();
    }
	if(isset($_POST['signal']) && $_POST['signal'] == 'change-status' && isset($_POST['status']) && preg_match("/^([0-9]+)$/", $_POST['status'])){ 
		//check the post status as well and we will be using int's to store
        $Status->changeMyStatus($_POST['status']);
    }
	
?>