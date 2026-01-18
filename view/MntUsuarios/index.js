//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "usuarios_table"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "usuario.php"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "agregar-usuarios-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-usuarios-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var rolSeleccionado = 0;
//* ******* **** ******* ** ***** ** ***** ** ** ********* *////* ******* **** ******* ** ***** ** ***** ** ** ********* *//
//* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
//* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
//* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
//* ******* **** ******* ** ***** ** ***** ** ** ********* *////* ******* **** ******* ** ***** ** ***** ** ** ********* *//

var isDark = isColorDark("#000000"); //? TRUE SI EL COLOR ES OSCURO FALSE SI ES CLARO

var colorLetra = "black";

//* ********** *////* ********** *////* ********** *////* ********** *////* ********** *////* ********** *//
//* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
//* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
//* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
//* ********** *////* ********** *////* ********** *////* ********** *////* ********** *////* ********** *//

var usuarios_table = $("#usuarios_table").DataTable({
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idUsuario" },
    { name: "nomUsuario" },
    { name: "correoUsuario" },
    { name: "idTrnasportista" },
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

    { targets: [3], orderData: false, visible: true },

    { targets: [4], orderData: false, visible: true, className: "tx-center" },

    { targets: [5], orderData: false, visible: true },

    {
      targets: [6],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },

    {
      targets: [7],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },

    {
      targets: [8],
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

    url: "../../controller/" + phpPrincipal + "?op=mostrarUsuarios",
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

usuarios_table.columns([7]).visible(true);

//////////////////////////////////////
///////////////////////////////////////
//////////////////////////////////////

function cargarInformacion(idUsuario, numRol) {
  if (numRol == 0) {
    $("#informacion-usuario-modal")
      .find(".infoCard")
      .addClass("border-primary");
    $("#informacion-usuario-modal")
      .find(".imgPrincipal")
      .css("border","3px solid").addClass("border-primary");
  } else if (numRol == 1) {
    $("#informacion-usuario-modal").find(".infoCard").addClass("border-info-subtle");
    $("#informacion-usuario-modal").find(".imgPrincipal").css("border","3px solid").addClass("border-info");
  } else {
    $("#informacion-usuario-modal").find(".infoCard").addClass("border-danger");
    $("#informacion-usuario-modal").find(".imgPrincipal").css("border","3px solid").addClass("border-danger");
  }
  $.post(
    "../../controller/" + phpPrincipal + "?op=obtenerUsuarioPorId", //! NO TOCAR
    { idUsuario: idUsuario }, //! NO TOCAR
    function (data) {
      //? RECOGER DATOS DE LA BASE DE DATOS
      data = JSON.parse(data);

      //TODO: CARGAR TANTOS CAMPOS COMO SEA NECESARIOS
      $("#nickUsu").text(data[0]["nickUsu"]);
      $("#nombreUsu").text(data[0]["nombreUsu"] + " " + data[0]["apellidosUsu"]);
      $("#fijoUsu").text(data[0]["telefonoUsu"]);
      $("#movilUsu").text(data[0]["movilUsu"]);
      $("#correoUsu").text(data[0]["correoUsu"]);
      $("#dirUsu").text(data[0]["direccionFacturacionUsu"]);
      $(".imgPrincipal").attr("src","../../public/assets/images/users/"+data[0]["avatarUsu"]);
      if(data[0]["estUsu"] == 1){
        $("#estUsu").html("<label class='badge bg-success tx-14'>ACTIVO</label>")
      } else {
        $("#estUsu").html("<label class='badge bg-secondary tx-14'>INACTIVO</label>")
      }
    }
  );
  $("#informacion-usuario-modal").modal("show");
}
$("#informacion-usuario-modal").on("hidden.bs.modal", function () {
  // Código a ejecutar cuando el modal se cierra
  $("#informacion-usuario-modal")
    .find(".infoCard")
    .removeClass("border-primary");
  $("#informacion-usuario-modal")
    .find(".imgPrincipal")
    .removeClass("bg-primary");

  $("#informacion-usuario-modal").find(".infoCard").removeClass("border-info");
  $("#informacion-usuario-modal").find(".imgPrincipal").removeClass("bg-info");

  $("#informacion-usuario-modal")
    .find(".infoCard")
    .removeClass("border-danger");
  $("#informacion-usuario-modal")
    .find(".imgPrincipal")
    .removeClass("bg-danger");
});
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

function agregarElemento() {
  //! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  let nickUsuario = $("#nickUsuario").val();
  let nombreUsuario = $("#nombreUsuario").val();
  let apeUsuario = $("#apeUsuario").val();
  let fechUsuario = $("#fechUsuario").val();
  let fijoUsuario = $("#fijoUsuario").val();
  let movilUsuario = $("#movilUsuario").val();
  let correoUsuario = $("#correoUsuario").val();
  let passUsuario = $("#passUsuario").val();
  let paisUsuario = $("#paisUsuario").val();
  let provUsuario = $("#provUsuario").val();
  let cityUsuario = $("#cityUsuario").val();
  let cpUsuario = $("#cpUsuario").val();
  let dirUsuario = $("#dirUsuario").val();
  let dniUsuario = $("#dniUsuario").val();

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE
    $.post(
      "../../controller/" + phpPrincipal + "?op=insertarUsuario", //! NO TOCAR
      {
        nickUsuario: nickUsuario,
        nombreUsuario: nombreUsuario,
        apeUsuario: apeUsuario,
        fechUsuario: fechUsuario,
        fijoUsuario: fijoUsuario,
        movilUsuario: movilUsuario,
        correoUsuario: correoUsuario,
        passUsuario: passUsuario,
        paisUsuario: paisUsuario,
        provUsuario: provUsuario,
        cityUsuario: cityUsuario,
        cpUsuario: cpUsuario,
        dirUsuario: dirUsuario,
        rolSeleccionado: rolSeleccionado,
        dniUsuario: dniUsuario,
      }, //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
      function (data) {
        if(data == 1 ){
          //? AGREGAR ELEMENTO
          $("#" + idModalAgregar + "").modal("hide"); //! NO TOCAR
          toastr.success("Acción Agregada."); //TODO: MODIFICAR MENSAJE DE SUCCESS
          $("#" + idDatatables + "")
            .DataTable()
            .ajax.reload(); //! NO TOCAR
        } else if (data == "Ya existe un usuario con el mismo nick"){
          toastr.error("Ya existe un usuario con el mismo nick.")
        } else if(data == "Ya existe un usuario con el mismo correo"){
          toastr.error("Ya existe un usuario con el mismo correo.")

        } else {
          
          toastr.error("Ha habido un error.")
        }
      }
    );
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//

function cargarUsuario(idUsuario) {
  //! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID
  $.post(
    "../../controller/" + phpPrincipal + "?op=obtenerUsuarioPorId", //! NO TOCAR
    { idUsuario: idUsuario }, //! NO TOCAR
    function (data) {
      //? RECOGER DATOS DE LA BASE DE DATOS
      data = JSON.parse(data);

      //TODO: CARGAR TANTOS CAMPOS COMO SEA NECESARIOS
      $("#nickUsuarioE").val(data[0]["nickUsu"]);
      $("#nombreUsuarioE").val(data[0]["nombreUsu"]);
      $("#apeUsuarioE").val(data[0]["apellidosUsu"]);
      $("#fechUsuarioE").val(data[0]["fechaNacimientoUsu"]);
      $("#dniUsuarioE").val(data[0]["identificacionFiscalUsu"]);
      $("#fijoUsuarioE").val(data[0]["telefonoUsu"]);
      $("#movilUsuarioE").val(data[0]["movilUsu"]);
      $("#correoUsuarioE").val(data[0]["correoUsu"]);
      /* $("#passUsuarioE").val(data[0][""]); */
      $("#paisUsuarioE").val(data[0]["paisUsu"]);
      $("#provUsuarioE").val(data[0]["provinciaUsu"]);
      $("#cityUsuarioE").val(data[0]["ciudadPuebloUsu"]);
      $("#cpUsuarioE").val(data[0]["codigoPostalUsu"]);
      $("#dirUsuarioE").val(data[0]["direccionFacturacionUsu"]);
      if (data[0]["rolUsu"] === "0") {
        rolSeleccionado = 0;
        $("#rolSeleccionadoE").text("Usuario");

        $("#rolSeleccionadoE").removeClass("bg-cyan").addClass("bg-primary");
      } else {
        rolSeleccionado = 1;
        $("#rolSeleccionadoE").text("Administrador");
        $("#rolSeleccionadoE").removeClass("bg-primary").addClass("bg-cyan");
      }

      $("#editando").text(data[0]["nickUsu"]);
      $("#hiddenid").val(data[0]["idUsu"]);

      $("#" + idModalEditar + "").modal("show"); //! NO TOCAR
    }
  );
}

function editarElemento() {
  //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO
  let idElemento = $("#hiddenid").val(); //! NO TOCAR

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  let nickUsuario = $("#nickUsuarioE").val();
  let nombreUsuario = $("#nombreUsuarioE").val();
  let apeUsuario = $("#apeUsuarioE").val();
  let fechUsuario = $("#fechUsuarioE").val();
  let dniUsuario = $("#dniUsuarioE").val();
  let fijoUsuario = $("#fijoUsuarioE").val();
  let movilUsuario = $("#movilUsuarioE").val();
  let correoUsuario = $("#correoUsuarioE").val();
  let passUsuario = $("#passUsuarioE").val(); //*OPCIONAL
  let paisUsuario = $("#paisUsuarioE").val();
  let provUsuario = $("#provUsuarioE").val();
  let cityUsuario = $("#cityUsuarioE").val();
  let cpUsuario = $("#cpUsuarioE").val();
  let dirUsuario = $("#dirUsuarioE").val();

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    $.post(
      "../../controller/" + phpPrincipal + "?op=updateUsuario", //! NO TOCAR
      {
        nickUsuario: nickUsuario,
        nombreUsuario: nombreUsuario,
        apeUsuario: apeUsuario,
        fechUsuario: fechUsuario,
        dniUsuario: dniUsuario,
        fijoUsuario: fijoUsuario,
        movilUsuario: movilUsuario,
        correoUsuario: correoUsuario,
        passUsuario: passUsuario,
        paisUsuario: paisUsuario,
        provUsuario: provUsuario,
        cityUsuario: cityUsuario,
        cpUsuario: cpUsuario,
        dirUsuario: dirUsuario,
        idElemento: idElemento,
        rolSeleccionado: rolSeleccionado,
      }, //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
      function (data) {
        //? GUARDAR CAMBIOS

        $("#" + idModalEditar + "").modal("hide"); //! NO TOCAR
        toastr.success("Acción Editada."); //TODO: MODIFICAR MENSAJE DE SUCCESS
        $("#" + idDatatables + "")
          .DataTable()
          .ajax.reload(); //! NO TOCAR
      }
    );
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//

function cambiarEstado(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/" + phpPrincipal + "?op=cambiarEstado", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //! NO TOCAR
      $("#" + idDatatables + "")
        .DataTable()
        .ajax.reload(); //! NO TOCAR
    }
  );
}

//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//

$("#" + idModalAgregar + "").on("show.bs.modal", function () {
  //! NO TOCAR
  //? FUNCION QUE SE EJECUTA ANTES DE ABRIR EL MODAL DE AGREGAR
  limpiarModalInputs(); //? LIMPIAR TODOS LOS INPUTS DE UN MODAL Y LAS CLASES IS-VALID E IS-INVALID
});

//* ** ********* *//
//* JS ADICIONAL *//
//* JS ADICIONAL *//
//* JS ADICIONAL *//
//* ** ********* *//

$("#usuarioBtn").click(function () {
  rolSeleccionado = 0;
  $("#rolSeleccionado").text("Usuario");

  $("#rolSeleccionado").removeClass("bg-cyan").addClass("bg-primary");
});

$("#adminBtn").click(function () {
  rolSeleccionado = 1;
  $("#rolSeleccionado").text("Administrador");
  $("#rolSeleccionado").removeClass("bg-primary").addClass("bg-cyan");
});
$("#usuarioBtnE").click(function () {
  rolSeleccionado = 0;
  $("#rolSeleccionadoE").text("Usuario");

  $("#rolSeleccionadoE").removeClass("bg-cyan").addClass("bg-primary");
});

$("#adminBtnE").click(function () {
  rolSeleccionado = 1;
  $("#rolSeleccionadoE").text("Administrador");
  $("#rolSeleccionadoE").removeClass("bg-primary").addClass("bg-cyan");
});



