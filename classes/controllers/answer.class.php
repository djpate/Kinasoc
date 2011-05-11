<?php

namespace controllers;

	class answer extends \application\controller{
		
		public function deleteAction(){
			$a = new \application\answer($_REQUEST['id']);
			if( $this->connected ):
				if ( $a->isDeletable($this->connected_user) ):
					$a->delete();
				else:
					header('HTTP/1.1 403 Forbidden');
				endif;
			else:
				header('HTTP/1.1 403 Forbidden');
				exit;
			endif;
		}
		
		public function newAction($id){
			$question = new \application\question($id);
			if( strlen($_REQUEST['answer_content']) > 40 ): // TODO should be a variable
				if( $this->connected ):
					$a = new \application\answer();
					$a->question = $question;
					$a->user = $this->connected_user;
					$a->creationDate = date("d/m/Y G:i:s");
					$a->content = $_REQUEST['answer_content'];
					$a->save();
					$a->checkNotifications($this->mailer,$this->params);
					echo "ok";
				else:
					echo "err_2"; // not connected
				endif;
			else:
				echo "err_1"; // answer is too short
			endif;
		}
		
		public function listAction($id){
			$question = new \application\question($id);
			$this->add("answers",$question->getAnswers());
			$this->render("ajax");
		}
		
		public function voteAction(){
			$a = new \application\answer($_REQUEST['id']);
			if( $this->connected ):
				if( $a->user != $this->connected_user ):
					switch($_REQUEST['type']){
						case 'up':
							$value = 1;
						break;
						case 'down':
							$value = -1;
						break;
						default:
							throw new Exception("Vote was forged");
						break;
					}
					if(!$a->didHeVote($this->connected_user,$value)):
						$a->vote($this->connected_user,$value);
						echo $a->getVote();
					else:
						echo "err_3"; // allready voted this value
					endif;
				else:
					echo "err_2"; // own answer
				endif;
			else:
				echo "err_1"; // not connected
			endif;
		}
		
		public function acceptAction(){
			$a = new \application\answer($_REQUEST['id']);
			if ( $this->connected ):
				if ( $a->question->user == $this->connected_user ):
					$a->toggleAccepted();
					echo "ok";
				else:
					echo "err_2"; // not the owner of the question
				endif;
			else:
				echo "err_1"; // not connected
			endif;
		}
		
		public function fetchAction($id){
			$a = new \application\answer($id);
			if($this->connected):
				if($a->isEditable($this->connected_user)):
					echo $a->content;
				else:
					header('HTTP/1.1 403 Forbidden');
					exit;
				endif;
			else:
				header('HTTP/1.1 403 Forbidden');
				exit;
			endif;
		}
		
		public function updateAction($id){
			$a = new \application\answer($id);
			if($this->connected):
				if($a->isEditable($this->connected_user)):
					$a->content = $_REQUEST['content'];
					$a->save();
				else:
					header('HTTP/1.1 403 Forbidden');
					exit;
				endif;
			else:
				header('HTTP/1.1 403 Forbidden');
				exit;
			endif;
		}
		
	} 

?>
