///////////////////////////////////
//////////////////////////////////
/////////////////////////////////

var codigo; // Declaarado a nivel superior para que esté disponible en todo el código


//Cuando pulso boton de enviar entonces ejecuta el siguiente codigo

let btnEnviarConfirmacion = $("#btnEnviarConfirmacion");
let btnConfirmarCodigo = $("#btnEnviarCodigo");
let enviarMailInput = $("#emailInput")
let verificacionCodigo = $("#modalVerification");

btnEnviarConfirmacion.click(function() {
    let correo = $('#email_recuperar').val();

    $.post("../../controller/usuario.php?op=comprobarCorreo",{usu_correo:correo},function (data) {

        if(data == 1){ // SI DA 1, SIGNIFICA QUE HAY DATOS = HAY CORREO CREADO
          $('#usu_correo').addClass('is-invalid');
          actualizar();

        }else{
            toastr["error"]('El correo proporcionado no se encuentra registrado.');
        }
    });
});

btnConfirmarCodigo.click(function() {
    let validado = comprobarCodigoVerificacion(codigo);
    var correoUsu = $("#email_recuperar").val();
    console.log(correoUsu);
    if (validado === true) {
        $.post("../../controller/usuario.php?op=getTokenByCorreo",{correoUsu:correoUsu},function (data) {

            data = JSON.parse(data);
            let token = data[0][0];
            
                window.location.href = "../../view/CambiarPass?tokenidusu="+token;
        });

    } else {
        toastr["error"]('Código verificación erróneo');
    }
});


function actualizar(){
    codigo = enviarCorreoValidacion();
}


function enviarCorreoValidacion(){
    var code1 = $('#code1').val('');
    var code2 = $('#code2').val('');
    var code3 = $('#code3').val('');
    var code4 = $('#code4').val('');
    var code5 = $('#code5').val('');

    let correo = $('#email_recuperar').val();
    var numeroAleatorio = generarNumeroAleatorio(); // Numero aleatorio que se enviara por correo.
    console.log(numeroAleatorio);
    function generarNumeroAleatorio() {
        var min = 10000; // Número mínimo de 5 dígitos
        var max = 99999; // Número máximo de 5 dígitos
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    

    $.post("../../controller/usuario.php?op=correoValidarCambioPass",{usu_correo:correo,numeroAleatorio:numeroAleatorio},function (data) {
        if(data == 1){
            toastr["warning"]('Revise su buzón de correo', 'Correo Enviado');

// Ocultar el campo de entrada del correo electrónico y mostrar el modal de verificación del código
            enviarMailInput.addClass('d-none');
            verificacionCodigo.show();


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

if($("#getCorreo").val() != ""){
    console.log($("#getCorreo").val());
    $("#email_recuperar").val($("#getCorreo").val());
    $("#btnEnviarConfirmacion").trigger('click');
}