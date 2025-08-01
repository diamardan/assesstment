<?php
require_once __DIR__ . '/../install/config.php';
//Métodos generales para usar en utilizando la base de datos
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
        //Método para obtener la instancia de la base de datos
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //Método para obtener la conexión
    public function getConnection() {
        return $this->connection;
    }

    //Método para realizar la query
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Error en consulta: " . $e->getMessage());
        }
    }
    
    //Método para obtener todos los registros
    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    //Método para obtener solo un registro
    public function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }
    //Método para obtener el id de la última fila insertada en la tabla
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
}
