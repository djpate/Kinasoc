<?php

	namespace controllers;
	
	class user extends \application\controller{
		
		public function loginAction(){
			$this->render();
		}
		
		public function registerAction(){
			$this->render();
		}
		
		public function local_loginAction(){
			if(isset($_POST['login']) && isset($_POST['password'])):
				if(\application\user::login($_POST['login'],$_POST['password'])):
					\kinaf\routes::redirect_to("home","index");
				else:
					$this->add("error",_("Login / Mot de passe incorrect"));
					$this->add("login",$_POST['login']);
				endif;
			endif;
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
			if($this->connected){
				$this->connected_user->logout();
			}
			\kinaf\routes::redirect_to("home","index");
		}
		
		public function openid_loginAction(){
			$client = new \libs\openid\LightOpenID();
			
			if($_REQUEST['action']=="verify"  && !$client->mode ){
				$client->required = array("contact/email","namePerson/first","namePerson/last");
				$client->identity = $_REQUEST['openid_identifier'];
				header('Location: ' . $client->authUrl());
			} elseif($client->mode == 'cancel') {
				\kinaf\routes::redirect_to("user","login");
			} else {
				if($client->validate()){
					$user = \application\user::getByopenid_identifier($_REQUEST['openid_identity']); 
					if(is_object($user)){
						$_SESSION['account']['id'] = $user->id;
						\kinaf\routes::redirect_to("home","index");
					} else {
						$attributes = $client->getAttributes();
						$user = \application\user::getByemail($attributes['contact/email']);
						if( is_object($user) ){
							$user->addOpenidAccount($_REQUEST['openid_identity']);
							$_SESSION['account']['id'] = $user->id;
							\kinaf\routes::redirect_to("home","index");
						} else {
							$u = new \application\user();
							foreach($attributes as $id => $attribute):
								switch($id){
									case 'contact/email':
										$u->email =$attribute;
									break;
									case 'namePerson/first':
										$u->first =$attribute;
									break;
									case 'namePerson/last':
										$u->last =$attribute;
									break;
								}
							endforeach;
							$u->creationDate = date("d/m/Y G:i:s");
							$u->save();
							$u->addOpenidAccount($_REQUEST['openid_identity']);
							$u->givePoints(new \application\points_event(7));
							$u->loginProcess();
							\kinaf\routes::redirect_to("user","create_login");
						}
					}
				}
			}
		}
		
		public function createAction(){
			if(!$_REQUEST['recaptcha_response_field'] == ""):
				if( strlen($_REQUEST['login']) >= $this->params['minLengthLogin'] ):
					if( strlen($_REQUEST['password']) >= $this->params['minLengthPass'] ):
						if ( $this->verifyCaptcha($_REQUEST['recaptcha_challenge_field'],$_REQUEST['recaptcha_response_field']) ):
							if ( filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL) ):
								if( preg_match("^[a-zA-Z0-9]+^",$_REQUEST['login']) ):
									$u = \application\user::getByemail($_REQUEST['email']);
									if( is_null($u) ):
										$u = \application\user::getBylogin($_REQUEST['login']);
										if( is_null($u) ):
											// all the checks are good we create the user
											$u = new \application\user();
											$u->login = $_REQUEST['login'];
											$u->password = hash("sha512",$_REQUEST['password']);
											$u->email = $_REQUEST['email'];
											$u->creationDate = date("d/m/Y G:i:s");
											$u->save();
											$u->loginProcess();
											echo "ok";
										else:
											echo "err_7"; // login is allready used
										endif;
									else:
										echo "err_6"; // email is allready used
									endif;
								else:
									echo "err_8"; // space or special chars
								endif;
							else:
								echo "err_5"; // email is invalid
							endif;
						else:
							echo "err_4"; // captcha is bad
						endif;
					else:
						echo "err_3"; // password too short
					endif;
				else:
					echo "err_2"; // login too short
				endif;
			else:
				echo "err_1"; // captcha field is empty
			endif;
		}
		
		public function create_loginAction(){
			$this->render();
		}
		
		public function save_loginAction(){
			if( $this->connected ):
				if( strlen($_REQUEST['login']) >= $this->params['minLengthLogin'] ):
					$u = \application\user::getBylogin($_REQUEST['login']);
					if( is_null($u) ):
						$this->connected_user->login = $_REQUEST['login'];
						$this->connected_user->save();
						echo "ok";
					else:
						echo "err_3"; // login is allready used
					endif;
				else:
					echo "err_2"; // login too short
				endif;
			else:
				echo "err_1"; // not connected
			endif;
		}
		
		public function forgot_pwdAction(){
			if( isset($_POST['email']) && isset($_REQUEST['recaptcha_challenge_field']) && isset($_REQUEST['recaptcha_response_field']) ):
				if( $this->verifyCaptcha($_REQUEST['recaptcha_challenge_field'],$_REQUEST['recaptcha_response_field']) ):
					$u = \application\user::getByemail($_POST['email']);
					if( !is_null($u) && $u->password != "" ): // we verify that the user exists and that it's not an openid account
						$pass = \application\user::generatePassword();
						$u->password = hash("sha512",$pass);
						$u->save();
						
						$message = \Swift_Message::newInstance();
						$message->setSubject(_("Votre nouveau mot de passe"));
						$message->setFrom(array("info@kinasoc.com" => "Kinasoc"));
						$message->setTo(array($u->email));
						$message->setBody(sprintf(_("Votre nouveau mot de passe %s"),$pass));
						$this->mailer->send($message);
	
						echo "ok";
					else:
						echo "err_2"; // user not found
					endif;
				else:
					echo "err_1"; //invalid captcha
				endif;
			else:
				$this->render();
			endif;
		}
		
		public function ficheAction($id){
			$user = new \application\user($id);
			$this->add("user",$user);
			$this->render();
		}
		
		private function verifyCaptcha($challenge,$response){
			$handle = curl_init("http://www.google.com/recaptcha/api/verify");
			$post = array("privatekey"=>$this->params['reCaptcha_private'],
										"remoteip"=> $_SERVER['REMOTE_ADDR'],
										"challenge"=>$challenge,
										"response"=>$response);
			curl_setopt($handle, CURLOPT_POST, true);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
			$info = explode("\n",curl_exec($handle));
			if( $info[0] == "true" ){
				return true;
			} else {
				return false;
			}
		}
		
	}
	
?>
