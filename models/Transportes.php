<?php
// $json_string = json_encode('');
// $file = 'orden-Tse.json';
// file_put_contents($file, $json_string);

class Transporte extends Conectar
{


    public function recogerOrden($idOrden)
    {
        $idOrden = 1;
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `orden-Transporte` WHERE id_orden = $idOrden";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerOrdenToken($idOrdenToken)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `orden-viaje-view` WHERE tokenOrden = '$idOrdenToken'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetch();
    }
    public function recogerOrdenTokenAll($idOrdenToken, $idviaje)
    {

        $conectar = parent::conexion();
        parent::set_names();
        if (empty($idviaje)) {
            $sql = "SELECT * FROM `orden-viaje-view` WHERE tokenOrden = '$idOrdenToken'";
        } else {
            $sql = "SELECT * FROM `orden-viaje-view` WHERE tokenOrden = '$idOrdenToken' AND `idViaje`=$idviaje";
        }

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function mostrarOrdenes()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `orden-Transporte` ORDER BY `TTE_COD` DESC";
        $json_string = json_encode($sql);
        $file = 'orden-Transporte.json';
        file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function mostrarOrdenesXIdTrabajador($idTrabajador)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `orden-Transporte` WHERE id_Transportista = '$idTrabajador' ORDER BY `TTE_COD` DESC ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function recogerIncidencia($idIncidencia)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_OrdenXIncidenciaXSituaciones` WHERE idIncidencia = $idIncidencia";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function mostrarIncidenciaXOrden($idOrden)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $idOrdenSinBarra = str_replace("/", "", $idOrden);

        $sql = "SELECT * FROM `view_OrdenXIncidenciaXSituaciones` WHERE idOrden_Incidencia = '$idOrdenSinBarra' AND estIncidencia = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute($resultado = $sql->fetchAll());

        return $resultado = $sql->fetchAll();
    }

    public function listarSituacion()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `situaciones-Transporte` WHERE estSituacion = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function guardarIncidencia($idOrden, $reportante, $selectSituacion, $selectViaje, $fechaIncidencia, $descripcionIncidencia, $documentos)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $documentosJson = json_encode($documentos);

        $idOrdenSinBarra = str_replace("/", "", $idOrden);
        // Establecer la zona horaria de Madrid
        date_default_timezone_set('Europe/Madrid');
        // Formatear la fecha y hora actual en formato MySQL
        $fechaIncidencia = date('Y-m-d H:i:s'); // Formato MySQL (año-mes-día hora:minuto:segundo)
        $sql = "INSERT INTO `incidencia-Transporte`( `idOrden_Incidencia`, `transportistaIncidencia`, `situacionIncidencia`,`viajeIncidencia`, `documento`, `descripcion`, `fechaCreacionIncidencia`, `estIncidencia`) 
        VALUES ('$idOrdenSinBarra','$reportante',$selectSituacion,'$selectViaje','$documentosJson','$descripcionIncidencia','$fechaIncidencia',1)";

        // Determine situacionLiteral based on $selectSituacion
        switch ($selectSituacion) {
            case 1:
                $situacionLiteral = "Sin situacion";
                break;
            case 2:
                $situacionLiteral = "En reparto";
                break;
            case 3:
                $situacionLiteral = "En entrega";
                break;
            default:
                $situacionLiteral = "Situacion desconocida";
                break;
        }


        // Create a JSON object with the incidence data
        $incidenceData = [
            'idOrden' => $idOrdenSinBarra,
            'acccion' => 'insert',
            'reportante' => $reportante,
            'situacion' => $selectSituacion,
            'situacionLiteral' => $situacionLiteral,
            'viaje' => $selectViaje,
            'fechaIncidencia' => $fechaIncidencia,
            'descripcion' => $descripcionIncidencia,
            'documentos' => $documentos
        ];

        // Convert the data to JSON format
        $jsonString = json_encode($incidenceData, JSON_PRETTY_PRINT);


        // Add timestamp to the file name to avoid overwriting
        $timestamp = date('His'); // Format: HourMinuteSecond

        // Define the file path and name
        // $filePath = "../view/Ordenes/envios/I_{$idOrdenSinBarra}.json";
        $filePath = "../view/Ordenes/envios/I_{$idOrdenSinBarra}_{$timestamp}.json";
        file_put_contents($filePath, $jsonString);



        // Comproibación de variables para depuración -- INCIDENCIAS
        // Create a JSON object to log the requested variables
        // $debugData = [
        //     'idOrdenSinBarra' => $idOrdenSinBarra,
        //     'selectSituacion' => $selectSituacion,
        //     'incidenceData' => $incidenceData,
        //     'filePath' => $filePath
        // ];
        // Convert the data to JSON format
        // $debugJsonString = json_encode($debugData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // Define the file path and name
        // $debugFilePath = __DIR__ . "/debug_variables.json";
        // Save the JSON to the specified file
        // file_put_contents($debugFilePath, $debugJsonString);



        // Vamos a guardar la imagen en la carpeta de envios
        // Extract the document names from the JSON object
        $documentNames = $documentos['Documentos'];

        // Iterate through all documents and copy them
        foreach ($documentNames as $key => $documentName) {
            // Define the source and destination paths
            $sourcePath = "../public/incidencias/" . $documentName;
            $destinationPath = "../view/Ordenes/envios/" . $documentName;

            // PARA BORRAR //
            // $caminos = [
            //     'origen' => $idOrdenSinBarra,
            //     'destino' => $reportante,
            //     'documento' => $documentName,
            // ];
            // Convert the data to JSON format
            // $jsonString_camino = json_encode($caminos, JSON_PRETTY_PRINT);
            // file_put_contents($filePath, $jsonString_camino);
            //PARA BORRAR //


            // Check if the file exists in the source directory
            if (file_exists($sourcePath)) {
                // Copy the file to the destination directory
                if (!copy($sourcePath, $destinationPath)) {
                    error_log("Failed to copy $documentName from $sourcePath to $destinationPath");
                }
            } else {
                error_log("File $documentName does not exist in $sourcePath");
            }
        }

        //11062025171043269269674.jpg

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    // Cambiar de estado una incidencia a 0 (inactiva)
    public function cambiarEstado($idTransporte)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `incidencia-Transporte` SET `estIncidencia`= 0 WHERE idIncidencia = $idTransporte";


        // Retrieve the idOrden_Incidencia based on idIncidencia
        $sqlRetrieve = "SELECT idOrden_Incidencia, fechaCreacionIncidencia FROM `incidencia-Transporte` WHERE idIncidencia = :idTransporte";
        $stmtRetrieve = $conectar->prepare($sqlRetrieve);
        $stmtRetrieve->bindParam(':idTransporte', $idTransporte, PDO::PARAM_INT);
        $stmtRetrieve->execute();
        $result = $stmtRetrieve->fetch();

        if ($result) {
            $idOrdenSinBarra = $result['idOrden_Incidencia'];
        } else {
            throw new Exception("No se encontró el idOrden_Incidencia para el idIncidencia proporcionado.");
        }

        // Create a JSON object with the incidence data
        $incidenceData = [
            'idOrden' => $idOrdenSinBarra,
            'idTransporte' => $idTransporte,
            'fechaCreacion' => $result['fechaCreacionIncidencia'],
            'accion' => 'delete'
        ];

        // Convert the data to JSON format
        $jsonString = json_encode($incidenceData, JSON_PRETTY_PRINT);
        // Add timestamp to the file name to avoid overwriting
        date_default_timezone_set('Europe/Madrid');
        $timestamp = date('His'); // Format: HourMinuteSecond

        $filePath = "../view/Ordenes/envios/I_{$idOrdenSinBarra}_{$timestamp}.json";

        // Save the JSON to the specified file
        file_put_contents($filePath, $jsonString);

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function guardarContenedor($idOrden, $numeroContenedor)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "UPDATE `orden-Transporte` SET `contenedorActivo`= :numeroContenedor WHERE num_transporte = :idOrden";
            $stmt = $conectar->prepare($sql);

            // Bind parameters to prevent SQL injection
            $stmt->bindParam(':numeroContenedor', $numeroContenedor, PDO::PARAM_STR);
            $stmt->bindParam(':idOrden', $idOrden, PDO::PARAM_STR);

            // Execute the statement
            if ($stmt->execute()) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            // Log the error or handle it as needed
            error_log($e->getMessage());
            return 0;
        }
    }





    public function guardarPrecinto($idOrden, $precinto)
    {

        try {
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "UPDATE `orden-Transporte` SET `precintoActivo`= :precinto WHERE num_transporte = :idOrden";
            $stmt = $conectar->prepare($sql);

            // Bind parameters to prevent SQL injection
            $stmt->bindParam(':precinto', $precinto, PDO::PARAM_STR);
            $stmt->bindParam(':idOrden', $idOrden, PDO::PARAM_STR);

            // Execute the statement
            if ($stmt->execute()) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            // Log the error or handle it as needed
            error_log($e->getMessage());
            return 0;
        }
    }

    public function recogerViajesxOrden($idOrden)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `viaje-Transporte` WHERE id_OrdenViajeTransporte = $idOrden;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function recogerViajesxID($idViaje)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `viaje-Transporte` WHERE idViaje = $idViaje;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function recogerViajesxIDOrden($idViaje)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `orden-viaje-view` WHERE idViaje = $idViaje;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function actualizarViaje($idViaje, $fechaLlegada, $fechaSalida, $observacionesViaje)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `viaje-Transporte` SET 
        `fechaLlegadaViaje`='$fechaLlegada',`fechaSalidaViaje`='$fechaSalida',`ObservacionViaje`='$observacionesViaje',`FirmaViajeReceptor`='' WHERE idViaje = $idViaje";


        // Hay que buscar el campo numero de orden para poder guardar el JSON en la carpeta de envios
        $conectarOrden = parent::conexion();
        parent::set_names();
        $sqlOrden = "SELECT * FROM `viaje-Transporte` WHERE idViaje = $idViaje";
        $sqlOrden = $conectarOrden->prepare($sqlOrden);
        $sqlOrden->execute();
        $ordenData = $sqlOrden->fetch();

        // Obtener el numero de orden
        $idOrden = $ordenData['numeroOrdenViaje'];
        $lugarCode = $ordenData['LUGAR_COD'];
        $viaje = $ordenData['LUGAR_NOMBRE'] . " - " . $ordenData['LUGAR_DIRECCION'];
        $idOrdenSanitized = str_replace("/", "", $idOrden);

        // Vamos a montar el fichero JSON de la actualizacion del viaje
        $viajeData = [
            'orden' => $idOrdenSanitized,
            'lugarCode' => $lugarCode,
            'idViaje' => $idViaje,
            'viaje' => $viaje,
            'fechaLlegada' => $fechaLlegada,
            'fechaSalida' => $fechaSalida,
            'observaciones' => $observacionesViaje
        ];

        // Convert the data to JSON format
        $jsonString = json_encode($viajeData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Define the file path and name
        $filePath = "../view/Ordenes/envios/V_{$idOrdenSanitized}.json";

        // Save the JSON to the specified file
        file_put_contents($filePath, $jsonString);

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerFirmaPerfil()
    {
        $dniUsu = $_SESSION["usu_identificacionFiscal"];
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `transportistas-Transporte` WHERE `idTransportistaLeader` = '$dniUsu'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function actualizarFirma($idViaje, $signature, $nombreInput, $correoInput, $DNIinput, $autorFirma, $idOrdenReceptor)
    {
        $conectar = parent::conexion();
        parent::set_names();

        if ($autorFirma == 'conductor') {
            $sql = "UPDATE `viaje-Transporte` SET 
            `FirmaViajeConductor`='$signature',`nombreViajeConductor`='$nombreInput',`dniViajeConductor`='$DNIinput' 
            WHERE idViaje = $idViaje";

            /**********************************/
            /**             JSON              */
            /**      firma Conductor           */
            /**********************************/

            // Hay que buscar el campo numero de orden para poder guardar el JSON en la carpeta de envios
            $conectarOrden = parent::conexion();
            parent::set_names();
            $sqlOrden = "SELECT * FROM `viaje-Transporte` WHERE idViaje = $idViaje";
            $sqlOrden = $conectarOrden->prepare($sqlOrden);
            $sqlOrden->execute();
            $ordenData = $sqlOrden->fetch();

            // Obtener el numero de orden
            $idOrden = $ordenData['numeroOrdenViaje'];
            $lugarCode = $ordenData['LUGAR_COD'];
            $idOrdenSanitized = str_replace("/", "", $idOrden);


            // Vamos a montar el fichero JSON de la actualizacion del viaje
            $firmaData = [
                'orden' => $idOrdenSanitized,
                'lugarCode' => $lugarCode,
                'idViaje' => $idViaje,
                'firmaConductor' => $signature,
            ];
            // Convert the data to JSON format
            $jsonString = json_encode($firmaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            // Remove any slashes from the idOrden to avoid issues in the file name
            // Define the file path and name
            $filePath = "../view/Ordenes/envios/FCO_{$idOrdenSanitized}.json";

            // Create a separate JSON file to log the values of $jsonString and $filePath for debugging
            // $debugData = [
            //     'filePath' => $filePath,
            //     'jsonString' => $jsonString
            // ];
            // $debugFilePath = "../view/Ordenes/envios/debug_log.json";
            // file_put_contents($debugFilePath, json_encode($debugData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // Save the JSON to the specified file
            file_put_contents($filePath, $jsonString);

            /**********************************/
            /**              FIN              */
            /**             JSON             */
            /**      firma Conductor        */
            /**********************************/
        } else if ($autorFirma == 'receptor') {
            $sql = "UPDATE `viaje-Transporte` SET 
            `FirmaViajeReceptor`='$signature',`nombreViajeReceptor`='$nombreInput',`correoViajeReceptor`='$correoInput',`dniViajeReceptor`='$DNIinput' 
            WHERE idViaje = $idViaje";

            /**********************************/
            /**             JSON              */
            /**      firma receptor           */
            /**********************************/

            // Hay que buscar el campo numero de orden para poder guardar el JSON en la carpeta de envios
            $conectarOrden = parent::conexion();
            parent::set_names();
            $sqlOrden = "SELECT * FROM `viaje-Transporte` WHERE idViaje = $idViaje";
            $sqlOrden = $conectarOrden->prepare($sqlOrden);
            $sqlOrden->execute();
            $ordenData = $sqlOrden->fetch();

            // Obtener el numero de orden
            $idOrden = $ordenData['numeroOrdenViaje'];
            $lugarCode = $ordenData['LUGAR_COD'];
            $idOrdenSanitized = str_replace("/", "", $idOrden);

            // Vamos a montar el fichero JSON de la actualizacion del viaje
            $firmaData = [
                'orden' => $idOrdenSanitized,
                'lugarCode' => $lugarCode,
                'idViaje' => $idViaje,
                'firmaReceptor' => $signature,
            ];
            // Convert the data to JSON format
            $jsonString = json_encode($firmaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            // Define the file path and name
            $filePath = "../view/Ordenes/envios/FRE_{$idOrdenSanitized}.json";

            // Save the JSON to the specified file
            file_put_contents($filePath, $jsonString);

            /**********************************/
            /**              FIN              */
            /**             JSON              */
            /**      firma receptor           */
            /**********************************/
        } else if ($autorFirma == 'cliente') {
            $sql = "UPDATE `orden-Transporte` SET 
            `nombreCliente`='$nombreInput',`correoCliente`='$correoInput',`dniCliente`='$DNIinput',`firmaCliente`='$signature'
             WHERE `tokenOrden` = '$idOrdenReceptor'";

            /**********************************/
            /**             JSON              */
            /**      Firma Cliente           */
            /**********************************/

            // Hay que buscar el campo numero de orden para poder guardar el JSON en la carpeta de envios
            $conectarOrden = parent::conexion();
            parent::set_names();
            $sqlOrden = "SELECT * FROM `viaje-Transporte` WHERE idViaje = $idViaje";
            $sqlOrden = $conectarOrden->prepare($sqlOrden);
            $sqlOrden->execute();
            $ordenData = $sqlOrden->fetch();

            // Obtener el numero de orden
            $idOrden = $ordenData['numeroOrdenViaje'];
            $lugarCode = $ordenData['LUGAR_COD'];
            $idOrdenSanitized = str_replace("/", "", $idOrden);

            // Vamos a montar el fichero JSON de la actualizacion del viaje
            $firmaData = [
                'orden' => $idOrdenSanitized,
                'lugarCode' => $lugarCode,
                'idViaje' => $idViaje,
                'firmaCliente' => $signature,
            ];
            // Convert the data to JSON format
            $jsonString = json_encode($firmaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            // Define the file path and name
            $filePath = "../view/Ordenes/envios/FCL_{$idOrdenSanitized}.json";

            // Save the JSON to the specified file
            file_put_contents($filePath, $jsonString);

            /**********************************/
            /**              FIN              */
            /**             JSON              */
            /**       firma Cliente           */
            /**********************************/
        }

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
