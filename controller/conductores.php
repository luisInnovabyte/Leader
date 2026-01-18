

<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Conductores.php");

require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$conductor = new Conductor();

$op = $_GET["op"];

switch ($op) {
    case "mostrarElementos":
        $datos = $conductor->mostrarElementos();

        //Archivos Log
        //generarLog('iva.php','Mostrar iva'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        $data = array();

        foreach ($datos as $row) {


            $sub_array = array();
            $sub_array[] = $row["idTransportista"];
            $sub_array[] = $row["nombreTransportista"];
            $sub_array[] = $row["idTransportistaLeader"]; //DNI
            $sub_array[] = $row["emailTransportista"];


            $sub_array[] = $row["direccionTransportista"];

            $sub_array[] = $row["poblacionTransportista"];

            $sub_array[] = $row["provinciaTransportista"];

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


    

    default:
        echo "No se ha encontrado esta opción";
}

?>