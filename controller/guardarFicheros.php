<?php
$carpetaDestino = "../public/assets/images/"; // Carpeta de destino donde se guardarán las imágenes

// Verificar si se han subido archivos
if (isset($_FILES["files"]) && !empty($_FILES["files"]["name"])) {
    // Recorrer todos los archivos subidos
    foreach ($_FILES["files"]["tmp_name"] as $key => $tmpName) {
        // Verificar si no hay error al subir el archivo
        if ($_FILES["files"]["error"][$key] === UPLOAD_ERR_OK) {
            // Obtener el tamaño del archivo actual
            $fileSize = $_FILES["files"]["size"][$key];

            $dataInfo = $_POST["info"][$key];
            // Generar el nuevo nombre del archivo
            $nuevoNombreArchivo = $carpetaDestino . $dataInfo . ".png";


            // Mover el archivo temporal a la ubicación deseada
            if (move_uploaded_file($tmpName, $nuevoNombreArchivo)) {
                // El archivo se ha guardado correctamente
                echo $dataInfo . ".png"."|";
            } else {
                // Ha ocurrido un error al guardar el archivo
            }
        } else {
            // Ha ocurrido un error durante la subida del archivo
        }
    }

} else {
}
?>
