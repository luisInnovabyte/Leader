<?php

// Mostrar Datos //

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Empresa.php");
session_start();
require_once("../models/Log.php");

$empresa = new Empresa();



switch ($_GET["op"]) {

    case "listarEmpresa":

        $empresaInfo = $empresa->listarEmpresa();

        //Archivos Log
        generarLog("empresa.php","Listar datos de empresa");
        //FIN Log

        echo json_encode($empresaInfo);

        break;
    case "insertarEmpresa":

        //Archivos Log
        generarLog("empresa.php","Insertar empresa");
        //FIN Log
        $nombreEmpresa = ucfirst($_POST['inputNombreEmpresa']);
        $telfEmpresa = $_POST['inputTelf'];
        $emailEmpresa = $_POST['inputEmail'];
        $nifEmpresa = $_POST['inputNif'];
        $webEmpresa = $_POST['inputWeb'];
        $regEmpresa = $_POST['inputRegEmpresa'];
        $prefijoPro = $_POST['prefijoPro'];
        $prefijoFact = $_POST['prefijoFact'];
        $inputfactPro = $_POST['inputfactPro'];
        $inputfact = $_POST['inputfact'];
        $inputfactNeg = $_POST['inputfactNeg'];

        $dirEmpresa = ucfirst($_POST['inputDireccion']);
        $poblaEmpresa = ucfirst($_POST['inputPoblacion']);
        $provEmpresa = ucfirst($_POST['inputProvincia']);
        $cpEmpresa = $_POST['inputCP'];
        $paisEmpresa = ucfirst($_POST['inputPais']);



        $empresa->insertarEmpresa($nombreEmpresa, $dirEmpresa, $poblaEmpresa, $cpEmpresa, $provEmpresa, $paisEmpresa, $webEmpresa, $telfEmpresa, $emailEmpresa, $nifEmpresa, $regEmpresa,$inputfactPro, $inputfact, $inputfactNeg,$prefijoPro,$prefijoFact);


        break;
    case "editarEmpresa":

        //Archivos Log
        generarLog("empresa.php","Editar empresa");
        //FIN Log
        $idEmpresa = $_POST['inputIdEmpresa'];

        $nombreEmpresa = ucfirst($_POST['inputNombreEmpresa']);
        $telfEmpresa = $_POST['inputTelf'];
        $emailEmpresa = $_POST['inputEmail'];
        $nifEmpresa = $_POST['inputNif'];
        $webEmpresa = $_POST['inputWeb'];
        $regEmpresa = $_POST['inputRegEmpresa'];
        $prefijoPro = $_POST['prefijoPro'];
        $prefijoFact = $_POST['prefijoFact'];
        $inputfactPro = $_POST['inputfactPro'];
        $inputfact = $_POST['inputfact'];
        $inputfactNeg = $_POST['inputfactNeg'];

        $dirEmpresa = ucfirst($_POST['inputDireccion']);
        $poblaEmpresa = ucfirst($_POST['inputPoblacion']);
        $provEmpresa = ucfirst($_POST['inputProvincia']);
        $cpEmpresa = $_POST['inputCP'];
        $paisEmpresa = ucfirst($_POST['inputPais']);



        $empresa->editarEmpresa($idEmpresa, $nombreEmpresa, $dirEmpresa, $poblaEmpresa, $cpEmpresa, $provEmpresa, $paisEmpresa, $webEmpresa, $telfEmpresa, $emailEmpresa, $nifEmpresa, $regEmpresa, $inputfactPro, $inputfact, $inputfactNeg,$prefijoPro,$prefijoFact);



        break;
    case "sumar1factprofactreal":
            $empresa->sumar1factprofactreal($_GET["empresa"]);
        break;
    case "sumar1factabono":
            $empresa->sumar1factabono($_GET["empresa"]);
        break;

    // MODO OSCURO SESSION//
    case "modoOscuro":
      
        $modo = $_POST["modo"];

        if($modo == '1'){
        session_start();
        $_SESSION['modo'] = '1';
        
        }else{
        session_start();
        $_SESSION['modo'] = '0';
        
        }


    break;
    /////////////////////////////////
    // SUBIDA DE LOGOTIPOS ICONOS //
    ///////////////////////////////

    case "subirIcono":

        $targetDir = "../public/img/"; // Carpeta de destino donde se guardarán las imágenes
        $targetFile = $targetDir . $_FILES["file"]["name"];

        // Mover el archivo temporal a la ubicación deseada
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            // El archivo se ha guardado correctamente
            // Puedes realizar más acciones si es necesario
            echo "La imagen se ha guardado correctamente.";
        } else {
            // Ha ocurrido un error al guardar el archivo
            echo "Error al guardar la imagen.";
        }

    break;
    
    case "subirLogotipo":

        $targetDir = "../public/img/"; // Carpeta de destino donde se guardarán las imágenes
        $targetFile = $targetDir . $_FILES["file"]["name"];
        

        // Mover el archivo temporal a la ubicación deseada
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            // El archivo se ha guardado correctamente
            // Puedes realizar más acciones si es necesario
            echo "La imagen se ha guardado correctamente.";
            
        //Archivos Log
        generarLog("empresa.php","Imagen guardada");
        //FIN Log
        } else {
            // Ha ocurrido un error al guardar el archivo
            echo "Error al guardar la imagen.";
        }
        
    break;
    // LISTAR CONFIGURACION
    case "listarOpciones":

        $opciones = $empresa->listarOpciones();

        echo json_encode($opciones);

    break;

    // ACTUALIZAR CONFIGURACION

    case "actualizarConfiguracion":
      


        $tabla = $_POST['tabla'];
        $estado = $_POST['estado'];
       
        $empresa->actualizarConfig($tabla,$estado);
       

    break;
     // ACTUALIZAR modulo

     case "actualizarModulo":
      


        $modulo = $_POST['modulo'];
        $estado = $_POST['estado'];
       
        $empresa->actualizarModulo($modulo,$estado);
       

    break;
    case "consultarCodigo":
      
        $codigo = $empresa->consultarCodigo();

        echo json_encode($codigo);

    
    break;
    case "aumentarNumFacturaPro":
        $empresa->aumentarNumFacturaPro();
        echo "1";
    break;
  

    

}
