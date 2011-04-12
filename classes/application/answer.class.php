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
		
		public function toggleAccepted(){
			
			$this->pdo->exec("update answer 
								set accepted = 0 
								where question = ".$this->question->id);
			// since this a toggle if the answer was allready accepted
			// we stop here
			if( !$this->accepted ):
				$this->pdo->exec("update answer 
									set accepted = 1 
									where id = ".$this->id);
			endif;
		}
		
	}
?>
