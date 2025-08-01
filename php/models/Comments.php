<?php
require_once __DIR__ . '/../Database.php';

class Comment
{
    private $db;
    private $table = 'comments';

    // Propiedades de la tabla 

    public $id;
    public $product_id;
    public $text;
    public $user_name;
    public $rating;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /* Obtener todos los comentarios */
    public function getAll()
    {
        $query = "SELECT * FROM ". $this->table . " ORDER BY id ASC";
        return $this->db->fetchAll($query);
    }

    /* Obtener comentarios por ID */
    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        return $this->db->fetch($query, [$id]);
    }

    /* Obtener comentarios por ID de producto */
    public function getByProductId($product_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE product_id = ?";
        return $this->db->fetchAll($query, [$product_id]);
    }
    /* Crear nuevo comentario  */
    public function create($product_id, $text, $user_name, $rating)
    {
        $query = "INSERT INTO " . $this->table . " (product_id,text,user_name,rating) VALUES (?, ?, ?, ?)";
        $this->db->query($query, [$product_id, $text, $user_name,$rating]);
        return $this->db->lastInsertId();
    }


}
