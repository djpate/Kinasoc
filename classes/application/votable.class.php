<?php

	namespace application;
	
	abstract class votable extends \kinaf\modele {
		
		public function getVote(){
			$q = $this->pdo->query("select coalesce(sum(value),0) as vote 
									from ".static::$table."_vote 
									where ".static::$table." = ".$this->id)->fetch();
			return $q['vote'];
		}
		
		public function vote(User $u,$value){
			if($this->hasVoted($u)):
				$this->pdo->exec("delete from ".static::$table."_vote where user = ".$u->id);
			else:
				if($value == "1" or $value == "-1"):
					$this->pdo->exec("insert into ".static::$table."_vote (".static::$table.",user,value,date)
									values (".$this->id.",".$u->id.",".$value.",now())");
				else:
					throw new Exception("Vote was forged");
				endif;
			endif;
		}
		
		private function hasVoted(User $u){
			$q = $this->pdo->query("select * 
										from ".static::$table."_vote
										where ".static::$table." = ".$this->id."
										and user = ".$u->id);
			if($q->rowCount()==1):
				return true;
			else:
				return false;
			endif;
		}
		
		/**
		 * Returns true if the provied user as voted and false otherwise
		 * */
		public function didHeVote(User $u,$value){
			if($value == "1" or $value == "-1"):
				$q = $this->pdo->query("select * 
										from ".static::$table."_vote
										where ".static::$table." = ".$this->id."
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
