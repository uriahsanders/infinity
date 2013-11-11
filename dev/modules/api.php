<?php
	/*Examples are at bottom*/
	//include dependancies
	include_once();
	//include all API compatible classes
	include_once();
	final class API{
		private $id;
		private $key;
		private $user;
		private $encryption;
		//key is what user calls, value is what it's replaced with
		private $semantic = [
			//EX: 'Workspace' => 'class_with_workspace_methods'
		];
		public function __construct($id, $key, $user = false, $encryption = false){
			$this->id = $id;
			$this->key = $key;
			$this->user = $user;
			$this->encryption = $encryption;
			if($user){
				//login and do request with oAuth
			}
		}
		//convert semantic names to class names
		private function convert(&$class){
			foreach($this->semantic as $key => $value){
				//if class name is not already valid
				if($class != $value){
					//given class matches a semantic so give it that value
					if($class == $key){
						$class = $value;
					}
				}
			}
		}
		//decrypt both the key and the params
		private function decrypt(&$params){

		}
		//verify API id and key
		private function verify(){
			
		}
		//check if the params are valid
		public static function isValid(){
			return (isset($_REQUEST['id']) && isset($_REQUEST['key']) 
				&& isset($_REQUEST['class']) && isset($_REQUEST['action']));
		}
		//see if we need to decode
		private function isJSON($str){
			json_decode($str);
			return(json_last_error() == JSON_ERROR_NONE);
		}
		//parse array into $class->doRequest(); and return result
		private function accept($a){
			$result = [];
			//will catch if class/method does not exist
			try{
				$class = new $a['class']();
				$result['data'] = $class->$a['action']($a['args']);
				$result['success'] = true;
			}catch(Exception $e){
				$result['success'] = false;
				//return actual php error and likely error
				$result['phpError'] = $e->getMessage();
				$result['error'] = 'Class or method may not exist. 
				Please consult API documentation or "phpError" for additional information.';
			}
			return json_encode($result);
		}
		//perform decryption, decoding, and conversions, then accept request
		public function send($params){
			//decrypt
			if($this->encryption == true){
				$this->decrypt($params);
			}
			//if it's json parse it
			if($this->isJSON($params)){
				$params = json_decode($params);
			}
			//convert invalid class names to a valid one if we can
			$this->convert($params['class']);
			//return final response
			return $this->accept($params);
		}
		//create an API id and key
		public static function generate(){

		}
	}
	//do stuff to accept() requests
	if(isset($_REQUEST)){
		if(API::isValid()){
			$user = $_REQUEST['user'] || false;
			$encryption = $_REQUEST['encryption'] || false;
			$args = $_REQUEST['args'] || [];
			$api = new API($_REQUEST['id'], $_REQUEST['key'], $user, $encryption);
			$result = $api->send([
				'class' => $_REQUEST['class'],
				'action' => $_REQUEST['action'],
				'args' => $_REQUEST['args']
			]);
			die($result);
		}
		die("Your API request was not valid.");
	}
	/*
		Examples -Creating a workspace document
		----------------------------------------
		JS Example:
		$.ajax({
			url: 'api.infinity-forum.org',
			type: 'POST',
			data: {
				id: id,
				key: key,
				user: true,
				'class': 'workspace',
				action: 'createDocument',
				'args': {
					title: 'My first API call!',
					description: 'This is a description'
				}
			},
			success: function(data){
				alert(data);
			}
		});

		PHP would use CURL...
	*/