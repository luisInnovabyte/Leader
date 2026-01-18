

//==========================================================\\
//=================== REGISTRO LOGIN ========================\\
//==========================================================//
// MENU OCULTAR MODAL //

$(document).ready(function() {
    // MOSTRAR MODAL CUANDO CARGUE
    $('#modalRegistro').removeClass('d-none');

    // Verificar si la URL contiene #registro
    if (window.location.hash === "#registro") {
      // Mostrar el modal
      $('#registro_modal').modal('show');
    if(!$(".layer").hasClass("layer-is-visible")){
        $(".layer").toggleClass("layer-is-visible");
    }
      
    }
  });
  
  $('#registro_modal').on('hidden.bs.modal', function() {
    // Aquí puedes ejecutar tu función cuando se cierre el modal
    $(".layer").toggleClass("layer-is-visible");
    
  });
  function abrirModalConClase(){
    if(!$(".layer").hasClass("layer-is-visible")){
        $(".layer").toggleClass("layer-is-visible");
    }
  }
    // FUNCION STEPS

    const stepContents = $(".step-content");
    const currentStepElement = $("#current-step");
    const previousButton = $("#anterior-paso");
    const nextButton = $("#siguiente-paso");
    const saveButton = $("#guardar-registro");
    const closeButton = $("#cerrar-modal");


    ////////////////////
    let currentStep = 1;

    function showStep(stepNumber) {
        stepContents.hide();
        $(`.step-content[data-step="${stepNumber}"]`).show();
        currentStepElement.text(stepNumber);

        previousButton.toggle(stepNumber !== 1);
        nextButton.toggle(stepNumber < stepContents.length);
        saveButton.toggle(stepNumber === stepContents.length);

        if (stepNumber === 1) {
            closeButton.html('<i class="fas fa-times"></i>');
            $('#yaCuenta').removeClass('d-none')

        } else {
            closeButton.html('<i class="fas fa-arrow-left"></i>');
            $('#yaCuenta').addClass('d-none')

        }
        if (stepNumber === 5) {
            previousButton.addClass('d-none');
        }
        // Llamar función específica para el paso
    }
   
    previousButton.on("click", () => {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    $("#guardar-registro").on("click", () => {

         window.location.href = "../Login/"; 
        /* window.location.href = "mantenimiento.php"; */

    }); 
    
    function siguiente(){
        if (currentStep < stepContents.length) {
            currentStep++;
            showStep(currentStep);
        }else{
            console.log('');
        }
    }
 
    showStep(currentStep);

    
    
///////////////////////////////////
//////////////////////////////////
/////////////////////////////////

function actualizar(){
    codigo = enviarCorreoValidacion();
}


var codigo; // Declaarado a nivel superior para que esté disponible en todo el código


$('.botonStepsCase').click(function (e) { 
    paso = $('#current-step').text(); // 1 - 2 -3 - 4

    switch (paso) {

        case '1':
            // Llamar a la función para el paso 1
                let resultvalidarDatos = validarDatosStep1();
              
                if(resultvalidarDatos == true){

                    let correo = $('#usu_correo').val();
                    $.post("../../controller/usuario.php?op=comprobarCorreo",{usu_correo:correo},function (data) {

                        if(data == 1){ // SI DA 1, SIGNIFICA QUE HAY DATOS = HAY CORREO CREADO
                          $('#usu_correo').addClass('is-invalid');
                            
                          toastr["error"]('El correo proporcionado ya se encuentra registrado.'); // Existe correo - Error personalizado
                
                        }else{
          
                            $('#usu_correo').removeClass('is-invalid');

                            let nickname = $("#nickname").val();
                            
                            $.post("../../controller/usuario.php?op=comprobarNick",{nickname:nickname},function (datos) {
                            
                                if(datos == 1){ // SI DA 1, SIGNIFICA QUE HAY DATOS = HAY CORREO CREADO
                                    $('#nickname').addClass('is-invalid');
                                      
                                    toastr["error"]('El apodo proporcionado ya se encuentra registrado.'); // Existe correo - Error personalizado
                          
                                  }else{
          
                                    $('#nickname').removeClass('is-invalid');
                                      siguiente();
                      
                                  }
                            
                            });
            
                        }
                    });
                }
                
        break;

        case '2':
            
            // PASO 2.- Validación de checkbox termino y condiiones
           

                if ($('.icheck').prop('checked')) {

                    $('#textCondiciones').removeClass('tx-danger');


                    // El checkbox está marcado  - Terminos y condiciones
                    $('#correoText').text($('#usu_correo').val()); // Asignamos correo al texto

                    // VALIDAR CORREO //
                    actualizar();
                    siguiente();

                } else {
                    $('#textCondiciones').addClass('tx-danger');
                    toastr["warning"]('Acepte los términos y condiciones.');
                }
           
            
        break;

        case '3':
            
            let validado = comprobarCodigoVerificacion(codigo);
            if(validado == true){
                siguiente();
            }else{
                toastr["error"]('Código verificación erróneo');

            }

        
        break;
        case '4':

            let resultvalidarDatosPass = validarDatosStep4();
            if(resultvalidarDatosPass == true){
                cargando();
                crearCuenta(); // TRUE - FALSE
               
            }else{
                console.log(''); // CONTRASEÑA POCO SEGURA
            }
    
        break;

        // Agregar más casos si hay más pasos
        default:
            break;
    }
});
function generarPass(){
   
    const symbols = "!@#$%^&*()_-+=<>?/{}";
    const uppercaseLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const allCharacters = "abcdefghijklmnopqrstuvwxyz" + uppercaseLetters + "0123456789" + symbols;

    let password = "";
    
    // Asegurar que haya al menos una mayúscula
    password += uppercaseLetters.charAt(Math.floor(Math.random() * uppercaseLetters.length));

    // Generar las otras posiciones aleatorias
    for (let i = 1; i < 8; i++) {
        password += allCharacters.charAt(Math.floor(Math.random() * allCharacters.length));
    }

    $('#usu_pass').val(password);
}
// SEXO //
$(document).ready(function () {
    // Agrega un evento change al elemento select
    $('#opciones').change(function () {
        // Obtiene el valor seleccionado
        var opcionSeleccionada = $(this).val();
        // Verifica si la opción seleccionada es 'personalizado'
        if (opcionSeleccionada === 'personalizado') {
            // Si es 'personalizado', quita la clase d-none
            $('#sexoPersonalizadoDiv').removeClass('d-none');
        } else {
            // Si no es 'personalizado', agrega la clase d-none
            $('#sexoPersonalizadoDiv').addClass('d-none');
        }
    });
});
// GENERAR NICK EJEMPLO
function generarNick(nombre, apellido) {
    // Eliminar espacios y combinar nombre y apellido
    let nick = (nombre + apellido).replace(/\s/g, '');

    // Agregar tres números aleatorios al final
    for (let i = 0; i < 3; i++) {
        nick += Math.floor(Math.random() * 10);
    }

    return nick;
}
//////////////////////////////////////
///////// 1.- VALIDACIÓN ////////////
////////////////////////////////////
// Validar Nombre en tiempo real
$('#nombre').keyup(function() {
    let nombre = $(this).val();
    let nombreRex = new validarCamposRegexManual($(this), /^[\p{L}\s]{1,20}$/u); 
    let resultadoNombre = nombreRex.validarRegexManual();
    
    // Obtén el apellido del otro campo
    let apellido = $('#apellido').val();

    // Genera el nick y úsalo como desees
    let nick = generarNick(nombre, apellido);
    $('#nickname').val(nick);
    

});

// Validar Apellido en tiempo real
$('#apellido').keyup(function() {

    let apellido = $(this).val();
    let apellidoRex = new validarCamposRegexManual($(this), /^[\p{L}\s]{1,20}$/u); 
    let resultadoApellido = apellidoRex.validarRegexManual();

    // Obtén el apellido del otro campo
    let nombre = $('#nombre').val();

    // Genera el nick y úsalo como desees
    let nick = generarNick(nombre, apellido);
    $('#nickname').val(nick);

});

// Validar Correo en tiempo real
$('#usu_correo').keyup(function() {
    let correoRex = new validarCamposRegexManual($(this), /^[a-zA-ZñÑ0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/); 
    let resultadoCorreo = correoRex.validarRegexManual();
});

// Validar movil en tiempo real
$('#movil').keyup(function() {
    let movilRex = new validarCamposRegexManual($(this),  /^[\d\s\-()+]{9,}$/); 
    let resultadoMovil = movilRex.validarRegexManual();
});

// Validar Nick en tiempo real
$('#nickname').keyup(function() {
    let nicknameRex = new validarCamposRegexManual($(this), /^[\p{L}\p{N}]{1,20}$/u); 
    let resultadoNickname = nicknameRex.validarRegexManual();
});


// Validar sexo en tiempo real
$('#sexoPersonalizado').keyup(function() {
    let sexoRex = new validarCamposRegexManual($(this), /^[\p{L}\s]{1,20}$/u); 
    let resultadoSexo = sexoRex.validarRegexManual();
});


// Validar NIF en tiempo real
$('#nif').keyup(function() {
    let NIFRex = new validarCamposRegexManual($(this), /^\d{8}[a-zA-Z]$|^[a-zA-Z]\d{8}$/); 
    let resultadoNif = NIFRex.validarRegexManual();
});


function validarDatosStep1(){

    $('#diaNacimiento, #mesNacimiento, #anioNacimiento').removeClass('is-invalid');

    // Validar Nombre
    nombreRex = new validarCamposRegexManual($('#nombre'), /^[\p{L}\s]{1,20}$/u); 
    let resultadoNombre = nombreRex.validarRegexManual();

    // Validar Sexo
    sexoRex = new validarCamposRegexManual($('#sexoPersonalizado'), /^[\p{L}\s]{1,20}$/u); 
    let resultadoSexoRex  = sexoRex.validarRegexManual();

     // Validar Nickname
     nicknameRex = new validarCamposRegexManual($('#nickname'), /^[\p{L}\p{N}]{1,20}$/u); 
     let resultadoNicknameRex  = nicknameRex.validarRegexManual();

    // Validar Apellido
    apellidoRex = new validarCamposRegexManual($('#apellido'), /^[\p{L}\s]{1,20}$/u); 
    let resultadoApellido = apellidoRex.validarRegexManual();
    
    // Validar Correo
    correoRex = new validarCamposRegexManual($('#usu_correo'), /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/); 
    let resultadoCorreo = correoRex.validarRegexManual();

    // Validar Movil
    movilRex = new validarCamposRegexManual($('#movil'), /^[\d\s\-()+]{9,}$/); 
    let resultadoMovil = movilRex.validarRegexManual();

    // Validar NIF
    NIFRex = new validarCamposRegexManual($('#nif'), /^\d{8}[a-zA-Z]$|^[a-zA-Z]\d{8}$/); 
    let resultadoNIF = NIFRex.validarRegexManual();

    if($('#opciones').val() == "0"){
        toastr["error"]('Seleccione una opción de genero.');
        return false;
    }

    var opcionSeleccionada = $('#opciones').val();

    if(opcionSeleccionada == 'personalizado'){

        opcionSexo = $('#sexoPersonalizado').val(); 

    }else{
        opcionSexo = $('#opciones').val(); 
    }

   
        
    // Verificar si los tres campos tienen un valor seleccionado
    if ($('#diaNacimiento').val() == null || $('#mesNacimiento').val() == null || $('#anioNacimiento').val() == null) {
        // Si no, añadir la clase 'is-invalid'
        $('#diaNacimiento, #mesNacimiento, #anioNacimiento').addClass('is-invalid');
        resultadoFecha = false;
    }else{
        resultadoFecha = true;
    }
    if(resultadoFecha == false || resultadoCorreo == false || resultadoApellido == false ||resultadoNombre == false ||resultadoMovil == false || resultadoNicknameRex == false || resultadoNIF == false){
        toastr["error"]('Revise los campos marcados.');

        return false;
    }else{
        return true; // Todo bien
    }

}
//////////////////////////////////////
////// 3.- ENVIAR CORREO REG ////////
////////////////////////////////////
function enviarCorreoValidacion(){
    var code1 = $('#code1').val('');
    var code2 = $('#code2').val('');
    var code3 = $('#code3').val('');
    var code4 = $('#code4').val('');
    var code5 = $('#code5').val('');

    let correo = $('#usu_correo').val();
console.log(correo);
    var numeroAleatorio = generarNumeroAleatorio(); // Numero aleatorio que se enviara por correo.
    console.log(numeroAleatorio);
    function generarNumeroAleatorio() {
        var min = 10000; // Número mínimo de 5 dígitos
        var max = 99999; // Número máximo de 5 dígitos
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    $.post("../../controller/usuario.php?op=correoValidarReg",{usu_correo:correo,numeroAleatorio:numeroAleatorio},function (data) {
        if(data == 1){
            toastr["warning"]('Revise su buzón de correo', 'Correo Enviado');
        }else{
            toastr["error"](data);
        } 
    });
    return numeroAleatorio;
}


function comprobarCodigoVerificacion(codigo){
    

    // Recoger los valores de los campos por sus IDs
    var code1 = $('#code1').val();
    var code2 = $('#code2').val();
    var code3 = $('#code3').val();
    var code4 = $('#code4').val();
    var code5 = $('#code5').val();

    // Juntar los valores en una sola variable
    var codigoInput = code1 + code2 + code3 + code4 + code5; 
    if(codigoInput == codigo){
        toastr["success"]('Correo Verificado');
        return true;
    }else{
        
        return false;
    }
   
}


///////////////////////////////////////////////////
////// 4.- Validar PASS y Crear cuenta  //////////
/////////////////////////////////////////////////
 // Validar usu_pass en tiempo real
 $('#usu_pass').keyup(function() {

    let usu_passReg = new validarCamposRegexManual($('#usu_pass'), /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\/\\])(.{8,})$/); 
    let resultadoPass = usu_passReg.validarRegexManual();
    if(resultadoPass == true){
        $('#textError').removeClass('tx-danger');
   
    }else{
        $('#textError').addClass('tx-danger');
    } 
});

function validarDatosStep4(){

    // Validar usu_pass
    let usu_passReg = new validarCamposRegexManual($('#usu_pass'), /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\/\\])(.{8,})$/); 
    let resultadoPass = usu_passReg.validarRegexManual();

    if(resultadoPass == true){
        $('#textError').removeClass('tx-danger');
        return true;
    }else{
        $('#textError').addClass('tx-danger');
        toastr["error"]('Para garantizar tu seguridad, es necesario que refuerces tu contraseña.', 'Contraseña Insegura');
        return false;
    } 

}


