<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión directa usando el mismo método del sistema
$dominioCompleto = $_SERVER['HTTP_HOST'];
$nombreDominio = $dominioCompleto;

$jsonContentSettings = file_get_contents(__DIR__ . '/config/settings/' . $nombreDominio . '.json');
$configJsonSetting = json_decode($jsonContentSettings, true);

$dbHost = $configJsonSetting['database']['host'];
$dbPort = $configJsonSetting['database']['port'];
$dbName = $configJsonSetting['database']['dbname'];
$dbUser = $configJsonSetting['database']['username'];
$dbPassword = $configJsonSetting['database']['password'];

try {
    $conectar = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
    $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Verificación Usuario - software@efeuno.es</h2>";
    
    // Consulta directa
    $sql = "SELECT idUsu, correoUsu, nombreUsu, rolUsu, estUsu FROM tm_usuario WHERE correoUsu = 'software@efeuno.es'";
    $stmt = $conectar->prepare($sql);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($usuario) {
        echo "<h3>✅ Datos en Base de Datos:</h3>";
        echo "<pre>";
        print_r($usuario);
        echo "</pre>";
        
        echo "<h3>🔍 Análisis del campo rolUsu:</h3>";
        echo "<ul>";
        echo "<li><strong>Valor:</strong> " . var_export($usuario['rolUsu'], true) . "</li>";
        echo "<li><strong>Tipo:</strong> " . gettype($usuario['rolUsu']) . "</li>";
        echo "<li><strong>rolUsu == 1:</strong> " . ($usuario['rolUsu'] == 1 ? 'TRUE ✅' : 'FALSE ❌') . "</li>";
        echo "<li><strong>rolUsu === 1:</strong> " . ($usuario['rolUsu'] === 1 ? 'TRUE ✅' : 'FALSE ❌') . "</li>";
        echo "<li><strong>rolUsu == 0:</strong> " . ($usuario['rolUsu'] == 0 ? 'TRUE ✅' : 'FALSE ❌') . "</li>";
        echo "</ul>";
        
        // Verificar tipo de campo en BD
        $sqlType = "SHOW COLUMNS FROM tm_usuario WHERE Field = 'rolUsu'";
        $stmtType = $conectar->prepare($sqlType);
        $stmtType->execute();
        $fieldInfo = $stmtType->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>📊 Estructura del campo rolUsu:</h3>";
        echo "<pre>";
        print_r($fieldInfo);
        echo "</pre>";
        
    } else {
        echo "<p>❌ Usuario no encontrado</p>";
    }
    
} catch (Exception $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
