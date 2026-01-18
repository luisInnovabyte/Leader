<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
<?php include("../../config/templates/mainHead.php"); ?>
<style>
    .input-container {
    display: flex;
    justify-content: center;
	}

	.digit-input {
		width: 40px;
		height: 40px;
		font-size: 18px;
		text-align: center;
		margin: 0 5px;
	}

    /* CHECKBOX */

    /* Hide the default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

.container {
  display: block;
  position: relative;
  cursor: pointer;
  font-size: 1.5rem;
  user-select: none;
}

/* Create a custom checkbox */
.checkmark {
  --clr: #85C99D;
  position: relative;
  top: 0;
  left: 0;
  height: 1.1em;
  width: 1.1em;
  background-color: #ccc;
  border-radius: 50%;
  transition: 300ms;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: var(--clr);
  border-radius: .5rem;
  animation: pulse 500ms ease-in-out;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 0.45em;
  top: 0.25em;
  width: 0.25em;
  height: 0.5em;
  border: solid #E0E0E2;
  border-width: 0 0.15em 0.15em 0;
  transform: rotate(45deg);
}

@keyframes pulse {
  0% {
    box-shadow: 0 0 0 #0B6E4F90;
    rotate: 20deg;
  }

  50% {
    rotate: -20deg;
  }

  75% {
    box-shadow: 0 0 0 10px #0B6E4F60;
  }

  100% {
    box-shadow: 0 0 0 13px #0B6E4F30;
    rotate: 0;
  }
}

/* Sugerir nueva contraseña */
.cta {
  border: none;
  background: none;
  cursor: pointer;
}

.cta span {
  padding-bottom: 7px;
  letter-spacing: 4px;
  font-size: 10px;
  padding-right: 15px;
  text-transform: uppercase;
}

.cta svg {
  transform: translateX(-8px);
  transition: all 0.3s ease;
}

.cta:hover svg {
  transform: translateX(0);
}

.cta:active svg {
  transform: scale(0.9);
}

.hover-underline-animation {
  position: relative;
  padding-bottom: 20px;
}

.hover-underline-animation:after {
  content: "";
  position: absolute;
  width: 100%;
  transform: scaleX(0);
  height: 2px;
  bottom: 0;
  left: 0;
  background-color: #000000;
  transform-origin: bottom right;
  transition: transform 0.25s ease-out;
}

.cta:hover .hover-underline-animation:after {
  transform: scaleX(1);
  transform-origin: bottom left;
}





</style>

<?php 
///////////////////////////////////////
/////// CONFIGURADOR DE CAMPOS ////////
///////////////////////////////////////

// 0 = NO SE MOSTRARÁ EN EL MODAL 1 = SE VERÁN LOS CAMPOS EN EL MODAL

$movilInputView = 1; // MOSTRAR CAMPOS Movil
$fechaInputView = 1; // MOSTRAR CAMPOS FECHA
$nickInputView = 1; // MOSTRAR CAMPOS Movil
$promocionalesInputView = 1; // MOSTRAR CAMPOS CORREO PROMOCIONALES
$generoInputView = 1; // MOSTRAR CAMPOS SEXO
$identificadorFiscalInputView = 0; // MOSTRAR CAMPOS IDENTIFICACION FISCAL
$fondo = 'auth-bg.jpg'; // MOSTRAR CAMPOS IDENTIFICACION FISCAL

///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
?>

</head>

<body>
  
