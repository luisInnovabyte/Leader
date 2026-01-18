<?php
header('Content-Type: application/json');

// Recibir la carpeta seleccionada
$carpeta = isset($_GET['carpeta']) ? $_GET['carpeta'] : '';

if (empty($carpeta)) {
    echo json_encode([]);
    exit;
}

// Construir ruta completa usando control_procesados como base
$directorioProcesados = '../Ordenes/descargas_procesados/control_procesados/' . $carpeta . '/';

// Verificar que el directorio existe y es válido
if (!is_dir($directorioProcesados)) {
    echo json_encode([]);
    exit;
}

// Buscar archivos JSON en la carpeta
$archivos = glob($directorioProcesados . '*.json');

// Ordenar archivos por fecha de modificación descendente (más reciente primero)
usort($archivos, function($a, $b) {
    return filemtime($b) - filemtime($a);
});

// Preparar array de respuesta
$resultado = [];
foreach ($archivos as $archivo) {
    $basename = basename($archivo);
    $fechaArchivo = filemtime($archivo);
    $fechaFormateada = date('d/m/Y H:i:s', $fechaArchivo);
    
    $resultado[] = [
        'nombre' => $basename,
        'fecha' => $fechaFormateada,
        'timestamp' => $fechaArchivo
    ];
}

echo json_encode($resultado);
?>
