<?php

	namespace application;

	class controller extends \kinaf\controller{
		
		public function __construct($controller,$action){
			parent::__construct($controller,$action);
			
			$this->connected = user::isConnected();
			
			$this->add("connected",$this->connected);
			
			if($this->connected){
				$this->connected_user = user::connected();
				$this->add("connected_user",$this->connected_user);
			}
		}
	
	}
?>
