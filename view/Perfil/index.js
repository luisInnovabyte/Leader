if ($("#disableAll").val() == 1) {
  $("input").prop("disabled", true);
}
function editarPass() {
  let password = $("#password_editar").val();
  $.post(
    "../../controller/usuario.php?op=cambiarContrasena",
    { pass: password },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
      toastr.success("Contraseña Cambiada");
    }
  );
}

/* $("#changePassword").on("click", function () {
  var idUsu = $("#idUsu").val();
  console.log(idUsu);
  $.post(
    "../../controller/usuario.php?op=obtenerTokenPorId",
    { idUsu: idUsu },
    function (data) {
      data = JSON.parse(data);
      let token = data[0][0];

      window.location.href = "../../view/CambiarPass?tokenidusu=" + token;
    }
  );
}); */

//Apartado de editar perfil, primero me traigo los datos del usuario a editar a traves de ID del mismo.
function clearCanvas(canvas, context) {
  var canvas = document.getElementById("signaturePadUsuario");
  var context = canvas.getContext("2d");
  context.clearRect(0, 0, canvas.width, canvas.height);
}

//esto solo se puede ejecuta si la session y la ID del usuario es la misma por seguridad (si le da problemas al admin crear excepcion para ese usuario)

/* if (idUsu == idUsuSession){ */
  $('a[href="#editarPerfil"]').on("click", function () {
    tokenUsu = $("#idUsuToken").val();
    $.post(
      "../../controller/usuario.php?op=datosUsuarioConductor",
      { tokenUsu: tokenUsu },
      function (data) {
        data = JSON.parse(data);
        console.log(data);

        // Rellenar los campos del formulario con los datos del usuario
        $("#nombreUsu").val(data[0]["nombreUsu"]);
        $("#apellidosUsu").val(data[0]["apellidosUsu"]);
        $("#movilUsu").val(data[0]["movilUsu"]);
        $("#correoUsu").val(data[0]["correoUsu"]);
        $("#ciudadPuebloUsu").val(data[0]["ciudadPuebloUsu"]);
        $("#codigoPostalUsu").val(data[0]["codigoPostalUsu"]);
        $("#fechaNacimientoUsu").val(data[0]["fechaNacimientoUsu"]);

        // Función recursiva para verificar si el canvas está disponible
        function checkCanvasAndRender() {
          const canvas = document.getElementById("signaturePadUsuario");

          const context = canvas.getContext("2d");
          clearCanvas(canvas, context);

          var img = new Image();
          img.src = data[0]["firmaTransportista_transportistasTransporte"];
          img.onload = function () {
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.drawImage(img, 0, 0, canvas.width, canvas.height);
          };
        }

        // Iniciar la verificación del canvas
        checkCanvasAndRender();
      }
    );
  });
  $("#editardatosPerfil").on("click", function () {
    tokenUsu = $("#idUsuToken").val();

    let nombreUsu = $("#nombreUsu").val();
    let apellidosUsu = $("#apellidosUsu").val();
    let movilUsu = $("#movilUsu").val();
    let correoUsu = $("#correoUsu").val();
    let ciudadPuebloUsu = $("#ciudadPuebloUsu").val();
    let codigoPostalUsu = $("#codigoPostalUsu").val();
    let fechaNacimientoUsu = $("#fechaNacimientoUsu").val();
    let fotoPerfil = $("#profilePreview").attr("src");

    var signaturePadUsuario = document.getElementById("signaturePadUsuario");

    signatureDataReceptor = signaturePadUsuario.toDataURL("image/png");
console.log('as');
    $.post(
      "../../controller/usuario.php?op=guardardatosUsuarioConductor",
      {
        tokenUsu: tokenUsu,
        nombreUsu: nombreUsu,
        apellidosUsu: apellidosUsu,
        movilUsu: movilUsu,
        correoUsu: correoUsu,
        ciudadPuebloUsu: ciudadPuebloUsu,
        codigoPostalUsu: codigoPostalUsu,
        fechaNacimientoUsu: fechaNacimientoUsu,
        signatureDataReceptor: signatureDataReceptor,
        fotoPerfil: fotoPerfil,
      },
      function (data) { 
         $("#imgFirmaGeneral").attr("src", signatureDataReceptor);

      // Mostrar mensaje de éxito
      toastr.success('Perfil editado correctamente');       
      }
    );
    var file_data = $("#profilePicture").prop("files")[0]; // Obtenemos el archivo
    if (file_data) {
      var form_data = new FormData(); // Creamos un FormData para enviar la imagen
      form_data.append("file", file_data);
      form_data.append("tokenUsu", $("#idUsuToken").val());

      $.ajax({
        url: "../../controller/usuario.php?op=actualizarImagen", // Archivo PHP donde se procesará la imagen
        type: "POST",
        data: form_data,
        contentType: false, // No procesar datos
        processData: false, // No establecer el content-type
        success: function (response) {
          toastr.success('Avatar Actualizado')

        },
        error: function () {
        },
      });
    }
  });

  $("#editardatosPerfilAdmin").on("click", function () {
    tokenUsu = $("#idUsuToken").val();

    let nombreUsu = $("#nombreUsu").val();
    let apellidosUsu = $("#apellidosUsu").val();
    let movilUsu = $("#movilUsu").val();
    let correoUsu = $("#correoUsu").val();
    let ciudadPuebloUsu = $("#ciudadPuebloUsu").val();
    let codigoPostalUsu = $("#codigoPostalUsu").val();
    let fechaNacimientoUsu = $("#fechaNacimientoUsu").val();
    let fotoPerfil = $("#profilePreview").attr("src");
console.log('object');

    signatureDataReceptor = '';
    $.post(
      "../../controller/usuario.php?op=guardardatosUsuarioConductor",
      {
        tokenUsu: tokenUsu,
        nombreUsu: nombreUsu,
        apellidosUsu: apellidosUsu,
        movilUsu: movilUsu,
        correoUsu: correoUsu,
        ciudadPuebloUsu: ciudadPuebloUsu,
        codigoPostalUsu: codigoPostalUsu,
        fechaNacimientoUsu: fechaNacimientoUsu,
        signatureDataReceptor: signatureDataReceptor,
        fotoPerfil: fotoPerfil,
      },
      function (data) {
        console.log('opasa');
        // Mostrar mensaje de éxito
        toastr.success('Perfil editado correctamente');        }
    );
    var file_data = $("#profilePicture").prop("files")[0]; // Obtenemos el archivo
    if (file_data) {
      var form_data = new FormData(); // Creamos un FormData para enviar la imagen
      form_data.append("file", file_data);
      form_data.append("tokenUsu", $("#idUsuToken").val());

      $.ajax({
        url: "../../controller/usuario.php?op=actualizarImagen", // Archivo PHP donde se procesará la imagen
        type: "POST",
        data: form_data,
        contentType: false, // No procesar datos
        processData: false, // No establecer el content-type
        success: function (response) {
        },
        error: function () {
        },
      });
    }
  });
