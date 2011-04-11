<?php

namespace kinaf;

    class i18nModele extends modele{
        
        protected $i18nFields = array();
        protected $i18nValues = array();
        
        public function get($nom,$lang=null){
            if(in_array($nom,$this->i18nFields)){
				if($lang==null){
					$lang = $_SESSION['lang'];
				}
                return $this->i18nValues[$nom][$lang];
            } else {
                return $this->$nom;
            }
        }
        
        public function set($nom,$valeur,$lang=null){
            if(in_array($nom,$this->i18nFields)){
                $this->i18nValues[$nom][$lang] = $valeur;
            } else {
               $this->$nom = $valeur;
            }
        }
        
        public function save(){
            if(parent::save()){
				foreach($this->i18nValues as $field => $content){
					foreach($content as $lang => $value){
						if(is_numeric($lang)){ // ne pas enlever car bug bizar
							$exist = $this->pdo->query("select * from ".static::$table."_i18n where Lang = ".$lang." and id = ".$this->id);
							$value = $this->pdo->quote(stripslashes($value));
							if($exist->rowCount()==0){
								// If we are creating a object we initiate the row
								$this->pdo->exec("insert into ".static::$table."_i18n (id,Lang,`".$field."`) values (".$this->id.",".$lang.",".$value.")");
							} else {
								$this->pdo->exec("update ".static::$table."_i18n set `".$field."` = ".$value." where Lang = ".$lang." and id = ".$this->id);
							}
						}
					}
				}
			}
        }
        
        protected function load(){
		$info = $this->pdo->query("select * from ".static::$table." where id = ".$this->id)->fetch();
            $fields = $this->orm->getFields();
            foreach($fields as $field){
				$type = $this->orm->getType($field);
                if(!in_array($type,$this->i18nFields)){
                    if($type=="object"){ // is what we are trying to load is an object we instancied it here
                        if($info[$field]!=0){
                        	$classname = '\\application\\'.$field;
                        	$this->$field = new $classname($info[$field]);
                        } else {
                            $this->$field = null;
                        }
                    } elseif($val=="date"){
                        $this->$field = date_en_to_fr($info[$field]);
                    } else {
                        $this->$field = $info[$field];
                    }
                }
            }
			
			$info_i18n = $this->pdo->query("select * from ".static::$table."_i18n where id = ".$this->id);
			foreach($info_i18n as $info){
				foreach($this->i18nFields as $field){
					$this->i18nValues[$field][$info['Lang']] = $info[$field];
				}
			}
        }
        
        public function delete(){
            $this->pdo->exec("delete from ".static::$table." where id = ".$this->id);
            $this->pdo->exec("delete from ".static::$table."_i18n where id = ".$this->id);
        }
        
        public function getI18nFields(){
			return $this->i18nFields;
		}
        
    }
?>
