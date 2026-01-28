<?php
/**
 * Script de Prueba - Simula Sesión Expirada
 * 
 * PROPÓSITO: Probar el modal de sesión expirada sin tener que hacer logout real
 * 
 * USO:
 * 1. Subir este archivo a la raíz del proyecto
 * 2. Abrir una página cualquiera (ej: ordenTransporte.php)
 * 3. Ejecutar en la consola del navegador:
 *    SessionMonitor.verificarAhora();
 * 4. O esperar 60 segundos y el modal aparecerá automáticamente
 * 
 * IMPORTANTE: ELIMINAR ESTE ARCHIVO DESPUÉS DE PROBAR
 */

header('HTTP/1.1 401 Unauthorized');
header('Content-Type: text/plain');
echo 'session_expired';
exit;
?>