/*  console.log(data);
        let idUsu = data[0][0];
        let correoUsu = data[0][2];
        let nombreUsu = data[0][13];
        let apellidosUsu = data[0][14];
        let fechaNacimientoUsu = data[0][15];
        let movilUsu = data[0][17];
        let codigoPostalUsu = data[0][21];
        let ciudadPuebloUsu = data[0][23];
     */
//una vez los datos ya estan cargados los cargamos en los input correspondientes
/* 
        $("#correoUsu").val(correoUsu);
        $("#nombreUsu").val(nombreUsu);
        $("#apellidosUsu").val(apellidosUsu);
        $("#fechaNacimientoUsu").val(fechaNacimientoUsu);
        $("#movilUsu").val(movilUsu);
        $("#codigoPostalUsu").val(codigoPostalUsu);
        $("#ciudadPuebloUsu").val(ciudadPuebloUsu); */

/* } else{
    window.location.href = "../Home/";
    //Crear log de registro y destruir sesiones para garantizar la seguridad
}
 */

/**********************/
/** CARGAR DATOS USU **/
/**********************/
/* $(document).ready(function() {
    // Capturamos el evento click en el elemento con id editarPerfil
    to
    $('a[href="#editarPerfil"]').on('click', function() {
        $.post(
            "../../controller/transportes.php?op=recogerConductor_x_token",
            { idViaje: idViaje },
            function (datosViaje) {
              datosViaje = JSON.parse(datosViaje);
              console.log(datosViaje);
          
              
              // ESTO TENDRIA QUE VENIR DE OTRO LDO
              $("#correoInputCliente").val(datosViaje[0]["correoCliente"]);
              $("#nombreInputCliente").val(datosViaje[0]["nombreCliente"]);
              $("#DNIinputCliente").val(datosViaje[0]["dniCliente"]);
        
            
              // Cargar la nueva firma
              var img = new Image();
              img.src = datosViaje[0]["FirmaViajeConductor"];
              img.onload = function () {
                context.clearRect(0, 0, canvas.width, canvas.height);
                context.drawImage(img, 0, 0, canvas.width, canvas.height);
              };
              
        
            }
        ); 
    });
}); */

/* FIRMA DIGITAL */
/*****************/

// Inicializa el plugin de firma
$("#fsignatureContainerUsuario").find("form").signaturePad({
  drawOnly: true,
  defaultAction: "drawIt",
  validateFields: false,
  lineWidth: 0,
  clear: "input[type=reset]",
  drawBezierCurves: true,
  lineTop: 200,
});

/*****************/
/*****************/
/*****************/

$("#profilePicture").on("change", function (event) {
  // Comprobar si realmente se ha seleccionado un archivo
  if (this.files && this.files[0]) {
    var file = this.files[0];
    // Aquí puedes realizar la lógica que necesites
    // Por ejemplo, mostrar una vista previa de la imagen
    var reader = new FileReader();
    reader.onload = function (e) {
      // Mostrar la imagen seleccionada en algún lugar del HTML
      $("#profilePreview").attr("src", e.target.result);
    };
    reader.readAsDataURL(file);
  }
});




$("#changePassword").click(function() {
    toastr.success("Revisa tu correo electrónico")
    var correoUsu = $("#correoUsu").val();
    console.log("🚀 ~ $ ~ correoUsu:", correoUsu)
    
    window.location.href = "../../view/RecuperarPass?correoUsu="+correoUsu;
    
});