<?php

namespace controllers;

	class home extends \application\controller{
		
		public function indexAction(){
			$this->add("questions",\application\question::all());
			$this->render();
		}
		
	} 

?>
