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
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Productos Destacados</h2>
                <p class="text-muted">Los productos más populares esta semana</p>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredProducts as $featuredProduct): ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <a class="product-card" href="product.php?id=<?= $featuredProduct['id']; ?>">
                        <div class="card">
                            <!-- <span class="badge badge-discount">-20%</span> -->
                            <img src="<?= './assets/images/' . $featuredProduct['image']; ?>" class="card-img-top" alt="Producto 1">
                            <div class="card-body">
                                <h5 class="card-title"><?= $featuredProduct['model']; ?></h5>
                                <p class="card-text text-muted"><?= $featuredProduct['specs'] ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="text-danger fw-bold"><?= '$' . number_format($featuredProduct['price'], 0, '.', ',') . ' MXN'; ?></span><!-- 
                                    <span class="text-decoration-line-through text-muted small ms-2">$624.99</span> -->
                                    </div>
                                    <!-- <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-cart-plus"></i>
                                </button> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>

            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold">Productos Mejor valorados</h2>
                    <p class="text-muted">Los productos con mejor calificación de los usuarios</p>
                </div>
            </div>

            <div class="row g-4">
                <?php foreach ($topRated as $topProduct): ?>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <a class="product-card" href="product.php?id=<?= $topProduct['id']; ?>">
                            <div class="card">
                                <!-- <span class="badge badge-discount">-20%</span> -->
                                <img src="<?= './assets/images/' . $topProduct['image']; ?>" class="card-img-top" alt="Producto 1">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $topProduct['model']; ?></h5>
                                    <p>Rating: <?= number_format($topProduct['average_rating'], 1) ?> ⭐</p>

                                    <p class="card-text text-muted"><?= $topProduct['specs'] ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-danger fw-bold"><?= '$' . number_format($topProduct['price'], 0, '.', ',') . ' MXN'; ?></span><!-- 
                                    <span class="text-decoration-line-through text-muted small ms-2">$624.99</span> -->
                                        </div>
                                        <!-- <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-cart-plus"></i>
                                </button> -->
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
    </main>

    <?php include_once './includes/footer.php' ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>