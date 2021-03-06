<?php

	namespace application;
	
	abstract class votable extends \kinaf\modele {
		
		public function getVote(){
			$q = $this->pdo->query("select coalesce(sum(value),0) as vote 
									from vote 
									where ".static::$table." = ".$this->id)->fetch();
			return $q['vote'];
		}
		
		public function vote(User $u,$value){
			if($this->hasVoted($u)):
			
				$this->pdo->exec("delete from vote where ".static::$table." = ".$this->id." and user = ".$u->id);
			
			else:
				if($value == "1" or $value == "-1"):
					
					if($value=="1"):
						if( static::$table=="question" ):
							$event = new points_event(3);
						elseif( static::$table=="answer" ):
							$event = new points_event(1);
						endif;
					else:
						if( static::$table=="question" ):
							$event = new points_event(4);
						elseif( static::$table=="answer" ):
							$event = new points_event(2);
						endif;
					endif;
					
					$obj = static::$table;
					
					$v = new Vote();
					$v->user = $u;
					$v->$obj = $this;
					$v->value = $value;
					$v->date = date("d/m/Y G:i:s");
					$v->save();
									
					$this->user->givePoints($event,$v);
									
				else:
					
					throw new Exception("Vote was forged");
				
				endif;
			
			endif;
		}
		
		private function hasVoted(User $u){
			$q = $this->pdo->query("select * 
										from vote
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
										from vote
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
