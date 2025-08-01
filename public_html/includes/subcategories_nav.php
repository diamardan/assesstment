<?php

// Instanciamos el modelo
$categoryModel = new Category();

// Obtenemos las categorías principales para el menú
$mainCategories = $categoryModel->getMainCategories();

// Obtene el árbol completo de categorías
$categoryTree = $categoryModel->getCategoryTree();

// Obtenemos categorias individuales
$catId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$category = $categoryModel->getById($catId);
?>

<div class="container mt-4">
    <?php include_once 'breadcrumbs.php'; ?>

    <!-- Header de la categoría -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center"><?php echo htmlspecialchars($category['name']); ?></h1>
            <p class="text-center lead">Explora nuestra selección de <?php echo htmlspecialchars($category['name']); ?></p>
        </div>
    </div>

    <!-- Subcategorías si las tiene -->
    <?php if (!empty($subcategories)): ?>
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="mb-4">Subcategorías</h3>
                <div class="row">
                    <?php foreach ($subcategories as $subcategory): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($subcategory['name']); ?></h5>
                                    <a href="category.php?id=<?php echo $subcategory['id']; ?>" class="btn btn-outline-primary">
                                        Ver Productos
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>