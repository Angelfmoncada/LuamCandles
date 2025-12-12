<?php

require_once '../app/config/config.php';

require_once '../app/helpers/session_helper.php';
require_once '../app/helpers/Csrf.php';

require_once '../app/config/Database.php';

require_once '../app/core/Controller.php';
require_once '../app/core/App.php';

// --- HOTFIX: CORRECCIÓN AUTOMÁTICA DE DATOS DE PRODUCTOS ---
// Este bloque corrige los problemas de codificación (mojibake) en la base de datos
// Se ejecuta en cada carga para asegurar que los datos estén limpios.
try {
    $db_fix = new Database();
    
    // 1. Corregir Vela Cítrica
    $db_fix->query("UPDATE products SET name = 'Vela Cítrica Energía', description = 'Energizante aroma a limón y naranja.', category = 'Aromática' WHERE name LIKE 'Vela C%trica%' OR description LIKE '%limÃ³n%'");
    $db_fix->execute();
    
    // 2. Corregir Vela Bosque Místico
    $db_fix->query("UPDATE products SET name = 'Vela Bosque Místico', description = 'Notas de pino y madera.', category = 'Aromática' WHERE name LIKE 'Vela Bosque M%'");
    $db_fix->execute();
    
    // 3. Corregir Vela Rosa Romántica
    $db_fix->query("UPDATE products SET name = 'Vela Rosa Romántica', description = 'Suave aroma a rosas frescas.', category = 'Floral' WHERE name LIKE 'Vela Rosa Rom%'");
    $db_fix->execute();
    
    // 4. Corregir Vela Lavanda (descripción)
    $db_fix->query("UPDATE products SET description = 'Vela aromática con esencia de lavanda para momentos de relajación.' WHERE name LIKE 'Vela Lavanda%' AND description LIKE '%relajaciÃ³n%'");
    $db_fix->execute();
    
    // 5. Corregir Vela Vainilla (descripción)
    $db_fix->query("UPDATE products SET description = 'Dulce aroma a vainilla que calidez a tu hogar.' WHERE name LIKE 'Vela Vainilla%' AND description LIKE '%Dulce aroma%'");
    $db_fix->execute();

    // 6. Corregir Categorías mal codificadas globalmente
    $db_fix->query("UPDATE products SET category = 'Aromática' WHERE category LIKE 'Arom%' AND category != 'Aromática'");
    $db_fix->execute();
    
} catch (Exception $e) {
    // Silently fail if DB connection issues, app will handle it later
}
// --- FIN HOTFIX ---

$app = new App;
