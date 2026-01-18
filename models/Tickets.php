<?php

class Tickets extends Conectar
{
    public function recogerCantidadEstadosPorId($idCliente){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL obtenerCantidadPorEstadoPorId($idCliente)";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerCantidadEstados(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL obtenerCantidadTickets";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarClientes()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `clientes&usuarios` WHERE estCliente = 1 ";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarClientesxId($idSeleccion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `clientes&usuarios` WHERE estCliente = 1 AND idCliente = $idSeleccion ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarCategorias()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `categoria-ticket` WHERE estCategoria = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarAgentes($idCategoria)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `soporteticket&tmusuario` WHERE estUsu = 1 AND categoriaTicket= $idCategoria";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
   public function mostrarTickets()
   {
       $conectar = parent::conexion();
       parent::set_names();
/*        $sql = "SELECT * FROM `incidencia-ticket` ORDER BY estadoTicket ASC, prioridadTicket DESC METER FECHA";
 */        

       $sql = "SELECT * FROM `incidencia-ticket` LEFT JOIN `soporteticket&tmusuario` ON `incidencia-ticket`.creadoPor = `soporteticket&tmusuario`.idUsu_tmUsuario ORDER BY fechaInicio DESC, estadoTicket ASC, prioridadTicket DESC ";
      
       $sql = $conectar->prepare($sql);
       $sql->execute();
       return $resultado = $sql->fetchAll();


   }

   
   public function getTicket_x_id($idTicket)  // ESTE TICKET ENLAZA CON LA MISMA TABLA, PARA TRAER DATOS DEL CREADOR Y DEL AGENTE
   {
       $conectar = parent::conexion();
       parent::set_names();
       $sql = "SELECT
       `incidencia-ticket`.*,
       `categoria-ticket`.*,
       viewCreador.idSoporte AS idCreador,
       viewCreador.nombreSoporte AS nombreSoporteCreador,
       viewCreador.nombreUsu AS nombreUsuCreador,
       viewCreador.apellidosUsu AS apellidosUsuCreador,
       viewAgente.idSoporte AS idAgente,
       viewAgente.nombreSoporte AS nombreSoporteAgente,
       viewAgente.nombreUsu AS nombreUsuAgente,
       viewAgente.apellidosUsu AS apellidosUsuAgente
        FROM `incidencia-ticket` 
        LEFT JOIN `soporteticket&tmusuario` AS viewCreador ON `incidencia-ticket`.creadoPor = viewCreador.idSoporte
        LEFT JOIN `soporteticket&tmusuario` AS viewAgente ON `incidencia-ticket`.agente = viewAgente.idSoporte
        LEFT JOIN `categoria-ticket` ON `categoria-ticket`.idCategoriaTicket = `incidencia-ticket`.categoriaTicket
        WHERE tokenTicket = '$idTicket'";
  
       $sql = $conectar->prepare($sql);
       $sql->execute();
       return $resultado = $sql->fetchAll();
   }

   // RESPUESTAS DE TICKETS

   public function recogerRespuestas($idTicket)
   {
    
       $conectar = parent::conexion();
       parent::set_names(); 
       $sql = "SELECT * FROM `respuestas-ticket` LEFT JOIN `incidencia-ticket` ON `respuestas-ticket`.idIncidencia_respuestas = `incidencia-ticket`.idIncidencia 
       LEFT JOIN `soporteticket&tmusuario` ON `respuestas-ticket`.idSoporteRespuesta = `soporteticket&tmusuario`.idSoporte WHERE tokenTicket = '$idTicket' ORDER BY fechaCreacionRespuesta ASC;";
        
       $sql = $conectar->prepare($sql);
       $sql->execute();

       return $resultado = $sql->fetchAll();
   }
   
   // REPONDER TICKET //
   public function responderTicket($respuestaTicket,$tokenTicket)
   {
    
       $conectar = parent::conexion();
       parent::set_names();

       session_start();
       $idUsuario = $_SESSION['usu_id'];


       // RECOGER VARIABLES NECESARIAS //
       $sql = "SELECT * FROM `incidencia-ticket` WHERE tokenTicket = '$tokenTicket'";
       $sql = $conectar->prepare($sql);
       $sql->execute();
   /*  if(	$row['estadoTicket'] == '3'){

    } */
       // Utiliza fetch si esperas solo una fila de resultados
       $row = $sql->fetch(PDO::FETCH_ASSOC);
       $idIncidencia = $row['idIncidencia'];
 
       // RECOGER VARIABLES NECESARIAS //
       $sql = "SELECT * FROM `soporte-ticket` WHERE idUsu_tmUsuario = $idUsuario";
       $sql = $conectar->prepare($sql);
       $sql->execute();
        
        // Utiliza fetch si esperas solo una fila de resultados
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $idSoporte = $row['idSoporte'];
        
        // ACTUALIZAR TICKET//
        $sql = "UPDATE `incidencia-ticket` SET`fechaActualizacion`=CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid'), `estadoTicket`= 2 WHERE tokenTicket = '$tokenTicket'";
        $sql = $conectar->prepare($sql);
        $sql->execute();

      
       $sql = "INSERT INTO `respuestas-ticket` (`idIncidencia_respuestas`, `idSoporteRespuesta`, `fechaCreacionRespuesta`, `respuestaTexto`) 

       VALUES ($idIncidencia, $idSoporte,CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid'),'$respuestaTicket')";

       $sql = $conectar->prepare($sql);
       $sql->execute();

   }
    // REPONDER TICKET & CERRAR//
    public function responderTicketCerrar($respuestaTicket,$tokenTicket)
    {
     
        $conectar = parent::conexion();
        parent::set_names();
 
        session_start();
        $idUsuario = $_SESSION['usu_id'];
 
        // RECOGER VARIABLES NECESARIAS //
        $sql = "SELECT * FROM `incidencia-ticket` WHERE tokenTicket = '$tokenTicket'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
       
        // Utiliza fetch si esperas solo una fila de resultados
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $idIncidencia = $row['idIncidencia'];
        
        // ACTUALIZAR TICKET PARA CERRAR //
        $sql = "UPDATE `incidencia-ticket` SET `estadoTicket`=3,`fechaActualizacion`=CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid'),`fechaFinalizacion`=CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid') WHERE tokenTicket = '$tokenTicket'";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
  
        // RECOGER VARIABLES NECESARIAS //
        $sql = "SELECT * FROM `soporte-ticket` WHERE idUsu_tmUsuario = $idUsuario";
        $sql = $conectar->prepare($sql);
        $sql->execute();
 
        // Utiliza fetch si esperas solo una fila de resultados
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $idSoporte = $row['idSoporte'];
 
        $sql = "INSERT INTO `respuestas-ticket` (`idIncidencia_respuestas`, `idSoporteRespuesta`, `fechaCreacionRespuesta`, `respuestaTexto`) 
        VALUES ($idIncidencia, $idSoporte,CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid'),'$respuestaTicket')";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
 
    }

    // INSERTAR NUEVO TICKET //
    
   public function insertarTicket($creadoPor, $agenteTicket, $asuntoTicket, $descripcionTicket, $categoriaTicket, $prioridadTicket, $clienteTicket, $fechaInicio, $tokenTicket)
   {
   
       $conectar = parent::conexion();
       parent::set_names();
       
       if (empty($agenteTicket)) {
            // La variable es vacía o nula
            $agenteTicket = 0;
        }

       $sql = "INSERT INTO `incidencia-ticket`( `creadoPor`, `agente`, `asuntoTicket`, `descripcionTicket`, `categoriaTicket`, `prioridadTicket`, `clienteTicket`, `estadoTicket`, `fechaInicio`, `fechaActualizacion`, `fechaFinalizacion`, `fechaCreacion`, `tokenTicket`) VALUES 
       ('$creadoPor','$agenteTicket','$asuntoTicket','$descripcionTicket','$categoriaTicket','$prioridadTicket','$clienteTicket','1','$fechaInicio',null,null,null,'$tokenTicket')";
       
       $sql = $conectar->prepare($sql);
       $sql->execute();

        // Obtener la ID insertada
        $lastInsertId = $conectar->lastInsertId();
       
        $sql = "INSERT INTO `respuestas-ticket` (`idIncidencia_respuestas`, `idSoporteRespuesta`, `fechaCreacionRespuesta`, `respuestaTexto`) 
        VALUES ($lastInsertId, $creadoPor,CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid'),'¡Nueva incidencia creada!')";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
 
   }
    
   // ELIMINAR TICKET

   
   public function eliminarTicket($idTicket)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "DELETE FROM `incidencia-ticket` WHERE tokenTicket = '$idTicket'";
        $sql = $conectar->prepare($sql);
        $sql->execute();

    }
    // actualizar TICKET

    
    public function actualizarTicket($tokenTicket,$prioridad, $estado, $categoriaTicket, $selectAgente )
    {
        if (empty($selectAgente)) {
            // La variable es vacía o nula
            $selectAgente = 0;
        }
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `incidencia-ticket` SET `prioridadTicket`='$prioridad' , `estadoTicket`='$estado', `categoriaTicket`='$categoriaTicket' , `agente`='$selectAgente'  WHERE tokenTicket = '$tokenTicket'";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();

    }
}
