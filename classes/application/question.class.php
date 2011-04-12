<?php
	namespace application;
	
	class question extends \kinaf\modele {
		protected static $table = "question";
		
		public function isAnswered(){
			return false;
		}
		
		public function getVote(){
			$q = $this->pdo->query("select coalesce(sum(value),0) as vote 
									from question_vote 
									where question = ".$this->id)->fetch();
			return $q['vote'];			
		}
		
		public function getNbVote(){
		}
		
		public function getTags(){
		}
		
		/**
		 * Returns true if the provied user as voted and false otherwise
		 * */
		public function didHeVote(User $u){
			$q = $this->pdo->query("select * 
									from question_vote 
									where question = ".$this->id."
									and user = ".$u->id);
			if($q->rowCount()==0):
				return false;
			else:
				return true;
			endif;
		}
		
		public function vote(User $u,$value){
			if($value == "1" or $value == "-1"):
				$this->pdo->exec("insert into question_vote (question,user,value,date)
								values (".$this->id.",".$u->id.",".$value.",now())");
			else:
				throw new Exception("Vote was forged");
			endif;
		}
		
		public function getAnswers(){
			$ret = array();
			$q = $this->pdo->query("select id from answer where question = ".$this->id);
			if( $q->rowCount() > 0 ):
				foreach($q as $row):
					array_push($ret,new \application\answer($row['id']));
				endforeach;
			endif;
			return $ret;
		}
		
		public function getNbAnswers(){
			return 1;
		}
		
	}
?>
