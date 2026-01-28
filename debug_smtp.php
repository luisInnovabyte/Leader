<?php
/**
 * Script de depuración para verificar configuración SMTP
 * Ejecutar en navegador: http://tudominio.com/debug_smtp.php
 * IMPORTANTE: ELIMINAR ESTE ARCHIVO DESPUÉS DE VERIFICAR
 */

// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    session_start();
    
    // Intentar cargar configuración
    if (!file_exists("config/config.php")) {
        die("<h2>Error:</h2><p>No se encuentra el archivo config/config.php</p>");
    }
    
    require_once("config/config.php");
    
    if (!file_exists("models/Config.php")) {
        die("<h2>Error:</h2><p>No se encuentra el archivo models/Config.php</p>");
    }
    
    require_once("models/Config.php");

    $config = new Config();
    $datosEmpresa = $config->getEmpresaLogueada();

    if (empty($datosEmpresa)) {
        die("<h2>Error:</h2><p>No se pudieron obtener los datos de la empresa. ¿Hay sesión iniciada?</p>");
    }
} catch (Exception $e) {
    die("<h2>Error al cargar configuración:</h2><p>" . htmlspecialchars($e->getMessage()) . "</p>");
}

// Mostrar configuración SMTP (ocultando parcialmente la contraseña)
echo "<h2>Configuración SMTP Actual</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><th>Campo</th><th>Valor</th></tr>";

echo "<tr><td><strong>SMTP Host (Servidor)</strong></td><td>" . htmlspecialchars($datosEmpresa[0]['smtp_host']) . "</td></tr>";
echo "<tr><td><strong>SMTP Auth (Autenticación)</strong></td><td>" . ($datosEmpresa[0]['snto_auth'] == 1 ? 'Activada (1)' : 'Desactivada (0)') . "</td></tr>";
echo "<tr><td><strong>SMTP Username (Usuario)</strong></td><td>" . htmlspecialchars($datosEmpresa[0]['smtp_username']) . "</td></tr>";

// Ocultar parcialmente la contraseña por seguridad
$pass = $datosEmpresa[0]['smtp_pass'];
$passOculta = strlen($pass) > 4 ? substr($pass, 0, 2) . str_repeat('*', strlen($pass) - 4) . substr($pass, -2) : str_repeat('*', strlen($pass));
echo "<tr><td><strong>SMTP Password (Contraseña)</strong></td><td>" . $passOculta . " <em>(longitud: " . strlen($pass) . " caracteres)</em></td></tr>";

echo "<tr><td><strong>SMTP Port (Puerto)</strong></td><td>" . htmlspecialchars($datosEmpresa[0]['smtp_port']) . "</td></tr>";
echo "<tr><td><strong>SMTP Receptor</strong></td><td>" . htmlspecialchars($datosEmpresa[0]['smtp_receptor']) . "</td></tr>";

echo "</table>";

echo "<br><h3>Configuración SSL/TLS en configMail.php</h3>";
echo "<p>Revisa el archivo <code>controller/configMail.php</code> para ver si está configurado <code>SMTPSecure</code>:</p>";
echo "<ul>";
echo "<li><strong>Puerto 465:</strong> Usar <code>\$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;</code> (o 'ssl')</li>";
echo "<li><strong>Puerto 587:</strong> Usar <code>\$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;</code> (o 'tls')</li>";
echo "<li><strong>Puerto 25:</strong> Normalmente sin cifrado (no recomendado)</li>";
echo "</ul>";

echo "<br><h3>Diagnóstico del Error</h3>";
echo "<p><strong>Error actual:</strong> <span style='color: red;'>Relay access denied</span></p>";
echo "<p>Este error significa que el servidor SMTP rechaza el envío. Posibles causas:</p>";
echo "<ol>";
echo "<li><strong>Autenticación incorrecta:</strong> Usuario o contraseña incorrectos</li>";
echo "<li><strong>Falta SMTPSecure:</strong> El servidor requiere SSL/TLS pero no está configurado</li>";
echo "<li><strong>IP no autorizada:</strong> El servidor solo permite envíos desde IPs específicas</li>";
echo "<li><strong>Puerto incorrecto:</strong> El puerto no coincide con el tipo de conexión</li>";
echo "<li><strong>Límite de envíos:</strong> Se ha excedido el límite de correos permitidos</li>";
echo "</ol>";

echo "<br><h3>Datos a proporcionar al cliente:</h3>";
echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 5px;'>";
echo "<p><strong>Servidor SMTP:</strong> " . htmlspecialchars($datosEmpresa[0]['smtp_host']) . "</p>";
echo "<p><strong>Puerto:</strong> " . htmlspecialchars($datosEmpresa[0]['smtp_port']) . "</p>";
echo "<p><strong>Usuario:</strong> " . htmlspecialchars($datosEmpresa[0]['smtp_username']) . "</p>";
echo "<p><strong>Autenticación SMTP:</strong> " . ($datosEmpresa[0]['snto_auth'] == 1 ? 'Sí' : 'No') . "</p>";
echo "<p style='color: red;'><strong>⚠️ PREGUNTA AL CLIENTE:</strong></p>";
echo "<ul>";
echo "<li>¿El puerto es correcto? (común: 587 para TLS, 465 para SSL, 25 sin cifrado)</li>";
echo "<li>¿Está configurado el cifrado? (TLS para 587, SSL para 465)</li>";
echo "<li>¿Las credenciales (usuario/contraseña) son correctas?</li>";
echo "<li>¿El servidor permite relay desde esta IP: " . $_SERVER['SERVER_ADDR'] . "?</li>";
echo "<li>¿Hay límite de envíos por hora/día?</li>";
echo "</ul>";
echo "</div>";

echo "<br><br>";
echo "<p style='color: red; font-weight: bold;'>⚠️ IMPORTANTE: ELIMINA ESTE ARCHIVO (debug_smtp.php) DESPUÉS DE VERIFICAR LA CONFIGURACIÓN POR SEGURIDAD</p>";
?>
