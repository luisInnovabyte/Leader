<?php
/**
 * Script para verificar la conexión a la base de datos
 * Prueba ambos métodos de conexión disponibles en el proyecto
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== TEST DE CONEXIÓN A BASE DE DATOS ===\n\n";

// ========================================
// TEST 1: Conexión usando __conexion.json
// ========================================
echo "📌 TEST 1: Verificando conexión con __conexion.json\n";
echo str_repeat("-", 50) . "\n";

try {
    $jsonPath = __DIR__ . '/config/__conexion.json';
    
    if (!file_exists($jsonPath)) {
        throw new Exception("❌ El archivo __conexion.json no existe en: " . $jsonPath);
    }
    
    echo "✓ Archivo de configuración encontrado\n";
    
    $json = file_get_contents($jsonPath);
    $config = json_decode($json, true);
    
    if ($config === null) {
        throw new Exception("❌ Error al parsear el archivo JSON");
    }
    
    echo "✓ Configuración JSON parseada correctamente\n";
    echo "  - Host: " . $config['host'] . "\n";
    echo "  - Puerto: " . ($config['port'] ?? '3306') . "\n";
    echo "  - Base de datos: " . $config['database'] . "\n";
    echo "  - Usuario: " . $config['user'] . "\n";
    
    $port = isset($config['port']) ? $config['port'] : '3306';
    $dsn = "mysql:host={$config['host']};port=$port;dbname={$config['database']};charset={$config['charset']}";
    
    $pdo = new PDO($dsn, $config['user'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
    
    echo "✅ CONEXIÓN EXITOSA con __conexion.json\n";
    
    // Verificar versión de MySQL
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    echo "✓ Versión de MySQL/MariaDB: " . $version . "\n";
    
    // Verificar base de datos actual
    $dbName = $pdo->query('SELECT DATABASE()')->fetchColumn();
    echo "✓ Base de datos actual: " . $dbName . "\n";
    
    // Contar tablas
    $tablas = $pdo->query("SHOW TABLES")->rowCount();
    echo "✓ Número de tablas: " . $tablas . "\n";
    
    $pdo = null;
    
} catch (PDOException $e) {
    echo "❌ ERROR DE CONEXIÓN PDO: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// ========================================
// TEST 2: Conexión usando settings/*.json
// ========================================
echo "📌 TEST 2: Verificando conexión con settings/{dominio}.json\n";
echo str_repeat("-", 50) . "\n";

try {
    // Simular dominio (puedes cambiar esto según necesites)
    $dominiosPrueba = [
        'localhost',
        '192.168.31.35',
        'leader.innovabyte.es',
        '192.168.31.19'
    ];
    
    $conexionExitosa = false;
    $dominioUsado = null;
    
    foreach ($dominiosPrueba as $dominio) {
        $settingsPath = __DIR__ . '/config/settings/_' . $dominio . '.json';
        
        // Probar también sin guion bajo
        if (!file_exists($settingsPath)) {
            $settingsPath = __DIR__ . '/config/settings/' . $dominio . '.json';
        }
        
        if (file_exists($settingsPath)) {
            echo "✓ Archivo encontrado: " . basename($settingsPath) . "\n";
            $dominioUsado = $dominio;
            
            $jsonContentSettings = file_get_contents($settingsPath);
            $configJsonSetting = json_decode($jsonContentSettings, true);
            
            if ($configJsonSetting === null || !isset($configJsonSetting['database'])) {
                echo "  ⚠ Formato JSON inválido o sin sección 'database'\n";
                continue;
            }
            
            $dbHost = $configJsonSetting['database']['host'];
            $dbPort = $configJsonSetting['database']['port'];
            $dbName = $configJsonSetting['database']['dbname'];
            $dbUser = $configJsonSetting['database']['username'];
            $dbPassword = $configJsonSetting['database']['password'];
            
            echo "  - Host: " . $dbHost . "\n";
            echo "  - Puerto: " . $dbPort . "\n";
            echo "  - Base de datos: " . $dbName . "\n";
            echo "  - Usuario: " . $dbUser . "\n";
            
            try {
                $pdo2 = new PDO(
                    "mysql:host={$dbHost};port={$dbPort};dbname={$dbName}",
                    $dbUser,
                    $dbPassword,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                
                echo "✅ CONEXIÓN EXITOSA con settings/" . basename($settingsPath) . "\n";
                
                // Verificar versión
                $version = $pdo2->query('SELECT VERSION()')->fetchColumn();
                echo "✓ Versión de MySQL/MariaDB: " . $version . "\n";
                
                // Verificar base de datos
                $dbNameActual = $pdo2->query('SELECT DATABASE()')->fetchColumn();
                echo "✓ Base de datos actual: " . $dbNameActual . "\n";
                
                // Contar tablas
                $tablas = $pdo2->query("SHOW TABLES")->rowCount();
                echo "✓ Número de tablas: " . $tablas . "\n";
                
                $conexionExitosa = true;
                $pdo2 = null;
                break;
                
            } catch (PDOException $e) {
                echo "  ❌ Error de conexión: " . $e->getMessage() . "\n";
            }
        }
    }
    
    if (!$conexionExitosa && $dominioUsado === null) {
        echo "⚠ No se encontró ningún archivo de configuración en settings/\n";
        echo "Archivos disponibles:\n";
        $settingsFiles = glob(__DIR__ . '/config/settings/*.json');
        foreach ($settingsFiles as $file) {
            echo "  - " . basename($file) . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n";
echo str_repeat("=", 50) . "\n";
echo "Test de conexión completado\n";
echo str_repeat("=", 50) . "\n";
?>