<div class="card my-12 col-xl-12 col-xxl-12 mx-auto " style="background:url(../../public/assets/images/big/<?php echo $fondo; ?>)  center center; min-height: 100vh;">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
							<!-- ============================================================== -->
        <div class="card my-5 col-xl-9 col-xxl-8 mx-auto rounded-4 overflow-hidden border-3 p-3">

		<div id="modalRegistro" class="d-none modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registrarse - Paso <span id="current-step">1</span> de 5</h4>
                <button type="button" class="btn-prev btn btn-link" id="anterior-paso" style="display: none;"><i class="fas fa-arrow-left"></i></button>
                <style>
                    .form-control:focus {
                        color: #212529;
                        background-color: #fff;
                        border-color: #94fe86 !important;
                        outline: 0;
                        box-shadow: 0 0 0 0.25rem rgba(13, 253, 33, 0.25);
                        }
                </style>
            </div>
                <div class="modal-body step-content" data-step="1">
              
                    <div class="row">
                        <div class="form-group col-6 md-col-6  mg-t-10">

                   

                            <label class="control-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" placeholder="" autocomplete="off" minlength="1" maxlength="20"  autofocus>
                            <small>Escribe tu nombre completo. Máximo 30 caracteres.</small>
                        </div>
                       
                        <div class="form-group col-6 md-col-6  mg-t-10">
                            <label class="control-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellido" placeholder="" minlength="1" maxlength="30"  autocomplete="off">
                            <small>Ingresa tus apellidos. Máximo 30 caracteres.</small>
                        </div>

                        
                        <?php // MOSTRAR CAMPO MOVIL //
                        if($movilInputView == 1){
                        ?>
                        <div class="form-group col-6 md-col-6  mg-t-10">
                            <label class="control-label">Correo Electrónico</label>
                            <input type="text" class="form-control" autocomplete="off" id="usu_correo" minlength="1" maxlength="40"  name="correo" placeholder="">
                            <small>Introduce tu dirección de correo electrónico. ejemplo@gmail.com</small>
                        </div>

                        <div class="form-group col-6 md-col-6  mg-t-10">
                            <label class="control-label">Móvil</label>
                            <input type="text" class="form-control" autocomplete="off" id="movil" minlength="1" maxlength="12"  name="movil" placeholder="">
                            <small>Ingresa tu número de teléfono móvil.</small>

                        </div>

                        <?php }else{ ?>
                            
                            <div class="form-group col-12 md-col-12  mg-t-10">
                                <label class="control-label">Correo Electrónico</label>
                                <input type="text" class="form-control" autocomplete="off" id="usu_correo" minlength="1" maxlength="30"  name="correo" placeholder="">
                                <small>Introduce tu dirección de correo electrónico. ejemplo@gmail.com</small>
                            </div>
                            <input type="hidden" class="form-control" autocomplete="off" id="movil" minlength="1" maxlength="12"  name="movil" value="000000000">
                        
                        <?php } 
                        // FIN CAMPO FECHA
                        ?>
  
                        <?php // MOSTRAR CAMPO NICKNAME //
                        if($nickInputView == 1){
                        ?>
                        <div class="form-group col-12 mg-t-10">
                            <label class="control-label">¿Con qué apodo te gustaría ser reconocido?</label>
                            <input type="text" class="form-control" id="nickname" minlength="1" maxlength="30"  name="nick" placeholder="">
                            <small>Solo se permite letras y números sin espacios. Máximo 30 caracteres.</small>
                        </div>
                        <?php }else{ ?>
                            <input type="hidden" class="form-control" id="nickname" value="SinNick"  name="nick" placeholder="">
                        <?php } 
                        // FIN CAMPO FECHA
                        ?>

                        <?php //MOSTRAR SEXO // 
                          if($generoInputView == 0){
                        ?>
                        
                        <div class="form-group col-12 md-col-12 mg-t-10">
                            <label for="opciones">Selecciona tu género</label>
                            <select id="opciones" class="form-control" name="opcion">
                                <option value="0" selected>Seleccione una opción</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Prefiero-no-decirlo">Prefiero no decirlo</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>
                        <div  id="sexoPersonalizadoDiv" class="form-group d-none col-12  md-col-12 mg-t-10">
                            <label class="" for="texto">Personalizado</label>
                            <input type="text" class="form-control " id="sexoPersonalizado"  minlength="1" maxlength="30"    placeholder="Escribe aquí tu género.">
                            <small>Solo se permite letras. Máximo 30 caracteres.</small>

                        </div>

                        <?php }else{ ?>
                            <input type="hidden"  id="sexoPersonalizado" value="No Especificado" placeholder="Escribe aquí">
                        <?php 
                        } 
                        // FIN CAMPO PROMOCIONALES
                        ?>

                        <?php // MOSTRAR CAMPO IDENTIFICACION FISCAL //
                        if($identificadorFiscalInputView == 1){
                        ?>
                        <div class="form-group col-12 mg-t-10">
                            <label class="control-label">NIF</label>
                            <input type="text" class="form-control" id="nif" minlength="1" maxlength="30"  name="nif" placeholder="Número de identificación Fiscal">
                            <small>Introduce tu número de identificación fiscal. DNI/NIE/CIF </small>
                        </div>
                        <?php }else{ ?>
                            <input type="hidden" class="form-control" id="nif" value="00000000X"  placeholder="">
                        <?php } 
                        // FIN CAMPO FECHA
                        ?>
                        
                        <?php // MOSTRAR CAMPO FECHA //
                        if($fechaInputView == 1){

                        ?>
                        <div class="form-group col-12 mg-t-10">

							<label class="tx-bold mg-t-10">Fecha de Nacimiento</label>
							<label>Esta información no será pública. Confirma tu propia edad, incluso si esta cuenta es para una empresa</label>
							<div class="row">
								<div class="form-group col-4 md-col-4">
									<select class="form-control" id="diaNacimiento" name="diaNacimiento" >
										<option value="" disabled selected>Día</option>
										<?php 
										for ($i = 1; $i <= 31; $i++) {
											echo "<option value='$i'>$i</option>";
										}
										?>
									</select>
								</div>
								<div class="form-group col-4 md-col-4">
									<select class="form-control" id="mesNacimiento" name="mesNacimiento" >
										<option value="" disabled selected>Mes</option>
										<?php
										$meses = array(
											"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
											"Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
										);
										foreach ($meses as $index => $mes) {
											echo "<option value='" . ($index + 1) . "'>$mes</option>";
										}
										?>
									</select>
								</div>
								<div class="form-group col-4 md-col-4">
									<select class="form-control" id="anioNacimiento" name="anioNacimiento" >
										<option value="" disabled selected>Año</option>
										<?php
										$anioActual = date("Y");
										for ($i = $anioActual; $i >= 1903; $i--) {
										echo "<option value='$i'>$i</option>";
										}
										?>
									</select>
								</div>
							</div>
							<?php }else{ ?>
								<input type="hidden" id="diaNacimiento" value="1">
								<input type="hidden" id="mesNacimiento" value="1">
								<input type="hidden" id="anioNacimiento" value="0000">
							<?php } 
							// FIN CAMPO FECHA
							?>

						

						</div>
					</div>
				</div>
                <div class="modal-body step-content" data-step="2">
                    <div class="row">

                            <?php // MOSTRAR CAMPO PROMOCIONALES //
                            if($promocionalesInputView == 1){
                            ?>

                                <div class="col-md-12">
                                    <div class="form-group options clearfix">
                                    <strong>¿Te gustaría recibir nuestros correos promocionales?</strong>
                                    <div class="mg-sm-t-10">

                                        

                                        <label class="switch-light  switch-ios float-end">
                                            <input type="checkbox" name="newsletterCheck" id="newsletterCheck" value="1" checked>
                                            <span>
                                                <span>No</span>
                                                <span>Sí</span>
                                            </span>
                                            <a></a>
                                        </label>
                                    </div>
                                    </div>
                                </div>

                            <?php }else{ ?>
                                <input type="hidden" name="newsletterCheck" id="newsletterCheck" value="0" checked>

                            <?php 
                            } 
                            // FIN CAMPO PROMOCIONALES
                            ?>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="d-flex align-items-center row">
                                        <span class="ms-2 col-11">
                                            <strong id="textCondiciones" class="mb-0">He leído y acepto los <a href="terminos-condiciones.php" target="_blank">Términos y Condiciones</a> de registro.</strong>
                                        </span>
                                        <label class="container col-1">
                                            <input  value="" id="" name="" class="icheck" type="checkbox">
                                            <div class="checkmark"></div>
                                        </label>
                                    </label>
                                </div>
                            </div>

                            
                    </div>
                </div>
                <div class="modal-body step-content" data-step="3">
                    <div class="row  d-flex justify-content-center text-center aling-item-center">
                        <h2 class="mg-b-20">Te enviamos un código</h2>
                        <p>Introdúcelo abajo para verificar <b id="correoText"></b></p>
                        <div class="form-group col-12 md-col-12">
                            <label class="control-label">Código de verificación</label>
                            <div class="row mg-b-10  d-flex justify-content-center text-center aling-item-center">
                                <input type="text" id="code1" class="form-control digit-input" maxlength="1">
                                <input type="text" id="code2" class="form-control digit-input" maxlength="1">
                                <input type="text" id="code3" class="form-control digit-input" maxlength="1">
                                <input type="text" id="code4" class="form-control digit-input" maxlength="1">
                                <input type="text" id="code5" class="form-control digit-input" maxlength="1">
                            </div>
                            <a class="" href="javascript:actualizar()">¿No recibiste el correo electrónico?</a>
                        </div>
                    </div>
                </div>
                <div class="modal-body step-content" data-step="4">

                    <div class="form-group col-12 mg-t-10">
                        <h2 class="mg-b-20">Necesitarás una contraseña</h2>
                        <p id="textError" class="mb-b-10">Asegúrate de que tenga 8 caracteres o más.<br>
                        Una mayúscula y un símbolo. 
                        </p><br>
                        <div class="input-group mb-3 col-12">
                            <input type="password" autocomplete="off" class="form-control form-control-lg mx-xxl-2" id="usu_pass" placeholder="Introduce tu Password" aria-label="Password" aria-describedby="basic-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-info" id="ver" type="button" title="Mostrar contraseña">
                                    <i id="icono" class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 mg-t-10">
                        <button class="cta tx-white" onclick="generarPass()">
                            <span class="hover-underline-animation"> Generar Contraseña </span>
                        </button>
                    </div>
                </div>
                <div class="modal-body step-content bg-confetti-animated mg-b-30" data-step="5">
                    <div class="row ">
                        <h2 id="textExit" class="mg-b-20">¡Cuenta creada con éxito!</h2>
                        <p>Ya puedes iniciar sesión en <b class="tx-success"><i>Iniciar Sesión</i></b></p>
                    </div>
                </div>
                
                <div class="modal-footer mt-xxl-2">
                    <a href="../Login/" type="button" id="yaCuenta" class="btn btn-info tx-white d-none mx-xxl-1">¡Ya tengo cuenta!</a>
                    <button type="button" class="btn-next btn btn-success botonStepsCase" id="siguiente-paso">Siguiente</button>
                    <button type="button" class="btn btn-success" id="guardar-registro" style="display: none;">Iniciar Sesión</button>
                </div>
                </div>
        </div>
    </div>
        </div>
    
    </div>


	<script>
		const passwordInput = document.getElementById("usu_pass");
		const toggleButton = document.getElementById("ver");
		const eyeIcon = document.getElementById("icono");

		toggleButton.addEventListener("click", function () {
			if (passwordInput.type === "password") {
				passwordInput.type = "text";
				eyeIcon.classList.remove("fa-eye");
				eyeIcon.classList.add("fa-eye-slash");
			} else {
				passwordInput.type = "password";
				eyeIcon.classList.remove("fa-eye-slash");
				eyeIcon.classList.add("fa-eye");
			}
		});
	</script>

    
    <?php include_once '../../config/templates/mainJs.php' ?>

	<script src="inicioSesion.js"></script>

</body>

</html>