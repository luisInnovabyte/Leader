<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filePath = $_POST['filePath'];

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo 'Documento eliminado con éxito';
        } else {
            echo 'Error al eliminar el documento';
        }
    } else {
        echo 'El documento no existe';
    }
} else {
    echo 'Método de solicitud no permitido';
}
?>
