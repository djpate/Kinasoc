<?php

namespace kinaf;

	class administrator extends modele {
		
		protected static $table = "administrator";
		
		public function isConnected(){
			return $this->id != 0;
		}
		
		public function logIn($l,$p){
			$ret = false;
			$q = $this->pdo->query("select id from ".self::$table." where login = ".$this->pdo->quote($l)." and password = '".hash('sha512',$p)."'");
			if($q->rowCount()==1){
				$res = $q->fetch();
				$ret = true;
				$_SESSION['admin']['id'] = $res['id'];
				$this->__construct($res['id']);
			}
			return $ret;
		}
		
		public function logout(){
			$_SESSION['admin'] = array();
		}
		
		public function __toString(){
			return $this->prenom." ".$this->nom;
		}
		
	}
?>
