<?php
namespace kinaf;
	class error {
		public function __construct($err){
			echo "<div style=\"border:2px solid red;padding:10px\">$err</div>";
			error_log($err);
		}
	}
?>
