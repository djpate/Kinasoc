<?php

	namespace controllers;
	
	class comments extends \application\controller{
		
		public function addAction(){
			if($this->connected):
				if( strlen($_REQUEST['content']) >= $this->params['minComment'] ):
					if($_REQUEST['type'] == "answer" or $_REQUEST['type'] == "question"):
						
						$type = $_REQUEST['type'];
						$obj_class = "\\application\\".$type;
						$class = $obj_class."_comment";
						$comment = new $class();
						
						$comment->user = $this->connected_user;
						$comment->creationDate = date("d/m/Y G:i:s");
						$comment->content = $_REQUEST['content'];
						$comment->$type = new $obj_class($_REQUEST[$type]);
						$comment->save();
						
						echo "ok";
						
					else:
						echo "err_3"; // request was forged
					endif;
				else:
					echo "err_2"; // comment too short
				endif;
			else:
				echo "err_1"; // not connected
			endif;
		}
		
	}
	
?>
