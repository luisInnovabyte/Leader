//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "conductores_table" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "conductores.php" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "agregar-clientes-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-clientes-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
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

var conductores_table =  $("#"+idDatatables+"").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idCliente" },
    { name: "nombreCliente", className: "text-center"},
    { name: "tipoCliente", className: "text-center"},
    { name: "tefCliente", className: "text-center"},
    { name: "dirCliente", className: "text-center"},
    { name: "emailCliente", className: "text-center"},
    { name: "faxCliente", className: "text-center"},
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
    
    { targets: [4], orderData: false, visible: true },
    
    { targets: [5], orderData: false, visible: true },
    
    { targets: [6], orderData: false, visible: true },
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/"+phpPrincipal+"?op=mostrarElementos",
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

//* ************* ********** *////* ************* ********** *////* ************* ********** *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* ************* ********** *////* ************* ********** *////* ************* ********** *//
$("#FootNombre").on("keyup", function () {
  conductores_table.columns(1).search(this.value).draw();
});
$("#FootNif").on("keyup", function () {
  conductores_table.columns(2).search(this.value).draw();
});
$("#"+idDatatables+"")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros(idDatatables);
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

if($("#idConductor").val() != ""){
  conductores_table.columns(0).search($("#idConductor").val()).draw();
}
conductores_table.columns(0).visible(true);

$("#"+idDatatables+"").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE

//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

function agregarElemento() {//! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  let nombreCliente = $("#nombreCliente").val(); 
  let tipoCliente = $("#tipoCliente").val(); 
  let tefCliente = $("#tefCliente").val(); 
  let dirCliente = $("#dirCliente").val(); 
  let emailCliente = $("#emailCliente").val(); 
  let faxCliente = $("#faxCliente").val(); 
  let obsCliente = $("#obsCliente").val(); 
  let notasCliente = $("#notasCliente").val(); 

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion && !validarArrayVacio(tipoCliente)) {
    //? SI LA VALIDACION DEVUELVE FALSE
    $.post(
      "../../controller/"+phpPrincipal+"?op=agregarElemento",//! NO TOCAR
      { nombreCliente:nombreCliente,tipoCliente:tipoCliente,tefCliente:tefCliente,dirCliente:dirCliente,emailCliente:emailCliente,faxCliente:faxCliente,obsCliente:obsCliente,notasCliente:notasCliente },//TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
      function (data) {
        //? AGREGAR ELEMENTO
        $("#"+idModalAgregar+"").modal("hide"); //! NO TOCAR
        toastr.success("Acción Agregada."); //TODO: MODIFICAR MENSAJE DE SUCCESS
        $("#"+idDatatables+"").DataTable().ajax.reload(null, false); //! NO TOCAR
      }
    );
  } else {
    if(validarArrayVacio(tipoCliente)){
      toastr.error("Por favor selecciona el Tipo de Cliente."); //? INFORMAR QUE HA DADO ERROR

    } ;
    if(validacion) {
      toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR

    };
  }
}

//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//

function cargarElemento(idElemento) {//! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID
  $.post(
    "../../controller/"+phpPrincipal+"?op=cargarElemento",//! NO TOCAR
    { idElemento: idElemento },//! NO TOCAR
    function (data) {
      //? RECOGER DATOS DE LA BASE DE DATOS
      data = JSON.parse(data);

      //TODO: CARGAR TANTOS CAMPOS COMO SEA NECESARIOS
      $("#nombreClienteE").val(data[0]["nombreCliente"]); 
      $("#tipoClienteE").val(data[0]["idTipoCliente_clientes"]).trigger('change'); 
      $("#tefClienteE").val(data[0]["telCliente"]); 
      $("#dirClienteE").val(data[0]["dirCliente"]); 
      $("#emailClienteE").val(data[0]["emailCliente"]); 
      $("#faxClienteE").val(data[0]["faxCliente"]); 
      $("#obsClienteE").val(data[0]["obsCliente"]); 
      $("#notasClienteE").val(data[0]["notasCliente"]); 

      $("#editando").text(data[0]["nombreCliente"]); 
      $("#hiddenid").val(data[0]["idCliAviso"]); 

      $("#"+idModalEditar+"").modal("show"); //! NO TOCAR
    }
  );
}