/////////////////////////////////////
//////// FUNCION CODIGO VALIDAR ////
  // Escuchar el evento keyup en los inputs
  $('.digit-input').keyup(function() {
         
    // Limitar la entrada a un solo dígito
    if ($(this).val().length > 1) {
        $(this).val($(this).val().charAt(0));
    }

    // Mover el foco al siguiente input
    if ($(this).val().length === 1) {
        $(this).next('.digit-input').focus();
    }
});

// Escuchar el evento paste en los inputs
$('.digit-input').on('paste', function(e) {
    // Evitar el comportamiento predeterminado del pegado
    e.preventDefault();

    // Obtener el texto pegado del portapapeles
    var pastedText = (e.originalEvent || e).clipboardData.getData('text/plain');

    // Quitar cualquier carácter que no sea un número
    var digits = pastedText.replace(/[^0-9]/g, '').split('').slice(0, 5); // Limitar a 5 dígitos
    // Permitir solo números en los inputs y actualizar en tiempo real
    $('.digit-input').on('input', function(e) {
        // Quitar cualquier carácter que no sea un número
        var inputValue = $(this).val().replace(/[^0-9]/g, '');

        // Asignar el valor limpio de nuevo al input
        $(this).val(inputValue);
    });
    // Asignar cada dígito a un input
    $('.digit-input').each(function(index) {
        var inputValue = $(this).val().replace(/[^0-9]/g, '');

        if (digits[index]) {
            $(this).val(digits[index]);
        } else {
            $(this).val('');
        }
    });

    
    // Asignar el último carácter al input actual
    $(this).val(lastChar);
});

