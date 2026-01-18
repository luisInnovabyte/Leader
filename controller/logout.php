
<?php
require_once("../config/funciones.php");

session_start(); // Iniciar la sesión

//Archivos Log
generarLog('logout.php','Sesión cerrada'); //EJEMPLO: generarLog('empresa.php','Listar datos de empresa');
//FIN Log
// Destruir todas las variables de sesión
session_unset();
// Destruir la sesión
session_destroy();

// Redireccionar al usuario a la página de inicio de sesión
header("Location: ../view/Login/");
exit(); // Asegurarse de que el script se detenga después de la redirección
