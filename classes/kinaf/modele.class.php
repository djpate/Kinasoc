<?php

namespace kinaf;

abstract class Modele {
	
	protected $id;
	protected $pdo;
	public static $autoSuggestField = "label";
	protected $errorStack = array();
	protected $classname = __class__;
	protected $orm;
	protected static $table;
	
	/* DAO */
	public static function all($offset=null,$limit=null,$and="",$order=""){
		$pdo = db::singleton();
		$classname = get_called_class();
		$a = array();
		
		if(!is_null($offset)){
			$limit = " limit ".$offset.",".$limit;
		} else {
			$limit = "";
		}
		
		$r = $pdo->query("select id from ".static::$table." ".$and." ".$order." ".$limit);
		foreach($r as $id => $val){
			array_push($a,new $classname($val['id']));
		}
		return $a;
	}
	
	public static function count($and=""){
		$pdo = db::singleton();
		$r = $pdo->query("select count(*) as cnt from ".static::$table.$and)->fetch();
		return $r['cnt'];
	}
	
	public static function getByField($field,$value){
		$pdo = \kinaf\db::singleton();
		$classname = get_called_class();
		$r = $pdo->query("select id from ".static::$table." where `".$field."` = '$value'");
		if($r->rowCount()==1){
			$r = $r->fetch();
			$classname = get_called_class();
			return new $classname($r['id']);
		} else if($r->rowCount()>1){
			$ret = array();
			foreach($r as $row){
				array_push($ret,new $classname($row['id']));
			}
			return $ret;
		} else {
			return null;
		}
	}
	
	/* END DAO */
	
	/* magic */

	public static function __callStatic($method,$args){
		if(substr($method,0,5) == "getBy"){
		
			$field = substr($method,5);
			return static::getByField($field,$args[0]);
		
		}
	}
	
	public function __call($method,$args){
		
			if(!array_key_exists("has_many",$this->orm)){
				new Error("Method ".$method." does not exist");
				exit;
			}
			
			if(!array_key_exists($method,$this->orm['has_many'])){
				new Error("Method ".$method." does not exist");
				exit;
			}
			
			return $this->get_many($this->orm['has_many'][$method]);
		
	}
	
	protected function get_many($type){
		if($this->id!=0){
			return $this->pdo->query("select id from ".$type::$table." where ".ucfirst(strtolower(__class__))." = ".$this->id);
		} else {
			new Error("This object does not have an id");
			exit;
		}
	}
	
	/* end magic */
	
	public function __construct($id=0){
		
		if(static::$table == null){
			throw new Exception("Object definition not valid");
			exit;
		}
		
		/* loads PDO */ 
		$this->pdo = Db::singleton();
		
		/* loads ORM */
		$this->orm = new orm(static::$table);
		
		if(!is_numeric($id)&&!is_array($id)){
			new Error("Should be an integer or an array");
			exit;
		}
		
		if(is_numeric($id)){
			if($id!=0){
				$r = $this->pdo->query("select id from `".static::$table."` where id = ".$id);
				if($r->rowCount()==1){
					$this->id = $id;
					$this->load();
				} else {
					$e = new Error("Specified ID was not found ".$id." on table ".static::$table);
				}
			}
		} else {
			foreach($id as $key => $val){
				if($val=="on"){$val = 1;} // pour les checkbox
					if($this->orm->getType($key) == "object"){
						$this->$key = new $key($val);
					} else if($this->orm->getType($key) != null) {
						$this->$key = $val;
					}
			}
		}
	}
	
	public function __get($nom){
		return $this->get($nom);
	}
	
	public function __set($nom,$valeur){
		$this->set($nom,$valeur);
	}
	
	public function get($nom){
		return $this->$nom;
	}
	
	public function set($nom,$valeur){
		$this->$nom = $valeur;
	}
	