function editarElemento() { //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO
  let idElemento = $("#hiddenid").val(); //! NO TOCAR

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  let nombreCliente = $("#nombreClienteE").val(); 
  let tipoCliente = $("#tipoClienteE").val(); 
  let tefCliente = $("#tefClienteE").val(); 
  let dirCliente = $("#dirClienteE").val(); 
  let emailCliente = $("#emailClienteE").val(); 
  let faxCliente = $("#faxClienteE").val(); 
  let obsCliente = $("#obsClienteE").val(); 
  let notasCliente = $("#notasClienteE").val(); 

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    $.post(
      "../../controller/"+phpPrincipal+"?op=editarElemento", //! NO TOCAR
      { idElemento:idElemento,nombreCliente:nombreCliente,tipoCliente:tipoCliente,tefCliente:tefCliente,dirCliente:dirCliente,emailCliente:emailCliente,faxCliente:faxCliente,obsCliente:obsCliente,notasCliente:notasCliente },//TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
      function (data) {
        //? GUARDAR CAMBIOS

        $("#"+idModalEditar+"").modal("hide"); //! NO TOCAR
        toastr.success("Acción Editada."); //TODO: MODIFICAR MENSAJE DE SUCCESS
        $("#"+idDatatables+"").DataTable().ajax.reload(null, false); //! NO TOCAR
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

function cambiarEstado(idElemento) { //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/"+phpPrincipal+"?op=cambiarEstado", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //! NO TOCAR
      $("#"+idDatatables+"").DataTable().ajax.reload(null, false); //! NO TOCAR
    }
  );
}

//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//

$("#"+idModalAgregar+"").on("show.bs.modal", function () {//! NO TOCAR
  //? FUNCION QUE SE EJECUTA ANTES DE ABRIR EL MODAL DE AGREGAR
  limpiarModalInputs(); //? LIMPIAR TODOS LOS INPUTS DE UN MODAL Y LAS CLASES IS-VALID E IS-INVALID
  limpiarSeleccion();
});

//* ** ********* *//
//* JS ADICIONAL *//
//* JS ADICIONAL *//
//* JS ADICIONAL *//
//* ** ********* *//

function limpiarSeleccion() {
  $('#tipoCliente').val(null).trigger('change');
  deselectFirstElement("tipoCliente");
  $('#tipoClienteE').val(null).trigger('change');
  deselectFirstElement("tipoClienteE");
  
}

function deselectFirstElement(idSelect2) {
  var $select = $('#'+idSelect2);
  var selectedValues = $select.val(); // Obtiene los valores seleccionados

  if (selectedValues && selectedValues.length > 0) {
    selectedValues.shift(); // Elimina el primer elemento
    $select.val(selectedValues).trigger('change'); // Actualiza el select2 con los nuevos valores
  }
}


$.post("../../controller/tiposClientes.php?op=listarTipos",{},function (data) {
  data = JSON.parse(data);
  console.log(data);
  $.each(data, function(index, cliente) {
    $("#tipoCliente").append("<option value='" + cliente.idTipoCliente + "' >" + cliente.descripcion_tipo_cliente + "</option>");
    $("#tipoClienteE").append("<option value='" + cliente.idTipoCliente + "' >" + cliente.descripcion_tipo_cliente + "</option>");

  });})

$('#tipoCliente').select2( {
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $( this ).data( 'tipoCliente' ),
  closeOnSelect: true,
  maximumSelectionLength: 1,
  language: {
    inputTooShort: function (args) {
        var remainingChars = args.minimum - args.input.length;
        return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
    },
    maximumSelected: function (e) {
      return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
    },
    noResults: function () {
      return 'No se encontraron resultados';
    },
    searching: function () {
      return 'Buscando...';
    }
  }
} );
$('#tipoClienteE').select2( {
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $( this ).data( 'tipoCliente' ),
  closeOnSelect: true,
  maximumSelectionLength: 1,
  language: {
    inputTooShort: function (args) {
        var remainingChars = args.minimum - args.input.length;
        return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
    },
    maximumSelected: function (e) {
      return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
    },
    noResults: function () {
      return 'No se encontraron resultados';
    },
    searching: function () {
      return 'Buscando...';
    }
  }
} );