<?php

// Incluimos el modelo
require_once __DIR__ . '../../../php/models/Product.php';

// Instanciamos el modelo
$productsModel = new Product();

// Obtenemos categorias individuales
$catId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$topRated = $productsModel->getTopRated($catId);
?>

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