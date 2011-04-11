<?php

namespace kinaf;

class adminController extends Controller{

	public function __construct($controller,$action){
		parent::__construct($controller,$action);
		$this->layout = "admin";
		if(!isset($_SESSION['admin']['id']) && $action != "login"){
			\kinaf\routes::redirect_to("admin","login");
		}
		$yaml = new \libs\yaml\sfYamlParser();
		$this->config = $yaml->parse(file_get_contents(dirname(__file__)."/../../configuration/admin.yaml"));
		$this->add("config",$this->config);
	}
	
	public function loginAction(){
		if(isset($_POST['login'])&&isset($_POST['password'])){
			$admin = new \kinaf\Administrator();
			if($admin->logIn($_POST['login'],$_POST['password'])){
				\kinaf\routes::redirect_to("admin","index");
			} else {
				$this->add("error",1);
				$this->render("ajax");
				exit;
			}
		} else {
			$this->render("ajax");
			exit;
		}
	}
	
	public function indexAction(){
		
		$this->action = "module";
		$this->moduleAction(key($this->config['categories']));
	}
	
	/**
	 * Gere les traitement de masse des listings */
	public function massAction(){
		$ids = array();
		$class_name = "\\application\\".$_REQUEST['object'];
		$method = $_REQUEST['method'];
		preg_match_all("|=([0-9]+)&?|",$_REQUEST['collection'],$ids);
		foreach($ids[1] as $id){
			$obj = new $class_name($id);
			$obj->$method();
		}
	}
	
	public function categoryAction($category){
		
		$this->action = "module";
		$this->moduleAction($category);
		
	}
	
	public function moduleAction($category = null,$module = null){
		
		if(is_null($category) or !array_key_exists($category,$this->config['categories'])){
			$category = key($this->config['categories']);
		}
		
		if(is_null($module) or !array_key_exists($module,$this->config['categories'][$category]['modules'])){
			$module = key($this->config['categories'][$category]['modules']);
		}
		
		$this->add("current_category",$category);
		$this->add("current_module",$module);
		
	
		$this->render();
		
	}
	
	public function listingAction($category,$module){
		
		$this->add("current_category",$category);
		$this->add("current_module",$module);
		
		/* class info */
		$namespace = $this->getModuleConfiguration($category,$module,"namespace","application");
		$classname = "\\".$namespace."\\".$module;
		$orm = new \kinaf\orm($module);
		
		
		/* filter */
		$and = "";
		if(isset($_REQUEST['filter'])){
			$and = " where 1";
			foreach($_REQUEST as $id => $val){
				if( substr($id,0,8) == "filter__" ){
					$field = explode("__",$id);
					$field = $field[1];
					if($val!=""){
						/* on set le filter pour le reuse dans la vue */
						$filters[$field] = $val;
						/* on build la query */
						$type = $orm->getType($field);
						switch($type){
							case 'varchar':
								$and .= " and `".$field."` like '%".$val."%'";
							break;
							case 'tinyint':
								$and .= " and `".$field."` = ".$val;
							break;
							case 'date':
								
								if($val[0] != ''){
									$start = date_fr_to_en($val[0]);
									$and .= " and `".$field."` >= '".$start."'";
								}
								
								if($val[1] != ''){
									$end = date_fr_to_en($val[1]);
									$and .= " and `".$field."` <= '".$end."'";
								}
							break;
							case 'datetime':
								if($val[0] != ''){
									$start = date_fr_to_en($val[0]);
									$and .= " and `".$field."` >= '".$start."'";
								}
								
								if($val[1] != ''){
									$end = date_fr_to_en($val[1]);
									$and .= " and `".$field."` <= '".$end."'";
								}
							break;
							default:
								$and .= " and `".$field."` = '".$val."'";
							break;
						}
					}
				}
			}
		}
		
		/* order */
		if(empty($_REQUEST['order'])){
			$order = "id";
			$order_sens = "asc";
		} else {
			$order = $_REQUEST['order'];
			$order_sens = $_REQUEST['order_sens'];
		}
		
		/* per page conf */
		$conf_per_page = $this->getModuleConfiguration($category,$module,"perPage",25);
		$pagination_pas = $this->getModuleConfiguration($category,$module,"paginationPas",2);
		
		/* current page */
		if(!isset($_REQUEST['page']) or !is_numeric($_REQUEST['page'])){
			$current_page = 1;
		} else {
			$current_page = $_REQUEST['page'];
		}
		
		/* total pages */
		$total = $classname::count($and);
		$total_pages = ceil($total / $conf_per_page);
		
		$min_pagination = max(1,$current_page-$pagination_pas);
		$max_pagination = min($current_page+$pagination_pas,$total_pages);
		
		/* table info */
		$fields = $this->getModuleConfiguration($category,$module,"listing");
		
		/* current_page objects */
		$page_objects = $classname::all(($current_page-1)*$conf_per_page,$conf_per_page,$and,"order by ".$order." ".$order_sens);
		
		/* mass operations */
		
		$mass_definition = $this->getModuleConfiguration($category,$module,"mass",array());
		
		/* register variables */
		$this->add("current_page",$current_page);
		$this->add("total_pages",$total_pages);
		$this->add("min_pagination",$min_pagination);
		$this->add("max_pagination",$max_pagination);
		$this->add("fields",$fields);
		$this->add("page_objects",$page_objects);
		$this->add("total_result",$total);
		$this->add("orm",$orm);
		if(isset($filters)){
			$this->add("filters",$filters);
		}
		$this->add("current_order",$order);
		$this->add("current_order_sens",$order_sens);
		$this->add("mass",$mass_definition);
	
		$this->render("ajax");
	}
	
