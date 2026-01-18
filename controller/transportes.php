

<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Transportes.php");

require_once '../public/vendor/autoload.php';


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


session_start();

$transporte = new Transporte();

$op = $_GET["op"];

switch ($op) {
    case "mostrarOrdenes":
     
        //Archivos Log
        generarLog('transportes.php','Mostrar Ordenes'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

    
        //* DEPENDIENDO DE SI ES ADMIN O USUARIO NORMAL, CARGARE TODOS O FILTRADO
        session_start();
        
        if($_SESSION['usu_rol'] == 1 || $_SESSION['usu_rol'] == 999){
            $json_string = json_encode($_SESSION['usu_rol']);
            $file = 'A1.json';
            file_put_contents($file, $json_string);
            $datosTransporte = $transporte->mostrarOrdenes();
        }else if($_SESSION['usu_rol'] == 0 ){
            $json_string = json_encode($_SESSION['usu_rol']);
            $file = 'A2.json';
            file_put_contents($file, $json_string);
           $idTrabajador =  $_SESSION['usu_idTransportistaUsu'];
           $datosTransporte = $transporte->mostrarOrdenesXIdTrabajador($idTrabajador);
        }
    
        $data = array();

        foreach ($datosTransporte as $row) {
           
                $sub_array = array();
                $sub_array[] = $row["idOrden"];
                // TTE_COD ahora es VARCHAR(10), manejar correctamente
                $tte_cod = $row["TTE_COD"] ?? '';
                $sub_array[] = !empty($tte_cod) ? transformarNumero($tte_cod) : '';
                $sub_array[] = $row["nombreTransportista_ordenTransporte"] ?? '';
                $sub_array[] = $row["id_cliente"] ?? '';
                $sub_array[] = isset($row["fechaOrdenViaje"]) ? fechaLocal($row["fechaOrdenViaje"]) : '';
                $sub_array[] = $row["puerto_origen"] ?? '';
                if ($row["tipoOrdenTransporte"] == 'C') {
                    $sub_array[] = '<span class="label label-success">CONTENEDOR</span>';
                } else if ($row["tipoOrdenTransporte"] == 'T') {
                    $sub_array[] = '<span class="label label-danger">TERRESTRE</span>';
                } else if ($row["tipoOrdenTransporte"] == 'M') {
                    $sub_array[] = '<span class="label label-warning">MULTIMODAL</span>';
                }
                if ($row["estOrden"] == 1) {
                    $sub_array[] = '<span class="badge bg-success">Activo</span>';
                } else {
                    $sub_array[] = '<span class="badge bg-secondary">Inactivo</span>';
                }
                $sub_array[] = "<a href='ordenTransporte.php?orden=".$row["tokenOrden"]."'><button class='btn btn-info waves-effect mg-l-10'><i class='fa fa-truck'></i></button></a>";
                $data[] = $sub_array;
             
        }
      
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        $json_string = json_encode($results);
        $file = 'results.json';
        file_put_contents($file, $json_string);
        echo json_encode($results);


    break;

   case "mostrarIncidencias":
    
        $idOrden = $_GET['orden'];
      
        $datosTransporte = $transporte->mostrarIncidenciaXOrden($idOrden);

        $data = array();

        foreach ($datosTransporte as $row) {

                $sub_array = array();
                $sub_array[] = $row["nombreSituacion"];
                $sub_array[] = $row["transportistaIncidencia"];
                $sub_array[] = FechaHoraLocal($row["fechaCreacionIncidencia"]);
                $sub_array[] = "<button class='btn btn-primary waves-effect mg-l-10'  onClick='cargarIncidencia(".$row["idIncidencia"].")'><i class='fa fa-eye'></i></button>";

                $data[] = $sub_array;
               
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);




    break;

    case "recogerIncidencia":
        $idIncidencia = $_POST["idIncidencia"];
        $datos = $transporte->recogerIncidencia($idIncidencia);
        echo json_encode($datos);
    break;

    
    case "selectSituacion":

        $resultado = $transporte->listarSituacion();

        echo json_encode($resultado);

    break;

    case "subirDoc":
        $carpeta = "incidencias";
        $imgsArray = array();
        
        foreach ($_FILES['file']['name'] as $key => $value) {
            $nombreReal = $_FILES['file']['name'][$key];
            $extension = pathinfo($nombreReal, PATHINFO_EXTENSION);

            $nombreUnico = transformarFecha("", ["d", "m", "Y", "H", "i", "s", "v", "u"]);

            $directorioDestino = "../public/$carpeta";

            $nombreArchivoNuevo = strval($nombreUnico) . "." . $extension;

            move_uploaded_file($_FILES['file']['tmp_name'][$key], $directorioDestino . "/" . $nombreArchivoNuevo);

            $imgsArray[$nombreReal] = $nombreArchivoNuevo;
        }
      
        echo json_encode($imgsArray);

    break;
    case "subirDocOrden":
        $carpeta = "gesdoc";
        $imgsArray = array();
        $id = $_GET["idOrden"];
        
        foreach ($_POST['files'] as $key => $base64Data) {
            $nombreReal = $_POST['filename'][$key];
            $extension = pathinfo($nombreReal, PATHINFO_EXTENSION);
    
            //$nombreUnico = transformarFecha("", ["d", "m", "Y", "H", "i", "s", "v", "u"]);
            $nombreUnico = $nombreReal;
            $directorioDestino = "../public/$carpeta/$id";
    
            if (!file_exists($directorioDestino)) {
                mkdir($directorioDestino, 0777, true);
            }
    
            /* $nombreArchivoNuevo = strval($nombreUnico) . "." . $extension; */
            $nombreArchivoNuevo = $nombreUnico;
            $filePath = $directorioDestino . "/" . $nombreArchivoNuevo;
            
            // Decodificar los datos base64 y guardar el archivo
            $decodedData = base64_decode($base64Data);
            file_put_contents($filePath, $decodedData);
           
                
            $imgsArray[$nombreReal] = $nombreArchivoNuevo;
        }
      
        echo json_encode($imgsArray);

    break;
    case "guardarIncidencia":
      
        $selectSituacion = $_POST['selectSituacion']; 
        $selectViaje = $_POST['selectViaje']; 
        $reportante = $_POST['reportante']; 
        $fechaIncidencia = $_POST['fechaIncidencia']; 
        $descripcionIncidencia = $_POST['descripcionIncidencia']; 
        $documentos = $_POST['documentos']; 
        $idOrden = $_POST['idOrden']; 

        $resultado = $transporte->guardarIncidencia($idOrden,$reportante,$selectSituacion,$selectViaje,$fechaIncidencia,$descripcionIncidencia,$documentos);

        echo json_encode($resultado);


    break;

    case "cambiarEstado":
        $idtransporte = $_POST["idIncidencia"];
        $transporte->cambiarEstado($idtransporte);
        //Archivos Log
       generarLog('departamentos.php','Elimina la incidencia N:'.$idtransporte); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
       //FIN Log
    break;

    case "actualizarPrecinto":
        $idOrden = $_POST["idOrden"];
      
        $precinto = $_POST["precinto"];
        
        $resultado = $transporte->guardarPrecinto($idOrden,$precinto);
        
        echo $resultado;
        //Archivos Log
       generarLog('ordenTransporte.php','ACTUALIZA EL PRECINTO A: '.$precinto); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
       //FIN Log
    break;
    case "actualizarContenedor":
        $idOrden = $_POST["idOrden"];
      
        $numeroContenedor = $_POST["numeroContenedor"];
        
        $resultado = $transporte->guardarContenedor($idOrden,$numeroContenedor);
        
        echo $resultado;
        //Archivos Log
       generarLog('ordenTransporte.php','ACTUALIZA EL CONTENEDOR A: '.$numeroContenedor); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
       //FIN Log
    break;
    case "recogerViajexId":
        $idViaje = $_POST["idViaje"];
              
        $resultado = $transporte->recogerViajesxID($idViaje);
        
        echo json_encode($resultado);
       
    break;
    case "recogerViajexIdOrden":
        $idViaje = $_POST["idViaje"];
              
        $resultado = $transporte->recogerViajesxIDOrden($idViaje);
        
        echo json_encode($resultado);
       
    break;
    case "actualizarViaje":
        $idViaje = $_POST["idViaje"];
        $fechaLlegada = $_POST["fechaLlegada"];
        $fechaSalida = $_POST["fechaSalida"];
        $observacionesViaje = $_POST["observacionesViaje"];

        $resultado = $transporte->actualizarViaje($idViaje,$fechaLlegada,$fechaSalida,$observacionesViaje);
        
        echo json_encode($resultado);
       
    break;
    case "actualizarFirma":
        
        $autorFirma = $_GET["autorFirma"];
        $idOrdenReceptor = $_POST['idOrdenTokenReceptor'];

        if($autorFirma == 'conductor'){
            $idViaje = $_POST["idViaje"];
            $signature = $_POST["signature"];
            $nombreInput = $_POST["nombreInput"];
            $DNIinput = $_POST["DNIinput"];

            $correoInput = 'No';
            
            $resultado = $transporte->actualizarFirma($idViaje,$signature,$nombreInput,$correoInput,$DNIinput,$autorFirma,$idOrdenReceptor);
        }else if($autorFirma == 'cliente'){
            $idViaje = $_POST["idViaje"];
            $signature = $_POST["signature"];
            $nombreInput = $_POST["nombreInput"];
            $DNIinput = $_POST["DNIinput"];
            $correoInput = $_POST["correoInput"];
        
            $resultado = $transporte->actualizarFirma($idViaje,$signature,$nombreInput,$correoInput,$DNIinput,$autorFirma,$idOrdenReceptor);
        }else if($autorFirma == 'receptor'){

            $idViaje = $_POST["idViaje"];
            $signature = $_POST["signature"];
            $nombreInput = $_POST["nombreInput"];
            $DNIinput = $_POST["DNIinput"];
            $correoInput = $_POST["correoInput"];

        
            $resultado = $transporte->actualizarFirma($idViaje,$signature,$nombreInput,$correoInput,$DNIinput,$autorFirma,$idOrdenReceptor);
        }
     
       
    break;
    
    case "correoEnviarOrden":
       
            
        // Asegúrate de que los datos POST estén limpios y preparados
        $correo = strtolower(trim($_POST['correo']));
        $orden = trim($_POST['orden']);
        $enlace = trim($_POST['enlace']);
        
        if (!empty($correo)) {
            // Obtener el nombre del servidor
            $server_name = $_SERVER['SERVER_NAME'];

            // Determinar el esquema (http o https)
            $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $port = $_SERVER['SERVER_PORT'];

            // Construir la URL completa (opcional)
            $full_url = $scheme . '://' . $server_name;
            if (($scheme === 'http' && $port != 80) || ($scheme === 'https' && $port != 443)) {
                $full_url .= ':' . $port;
            }
           
            ////////////////////////////
            //==== RECOGER ORDEN DINAMICA ==//
            // Obtener el esquema (http o https)
            $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

            // Obtener el host (dominio)
            $host = $_SERVER['HTTP_HOST'];

            // Obtener el path (ruta)
            $path = $_SERVER['REQUEST_URI'];

            // Construir la URL completa
            $url = $scheme . "://" . $host . $path;

            // Usamos parse_url para descomponer la URL en sus componentes
            $parsed_url = parse_url($url);

            // Obtenemos el esquema (http o https), el host (dominio) y el path
            $scheme = $parsed_url['scheme'];
            $host = $parsed_url['host'];
            $path = $parsed_url['path'];
            
            // Dividimos el path en sus segmentos
            $path_segments = explode('/', $path);

            // Verificar si el dominio es localhost
            if ($host === 'localhost') {
                // Código para cuando el dominio es localhost
                 // Reconstruimos la parte necesaria del path
                $required_path = '';
                for ($i = 0; $i < 3; $i++) { // Tomamos solo los primeros 3 segmentos
                    if (isset($path_segments[$i])) {
                        $required_path .= $path_segments[$i] . '/';
                    }
                }
            } else {
                // Código para otros dominios
                 // Reconstruimos la parte necesaria del path
                $required_path = '';
                for ($i = 0; $i < 1; $i++) { // Tomamos solo los primeros 2 segmentos
                    if (isset($path_segments[$i])) {
                        $required_path .= $path_segments[$i] . '/';
                    }
                }
            }
           

            // Construimos la URL base
            $enlaceOrden = $scheme . '://' . $host . $required_path .'view/Transportes'.$enlace;

            //==== FIN ORDEN DINAMICA ==//

         


            // Configuración del correo
            $dominio_actual = $_SERVER["SERVER_NAME"];
            $img = 'https://' . $dominio_actual . '/public/img/logo_pequeno.png';
            $nombreSoftware = 'Leader Transport';

            try {
                // Archivo de configuración Mail
                include 'configMail.php';
               
                // Configurar el remitente del correo
                $mail->setFrom('software@efeuno.com.es', 'Efeuno');
                $mail->addAddress($correo, ''); // Añadir destinatario

                $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo
                $mail->Subject = 'Orden de Transporte - Leader Transport';

                // Cargar y modificar el cuerpo del correo
                $cuerpo = file_get_contents("../public/mailTemplate/envioClienteOrden.html");
                $cuerpo = str_replace("NAMESOFTWARE", $nombreSoftware, $cuerpo);
                $cuerpo = str_replace("IDORDEN", $orden, $cuerpo);
                $cuerpo = str_replace("logotipo", $img, $cuerpo);
                $cuerpo = str_replace("enlaceOrdenTransporte", $enlaceOrden, $cuerpo);
                $cuerpo = str_replace("enlaceWeb", $full_url, $cuerpo);
                
                // Establecer el cuerpo del correo
                $mail->Body = $cuerpo;
                $mail->AltBody = "Orden de Transporte - Leader Transport";

                // Enviar el correo
                if ($mail->send()) {
                    echo '1';
                } else {
                    echo 'El mensaje no pudo ser enviado. Error de Mailer: ' . $mail->ErrorInfo;
                }
            } catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
            }
            
        }
    break;
    case "recogerFirmaPerfil":

        $resultado = $transporte->recogerFirmaPerfil();
        echo json_encode($resultado);
        break;
    

    default:
        echo "No se ha encontrado esta opción";
}
?>