// Permitir solo números en los inputs y actualizar en tiempo real
$('.digit-input').on('input', function(e) {
    // Quitar cualquier carácter que no sea un número
    var inputValue = $(this).val().replace(/[^0-9]/g, '');

    
    // Tomar solo el último carácter del texto pegado
    var lastChar = pastedText.charAt(pastedText.length - 1);
    // Asignar el valor limpio de nuevo al input
    $(this).val(inputValue);
});


///////////////////////////////////////////////////
////// 4.- Validar PASS y Crear cuenta  //////////
/////////////////////////////////////////////////

function crearCuenta(){

    ///////////////////
    //Recoger datos //
    /////////////////

    // Recoger datos privados //
    nombre = $('#nombre').val();
    apellido = $('#apellido').val();
    correo = $('#usu_correo').val();
    movil = $('#movil').val();

    // Fecha nacimiento
    diaNacimiento = $('#diaNacimiento').val();
    mesNacimiento = $('#mesNacimiento').val();
    anioNacimiento = $('#anioNacimiento').val();

    fechaNacimiento = anioNacimiento + '-'+ mesNacimiento + '-' + diaNacimiento; 
    // Promocionales 
    if ($('#newsletterCheck').prop('checked')) {
        newsletter = 1;
    } else {
        newsletter = 0

    }

    //Contraseña 
    password = $('#usu_pass').val();

    var opcionSeleccionada = $('#opciones').val();

    if(opcionSeleccionada == 'personalizado'){

        opcionSexo = $('#sexoPersonalizado').val(); 

    }else{
        opcionSexo = $('#opciones').val(); 
    }

    //Nickname 
    nickname = $('#nickname').val();

    //Nif
    nif = $('#nif').val();
    console.log('ENTRA EN EL JS');
    // CREACIÓN DE CUENTA //
   $.post("../../controller/usuario.php?op=registrarUsuario",{ nombre:nombre, apellido:apellido, usu_correo:correo, movil:movil, fechaNacimiento:fechaNacimiento,
     password:password, newsletter:newsletter, opcionSexo:opcionSexo, nickname:nickname, resultadoNIF:nif },function (data) {
        if(data == 1){
            descargando();
            siguiente();
            correoNewUser(correo);

            
        }else{

            descargando();

            toastr["error"]('Se ha producido un problema al crear su cuenta. Por favor, verifique los campos ingresados o intente nuevamente más tarde.');
            $('#textExit').text('');
            $('#textExit').text('Error en la creación de su cuenta.');
            $('#sucessImg').attr('src', '');
        } 
    }); 
}



function correoNewUser(correo){
$.post("../../controller/usuario.php?op=correoNewUser",{correo:correo},function (data) {

        if(data == 1){
            toastr["warning"]('Revise su buzón de correo', 'Correo Enviado');
        }else{
            toastr["error"](data);
        } 
    });
}
