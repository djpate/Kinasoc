<?php
	namespace application;
	
	class question extends votable {
		
		protected static $table = "question";
		
		public function isAnswered(){
			$q = $this->pdo->query("select * from answer where accepted = 1 and question = ".$this->id);
			if($q->rowCount()==1){
				return true;
			} else {
				return false;
			}
		}
		
		public static function hottest($offset=null,$limit=null){
			return parent::all($offset,$limit,"order by creationDate desc,views desc");
		}
		
		public static function byTag($offset=null,$limit=null,$tag){
			$ret = array();
			$pdo =  \kinaf\db::singleton();
			$q = $pdo->query("select question from question,question_tag where question.id = question_tag.question and tag = ".$tag->id." order by creationDate desc,views desc");
			foreach($q as $row){
				array_push($ret,new question($row['question']));
			}
			return $ret;
		}
		
		public static function byTagCount($tag){
			$pdo =  \kinaf\db::singleton();
			$q = $pdo->query("select count(question) as cnt from question,question_tag where question.id = question_tag.question and tag = ".$tag->id)->fetch();
			return $q['cnt'];
		}
		
		
		
		public function getTags(){
			$ret = array();
			$q = $this->pdo->query("select tag from question_tag where question = ".$this->id);
			if($q->rowCount()>0){
				foreach($q as $row){
					array_push($ret,new tag($row['tag']));
				}
			}
			return $ret;
		}
		
		public function getAnswers(){
			$ret = array();
			$q = $this->pdo->query("SELECT answer.id,coalesce(sum(value),0) as vote FROM vote right join answer on answer.id = vote.answer where answer.question = ".$this->id." group by answer.id order by answer.accepted desc,vote desc");
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
		
		public function ago(){
			
			$time_ago = strtotime(datetime_fr_to_en($this->creationDate));
			$time_now = time();
			
			$diff = $time_now - $time_ago;
			
			if($diff < 60){ // seconds
			
				$ret = sprintf(ngettext("Il y a %s seconde","Il y a %s secondes",$diff),$diff);
				
			} else if($diff < 3600){ // minutes
				
				$diff = round($diff / 60);
				
				$ret = sprintf(ngettext("Il y a %s minute","Il y a %s minutes",$diff),$diff);
				
			} else if($diff < 86400){ // hours
			
				$diff = round($diff / 60 / 60);
				
				$ret = sprintf(ngettext("Il y a %s heure","Il y a %s heures",$diff),$diff);
			
			} else if($diff < 604800){ // days
				
				$diff = round($diff / 60 / 60 / 7);
				
				$ret = sprintf(ngettext("Il y a %s jour","Il y a %s jours",$diff),$diff);
				
				
			} else if($diff < 2419200){
				
				$diff = round($diff / 60 / 60 / 7 / 4);
				
				$ret = sprintf(ngettext("Il y a %s semaine","Il y a %s semaines",$diff),$diff);
				
			} else if($diff < 31536000){ //$month
				
				$diff = round($diff / 60 / 60 / 24 / 30 );
				
				$ret = sprintf(ngettext("Il y a %s mois","Il y a %s mois",$diff),$diff);
				
			} else { //years
				
				$diff = round($diff / 60 / 60 / 24 / 365);
				
				$ret = sprintf(ngettext("Il y a %s ans","Il y a %s ans",$diff),$diff);
				
			}
			
			return $ret;
			
			
		}
		
		public function addTags($tags){
			foreach($tags as $tag){
				$this->pdo->exec("insert into question_tag (question,tag) values (".$this->id.",".$tag->id.")");
			}
		}
		
		public function getComments(){
			$ret = array();
			
			$q = $this->pdo->query("select id from question_comment where question = ".$this->id." order by creationDate asc");
			if($q->rowCount()>0):
				foreach($q as $row):
					array_push($ret,new question_comment($row['id']));
				endforeach;
			endif;
			
			return $ret;
		}
		
		
		
	}
?>
