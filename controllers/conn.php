<?php
class DbConn{
    protected $pdo;
    public function __construct(){
        
        try {
            $this->pdo = new \PDO("mysql:host=localhost;port=3306;dbname=rhfastnet;charset=utf8mb4", "root", "", [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_EMULATE_PREPARES => false
            ]);
            
        } catch (PDOException $e) {
            die('La conexión fallo: '.$e->getMessage());
        }
    }
    
           // Método para obtener el objeto PDO
    public function getPdo() {
        return $this->pdo;
    }
}

$db = new DbConn();
$pdo = $db->getPdo();