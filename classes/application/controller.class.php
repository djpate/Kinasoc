<?php

	namespace application;

	class controller extends \kinaf\controller{
		
		public function __construct($controller,$action){
			
			parent::__construct($controller,$action);
			
			$yamlparser = new \libs\yaml\sfYamlParser();
			$this->params = $yamlparser->parse(file_get_contents(dirname(__file__)."/../../configuration/params.yaml"));
			$this->add("params",$this->params);
			
			$this->connected = user::isConnected();
			
			$this->add("connected",$this->connected);
			
			$this->add("popularTags",tag::popular());
			
			$transport = \Swift_SmtpTransport::newInstance('localhost', 25);
			$this->mailer = \Swift_Mailer::newInstance($transport);
			
			if($this->connected){
				$this->connected_user = user::connected();
				$this->add("connected_user",$this->connected_user);
			}
		
		}
	
	}
?>
