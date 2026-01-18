<!doctype html>
<html lang="es" data-bs-theme="dark">
<!--start head-->

<head>
  <?php

  session_start();
  if (($_SERVER['REQUEST_METHOD'] == 'POST') ) {

    if (isset($_SESSION['usu_id'])) {
      {
        header('Location:../Home/index.php');

      }
  }
  }
  ?>
  <?php include("../../config/templates/mainHead.php"); ?>

</head>
<!--end head-->
  <body>


    <!--authentication-->

     <div class="container my-5">
        <div class="row">
           <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
            <div class="card border-3">
              <div class="card-body p-5">
              <input type="hidden" id="token" value=<?php echo $_GET['tokenidusu'];?>>
              <img src="../../public/assets/images/efeuno/logotipoWhite.png" class="mb-4" width="200" alt="">
                  <h4 class="fw-bold">Generar Nueva Contraseña</h4>
                  <p class="mb-0">Por favor introduce la nueva contraseña</p>
                  <div class="form-body mt-4">
										<form class="row g-3">
											<div class="col-12">
												<label class="form-label" for="NewPassword">Nueva Contraseña</label>
												<input type="password" class="form-control" id="NewPassword" placeholder="Introduce nueva contraseña">
											</div>
                      <div class="col-12">
                        <label class="form-label" for="ConfirmPassword">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="ConfirmPassword" placeholder="Confirma la nueva contraseña">
                      </div>
											<div class="col-12">
												<div class="d-grid gap-2">
                          <button type="button" class="btn btn-primary" id="changePasswordButton">Cambiar Contraseña</button>
                           <a href="../../view/Login/" class="btn btn-light">Cancelar</a>
                        </div>
											</div>    
										</form>
									</div>

              </div>
            </div>
           </div>
        </div><!--end row-->
     </div>
      

   <!--plugins-->
   <?php include_once '../../config/templates/mainJs.php' ?>

<script src="index.js"></script>

  
  </body>
</html>