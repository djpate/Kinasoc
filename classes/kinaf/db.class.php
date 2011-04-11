<?
namespace kinaf;
/* this is nothing else but a PDO wrapper */
class Db {
	
	private $pdoInstance;
   
    private static $instance;
    public $db;
 
    private function __construct() {
		global $pdoConf;
		$this->pdoInstance = new \PDO($pdoConf['pdoType'].":host=".$pdoConf['pdoHost'].";dbname=".$pdoConf['pdoDb'],$pdoConf['pdoUser'],$pdoConf['pdoPass']);
        $this->pdoInstance->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION); 
        $this->pdoInstance->exec("set names 'utf8'");
        $this->db = $pdoConf['pdoDb'];
	}
   
    private function __clone() {}
   
    public static function singleton() {
		
		if (!isset(self::$instance)) {
        		$c = __CLASS__;
        		self::$instance = new $c;
		}
		
		return self::$instance;
    
    }
    
    /* pdo functions */
    
    public function quote($str){
		return $this->pdoInstance->quote($str);
	}
	
	public function lastInsertId(){
		return $this->pdoInstance->lastInsertId();
	}
	
	public function query($str){
		try {
			$q = $this->pdoInstance->query($str);
            return $q;
		} catch (\PDOException $e) {
			$err = "Erreur dans la requete : \n".$str."\n". $e->getMessage() . "\n".$e->getTraceAsString();
			error_log($err);
            exit;
		}
	}
	
	public function exec($str){
		try {
			return $this->pdoInstance->exec($str);
		} catch (\PDOException $e) {
			$err = "Erreur dans la requete : \n".$str."\n". $e->getMessage() . "\n".$e->getTraceAsString();
			error_log($err);
            exit;
		}
	}
   
}
?>
