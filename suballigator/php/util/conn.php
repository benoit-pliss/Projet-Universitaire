<?php



class singletonConnexion {
    private static $instance = null;
    private $connexion;
    private function __construct() {
        $this->connexion = new PDO('mysql:host=localhost;dbname=sae301grp1_bd', "sae301grp1", "EavooBepeep0aida");
    }
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new singletonConnexion();
        }
        return self::$instance;
    }
    public function getConnexion() {
        return $this->connexion;
    }
}

$mysqlConnection = singletonConnexion::getInstance()->getConnexion();

?>