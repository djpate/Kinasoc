<?php
	namespace application;
	
	class user extends \kinaf\modele {
		protected static $table = "user";
		
		public static function isConnected(){
			if(isset($_SESSION['account']['id'])){
				return true;
			} else {
				return false;
			}
		}
		
		public static function connected(){
			if(static::isConnected()){
				return new user($_SESSION['account']['id']);
			} else {
				return null;
			}
		}
		
		public function __toString(){
			return $this->login."";
		}
		
		public function logout(){
			$_SESSION['account'] = array();
		}
		
		public function getPoints(){
			return 1500;
		}
		
		/**
		 * Get either a Gravatar URL or complete image tag for a specified email address.
		 *
		 * @param string $email The email address
		 * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
		 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
		 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
		 * @return String containing just a URL
		 * @source http://gravatar.com/site/implement/images/php/
		 */
		function get_gravatar($s = 40, $d = 'mm', $r = 'r') {
			$url = 'http://www.gravatar.com/avatar/';
			$url .= md5( strtolower( trim( $this->email ) ) );
			$url .= "?s=$s&d=$d&r=$r";
			return $url;
		}

		
	}
?>
