<?php
session_start();

// Incluir el controlador de categorias
require_once __DIR__ . '/../php/controllers/CategoryController.php';

// Crear instancia del controlador
$controller = new CategoryController();

// Obtener la URL y determinar la acción
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);

// Extraer la ruta después del dominio
$basePath = '/categories.php';
$route = str_replace($basePath, '', $path);

// Enrutamiento simple
if (empty($route) || $route === '/') {
    // GET /categories - Listar categorías
    $controller->index();
} elseif ($route === '/create') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // GET /categories/create - Mostrar formulario
        $controller->create();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // POST /categories/create - Guardar categoría
        $controller->store();
    }
} elseif (preg_match('/^\/edit\/(\d+)$/', $route, $matches)) {
    $id = $matches[1];
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // GET /categories/edit/{id} - Mostrar formulario de edición
        $controller->edit($id);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // POST /categories/edit/{id} - Actualizar categoría
        $controller->update($id);
    }
} elseif (preg_match('/^\/delete\/(\d+)$/', $route, $matches)) {
    $id = $matches[1];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // POST /categories/delete/{id} - Eliminar categoría
        $controller->delete($id);
    }
} elseif ($route === '/api') {
    // GET /categories/api - API JSON
    $controller->apiGetAll();
} elseif (preg_match('/^\/api\/subcategories\/(\d+)$/', $route, $matches)) {
    $parentId = $matches[1];
    // GET /categories/api/subcategories/{parentId} - API subcategorías
    $controller->apiGetSubcategories($parentId);
} else {
    // Ruta no encontrada
    http_response_code(404);
    echo "Página no encontrada";
}
?> 