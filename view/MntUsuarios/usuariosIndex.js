//**********************************************************************/
//*********************************************************************/
//********** FUNCION FILTRO Y AJAX PARA MOSTRAR DOCUMENTOS ***********/
//*******************************************************************/
//******************************************************************/

var usuarios_table = $("#usuarios_table").DataTable({
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idUsuario" },
    { name: "nomUsuario" },
    { name: "correoUsuario" },
    { name: "rolUsuario", className: "text-center" },
    { name: "estUsuario", className: "text-center" },
    { name: "informacionUsuario", className: "text-center" },
    { name: "acciones", className: "text-center" },
    { name: "ultimaConexion", className: "text-center" },
  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },

    { targets: [1], orderData: false, visible: true },

    { targets: [2], orderData: false, visible: true },

    { targets: [3], orderData: false, visible: true, className: "tx-center" },

    { targets: [4], orderData: false, visible: true },

    {
      targets: [5],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },

    {
      targets: [6],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },

    {
      targets: [7],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 2, 3, 4],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/usuario.php?op=mostrarUsuarios",
    type: "get",
    dataType: "json",
    cache: false,
    serverSide: true,
    processData: true,
    beforeSend: function () {
      // $('.submitBtn').attr("disabled","disabled");
      //$('#usuario_data').css("opacity","");
    },
    complete: function (data) {},
    error: function (e) {},
  },
}); // del DATATABLE
$("#usuarios_table")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros("usuarios_table");
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });
$("#FootNombre").on("keyup", function () {
  usuarios_table.columns(1).search(this.value).draw();
});
$("#FootCorreo").on("keyup", function () {
  usuarios_table.columns(2).search(this.value).draw();
});

$("#usuarios_table").addClass("width-100");

usuarios_table.columns([7]).visible(false);

////////////////////////////////////////////////////////////////
////////////////// DESACTIVAR USUARIO /////////////////////////
//////////////////////////////////////////////////////////////

function eliminar(idUsu) {
  swal
    .fire({
      title: "Usuario",
      text: "¿Desea desactivar el USUARIO?",
      icon: "error",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      reverseButtons: true,
      input: "text", // Tipo de input (puedes usar 'text', 'email', 'password', etc.)
      inputPlaceholder: "Escriba el motivo en caso de ser necesario", // Placeholder del input
    })
    .then((result) => {
      if (result.isConfirmed) {
        let motivo = result.value; // Obtener el valor ingresado por el usuario
        $.post(
          "../../controller/usuario.php?op=desactivarUsuario",
          { idUsu: idUsu, motivo: motivo },
          function (data) {
            $("#usuarios_table").DataTable().ajax.reload(null, false);
          }
        );

        swal.fire("Desactivado", "El Usuario se ha desactivado", "success");
      } else {
        swal.fire("Cancelado", "El usuario no se ha desactivado", "error");
      }
    });
}

////////////////////////////////////////////////////////////////
///////////////////// ACTIVAR USUARIO /////////////////////////
//////////////////////////////////////////////////////////////

function activar(idUsu) {
  swal
    .fire({
      title: "Usuario",
      text: "¿Desea activar el USUARIO?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.post(
          "../../controller/usuario.php?op=activarUsuario",
          { idUsu: idUsu },
          function (data) {
            $("#usuarios_table").DataTable().ajax.reload(null, false);
          }
        );

        swal.fire("Activado", "El Usuario se ha activado", "success");
      } else {
        swal.fire("Cancelado", "El usuario no se ha activado", "error");
      }
    });
}

//////////////////////////////////////////////////////////
//////////////// CREAR EDITAR USUARIO ///////////////////
////////////////////////////////////////////////////////

