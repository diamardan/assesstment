#  Script de configuración de la base de datos 
# Creación de base de datos
# CREATE DATABASE IF NOT EXISTS assesstment;
# Usamos la base de datos creada 
# USE assesstment; 
# Creación de las tablas correspondientes al nivel básico del assesstment 
CREATE TABLE IF NOT EXISTS products(
    id INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(100),
    specs VARCHAR(255),
    price INT,
    main_category INT,
    brand VARCHAR(80),
    image VARCHAR(255) #Agregamos la columna image para almacenar la ruta de la imágen
);
CREATE TABLE IF NOT EXISTS comments(
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    text VARCHAR(255),
    user_name VARCHAR(120),
    rating INT
);
CREATE TABLE IF NOT EXISTS categories(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    parent_id INT DEFAULT NULL
);
#Agregamos las claves foraneas para las relaciones entre la tabla productos y comentarios, y entre las tablas productos y categorias.
ALTER TABLE products
ADD CONSTRAINT fk_products_main_category FOREIGN KEY (main_category) REFERENCES categories(id) ON DELETE
SET NULL;
ALTER TABLE comments
ADD CONSTRAINT fk_comments_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE;
ALTER TABLE categories
ADD CONSTRAINT fk_categories_parent FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE
SET NULL;
# Agregamos como mínimo 10 registros para cada tabla
# Agregamos las categorias
INSERT INTO categories (name, parent_id)
VALUES('Computadoras', NULL),
    ('Laptops', 1),
    ('Desktops', 1),
    ('Componentes', NULL),
    ('Procesadores (CPUs)', 4),
    ('Motherboards', 4),
    ('Memorias RAM', 4),
    ('Almacenamiento', 4),
    ('Accesorios', NULL),
    ('Monitores', 9);
# Agregamos los primeros 10 productos para mostrar en el sitio
INSERT INTO products (model, specs, price, main_category, brand)
VALUES (
        'ROG STRIX G15',
        'Procesador AMD Ryzen 7 6800H, NVIDIA GeForce RTX 3060, 16GB RAM DDR5, 512GB SSD NVMe, Pantalla IPS de 15.6" Full HD (1920x1080) 144Hz.',
        25000,
        2,
        'ASUS'
    ),
    (
        'UltraSharp U3821DW',
        'Pantalla IPS curva de 37.5" (3840x1600), relación de aspecto 21:9, cobertura de color sRGB del 100%, DisplayPort, HDMI, USB-C (90W Power Delivery)',
        18500,
        10,
        'Dell'
    ),
    (
        'GeForce RTX 4070 Ti',
        '12GB GDDR6X, Interfaz PCIe 4.0, 7680 CUDA Cores, Boost Clock 2790 MHz.',
        16899,
        4,
        'Dell'
    ),
    (
        'T7 Shield',
        '2TB NVMe SSD, Interfaz USB 3.2 Gen 2 (hasta 1,050 MB/s de lectura, 1,000 MB/s de escritura), resistente al agua y al polvo (IP65), protección contra caídas de 3 metros.',
        3199,
        8,
        'Samsung'
    ),
    (
        'Alloy Origins Core',
        'Switches mecánicos HyperX Red (lineales), retroiluminación RGB por tecla, marco de aluminio, diseño TKL (Tenkeyless)',
        1799,
        4,
        'HyperX'
    ),
    (
        'G502 LIGHTSPEED',
        'Sensor HERO 25K (hasta 25,600 DPI), 11 botones programables, tecnología inalámbrica LIGHTSPEED, compatible con carga PowerPlay, peso ajustable',
        1949,
        9,
        'Logitech'
    ),
    (
        'Vengeance RGB DDR5',
        '32GB (2x16GB) DDR5 6000MHz, Latencia CL30, compatible con Intel XMP 3.0, iluminación RGB.',
        2899,
        7,
        'Corsair'
    ),
    (
        'Laptop Gamer MSI THIN 15 B13VE',
        'Intel Core i5-13420H / 144Hz / 16GB / 512GB SSD / NVIDIA GeForce RTX 4060 / Gris',
        19999,
        2,
        'MSI'
    ),
    (
        'Monitor Profesional NZXT CANVAS 27Q V2',
        '27” / QHD / 2560x1440 / 165Hz / 1ms / HDMIx2 / DP / HDR 10 / AMD FreeSync Premium y Gsync / Panel IPS / Incluye Base para Monitor /',
        2999,
        10,
        'NZXT'
    ),
    (
        'Procesador AMD Ryzen 7 5800XT',
        '8 Core / 16 Thread / 3.8GHz / 4.8GHz Boost / AM4 / TDP 105W / (Requiere Tarjeta de Video)',
        3899,
        5,
        'AMD'
    );
#
    # Insertamos 10 registros de comentarios
#
INSERT INTO comments (product_id, text, user_name, rating)
VALUES (1, 'Excelente calidad', 'J JHONA JAMESON', 5),
    (2, 'Lo volvería a comprar', 'PETER B PARKER', 5),
    (3, 'No me gustó', 'MILES MORALES', 3),
    (4, 'Llegó incompleto', 'OTTO OCTAVIUS', 1),
    (5, 'Cumple su función', 'BETTY BRANT', 4),
    (
        6,
        'Precio elevado para la calidad del producto',
        'CURT CONNORS',
        3
    ),
    (7, 'No lo recomiendo', 'ROBBIE ROBERTSON', 1),
    (
        8,
        'Eviten ésta marca, sobrevalorada',
        'FRANK CASTLE',
        1
    ),
    (
        9,
        'Todo bien, llegó muy rápido',
        'REED RICHARDS',
        5
    ),
    (
        10,
        'Excelente, lo recomiendo ampliamente',
        'MATT MURDOCK',
        5
    );