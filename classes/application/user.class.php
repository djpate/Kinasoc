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
		
		public static function login($l,$p){
			$pdo = \kinaf\db::singleton();
			$q = $pdo->query("select id from user where login = ".$pdo->quote($l)." and password = ".$pdo->quote(hash("sha512",$p)));
			if($q->rowCount() == 1){
				$q = $q->fetch();
				$u = new user($q['id']);
				$u->loginProcess();
				return true;
			} else {
				return false;
			}
		}
		
		public static function validLogin($login){
			return preg_match("^([a-zA-Z0-9]+)^",$login);
		}
		
		public function __toString(){
			return $this->login."";
		}
		
		public function logout(){
			$_SESSION['account'] = array();
		}
		
		public function getPoints(){
			$q = $this->pdo->query("SELECT coalesce(sum(points),0) as points FROM points_event e,points p WHERE p.event = e.id and p.user = ".$this->id)->fetch();
			return $q['points'];
		}
		
		public function loginProcess(){
			$_SESSION['account']['id'] = $this->id;
			$today = date("d/m/Y");
			$lastLogin = date("d/m/Y",strtotime($this->lastLogin));
			if($today != $lastLogin){
				$this->presence = $this->presence + 1;
			}
			$this->lastLogin = date("d/m/Y G:i:s");
			$this->save();
		}
		
		public function givePoints($event,$vote = null){
			
			if(!is_null($vote)){
				$vote = $vote->id;
			} else {
				$vote = "NULL";
			}
			
			$this->pdo->exec("insert into points (user,event,date,vote) values (".$this->id.",".$event->id.",now(),".$vote.")");
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
