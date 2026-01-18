<?php
// Cargar configuración desde el archivo JSON
$nombreDominio = '192.168.31.19';
$jsonContentSettings = file_get_contents(__DIR__ . '/config/settings/' . $nombreDominio . '.json');
$configJsonSetting = json_decode($jsonContentSettings, true);

// Acceder a las variables de la base de datos
$dbHost = $configJsonSetting['database']['host'];
$dbPort = $configJsonSetting['database']['port'];
$dbName = $configJsonSetting['database']['dbname'];
$dbUser = $configJsonSetting['database']['username'];
$dbPassword = $configJsonSetting['database']['password'];

// Conectar a la BD
$conectar = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
$conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conectar->prepare('SHOW COLUMNS FROM `transportistas-Transporte` WHERE Field = "cpDireccionTransportista"');
$stmt->execute();
$col = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Información de la columna cpDireccionTransportista:\n";
echo "Tipo: " . $col['Type'] . "\n";
echo "Null: " . $col['Null'] . "\n";
echo "Default: " . ($col['Default'] ?? 'NULL') . "\n";
