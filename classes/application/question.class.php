<?php
	namespace application;
	
	class question extends votable {
		
		protected static $table = "question";
		
		public function isAnswered(){
			return false;
		}
		
		public function getTags(){
		}
		
		public function getAnswers(){
			$ret = array();
			$q = $this->pdo->query("SELECT answer.id,coalesce(sum(value),0) as vote FROM answer_vote right join answer on answer.id = answer_vote.answer where answer.question = ".$this->id." group by answer.id order by accepted desc,vote desc");
			if( $q->rowCount() > 0 ):
				foreach($q as $row):
					array_push($ret,new \application\answer($row['id']));
				endforeach;
			endif;
			return $ret;
		}
		
		public function getNbAnswers(){
			$q = $this->pdo->query("select count(id) as cnt from answer where question = ".$this->id)->fetch();
			return $q['cnt'];
		}
		
		public function labelDate(){
			return $this->creationDate;
		}
		
		
		
	}
?>
