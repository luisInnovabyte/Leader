<?php
// Ruta al directorio de imágenes
$directory = '../../public/gesdoc/' . $_GET["orden"];
$files = glob($directory . '/*.{jpg,png,gif,jpeg,pdf}', GLOB_BRACE);

foreach ($files as $file) {
    $fileName = basename($file); // Obtener el nombre del archivo
    $fileExtension = pathinfo($file, PATHINFO_EXTENSION); // Obtener la extensión del archivo

    if ($fileExtension === 'pdf') {
        echo '<div><a href="../../public/gesdoc/' . $_GET["orden"] . '/' . $fileName . '" target="_blank">';
        echo '<img src="pdfIcono.png" alt="PDF">';
        echo '<small>' . $fileName . '</small>';
        echo "</a><button class='btn btn-danger waves-effect wd-100p deleteFromGallery'><i class='fa-solid fa-caret-up'></i> Borrar documento <i class='fa-solid fa-caret-up'></i></button></div>";
    } else {
        echo '<div><a href="../../public/gesdoc/' . $_GET["orden"] . '/' . $fileName . '" target="_blank">';
        echo '<a href="../../public/gesdoc/' . $_GET["orden"] . '/' . $fileName . '" download>';
echo '<img class="hoverImage" src="../../public/gesdoc/' . $_GET["orden"] . '/' . $fileName . '" alt="Imagen">';
echo '</a>';
        echo "</a><button class='btn btn-danger waves-effect wd-100p deleteFromGallery'><i class='fa-solid fa-caret-up'></i> Borrar imagen <i class='fa-solid fa-caret-up'></i></button></div>";
    }
}
?>
