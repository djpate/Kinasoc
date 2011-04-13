<?php
	namespace application;
	
	class tag extends \kinaf\modele {
		protected static $table = "tag";
		
		public static function popular($limit = 50){
			$ret = array();
			$pdo = \kinaf\db::singleton();
			$q = $pdo->query("SELECT tag,count(*) as popularity FROM `question_tag` group by tag order by popularity desc limit 0,".$limit);
			if($q->rowCount()>0){
				foreach($q as $row){
					array_push($ret,new tag($row['tag']));
				}
			}
			return $ret;
		}
		
		public function used(){
			$q = $this->pdo->query("select count(*) as cnt from question_tag where tag = ".$this->id)->fetch();
			return $q['cnt']; 
		}
		
		public function __toString(){
			return $this->label."";
		}
		
	}
?>
