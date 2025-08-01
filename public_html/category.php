<?php
session_start();

// Incluir los modelos
require_once __DIR__ . '/../php/models/Category.php';
require_once __DIR__ . '/../php/models/Product.php';

// Obtener el ID de la categoría desde la URL
$categoryId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Crear instancias de los modelos
$categoryModel = new Category();
$productModel = new Product();

// Obtener la categoría
$category = $categoryModel->getById($categoryId);

// Si la categoría no existe, redirigir a página de error
if (!$category) {
    header('Location: under_construction.html');
    exit;
}

// Obtener productos de esta categoría
$products = $productModel->getProductsByCategoryId($categoryId);

// Obtener subcategorías si las tiene
$subcategories = $categoryModel->getSubcategories($categoryId);

// Obtener categorías principales para el menú
$mainCategories = $categoryModel->getMainCategories();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--bootstrap cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo htmlspecialchars($category['name']); ?> - Tienda de Computadoras</title>
</head>

<body>
    <?php include __DIR__ . "/includes/categories_nav.php" ?>
    <?php include __DIR__ . "/includes/subcategories_nav.php" ?>




    <!-- Listado de productos -->
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Productos en <?php echo htmlspecialchars($category['name']); ?></h2>

            <?php if (empty($products)): ?>
                <div class="alert alert-info text-center">
                    <h4>No hay productos disponibles en esta categoría</h4>
                    <p>Pronto agregaremos productos a <?php echo htmlspecialchars($category['name']); ?></p>
                    <a href="index.php" class="btn btn-primary">Volver al Inicio</a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <img class="card-img-top" src="<?= htmlspecialchars('./assets/images/'.$product['image']) ?>" 
                                         alt="<?php echo htmlspecialchars($product['model']); ?>">
                                    <h5 class="card-title mt-3"><?php echo htmlspecialchars($product['model']); ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($product['brand']); ?></h6>
                                    <p class="card-text"><?php echo htmlspecialchars(substr($product['specs'], 0, 100)) . '...'; ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-primary">$<?php echo number_format($product['price'], 0, ',', '.'); ?></span>
                                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include './includes/featured.php'; ?>
    <?php include './includes/best_rated.php'; ?>
    <!-- Botón volver -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="index.php" class="btn btn-secondary">
                ← Volver al Inicio
            </a>
        </div>
    </div>
    </div>

    <!--bootstrap js cdn link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>