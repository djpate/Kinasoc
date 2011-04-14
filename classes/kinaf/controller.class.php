<?php
namespace kinaf;
	abstract class Controller{
		
		protected $controller;
		protected $action;
		protected $variableStack;
		protected $pdo;
		protected $layout;
		
		public function __construct($controller,$action){
			error_log($controller."=>".$action);
			$this->controller = $controller;
			$this->action = $action;
			$this->variableStack = array();
			$this->pdo = db::singleton();
			$this->layout = "default";
		}
		
		/* render another view by using controller action parameters */
		protected function render_view($controller,$action,$layout=null){
			if(file_exists(dirname(__FILE__). "/../../views/".$controller."/".$action.".php")){
				if(is_null($layout)){
					$layout = new layout($this->layout);
				} else {
					$layout = new layout($layout);
				}
				$layout->load(dirname(__FILE__). "/../../views/".$controller."/".$action.".php",$this->variableStack);
			} else {
				new Error("The view ".$this->action." was not found !");
			}
		}
		
		/* render the current view */
		protected function render($layout = null){
			
			if(file_exists(dirname(__FILE__). "/../../views/".$this->controller."/".$this->action.".php")){
				if(is_null($layout)){
					$layout = new layout($this->layout);
				} else {
					$layout = new layout($layout);
				}
				$layout->load(dirname(__FILE__). "/../../views/".$this->controller."/".$this->action.".php",$this->variableStack);
			} else {
				new Error("The view ".$this->action." was not found !");
			}
			
		}
		
		protected function add($key,$value){
			if(array_key_exists($key,$this->variableStack)){
				new Error("The key is allready in the variableStack");
			}
			
			$this->variableStack[$key] = $value;
			
		}
	}
?>
