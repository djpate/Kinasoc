<?php
	require('../configuration/configuration.php');
	require('../classes/Db.class.php');
	
	$pdo = Db::singleton();
	
	foreach($pdo->query("show tables") as $row){
		/* on gere les tables principales */
		$is = array();
		$files = array();
		$table = $row[0];
		foreach($pdo->query("show index from $table") as $subRow){
			if($subRow['Column_name']=="id"){
				/* we can treat it with the modele Class */
				$tableName = ucfirst(strtolower($table));
				if(!file_exists("../classes/".$tableName.".class.php")){
					echo "Creating class ".$tableName."\n";
					$fp = fopen("../classes/".$tableName.".class.php", 'w');
					fwrite($fp, "<?php\n");
					fwrite($fp, "\tclass ".$tableName." extends modele { \n"); 
					fwrite($fp, "\t\tprotected ".'$table'." = \"".$table."\";\n");
					fwrite($fp, "\t\tprotected ".'$orm'." = array(");
					$arr = "";
					foreach($pdo->query("show columns from ".$table." where Field != 'id'") as $field){
						if(preg_match("@int@",$field['Type'])){
							/* on verifie si c juste un int ou une autre classe */
							if(preg_match("@^[A-Z]{1}@",$field['Field'])){
								$type = "object";
							} else {
								if(preg_match("@tinyint@",$field['Type'])){
									$type = "tinyint";
									array_push($is,$field['Field']);
								} else {
									$type = "int";
								}
							}
						} elseif(preg_match("@text@",$field['Type'])) {
							$type = "text";
						} elseif(preg_match("@date@",$field['Type'])) {
							$type = "date";
						} elseif(preg_match("@^char@",$field['Type'])) {
							$type = "file";
							array_push($files,$field['Field']);
						} else {
							$type = "varchar";
						}
						$arr .= "\"".$field['Field']."\"=>\"$type\",";
					}
					$arr = rtrim($arr,",");
					fwrite($fp, $arr);
					fwrite($fp, ");\n");
					foreach($pdo->query("show columns from ".$table." where Field != 'id'") as $field){
						fwrite($fp,"\t\t".'protected'." $".$field['Field'].";\n");
					}
					
					/* genere les isKkchoz() genre isActif si champ actif en tinyint */
					if(count($is)>0){
						fwrite($fp,"\n");
						foreach($is as $id => $val){
							fwrite($fp,"\t\t".'public function is'.ucfirst(strtolower($val))."(){\n");
							fwrite($fp,"\t\t\t".'return $this->'.$val.";\n");
							fwrite($fp,"\t\t}\n\n");
						}
					}
					
					/* genere la methode d'upload propre a un champ unique */
					if(count($files)>0){
						fwrite($fp,"\n");
						foreach($files as $id => $val){
							echo "Vous devez chmoder a 777 le dossier upload/".strtolower($tableName)."/$val\n";
							fwrite($fp,"\t\t".'public function upload'.ucfirst(strtolower($val))."(){\n");
							fwrite($fp,"\t\t\t".'$path_info = pathinfo($_FILES[\''.$val.'\'][\'name\']);'."\n");
							fwrite($fp,"\t\t\t".'$ext = $path_info[\'extension\'];'."\n");
							fwrite($fp,"\t\t\t".'if(move_uploaded_file($_FILES[\''.$val.'\'][\'tmp_name\'],dirname(".")."/../upload/'.strtolower($tableName).'/'.$val.'/".$this->id.".".$ext)){'."\n");
							fwrite($fp,"\t\t\t\t".'$this->set("'.$val.'",$_FILES[\''.$val.'\'][\'name\']);'."\n");
							fwrite($fp,"\t\t\t\t".'$this->save();'."\n");
							fwrite($fp,"\t\t\t\treturn true;\n\t\t\t} else {\n");
							fwrite($fp,"\t\t\t\treturn false;\n\t\t\t}\n");
							fwrite($fp,"\t\t}\n\n");
							fwrite($fp,"\t\t".'public function link'.ucfirst(strtolower($val))."(){\n");
							fwrite($fp,"\t\t\t".'return  "upload/'.strtolower($tableName).'/'.$val.'/'.'".$this->id.".".$this->'.ucfirst(strtolower($val)).'Ext();'."\n");
							fwrite($fp,"\t\t}\n\n");
							fwrite($fp,"\t\t".'private function '.ucfirst(strtolower($val))."Ext(){\n");
							fwrite($fp,"\t\t\t".'$path_info = pathinfo($this->'.$val.');'."\n");
							fwrite($fp,"\t\t\t".'return $path_info[\'extension\'];'."\n");
							fwrite($fp,"\t\t}\n\n");
							
							
						}
					}
					
					/* genere les liens vers les autres tables */
					foreach($pdo->query("show tables where Tables_in_".$pdo->db." like '".$table."__%';") as $lien){
						$lienTable = $lien[0];
						$lienTable = str_replace($table."__","",$lienTable);
						fwrite($fp,"\n\t\t".'public function get'.ucfirst(strtolower($lienTable)).'(){'."\n");
						fwrite($fp,"\t\t\t".'$returnArray = array();'."\n");
						fwrite($fp,"\t\t\t".'$q = $this->pdo->query("select '.$lienTable.'id from '.$lien[0].' where '.$table.'id = ".$this->id);'."\n");
						fwrite($fp,"\t\t\t".'if($q->rowCount()>0){'."\n");
						fwrite($fp,"\t\t\t\t".'foreach($q as $row){'."\n");
						fwrite($fp,"\t\t\t\t\t".'array_push($returnArray,new '.$lienTable.'($row[\''.$lienTable.'id\']));'."\n");
						fwrite($fp,"\t\t\t\t}\n");
						fwrite($fp,"\t\t\t}\n");
						fwrite($fp,"\t\t\t".'return $returnArray;'."\n");
						fwrite($fp,"\t\t}\n");
						
						fwrite($fp,"\n\t\t".'public function count'.ucfirst(strtolower($lienTable)).'(){'."\n");
						fwrite($fp,"\t\t\t".'$q = $this->pdo->query("select '.$lienTable.'id from '.$lien[0].' where '.$table.'id = ".$this->id);'."\n");
						fwrite($fp,"\t\t\t".'return $q->rowCount();'."\n");
						fwrite($fp,"\t\t}\n");
						
						fwrite($fp,"\n\t\t".'public function save'.ucfirst(strtolower($lienTable)).'(array $array){'."\n");
						fwrite($fp,"\t\t\t".'$this->pdo->exec("delete from '.$lien[0].' where '.$table.'id = ".$this->id);'."\n");
						fwrite($fp,"\t\t\t".'if(count($array)>0){'."\n");
						fwrite($fp,"\t\t\t\t".'foreach($array as $val){'."\n");
						fwrite($fp,"\t\t\t\t\t".'$this->pdo->exec("insert into '.$lien[0].' ('.$table.'id,'.$lienTable.'id) values (".$this->id.",$val)");'."\n");
						fwrite($fp,"\t\t\t\t}\n");
						fwrite($fp,"\t\t\t}\n");
						fwrite($fp,"\t\t}\n");
					}
					
					
					fwrite($fp, "\t}\n");
					fwrite($fp,"?>");
					fclose($fp);
				} else {
					echo "Class ".$tableName." already exist !\n";
				}
			}
		}
	}
?>
