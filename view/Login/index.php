<!doctype html>
<html lang="es" data-bs-theme="light">

<!--start head-->
<head>
<?php
    session_start();
    if (isset($_SESSION['usu_id'])) {
        header('Location:../Home/index.php');
        exit();
    }
    
    // Cargar solo la configuración necesaria para el login
    $dominioCompleto = $_SERVER['HTTP_HOST'];
    $jsonContentSettings = file_get_contents(__DIR__ . '/../../config/settings/' . $dominioCompleto . '.json');
    $configJsonSetting = json_decode($jsonContentSettings, true);
    $versionEfeuno = '1.0';
    $favicon = 'favicon.png';
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="efeuno.es">
<title><?php echo $configJsonSetting['General']['tituloSitio']; ?></title>
<link rel="icon" type="image/x-icon" href="../../public/assets/images/<?php echo $favicon ?>">
<meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">

<!-- loader-->
<link href="../../public/assets/css/pace.min.css" rel="stylesheet">
<script src="../../public/assets/js/pace.min.js"></script>
<!--Styles-->
<link href="../../public/assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="../../public/assets/css/icons.css">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="../../public/assets/css/main.css" rel="stylesheet">
<link href="../../public/assets/css/dark-theme.css" rel="stylesheet">
<link href="../../public/assets/css/semi-dark-theme.css" rel="stylesheet">
<link href="../../public/assets/css/minimal-theme.css" rel="stylesheet">
<link href="../../public/assets/css/shadow-theme.css" rel="stylesheet">
<!-- TOASTR -->
<link href="../../public/assets/js/toastr/build/toastr.css" rel="stylesheet">
<link href="../../public/assets/css/style.css" rel="stylesheet">
<link href="../../public/assets/css/efeuno.css" rel="stylesheet">
<style>

.material-symbols-outlined {
            font-size: 30px; /* Ajusta el tamaño según sea necesario */
        }

</style>
</head>
<!--end head-->

<body>


  <!--authentication-->
<!-- Form -->
<div>

  <div class="mx-3 mx-lg-0">

  <div class="card my-5 col-xl-9 col-xxl-8 mx-auto rounded-4 overflow-hidden border-3 p-3">
    <div class="row g-3">
      <div class="col-lg-6 d-flex">
        <div class="card-body p-5 w-100">
          <div class="mb-4">
            <h2 class="fw-bold mb-0" style="color: #159315ff; line-height: 1.2;">LEADER</h2>
            <h2 class="fw-bold" style="color: #159315ff; line-height: 1.2;">TRANSPORT</h2>
          </div>
          <h4 class="fw-bold">Inicia sesión</h4>
          <p class="mb-0">Introduce tus credenciales para entrar en tu cuenta</p>
          <div class="row g-3 my-4">
            <div class="col-12 col-lg-12">
              <!-- <button id="google-login" class="btn btn-light py-2 font-text1 fw-bold d-flex align-items-center justify-content-center w-100"><img 
              src="../../public/assets/images/icons/google-2.png" width="18" class="me-2" alt="">Iniciar Sesión con Google</button> -->
            </div>
            
          </div>
          <div class="separator">
            <!-- <div class="line"></div>
            <p class="mb-0 fw-bold">O</p>
            <div class="line"></div> -->
          </div>
          <div id="divLogin" class="form-body mt-4">
            <form class="row g-3" id="login_form">
              <div class="col-12">
                <label for="inputEmailAddress" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="usu_correo" placeholder="ejemplo@dominio.com">
              </div>
              <div class="col-12">
                <label for="inputChoosePassword" class="form-label">Contraseña</label>
                <div class="input-group" id="show_hide_password">
                  <input type="password" class="form-control border-end-0" id="usu_pass" 
                    placeholder="Introduzca contraseña">
                  <a href="javascript:;" class="input-group-text bg-transparent"><i
                      class="bi bi-eye-slash-fill"></i></a>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check form-switch">
                  <!-- <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                  <label class="form-check-label" for="flexSwitchCheckChecked">Recordar contraseña</label> -->
                </div>
              </div>
              <div class="col-md-6 text-end"> <a href="../../view/RecuperarPass/">¿Contraseña olvidada?</a>
              </div>
              <div class="col-12">
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary" id="loginButton">Login</button>
                </div>
              </div>
              <div class="col-12">
                <div class="text-start">
                  <p class="mb-0">¿No tienes cuenta?<a href="../../view/Registro"> Registrate</a>
                  </p>
                </div>
              </div>
            </form>
            
          </div>
         
        </div>
        <div>
                <a class="nav-link dark-mode-icon" id="toggle-bs-theme" href="javascript:;"><span id="theme-icon" class="material-symbols-outlined">dark_mode</span></a>
              </div>
      </div>
      <div class="col-lg-6 d-lg-flex ">
        <div class="p-3 rounded-4 w-100 d-flex align-items-center justify-content-center border-3 bg-primary">
          <img src="../../public/assets/images/boxed-login.png" class="img-fluid" alt="">
        </div>
      </div>

    </div><!--end row-->
  </div>

</div>
  <!--BS Scripts-->
  <script src="../../public/assets/js/jquery.min.js"></script>
  <script src="../../public/assets/js/bootstrap.bundle.min.js"></script>
  <script src="../../public/assets/js/main.js"></script>
  <!-- SWEETALERT 2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- TOASTR -->
  <script src="../../public/assets/js/toastr/toastr.js"></script>
  <!-- end BS Scripts-->

  <!--authentication-->

  <!--start plugins extra-->
  <script>
        $(document).ready(function() {
            $('#google-login').on('click', function() {
                window.location.href = '../../controller/googleLogin.php';
            });
        });
    </script>
       <script src="index.js"></script>
  <!--end plugins extra-->
  
<footer class="footer">
    <div class="footer-content">
        <div class="footer-left"></div>
        <div class="footer-center">
            <?php echo date("Y");?> © Todos los derechos reservados. Diseñado y desarrollado por 
            <a href="https://innovabyte.es">Innovabyte</a>.
        </div>
        <div class="footer-right">
            v<?php echo "2.0.1"; ?><b class="tx-danger">*</b>
        </div>
    </div>
</footer>

</body>

</html>