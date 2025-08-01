<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>

</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo htmlspecialchars($title); ?></h1>
            <a href="/categories/create" class="btn btn-success">Nueva Categoría</a>
        </div>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-message flash-<?php echo $_SESSION['flash']['type']; ?>">
                <?php echo htmlspecialchars($_SESSION['flash']['message']); ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <?php if (empty($categories)): ?>
            <p>No hay categorías disponibles.</p>
        <?php else: ?>
            <?php foreach ($categories as $category): ?>
                <div class="category-item">
                    <div class="category-name">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </div>
                    
                    <div class="actions">
                        <a href="/categories/edit/<?php echo $category['id']; ?>" class="btn">Editar</a>
                        <form method="POST" action="/categories/delete/<?php echo $category['id']; ?>" style="display: inline;">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta categoría?')">
                                Eliminar
                            </button>
                        </form>
                    </div>

                    <?php if (!empty($category['subcategories'])): ?>
                        <div class="subcategories">
                            <h4>Subcategorías:</h4>
                            <?php foreach ($category['subcategories'] as $subcategory): ?>
                                <div class="subcategory-item">
                                    <div class="category-name">
                                        <?php echo htmlspecialchars($subcategory['name']); ?>
                                    </div>
                                    <div class="actions">
                                        <a href="/categories/edit/<?php echo $subcategory['id']; ?>" class="btn">Editar</a>
                                        <form method="POST" action="/categories/delete/<?php echo $subcategory['id']; ?>" style="display: inline;">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta categoría?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html> 