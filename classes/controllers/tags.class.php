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
			
			$maxPage = min(10,ceil(question::byTagCount($tag) / $this->params['questionsPerPage']));
			
			$this->add("maxPage",$maxPage);
			$this->add("question_type","tag");
			$this->add("tag",$tag);
			$this->render_view("home","index");
		}
	}
	
?>
