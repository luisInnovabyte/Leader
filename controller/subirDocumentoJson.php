<?php

$op = $_GET["op"];

switch ($op) {

    case "subirDocImport":
        
        $imgsArray = array(); // Array para almacenar los nombres de los archivos subidos
        
        // Verificar si hay archivos en el array de $_FILES
        if (isset($_FILES['file']) && !empty($_FILES['file']['name'][0])) {
            foreach ($_FILES['file']['name'] as $key => $nombreReal) {
                
                $extension = pathinfo($nombreReal, PATHINFO_EXTENSION);

                // Verificar que la extensión sea JSON
                if ($extension === 'json') {
                    $directorioDestino = "../view/Ordenes/uploads/";

                    // Mover el archivo a la ubicación de destino
                    move_uploaded_file($_FILES['file']['tmp_name'][$key], $directorioDestino . $nombreReal);

                    // Almacenar el nombre en el array de respuesta
                    $imgsArray[$nombreReal] = $nombreReal;
                } else {
                    // Si no es JSON, mostrar mensaje de error
                    echo json_encode(["error" => "Formato no permitido. Solo se aceptan archivos JSON."]);
                    exit();
                }
            }

            // Responder con un JSON que contenga los archivos subidos
            echo json_encode($imgsArray);
        } else {
            // No se subió ningún archivo
            echo json_encode(["error" => "No se subieron archivos."]);
        }

        break;

    default:
        echo "No se ha encontrado esta opción";
}
?>
