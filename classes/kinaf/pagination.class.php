<?php

	namespace kinaf;

	class pagination{
		
		private $currentPage;
		private $maxPage;
		private $gap = 3;
	
		public function setCurrentPage($i){
			$this->currentPage = $i;
		}
		
		public function setMaxPage($i){
			$this->maxPage = $i;
		}
		
		public function setGap($i){
			$this->gap = $i;
		}
		
		public function display(){
			
			if($this->maxPage > 1){
			
				$ret = "<ul class='kinafPagination'>";
				
				if($this->currentPage != 1){ // we show the previous button
					$ret .= "<li class='page previous' rel='".($this->currentPage-1)."'>"._("Précédent")."</li>";
				}
				
				$start = max(1,$this->currentPage - $this->gap);
				$end = min($this->maxPage,$this->currentPage + $this->gap);
				
				if( $start > 1){
					
					$ret .= "<li class='page' rel='1'>1</li>";
					
					if( $start > 2 ){
						$ret .= "<li class='spacer'>...</li>";
					}
					
				}

				for($i = $start ; $i <= $end ; $i++){
					if($i == $this->currentPage){
						$ret .= "<li class='page active' rel='".$i."'>".$i."</li>";
					} else {
						$ret .= "<li class='page' rel='".$i."'>".$i."</li>";
					}
				}
				
				if( $end < $this->maxPage ){
					
					if( $end < $this->maxPage - 1){
						$ret .= "<li class='spacer'>...</li>";
					}
					
					$ret .= "<li class='page' rel='".$this->maxPage."'>".$this->maxPage."</li>";
				}
				
				if($this->currentPage != $this->maxPage){ // we show the previous button
					$ret .= "<li class='page next' rel='".($this->currentPage + 1)."'>"._("Suivant")."</li>";
				}
				
				$ret .= "</ul>";
				
				return $ret;
			}
		}

	}
?>
