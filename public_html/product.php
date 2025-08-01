<?php

session_start();
// Incluir los modelos
require_once __DIR__ . '/../php/models/Category.php';
require_once __DIR__ . '/../php/models/Product.php';
require_once __DIR__ . '/../php/models/Comments.php';

// Obtener el ID del producto desde la URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Crear instancias de los modelos
$categoryModel = new Category();
$productModel = new Product();
$commentsModel = new Comment();

// Obtener el producto
$product = $productModel->getById($productId);

// Si la categoría no existe, redirigir a página de error
if (!$product) {
    header('Location: under_construction.html');
    exit;
}

// Obtener categorías principales para el menú
$mainCategories = $categoryModel->getMainCategories();
$comments = $commentsModel->getByProductId($productId);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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


        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <img src="./assets/images/<?= $product['image']; ?>" alt="">

                    </div>
                </div>
                <div class="col-6">
                    <p class="title"><?= $product['model']; ?></p>
                    <div class="container"><?= $product['specs']; ?></div>
                    <div class="text-danger fw-bold">$ <?= number_format($product['price']); ?> MXN</div>

                </div>

            </div>
            <p></p>
            <h3>Comentarios de los compradores</h3>
            <?php foreach ($comments as $comment) : ?>
                <div class="comment-card">
                    <div class="comment-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="">
                                    <?= $comment['user_name']; ?>
                                </h4>


                            </div>
                            <div class="col-md-6">

                                <p>
                                    <?php for ($i = 0; $i <= 4; $i++) : ?>
                                        <span class="fa fa-star <?= $i < $comment['rating'] ? 'checked' : null; ?>"></span>
                                    <?php endfor; ?>
                                </p>

                            </div>
                        </div>
                        <?= $comment['text']; ?>
                    </div>
                </div>
            <?php endforeach ?>
</body>

</html>