function agregarUsuario() {
  // Validar Nombre
  nombreRex = new validarCamposRegexManual(
    $("#nombreUsuario"),
    /^[\p{L}\s]{1,20}$/u
  );
  let resultadoNombre = nombreRex.validarRegexManual();

  // Validar apellidoUsuario
  apellidoUsuarioRex = new validarCamposRegexManual(
    $("#apellidoUsuario"),
    /^[\p{L}\s]{1,20}$/u
  );
  let resultadoApellidoUsuario = apellidoUsuarioRex.validarRegexManual();

  // Validar Correo
  correoRex = new validarCamposRegexManual(
    $("#correoUsuario"),
    /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
  );
  let resultadoCorreo = correoRex.validarRegexManual();

  // Validar Movil
  movilRex = new validarCamposRegexManual(
    $("#movilUsuario"),
    /^[\d\s\-()+]{9,}$/
  );
  let resultadoMovil = movilRex.validarRegexManual();

  // Validar usu_pass
  let usu_passReg = new validarCamposRegexManual(
    $("#passUsuario"),
    /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\/\\])(.{8,})$/
  );

  let resultadoPass = usu_passReg.validarRegexManual();

  // Validar usu_pass_confirm
  let usu_pass_confirmReg = new validarCamposRegexManual(
    $("#passUsuarioConfirm"),
    /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\/\\])(.{8,})$/
  );
  let resultadoPassConfirm = usu_pass_confirmReg.validarRegexManual();

  if ($("#opciones").val() == "0") {
    toastr["error"]("Seleccione una opción de genero.");
    return false;
  }
  if ($("#rolUser").val() == "0") {
    toastr["error"]("Seleccione un rol.");
    return false;
  }

  if (
    resultadoNombre === false ||
    resultadoApellidoUsuario === false ||
    resultadoCorreo === false ||
    resultadoMovil === false ||
    resultadoPass === false ||
    resultadoPassConfirm === false
  ) {
    toastr.warning("Alguno de los campos no cumple con los requisitos.");
  } else {
    nombreUsuario = $("#nombreUsuario").val();
    apellidoUsuario = $("#apellidoUsuario").val();
    correoUsuario = $("#correoUsuario").val();
    movilUsuario = $("#movilUsuario").val();
    passUsuario = $("#passUsuario").val();
    passUsuarioConfirm = $("#passUsuarioConfirm").val();

    opcionSeleccionada = $("#opciones").val();

    if (opcionSeleccionada == "personalizado") {
      opcionSexo = $("#sexoPersonalizado").val();
    } else {
      opcionSexo = $("#opciones").val();
    }

    rolUsuario = $("#rolUsuario").val();
    nickUsu = $("#nickname").val();

    // Fecha nacimiento
    diaNacimiento = $("#diaNacimiento").val();
    mesNacimiento = $("#mesNacimiento").val();
    anioNacimiento = $("#anioNacimiento").val();

    fechaNacimiento =
      anioNacimiento + "-" + mesNacimiento + "-" + diaNacimiento;

    // Promocionales
    if ($("#newsletterCheck").prop("checked")) {
      newsletter = 1;
    } else {
      newsletter = 0;
    }

    if (passUsuario != passUsuarioConfirm) {
      toastr["error"]("¡Las contraseñas no coinciden!");
    } else {
      $.post(
        "../../controller/usuario.php?op=comprobarCorreo",
        { correoUsuario: correoUsuario },
        function (data) {
          if (data == 1) {
            // SI DA 1, SIGNIFICA QUE HAY DATOS = HAY CORREO CREADO
            $("#correoUsuario").addClass("is-invalid");

            toastr["error"](
              "El correo proporcionado ya se encuentra registrado."
            ); // Existe correo - Error personalizado
          } else {
            $.post(
              "../../controller/usuario.php?op=insertarUsuario",
              {
                nombreUsuario: nombreUsuario,
                apellidoUsuario: apellidoUsuario,
                correoUsuario: correoUsuario,
                movilUsuario: movilUsuario,
                passUsuario: passUsuario,
                rolUsuario: rolUsuario,
                generoUsuario: opcionSexo,
                fechaNacimiento: fechaNacimiento,
                newsletter: newsletter,
                nickUsu: nickUsu
              },
              function (data) {
                console.log(data);
                if (data != true) {
                  toastr["error"](data); // Existe correo - Error personalizado
                } else {
                  $("#nombreUsuario").val("");
                  $("#apellidoUsuario").val("");
                  $("#correoUsuario").val("");
                  $("#movilUsuario").val("");
                  $("#passUsuario").val("");
                  $("#passUsuarioConfirm").val("");

                  $("#nickname").val("");
                  // Cierra el modal con el ID "agregar-usuario-modal"
                  $("#agregar-usuario-modal").modal("hide");
                  $("#usuarios_table").DataTable().ajax.reload(null, false);
                  toastr["success"]("¡Usuario creado correctamente!");
                }
              }
            );
          }
        }
      );
    }
  }
}

