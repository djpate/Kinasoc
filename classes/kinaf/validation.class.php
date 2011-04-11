<?php

namespace kinaf;

	class validation{
		
		public static function required($val){
			return !empty($val);
		}
		
		public static function email($val){
			return filter_var($val,FILTER_VALIDATE_EMAIL);
		}
		
		public static function url($val){
			return filter_var($val,FILTER_VALIDATE_URL);
		}
		
		public static function integer($val){
			return is_numeric($val);
		}
		
		public static function float($val){
			return is_float($val);
		}
		
		public static function date($val){
			/* todo */
			return true;
		}
	}
?>
