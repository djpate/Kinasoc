<?php

namespace controllers;

	class home extends \application\controller{
		
		public function indexAction(){
			
			$this->add("question_type","hottest");
			
			$maxPage = min(10,ceil(\application\question::count() / $this->params['questionsPerPage']));
			
			$this->add("maxPage",$maxPage);
			
			$this->render();
		}
		
		public function question_ajaxAction(){
			
			if( isset($_REQUEST['currentPage'])&& is_numeric($_REQUEST['currentPage']) ):
				$currentPage = $_REQUEST['currentPage'];
			else:
				$currentPage = 1;
			endif;
			
			$offset = ($currentPage - 1) * $this->params['questionsPerPage'];
			
			$type = $_REQUEST['questionType'];
			
			if($type == "tag"){
				$tag = new \application\tag($_REQUEST['tag']);
				$this->add("questions",\application\question::byTag($offset,$this->params['questionsPerPage'],$tag));
			} else {
				$this->add("questions",\application\question::$type($offset,$this->params['questionsPerPage']));
			}
			
			$this->render("ajax");
			
		}
		
	} 

?>
