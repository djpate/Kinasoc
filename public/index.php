<?php
	/* front controller */
	session_start();
	
	if(!file_exists("../configuration/configuration.php")){
		echo "Please setup the configuration file";
	}
	
	require("../classes/libs/markdown/markdown.php");
	require('../configuration/configuration.php');
	require('../classes/loader.php');
	
	$r = \Kinaf\Routes::singleton();
	
	$p = new \Kinaf\Page();
?>
