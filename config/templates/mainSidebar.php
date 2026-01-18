<?php
session_start();

$rolUsuarioMenu = $_SESSION['usu_rol'];
$usuario = $_SESSION['usu_nom']; // Nombre de usuario
$apellido = $_SESSION['usu_ape']; // Nombre de usuario
$idUsuario = $_SESSION['usu_id']; // ID de usuario
$avatar = $_SESSION['usu_avatar']; // ID de usuario
$tokenUsu = $_SESSION['usu_token'];
/* $avatarUsuario = $_SESSION['usu_avatar'];  */ //

// SELECCION DE TEXTOS POR ROL //

/* 

https://fonts.google.com/icons

  $avatarUsuario = [
  '999' => 'superadmin.png',
  '2' => 'usuario.png',
  '1' => 'administrador.png',
];

$avatarRol = $avatarUsuario[$rolUsuarioMenu] ?? ''; */

// SELECCION DE AVATAR POR ROL //
/* $rolAvatar = [
    '0' => 'profesorAvatar.png', //'Profesor',
    '1' => 'adminAvatar.png', //'Administrador',
    '2' => 'jefeEstudiosAvatar.png', //'Jefe de Estudios',
    '3' => 'alumnoAvatar.png',  //'Alumno'
]; */

/* $rolAvatar = $_SESSION['usu_avatar']; */
?>
<aside class="sidebar-wrapper">
  <div class="sidebar-header">
    <div class="logo-icon">
      <img src="../../public/assets/images/<?php echo $logotipo ?>" class="logo-img" alt="">
    </div>
    <div class="logo-name flex-grow-1">
      <h5 class="mb-0"></h5>
    </div>
    <div class="sidebar-close ">
      <span class="material-symbols-outlined">close</span>
    </div>
  </div>
  <div class="sidebar-nav" data-simplebar="true">

    <!--navigation-->
    <ul class="metismenu" id="menu">
      <li>
        <a href="../../view/Home">
          <div class="parent-icon"><span class="material-symbols-outlined">home</span>
          </div>
          <div class="menu-title">Inicio</div>
        </a>
      </li>

      
      <!-- <?php if (isset($_SESSION['superadmin'])) { ?>
      
        <li class="menu-label">SUPERADMIN</li>
          <li>
            <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><span class="material-symbols-outlined">hotel_class</span>

              </div>
              <div class="menu-title">GESTIÓN ADMIN </div>
            </a>
            <ul>
              <li> <a href="../../view/SUPER"><span class="material-symbols-outlined">arrow_right</span>Módulos</a>
              </li>
              <li> <a href="../../view/Logs/"><span class="material-symbols-outlined">arrow_right</span>Logs</a>
              </li>
            </ul>
          </li>
      <?php } ?>
     -->


    
     
     
        
        <li class="menu-label">TRANSPORTES</li>

        <?php if ($_SESSION['usu_rol'] == 1) { ?>
            <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><span class="material-symbols-outlined">local_shipping</span>
              </div>
              <div class="menu-title">Órdenes</div>
            </a>
            <ul>
              <li> <a href="../../view/Transportes/"><span class="material-symbols-outlined">receipt_long</span>Consultar Ordenes</a>
              </li>

              <li> <a href="../../view/Transportes/subirOrdenes.php"><span class="material-symbols-outlined">upload</span>Cargar Ordenes</a>
                </li> 
                <li> <a href="../../view/Logs/"><span class="material-symbols-outlined">receipt_long</span>Logs</a>
                <li> <a href="../../view/Logs/control_descargas.php"><span class="material-symbols-outlined">receipt_long</span>Control Descargas</a>
                <li> <a href="../../view/Logs/control_procesados.php"><span class="material-symbols-outlined">receipt_long</span>Control Procesados</a>
                </li>
            </ul>

          <?php }else{ ?>
           
            <li>
              <a href="../../view/Transportes/">
                <div class="parent-icon"><span class="material-symbols-outlined">local_shipping</span>
                </div>
                <div class="menu-title">Mis Órdenes</div>
              </a>

            </li>
          <?php } ?>
        </li>
      

     
          
        <?php if ($_SESSION['usu_rol'] == 1) { ?>
          <!-- <li>
            <a href="../../view/MntClientes/">
              <div class="parent-icon"><span class="material-symbols-outlined">folder</span>
              </div>
              <div class="menu-title">Clientes</div>
            </a>
          </li> -->

          <!-- <li>
              <a href="../../view/MntTrabajadores/">
              <div class="parent-icon"><span class="material-symbols-outlined">folder</span>
              </div>
              <div class="menu-title">Trabajadores</div>
            </a>

          </li> -->

          <!-- <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><i class="fa-solid fa-triangle-exclamation mg-b-5"></i>
              </div>
              <div class="menu-title">Materiales</div>
            </a>

            <ul>
              <li> <a href="../../view/MntModelos/"><span class="material-symbols-outlined">arrow_right</span>Modelos</a>
              </li>
              <li> <a href="../../view/MntFamilias/"><span class="material-symbols-outlined">arrow_right</span>Familias</a>
              </li>
              <li> <a href="../../view/MntSubFamilias/"><span class="material-symbols-outlined">arrow_right</span>Subfamilias</a>
              </li>
            </ul>
          </li> -->

          <!-- <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><i class="fa-solid fa-triangle-exclamation mg-b-5"></i>
              </div>
              <div class="menu-title">Mantenimientos</div>
            </a>
            <ul>
              <li> <a href="../../view/MntUsuariosAfontur/"><span class="material-symbols-outlined">arrow_right</span>Usuarios (Sin Finalizar)</a>
              </li>
              <li> <a href="../../view/MntProfesiones/"><span class="material-symbols-outlined">arrow_right</span>Profesiones</a>
              </li>
              <li> <a href="../../view/MntTipoClientes/"><span class="material-symbols-outlined">arrow_right</span>Tipo de Clientes</a>
              </li>
              <li> <a href="../../view/MntAccionesContacto/"><span class="material-symbols-outlined">arrow_right</span>Acciones de contacto</a>
              </li>
              <li> <a href="../../view/MntOtrosConceptos/"><span class="material-symbols-outlined">arrow_right</span>Otros conceptos</a>
              </li>
              <li> <a href="../../view/MntIVA/"><span class="material-symbols-outlined">arrow_right</span>IVA</a>
              </li>
            </ul>
          </li> -->
        <?php } ?>



      <?php if ($_SESSION['usu_rol'] == 1) { ?>
        <li class="menu-label">GESTIÓN</li>

        <li>
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><span class="material-symbols-outlined">settings</span>
            </div>
            <div class="menu-title">Mantenimientos</div>
          </a>
          <ul>

            <li> <a href="../../view/MntUsuarios/"><span class="material-symbols-outlined">arrow_right</span>Usuarios</a>
            
    
            </li>
            
            <li> <a href="../../view/Empresa/"><span class="material-symbols-outlined">arrow_right</span>Empresa</a>
            
            </li>
            <li> <a href="../../view/SMTP/"><span class="material-symbols-outlined">arrow_right</span>Config Correo</a>
            </li>
          </ul>
        </li>
      <?php } ?>



  </div>
  <div class="sidebar-bottom dropdown dropup-center dropup">
    <div class="dropdown-toggle d-flex align-items-center px-3 gap-1 w-100 h-100" data-bs-toggle="dropdown">
      <div class="user-img">
        <img src="../../public/assets/images/users/<?php echo $avatar ?>" alt="">
      </div>
      <div class="user-info">
        <h5 class="mb-0 user-name"><?php echo $usuario . ' ' . $apellido ?></h5>
        <p class="mb-0 user-designation"></p>
      </div>
    </div>
    <ul class="dropdown-menu dropdown-menu-end">
      <li><a class="dropdown-item" href="../../view/Perfil/?tokenUsuario=<?php echo $tokenUsu; ?>"><span class="material-symbols-outlined me-2">
            account_circle
          </span><span>Perfil</span></a>
      </li>
     <!--  <li><a class="dropdown-item" href="#ThemeCustomizer"><span class="material-symbols-outlined me-2">
            tune
          </span><span>Ajustes</span></a>
      </li>
      <li><a class="dropdown-item" href="javascript:;"><span class="material-symbols-outlined me-2">
            dashboard
          </span><span>Panel</span></a>
      </li>
 -->
      <li>
        <div class="dropdown-divider mb-0"></div>
      </li>
      <li><a class="dropdown-item" href="../../controller/logout.php"><span class="material-symbols-outlined me-2">
            logout
          </span><span>Cerrar sesión</span></a>
      </li>
    </ul>
  </div>
</aside>