	protected function load(){
		$info = $this->pdo->query("select * from `".static::$table."` where id = ".$this->id)->fetch();
		$fields = $this->orm->getFields();
		foreach($fields as $field){
			//var_dump($info);
			$type = $this->orm->getType($field);
			switch($type){
				case 'object':
					if($info[$field]!=0){
						
						$namespace = $this->orm->getNamespace($field);
						if($namespace==null){$namespace = "application";}
						
						$class = $this->orm->getClass($field);
						if($class==null){$class = $field;}
						
						$classname = '\\'.$namespace.'\\'.$class;
						$this->$field = new $classname($info[$field]);
					} else {
						$this->$field = null;
					}
				break;
				case 'date':
					$this->$field = date_en_to_fr($info[$field]);
				break;
				case 'datetime':
					$this->$field = datetime_en_to_fr($info[$field]);
				break;
				default:
					$this->$field = $info[$field];
				break;
			}
		}
	}
	
	private function prepareForDb($field){
		$type = $this->orm->getType($field);
					
		if($type=="object"&&is_object($this->$field)){
			$value = $this->$field->id;
		} elseif($type=="date") {
			$value = date_fr_to_en($this->$field);
		} elseif($type=="datetime"){
			$value = datetime_fr_to_en($this->$field);
		} else {
			$value = $this->$field;
		}
		
		return $this->pdo->quote(stripslashes($value));
	}
	
	public function save(){
		
		if($this->isValid()){
		
			if($this->id==0){ // is this is a new record we create it
				
				$fields = $this->orm->getFields();
				
				$req = "insert into `".static::$table."` (";
				foreach($fields as $field){
					$req .= "`".$field."`,";
				}
				$req = substr($req, 0, -1);  // removes last ,
				$req .= ") values (";
				foreach($fields as $field){
					$value = $this->prepareForDb($field);
					$req .= $value.",";
				}
				$req = substr($req, 0, -1);  // removes last ,
				$req .= ")";
				
				$this->pdo->exec($req);
				
				$this->id = $this->pdo->lastInsertId();
			
			} else {
			
				$req = "update `".static::$table."` set ";
				$fields = $this->orm->getFields();
				
				foreach($fields as $field){
					
					$req .= "`".$field."` = ";
					
					$value = $this->prepareForDb($field);
					
					$req .= $value.",";
					
				}
				$req = substr($req, 0, -1); 
				$req .= " where id = ".$this->id;
				
				$this->pdo->exec($req);
			}
			
			return true;
		} else {
			return false;
		}
	}
	
	public function isValid(){
		$fields = $this->orm->getFields();
		foreach($fields as $field){
			$constraints = $this->orm->getConstraints($field);
			if(is_array($constraints)){
				foreach($constraints as $constraint => $value){
					if(!method_exists('\kinaf\validation',$constraint)){
						throw new \Exception("Validation ".$constraint." does not exist");
					}
					/* on ne fais la validation que si la valeur est required et/ou qu'elle est renseigné */
					
					if(array_key_exists("required",$constraints)||$this->$field!=""){
					
						if(!validation::$constraint($this->$field)){
							Throw new \Exception($field." => \"".$this->$field."\" ne valide pas la contrainte ".$constraint);
						}
						
					}
				}
			}
		}
		return true;
	}
	
	public function generateConstraint($id){
		$ret = "";
		$constraints = $this->orm->getConstraints($id);
			if(is_array($constraints)&&count($constraints)>0){
				foreach($constraints as $constraint => $val){
					$ret .= " ".$constraint;
				}
			}
		return $ret;
	}
	
	public function delete(){
		$this->pdo->exec("delete from `".static::$table."` where id = ".$this->id);
	}
	
	public function __toString(){
		return $this->id;
	}
	
	public function addError($err){
		array_push($this->errorStack,$err);
	}
	
	public function getNumError(){
		return count($this->errorStack);
	}
	
	public function getLastError(){
		return end($this->errorStack);
	}
	
	public function getTable() {
        return static::$table;
    }
    
    public function getClassname(){
		return get_called_class();
	}
		
}
?>
