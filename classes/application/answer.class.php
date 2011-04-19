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
		
		public function getComments(){
			$ret = array();
			
			$q = $this->pdo->query("select id from answer_comment where answer = ".$this->id." order by creationDate asc");
			if($q->rowCount()>0):
				foreach($q as $row):
					array_push($ret,new answer_comment($row['id']));
				endforeach;
			endif;
			
			return $ret;
		}
		
		public function isDeletable(User $u){ //permettra plus tard de gerer les modos
			if( $u->id == $this->user->id){
				return true;
			} else {
				return false;
			}
		}
		
	}
?>
