<?php
	namespace controllers;
	
	class tags extends \application\controller {
		public function jsonAction(){
			$tags = \application\tag::all(null,null,"where label like '".$_REQUEST['term']."%'");
			$array = array();
			foreach($tags as $tag){
				array_push($array,array("id"=>$tag->id,"label"=>$tag->label));
			}
			echo json_encode($array);
		}
	}
	
?>
