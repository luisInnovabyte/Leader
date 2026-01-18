<?php

class Usuario extends Conectar
{
    public function listarUsuarios()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_usuario` ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    // Se utiliza para comprobar si se puede dar de alta.
    public function get_usuario_x_usu($correoUsu)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM tm_usuario WHERE trim(correoUsu) = trim('$correoUsu')";
        $json_string = json_encode($sql);
$file = 'CALABAZON.json';
file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_nick_x_usu($nickUsuario)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM tm_usuario WHERE trim(nickUsu) = trim('$nickUsuario')";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    // RECOGER CORREOS NO DISPONIBLES POR EL USUARIO 
    public function get_correo_x_usu($idUsu, $correoUsu)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_usuario` WHERE correoUsu = '$correoUsu' AND idUsu != $idUsu";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();

        if (empty($resultado)) {
            return 1;
        } else {
            return 0;
        }
    }


    /////////////////////////////
    ///// REGISTRAR USUARIO ////
    ///////////////////////////
    //! HE HECHO ESTO el 04/03/2024
    //TODO:CREAR FUNCION ELIMINAR
    public function registrar_usuario($correoUsu, $senaUsu, $rolUsu, $estUsu, $fecAltaUsu, $nombreUsu, $apellidosUsu, $fechaNacimiento, $movil, $recibirNotificacionesUsu, $tokenUsu, $registroUsu, $genero, $nickName, $nif)
    {

        $conectar = parent::conexion();
        parent::set_names();
        try {
            $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
            $sql = "INSERT INTO `tm_usuario`(`nickUsu`,`correoUsu`, `senaUsu`, `rolUsu`, `estUsu`,`generoUsu`, `fecAltaUsu`, `nombreUsu`, `apellidosUsu`, `fechaNacimientoUsu`, `movilUsu`,`identificacionFiscalUsu`,`recibirNotificacionesUsu`,`ipUsu`, `tokenUsu`, `registroUsu`) VALUES 
        ('$nickName','$correoUsu', md5('$senaUsu'),$rolUsu,$estUsu,'$genero','$fecAltaUsu','$nombreUsu','$apellidosUsu','$fechaNacimiento','$movil','$nif','$recibirNotificacionesUsu','$REMOTE_ADDR','$tokenUsu','$registroUsu')";



            $sql = $conectar->prepare($sql);
            $sql->execute();

            return true; // Éxito en la inserción

        } catch (PDOException $e) {
            return "Error en la inserción: " . $e->getMessage();
        }
    }
    public function getUsuarioConductor_x_token($tokenUsu)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_usuario&conductor` WHERE `tokenUsu` = '$tokenUsu'";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function guardardatosUsuarioConductor($tokenUsu,$nombreUsu,$apellidosUsu,$movilUsu,$correoUsu,$ciudadPuebloUsu,$codigoPostalUsu,$fechaNacimientoUsu,$signatureDataReceptor)
    {
        $json_string = json_encode('');
        $file = 'RRRRRRRRRRRRR.json';
        file_put_contents($file, $json_string);
        session_start();
        if( $_SESSION['usu_rol'] == 1){
          
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE `tm_usuario` SET `nombreUsu`='$nombreUsu',`apellidosUsu`='$apellidosUsu',`movilUsu`='$movilUsu',`correoUsu`='$correoUsu',`ciudadPuebloUsu`='$ciudadPuebloUsu',`codigoPostalUsu`='$codigoPostalUsu',`fechaNacimientoUsu`='$fechaNacimientoUsu'  WHERE `tokenUsu` = '$tokenUsu'";
            
          
            
            $sql = $conectar->prepare($sql);
    
            $sql->execute();
            
           
            

        }else{
            $json_string = json_encode('');
            $file = 'NNNNNNNNNNNNN.json';
            file_put_contents($file, $json_string);
    
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE `tm_usuario` SET `nombreUsu`='$nombreUsu',`apellidosUsu`='$apellidosUsu',`movilUsu`='$movilUsu',`correoUsu`='$correoUsu',`ciudadPuebloUsu`='$ciudadPuebloUsu',`codigoPostalUsu`='$codigoPostalUsu',`fechaNacimientoUsu`='$fechaNacimientoUsu'  WHERE `tokenUsu` = '$tokenUsu'";
            
          
            
            $sql = $conectar->prepare($sql);
    
            $sql->execute();
            
            $resultado = $sql->fetchAll();
            
            $sql = "SELECT * FROM `tm_usuario`  WHERE `tokenUsu` = '$tokenUsu'";
            
         
            
            $sql = $conectar->prepare($sql);
    
            $sql->execute();
            
            $resultado2 = $sql->fetchAll();
            $DNI = $resultado2[0]["identificacionFiscalUsu"];
            $sql = "UPDATE `transportistas-Transporte` SET `firmaTransportista_transportistasTransporte`='$signatureDataReceptor' WHERE `idTransportistaLeader`= '$DNI'";
            
          
            
            $sql = $conectar->prepare($sql);
    
            $sql->execute();
            
        }

      

        
    }
    public function actualizarImagen($tokenUsu,$new_file_name)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_usuario` SET `avatarUsu`='$new_file_name'  WHERE `tokenUsu` = '$tokenUsu'";
        
        
        $sql = $conectar->prepare($sql);

        $sql->execute();
        
        return $resultado = $sql->fetchAll();
        

        
    }
    //////////////////////////////////
    //////// RECOGE USUARIO XID //////
    //////////////////////////////////

    public function getUsuario_x_id($id)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_usuario WHERE `idUsu` = $id";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function getUsuario_x_idToken($idToken)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_usuario WHERE `tokenUsu` = '$idToken'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    ////////////////////////////
    ///// EDITAR USUARIO //////
    //////////////////////////
    public function updateInfo($idUsuario, $emailUsuario, $nickUsu, $nomUsuario, $apeUsuario, $teleUser, $movilUser, $razonSocial, $idFiscal, $dirFact, $codPostal, $provUser, $ciudadPueblo, $recibirNoti)
    {


        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `tm_usuario` SET `nickUsu`='$nickUsu',`correoUsu`='$emailUsuario',`nombreUsu`='$nomUsuario',`apellidosUsu`='$apeUsuario',`telefonoUsu`='$teleUser',`movilUsu`='$movilUser',`razonSocialFacturacionUsu`='$razonSocial',`identificacionFiscalUsu`='$idFiscal',`direccionFacturacionUsu`='$dirFact',`codigoPostalUsu`='$codPostal',`provinciaUsu`='$provUser',`ciudadPuebloUsu`='$ciudadPueblo',`recibirNotificacionesUsu` = $recibirNoti WHERE `idUsu` = $idUsuario";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    // ACT PASSWORD

    public function update_password($id, $password)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `tm_usuario` SET `senaUsu`=MD5('$password') WHERE `tokenUsu` = '$id'";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function editar($id, $nombre, $apellido, $tef, $mov, $razSoc, $idFis, $dirFact, $codPost, $provincia, $cidPueblo)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `tm_usuario` SET `nombreUsu`='$nombre',`apellidosUsu`='$apellido',`telefonoUsu`=$tef,`movilUsu`=$mov,`razonSocialFacturacionUsu`='$razSoc',`identificacionFiscalUsu`='$idFis',`direccionFacturacionUsu`='$dirFact',`codigoPostalUsu`=$codPost,`provinciaUsu`='$provincia',`ciudadPuebloUsu`='$cidPueblo',`registroUsu`= 1 WHERE `idUsu` = $id";


        $sql = $conectar->prepare($sql);
        $sql->execute();

        session_start();
        $_SESSION['usu_registro'] = 1;

        return $resultado = $sql->fetchAll();
    }

    public function update_usuarioAdmin($idUsuario,$nickUsuario,$nombreUsuario,$apeUsuario,$fechUsuario,$fijoUsuario,$movilUsuario,$correoUsuario,$passUsuario,$paisUsuario,$provUsuario,$cityUsuario,$cpUsuario,$dirUsuario,$rolSeleccionado,$dniUsuario)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `tm_usuario` SET `nickUsu`='$nickUsuario',`nombreUsu`= '$nombreUsuario',`apellidosUsu`='$apeUsuario',`fechaNacimientoUsu`='$fechUsuario',`telefonoUsu`='$fijoUsuario',`movilUsu`=$movilUsuario, `registroUsu`=0,`correoUsu`= '$correoUsuario',`paisUsu`= '$paisUsuario',`provinciaUsu`= '$provUsuario',`ciudadPuebloUsu`= '$cityUsuario',`codigoPostalUsu`= '$cpUsuario',`direccionFacturacionUsu`= '$dirUsuario',`rolUsu`= '$rolSeleccionado',`identificacionFiscalUsu`= '$dniUsuario',`fecModiUsu` = now() WHERE `idUsu` = $idUsuario";

        try {

            $sql = $conectar->prepare($sql);
            $sql->execute();
            
            if(!empty($passUsuario)){
                $sql = "UPDATE `tm_usuario` SET `senaUsu`=MD5('$passUsuario') WHERE `idUsu` = $idUsuario";

                $sql = $conectar->prepare($sql);
                $sql->execute();
            }

            return true; // Éxito en la edicion
        } catch (PDOException $e) {
            //Archivos Log
            generarLog('Usuario.php', 'Error al editar el usuario con id: ' . $idUsuario); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
            //FIN Log
            // En caso de error, puedes devolver el mensaje de error de MySQL
            return "Error en la edición: " . $e->getMessage();
        }
    }

    /////////////////////////////
    /////// LOGIN USUARIO //////
    ///////////////////////////
    public function login($usu_correo, $usu_pass)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $correo = strtolower($usu_correo);
        $pass = $usu_pass;

        if (empty($correo) or empty($pass)) {
            return 'Campos vacios';
        } else {


            // $sql = "SELECT * FROM tm_usuario WHERE emailUsuario = '$correo' and senaUsuario = '$pass' and estUsu=1";
            $sql = "SELECT * FROM tm_usuario WHERE correoUsu = '$correo' AND senaUsu = MD5('$pass')";
			$json_string = json_encode($sql);
				$file = 'T3.json';
				file_put_contents($file, $json_string);
            $sql = $conectar->prepare($sql);
            $sql->execute();

            $resultado = $sql->fetch();
			
            if (is_array($resultado) and count($resultado) > 0) { // ESTA LOGEADO

                if ($resultado['estUsu'] == 1) {
                    session_start();

                    $_SESSION['usu_id'] = $resultado['idUsu'];
                    $_SESSION['usu_email'] = $resultado['correoUsu'];
                    $_SESSION['usu_rol'] = $resultado['rolUsu'];
                    $_SESSION['usu_est'] = $resultado['estUsu'];
                    $_SESSION['usu_obsUsu'] = $resultado['obsUsu'];
                    $_SESSION['usu_avatar'] = $resultado['avatarUsu'];
                    $_SESSION['usu_genero'] = $resultado['generoUsu'];
                    $_SESSION['usu_fecAlta'] = $resultado['fecAltaUsu'];
                    $_SESSION['usu_fecBaja'] = $resultado['fecBajaUsu'];
                    $_SESSION['usu_nom'] = $resultado['nombreUsu'];
                    $_SESSION['usu_ape'] = $resultado['apellidosUsu'];
                    $_SESSION['usu_fecha'] = $resultado['fechaNacimientoUsu'];
                    $_SESSION['usu_telf'] = $resultado['telefonoUsu'];
                    $_SESSION['usu_movil'] = $resultado['movilUsu'];
                    $_SESSION['usu_razonSocial'] = $resultado['razonSocialFacturacionUsu'];
                    $_SESSION['usu_identificacionFiscal'] = $resultado['identificacionFiscalUsu'];
                    $_SESSION['usu_direccionFacturacion'] = $resultado['direccionFacturacionUsu'];
                    $_SESSION['usu_codigoPostal'] = $resultado['codigoPostalUsu'];
                    $_SESSION['usu_provincia'] = $resultado['provinciaUsu'];
                    $_SESSION['usu_ciudad'] = $resultado['ciudadPuebloUsu'];
                    $_SESSION['usu_pais'] = $resultado['paisUsu'];
                    $_SESSION['usu_personalizacion'] = $resultado['personalizacionUsu'];
                    $_SESSION['usu_idioma'] = $resultado['idiomaUsu'];
                    $_SESSION['usu_news'] = $resultado['recibirNotificacionesUsu'];
                    $_SESSION['usu_registro'] = $resultado['registroInicioSesionUsu']; // ULTIMO REGISTRO
                    $_SESSION['usu_privado'] = $resultado['accesoPrivadoUsu']; // a pagado?
                    $_SESSION['usu_ipUsu'] = $resultado['ipUsu'];
                    $_SESSION['usu_token'] = $resultado['tokenUsu'];
                    $_SESSION['registroUsu'] = $resultado['registroUsu'];
                    $_SESSION['usu_uuidUsu'] = $resultado['uuidUsu']; // UUID API

                    $_SESSION['usu_idTransportistaUsu'] = $resultado['idTransportista_transportistas-Transporte']; // TRANSPORTISTA

                    
                    /*                $this->actualizarUltimaSesion($_SESSION['usu_id']);
 */

                    return '1';
                } else { // ESTADO 0 / DESHABILITADO USER

                    $sql = "SELECT mostrarSancion FROM tm_config";
                    $sql = $conectar->prepare($sql);
                    $sql->execute();

                    $resultadoConfig = $sql->fetch();
                    if ($resultadoConfig['mostrarSancion'] == 1 && !empty($resultado['motivoBajaUsu'])) {
                        return 'Motivo: ' . $resultado['motivoBajaUsu'];
                    } else {
                        return '0';
                    }
                }
	
            } else {

                return '2';
            }
        }
    }

    // MOSTRAR USUARIOS //

    public function mostrarUsuarios()
    {
        $conectar = parent::conexion();
        parent::set_names();
        // Usar tabla directa en lugar de vista problemática
        // Seleccionar solo las columnas necesarias para evitar problemas
        $sql = "SELECT idUsu, nickUsu, correoUsu, senaUsu, rolUsu, estUsu, generoUsu, 
                       fecAltaUsu, fecBajaUsu, nombreUsu, apellidosUsu, fechaNacimientoUsu, 
                       telefonoUsu, movilUsu, registroInicioSesionUsu, tokenUsu,
                       COALESCE(`idTransportista_transportistas-Transporte`, 0) as idTransportista 
                FROM tm_usuario 
                ORDER BY registroInicioSesionUsu DESC";
        $sql = $conectar->prepare($sql);
        try {
            $sql->execute();
            return $resultado = $sql->fetchAll();
        } catch (PDOException $e) {
            // Si hay error, devolver array vacío
            return array();
        }
    }

    // DESACTIVAR USUARIO //
    public function delete_usuario($idUsu, $motivo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario
                SET
                    estUsu=0,
                    fecBajaUsu=CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid'),
                    motivoBajaUsu='$motivo'
                WHERE
                idUsu = $idUsu";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    // ACTIVAR USUARIO //
    public function activar_usuario($idUsuario)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario
                SET
                    estUsu=1,
                    fecBajaUsu=null,
                    motivoBajaUsu=null

                WHERE
                idUsu = $idUsuario";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    /////////////////////////////
    ///// REGISTRAR USUARIO ////
    ///////////////////////////

    public function insertar_usuario($nickUsuario, $nombreUsuario, $apeUsuario, $fechUsuario, $fijoUsuario, $movilUsuario, $correoUsuario, $passUsuario, $paisUsuario, $provUsuario, $cityUsuario, $cpUsuario, $dirUsuario, $rolSeleccionado, $dniUsuario)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "INSERT INTO `tm_usuario` (`nickUsu`,`nombreUsu`,`apellidosUsu`,`fechaNacimientoUsu`,`telefonoUsu`,`movilUsu`,`correoUsu`,`senaUsu`,`paisUsu`,`provinciaUsu`,`ciudadPuebloUsu`,`codigoPostalUsu`,`direccionFacturacionUsu`,`rolUsu`,`estUsu`,`fecAltaUsu`,`identificacionFiscalUsu`) VALUES ('$nickUsuario','$nombreUsuario', '$apeUsuario','$fechUsuario','$fijoUsuario' ,'$movilUsuario','$correoUsuario' ,MD5('$passUsuario'),'$paisUsuario','$provUsuario','$cityUsuario','$cpUsuario','$dirUsuario',$rolSeleccionado,1,now(),'$dniUsuario')";



        try {

            $sql = $conectar->prepare($sql);
            $sql->execute();

            return true; // Éxito en la inserción
        } catch (PDOException $e) {

            // En caso de error, puedes devolver el mensaje de error de MySQL
            return "Error en la inserción: " . $e->getMessage();
        }
    }

    public function get_usuario_x_id($idUsu)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_usuario WHERE idUsu = '$idUsu'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_usuario_x_idToken($idUsu)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_usuario WHERE tokenUsu = '$idUsu'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_token_x_correo($correoUsu)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT `tokenUsu` FROM tm_usuario WHERE `correoUsu` = '$correoUsu'";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_token_x_idUsu($idUsu)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT `tokenUsu` FROM tm_usuario WHERE `idUsu` = '$idUsu'";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }



    // NOTIFICACION USER - devuelve cantidad de usuarios
    public function get_countUser()
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT count(*) as UsuariosTotales FROM `tm_usuario` WHERE rolUsu = 3";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    //NOTIFICACIONES - PEDIDOS
    public function get_pedidoUser($idUsuario)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `pedidos` WHERE idUsu_pedidos = $idUsuario AND fecInicioPedido >= 'CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid')' AND estPedido = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();

        if (!empty($resultado)) {

            $sql = "SELECT 	codigoPuertaLocal FROM `tm_config` WHERE idConfig = 1";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        } else {
            return 0;
        }
    }
    
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_usuario` SET `estUSU` = NOT `estUSU` WHERE `idUsu` = $idElemento ";
   
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }








    /************************************************** */
    /************ LISTA COSTA DE VALENCIA  **************/
    /************************************************** */


    public function actualizarUltimaSesion($idUsuario)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE `tm_usuario` SET `UltimaSesion`= NOW() WHERE `idUsuario` = $idUsuario";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }


 

    public function obtenerClientes()
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM td_cliente";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_usuario($idUsu, $nomUsu, $emailUsu, $estUsu)
    {

        session_start();

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario
                SET
                    nomUsuario='$nomUsu',
                    emailUsuario='$emailUsu',
                    fecModiUsuario=now(),
                    estUsu=$estUsu
                    WHERE
                    idUsuario = '$idUsu'";

        $sql = $conectar->prepare($sql);
       
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function actualizar_Password($idUsu, $password)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "UPDATE tm_usuario SET senaUsu=md5('$password') WHERE idUsuario = '$idUsu'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function mostrarUsuariosCorreos(){
        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT `emailUsuario` FROM tm_usuario";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarUsuariosCorreosPers(){
        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT `emailUsuario` FROM tm_personal";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function recogerIdxCorreo($correo){

        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "SELECT `idUsuario` FROM `tm_usuario` WHERE emailUsuario = '$correo'";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function recogerIdxCorreoPers($correo){

        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "SELECT `idPersonal` FROM `tm_personal` WHERE emailUsuario = '$correo'";

        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function crearToken($idUsu,$token){
        
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "UPDATE tm_usuario SET tokenUsu=$token WHERE idUsuario = '$idUsu'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function crearTokenPers($idUsu,$token){
        
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "UPDATE tm_personal SET tokenPers=$token WHERE idPersonal = '$idUsu'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function recogerToken($idUsu){
        
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "SELECT `tokenUsu` FROM `tm_usuario` WHERE idUsuario = '$idUsu'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerTokePers($idUsu){
        
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "SELECT `tokenPers` FROM `tm_personal` WHERE idPersonal = '$idUsu'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function cambiarPassID($idUsu,$pass){
        
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "UPDATE tm_usuario SET senaUsuario=md5('$pass'),tokenUsu = NULL WHERE idUsuario = '$idUsu'";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarPassIDPers($idUsu,$pass){
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "UPDATE tm_personal SET senaUsuario=md5('$pass'),tokenPers =NULL  WHERE idPersonal = '$idUsu'";


        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function getUserByToken($token){
        
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "SELECT * FROM tm_usuario WHERE tokenUsu = '$token'";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetch();
    }

    public function getUserByTokenPers($token){
        
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "SELECT * FROM tm_personal WHERE tokenPers = '$token'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetch();
    }

    

    ///###########################################///
    //######## CONFIGURACIÓN DE PERFIL ###########//
    ///###########################################///
    public function actualizarCuentaPerfil($idUsuario, $nomUsuario, $emailUsuario, $nomAlumno, $apeAlumno, $fecNacAlumno, $teleAlumno, $nacioAlumno, $ProfeEstuAlumno, $EmpresaAlumno, $UniAlumno, $domValAlumno, $domOrigenAlumno)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "UPDATE `tm_usuario` SET 
        `nomUsuario` = '$nomUsuario',
        `emailUsuario` = '$emailUsuario',
        `nomAlumno` = '$nomAlumno',
        `apeAlumno` = '$apeAlumno',
        `fecNacAlumno` = '$fecNacAlumno',
        `teleAlumno` = '$teleAlumno',
        `nacioAlumno` = '$nacioAlumno',
        `ProfeEstuAlumno` = '$ProfeEstuAlumno',
        `EmpresaAlumno` = '$EmpresaAlumno',
        `UniAlumno` = '$UniAlumno',
        `domValAlumno` = '$domValAlumno',
        `domOrigenAlumno` = '$domOrigenAlumno'

        WHERE `idUsuario` = '$idUsuario'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    ///###################################################///
    //######## CONFIGURACIÓN DE CONOCIMIENTOS ###########//
    ///###################################################///
    public function actualizarConocimientosPerfil($idUsuario, $lenMatAlumno, $lenCon1Alumno, $lenCon2Alumno, $lenCon3Alumno, $lenCon4Alumno, $estEspAlumno, $nivEspAlumno, $tiemEspAlumno, $lugEspAlumno, $porEspAlumno, $mejEspAlumno)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "UPDATE tm_usuario SET lenMatAlumno = '$lenMatAlumno', 
        lenCon1Alumno = '$lenCon1Alumno', lenCon2Alumno = '$lenCon2Alumno', 
        lenCon3Alumno = '$lenCon3Alumno', lenCon4Alumno = '$lenCon4Alumno', 
        estEspAlumno = '$estEspAlumno', nivEspAlumno = '$nivEspAlumno', 
        tiemEspAlumno = '$tiemEspAlumno', lugEspAlumno = '$lugEspAlumno', 
        porEspAlumno = '$porEspAlumno', mejEspAlumno = '$mejEspAlumno' 
        WHERE idUsuario = '$idUsuario'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

     ///###################################################///
    //######## CONFIGURACIÓN DE APRENDIZAJE ###########//
    ///###################################################///
    public function actualizarAprendizajePerfil($idUsuario, $aprEspAlumno, $gustaTraAlumno, $act1Alumno, $act2Alumno, $act3Alumno, $act4Alumno, $act5Alumno, $act6Alumno, $act7Alumno)
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "UPDATE tm_usuario SET 
            aprEspAlumno = '$aprEspAlumno',
            gustaTraAlumno = '$gustaTraAlumno',
            act1Alumno = '$act1Alumno',
            act2Alumno = '$act2Alumno',
            act3Alumno = '$act3Alumno',
            act4Alumno = '$act4Alumno',
            act5Alumno = '$act5Alumno',
            act6Alumno = '$act6Alumno',
            act7Alumno = '$act7Alumno'
            WHERE idUsuario = '$idUsuario'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //###################################################///
    //########## CONFIGURACIÓN DE OBJETIVOS  ############//
    ///###################################################///
    public function actualizarObjetivosPerfil($idUsuario, $gus1EspAlumno, $gus2EspAlumno, $gus3EspAlumno, $gus4EspAlumno, $gus5EspAlumno, $gusTextEspAlumno, $conAlumno, $conRecoAlumno, $conAgenAlumno)
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "UPDATE tm_usuario SET gus1EspAlumno = '$gus1EspAlumno', 
        gus2EspAlumno = '$gus2EspAlumno', gus3EspAlumno = '$gus3EspAlumno', 
        gus4EspAlumno = '$gus4EspAlumno', gus5EspAlumno = '$gus5EspAlumno', 
        gusTextEspAlumno = '$gusTextEspAlumno', conAlumno = '$conAlumno', 
        conRecoAlumno = '$conRecoAlumno', conAgenAlumno = '$conAgenAlumno' 
        WHERE idUsuario = '$idUsuario'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //###################################################///
    //######### CONFIGURACIÓN DE ACTIVIDADES  ############//
    ///###################################################///
    public function actualizarActividadesPerfil($idUsuario, $actSocialesAlumno, $actGastroAlumno, $actCultAlumno, $actDepoAlumno, $partActAlumno, $numActAlumno)
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "UPDATE tm_usuario SET
        actSocialesAlumno = '$actSocialesAlumno',
        actGastroAlumno = '$actGastroAlumno',
        actCultAlumno = '$actCultAlumno',
        actDepoAlumno = '$actDepoAlumno',
        partActAlumno= '$partActAlumno',
        numActAlumno = '$numActAlumno'
        WHERE idUsuario = '$idUsuario'";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    ///###################################################///
    //######## EDITAR AVATAR ##############################//
    ///###################################################///
    public function editarAvatar($avatarUsuario, $idUsuario)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // se hace sobre una vista para sacar el literal de la categoria
        // $sql = "SELECT * FROM vsopcatego WHERE estSop=1";
        $sql = "UPDATE `tm_usuario` SET `avatarUsuario`='$avatarUsuario' WHERE `idUsuario` = '$idUsuario'";;
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listarAlumnos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_usuario " ;
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarBloqueado($idUsu){

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_usuario` SET `perfilBloqueado` = NOT `perfilBloqueado` WHERE idUsuario= $idUsu" ;
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerBloqueado($idUsu){

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT `perfilBloqueado` FROM `tm_usuario` WHERE idUsuario= $idUsu" ;
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


}
