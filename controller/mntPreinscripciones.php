

<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/MntPreincriptores_Edu.php");

require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$mntPreincriptores = new MntPreincriptores();

$op = $_GET["op"];

switch ($op) {
    case "mostrarElementos":
        $datos = $mntPreincriptores->mostrarElementos();

        //Archivos Log
        //generarLog('iva.php','Mostrar iva'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        $data = array();

        foreach ($datos as $row) {


            $sub_array = array();
            $sub_array[] = $row["idConocimiento"];
            $sub_array[] = $row["nombreConocimiento"];


            //TODO: diseñar columna de estado del IVA segun este a 0 o a 1

            if ($row["estConocimiento"] == 1) {
                $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Prioridad" onClick="cargarElemento('.$row["idConocimiento"].')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger waves-effect" title="Desactivar Prioridad" onClick="cambiarEstado('.$row["idConocimiento"].')"><i class="fa-solid fa-user-slash"></i></button>';
            } else {
                $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Prioridad" onClick="cargarElemento('.$row["idConocimiento"].')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger waves-effect" title="Desactivar Prioridad" onClick="cambiarEstado('.$row["idConocimiento"].')"><i class="fa-solid fa-user-check"></i></button>';
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
            $tipo = $_POST["tipo"];
            
            $mntPreincriptores->agregarElemento($descripcion,$tipo);
            break;
        case "cargarElemento":
            $idElemento = $_POST["idElemento"];
            $datos = $mntPreincriptores->cargarElemento($idElemento);
            echo json_encode($datos);
        break;
        case "editarElemento":
            $descripcion = $_POST["descripcion"];
            $idElemento = $_POST["idElemento"];
            $tipo = $_POST["tipo"];
            $mntPreincriptores->editarElemento($idElemento,$descripcion,$tipo);
        break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $mntPreincriptores->cambiarEstado($idElemento);
            break;
        case "listarTipos":

            $datos = $mntPreincriptores->mostrarElementosActivos();
            echo json_encode($datos);

            break;
        case "listarAgentesPreinscripciones":

            $datos = $mntPreincriptores->mostrarAgentes();
         
            $data = array();

            foreach ($datos as $row) {


                $sub_array = array();
                $sub_array[] = $row["idAgente"];
                $sub_array[] = $row["nombreAgente"];
                $sub_array[] = $row["identificacionFiscal"];
                $sub_array[] = $row["domicilioFiscal"];
                $sub_array[] = $row["correoAgente"];


                //TODO: diseñar columna de estado del IVA segun este a 0 o a 1

                if ($row["estAgente"] == 1) {
                    $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                    $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Agente" onClick="cargarElementoAgente('.$row["idAgente"].')"><i class="fa-solid fa-edit"></i></button>
                    <button class="btn btn-success waves-effect" title="Desactivar Agente" onClick="cambiarEstadoAgentes('.$row["idAgente"].')"><i class="fa-solid fa-user-slash"></i></button>';
                } else {
                    $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                    $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Agente" onClick="cargarElementoAgente('.$row["idAgente"].')"><i class="fa-solid fa-edit"></i></button>
                    <button class="btn btn-danger waves-effect" title="Desactivar Agente" onClick="cambiarEstadoAgentes('.$row["idAgente"].')"><i class="fa-solid fa-user-check"></i></button>';
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
            case "listarAgentesPreinscripcionesLlegadas":
    
                $datos = $mntPreincriptores->mostrarAgentesLlegadas();
             
                $data = array();
    
                foreach ($datos as $row) {
    
    
                    $sub_array = array();
                    $sub_array[] = $row["idAgente"];
                    $sub_array[] = $row["nombreAgente"];
                    $sub_array[] = $row["identificacionFiscal"];
                    $sub_array[] = $row["domicilioFiscal"];
                    $sub_array[] = $row["correoAgente"];
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
            case "agregarElementoAgente":
                $nombreAgente = $_POST["nombreAgente"];
                $tipo = $_POST["tipo"];
                $descrTipoCurso = ucfirst($_POST["descrTipo"]);
                $codTipo = strtoupper($_POST["codTipo"]);
                $textTipo = $_POST["textTipo"];
                
                $mntPreincriptores->agregarElemento($nombreAgente,$tipo);
            break;
            case "insertarAgentes":
                $nombreAgente = ucfirst($_POST["nombreAgente"]);
                $identificacionFiscal = strtoupper($_POST["identificacionFiscal"]);
                $domicilioFiscalAgente = strtoupper($_POST["domicilioFiscalAgente"]);
                $correoAgente = $_POST["correoAgente"];

                $datos = $mntPreincriptores->agregarElementoAgente($nombreAgente, $identificacionFiscal, $domicilioFiscalAgente, $correoAgente);
                echo 1;
            break;
            case "recogerDepartamentos":
        
                $datos = $mntPreincriptores->recogerDepartamentos();
               
                echo json_encode($datos);
            break;
            case "recogerDepartamentosActivo":
        
                $datos = $mntPreincriptores->recogerDepartamentos();
               
                echo json_encode($datos);
            break;
            case "recogerTipoDocumento":
        
                $datos = $mntPreincriptores->recogerTipoDocumento();
               
                echo json_encode($datos);
            break;
            case "recogerGruposBuscador":
                $query = $_POST["search"];
                $datos = $mntPreincriptores->recogerGruposBuscador($query);
              
                echo json_encode($datos);

            break;
            case "recogerCursoBuscador":
                $query = $_POST["search"];
                $datos = $mntPreincriptores->recogerCursoBuscador($query);
                
                echo json_encode($datos);

            break;
                
            case "obtenerAgentesPorId":
                $idElemento = $_POST["idAgente"];
                $datos = $mntPreincriptores->cargarElementoAgentexId($idElemento);
                echo json_encode($datos);
            break;
            case "cargarAgenteXNombre":
                $agente = $_POST["agente"];
                $datos = $mntPreincriptores->cargarAgenteXNombre($agente);
                echo json_encode($datos);
            break;
            case "obtenerAgentesBuscador":
                $search = $_POST["search"];
                $datos = $mntPreincriptores->obtenerAgentesBuscador($search);
                echo json_encode($datos);
            break;
            case "obtenerBildungsurlaubPorId":
                $idElemento = $_POST["idElemento"];
                $datos = $mntPreincriptores->obtenerBildungsurlaubPorId($idElemento);
                echo json_encode($datos);
            break;
            case "editarBildungsurlaubId":
                   
                $idElemento = $_POST["id-bildun"];
                $nombreBildungsurlaubE = $_POST["nombreBildungsurlaubE"];
               
                $datos = $mntPreincriptores->editarBildungsurlaub($idElemento, $nombreBildungsurlaubE);
                echo json_encode($datos);
            break;
            case "editarAgenteId":
                $idElemento = $_POST["id-agente"];
                $nombreAgenteE = $_POST["nombreAgenteE"];
                $identificacionFiscalAgenteE = $_POST["identificacionFiscalAgenteE"];
                $domicilioFiscalAgenteE = $_POST["domicilioFiscalAgenteE"];
                $correoAgenteE = $_POST["correoAgenteE"];

                $datos = $mntPreincriptores->editarAgente($idElemento,$nombreAgenteE,$identificacionFiscalAgenteE,$domicilioFiscalAgenteE,$correoAgenteE);
                echo json_encode($datos);
            break;
            case "cambiarEstadoAgente":
                $idElemento = $_POST["idElemento"];
                $mntPreincriptores->cambiarEstadoAgente($idElemento);
            break;
            case "listarDepartamentos":
         
                $datos = $mntPreincriptores->mostrarDepartamentos();

                $data = array();
    
                foreach ($datos as $row) {
                    $sub_array = array();
                    $sub_array[] = $row["idDepartamentoEdu"];
                    $sub_array[] = $row["nombreDepartamento"];

                    $sub_array[] = $row["prefijoFactDepa"].' - '.$row["numFacturaDepa"];
                    $sub_array[] = $row["prefijoFacturaProEdu"].' - '.$row["numFacturaProDepa"];
                    $sub_array[] = $row["prefijoAbonoEdu"].' - '.$row["numFacturaNegDepa"];
          

    
                    //TODO: diseñar columna de estado del IVA segun este a 0 o a 1
    
                    if ($row["estDepa"] == 1) {
                        $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                        $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Departamento" onClick="cargarElementoDepartamento('.$row["idDepartamentoEdu"].')"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-success waves-effect" title="Desactivar Departamento" onClick="cambiarEstadoDepartamentos('.$row["idDepartamentoEdu"].')"><i class="fa-solid fa-user-slash"></i></button>';
                    } else {
                        $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                        $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Departamento" onClick="cargarElementoDepartamento('.$row["idDepartamentoEdu"].')"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-danger waves-effect" title="Desactivar Departamento" onClick="cambiarEstadoDepartamentos('.$row["idDepartamentoEdu"].')"><i class="fa-solid fa-user-check"></i></button>';
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
                case "insertarDepartamentos":
                    $nombreDepartamento = ucfirst($_POST["nombreDepartamento"]);
                    $prefijofactura = strtoupper($_POST["prefijofactura"]);
                    $nfactura = strtoupper($_POST["nfactura"]);
                    $prefijofacturapro = strtoupper($_POST["prefijofacturapro"]);
                    $nfacturapro = strtoupper($_POST["nfacturapro"]);
                    $prefijoabono = strtoupper($_POST["prefijoabono"]);
                    $nfacturaNeg = strtoupper($_POST["nfacturaNeg"]);
                    
                    $datos = $mntPreincriptores->agregarElementoDepartamento($nombreDepartamento,$prefijofactura,$nfactura,$prefijofacturapro,$nfacturapro,$prefijoabono,$nfacturaNeg);
                    echo 1;
                break;
                case "insertarConocimientos":
                    $nombreConocimiento = ucfirst($_POST["nombreConocimiento"]);
                   
                    
                    $datos = $mntPreincriptores->agregarElementoConocimiento($nombreConocimiento);
                    echo 1;
                break;
                
                case "obtenerDepartamentoPorId":
                    $idElemento = $_POST["idDepartamento"];
                    $datos = $mntPreincriptores->cargarElementoDepartamentoxId($idElemento);
                    echo json_encode($datos);
                break;
                                
                case "obtenerConocimientoPorId":
                    $idElemento = $_POST["idConocimiento"];
                    $datos = $mntPreincriptores->cargarElementoConocimientoxId($idElemento);
                    echo json_encode($datos);
                break;
                case "cargarElementoIdentidadxId":
                    $idElemento = $_POST["idElemento"];
                    $datos = $mntPreincriptores->cargarElementoIdentidadxId($idElemento);
                    echo json_encode($datos);
                break;
                
                
                case "editarConocimientoId":
                   
                    $idElemento = $_POST["id-conocimiento"];
                    $nombreConocimientoE = $_POST["nombreConocimientoE"];
                   
                    $datos = $mntPreincriptores->editarConocimientos($idElemento, $nombreConocimientoE);
                    echo json_encode($datos);
                break;
                   
                case "editarIdentidad":
                   
                    $idElemento = $_POST["id-identidadE"];
                    $nombreIdentidadE = $_POST["nombreIdentidadE"];
                   
                    $datos = $mntPreincriptores->editarIdentidad($idElemento, $nombreIdentidadE );
                    echo json_encode($datos);
                break;
                
                case "cambiarEstadoBildungsurlaub":
                    $idElemento = $_POST["idElemento"];
                    $mntPreincriptores->cambiarEstadoBildungsurlaub($idElemento);
                break;
                case "cambiarEstadoIdentificativo":
                    $idElemento = $_POST["idElemento"];
                    $mntPreincriptores->cambiarEstadoIdentificativo($idElemento);
                break;
                
                case "cambiarEstadoConocimiento":
                    $idElemento = $_POST["idElemento"];
                    $mntPreincriptores->cambiarEstadoConocimiento($idElemento);
                break;
                case "editarDepartamentoId":
                    $idElemento = $_POST["id-departamento"];
                    $nombreDepartamentoE = $_POST["nombreDepartamentoE"];
                    $prefijofacturaE = $_POST["prefijofacturaE"];
                    $nfacturaE = $_POST["nfacturaE"];
                    $prefijofacturaproE = $_POST["prefijofacturaproE"];
                    $nfacturaproE = $_POST["nfacturaproE"];
                    $prefijoabonoE = $_POST["prefijoabonoE"];
                    $nfacturaNegE = $_POST["nfacturaNegE"];

                    $datos = $mntPreincriptores->editarDepartamento($idElemento, $nombreDepartamentoE, $prefijofacturaE, $nfacturaE, $prefijofacturaproE,$nfacturaproE, $prefijoabonoE, $nfacturaNegE);
                    echo json_encode($datos);
                break;
                case "cambiarEstadoDepartamentos":
                    $idElemento = $_POST["idElemento"];
                    $mntPreincriptores->cambiarEstadoDepartamentos($idElemento);
                break;
                
                case "listarConocimientos":
         
         
                    $datos = $mntPreincriptores->mostrarConocimientos();
               
                    $data = array();
        
                    foreach ($datos as $row) {
    
                        $sub_array = array();
                        $sub_array[] = $row["idConocimiento"];
                        $sub_array[] = $row["nombreConocimiento"];
                
    
        
                        //TODO: diseñar columna de estado del IVA segun este a 0 o a 1
        
                        if ($row["estConocimiento"] == 1) {
                            $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                            $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Conocimiento" onClick="cargarElementoConocimientos('.$row["idConocimiento"].')"><i class="fa-solid fa-edit"></i></button>
                            <button class="btn btn-success waves-effect" title="Desactivar Conocimiento" onClick="cambiarEstadoConocimientos('.$row["idConocimiento"].')"><i class="fa-solid fa-user-slash"></i></button>';
                        } else {
                            $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                            $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Conocimiento" onClick="cargarElementoConocimientos('.$row["idConocimiento"].')"><i class="fa-solid fa-edit"></i></button>
                            <button class="btn btn-danger waves-effect" title="Desactivar Conocimiento" onClick="cambiarEstadoConocimientos('.$row["idConocimiento"].')"><i class="fa-solid fa-user-check"></i></button>';
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
                    
                    case "recogerBildungsurlaub":
                        $datos = $mntPreincriptores->recogerBildungsurlaub();
                        echo json_encode($datos);


                    break;
                    case "insertarBildungsurlaub":
                        $nombreBildungsurlaub = ucfirst($_POST["nombreBildungsurlaub"]);

                        $datos = $mntPreincriptores->agregarElementoBildungsurlaub($nombreBildungsurlaub);
                        echo 1;
                    break;
                    case "insertarIdentidad":
                        $nombreIdentidad = ucfirst($_POST["nombreIdentidad"]);

                        $datos = $mntPreincriptores->agregarElementoIdentidad($nombreIdentidad);
                        echo 1;
                    break;
                    
                    case "listarBildungsurlaub":
         
         
                        $datos = $mntPreincriptores->listarBildungsurlaub();
                   
                        $data = array();
            
                        foreach ($datos as $row) {
        
                            $sub_array = array();
                            $sub_array[] = $row["idBildun"];

                            $sub_array[] = $row["nombreBildun"];
                    
                    
            
                            //TODO: diseñar columna de estado del IVA segun este a 0 o a 1
            
                            if ($row["estBildun"] == 1) {
                                $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Bildungsurlaub" onClick="cargarElementoBildungsurlaub('.$row["idBildun"].')"><i class="fa-solid fa-edit"></i></button>
                                <button class="btn btn-success waves-effect" title="Desactivar Bildungsurlaub" onClick="cambiarEstadoBildungsurlaub('.$row["idBildun"].')"><i class="fa-solid fa-user-slash"></i></button>';
                            } else {
                                $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Bildungsurlaub" onClick="cargarElementoBildungsurlaub('.$row["idBildun"].')"><i class="fa-solid fa-edit"></i></button>
                                <button class="btn btn-danger waves-effect" title="Desactivar Bildungsurlaub" onClick="cambiarEstadoBildungsurlaub('.$row["idBildun"].')"><i class="fa-solid fa-user-check"></i></button>';
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
            case "listarTipoIdentificativo":
         
         
                $datos = $mntPreincriptores->listarTipoIdentificativo();
           
                $data = array();
    
                foreach ($datos as $row) {

                    $sub_array = array();
                    $sub_array[] = $row["idTipoIdentificativo"];

                    $sub_array[] = $row["nombreIdentificativo"];
            
            
    
                    //TODO: diseñar columna de estado del IVA segun este a 0 o a 1
    
                    if ($row["estTipoIdentificativo"] == 1) {
                        $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                        $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Tipo Identificativo" onClick="cargarElementoIdentidad('.$row["idTipoIdentificativo"].')"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-success waves-effect" title="Desactivar Tipo Identificativo" onClick="cambiarEstadoTipoIdentificativo('.$row["idTipoIdentificativo"].')"><i class="fa-solid fa-user-slash"></i></button>';
                    } else {
                        $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                        $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Tipo Identificativo" onClick="cargarElementoIdentidad('.$row["idTipoIdentificativo"].')"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-danger waves-effect" title="Desactivar Tipo Identificativo" onClick="cambiarEstadoTipoIdentificativo('.$row["idTipoIdentificativo"].')"><i class="fa-solid fa-user-check"></i></button>';
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
                case "listarErasmus":
         
         
                    $datos = $mntPreincriptores->listarErasmus();
               
                    $data = array();
        
                    foreach ($datos as $row) {
    
                        $sub_array = array();
                        $sub_array[] = $row["idErasmus"];
    
                        $sub_array[] = $row["nombreErasmus"];
                
                
        
                        //TODO: diseñar columna de estado del IVA segun este a 0 o a 1
        
                        if ($row["estErasmus"] == 1) {
                            $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                            $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Erasmus" onClick="cargarElementoErasmus('.$row["idErasmus"].')"><i class="fa-solid fa-edit"></i></button>
                            <button class="btn btn-success waves-effect" title="Desactivar Erasmus" onClick="cambiarEstadoErasmus('.$row["idErasmus"].')"><i class="fa-solid fa-user-slash"></i></button>';
                        } else {
                            $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                            $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Erasmus" onClick="cargarElementoErasmus('.$row["idErasmus"].')"><i class="fa-solid fa-edit"></i></button>
                            <button class="btn btn-danger waves-effect" title="Desactivar Erasmus" onClick="cambiarEstadoTipoErasmus('.$row["idErasmus"].')"><i class="fa-solid fa-user-check"></i></button>';
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
    default:
        echo "No se ha encontrado esta opción";
}

?>