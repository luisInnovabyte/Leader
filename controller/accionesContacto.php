

<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/AccionesContacto.php");

require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$accion = new AccionContacto();

$op = $_GET["op"];

switch ($op) {
    case "mostrarElementos":
        $datos = $accion->mostrarAcciones();

        //Archivos Log
        //generarLog('iva.php','Mostrar iva'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        $data = array();

        foreach ($datos as $row) {


            $sub_array = array();
            $sub_array[] = $row["idAccion"];
            $sub_array[] = $row["descAccion"];


            //TODO: diseñar columna de estado del IVA segun este a 0 o a 1

            if ($row["estAccion"] == 1) {
                $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Accion" onClick="cargarElemento('.$row["idAccion"].')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger waves-effect" title="Desactivar Accion" onClick="cambiarEstado('.$row["idAccion"].')"><i class="fa-solid fa-user-slash"></i></button>';
            } else {
                $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Accion" onClick="cargarElemento('.$row["idAccion"].')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-success waves-effect" title="Activar Accion" onClick="cambiarEstado('.$row["idAccion"].')"><i class="fa-solid fa-user-check"></i></button>';
            }
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

        case "agregarElemento":
            $descripcion = $_POST["descripcion"];
            $accion->agregarElemento($descripcion);
            break;
        case "cargarElemento":
            $idElemento = $_POST["idElemento"];
            $datos = $accion->cargarElemento($idElemento);
            echo json_encode($datos);
            break;
        case "editarElemento":
            $descripcion = $_POST["descripcion"];
            $idElemento = $_POST["idElemento"];
            $accion->editarElemento($idElemento,$descripcion);
            break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $accion->cambiarEstado($idElemento);
            break;
    default:
        echo "No se ha encontrado esta opción";
}

?>