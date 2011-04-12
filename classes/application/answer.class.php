<?php
	namespace application;
	
	class answer extends votable {
		
		protected static $table = "answer";
		
		public function isAccepted(){
			if($this->accepted==1){
				return true;
			} else {
				return false;
			}
		}
		
	}
?>
