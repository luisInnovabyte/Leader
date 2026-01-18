<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");


require_once("../models/Asistencia.php");
session_start();
require_once("../models/Log.php");

$asistencia = new Asistencia();

switch ($_GET["op"]) {

    case "listarAsistencia":
        $datos = $asistencia->listarAsistencia();
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "asistencia.php", "Lista las asistencias");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = '<p class="">' . $row["nomPersonal"] . ' '. $row["apePersonal"] .'</p>';
            $sub_array[] = '<p class="">' . transformarFecha($row["inicioAsistencia"],["d","-","m","-","Y"," ","H",":","i",":","s"]) . '</p>';
            $sub_array[] = '<p class="">' . transformarFecha($row["finAsistencia"],["d","-","m","-","Y"," ","H",":","i",":","s"]) . '</p>';            
            $sub_array[] = '<p class="">' . $row["motivoAsistencia"] . '</p>';
            if ($row["estado"] == 'Jornada finalizada') {
                $sub_array[] = '<p class="tx-success tx-bold">Jornada finalizada</p>';
            } elseif ($row["estado"] == 'Trabajando') {
                $sub_array[] = '<p class="tx-danger tx-bold">Trabajando</p>';
            }
            $sub_array[] = '<p class="tx-bold">' . $row["TiempoTotalFuncion"] . '</p>';

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

        ////////////////////////////////
        ///// ASISTENCIA CONTROL ///////
        ///////////////////////////////
    case "inicioAsistencia":
        $usuId = $_SESSION["usu_id"];
        $descripccion = $_POST["descripcion"];

        $asistencia->insertarAsist($usuId, $descripccion);
        break;

    case "finAsistencia":
        $usuId = $_SESSION["usu_id"];

        $asistencia->updateAsist($usuId);
        break;
        //////////////////////////////
        /////////////////////////////
        /////////////////////////////
    case "estado":
        $usuId = $_SESSION["usu_id"];
        $resultado = $asistencia->ultimoRegistro($usuId);
        echo json_encode($resultado);
        break;
}
