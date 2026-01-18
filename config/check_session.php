<?php
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['usu_id']) || empty($_SESSION['usu_id'])) {
    // Sesión no válida
    http_response_code(401);
    echo 'session_expired';
    exit;
}

// Sesión válida
http_response_code(200);
echo 'session_active';
exit;