	public function logoutAction(){
		
		if(isset($_SESSION['admin']['id'])){
			$a = new \kinaf\admin($_SESSION['admin']['id']);
			$a->logout();
		}
		
		\kinaf\routes::redirect_to("admin","login");
		
	}
	
	public function ficheAction($category,$module,$id){
		
		$this->add("current_category",$category);
		$this->add("current_module",$module);
		
		$namespace = $this->getModuleConfiguration($category,$module,"namespace","application");
		$classname = "\\".$namespace."\\".$module;
		
		$orm = new orm($module);
		$object = new $classname($id);

		if(get_parent_class($object)=="kinaf\i18nModele"){
			$i18n = true;
			$this->add("i18nFields",$object->getI18nFields());
		} else {
			$i18n = false;
		}
		
		$has_many = $this->getModuleConfiguration($category,$module,"has_many");
		if(is_array($has_many)){
			$this->add("has_many",$has_many);
		}
	
		$this->add("s",\kinaf\language::all());
		$this->add("i18n",$i18n);
		$this->add("orm",$orm);
		$this->add("object",$object);

		$this->render();

	}
	
	public function addAction($category,$module){
		
		$this->add("current_category",$category);
		$this->add("current_module",$module);
		
		$namespace = $this->getModuleConfiguration($category,$module,"namespace","application");
		$classname = "\\".$namespace."\\".$module;
		
		$orm = new orm($module);
		$object = new $classname();

		if(get_parent_class($object)=="kinaf\i18nModele"){
			$i18n = true;
			$this->add("i18nFields",$object->getI18nFields());
		} else {
			$i18n = false;
		}
		
		$this->add("languages",\kinaf\language::all());
		$this->add("i18n",$i18n);
		$this->add("orm",$orm);
		$this->add("object",$object);

		$this->render_view("admin","fiche");
		
	}
	
	public function deleteAction(){
		$classname = "\\application\\".$_REQUEST['object'];
		echo $classname;
		$object = new $classname($_REQUEST['id']);
		$object->delete();
	}
	
	public function autocompleteAction(){
		$ret = array();
		$classname = "\\application\\".$_REQUEST['object'];
		$objects = $classname::all(0,20,"where ".$classname::$autoSuggestField." like '%".$_REQUEST['term']."%'");
		foreach($objects as $object){
			array_push($ret,array("id"=>$object->id,"label"=> (string) $object));
		}
		echo json_encode($ret);
	}
	
