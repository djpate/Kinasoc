<?php

namespace controllers;

	class home extends \kinaf\controller{
		
		public function indexAction(){
			$this->add("questions",\application\question::all());
			$this->render();
		}
		
	} 

?>
