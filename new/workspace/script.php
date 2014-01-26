<?php
$workspace = new Workspace();
$projects = new Projects();
switch($_SERVER['REQUEST_METHOD']){
	case 'POST':
		if(!$_POST['token'] || $_POST['token'] != $_SESSION['token']) die(); //CSRF defense
		switch($_POST['signal']){
			case 'newWorkspace':

				die();
			case 'deleteElement':

				die();
			case 'deleteElementVersion':

				die();
			case 'comment':

				die();
			case 'changeStatus':

				die();
			case 'leaveProject':

				die();
			case 'passLead':

				die();
			case 'deleteWorkspace':
				
				die();
			case 'createBranch':

				die();
			case 'editBranch':

				die();
			case 'deleteBranch':

				die();
			case 'launch':

				die();
			case 'changePrivilege':

				die();
			case 'removeMember':

				die();
			case 'addMember':

				die();
			case 'acceptMember':

				die();
			case 'denyMember':

				die();
			case 'getAdvancedMemberInfo':

				die();
			case 'createElement':

				die();
			case 'createElementVersion':

				die();
			case 'changeTaskStatus':

				die();
			case 'goToEvent':

				die();
			case 'addFile':

				die();
			case 'removeFile':

				die();
			case 'dismissSuggestion':

				die();
			case 'approveSuggestion':

				die();	
		}
		die();
	case 'GET':
		switch($_GET['signal']){
			case 'application':

				die();
			case 'getElement':

				die();
			case 'search':

				die();
			case 'loadMore':

				die();
		}
		die();
}
	//HTML insertion functions:
	function elementTemplate(){

	}
	function thumbnailTemplate(){
		
	}
	function controlTemplate(){

	}
	function form(){

	}
	//repetition safe functions:
	