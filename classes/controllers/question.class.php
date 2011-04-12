<?php

namespace controllers;

use \application\user as user;
use \application\answer as answer;

	class question extends \application\controller{
		
		public function addAction(){
			if(isset($_POST)){
				$q = new \application\question();
				$q->title = $_REQUEST['title'];
				$q->content = $_REQUEST['content'];
				$q->creationDate = date("d/m/Y G:i:s");
				$q->save();
				header("location:".\kinaf\routes::url_to("question","view",$q));
				exit;
			}
		}
		
		public function newAction(){
			$this->render();
		}
		
		public function viewAction($id){
			$question = new \application\question($id);
			$question->views = $question->views + 1;
			$question->save();
			$this->add("question",$question);
			$this->add("answers",$question->getAnswers());
			$this->add("parser",new \libs\markdown\markdownextraparser());
			
			$this->render();
		}
		
		public function voteAction($id){
			$question = new \application\question($id);
			if($this->connected):
				if($question->user != $this->connected_user):
					if(!$question->didHeVote($this->connected_user)):
						switch($_REQUEST['type']){
							case 'up':
								$question->vote($this->connected_user,1);
							break;
							case 'down':
								$question->vote($this->connected_user,-1);
							break;
							default:
								throw new Exception("Vote was forged");
							break;
						}
						echo "ok";
					else:
						echo "err_3"; // allready voted
					endif;
				else:
					echo "err_2"; // own question
				endif;
			else:
				echo "err_1"; // not connected
			endif;
		}
		
		public function current_voteAction($id){
			$question = new \application\question($id);
			echo $question->getVote();
		}
		
		public function answersAction($id){
			$question = new \application\question($id);
			$this->add("answers",$question->getAnswers());
			$this->add("parser",new \libs\markdown\markdownextraparser());
			$this->render("ajax");
		}
		
		public function new_answerAction($id){
			$question = new \application\question($id);
			if( strlen($_REQUEST['answer_content']) > 50 ): // TODO should be a variable
				if( $this->connected ):
					$a = new answer();
					$a->question = $question;
					$a->user = $this->connected_user;
					$a->creationDate = date("d/m/Y G:i:s");
					$a->content = $_REQUEST['answer_content'];
					$a->save();
					echo "ok";
				else:
					echo "err_2"; // not connected
				endif;
			else:
				echo "err_1"; // answer is too short
			endif;
		}
		
		public function vote_answerAction(){
			$a = new answer($_REQUEST['id']);
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
						echo "ok";
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
		
	} 

?>