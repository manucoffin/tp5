<?php

class Model{
	//Instance de la classe PDO
	public $bdd = null;

	//Instance de la classe Model
	private static $instance = null;

	//Constante: nom d'utilisateur de la bdd
	const DEFAULT_SQL_USER = DB_USER;

	//Constante: hôte de la bdd
	const DEFAULT_SQL_HOST = DB_HOST;

	//Constante: hôte de la bdd
	const DEFAULT_SQL_PASS = DB_PASS;

	//Constante: nom de la bdd
	const DEFAULT_SQL_DTB = DB_DATABASE;

        public function __construct(){
            if(is_null(self::$instance)){
                if(DEBUG){
                    $this->bdd = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST
                    ,self::DEFAULT_SQL_USER,self::DEFAULT_SQL_PASS
                    , array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
                    self::$instance = $this;
                }else{
                    $this->bdd = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST
                    ,self::DEFAULT_SQL_USER,self::DEFAULT_SQL_PASS);
                }
            }else{
                $inst = self::getInstance();
                $this->bdd = $inst->bdd;
            }
        }

	//Crée et retourne l'objet Model
	public static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = new Model();
		}
		return self::$instance;
	}
}