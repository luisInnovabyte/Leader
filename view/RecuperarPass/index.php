<html lang="es" data-bs-theme="light">

<!--start head-->

<head>
  <?php

  session_start();
  if (isset($_SESSION['usu_id'])) {


    //header('Location:../Home/index.php');
  }
  ?>
  <?php include("../../config/templates/mainHead.php"); ?>

</head>
<!--end head-->

<body>


  <!--authentication-->
<?php

if (isset($_GET['correoUsu'])) {

?>
<input type="hidden" id="getCorreo" value="<?php echo $_GET['correoUsu'] ?>">

<?php
}
?>
  <div class="mx-3 mx-lg-0">

    <div class="card my-5 col-xl-9 col-xxl-8 mx-auto rounded-4 overflow-hidden border-3 p-3">
      <div class="row g-3 align-items-center">
        <div class="col-lg-6 d-flex">
          <div class="card-body p-5 w-100">
            <div class="image-container">
            <div class="mb-4">
            <h2 class="fw-bold mb-0" style="color: #159315ff; line-height: 1.2;">LEADER</h2>
            <h2 class="fw-bold" style="color: #159315ff; line-height: 1.2;">TRANSPORT</h2>
          </div>
            </div>
            <div id="emailInput">
            <h4 class="fw-bold">¿Contraseña olvidada?</h4>
            <p class="mb-0">Introduce tu dirección de correo eléctronico para enviarte un mensaje de confirmación</p>

            <div class="form-body mt-4">
              <form class="row g-3">
                <div class="col-12">
                  <label class="form-label">Email</label>
                  <input type="text" id="email_recuperar" class="form-control" placeholder="ejemplo@dominio.com">
                </div>
                <div class="col-12">
                  <div class="d-grid gap-2">
                    <button type="button" id="btnEnviarConfirmacion" class="btn btn-primary">Enviar</button>
                    <a href="../../view/Login/" class="btn btn-light">Cancelar</a>
                  </div>
                </div>
              </form>
            </div>
          </div>


            <div id="modalVerification" class="modal-content" style="display: none;">
              <div class="modal-body step-content">
                <div class="row d-flex justify-content-center text-center align-items-center">
                  <h6>Introdúce abajo el código para verificar</h6>
                  <div class="form-group col-12 md-col-12">
                    <label class="control-label mg-t-10 mb-t-10">Código de verificación</label>
                    <div class="row mg-b-10 d-flex justify-content-center text-center align-items-center">
                      <input type="text" id="code1" class="form-control digit-input" maxlength="1">
                      <input type="text" id="code2" class="form-control digit-input" maxlength="1">
                      <input type="text" id="code3" class="form-control digit-input" maxlength="1">
                      <input type="text" id="code4" class="form-control digit-input" maxlength="1">
                      <input type="text" id="code5" class="form-control digit-input" maxlength="1">
                    </div>
                    <button type="button" id="btnEnviarCodigo" class="btn btn-primary col-12 mb-t-10 mg-t-10">Confirmar codigo</button>
                    <a href="../../view/Login/" class="btn btn-light col-12  mb-t-10 mg-t-10">Cancelar</a>
                    <div>
                    <a class="" href="javascript:actualizar()">¿No recibiste el correo electrónico?</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="col-lg-6 d-lg-flex">
          <div class="p-3 rounded-4 w-100 d-flex align-items-center justify-content-center border-3 bg-primary">
            <img src="../../public/assets/images/boxed-forgot-password.png" class="img-fluid" alt="">
          </div>
        </div>

      </div><!--end row-->
    </div>

  </div>




  <!--authentication-->




  <!--plugins-->
  <?php include_once '../../config/templates/mainJs.php' ?>

  <script src="index.js"></script>

</body>

</html>