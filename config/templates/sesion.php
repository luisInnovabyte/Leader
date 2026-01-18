<?php
  session_start();
function checkAccess($rolesRequeridos) {
  
  if (isset($_SESSION['usu_rol'])) {
    if (in_array($_SESSION['usu_rol'], $rolesRequeridos) ) {
      // El usuario tiene uno de los roles requeridos, se permite el acceso
      return true;
    } else {
      // El usuario no tiene ninguno de los roles requeridos, se redirige a la página de login
      header('Location: ../../view/Login/index.php');
      exit();
    }
  } else {
    // El usuario no está autenticado, se redirige a la página de login
    header('Location: ../../view/Login/index.php');
    exit();
  }
}
?>