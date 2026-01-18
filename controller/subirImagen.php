<?php
$prep = $_GET["zona"];

/* if($prep == "trabajo"){
    $targetDir = "../../img/Imagenes/lapidas-sencillas/todos/"; // Carpeta de destino

} else if($prep == "dropzone-lapidas-incrustacion" || $prep == "dropzone-lapidas-con-metal" || $prep == "dropzone-ilustracion-infantil" || $prep == "dropzone-panteones" || $prep == "dropzone-otros/accesorios"){
    $targetDir = "../../img/Imagenes/$prep/"; // Carpeta de destino


} else {
    $targetDir = "../../img/$prep/"; // Carpeta de destino

} */
$targetDir = "../../images/$prep/";


if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true); // Crea la carpeta si no existe
}

$uploadedFiles = [];

// Manejar la subida de archivos
foreach ($_FILES["archivo"]["tmp_name"] as $key => $tmp_name) {
    $name = $_FILES["archivo"]["name"][$key];
    $targetFile = $targetDir . str_replace(' ', '-', basename($name)); // Reemplazar espacios por guiones

    if (move_uploaded_file($_FILES['archivo']['tmp_name'][$key], $targetFile)) {
        $uploadedFiles[] = str_replace(' ', '-', $name); // Agregar el nombre modificado al arreglo de archivos subidos
        echo '1';
    }
}

?>