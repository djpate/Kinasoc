<?php

	namespace controllers;
	
	class user extends \application\controller{
		
		public function loginAction(){
			$this->render();
		}
		
		public function registerAction(){
			$this->render();
		}
		
		public function register_helperAction(){
			if(isset($_REQUEST['email'])){
				$u = \application\user::getByemail($_REQUEST['email']);
			} else if(isset($_REQUEST['login'])){
				$u = \application\user::getBylogin($_REQUEST['login']);
			}
			
			if( is_null($u) ){
				echo "true";
			} else {
				echo "false";
			}
		}
		
		public function logoutAction(){
			$this->connected_user->logout();
			\kinaf\routes::redirect_to("home","index");
		}
		
		public function openid_loginAction(){
			$client = new \libs\openid\LightOpenID();
			
			if($_REQUEST['action']=="verify"  && !$client->mode ){
				$client->required = array("contact/email","namePerson/first","namePerson/last","namePerson/friendly");
				$client->identity = $_REQUEST['openid_identifier'];
				header('Location: ' . $client->authUrl());
			} elseif($client->mode == 'cancel') {
				
			} else {
				if($client->validate()){
					$user = \application\user::findByopenid_identifier($client->identify); 
					if(is_object($user)){
						$_SESSION['account']['id'] = $user->id;
						\kinaf\routes::redirect_to("home","index");
					} else {
						// new account
						print_r($_REQUEST);
						$u = new \application\user();
						$u->email = $_REQUEST['openid_ext1_value_contact_email'];
						$u->first = $_REQUEST['openid_ext1_value_namePerson_first'];
						$u->last = $_REQUEST['openid_ext1_value_namePerson_last'];
						$u->login = $_REQUEST['openid_ext1_value_namePerson_friendly'];
						$u->openid_identifier = $_REQUEST['openid_identity'];
						$u->save();
						$_SESSION['account']['id'] = $u->id;
						\kinaf\routes::redirect_to("home","index");
					}
				}
			}
		}
		
	}
	
?>
