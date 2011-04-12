<?php
namespace kinaf;
	/* singleton */
	
	class Routes{
		
		private static $instance;
		private $routing_array;
		
		private function __construct(){
			$this->routing_array = array();
			$this->loadRoutes();
		}
		
		public function getControllerInfo(){
			
			$uri = preg_replace("/\?(.*)/","",$_SERVER['REQUEST_URI']);

			
			if($uri == "/"){
				global $def_route;
				return $def_route;
			}
			
			$matches = array();
				
			if(preg_match("$/(.*)/$",$_SERVER['PHP_SELF'],$matches)){
				$uri = str_replace($matches[0],"",$uri);
			}
			
			$ret = $uri;
			$matches = array();
			foreach($this->routing_array as $id => $val){
				if(preg_match("^".$id."$^",$uri,$matches)){
					$ret = array("controller"=>$val['controller'],"action"=>$val['action'],"matches"=>$matches);
					break;
				}
			}
			return $ret;
		}
		/**
		 * Returns the url for the specified controller and action
		 * @param string $controller
		 * @param string $action
		 * @param objet $object 
		 * @return string
		 */
		public static function url_to($controller,$action,$objet=null){
			
			$routes = self::fetchRoutes();
			
			if(!array_key_exists($controller,$routes)){
				new Error("Controller ".$controller." not found");
			}
			
			if(!array_key_exists($action,$routes[$controller])){
				new Error("Action ".$action." not found");
			}
			
			if(preg_match("/{([a-z]+)}/",$routes[$controller][$action]['url'])>0){
				
				$url = $routes[$controller][$action]['url'];
				
				if(is_null($objet)){
					new Error("You forgot to pass the instance !");
				}
				
				$matches = array();
				preg_match_all("/{([a-z]+)}/",$url,$matches);
				
				foreach($matches[0] as $key => $value){
					$s = $matches[1][$key];
					$url = str_replace($value,self::slugify($objet->$s),$url);
				}
				
				return $url;
				
			} else{
				return $routes[$controller][$action]['url'];
			}
			
		}
		/**
		 * Renvoi un lien href vers la bonne url en fonction du controller et d'une action
		 * @param string $value Le contenu du lien
		 * @param string $controller
		 * @param string $action
		 * @param objet $object 
		 * @param string $class
		 * @param string $id
		 * @param string $title
		 * @return string
		 */
		public static function link_to($value,$controller,$action,$objet=null,$class=null,$id=null,$title=null){
			
			if(!is_null($class)){
				$class = "class=\"".$class."\"";
			}
			
			if(!is_null($id)){
				$id = "id=\"".$id."\"";
			}
			
			if(!is_null($title)){
				$title = "title=\"".$title."\"";
			}
			
			return "<a $class $id $title href=".self::url_to($controller,$action,$objet).">".$value."</a>";
		}
		/**
		 * Redirige vers la bonne url en utilisant header location
		 * @param string $controller
		 * @param string $action
		 * @param objet $object 
		 * @return void
		 */
		public static function redirect_to($controller,$action,$objet=null,$get=""){
			$url = self::url_to($controller,$action,$objet);
			header("location:".$url.$get);
		}
		
		private function loadRoutes(){
			
			$routes = self::fetchRoutes();
			
			foreach($routes as $controller => $actions){
				foreach($actions as $action => $infos){
					if(preg_match("/{([a-z]+)}/",$infos['url'])>0){
						
						$url_reg = $infos['url'];
						
						$matches = array();
						preg_match_all("/{([a-z]+)}/",$infos['url'],$matches);
						
						if(is_array($matches[0])){
							foreach($matches[0] as $k => $v){
								if(is_array($infos['reg'][$k])){
									print_r($infos['reg'][$k]);
								}
								$url_reg = str_replace($v,$infos['reg'][$k],$url_reg);
							}
						}

					} else {
						$url_reg = $infos['url'];
					}
					
					if(!array_key_exists("verb",$infos)){
						$verb = "GET";
					} else {
						$verb = $infos['verb'];
					}
					
					$this->routing_array[$url_reg] = array("controller"=>$controller,"action"=>$action,"verb"=>$verb);
				}
			}
		}
		
		private static function fetchRoutes(){
			
			$yaml = new \libs\yaml\sfYamlParser();
			
			/* concatenation des tous les fichiers de routings */
			$routing_content = "";
			$d = Dir(dirname(__FILE__)."/../../routing");
			
			while (false !== ($entry = $d->read())) {
				if(pathinfo($entry, PATHINFO_EXTENSION)=="yaml"){
					$routing_content .= file_get_contents(dirname(__FILE__)."/../../routing/".$entry);
				}
			}
			
			try{
		      $routes = $yaml->parse($routing_content);
		    } catch (\InvalidArgumentException $e)
		    {
		      new Error("Unable to parse the YAML string: ".$e->getMessage());
		    }
		    
		    return $routes;
			
		}
		
		public static function singleton(){
			
			if (!isset(self::$instance)) {
        		$c = __CLASS__;
        		self::$instance = new $c;
			}
		
			return self::$instance;
			
		}
	
		static private function slugify($text){
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
		
		// trim
		$text = trim($text, '-');
		
		// transliterate
		if (function_exists('iconv'))
		{
			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		}
		
		// lowercase
		$text = strtolower($text);
		
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
		
		if (empty($text))
		{
			return 'n-a';
		}
		
		return $text;
		}
	
	}

?>
