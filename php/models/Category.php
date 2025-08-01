<?php
require_once __DIR__ . '/../Database.php';

class Category
{
    private $db;
    private $table = 'categories';

    // Propiedades de la tabla 

    public $id;
    public $name;
    public $parent_id;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /* Obtener todas las categorías */
    public function getAll()
    {
        $query = "SELECT * FROM ". $this->table . " ORDER BY name ASC";
        return $this->db->fetchAll($query);
    }

    /* Obtener categoría por ID */
    public function getById($id)
    {
        $query = "SELECT * FROM categories WHERE id = ?";
        return $this->db->fetch($query, [$id]);
    }

    /* Obtener categorías principales (sin parent_id) */
    public function getMainCategories()
    {
        $query = "SELECT * FROM categories WHERE parent_id IS NULL ORDER BY name ASC";
        return $this->db->fetchAll($query);
    }

    /* Obtener subcategorías de una categoría padre */
    public function getSubcategories($parentId)
    {
        $query = "SELECT * FROM categories WHERE parent_id = ? ORDER BY name ASC";
        return $this->db->fetchAll($query, [$parentId]);
    }

    /* Crear nueva categoría */
    public function create($name, $parentId = null)
    {
        $query = "INSERT INTO categories (name, parent_id) VALUES (?, ?)";
        $this->db->query($query, [$name, $parentId]);
        return $this->db->lastInsertId();
    }

    /* Actualizar categoría */
    public function update($id, $name, $parentId = null)
    {
        $query = "UPDATE categories SET name = ?, parent_id = ? WHERE id = ?";
        return $this->db->query($query, [$name, $parentId, $id]);
    }

    /* Eliminar categoría */
    public function delete($id)
    {
        // Primero verificamos si la categoria tiene subcategorías
        $subcategories = $this->getSubcategories($id);
        if (!empty($subcategories)) {
            throw new Exception("No se puede eliminar una categoría que tiene subcategorías");
        }

        // Verificamos si tiene productos
        $query = "SELECT COUNT(*) as count FROM products WHERE main_category = ?";
        $result = $this->db->fetch($query, [$id]);
        if ($result['count'] > 0) {
            throw new Exception("No se puede eliminar una categoría que tiene productos");
        }

        $query = "DELETE FROM categories WHERE id = ?";
        return $this->db->query($query, [$id]);
    }

    /* Obtener árbol de categorías (categorías con sus subcategorías) */
    public function getCategoryTree()
    {
        $mainCategories = $this->getMainCategories();
        $tree = [];

        foreach ($mainCategories as $category) {
            $category['subcategories'] = $this->getSubcategories($category['id']);
            $tree[] = $category;
        }

        return $tree;
    }

    /* Contar productos por categoría */
    public function getProductCount($categoryId)
    {
        $query = "SELECT COUNT(*) as count FROM products WHERE main_category = ?";
        $result = $this->db->fetch($query, [$categoryId]);
        return $result['count'];
    }
}
