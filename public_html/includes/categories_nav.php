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
<!-- Navbar con menú de categorías -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
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
                        <?php foreach ($mainCategories as $category): ?>
                            <li>
                                <a class="dropdown-item" href="category.php?id=<?php echo $category['id']; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

