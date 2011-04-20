<?php
/* 
 * loads all the necessary classes 
 * 
 * All classes should end with .class.php so it can be loaded
 * */
	
	/* autoload dans classes */
	
	require dirname(__FILE__)."/libs/swift/swift_required.php";
	
	function kinafAutoload($class_name) {
		require_once dirname(__FILE__) . "/" . str_replace('\\', '/', strtolower($class_name)) . '.class.php';
	}
	
	spl_autoload_register(kinafAutoload);
	
	function date_en_to_fr($date_en){
		$d = explode("-",$date_en);
		return $d[2]."/".$d[1]."/".$d[0];
	}
	
	function date_fr_to_en($date_fr){
		$d = explode("/",$date_fr);
		return $d[2]."-".$d[1]."-".$d[0];
	}
	
	function datetime_en_to_fr($date){
		return date("d/m/Y G:i:s",strtotime($date));
	}
	
	function datetime_fr_to_en($date){
		$date = explode(" ",$date);
		return date_fr_to_en($date[0])." ".$date[1];
	}
	

?>
