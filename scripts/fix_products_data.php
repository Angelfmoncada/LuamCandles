<?php
// Fix encoding and spelling issues in products
// Run this script from the project root or adjust paths

define('APPROOT', dirname(__DIR__) . '/app');
require_once APPROOT . '/helpers/Env.php';
// Load .env from root
Env::load(dirname(__DIR__) . '/.env');

// Define DB constants if not defined by config (avoiding full config load if it has side effects)
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'root');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') ?: '');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'luamcandle');

require_once APPROOT . '/config/Database.php';

$db = new Database();

$products = [
    [
        'image' => 'Screenshot 2025-07-26 042148.png',
        'name' => 'Vela de Lavanda Relajante',
        'description' => 'Vela aromática con esencia de lavanda para momentos de relajación.',
        'price' => 375.00,
        'category' => 'Aromática'
    ],
    [
        'image' => 'Screenshot 2025-07-26 042218.png',
        'name' => 'Vela de Vainilla Dulce',
        'description' => 'Dulce aroma a vainilla que brinda calidez a tu hogar.',
        'price' => 462.50,
        'category' => 'Decorativa'
    ],
    [
        'image' => 'Screenshot 2025-07-26 042236.png',
        'name' => 'Vela Cítrica Energizante',
        'description' => 'Energizante aroma a limón y naranja.',
        'price' => 400.00,
        'category' => 'Aromática'
    ],
    [
        'image' => 'Screenshot 2025-07-26 042251.png',
        'name' => 'Vela Bosque Místico',
        'description' => 'Notas de pino y madera.',
        'price' => 500.00,
        'category' => 'Aromática'
    ],
    [
        'image' => 'Screenshot 2025-07-26 042344.png',
        'name' => 'Set de Regalo',
        'description' => 'Pack de 3 velas pequeñas surtidas.',
        'price' => 1125.00,
        'category' => 'Regalos'
    ],
    [
        'image' => 'Screenshot 2025-07-26 042356.png',
        'name' => 'Vela Rosa Romántica',
        'description' => 'Suave aroma a rosas frescas.',
        'price' => 475.00,
        'category' => 'Floral'
    ]
];

echo "Iniciando corrección de productos...\n";

foreach ($products as $p) {
    echo "Actualizando: " . $p['name'] . "\n";
    $sql = "UPDATE products SET name = :name, description = :description, price = :price, category = :category WHERE image = :image";
    $db->query($sql);
    $db->bind(':name', $p['name']);
    $db->bind(':description', $p['description']);
    $db->bind(':price', $p['price']);
    $db->bind(':category', $p['category']);
    $db->bind(':image', $p['image']);
    
    if($db->execute()) {
        echo "  -> OK\n";
    } else {
        echo "  -> ERROR\n";
    }
}

echo "Corrección completada.\n";
