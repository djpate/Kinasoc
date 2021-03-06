<?php
	namespace application;
	
	class answer extends votable {
		
		protected static $table = "answer";
		
		public function isAccepted(){
			if($this->accepted==1){
				return true;
			} else {
				return false;
			}
		}
		
		public function toggleAccepted(){
			
			if( $this->isAccepted() ){
				
				
				// the answer is accepted so we need to unaccept it 
				// and remove the points that we gave
				
				$this->accepted = 0;
				$this->save();
				
				$this->pdo->exec("delete from vote where accepted = ".$this->id);
				
			} else {
				
				if ( $this->question->isAnswered() ){
					// an answer is allready accepted so we need to unaccept it
					// and remove the points
					
					$this->pdo->exec("update answer set accepted = 0 where question = ".$this->question->id);
					$this->pdo->exec("delete from vote where accepted = ".$this->id);
					
				}
				
				$this->accepted = 1;
				$this->save();
				
				$v = new Vote();
				$v->accepted = $this->id;
				$v->save();
				
				$connected_user = user::connected();
				
				if( $this->user != $connected_user ){ // we dont give points if you answer your own question
				
					$this->user->givePoints(new points_event(5),$v);
					$this->question->user->givePoints(new points_event(6),$v);	
					
				} 
				
				
			}
								
		}
		
		public function getComments(){
			$ret = array();
			
			$q = $this->pdo->query("select id from answer_comment where answer = ".$this->id." order by creationDate asc");
			if($q->rowCount()>0):
				foreach($q as $row):
					array_push($ret,new answer_comment($row['id']));
				endforeach;
			endif;
			
			return $ret;
		}
		
		public function isDeletable(User $u){ //permettra plus tard de gerer les modos
			if( $u->id == $this->user->id){
				return true;
			} else {
				return false;
			}
		}
		
		public function isEditable(User $u){ //permettra plus tard de gerer les modos
			if( $u->id == $this->user->id){
				return true;
			} else {
				return false;
			}
		}
		
		public function checkNotifications($mailer,$params){
			if($this->question->user->notificationAnswer == 1){
				
				$message = \Swift_Message::newInstance();
				$message->setSubject(_("Une réponse à votre question vient d'être ajouté !"));
				$message->setFrom(array($params['mailFromEmail'] => $params['mailFromName']));
				$message->setTo(array($this->question->user->email));
				$message->setBody(sprintf(_("Bonjour %s,<br /><br />%s vient de répondre à votre question <a href='%s'>%s</a>.<br /><br />A bientot sur %s !"),$this->question->user->login,$this->user->login,"http://".$_SERVER['SERVER_NAME'].\kinaf\routes::url_to("question","view",$this->question)."#answer".$this->id,$this->question->title,$params['sitename']),'text/html');
				
				$mailer->send($message);
				
			}
		}
		
	}
?>
