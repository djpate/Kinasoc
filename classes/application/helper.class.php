<?php

namespace application;

class helper {
	
	//date should be an datetime EN format eg. 2010-05-30 12:25:10
	public static function ago($date){
			
		$time_ago = strtotime($date);
		$time_now = time();
		
		$diff = $time_now - $time_ago;
		
		if($diff < 60){ // seconds
		
			$ret = sprintf(ngettext("Il y a %s seconde","Il y a %s secondes",$diff),$diff);
			
		} else if($diff < 3600){ // minutes 60*60
			
			$diff = round($diff / 60);
			
			$ret = sprintf(ngettext("Il y a %s minute","Il y a %s minutes",$diff),$diff);
			
		} else if($diff < 86400){ // hours 60*60*24
		
			$diff = round($diff / 60 / 60);
			
			$ret = sprintf(ngettext("Il y a %s heure","Il y a %s heures",$diff),$diff);
		
		} else if($diff < 604800){ // days 60*60*24*7
			
			$diff = round($diff / 60 / 60 / 24);
			
			$ret = sprintf(ngettext("Il y a %s jour","Il y a %s jours",$diff),$diff);
			
			
		} else if($diff < 2592000){ // weeks 60*60*24*30
			
			$diff = round($diff / 60 / 60 / 24 / 7);
			
			$ret = sprintf(ngettext("Il y a %s semaine","Il y a %s semaines",$diff),$diff);
			
		} else if($diff < 31536000){ //$month 60*60*24*365
			
			$diff = round($diff / 60 / 60 / 24 / 30 );
			
			$ret = sprintf(ngettext("Il y a %s mois","Il y a %s mois",$diff),$diff);
			
		} else { //years
			
			$diff = round($diff / 60 / 60 / 24 / 365);
			
			$ret = sprintf(ngettext("Il y a %s ans","Il y a %s ans",$diff),$diff);
			
		}
		
		return $ret;
	}
	
}

?>
