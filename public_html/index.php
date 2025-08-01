<?php
session_start();

// Incluimos el modelo de categorías
require_once __DIR__ . '/../php/models/Category.php';
require_once __DIR__ . '/../php/models/Product.php';

// Instanciamos el modelo
$categoryModel = new Category();
$productsModel = new Product();

// Obtenemos las categorías principales para el menú
$mainCategories = $categoryModel->getMainCategories();

// Obtene el árbol completo de categorías
$categoryTree = $categoryModel->getCategoryTree();

// Obtenemos categorias individuales
$catId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$category = $categoryModel->getById($catId);

$products = $productsModel->getAll();
$featuredProducts = $productsModel->getFeatured();
$topRated = $productsModel->getTopRated();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda Online</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php include_once './includes/searchbar.php'; ?>
    <?php include_once './includes/navbar.php'; ?>



    <!-- Contenido principal -->
    <main class="container my-5">
        <?php include './includes/featured.php'; ?>

        <?php include './includes/best_rated.php'; ?>
    </main>

    <?php include_once './includes/footer.php' ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>