<?php
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/Logger.php';

class DatabaseInitializer {
    private $db;
    private $logger;
    private $stats = [
        'categories' => 0,
        'products' => 0,
        'comments' => 0
    ];

    public function __construct() {
        $this->db = Database::getInstance();
        $this->logger = new Logger('database_init_',);
        $this->logger->add("Iniciando script de inicialización");
    }

    public function run() {
        try {
            $this->insertCategories();
            $this->insertProducts();
            $this->insertComments();
            /* $this->showResults(); */
        } catch (Exception $e) {
            $this->logger->addError("Error crítico: " . $e->getMessage());
            $this->showResults();
        }
    }

    private function insertCategories() {
        $this->logger->add("Insertando categorías adicionales");
        
        $categories = [
            ['name' => 'Gaming', 'parent_id' => null],
            ['name' => 'Oficina', 'parent_id' => null],
            ['name' => 'Audio', 'parent_id' => null],
            ['name' => 'Tarjetas de Video', 'parent_id' => 4],
            ['name' => 'Fuentes de Poder', 'parent_id' => 4],
            ['name' => 'Gabinetes', 'parent_id' => 4],
            ['name' => 'Teclados Gaming', 'parent_id' => 9],
            ['name' => 'Mouse Gaming', 'parent_id' => 9],
            ['name' => 'Auriculares', 'parent_id' => 13],
            ['name' => 'Altavoces', 'parent_id' => 13]
        ];

        $sql = "INSERT INTO categories (name, parent_id) VALUES (?, ?)";
        
        foreach ($categories as $cat) {
            try {
                $this->db->query($sql, [$cat['name'], $cat['parent_id']]);
                $this->stats['categories']++;
                $this->logger->addSuccess("Categoría: " . $cat['name']);
            } catch (PDOException $e) {
                $this->logger->addError("Categoría '{$cat['name']}': " . $e->getMessage());
            }
        }
    }

    private function insertProducts() {
        $this->logger->add("Insertando productos adicionales");
        
        $products = [
            ['MacBook Pro M3', 'Chip M3 Pro, 18GB RAM, 512GB SSD, 14.2"', 45000, 2, 'Apple', 'macbook_pro_m3.png'],
            ['ThinkPad X1 Carbon', 'Intel i7-1355U, 16GB RAM, 512GB SSD, 14" 2.8K', 32000, 2, 'Lenovo', 'thinkpad_x1.png'],
            ['ROG Zephyrus M16', 'Intel i9-13900H, RTX 4090, 32GB RAM, 1TB SSD', 55000, 2, 'ASUS', 'rog_zephyrus.png'],
            ['Intel Core i9-14900K', '24 Cores, 32 Threads, 6.0GHz Turbo, LGA1700', 8500, 5, 'Intel', 'i9_14900k.png'],
            ['MSI MPG B650 Carbon', 'Socket AM5, DDR5, PCIe 5.0, WiFi 6E', 3200, 6, 'MSI', 'msi_b650.png'],
            ['Kingston Fury Beast DDR5', '32GB 6000MHz CL36, XMP 3.0', 2200, 7, 'Kingston', 'kingston_fury.png'],
            ['Samsung 990 PRO', '2TB NVMe M.2 PCIe 4.0, 7,450 MB/s', 2800, 8, 'Samsung', 'samsung_990.png'],
            ['Corsair K100 RGB', 'Switches Cherry MX Speed, RGB, multimedia', 3500, 17, 'Corsair', 'corsair_k100.png'],
            ['Razer DeathAdder V3 Pro', 'Sensor 30K DPI, 63g, HyperSpeed', 2800, 18, 'Razer', 'razer_deathadder.png'],
            ['Sennheiser HD 660S', 'Estudio, 150Ω, 10-41,000 Hz', 4200, 19, 'Sennheiser', 'sennheiser_hd660s.png']
        ];

        $sql = "INSERT INTO products (model, specs, price, main_category, brand, image) VALUES (?, ?, ?, ?, ?, ?)";
        
        foreach ($products as $prod) {
            try {
                $this->db->query($sql, $prod);
                $this->stats['products']++;
                $this->logger->addSuccess("Producto: " . $prod[0]);
            } catch (PDOException $e) {
                $this->logger->addError("Producto '{$prod[0]}': " . $e->getMessage());
            }
        }
    }

    private function insertComments() {
        $this->logger->add("Insertando comentarios adicionales");
        
        $comments = [
            [11, 'Excelente rendimiento, muy recomendado', 'TONY STARK', 5],
            [12, 'Buena relación calidad-precio', 'STEVE ROGERS', 4],
            [13, 'Perfecto para gaming', 'BRUCE BANNER', 5],
            [14, 'Muy potente pero consume mucha energía', 'THOR ODINSON', 4],
            [15, 'Fácil instalación y configuración', 'NATASHA ROMANOFF', 5],
            [16, 'Funciona perfectamente con mi sistema', 'CLINT BARTON', 5],
            [17, 'Velocidad increíble, muy satisfecho', 'WANDA MAXIMOFF', 5],
            [18, 'Teclado premium, vale la pena', 'VISION', 4],
            [19, 'Mouse muy preciso y cómodo', 'SAM WILSON', 5],
            [20, 'Calidad de audio excepcional', 'BUCKY BARNES', 5]
        ];

        $sql = "INSERT INTO comments (product_id, text, user_name, rating) VALUES (?, ?, ?, ?)";
        
        foreach ($comments as $comment) {
            try {
                $this->db->query($sql, $comment);
                $this->stats['comments']++;
                $this->logger->addSuccess("Comentario para producto ID: " . $comment[0]);
            } catch (PDOException $e) {
                $this->logger->addError("Comentario producto ID {$comment[0]}: " . $e->getMessage());
            }
        }
    }

    private function showResults() {
        $total = array_sum($this->stats);
        
        $this->logger->add("=== REPORTE FINAL ===");
        $this->logger->add("Categorías: " . $this->stats['categories']);
        $this->logger->add("Productos: " . $this->stats['products']);
        $this->logger->add("Comentarios: " . $this->stats['comments']);
        $this->logger->add("Total: " . $total);
        $this->logger->add("Script completado");
        
        $logFile = $this->logger->save();
        
        echo "=== INICIALIZACIÓN DE BASE DE DATOS ===\n";
        echo "Fecha: " . date('Y-m-d H:i:s') . "\n";
        echo "Categorías: " . $this->stats['categories'] . "\n";
        echo "Productos: " . $this->stats['products'] . "\n";
        echo "Comentarios: " . $this->stats['comments'] . "\n";
        echo "Total: " . $total . "\n";
        echo "Log: " . $logFile . "\n";
        echo "=====================================\n";
    }
}

$initializer = new DatabaseInitializer();
$initializer->run();
?> 