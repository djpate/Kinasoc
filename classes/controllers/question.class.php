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
		
		public function searchAction(){
			$this->render();
		}
		
		public function search_ajaxAction(){
			if(isset($_REQUEST['q']) && $_REQUEST['q'] != ""){
					
				if(isset($_REQUEST['page'])){
					$page = $_REQUEST['page'];
				} else {
					$page = 1;
				}
				
				$offset = ($page - 1) * $this->params['questionsPerPageSearch'];

				$pagination = new \kinaf\pagination();
				$pagination->setCurrentPage($page);
				$pagination->setMaxPage( ceil( \application\question::searchCount($_REQUEST['q']) / $this->params['questionsPerPageSearch'] ) );

				$questions = \application\question::search($_REQUEST['q'],$offset,$this->params['questionsPerPageSearch']);
				
				$this->add("route",\kinaf\routes::url_to("question","search_ajax")."?q=".$_REQUEST['q']);
				$this->add("pagination",$pagination);
				$this->add("questions",$questions);
				
				$this->render_view("user","paginated_question","ajax");
				
			} else {
				\kinaf\routes::redirect_to("home","index");
			}
		}
		
		public function deleteAction($id){
			$q = new \application\question($id);
			if( $this->connected ):
				if ( $this->connected_user == $q->user ):
					$q->delete();
				else:
					header('HTTP/1.1 403 Forbidden');
				endif;
			else:
				header('HTTP/1.1 403 Forbidden');
				exit;
			endif;
		}
		
		public function fetchAction($id){
			$q = new \application\question($id);
			if($this->connected):
				if($q->isEditable($this->connected_user)):
					echo $q->content;
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
			$q = new \application\question($id);
			if($this->connected):
				if($q->isEditable($this->connected_user)):
					$q->content = $_REQUEST['content'];
					$q->save();
					echo Markdown($q->content);
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
