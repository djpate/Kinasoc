<?php
	namespace controllers;
	
	use \application\tag as tag;
	use \application\question as question;
	
	class tags extends \application\controller {
		
		public function jsonAction(){
			$tags = tag::all(null,null,"where label like '".$_REQUEST['term']."%'");
			$array = array();
			foreach($tags as $tag){
				array_push($array,array("id"=>$tag->id,"label"=>$tag->label));
			}
			echo json_encode($array);
		}
		
		public function filterAction($id){
			$tag = new tag($id);
			$questions = array();
			$q = $this->pdo->query("select question from question_tag where tag = ".$tag->id);
			if($q->rowCount()>0){
				foreach($q as $row){
					array_push($questions,new question($row['question']));
				}
			}
			$this->add("questions",$questions);
			$this->render_view("home","index");
		}
	}
	
?>
