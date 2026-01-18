<?php

require_once('../../config/funciones.php');
require_once('../../config/conexion.php');

require_once("../../models/Config.php");

$datosConfig = new Config();

$datosEmpresa =  $datosConfig->get_datos_empresaConfig();

$idEmpresa = $datosEmpresa[0]['idEmpresa']; //1
$nombreEmpresa = $datosEmpresa[0]['nombreEmpresa']; //2
$logotipoEmpresa = $datosEmpresa[0]['logotipoDark'];
$versionEfeuno = $datosEmpresa[0]['version_efeuno'];

session_start();
$modo = $_SESSION['modo'];
$logotipo;
$favicon;


$version_web = '';

if($modo == '1'){
    $logotipo = $datosEmpresa[0]['logotipoDark']; //3
    $favicon = $datosEmpresa[0]['faviconDark']; //4
}else{
    $logotipo = $datosEmpresa[0]['logotipoWhite']; //5
    $favicon = $datosEmpresa[0]['faviconWhite']; //6
}

$footerEmpresa = $datosEmpresa[0]['footerEmpresa']; //7
$mostrarSancion = $datosEmpresa[0]['mostrarSancion']; //8
$mostrarMeses = $datosEmpresa[0]['mostrarMeses']; //9
$mostrarQuincenas = $datosEmpresa[0]['mostrarQuincenas']; //10
$mostrarTrimestral = $datosEmpresa[0]['mostrarTrimestral']; //11
$factProPresupuesto = $datosEmpresa[0]['tipoPresupusto']; //12
$mostrarContPrecinto = $datosEmpresa[0]['mostrarContPrecinto']; //12
$webEmpresa = $datosEmpresa[0]['webEmpresa']; //13
$tlfEmpresa = $datosEmpresa[0]['tlfEmpresa']; //14
$colorDefault = $datosEmpresa[0]['colorPrincipal']; //15

$cliente_gesdoc = $datosEmpresa[0]['cliente_gesdoc']; 
$departamento_gesdoc = $datosEmpresa[0]['departamento_gesdoc']; 

                // SUSCRIPCION //
$datosSuscripcion =  $datosConfig->get_datos_suscripcion();
$json_string = json_encode($datosSuscripcion);
$file = 'VGY.json';
file_put_contents($file, $json_string);
$idSoftware = $datosSuscripcion[0]['idSoftware'];
$nombreDominio = $datosSuscripcion[0]['nombreDominio'];

$gesdoc_m = $datosSuscripcion[0]['gesdoc_m'];
$facturacion_m = $datosSuscripcion[0]['facturacion_m'];
$cms_m = $datosSuscripcion[0]['cms_m'];
$inscripciones_m = $datosSuscripcion[0]['inscripciones_m'];
$inscripciones_m = $datosSuscripcion[0]['inscripciones_m'];
$facturacion_m = $datosSuscripcion[0]['facturacion_m'];
$helpdesk_m = $datosSuscripcion[0]['helpdesk_m'];
$transporte_m = $datosSuscripcion[0]['transporte_m'];
$avisos_m = $datosSuscripcion[0]['avisos_m'];
$educacion_m = $datosSuscripcion[0]['educacion_m'];

//SMTP


$smtp_host = $datosEmpresa[0]['smtp_host']; //12
$smtp_auth = $datosEmpresa[0]['snto_auth']; //12
$smtp_username = $datosEmpresa[0]['smtp_username']; //12
$smtp_pass = $datosEmpresa[0]['smtp_pass']; //12
$smtp_port = $datosEmpresa[0]['smtp_port']; //12
$smtp_receptor = $datosEmpresa[0]['smtp_receptor']; //12


//=============================================================================//
//                               SETTINGS 🔩🔧                                //
//============================================================================//

// Obtener el dominio completo (por ejemplo, "efeuno.es" o "www.efeuno.es")
$dominioCompleto = $_SERVER['HTTP_HOST'];

// Guardar directamente el dominio o la IP completa
$nombreDominio = $dominioCompleto;
$json_string = json_encode($nombreDominio);
$file = 'assa.json';
file_put_contents($file, $json_string);
// Construir la ruta al archivo de configuración basado en el nombre del dominio
$jsonContentSettings = file_get_contents(__DIR__ . '/settings/' . $nombreDominio . '.json');

// Convertir el JSON a un arreglo asociativo de PHP
$configJsonSetting = json_decode($jsonContentSettings, true);


// Acceder a las variables de entorno de la base de datos
$dbHost = $configJsonSetting['database']['host'];
$dbUser = $configJsonSetting['database']['username'];
$dbPassword = $configJsonSetting['database']['password'];







//=======================================================================//
//=======================================================================//
//=======================================================================//


?>
