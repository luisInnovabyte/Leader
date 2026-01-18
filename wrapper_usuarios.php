<?php
// Activar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 0); // No mostrar en pantalla
ini_set('log_errors', 1);

// Capturar todos los errores
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    // No hacer nada, solo suprimir el warning
    return true;
});

// Iniciar buffer
ob_start();

// Incluir el controlador
$_GET['op'] = 'mostrarUsuarios';
include('controller/usuario.php');

// Capturar el resultado
$output = ob_get_clean();

// Enviar headers y contenido
header('Content-Type: application/json; charset=utf-8');
echo $output;