//////////////////////////////////////////////////////////
/////////////////////  EDITAR USUARIO ///////////////////
////////////////////////////////////////////////////////

function cargarUsuario(idUsuario) {
  $.post(
    "../../controller/usuario.php?op=obtenerUsuarioPorId",
    { idUsuario: idUsuario },
    function (data) {
      var data = JSON.parse(data);

      $("#idUsuarioHidden").val(data[0].idUsu);

      $("#nombreUsuarioE").val(data[0].nombreUsu);
      $("#apellidoUsuarioE").val(data[0].apellidosUsu);
      $("#correoUsuarioE").val(data[0].correoUsu);
      $("#movilUsuarioE").val(data[0].movilUsu);
      $("#nicknameE").val(data[0].nickUsu);
      $("#opcionesE").val(data[0].generoUsu);
      $("#rolUsuarioE").val(data[0].rolUsu);


    }
  );
}

function editarUsuario() {
  idUsuario = $("#idUsuarioHidden").val();

   // Validar Nombre
   nombreRex = new validarCamposRegexManual(
    $("#nombreUsuarioE"),
    /^[\p{L}\s]{1,20}$/u
  );
  let resultadoNombreE = nombreRex.validarRegexManual();

  // Validar apellidoUsuario
  apellidoUsuarioRex = new validarCamposRegexManual(
    $("#apellidoUsuarioE"),
    /^[\p{L}\s]{1,20}$/u
  );
  let resultadoApellidoUsuarioE = apellidoUsuarioRex.validarRegexManual();

  // Validar Correo
  correoRex = new validarCamposRegexManual(
    $("#correoUsuarioE"),
    /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
  );
  let resultadoCorreoE = correoRex.validarRegexManual();

  // Validar Movil
  movilRex = new validarCamposRegexManual(
    $("#movilUsuarioE"),
    /^[\d\s\-()+]{9,}$/
  );
  let resultadoMovilE = movilRex.validarRegexManual();

 
  if ($("#opcionesE").val() == "0") {
    toastr["error"]("Seleccione una opción de genero.");
    return false;
  }
  if ($("#rolUserE").val() == "0") {
    toastr["error"]("Seleccione un rol.");
    return false;
  }

  if (
    resultadoNombreE === false ||
    resultadoApellidoUsuarioE === false ||
    resultadoCorreoE === false ||
    resultadoMovilE === false
  ) {
    toastr.warning("Alguno de los campos no cumple con los requisitos.");
  } else {
    
    nombreUsuarioE = $("#nombreUsuarioE").val();
    apellidoUsuarioE = $("#apellidoUsuarioE").val();
    correoUsuarioE = $("#correoUsuarioE").val();
    movilUsuarioE = $("#movilUsuarioE").val();
    nickUsuE = $("#nicknameE").val();
    opcionSeleccionadaE = $("#opcionesE").val();

    if (opcionSeleccionadaE == "personalizado") {
      opcionSexoE = $("#sexoPersonalizadoE").val();
    } else {
      opcionSexoE = $("#opcionesE").val();
    }
 // Fecha nacimiento
 diaNacimientoE = $("#diaNacimientoE").val();
 mesNacimientoE = $("#mesNacimientoE").val();
 anioNacimientoE = $("#anioNacimientoE").val();

 fechaNacimientoE =
   anioNacimientoE + "-" + mesNacimientoE + "-" + diaNacimientoE;

   rolUsuarioE = $("#rolUsuarioE").val();


    // Promocionales
    if ($("#newsletterCheckE").prop("checked")) {
      newsletterE = 1;
    } else {
      newsletterE = 0;
    }


    passUsuarioE = $("#passUsuarioE").val();
    passUsuarioConfirmE = $("#passUsuarioConfirmE").val();
    

    $.post(
      "../../controller/usuario.php?op=comprobarCorreoEditar",
      { idUsu: idUsuario, correoUsuarioE: correoUsuarioE },
      function (data) {
        if (data == 1) {
          // SI DA 1, SIGNIFICA QUE HAY DATOS = HAY CORREO CREADO
          $("#correoUsuarioE").removeClass("is-invalid");

          $.post(
            "../../controller/usuario.php?op=updateUsuario",
            {
              idUsuario: idUsuario,
              nombreUsuario: nombreUsuarioE,
              apellidoUsuario: apellidoUsuarioE,
              correoUsuario: correoUsuarioE,
              movilUsuario: movilUsuarioE,
              rolUsuario: rolUsuarioE,
              generoUsuario: opcionSexoE,
              fechaNacimiento: fechaNacimientoE,
              newsletter: newsletterE,
              nickUsu: nickUsuE
            },
            function (data) {
              if (data != true) {
                toastr["error"](data); // Existe correo - Error personalizado
              } else {
                // Cierra el modal con el ID "agregar-usuario-modal"
                $("#editar-usuario-modal").modal("hide");

                $("#usuarios_table").DataTable().ajax.reload(null, false);

                toastr["success"]("¡Usuario actualizado correctamente!");
              }
            }
          );
        } else {
          $("#correoUsuarioE").addClass("is-invalid");

          toastr["error"](
            "El correo proporcionado ya se encuentra registrado."
          ); // Existe correo - Error personalizado
        }
      }
    );
  }
}

