<?php

namespace controllers;

	class question extends \kinaf\controller{
		
		public function addAction(){
			if(isset($_POST)){
				$q = new \application\question();
				$q->title = $_REQUEST['title'];
				$q->content = $_REQUEST['content'];
				$q->creationDate = date("d/m/Y G:i:s");
				$q->save();
				header("location:".\kinaf\routes::url_to("question","view",$q));
				exit;
			}
		}
		
		public function newAction(){
			$this->render();
		}
		
		public function viewAction($id){
			$this->add("question",new \application\question($id));
			$this->render();
		}
		
	} 

?>
