<?php

class Product
{
    private $db;
    private $table = 'products';
    private $categories = 'categories';

    //Campos de la tabla
    public $model;
    public $specs;
    public $price;
    public $main_category;
    public $brand;
    public $image;

    //Constructor de la conexión a la DB
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    //Obtener los productos
    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        return $this->db->fetchAll($query);
    }

    //Obtener un producto por su id
    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        return $this->db->fetch($query, [$id]);
    }

    //Obtener un producto por su categoria
    public function getProductsByCategoryId($categoryId)
    {
        $query = "SELECT t1.*,t2.id as categoryId,t2.name,t2.parent_id FROM " . $this->table . " t1 LEFT JOIN " . $this->categories . " t2 on t2.id = t1.main_category WHERE main_category = ?";
        return $this->db->fetchAll($query, [$categoryId]);
    }
}
