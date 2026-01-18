

<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Tickets.php");

require_once '../public/vendor/autoload.php';

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    session_start();

    $tickets = new Tickets();

    $op = $_GET["op"];

    switch($op){

    // MOSTRAR TICKETS
    case "mostrarTickets":

        $datos = $tickets->mostrarTickets();
            
            //Archivos Log
            generarLog('tickets.php','Mostrar Tickets'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
            //FIN Log


        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = '<span class="label label-rounded label-info tx-13">'. $row["idIncidencia"] .'</label>';
            $sub_array[] = '<label class="tx-bold">'.$row["asuntoTicket"].'</label><br>
            <label class="tx-10">'.obtenerTiempoTranscurrido($row["fechaInicio"]).'</label>';

            if ($row["prioridadTicket"] == 1) { $sub_array[] = '<span class="label label-success text-center tx-bold">BAJA</span>';
            } else if ($row["prioridadTicket"] == 2) { $sub_array[] = '<span class="label label-goldenrod text-center tx-bold">MEDIA</span>';
            } else if ($row["prioridadTicket"] == 3) { $sub_array[] = '<span class="label label-warning text-center  tx-bold">ALTA</span>';
            } else if ($row["prioridadTicket"] == 4) { $sub_array[] = '<span class="label label-danger text-center  tx-bold">URGENTE</span>'; }
    
            if ($row["estadoTicket"] == 1) { $sub_array[] = '<span class="badge text-center tx-bold" style="background-color: #1BA0F2">PENDIENTE</span>';
            } else if ($row["estadoTicket"] == 2) { $sub_array[] = '<span class="badge text-center tx-bold"  style="background-color: #F2A516">EN PROCESO</span>';
            }else if ($row["estadoTicket"] == 3) { $sub_array[] = '<span class="badge text-center tx-bold tx-black" style="background-color: #EBEBE4">RESUELTO</span>';}

            $sub_array[] = FechaHoraLocal($row["fechaInicio"]);
            $sub_array[] = $row["nombreCategoria"];
            $sub_array[] = '
            <a href="ticket?token='.$row["tokenTicket"].'" class="btn btn-icon btn btn-outline-primary" data-toggle="tooltip-primary" data-placement="top" title="Consultar Ticket"><div><i class="fa-solid fa-clipboard-list"></i></div></a>';

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
    //Estadisticas por ID
    case "recogerCantidadEstadosPorId":
        $idCliente = $_POST["idCliente"];
        $datos = $tickets->recogerCantidadEstadosPorId($idCliente);


        echo json_encode($datos);
    break;
    //Estadisticas
    case "recogerCantidadEstados":

        $datos = $tickets->recogerCantidadEstados();


        echo json_encode($datos);
    break;
    // RECOGER TICKETS RESPUESTAS //
    case "recogerRespuestas":
    
        $tokenId = $_GET['tokenCifrado'];
       
        $datos = $tickets->recogerRespuestas($tokenId);


        echo json_encode($datos);
    break;

    // RESPONDER TICKETS RESPUESTAS //
    case "responderTicket":

        $respuestaTicket = $_POST['respuesta'];
        $tokenTicket = $_POST['tokenTicket'];

       
        $datos = $tickets->responderTicket($respuestaTicket,$tokenTicket);

    break;
    // RESPONDER TICKETS RESPUESTAS //
    case "responderTicketCerrar":

        $respuestaTicket = $_POST['respuesta'];
        $tokenTicket = $_POST['tokenTicket'];

       
        $datos = $tickets->responderTicketCerrar($respuestaTicket,$tokenTicket);

    break;

    case "cargarClientes":

    
        $datos = $tickets->cargarClientes();
       
        echo json_encode($datos);


    break;
    
    
    case "cargarClientesxId":

        $idSeleccion = $_POST['seleccion'];
        
        $datos = $tickets->cargarClientesxId($idSeleccion);

        echo json_encode($datos);

    break;


    case "cargarAgentes":

        $idCategoria = $_GET['idCategoria'];
    
        $datos = $tickets->cargarAgentes($idCategoria);

        echo json_encode($datos);


    break;

    case "cargarCategorias":
        
        $datos = $tickets->cargarCategorias();

        echo json_encode($datos);

    break;

    // INSERTAR NUEVO TICKET //
    case "insertarTicket":
        session_start();
       
        $creadoPor = $_SESSION['usu_id'];
        $agenteTicket = $_POST['agenteTicket']; //Agente Ticket
        $asuntoTicket = $_POST['asuntoTicket']; //Asunto
        $asuntoTicket = ucfirst(trim($asuntoTicket)); //Asunto
       
        $descripcionTicket = $_POST['respuestaTicket']; //respuestaTicket
        $categoriaTicket = $_POST['categoriaTicket']; //categoriaTicket
        $prioridadTicket = $_POST['prioridadTicket']; //Prioridad
        $clienteTicket = $_POST['clienteTicket']; //Cliente
        // Configurar la zona horaria de Madrid
        $zonaHorariaMadrid = new DateTimeZone('Europe/Madrid');
       
        // Obtener la fecha y hora actual en Madrid
        $fechaActualMadrid = new DateTime('now', $zonaHorariaMadrid);
        // Formatear la fecha y hora según tus necesidades
        $fechaInicio = $fechaActualMadrid->format("Y-m-d H:i:s");
        
        $tokenTicket = generarToken(30);
        
       
        $datos = $tickets->insertarTicket($creadoPor, $agenteTicket, $asuntoTicket, $descripcionTicket, $categoriaTicket, $prioridadTicket, $clienteTicket, $fechaInicio, $tokenTicket);

        echo $tokenTicket;

    break;


    // ELIMINAR TICKET 

    case "eliminarTicket":

        $tokenTicket = $_POST['tokenTicket'];
        
        $datos = $tickets->eliminarTicket($tokenTicket);


    break;

    // EDITAR TICKET
    case "actualizarTicket":

        $tokenTicket = $_POST['tokenTicket'];
        $prioridad = $_POST['prioridadTicketSelect'];
        $estado = $_POST['estadoTicketSelect'];
        $categoriaTicket = $_POST['categoriaTicket'];
        $selectAgente = $_POST['selectAgente'];

        $datos = $tickets->actualizarTicket($tokenTicket,$prioridad, $estado, $categoriaTicket, $selectAgente );


    break;

    
    //////////////////////7////
    
        
    }
        ?>