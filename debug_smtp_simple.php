<?php
/**
 * Script alternativo de depuración SMTP - Consulta directa a BD
 * Ejecutar en navegador: http://tudominio.com/debug_smtp_simple.php
 * IMPORTANTE: ELIMINAR ESTE ARCHIVO DESPUÉS DE VERIFICAR
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Script de Depuración SMTP - Versión Simple</h2>";

try {
    // Obtener configuración de BD desde el archivo JSON del dominio
    $dominioCompleto = $_SERVER['HTTP_HOST'];
    $jsonContentSettings = file_get_contents(__DIR__ . '/config/settings/' . $dominioCompleto . '.json');
    $configJsonSetting = json_decode($jsonContentSettings, true);
    
    // Acceder a las variables de BD
    $dbHost = $configJsonSetting['database']['host'];
    $dbPort = $configJsonSetting['database']['port'];
    $dbName = $configJsonSetting['database']['dbname'];
    $dbUser = $configJsonSetting['database']['username'];
    $dbPassword = $configJsonSetting['database']['password'];
    
    // Crear conexión PDO directa
    $conn = new PDO("mysql:host={$dbHost};port={$dbPort};dbname={$dbName}", $dbUser, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✓ Conexión a BD exitosa</p>";
    
    // Consultar configuración SMTP desde la vista que une empresa y tm_config
    $sql = "SELECT smtp_host, snto_auth, smtp_username, smtp_pass, smtp_port, smtp_receptor 
            FROM view_empresa_config 
            WHERE idConfig = 1 
            LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$resultado) {
        die("<p style='color: red;'>Error: No se encontraron datos de empresa en la BD</p>");
    }
    
    // Mostrar configuración
    echo "<h3>Configuración SMTP desde Base de Datos:</h3>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse; font-family: monospace;'>";
    echo "<tr><th style='text-align: left;'>Campo</th><th style='text-align: left;'>Valor</th></tr>";
    
    echo "<tr><td><strong>SMTP Host (Servidor)</strong></td><td>" . htmlspecialchars($resultado['smtp_host']) . "</td></tr>";
    echo "<tr><td><strong>SMTP Auth</strong></td><td>" . ($resultado['snto_auth'] == 1 ? '✓ Activada (1)' : '✗ Desactivada (0)') . "</td></tr>";
    echo "<tr><td><strong>SMTP Username</strong></td><td>" . htmlspecialchars($resultado['smtp_username']) . "</td></tr>";
    
    // Ocultar parcialmente la contraseña
    $pass = $resultado['smtp_pass'];
    if (!empty($pass)) {
        $passLength = strlen($pass);
        if ($passLength > 4) {
            $passOculta = substr($pass, 0, 2) . str_repeat('*', $passLength - 4) . substr($pass, -2);
        } else {
            $passOculta = str_repeat('*', $passLength);
        }
        echo "<tr><td><strong>SMTP Password</strong></td><td>" . $passOculta . " <em>(longitud: " . $passLength . " caracteres)</em></td></tr>";
    } else {
        echo "<tr><td><strong>SMTP Password</strong></td><td style='color: red;'>⚠️ VACÍA</td></tr>";
    }
    
    echo "<tr><td><strong>SMTP Port</strong></td><td>" . htmlspecialchars($resultado['smtp_port']) . "</td></tr>";
    echo "<tr><td><strong>SMTP Receptor</strong></td><td>" . htmlspecialchars($resultado['smtp_receptor']) . "</td></tr>";
    
    echo "</table>";
    
    // Diagnóstico
    echo "<br><h3>Diagnóstico:</h3>";
    echo "<div style='background: #f9f9f9; padding: 15px; border-left: 4px solid #007bff;'>";
    
    $puerto = $resultado['smtp_port'];
    if ($puerto == 587) {
        echo "<p>✓ <strong>Puerto 587</strong> - Debe usar cifrado <strong>TLS (STARTTLS)</strong></p>";
    } elseif ($puerto == 465) {
        echo "<p>✓ <strong>Puerto 465</strong> - Debe usar cifrado <strong>SSL (SMTPS)</strong></p>";
    } elseif ($puerto == 25) {
        echo "<p>⚠️ <strong>Puerto 25</strong> - Normalmente sin cifrado (no recomendado)</p>";
    } else {
        echo "<p>⚠️ <strong>Puerto " . $puerto . "</strong> - Puerto no estándar, verificar con el proveedor</p>";
    }
    
    if ($resultado['snto_auth'] != 1) {
        echo "<p style='color: orange;'>⚠️ Autenticación SMTP desactivada - Muchos servidores la requieren</p>";
    }
    
    if (empty($resultado['smtp_host'])) {
        echo "<p style='color: red;'>❌ <strong>Servidor SMTP vacío</strong></p>";
    }
    
    if (empty($resultado['smtp_username'])) {
        echo "<p style='color: red;'>❌ <strong>Usuario SMTP vacío</strong></p>";
    }
    
    if (empty($pass)) {
        echo "<p style='color: red;'>❌ <strong>Contraseña SMTP vacía</strong></p>";
    }
    
    echo "</div>";
    
    // Información del servidor
    echo "<br><h3>Información del Servidor:</h3>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><td><strong>IP del servidor</strong></td><td>" . $_SERVER['SERVER_ADDR'] . "</td></tr>";
    echo "<tr><td><strong>Nombre del servidor</strong></td><td>" . $_SERVER['SERVER_NAME'] . "</td></tr>";
    echo "<tr><td><strong>Software del servidor</strong></td><td>" . $_SERVER['SERVER_SOFTWARE'] . "</td></tr>";
    echo "<tr><td><strong>Versión de PHP</strong></td><td>" . phpversion() . "</td></tr>";
    echo "</table>";
    
    // Verificar extensiones PHP necesarias
    echo "<br><h3>Extensiones PHP necesarias:</h3>";
    echo "<ul>";
    echo "<li>OpenSSL: " . (extension_loaded('openssl') ? "✓ Instalada" : "<span style='color: red;'>✗ NO INSTALADA</span>") . "</li>";
    echo "<li>Sockets: " . (extension_loaded('sockets') ? "✓ Instalada" : "<span style='color: red;'>✗ NO INSTALADA</span>") . "</li>";
    echo "</ul>";
    
    // Datos para el cliente
    echo "<br><h3>📧 Datos para Proporcionar al Cliente:</h3>";
    echo "<div style='background: #fffacd; padding: 15px; border-radius: 5px; border: 2px solid #ffa500;'>";
    echo "<p><strong>Configuración actual:</strong></p>";
    echo "<ul>";
    echo "<li><strong>Servidor SMTP:</strong> " . htmlspecialchars($resultado['smtp_host']) . "</li>";
    echo "<li><strong>Puerto:</strong> " . htmlspecialchars($resultado['smtp_port']) . "</li>";
    echo "<li><strong>Usuario:</strong> " . htmlspecialchars($resultado['smtp_username']) . "</li>";
    echo "<li><strong>Autenticación:</strong> " . ($resultado['snto_auth'] == 1 ? 'Sí' : 'No') . "</li>";
    echo "<li><strong>Cifrado sugerido:</strong> " . ($puerto == 587 ? 'TLS' : ($puerto == 465 ? 'SSL' : 'Ninguno')) . "</li>";
    echo "<li><strong>IP del servidor web:</strong> " . $_SERVER['SERVER_ADDR'] . "</li>";
    echo "</ul>";
    
    echo "<p><strong>Preguntas para el cliente:</strong></p>";
    echo "<ol>";
    echo "<li>¿Son correctos el servidor, puerto y credenciales?</li>";
    echo "<li>¿El servidor SMTP permite relay desde la IP <code>" . $_SERVER['SERVER_ADDR'] . "</code>?</li>";
    echo "<li>¿Hay límite de envíos por hora/día?</li>";
    echo "<li>¿Es necesario autorizar la IP en el panel del proveedor de correo?</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<br><br>";
    echo "<p style='color: red; font-weight: bold; background: #ffebee; padding: 10px;'>";
    echo "⚠️ IMPORTANTE: ELIMINA ESTE ARCHIVO (debug_smtp_simple.php) DESPUÉS DE VERIFICAR POR SEGURIDAD";
    echo "</p>";
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>Error:</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
?>
