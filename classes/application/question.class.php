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
			$q = $this->pdo->query("select id from answer where question = ".$this->id);
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
