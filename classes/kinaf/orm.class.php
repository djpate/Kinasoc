<?php
	namespace kinaf;
	
	class orm{
		
		private $yaml;
		private $fields;
		
		public function __construct($model){
			
			$this->yaml = new \libs\yaml\sfYamlParser();
			
			if(!is_file(dirname(__file__)."/../../orm/".strtolower($model).".yaml")){
				throw new Exception("Orm for model ".$model." was not found");
			}
			
			try{
				$this->fields = $this->yaml->parse(file_get_contents(dirname(__file__)."/../../orm/".strtolower($model).".yaml"));
				$this->fields = $this->fields['fields'];
			} catch (\InvalidArgumentException $e){
				throw new Exception("Unable to parse the YAML string: ".$e->getMessage());
			}
			
		}
		
		public function getFields(){
			$ret = array();
			foreach($this->fields as $id => $val){
				array_push($ret,$id);
			}
			return $ret;
		}
		
		public function getType($field){
			return $this->get($field,"type");
		}
		
		public function getConstraints($field){
			return $this->get($field,"constraints");
		}
		
		public function getNamespace($field){
			return $this->get($field,"namespace");
		}
		
		public function getClass($field){
			return $this->get($field,"class");
		}
		
		public function getDisplay($field){
			if(is_null($this->get($field,"display"))){
				return $field;
			} else {
				return $this->get($field,"display");
			}
		}
		
		public function get($field,$conf){
			if(isset($this->fields[$field])){
				if(array_key_exists($conf,$this->fields[$field])){
					return $this->fields[$field][$conf];
				} else {
					return null;
				}
			} else {
				return null;
			}
		}
		
	}
?>