	public function has_manyAction($object){
		
		$category = $_REQUEST['category'];
		$module = $_REQUEST['module'];
		
		$this->add("current_category",$category);
		$this->add("current_module",$module);
		$this->add("current_object",$object);
		
		$has_many = $this->getModuleConfiguration($category,$module,"has_many");
		
		$conf = $has_many[$object];
		
		/* class info */
		if(isset($conf['namespace'])){
			$namespace = $conf['namespace'];
		} else {
			$namespace = "application";
		}
		
		$classname = "\\".$namespace."\\".$object;
		$orm = new \kinaf\orm($object);
		
		/* filter */
		$and = " where `".$module."` = ".$_REQUEST['id'];
		if(isset($_REQUEST['filter'])){
			foreach($_REQUEST as $id => $val){
				if( substr($id,0,8) == "filter__" ){
					$field = explode("__",$id);
					$field = $field[1];
					if($val!=""){
						/* on set le filter pour le reuse dans la vue */
						$filters[$field] = $val;
						/* on build la query */
						$type = $orm->getType($field);
						switch($type){
							case 'varchar':
								$and .= " and `".$field."` like '%".$val."%'";
							break;
							case 'tinyint':
								$and .= " and `".$field."` = ".$val;
							break;
							case 'date':
								
								if($val[0] != ''){
									$start = date_fr_to_en($val[0]);
									$and .= " and `".$field."` >= '".$start."'";
								}
								
								if($val[1] != ''){
									$end = date_fr_to_en($val[1]);
									$and .= " and `".$field."` <= '".$end."'";
								}
							break;
							case 'datetime':
								if($val[0] != ''){
									$start = date_fr_to_en($val[0]);
									$and .= " and `".$field."` >= '".$start."'";
								}
								
								if($val[1] != ''){
									$end = date_fr_to_en($val[1]);
									$and .= " and `".$field."` <= '".$end."'";
								}
							break;
							default:
								$and .= " and `".$field."` = '".$val."'";
							break;
						}
					}
				}
			}
		}
		
		/* order */
		if(empty($_REQUEST['order'])){
			$order = "id";
			$order_sens = "asc";
		} else {
			$order = $_REQUEST['order'];
			$order_sens = $_REQUEST['order_sens'];
		}
		
		/* per page conf */
		$conf_per_page = 25;
		if(isset($conf['perPage'])){
			$conf_per_page = $conf['perPage'];
		}
		
		$pagination_pas = 2;
		if(isset($conf['paginationPas'])){
			$conf_per_page = $conf['paginationPas'];
		}
		
		/* current page */
		if(!isset($_REQUEST['page']) or !is_numeric($_REQUEST['page'])){
			$current_page = 1;
		} else {
			$current_page = $_REQUEST['page'];
		}
		
		/* total pages */
		$total = $classname::count($and);
		$total_pages = ceil($total / $conf_per_page);
		
		$min_pagination = max(1,$current_page-$pagination_pas);
		$max_pagination = min($current_page+$pagination_pas,$total_pages);
		
		/* table info */
		$fields = $conf['listing'];
		
		/* current_page objects */
		$page_objects = $classname::all(($current_page-1)*$conf_per_page,$conf_per_page,$and,"order by ".$order." ".$order_sens);
		
		/* mass operations */
		
		$mass_definition = array();
		if(isset($conf['mass'])){
			$mass_definition = $conf['mass'];
		}
		
		/* register variables */
		$this->add("id",$_REQUEST['id']);
		$this->add("current_page",$current_page);
		$this->add("total_pages",$total_pages);
		$this->add("min_pagination",$min_pagination);
		$this->add("max_pagination",$max_pagination);
		$this->add("fields",$fields);
		$this->add("page_objects",$page_objects);
		$this->add("total_result",$total);
		$this->add("orm",$orm);
		if(isset($filters)){
			$this->add("filters",$filters);
		}
		$this->add("current_order",$order);
		$this->add("current_order_sens",$order_sens);
		$this->add("mass",$mass_definition);
	
		$this->render("ajax");
		
		
	}
	
	public function saveAction(){
		
		$class = $_REQUEST['class'];
		$obj = new $class($_REQUEST['id']);
		
		foreach($_POST as $id => $val){
			if($id != "id" && $id != "class"){
				if(substr($id,0,5)=="i18n_"){
					$info = explode("_",$id);
					$field = $info[1];
					$lang = $info[2];
					$obj->set($field,$val,$lang);
				} else {
					$obj->$id = $val;
				}
			}
		}
		
		$obj->save();
		
		echo $obj->id;
		
	}

	/**
	 * Check if a conf setting was set in admin.yaml if not return the default_value */
	protected function getModuleConfiguration($category,$module,$conf,$default_value=null){
		if(array_key_exists($conf,$this->config['categories'][$category]['modules'][$module])){
			return $this->config['categories'][$category]['modules'][$module][$conf];
		} else {
			return $default_value;
		}
	}
	
	
	
}

?>
