<?php

namespace kinaf;

	class layout{
		
		private $layout_name;
		
		private $variable_stack;
		
		public function __construct($layout){
			$this->layout_name = $layout;
		}
		
		
		
		public function load($view,$variableStack){
			
			$this->variable_stack = $variableStack;
			
			/* load all variables into the view */
			if(count($variableStack)>0){
				foreach($variableStack as $id => $val){
					$$id = $val;
				}
			}
			
			if(file_exists($view)){
			
				if(file_exists(dirname(__file__)."/../../layouts/".$this->layout_name."/header.php")){
					require(dirname(__file__)."/../../layouts/".$this->layout_name."/header.php");
				}
				
				require($view);
	
				if(file_exists(dirname(__file__)."/../../layouts/".$this->layout_name."/footer.php")){
					require(dirname(__file__)."/../../layouts/".$this->layout_name."/footer.php");
				}
			
			} else {
				new Error("The view was not found");
			}

		}
		
		public function loadPartial($name){
			
			if(count($this->variable_stack)>0){
				foreach($this->variable_stack as $id => $val){
					$$id = $val;
				}
			}
			
			require(dirname(__file__)."/../../layouts/".$this->layout_name."/".$name.".php");
		}

		
	}

?>
