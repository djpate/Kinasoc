<?php

namespace kinaf;

	class i18n{
		
		public static function pgt($zero,$un,$plusieur,$count){
		
			if($count==0){
				$str = $zero;
			} elseif($count == 1){
				$str =  $un;
			} else{
				$str = $plusieur;
			}
			
			return sprintf($str,$count);
		
		}

	}
?>
