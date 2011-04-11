<?php

namespace kinaf;

	class language extends \kinaf\modele {
		protected static $table = "language";
		
		public function formatNumber($val){
			return number_format($val,2,$this->decimalSeperator,$this->thousandSeperator);
		}
		
		public function formatPrice($price,Currency $currency){
			if($this->symbolPrepend){
				return $currency->symbol.$this->formatNumber($price);
			} else {
				return $this->formatNumber($price).$currency->symbol;
			}
		}
		
		public function __toString(){
			return $this->code;
		}
		
	}
?>
