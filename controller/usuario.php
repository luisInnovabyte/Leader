<?php
// Determinar la ruta base correcta
$baseDir = dirname(__DIR__);
require_once($baseDir . "/config/conexion.php");
require_once($baseDir . "/config/funciones.php");
require_once($baseDir . "/models/Usuario.php");

require_once $baseDir . '/public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$usuario = new Usuario();

$op = $_GET["op"];

switch ($op) {
    case "listarUsuarios":

        $datos = $usuario->listarUsuarios();
        echo json_encode($datos);
        break;
        //////////////////////////////////////////
        /////// COMPROBAR USUARIO EXISTENTE /////
        ////////////////////////////////////////
    case "comprobarCorreoEditar":

        $idUsu = $_POST['idUsu']; // Poner en minuscula
        $correoUsu = strtolower(trim($_POST['correoUsuarioE'])); // Poner en minuscula
        $datosUsu = $usuario->get_correo_x_usu($idUsu, $correoUsu);

        if ($datosUsu == 1) {
            echo 1;
        }

        break;
    case "comprobarCorreo":
		$json_string = json_encode('');
$file = 'PEPEroni1.json';
file_put_contents($file, $json_string);
        $correoUsu = strtolower(trim($_POST['usu_correo'])); // Poner en minuscula
$json_string = json_encode($correoUsu);
$file = 'PEPE1.json';
file_put_contents($file, $json_string);
        $datosUsu = $usuario->get_usuario_x_usu(strtolower(trim($correoUsu)));
		$json_string = json_encode($datosUsu);
$file = 'PEPE2.json';
file_put_contents($file, $json_string);
        if (is_array($datosUsu) == true and count($datosUsu) > 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
            echo 1;
        };
        break;
    case "editar":
        //Archivos Log
        generarLog('usuario.php', 'Se edita el usuario con id: ' . $_POST["id"]); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log
        $id = $_POST["id"];
        $nombre = $_POST["nombreUsuario"];
        $apellido = $_POST["apellidoUsuario"];
        $tef = $_POST["numTelefono"];
        $mov = $_POST["numMovil"];
        $razSoc = $_POST["razSoc"];
        $idFis = $_POST["idFis"];
        $dirFact = $_POST["dirFact"];
        $codPost = $_POST["codPost"];
        $provincia = $_POST["provincia"];
        $cidPueblo = $_POST["cidPueblo"];

        $usuario->editar($id, $nombre, $apellido, $tef, $mov, $razSoc, $idFis, $dirFact, $codPost, $provincia, $cidPueblo);
        echo '1';
        break;
        ////////////////////////////////////////
        //// RECUPERAR DATOS USUARIO  /////////
        //////////////////////////////////////

    case "recuperarDatosXCorreo":
        //Archivos Log
        generarLog('usuario.php', 'Se recoge los datos del usuario con correo: ' . $_POST['usu_correo']); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log
        $correoUsu = strtolower(trim($_POST['usu_correo'])); // Poner en minuscula
        $datosUsu = $usuario->get_usuario_x_usu(strtolower(trim($correoUsu)));

        echo json_encode($datosUsu);


        break;

        // CAMBIAR CONTRASEÑA
    case "cambiarPassword":
        //Archivos Log
        generarLog('usuario.php', 'Se cambia la contraseña de: ' . $_POST['idUsu']); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log
        $id = $_POST['idUsu'];
        $password = $_POST['password'];
        $datosUsu = $usuario->update_password($id, trim($password));

        echo json_encode($datosUsu);


        break;


        //////////////////////////////////////////
        //////////// REGISTRAR USUARIO //////////
        ////////////////////////////////////////

    case "registrarUsuario":

        $error = "";

        $nombreUsu = strtolower(trim($_POST['nombre'])); // Ponemos todas en minuscula
        $nombreUsu = ucfirst(trim($nombreUsu)); // Primera letra en mayuscula

        $apellidosUsu = strtolower(trim($_POST['apellido'])); // Ponemos todas en minuscula
        $apellidosUsu = ucfirst(trim($apellidosUsu)); // Primera letra en mayuscula

        $correoUsu = strtolower(trim($_POST['usu_correo'])); // Poner en minuscula
        $movil = trim($_POST['movil']);

        $fechaNacimiento = $_POST['fechaNacimiento'];

        $senaUsu = trim($_POST['password']);

        $rolUsu = 3;

        date_default_timezone_set('Europe/Madrid');
        $fecAltaUsu =  date("Y-m-d H:i:s"); //Fecha Actual

        $estUsu = 1; //Estado del usuario

        $recibirNotificacionesUsu = $_POST['newsletter'];

        $registroUsu = 0; // OBLIGAR COMPLETAR 

        $datosUsu = $usuario->get_usuario_x_usu($correoUsu);

        $genero =  $_POST['opcionSexo']; //Genero

        $nickName =  $_POST['nickname']; //NickName

        $nif =  $_POST['resultadoNIF']; //resultadoNIF



        if (is_array($datosUsu) == true and count($datosUsu) > 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
            $error = 'Ya existe un usuario con el mismo correo <br>';
        };

        // Uso de la función para generar un token de 30 caracteres
        $tokenUsu = generarToken(30);

        if ($error == "") {

            $success = $usuario->registrar_usuario($correoUsu, $senaUsu, $rolUsu, $estUsu, $fecAltaUsu, $nombreUsu, $apellidosUsu, $fechaNacimiento, $movil, $recibirNotificacionesUsu, $tokenUsu, $registroUsu, $genero, $nickName, $nif);

            if ($success == true) {
                session_start();

                $datosUsu = $usuario->get_usuario_x_usu($correoUsu);

                $sql = "SELECT actualizarRegistroInicioSesion(" . $_SESSION['usu_id'] . ");";


                $_SESSION['usu_id'] = $datosUsu[0]['idUsu'];
                $_SESSION['usu_email'] = $datosUsu[0]['correoUsu'];
                $_SESSION['usu_rol'] = $datosUsu[0]['rolUsu'];
                $_SESSION['usu_est'] = $datosUsu[0]['estUsu'];
                $_SESSION['usu_obsUsu'] = $datosUsu[0]['obsUsu'];
                $_SESSION['usu_avatar'] = $datosUsu[0]['avatarUsu'];
                $_SESSION['usu_genero'] = $datosUsu[0]['generoUsu'];
                $_SESSION['usu_fecAlta'] = $datosUsu[0]['fecAltaUsu'];
                $_SESSION['usu_fecBaja'] = $datosUsu[0]['fecBajaUsu'];
                $_SESSION['usu_nom'] = $datosUsu[0]['nombreUsu'];
                $_SESSION['usu_ape'] = $datosUsu[0]['apellidosUsu'];
                $_SESSION['usu_fecha'] = $datosUsu[0]['fechaNacimientoUsu'];
                $_SESSION['usu_telf'] = $datosUsu[0]['telefonoUsu'];
                $_SESSION['usu_movil'] = $datosUsu[0]['movilUsu'];
                $_SESSION['usu_razonSocial'] = $datosUsu[0]['razonSocialFacturacionUsu'];
                $_SESSION['usu_identificacionFiscal'] = $datosUsu[0]['identificacionFiscalUsu'];
                $_SESSION['usu_direccionFacturacion'] = $datosUsu[0]['direccionFacturacionUsu'];
                $_SESSION['usu_codigoPostal'] = $datosUsu[0]['codigoPostalUsu'];
                $_SESSION['usu_provincia'] = $datosUsu[0]['provinciaUsu'];
                $_SESSION['usu_ciudad'] = $datosUsu[0]['ciudadPuebloUsu'];
                $_SESSION['usu_pais'] = $datosUsu[0]['paisUsu'];
                $_SESSION['usu_personalizacion'] = $datosUsu[0]['personalizacionUsu'];
                $_SESSION['usu_idioma'] = $datosUsu[0]['idiomaUsu'];
                $_SESSION['usu_news'] = $datosUsu['recibirNotificacionesUsu'];
                $_SESSION['usu_registro'] = $datosUsu[0]['registroInicioSesionUsu']; // ULTIMO REGISTRO
                $_SESSION['usu_privado'] = $datosUsu['accesoPrivadoUsu']; // a pagado?
                $_SESSION['usu_ipUsu'] = $datosUsu[0]['ipUsu'];
                $_SESSION['usu_token'] = $datosUsu[0]['tokenUsu'];
                $_SESSION['usu_registro'] = $datosUsu['registroUsu'];
                $_SESSION['usu_uuidUsu'] = $datosUsu[0]['uuidUsu']; // UUID API


                echo true;
            } else {
                $nombreLog =  $correoUsu;
                $logI = new Log($nombreLog, "error.php", "Problema al crear el usuario." . $datosUsu);
                $logI->grabarLinea();
                unset($logI);

                echo $datosUsu; // Devolver el error
            }
        } else {
            echo $error;
        }
        break;
        //////////////////////////////////////
        /////////////////////////////////////
        ////////////////////////////////////

    case "login":
        $usu_correo = $_POST['usu_correo'];
        $usu_pass = $_POST['usu_pass'];

        $datos = $usuario->login($usu_correo, $usu_pass);
        
        echo $datos;

        break;
        //////////////////////////////////////////
        //////////// new us USUARIO //////////
        ////////////////////////////////////////
    case "correoNewUser":
        $correoUsu = strtolower(trim($_POST['usu_correo']));

        if ($correoUsu != "") {

            $dominio_actual = $_SERVER["SERVER_NAME"];

            // IMAGEN LOGOTIPO CORREO
            $img = 'https://' . $dominio_actual . '/public/img/logo_pequeno.png';

            $nombreSoftware = 'EFEUNO DEV';
            try {

                // Archivo de configuración Mail //
                include 'configMail.php';


                //¿Quien envia el correo?
                $mail->setFrom('software@efeuno.com.es', 'NOMBRE');

                $mail->addAddress($correoUsu, '');     //Add a recipient

                $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo

                $mail->Subject = 'Bienvenid@ ';

                $cuerpo = file_get_contents("../public/mailTemplate/teContactamos.html"); /* Ruta del template en formato HTML */

                $cuerpo = str_replace("NAMESOFTWARE", $nombreSoftware, $cuerpo);

                $cuerpo = str_replace("logotipo", $img, $cuerpo);
                $mail->Body    = $cuerpo;
                $mail->AltBody = "Bienvenid@";

                $mail->send();

                echo '1';
            } catch (Exception $e) {

                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        break;

        // VERIFICAR USUARIO CONTRASEÑA RESTABLECER //

    case "updateInfo":
        $idUsuario = $_POST["idUsuario"];
        $emailUsuario = $_POST["emailUsuario"];
        $nickUsu = $_POST["nickUsu"];
        $nomUsuario = $_POST["nomUsuario"];
        $apeUsuario = $_POST["apeUsuario"];
        $teleUser = $_POST["teleUser"];
        $movilUser = $_POST["movilUser"];
        $razonSocial = $_POST["razonSocial"];
        $idFiscal = $_POST["idFiscal"];
        $dirFact = $_POST["dirFact"];
        $codPostal = $_POST["codPostal"];
        $provUser = $_POST["provUser"];
        $ciudadPueblo = $_POST["ciudadPueblo"];

        $recibirNoti = isset($_POST['recibirNoti']) ? 1 : 0;
        $datosUsu = $usuario->updateInfo($idUsuario, $emailUsuario, $nickUsu, $nomUsuario, $apeUsuario, $teleUser, $movilUser, $razonSocial, $idFiscal, $dirFact, $codPostal, $provUser, $ciudadPueblo, $recibirNoti);

        break;
        //////////////////////////////
        // ENVIAR CORREO REGISTRAR //
        ////////////////////////////
    case "correoValidarReg":

        $correo = $_POST['usu_correo'];
        $numeroAleatorio = $_POST['numeroAleatorio'];

        $dominio_actual = $_SERVER["SERVER_NAME"];

        // IMAGEN LOGOTIPO CORREO
        $img = 'https://' . $dominio_actual . '/public/img/logo_pequeno.png';

        $nombreSoftware = 'EFEUNO DEV';

        try {

            // Archivo de configuración Mail //
            include 'configMail.php';


            //¿Quien envia el correo?
            $mail->setFrom('software@efeuno.com.es', 'Efeuno Dev');

            $mail->addAddress($correo, '');     //Add a recipient

            $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo

            $mail->Subject = 'Validar correo ';

            $cuerpo = file_get_contents("../public/mailTemplate/correoValidarReg.html"); /* Ruta del template en formato HTML */
            /* parametros del template a remplazar */
            $cuerpo = str_replace("00000", $numeroAleatorio, $cuerpo);
            $cuerpo = str_replace("logotipo", $img, $cuerpo);

            $cuerpo = str_replace("NAMESOFTWARE", $nombreSoftware, $cuerpo);


            $mail->Body    = $cuerpo;
            $mail->AltBody = "Validar correo";

            $mail->send();

            echo 1;
        } catch (Exception $e) {


            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        break;

    case "correoValidarCambioPass":

        $correo = $_POST['usu_correo'];
        $numeroAleatorio = $_POST['numeroAleatorio'];

        $dominio_actual = $_SERVER["SERVER_NAME"];

        // IMAGEN LOGOTIPO CORREO
        $img = 'https://' . $dominio_actual . '/public/img/logo_pequeno.png';

        $nombreSoftware = 'EFEUNO DEV';

        try {

            // Archivo de configuración Mail //
            include 'configMail.php';


            //¿Quien envia el correo?
            $mail->setFrom('software@efeuno.com.es', 'Efeuno Dev');

            $mail->addAddress($correo, '');     //Add a recipient

            $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo

            $mail->Subject = 'Validar correo ';

            $cuerpo = file_get_contents("../public/mailTemplate/correoValidarCambioPass.html"); /* Ruta del template en formato HTML */
            /* parametros del template a remplazar */
            $cuerpo = str_replace("00000", $numeroAleatorio, $cuerpo);
            $cuerpo = str_replace("logotipo", $img, $cuerpo);

            $cuerpo = str_replace("NAMESOFTWARE", $nombreSoftware, $cuerpo);


            $mail->Body    = $cuerpo;
            $mail->AltBody = "Validar correo";

            $mail->send();

            echo 1;
        } catch (Exception $e) {


            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        break;

        ///////////////////////////
        /////////////////////////
        ///////////////////////

        // MOSTRAR USUARIOS
    case "mostrarUsuarios":
        
        $datos = $usuario->mostrarUsuarios();
        
        //Archivos Log
        if (isset($_SESSION['usu_id'])) {
            try {
                generarLog('usuario.php', 'Mostrar usuarios');
            } catch (Exception $e) {
                // Ignorar errores de log
            }
        }
        //FIN Log

        $data = array();

        if (!$datos) {
            $datos = array();
        }

        foreach ($datos as $row) {

            if ($row["rolUsu"] != 999) {
                $sub_array = array();
                $sub_array[] = $row["idUsu"];
                $sub_array[] = $row["nombreUsu"] . ' ' . $row["apellidosUsu"];
                $sub_array[] = $row["correoUsu"];
                // Verificar si existe el campo idTransportista antes de usarlo
                $idTransportista = isset($row["idTransportista"]) ? $row["idTransportista"] : (isset($row["idTransportista_transportistas-Transporte"]) ? $row["idTransportista_transportistas-Transporte"] : '-');
                // Si es "0" o vacío, mostrar guión
                if ($idTransportista == '0' || $idTransportista == 0 || empty($idTransportista) || $idTransportista == '-') {
                    $sub_array[] = '-';
                } else {
                    $sub_array[] = "<a href='../MntConductor/index.php?idConductor=" . $idTransportista . "'>" . $idTransportista . "</a>";
                }

                if ($row["rolUsu"] == 0) {

                    $sub_array[] = '<span class="rol badge bg-primary text-center tx-bold tx-14-force">Usuario</span>';
                } else if ($row["rolUsu"] == 1) {

                    $sub_array[] = '<span class="rol badge bg-info text-center tx-bold tx-14-force bg-sparkles-animated">Administrador</span>';
                }


                if ($row["estUsu"] == 1) {
                    $sub_array[] = '<span class="badge bg-success tx-14-force">Activo</span>';
                } else {
                    $sub_array[] = '<span class="badge bg-secondary tx-14-force">Inactivo</span>';
                }

                $sub_array[] = '<a href="../Perfil/index.php?tokenUsuario='.$row["tokenUsu"].'" class="btn btn-primary btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Consultar Datos">
            <div><i class="fa fa-eye"></i></div></button';

                if ($row["rolUsu"] == 999) {
                    $sub_array[] = '
                <button type="button"  data-target="#editar-usuario-modal" data-toggle="modal" class="btn btn-info btn-icon disabled" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa fa-edit"></i></div></button>
                <button type="button"  id="' . $row["idUsu"] . '" class="btn btn-danger btn-icon mt-1 mt-lg-0 disabled" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-user-slash"></i></div></button>';
                } else if ($row["estUsu"] == 1) {
                    if ($row["rolUsu"] == 1 && isset($_SESSION['usu_rol']) && $_SESSION['usu_rol'] != "999") {
                        $sub_array[] = '
<button type="button"  data-target="#editar-usuario-modal" data-toggle="modal" onClick="cargarUsuario(' . $row["idUsu"] . ');"  id="' . $row["idUsu"] . '" class="btn btn-info btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Modificar usuario"><div><i class="fa fa-edit"></i></div></button>
<button type="button" onClick=""  id="' . $row["idUsu"] . '" class="btn btn-danger btn-icon mt-1 mt-lg-0 disabled" data-toggle="tooltip-primary" data-placement="top" title="Los administradores no pueden ser desactivados."><div><i class="fa-solid fa-user-slash"></i></div></button>';
                    } else {
                        $sub_array[] = '
                <button type="button" data-target="#editar-usuario-modal" data-toggle="modal" onClick="cargarUsuario(' . $row["idUsu"] . ');"  id="' . $row["idUsu"] . '" class="btn btn-info btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Modificar usuario"><div><i class="fa fa-edit"></i></div></button>
                <button type="button" onClick="cambiarEstado(' . $row["idUsu"] . ');"  id="' . $row["idUsu"] . '" class="btn btn-danger btn-icon mt-1 mt-lg-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar usuario"><div><i class="fa-solid fa-user-slash"></i></div></button>';
                    }
                } else {
                    $sub_array[] = ' 
                <button type="button"  data-target="#editar-usuario-modal" data-toggle="modal" onClick="cargarUsuario(' . $row["idUsu"] . ');"  id="' . $row["idUsu"] . '" class="btn btn-info btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Modificar usuario"><div><i class="fa fa-edit"></i></div></button>
                <button type="button" onClick="cambiarEstado(' . $row["idUsu"] . ');"  id="' . $row["idUsu"] . '" class="btn btn-success btn-icon mt-1 mt-lg-0" data-toggle="tooltip-primary" data-placement="top" title="Activar usuario"><div><i class="fa-solid fa-user-check "></i></div></button>';
                }

                // Verificar que existe y no es null antes de procesar
                if (isset($row["registroInicioSesionUsu"]) && !empty($row["registroInicioSesionUsu"])) {
                    try {
                        // Si la fecha no tiene hora, agregar hora por defecto
                        $fechaRegistro = $row["registroInicioSesionUsu"];
                        if (strlen($fechaRegistro) <= 10) {
                            $fechaRegistro .= ' 00:00:00';
                        }
                        $registroSesion = obtenerTiempoTranscurrido($fechaRegistro);
                    } catch (Exception $e) {
                        $registroSesion = 'Nunca';
                    }
                } else {
                    $registroSesion = 'Nunca';
                }
                $sub_array[] = $registroSesion;
                $data[] = $sub_array;
            }
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        
        echo json_encode($results);
        break;

    case "getTokenByCorreo":

        $datosUsuario = $usuario->get_token_x_correo($_POST["correoUsu"]);


        //Archivos Log
        echo json_encode($datosUsuario);

        break;
    case "desactivarUsuario":

        $usuario->delete_usuario($_POST["idUsu"], $_POST["motivo"]);
        //Archivos Log
        generarLog('usuario.php', 'Se desactiva el usuario con id: ' . $_POST["idUsu"]); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        break;
    case "activarUsuario":
        $usuario->activar_usuario($_POST["idUsu"]);

        //Archivos Log
        generarLog('usuario.php', 'Se activa el usuario con id: ' . $_POST["idUsu"]); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log
        break;

    case "obtenerUsuarioToken":
        //Archivos Log
        generarLog('usuario.php', 'Se recoge usuario con token: ' . $_POST['idToken']); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        $idToken = $_POST['idToken'];
        $datosUsuario = $usuario->getUsuario_x_idToken($idToken);

        echo json_encode($datosUsuario);
        break;


    case "obtenerUsuarioPorId":
        //Archivos Log
        generarLog('usuario.php', 'Se recoge usuario con id: ' . $_POST['idUsuario']); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        $idUsuario = $_POST['idUsuario'];
        $datosUsuario = $usuario->get_usuario_x_id($idUsuario);

        echo json_encode($datosUsuario);
        break;

    case "obtenerTokenPorId":
        //Archivos Log
        generarLog('usuario.php', 'Se recoge usuario con id: ' . $_POST['idUsu']); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log

        $idUsu = $_POST['idUsu'];
        $datosUsuario = $usuario->get_token_x_idUsu($idUsu);

        echo json_encode($datosUsuario);




        break;

    case "insertarUsuario":


        //Archivos Log
        generarLog('usuario.php', 'Se crea un nuevo usuario'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');

        //FIN Log


        $error = "";
        $nickUsuario = strtolower(trim($_POST["nickUsuario"]));
        $nombreUsuario = ucwords(strtolower(trim($_POST["nombreUsuario"])));
        $apeUsuario = ucwords(strtolower(trim($_POST["apeUsuario"])));
        $fechUsuario = $_POST["fechUsuario"];
        $fijoUsuario = trim($_POST["fijoUsuario"]);
        $movilUsuario = trim($_POST["movilUsuario"]);
        $correoUsuario = strtolower(trim($_POST["correoUsuario"]));
        $passUsuario = $_POST["passUsuario"];
        $paisUsuario = $_POST["paisUsuario"];
        $provUsuario = $_POST["provUsuario"];
        $cityUsuario = $_POST["cityUsuario"];
        $cpUsuario = $_POST["cpUsuario"];
        $dirUsuario = $_POST["dirUsuario"];
        $rolSeleccionado = $_POST["rolSeleccionado"];
        $dniUsuario = $_POST["dniUsuario"];

        $datosUsu = $usuario->get_usuario_x_usu($correoUsuario);
        $datosUsuNick = $usuario->get_usuario_x_usu($nickUsuario);

        if (is_array($datosUsu) == true and count($datosUsu) > 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
            $error = 'Ya existe un usuario con el mismo correo';
        };
        if (is_array($datosUsuNick) == true and count($datosUsuNick) > 0) {
            $error = 'Ya existe un usuario con el mismo nick';
        };



        // Uso de la función para generar un token de 30 caracteres
        $tokenUsu = generarToken(30);


        $generoUsu = $_POST['generoUsuario'];

        if ($error == "") {

            $success = $usuario->insertar_usuario($nickUsuario, $nombreUsuario, $apeUsuario, $fechUsuario, $fijoUsuario, $movilUsuario, $correoUsuario, $passUsuario, $paisUsuario, $provUsuario, $cityUsuario, $cpUsuario, $dirUsuario, $rolSeleccionado, $dniUsuario);


            if ($success == true) {


                echo true;
            } else {

                $nombreLog =  $correoUsu;


                echo $datosUsu; // Devolver el error
            }
        } else {


            echo $error;
        }

        break;
        // EDITAR USUARIO APARTADO ADMIN
    case "comprobarNick":
        $nickUsuario = $_POST["nickname"];

        $datosUsuNick = $usuario->get_usuario_x_usu($nickUsuario);

        if (is_array($datosUsuNick) == true and count($datosUsuNick) > 0) {
            echo "1";
        }

        break;
    case "updateUsuario":
        //Archivos Log
        generarLog('usuario.php', 'Se edita el usuario con id: ' . $_POST['idUsuario']); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
        //FIN Log
        $error = "";

        $nickUsuario = strtolower(trim($_POST["nickUsuario"]));
        $nombreUsuario = ucwords(strtolower(trim($_POST["nombreUsuario"])));
        $apeUsuario = ucwords(strtolower(trim($_POST["apeUsuario"])));
        $fechUsuario = $_POST["fechUsuario"];
        $fijoUsuario = trim($_POST["fijoUsuario"]);
        $movilUsuario = trim($_POST["movilUsuario"]);
        $correoUsuario = strtolower(trim($_POST["correoUsuario"]));
        $passUsuario = $_POST["passUsuario"];
        $paisUsuario = $_POST["paisUsuario"];
        $provUsuario = $_POST["provUsuario"];
        $cityUsuario = $_POST["cityUsuario"];
        $cpUsuario = $_POST["cpUsuario"];
        $dirUsuario = $_POST["dirUsuario"];
        $rolSeleccionado = $_POST["rolSeleccionado"];
        $dniUsuario = $_POST["dniUsuario"];
        $idElemento = $_POST["idElemento"];

        date_default_timezone_set('Europe/Madrid');
        $fecModiUsu =  date("Y-m-d H:i:s"); //Fecha Actual



        /* $datosUsu = $usuario->get_usuario_x_usu($correoUsu);
           
            if (is_array($datosUsu) == true and count($datosUsu) > 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
                $error = 'Ya existe un usuario con el mismo correo <br>';
            }; 
            */


        if ($error == "") {

            $success = $usuario->update_usuarioAdmin($idElemento, $nickUsuario, $nombreUsuario, $apeUsuario, $fechUsuario, $fijoUsuario, $movilUsuario, $correoUsuario, $passUsuario, $paisUsuario, $provUsuario, $cityUsuario, $cpUsuario, $dirUsuario, $rolSeleccionado, $dniUsuario);

            if ($success == true) {


                echo true;
            } else {

                $nombreLog =  $correoUsu;


                echo $datosUsu; // Devolver el error
            }
        } else {
            echo $error;
        }

        break;

        // NOTIFICACIONES USUARIO - DEVUELVE LA CANTIDAD DE USUARIOS PARA COMPARAR CON LOCALSTORAGE
    case 'recuperarCantidadUsuarios':
        session_start();
        if ($_SESSION['usu_rol'] == 1) {
            $resultado = $usuario->get_countUser();

            echo json_encode($resultado);
        } else {
            echo 0;
        }
        break;
    case 'cambiarContrasena':
        session_start();
        $idUsu = $_SESSION["usu_id"];
        $usuario->update_password($idUsu, $_POST["pass"]);
        break;


        // NOTIFICACIONES - DEVUELVE NUMERO LOCAL
    case 'recuperarPedidoActivo':
        session_start();
        $idUsuario = $_SESSION['usu_rol'];
        $resultado = $usuario->get_pedidoUser($idUsuario);
        echo json_encode($resultado);
        break;
    case 'superadmin':
        session_start();

        $status = $_POST['status'];

        if ($status == 'true') {

            $_SESSION['usu_id'] =  '0';
            $_SESSION['usu_email'] =  'superadmin@efeuno.es';
            $_SESSION['usu_rol'] =  '1';
            $_SESSION['usu_est'] =  '1';
            $_SESSION['usu_obsUsu'] =  'SuperAdmin';
            $_SESSION['usu_avatar'] =  'superadminCrip.png';
            $_SESSION['usu_genero'] =  '';
            $_SESSION['usu_fecAlta'] =  '';
            $_SESSION['usu_fecBaja'] =  '';
            $_SESSION['usu_nom'] =  'Super';
            $_SESSION['usu_ape'] = 'Admin';
            $_SESSION['usu_fecha'] =  '20220202';
            $_SESSION['usu_telf'] =  '911611611';
            $_SESSION['usu_movil'] =  '611611611';
            $_SESSION['usu_razonSocial'] = 'Razon Social';
            $_SESSION['usu_identificacionFiscal'] =  '03232323156D';
            $_SESSION['usu_direccionFacturacion'] =  '';
            $_SESSION['usu_codigoPostal'] =  '46970';
            $_SESSION['usu_provincia'] =  'Valencia';
            $_SESSION['usu_ciudad'] = 'Valencia';
            $_SESSION['usu_pais'] =  'España';
            $_SESSION['usu_personalizacion'] =  'Ninguna';
            $_SESSION['usu_idioma'] =  'Español';
            $_SESSION['usu_news'] =  '1';
            $_SESSION['usu_registro'] =  '1';
            $_SESSION['usu_privado'] =  '1';
            $_SESSION['usu_ipUsu'] =  '199.199.199';
            $_SESSION['usu_token'] =  '654564654564654564656';
            $_SESSION['usu_registro'] =  '1';
            $_SESSION['usu_uuidUsu'] =  '46454646454556';
            $_SESSION['superadmin'] = 'start';
        } else if ($status == 'false') {

            session_start(); // Iniciar la sesión

            // Destruir todas las variables de sesión
            session_unset();
            // Destruir la sesión
            session_destroy();

            // Redireccionar al usuario a la página de inicio de sesión
            exit(); // Asegurarse de que el scri

        }


        break;

    case "cambiarEstado":
        $idElemento = $_POST["idElemento"];
        $usuario->cambiarEstado($idElemento);
        break;

    case "datosUsuarioConductor":
        $tokenUsu = $_POST["tokenUsu"];

        $resultado = $usuario->getUsuarioConductor_x_token($tokenUsu);

        echo json_encode($resultado);

        break;
    case "guardardatosUsuarioConductor":
        $tokenUsu = $_POST["tokenUsu"];
        $nombreUsu = $_POST["nombreUsu"];
        $apellidosUsu = $_POST["apellidosUsu"];
        $movilUsu = $_POST["movilUsu"];
        $correoUsu = $_POST["correoUsu"];
        $ciudadPuebloUsu = $_POST["ciudadPuebloUsu"];
        $codigoPostalUsu = $_POST["codigoPostalUsu"];
        $fechaNacimientoUsu = $_POST["fechaNacimientoUsu"];
        $signatureDataReceptor = $_POST["signatureDataReceptor"];

        $usuario->guardardatosUsuarioConductor($tokenUsu, $nombreUsu, $apellidosUsu, $movilUsu, $correoUsu, $ciudadPuebloUsu, $codigoPostalUsu, $fechaNacimientoUsu, $signatureDataReceptor);

        echo json_encode('1');

        break;
    case "actualizarImagen":
        $tokenUsu = $_POST['tokenUsu'];
        if ($_FILES['file']['name']) {
            $upload_dir = '../public/assets/images/users/'; // Directorio donde se subirá la imagen
            $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $new_file_name = date('d_m_Y__H_i_s') . '.' . $file_extension;

            // Definimos la ruta completa del archivo con el nuevo nombre
            $target_file = $upload_dir . $new_file_name;

            // Verificar si el archivo es una imagen
            $check = getimagesize($_FILES['file']['tmp_name']);
            if ($check !== false) {
                // Mover el archivo subido a la carpeta de destino con el nuevo nombre
                if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                    
                    /*JSON - TODO:BORRAR*/
                    $json_string = json_encode("La imagen se ha subido correctamente con el nombre: " . $target_file);
                    $file = 'imagenes.json';
                    file_put_contents($file, $json_string);
                    //***FIN JSON***
                } else {
                    /*JSON - TODO:BORRAR*/
                    $json_string = json_encode( "Hubo un error al subir la imagen." . $target_file);
                    $file = 'imagenes.json';
                    file_put_contents($file, $json_string);
                    //***FIN JSON***
                }
            } else {
                /*JSON - TODO:BORRAR*/
                $json_string = json_encode( "El archivo no es una imagen válida." .$target_file);
                $file = 'imagenes.json';
                file_put_contents($file, $json_string);
                //***FIN JSON***
            }
        }

        $resultado = $usuario->actualizarImagen($tokenUsu, $new_file_name);


        break;

        /********************************************************************************************/
        /********** APARTADO COSTA VALENCIA DEL ANTERIOR TEMPLATE ***********************************/
        /********************************************************************************************/

        
    case "activar":
        $usuario->activar_usuario($_POST["idUsuario"]);

        // Archivo LOG
        $idUsu = $_POST["idUsuario"];
        session_start();
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "usuario.php", "ACTIVA USUARIO ID:$idUsu");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "insertar":
        $emailUsu = strtolower(trim($_POST['emailUsuario']));
        $senaUsu = trim($_POST['senaUsuario']); // NO HASH
        $nomUsu = trim($_POST['nomUsuario']);

        $estUsu = isset($_POST['estUsu']) ? $_POST['estUsu'] : 0;


        $error = "";


        //validar emailUsu
        if (empty($emailUsu) || strlen(trim($emailUsu)) <= 1) {
            $error = 'Introduce un correo valido para el usuario <br>';
        } else {
            $emailUsu = filter_var($emailUsu, FILTER_SANITIZE_STRING);

            // vamos a comprobar si ya existe un usuario con el mismo emailUsu
            // $datosUsu = $usuario->get_usuario_x_usu($_POST["emailUsu"]);

            //if (is_array($datosUsu) == true and count($datosUsu) > 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
            //    $error = 'Ya existe un usuario con el mismo identificativo <br>';
            //};
        } // del empty($emailUsu)

        //validar contraseña
        if (empty($_POST["idUsuario"])) {
            if (empty($senaUsu) || strlen(trim($senaUsu)) <= 1) {
                $error = 'Introduce una contraseña valida <br>';
            } else {
                $senaUsu = filter_var($senaUsu, FILTER_SANITIZE_STRING);
            }
        }

        //validar nombre
        if (empty($nomUsu) || strlen(trim($nomUsu)) <= 1) {
            $error .= 'Introduce un nombre valido <br>';
        } else {
            $nomUsu = filter_var($nomUsu, FILTER_SANITIZE_STRING);
        }



        $datosUsu = $usuario->get_usuario_x_usu($_POST["emailUsuario"],0);
        if (is_array($datosUsu) == true and count($datosUsu) > 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
            $error = 'Ya existe un usuario con el mismo correo <br>';
        };

        if ($error == "") {

            // Usar insertar_usuario con los 15 parámetros requeridos
            // Los campos no proporcionados se establecen como vacíos o valores por defecto
            $nickUsuario = ''; // No proporcionado en este formulario
            $fechUsuario = ''; // No proporcionado
            $fijoUsuario = ''; // No proporcionado
            $movilUsuario = ''; // No proporcionado
            $paisUsuario = ''; // No proporcionado
            $provUsuario = ''; // No proporcionado
            $cityUsuario = ''; // No proporcionado
            $cpUsuario = ''; // No proporcionado
            $dirUsuario = ''; // No proporcionado
            $rolSeleccionado = 0; // Rol por defecto usuario normal
            $dniUsuario = ''; // No proporcionado

            $datosUsu = $usuario->insertar_usuario($nickUsuario, $nomUsu, '', $fechUsuario, $fijoUsuario, $movilUsuario, $emailUsu, $senaUsu, $paisUsuario, $provUsuario, $cityUsuario, $cpUsuario, $dirUsuario, $rolSeleccionado, $dniUsuario);


            session_start();
            require_once("../models/Log.php");

            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "usuario.php", "Se inserta un nuevo usuario");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG

            echo '1';
        } else {
            echo $error;
        }

        break;

    case "recogerClientesBD":

        $datosCliente = $usuario->obtenerClientes();

        echo json_encode($datosCliente);


        break;

    case "obtenerClientePorId":

        $idUsuario = $_POST['idUsuario'];
        $datosUsuario = $usuario->get_usuario_x_id($idUsuario);

        echo json_encode($datosUsuario);
        break;

    case "editar":

        $idUsuario = $_POST['idUsuario'];

        $emailUsu = strtolower(trim($_POST['emailUsuario']));
        $nomUsu = trim($_POST['nomUsuario']);
        $estUsu = $_POST['estUsu'];

        $error = "";

     
        if (isset($_POST['estUsu']) && $_POST['estUsu'] = 'on') {
            $estUsu = 1;
        } else {
            $estUsu = 0;
        }

     

        //validar emailUsu
        if (empty($emailUsu) || strlen(trim($emailUsu)) <= 1) {
            $error = 'Introduce un correo valido para el usuario <br>';
        } else {
            $emailUsu = filter_var($emailUsu, FILTER_SANITIZE_STRING);

            // vamos a comprobar si ya existe un usuario con el mismo emailUsu
            // $datosUsu = $usuario->get_usuario_x_usu($_POST["emailUsu"]);

            //if (is_array($datosUsu) == true and count($datosUsu) > 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
            //    $error = 'Ya existe un usuario con el mismo identificativo <br>';
            //};
        } // del empty($emailUsu)

        //validar contraseña
        if (empty($_POST["idUsuario"])) {
            if (empty($senaUsu) || strlen(trim($senaUsu)) <= 1) {
                $error = 'Introduce una contraseña valida <br>';
            } else {
                $senaUsu = filter_var($senaUsu, FILTER_SANITIZE_STRING);
            }
        }

        //validar nombre
        if (empty($nomUsu) || strlen(trim($nomUsu)) <= 1) {
            $error .= 'Introduce un nombre valido <br>';
        } else {
            $nomUsu = filter_var($nomUsu, FILTER_SANITIZE_STRING);
        }



        $datosUsu = $usuario->get_usuario_x_usu($_POST["emailUsuario"],$idUsuario);
        if (is_array($datosUsu) == false and count($datosUsu) < 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
            $error = 'Este usuario no existe.<br>';
        };

        if ($error == "") {


            $datosUsu = $usuario->update_usuario($idUsuario, $nomUsu, $emailUsu, $estUsu);

            session_start();
            require_once("../models/Log.php");

            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "usuario.php", "Se edita  el usuario " . $idUsuario);
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG

            echo '1';
        } else {
            echo $error;
        }

        break;


    case "actualizarPassword":
        $idUsu = $_POST['idUsuario'];
        $password = trim($_POST['password']);
        $usuario->actualizar_Password($idUsu, $password);

        break;

    case "listarUsuariosSelect":

        $datosUsuarios = $usuario->mostrarUsuarios();
        echo json_encode($datosUsuarios);

        break;


    case "guardarAviso":
        $datos;
        break;

    case "recogerUsuariosBD":

        // Archivo LOG
        session_start();

        require_once("../models/Log.php");
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "usuario.php", "Recoger usuarios BD");
        $logI->grabarLinea();
        unset($logI);
        //Fin Log
        $coincide = 0;
        $datosCliente = $usuario->mostrarUsuariosCorreos();



        foreach ($datosCliente as $row) {
            if ($row["emailUsuario"] == $_GET["correo"]) {
                echo "1";
                $coincide = 1;
            }
        }
        if ($coincide == 0) {
            echo "0";
        }

        break;
        case "recogerUsuariosPersBD":

            // Archivo LOG
            session_start();
    
            require_once("../models/Log.php");
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "usuario.php", "Recoger usuarios BD");
            $logI->grabarLinea();
            unset($logI);
            //Fin Log
            $coincide = 0;
            $datosCliente = $usuario->mostrarUsuariosCorreosPers();
    
    
    
            foreach ($datosCliente as $row) {
                if ($row["emailUsuario"] == $_GET["correo"]) {
                    echo "1";
                    $coincide = 1;
                }
            }
            if ($coincide == 0) {
                echo "0";
            }
    
            break;
    case "enviarCorreo":
        // Archivo LOG
        session_start();

        require_once("../models/Log.php");
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "usuario.php", "Enviar correo");
        $logI->grabarLinea();
        unset($logI);
        //Fin Log
        $correo = $_GET["correo"];
        $dominio_actual = $_SERVER["SERVER_NAME"];
        // MODIFICAR AQUÍ EL DOMINIO
        /* $url = 'http://' . $dominio_actual . '/proyectos/CostaValencia/CostaValencia/view/Alojamientos/datosAlojamiento.php?idAloja=' . $idAloja . ''; */
        // IMAGEN LOGOTIPO CORREO
        $img = 'https://' . $dominio_actual . '/public/img/logo_pequeno.png';

        $idUsu = $usuario->recogerIdxCorreo($correo)[0][0];
        $idUsuCifrada = encryptNumber($idUsu);

        // MODIFICAR AQUÍ EL DOMINIO
        $dominio_actual = $_SERVER['SERVER_NAME'];
        /* $url = 'http://' . $dominio_actual . '/proyectos/CostaValencia/CostaValencia/view/Alojamientos/datosAlojamiento.php?idAloja=' . $idAloja . ''; */
        $url = 'https://' . $dominio_actual . '/view/RecPass/RecPass.php?idUsu=' . $idUsuCifrada;

        /*         $url = 'http://' . $dominio_actual . '/costaValencia/view/RecPass/RecPass.php?idUsu='.$idUsuCifrada;
 */


        try {

            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.ionos.es';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'software@efeuno.com.es';                     //SMTP username
            $mail->Password   = 'M4r10.efeuno';                               //SMTP password
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


            //Recipients
            $mail->setFrom('software@efeuno.com.es', 'Administracion');
            $mail->addAddress($correo, '');     //Add a recipient
            /* $mail->addAddress('ellen@example.com'); */               //Name is optional
            /* $mail->addReplyTo('info@example.com', 'Information'); */
            /* $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com'); */
            $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo

            //Attachments
            /* $mail->addAttachment($pdfDoc); */      //Add attachments
            $mail->Subject = 'Recuperar contraseña - Costa de Valencia';

            $cuerpo = file_get_contents("../public/CorreoPass.html"); /* Ruta del template en formato HTML */
            /* parametros del template a remplazar */
            $cuerpo = str_replace("url", $url, $cuerpo);

            $mail->Body    = $cuerpo;
            $mail->AltBody = "Recuperar contraseña - Costa de Valencia";

            $datosUsu = $usuario->crearToken($idUsu, $idUsuCifrada);

            $mail->send();

            echo '1';
        } catch (Exception $e) {

            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        break;
        case "enviarCorreoPers":
            // Archivo LOG
            session_start();
    
            require_once("../models/Log.php");
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "usuario.php", "Enviar correo");
            $logI->grabarLinea();
            unset($logI);
            //Fin Log
            $correo = $_GET["correo"];
            $dominio_actual = $_SERVER["SERVER_NAME"];
            // MODIFICAR AQUÍ EL DOMINIO
            /* $url = 'http://' . $dominio_actual . '/proyectos/CostaValencia/CostaValencia/view/Alojamientos/datosAlojamiento.php?idAloja=' . $idAloja . ''; */
            // IMAGEN LOGOTIPO CORREO
            $img = 'https://' . $dominio_actual . '/public/img/logo_pequeno.png';
    
            $idUsu = $usuario->recogerIdxCorreoPers($correo)[0][0];
            $idUsuCifrada = encryptNumber($idUsu);
    
            // MODIFICAR AQUÍ EL DOMINIO
            $dominio_actual = $_SERVER['SERVER_NAME'];
            /* $url = 'http://' . $dominio_actual . '/proyectos/CostaValencia/CostaValencia/view/Alojamientos/datosAlojamiento.php?idAloja=' . $idAloja . ''; */
            $url = 'https://' . $dominio_actual . '/view/RecPass/RecPassPers.php?idUsu=' . $idUsuCifrada;
    
            /*         $url = 'http://' . $dominio_actual . '/costaValencia/view/RecPass/RecPass.php?idUsu='.$idUsuCifrada;
     */
    
    
            try {
    
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.ionos.es';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'software@efeuno.com.es';                     //SMTP username
                $mail->Password   = 'M4r10.efeuno';                               //SMTP password
                $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
    
                //Recipients
                $mail->setFrom('software@efeuno.com.es', 'Administracion');
                $mail->addAddress($correo, '');     //Add a recipient
                /* $mail->addAddress('ellen@example.com'); */               //Name is optional
                /* $mail->addReplyTo('info@example.com', 'Information'); */
                /* $mail->addCC('cc@example.com');
                    $mail->addBCC('bcc@example.com'); */
                $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo
    
                //Attachments
                /* $mail->addAttachment($pdfDoc); */      //Add attachments
                $mail->Subject = 'Recuperar contraseña - Costa de Valencia';
    
                $cuerpo = file_get_contents("../public/CorreoPassPers.html"); /* Ruta del template en formato HTML */
                /* parametros del template a remplazar */
                $cuerpo = str_replace("url", $url, $cuerpo);
    
                $mail->Body    = $cuerpo;
                $mail->AltBody = "Recuperar contraseña - Costa de Valencia";
    
                $datosUsu = $usuario->crearTokenPers($idUsu, $idUsuCifrada);
    
                $mail->send();
    
                echo '1';
            } catch (Exception $e) {
    
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
    
            break;
    case "recogerTokenBD":
        // Archivo LOG
        session_start();

        require_once("../models/Log.php");
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "usuario.php", "Recoger token");
        $logI->grabarLinea();
        unset($logI);
        //Fin Log
        $token = $_GET["idUsu"];
        $idUsu = decryptNumber($token);
        
        $datosUsu = $usuario->recogerToken($idUsu);


        if (empty($datosUsu[0][0])) {
            echo "0";
        } else {
            echo "1";
        }
        break;

        case "recogerTokenBDPers":
            // Archivo LOG
            session_start();
    
            require_once("../models/Log.php");
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "usuario.php", "Recoger token");
            $logI->grabarLinea();
            unset($logI);
            //Fin Log
            $token = $_GET["idUsu"];
            $idUsu = decryptNumber($token);
    
            $datosUsu = $usuario->recogerTokePers($idUsu);
    
    
            if (empty($datosUsu[0][0])) {
                echo "0";
            } else {
                echo "1";
            }
            break;
    case "cambiarPass":
        // Archivo LOG
        session_start();

        require_once("../models/Log.php");
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "usuario.php", "Cambiar contraseña");
        $logI->grabarLinea();
        unset($logI);
        //Fin Log
        $token = $_GET["idUsu"];
        $idUsu = decryptNumber($token);
        $pass = $_GET["pass"];

        $datosUsu = $usuario->cambiarPassID($idUsu, $pass);
        echo "1";

        break;

        case "cambiarPassPers":
            // Archivo LOG
            session_start();
    
            require_once("../models/Log.php");
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "usuario.php", "Cambiar contraseña");
            $logI->grabarLinea();
            unset($logI);
            //Fin Log
            $token = $_GET["idUsu"];
            $idUsu = decryptNumber($token);
            $pass = $_GET["pass"];
            $datosUsu = $usuario->cambiarPassIDPers($idUsu, $pass);
            echo "1";
    
            break;
    case "listarAlumnos":

        $datos = $usuario->listarAlumnos();
        $data = array();



        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["idUsuario"];
            $sub_array[] = $row["nomAlumno"]." ".$row["apeAlumno"];
            $sub_array[] = $row["emailUsuario"];
            $sub_array[] = $row["teleAlumno"];


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
    case "cambiarBloqueado":

        $usuario->cambiarBloqueado($_GET["id"]);
    break;
    case "recogerBloqueado":

        $datos = $usuario->recogerBloqueado($_GET["id"]);
        echo json_encode($datos[0][0]);
    break;

    
    case "enviarCredenciales":

          $correo = $_POST["email"];
          $password = $_POST["password"];

          $dominio_actual = $_SERVER["SERVER_NAME"];


            // Archivo LOG
            session_start();
            require_once("../models/Log.php");
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "usuario.php", "Envia correo credenciales".$correo);
            $logI->grabarLinea();
            unset($logI);
            //Fin Log

  
          $url = 'https://' . $dominio_actual . '';
          //$url = 'https://' . $dominio_actual . '/view/RecPass/RecPass.php?idUsu=' . $idUsuCifrada;
  
          $rutaImg = 'https://' . $dominio_actual . '/public/img';
  
     
          try {
 
    
              //Server settings
              $mail->isSMTP();                                            //Send using SMTP
              $mail->Host       = 'smtp.ionos.es';                     //Set the SMTP server to send through
              $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
              $mail->Username   = 'software@efeuno.com.es';                     //SMTP username
              $mail->Password   = 'M4r10.efeuno';                               //SMTP password
              $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
  
  
              //Recipients
              $mail->setFrom('software@efeuno.com.es', 'Administracion');
              $mail->addAddress($correo, '');     //Add a recipient
              $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo
  
              //Attachments
              $mail->Subject = 'Bienvenido a Costa de Valencia';
  
              $cuerpo = file_get_contents("../public/CorreoCredencialesUsuario.html"); /* Ruta del template en formato HTML */
              /* parametros del template a remplazar */
              $cuerpo = str_replace("url", $url, $cuerpo);

              $cuerpo = str_replace("userInput", $correo, $cuerpo);
              $cuerpo = str_replace("passInput", $password, $cuerpo);

              $cuerpo = str_replace("rutaImgInput", $rutaImg, $cuerpo);

  
              $mail->Body    = $cuerpo;
              $mail->AltBody = "Bienvenido - Costa de Valencia";
    
              $mail->send();
  
              echo '1';
          } catch (Exception $e) {
  
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }

    break;

}