///////////////////////////////////////////////////
/////////// INFORMACIÓN USUARIO //////////////////
/////////////////////////////////////////////////

function cargarInformacion(idUsuario) {
  $.post(
    "../../controller/usuario.php?op=obtenerUsuarioPorId",
    { idUsuario: idUsuario },
    function (data) {
      var data = JSON.parse(data);

      let nickUsu = data[0].nickUsu;
      if (nickUsu != null && nickUsu !== "") {
        $("#divNickname").removeClass("d-none");
        $("#nickUsu").text(nickUsu);
      } else {
        $("#divNickname").addClass("d-none");
      }

      let nombreUsu = data[0].nombreUsu;
      if (nombreUsu != null && nombreUsu !== "") {
        $("#divNombre").removeClass("d-none");
        $("#nombreUsu").text(nombreUsu);
      } else {
        $("#divNombre").addClass("d-none");
      }

      let apellidoUsuariosUsu = data[0].apellidoUsuariosUsu;
      if (apellidoUsuariosUsu != null && apellidoUsuariosUsu !== "") {
        $("#divapellidoUsuarios").removeClass("d-none");
        $("#apellidoUsuariosUsu").text(apellidoUsuariosUsu);
      } else {
        $("#divapellidoUsuarios").addClass("d-none");
      }

      let correoUsu = data[0].correoUsu;
      if (correoUsu != null && correoUsu !== "") {
        $("#divCorreo").removeClass("d-none");
        $("#correoUsu").text(correoUsu);
      } else {
        $("#divCorreo").addClass("d-none");
      }

      let movilUsu = data[0].movilUsu;
      if (movilUsu != null && movilUsu !== "") {
        $("#divMovil").removeClass("d-none");
        $("#movilUsu").text(movilUsu);
      } else {
        $("#divMovil").addClass("d-none");
      }

      let fechaNacimientoUsu = data[0].fechaNacimientoUsu;
      if (fechaNacimientoUsu != null && fechaNacimientoUsu !== "") {
        $("#divFechaNacimientoUsu").removeClass("d-none");
        $("#fechaNacimientoUsu").text(
          convertirFormatoFecha(fechaNacimientoUsu)
        );
      } else {
        $("#divFechaNacimientoUsu").addClass("d-none");
      }

      let razonSocialFacturacionUsu = data[0].razonSocialFacturacionUsu;
      if (
        razonSocialFacturacionUsu != null &&
        razonSocialFacturacionUsu !== ""
      ) {
        $("#divRazonSocialFacturacionUsu").removeClass("d-none");
        $("#razonSocialFacturacionUsu").text(razonSocialFacturacionUsu);
      } else {
        $("#divRazonSocialFacturacionUsu").addClass("d-none");
      }

      let identificacionFiscalUsu = data[0].identificacionFiscalUsu;
      if (identificacionFiscalUsu != null && identificacionFiscalUsu !== "") {
        $("#divIdentificacionFiscalUsu").removeClass("d-none");
        $("#identificacionFiscalUsu").text(identificacionFiscalUsu);
      } else {
        $("#divIdentificacionFiscalUsu").addClass("d-none");
      }

      let direccionFacturacionUsu = data[0].direccionFacturacionUsu;
      if (direccionFacturacionUsu != null && direccionFacturacionUsu !== "") {
        $("#divDireccionFiscalUsu").removeClass("d-none");
        $("#direccionFacturacionUsu").text(
          direccionFacturacionUsu +
            ", " +
            data[0].codigoPostalUsu +
            ", " +
            data[0].provinciaUsu +
            ", " +
            data[0].ciudadPuebloUsu
        );
        $("#conDatosFacturacion").removeClass("tx-danger");
      } else {
        $("#conDatosFacturacion").addClass("tx-danger");

        $("#divDireccionFiscalUsu").addClass("d-none");
      }

      let idUsu = data[0].idUsu;
      if (idUsu != null && idUsu !== "") {
        $("#divEstUsu").removeClass("d-none");
        $("#idUsu").html(
          '<span class="label label-primary">' + idUsu + "</label>"
        );
      } else {
        $("#divEstUsu").addClass("d-none");
      }

      let estUsu = data[0].estUsu;

      if (estUsu != null && estUsu !== "0") {
        $("#estUsu").html('<span class="label label-success">Activo</span>');
      } else {
        $("#estUsu").html('<span class="label label-danger">Inactivo</span>');
      }

      let fechaAltaUsu = data[0].fecAltaUsu;
      if (fechaAltaUsu != null && fechaAltaUsu !== "") {
        $("#divFechaAltaUsu").removeClass("d-none");
        $("#fechaAltaUsu").text(convertirFormatoFechaHora(fechaAltaUsu));
      } else {
        $("#divFechaAltaUsu").addClass("d-none");
      }

      let fechaBajaUsu = data[0].fecBajaUsu;
      if (fechaBajaUsu != null && fechaBajaUsu !== "") {
        $("#divFechaBajaUsu").removeClass("d-none");
        $("#fechaBajaUsu").text(convertirFormatoFechaHora(fechaBajaUsu));
      } else {
        $("#divFechaBajaUsu").addClass("d-none");
      }

      let fechaModiUsu = data[0].fecModiUsu;
      if (fechaModiUsu != null && fechaModiUsu !== "") {
        $("#divModiUsu").removeClass("d-none");
        $("#fechaModiUsu").text(convertirFormatoFechaHora(fechaModiUsu));
      } else {
        $("#divModiUsu").addClass("d-none");
      }

      let motivoBajaUsu = data[0].motivoBajaUsu;
      if (motivoBajaUsu != null && motivoBajaUsu !== "") {
        $("#divMotivoBajaUsu").removeClass("d-none");
        $("#motivoBajaUsu").text(motivoBajaUsu);
      } else {
        $("#divMotivoBajaUsu").addClass("d-none");
      }

      let recibirNotificacionesUsu = data[0].recibirNotificacionesUsu;
      if (recibirNotificacionesUsu != null && recibirNotificacionesUsu !== "") {
        $("#recibirNotificacionesUsu").html(
          '<label class="label label-rounded label-info">Si</label>'
        );
      } else {
        $("#recibirNotificacionesUsu").html(
          '<label class="label label-rounded label-danger">No</label>'
        );
      }

      let registroInicioSesionUsu = data[0].registroInicioSesionUsu;
      if (registroInicioSesionUsu != null && registroInicioSesionUsu !== "0") {
        $("#registroInicioSesionUsu").text(
          convertirFormatoFecha(registroInicioSesionUsu)
        );
      } else {
        $("#divRegistroInicioSesionUsu").addClass("d-none");
      }

      let accesoPrivadoUsu = data[0].accesoPrivadoUsu;
      if (accesoPrivadoUsu != null && accesoPrivadoUsu !== "0") {
        $("#accesoPrivadoUsu").html(
          '<label class="label label-rounded label-info">Si</label>'
        );
      } else {
        $("#accesoPrivadoUsu").html(
          '<label class="label label-rounded label-danger">No</label>'
        );
      }

      let registroUsu = data[0].registroUsu;

      if (registroUsu != null && registroUsu !== "0") {
        $("#registroUsu").html(
          '<label class="label label-rounded label-info">Si</label>'
        );
      } else {
        $("#registroUsu").html(
          '<label class="label label-rounded label-danger">No</label>'
        );
      }
    }
  );
}

