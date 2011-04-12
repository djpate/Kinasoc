<?php

namespace controllers;

use \application\user as user;

	class markdown extends \application\controller{
		
		public function parserAction(){
			$parser = new \libs\markdown\markdownextraparser();
			echo $parser->transform($_REQUEST['data']);
		}
		
	} 

?>
