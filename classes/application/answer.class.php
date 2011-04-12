<?php
	namespace application;
	
	class answer extends votable {
		
		protected static $table = "answer";
		
		/**
		 * Returns true if the provied user as voted with this value 
		 * returns false otherwise
		 * */
		public function didHeVote(User $u,$value){
			if($value == "1" or $value == "-1"):
				$q = $this->pdo->query("select * 
										from answer_vote 
										where answer = ".$this->id."
										and value = ".$value."
										and user = ".$u->id);
				if($q->rowCount()==0):
					return false;
				else:
					return true;
				endif;
			else:
				throw new Exception("Vote was forged");
			endif;
		}
		
	}
?>
