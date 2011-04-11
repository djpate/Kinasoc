<?php

namespace kinaf;

	class liste{
		private $pdo;
		private $table;
		private $name;
		private $default;
		
		private $title;
		private $classe;
		private $multiple;
		private $orderBy;
		private $defaultDisplay;
		
		public function __construct($table,$name,$default=0){
			$this->pdo = DB::singleton();
			$this->table = $table;
			$this->name = $name;
			$this->orderBy = "designation";
			if(is_array($default)){
				$this->default = $default;
			} elseif(is_object($default)){
				$this->default = $default->get('id');
			} else {
				$this->default = 0;
			}
		}
		
		public function setClasse($c){
			$this->classe = $c;
		}
		
		public function setDefaultDisplay($d){
			$this->defaultDisplay = $d;
		}
		
		public function setOrder($orderBy){
			$this->orderBy = $orderBy;
		}
		
		public function setMultiple($title){
			$this->multiple = 1;
			$this->title = $title;
		}
		
		public function display(){
			if($this->multiple!=1){
				$ret  = "<select name='".$this->name."' style='width: 100%'>";
			} else {
				$ret  = "<select multiple='multiple' title='".$this->title."' name='".$this->name."' style='width: 100%'>";
			}
			if($this->defaultDisplay){
				$ret .= "<option value='0'>".$this->defaultDisplay."</option>";
			}
			$q = $this->pdo->query("select * from ".$this->table." order by ".$this->orderBy);
			
			foreach($q as $val){
				$selected = "";
				if(is_array($this->default)){
					foreach($this->default as $obj){
						if($obj->get('id')==$val['id']){
							$selected = "selected";
							break;
						}
					}
				} else {
					if($val['id']==$this->default){
						$selected = "selected";
					}
				}
				$ret .= "<option value='".$val['id']."' ".$selected.">".$val['designation']."</option>";
			}
			$ret .= "</select>";
			return $ret;
		}
		
	}
?>
