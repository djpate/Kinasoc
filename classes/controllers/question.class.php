<?php

namespace controllers;

use \application\user as user;
use \application\answer as answer;
use \application\tag as tag;

	class question extends \application\controller{
		
		public function addAction(){
			if( $this->connected ):
				if(strlen($_REQUEST['title']) >= $this->params['minQuestionTitle']):
					if(strlen($_REQUEST['content']) >= $this->params['minQuestionContent']):
						if(count($_REQUEST['tags']) >= $this->params['minTagsPerQuestion'] && count($_REQUEST['tags']) <= $this->params['maxTagsPerQuestion']):
							
							$tags = array();
							
							foreach($_REQUEST['tags'] as $tag):
								if(!is_numeric($tag) && $this->params['canCreateTags'] == 'false'):
									die("err_4"); // tag is not an int
								elseif(is_numeric($tag)):
									array_push($tags,new tag($tag)); // will fail here if tag does not exist 
								elseif($this->params['canCreateTags'] == 'true'):
									$t = new tag();
									$t->label = $tag;
									$t->save();
									array_push($tags,$t);
								endif;
							endforeach;
							
							$tags = array_unique($tags); // removes duplicate
							
							$q = new \application\question();
							$q->title = $_REQUEST['title'];
							$q->content = $_REQUEST['content'];
							$q->creationDate = date("d/m/Y G:i:s");
							$q->user = $this->connected_user;
							$q->save();
							
							$q->addTags($tags);
							
							\kinaf\routes::redirect_to("question","view",$q);
						else:
							echo "err_3"; //number of tags is out of bounds
						endif;
					else:
						echo "err_2"; // content too short
					endif;
				else:
					echo "err_1"; // title too short
				endif;
			else:
				\kinaf\routes::redirect_to("user","login");
			endif;
		}
		
		public function newAction(){
			if( $this->connected ):
				$this->render();
			else:
				\kinaf\routes::redirect_to("user","login");
			endif;
		}
		
		public function viewAction($id){
			$question = new \application\question($id);
			$question->views = $question->views + 1;
			$question->save();
			$this->add("question",$question);
			$this->add("answers",$question->getAnswers());
			
			$this->render();
		}
		
		public function voteAction($id){
			$question = new \application\question($id);
			if($this->connected):
				if($question->user != $this->connected_user):
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
					if(!$question->didHeVote($this->connected_user,$value)):
						$question->vote($this->connected_user,$value);
						echo $question->getVote();
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
		
		public function answersAction($id){
			$question = new \application\question($id);
			$this->add("answers",$question->getAnswers());
			$this->render("ajax");
		}
		
		public function new_answerAction($id){
			$question = new \application\question($id);
			if( strlen($_REQUEST['answer_content']) > 40 ): // TODO should be a variable
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
		
		public function accept_answerAction(){
			$a = new answer($_REQUEST['id']);
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
		
	} 

?>
