<?php 
  require_once 'parametros.php';

  // Clase que devuelve una instancia de la
  // PDO para manejar el modelo de la base
  class Conexion_db {
    
    // unica instancia de la clase
    private static $db = null;
    // instancia de pdo
    private static $pdo;
    

    final private function __construct(){
    	try {
    	   // Crear nueva conexion PDO
           self::obtenerDB();
    	} catch ( PDOException $e){
    		// manejo de excepciones
    	}
    }

    function __destruct(){
    	self::$pdo = null;
    }
    

    // Retorna una unica instancia de la clase
    public static function obtenerint(){
      if (self::$db === null){
      	self::$db = new self();
      }
      return self::$db;
    }
    
    // Crea una nueva conexion PDO basada
    // constantes de conexion
    public function obtenerDB() {
      if (self::$pdo == null){
      	self::$pdo = new PDO(
        'mysql:dbname=' . base .
        ';host=' . servidor .
        ';',usuario,contrasena,
        array(PDO::MYSQL_ATTR_INIT_COMMAND =>
        	"SET NAMES utf8"));

        // habilitar excepciones
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE,
        	PDO::ERRMODE_EXCEPTION);      	
      }
      return self::$pdo;
    }
    
    // evita la clonación del objeto
    final protected function __clone() {
    }
  }
?>