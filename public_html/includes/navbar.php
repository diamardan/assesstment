<?php

// Incluimos el modelo de categorías
require_once __DIR__ . '../../../php/models/Category.php';

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

<!-- Navbar de categorías -->
<nav class="navbar navbar-expand-lg navbar-light category-nav mb-4">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarCategories">
            <ul class="navbar-nav mx-auto">
                <?php foreach ($mainCategories as $cat) : ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="category.php?id=<?= $cat['id'];?>"><?= $cat['name']; ?></a>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>
    </div>
</nav>