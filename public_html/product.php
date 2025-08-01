<?php
session_start();

// Incluir los modelos
require_once __DIR__ . '/../php/models/Category.php';
require_once __DIR__ . '/../php/models/Product.php';

// Obtener el ID del producto desde la URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Crear instancias de los modelos
$categoryModel = new Category();
$productModel = new Product();

// Obtener el producto
$product = $productModel->getById($productId);

// Si la categoría no existe, redirigir a página de error
if (!$product) {
    header('Location: under_construction.html');
    exit;
}

// Obtener categorías principales para el menú
$mainCategories = $categoryModel->getMainCategories();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <title>Document</title>
</head>

<body>
    <!-- Navbar con menú de categorías -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Tienda de Computadoras</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>

                    <!-- Menú desplegable de categorías -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categorías
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($mainCategories as $cat): ?>
                                <li>
                                    <a class="dropdown-item" href="category.php?id=<?php echo $cat['id']; ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            </ol>
        </nav>

        <!-- Header de la categoría -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-center"><?php echo htmlspecialchars($product['model']); ?></h1>
                <p class="text-center lead">Explora nuestra selección de <?php echo htmlspecialchars($product['specs']); ?></p>
            </div>
        </div>



</body>

</html>