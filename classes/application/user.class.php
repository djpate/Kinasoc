<?php
	namespace application;
	
	class user extends \kinaf\modele {
		protected static $table = "user";
		
		public static function isConnected(){
			return true;
		}
		
		public static function connected(){
			return new user(1);
		}
		
	}
?>