//////////////////////////////////////
///////// 1.- VALIDACIÓN ////////////
////////////////////////////////////
// Validar Nombre en tiempo real
$("#nombreUsuario").keyup(function () {
  let nombreUsuario = $(this).val();
  let nombreRex = new validarCamposRegexManual($(this), /^[\p{L}\s]{1,20}$/u);
  let resultadoNombre = nombreRex.validarRegexManual();
});

// Validar apellidoUsuario en tiempo real
$("#apellidoUsuario").keyup(function () {
  let apellidoUsuario = $(this).val();
  let apellidoUsuarioRex = new validarCamposRegexManual(
    $(this),
    /^[\p{L}\s]{1,20}$/u
  );
  let resultadoapellidoUsuario = apellidoUsuarioRex.validarRegexManual();
});

// Validar Correo en tiempo real
$("#correoUsuario").keyup(function () {
  let correoRex = new validarCamposRegexManual(
    $(this),
    /^[a-zA-ZñÑ0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
  );
  let resultadoCorreo = correoRex.validarRegexManual();
});

// Validar movilUsuario en tiempo real
$("#movilUsuario").keyup(function () {
  let movilRex = new validarCamposRegexManual($(this), /^[\d\s\-()+]{9,}$/);
  let resultadoMovil = movilRex.validarRegexManual();
});

// Validar Nick en tiempo real
$("#nickname").keyup(function () {
  let nicknameRex = new validarCamposRegexManual(
    $(this),
    /^[\p{L}\p{N}]{1,20}$/u
  );
  let resultadoNickname = nicknameRex.validarRegexManual();
});

// Validar sexo en tiempo real
$("#sexoPersonalizado").keyup(function () {
  let sexoRex = new validarCamposRegexManual($(this), /^[\p{L}\s]{1,20}$/u);
  let resultadoSexo = sexoRex.validarRegexManual();
});

// Validar NIF en tiempo real
$("#nif").keyup(function () {
  let NIFRex = new validarCamposRegexManual(
    $(this),
    /^\d{8}[a-zA-Z]$|^[a-zA-Z]\d{8}$/
  );
  let resultadoNif = NIFRex.validarRegexManual();
});

///////////////////////////////
////////GESTION DE LOS INPUTS PASSWORD Y DE EL CAMPO DE GENERO PERSONALIZADO/////////////
/////////////////////////////////
// Agrega un evento change al elemento select
$("#opciones").change(function () {
  // Obtiene el valor seleccionado
  var opcionSeleccionada = $(this).val();
  // Verifica si la opción seleccionada es 'personalizado'
  if (opcionSeleccionada === "personalizado") {
    // Si es 'personalizado', quita la clase d-none
    $("#sexoPersonalizadoDiv").removeClass("d-none");
  } else {
    // Si no es 'personalizado', agrega la clase d-none
    $("#sexoPersonalizadoDiv").addClass("d-none");
  }
});

const passwordInput = document.getElementById("passUsuario");
const passwordInputConfirm = document.getElementById("passUsuarioConfirm");
const toggleButtonPassword = document.getElementById("ver_password");
const toggleButtonPasswordConfirm = document.getElementById(
  "ver_password_confirm"
);
//const eyeIcon = document.getElementById("iconoInput");
//const eyeIconConfirm = document.getElementById("iconoInputConfirm");

//Boton de ver contraseña input password
toggleButtonPassword.addEventListener("click", function () {
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    $("#iconoInput").removeClass("fa-eye");
    $("#iconoInput").addClass("fa-eye-slash");

    //eyeIcon.classList.remove("fa-eye");
    //eyeIcon.classList.add("fa-eye-slash");
  } else {
    passwordInput.type = "password";
    $("#iconoInput").removeClass("fa-eye-slash");
    $("#iconoInput").addClass("fa-eye");

    //eyeIcon.classList.remove("fa-eye-slash");
    //eyeIcon.classList.add("fa-eye");
  }
});
//Boton de ver contraseña input passwordConfirm

toggleButtonPasswordConfirm.addEventListener("click", function () {
  console.log("asdsaddasdsad");

  if (passwordInputConfirm.type === "password") {
    passwordInputConfirm.type = "text";
    //eyeIconConfirm.classList.remove("fa-eye");
    //eyeIconConfirm.classList.add("fa-eye-slash");
    $("#iconoInputConfirm").removeClass("fa-eye");
    $("#iconoInputConfirm").addClass("fa-eye-slash");
  } else {
    passwordInputConfirm.type = "password";
    $("#iconoInputConfirm").removeClass("fa-eye-slash");
    $("#iconoInputConfirm").addClass("fa-eye");
    //eyeIconConfirm.classList.remove("fa-eye-slash");
    //eyeIconConfirm.classList.add("fa-eye");
  }
});
