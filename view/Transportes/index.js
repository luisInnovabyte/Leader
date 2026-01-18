//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//
var idDatatables = "ordenes_table"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "transportes.php"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = ""; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = ""; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var viajeSeleccionado = "";
var datosJson = "";
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

var ordenes_table = $("#" + idDatatables + "").DataTable({
  select: false,
  ordering: true,
  order: [[7, "desc"]], // Orden inicial por la columna estOrden

  language: {
    emptyTable: "No se han encontrado Ordenes de Transportes",
  },
  columns: [
    { name: "idOrden", className: "text-center", orderable: true },
    { name: "num_transporte", className: "text-center", orderable: true },
    { name: "TRANSPORTISTA", className: "text-center", orderable: false },
    { name: "CLIENTE", className: "d-none", orderable: false },
    { name: "FECHAINICIO", className: "text-center", orderable: true },
    { name: "PUERTO", className: "text-center", orderable: false },
    { name: "tipoOrden", className: "text-center", orderable: true },
    { name: "estOrden", className: "text-center", orderable: true },
    { name: "botones", className: "text-center", orderable: false },
  ],

  columnDefs: [
    { targets: [0], visible: false }, // Columna idOrden no visible
    { targets: [1], visible: true, type: 'natural' }, // Columna num_transporte
    { targets: [2], visible: true }, // Columna TRANSPORTISTA
    { targets: [3], visible: false }, // Columna CLIENTE no visible
    { targets: [4], type: "date-eu" }, // Columna FECHAINICIO
    { targets: [5], visible: true }, // Columna PUERTO
    { targets: [6], visible: true }, // Columna tipoOrden
    { targets: [7], visible: true }, // Columna estOrden
    { targets: [8], visible: true }, // Columna botones
  ],
  // Configuración adicional para que detecte valores numéricos con sufijos
  "initComplete": function() {
    this.api().columns(1).every(function() {
      this.nodes().to$().each(function() {
        const originalValue = $(this).text();
        const numericValue = parseInt(originalValue.split('/')[0]); // Toma solo la parte numérica
        $(this).attr('data-sort', numericValue); // Asigna el valor numérico como atributo data-sort
      });
    });
  },

  searchBuilder: {
    columns: [0, 1, 2] // Columnas disponibles para búsqueda
  },

  ajax: {
    url: "../../controller/" + phpPrincipal + "?op=mostrarOrdenes",
    type: "get",
    dataType: "json",
    dataSrc: "aaData"
  },
}); // del DATATABLE

// Obtiene el valor del rol del usuario desde un elemento del DOM
var userRoleValue = $("#usuRol").val();

if (userRoleValue == "0") {
  ordenes_table.columns([2, 7]).visible(false);
} else {
  ordenes_table.columns([2, 7]).visible(true);
}
ordenes_table.columns([0]).visible(false);

//* ************* ********** *////* ************* ********** *////* ************* ********** *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* ************* ********** *////* ************* ********** *////* ************* ********** *//

$("#" + idDatatables + "")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros(idDatatables);
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

$("#" + idDatatables + "").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE

//* ** ********* *//
//* JS ADICIONAL *//
//* JS ADICIONAL *//
//* JS ADICIONAL *//
//* ** ********* *//

//****************************************/
//************* IMPRESION  ***************/
//****************************************/
$("body").on("click", ".printDocumento", function () {
  var tipoDocumento = $(this).data("tipodocumento");
  var tokenId = $("#tokenId").val();
  var contenedorActivo = $("#contenedor").val();
  var tipoOrden = $("#tipoOrdenTransporte").val();

  if (tipoDocumento == "X") {
    $("#botonesDocumentos").addClass("d-none");
    $("#seleccionarViaje").removeClass("d-none");
  } else {
    nuevaVentana = window.open(
      "orden.php?idOrden=" +
        tokenId +
        "&tipoDocumento=" +
        tipoDocumento +
        "&contenedorActivo=" +
        contenedorActivo +
        "&tipoOrdenTransporte=" +
        tipoOrden,
      "_blank",
      `width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes`
    );
  }
});

function generarDocumentoCliente() {
  viaje = $("#viajeSeleccionado").val();

  if (viaje === "") {
    toastr.error("Seleccione un viaje");
  } else {
    // Abrir una nueva ventana about:blank con scrollbars y resizable
    var width = screen.width;
    var height = screen.height;

    var tipoOrden = $("#tipoOrdenTransporte").val();

    var tipoDocumento = "C";
    var tokenId = $("#tokenId").val();
    var contenedorActivo = $("#contenedor").val();

    nuevaVentana = window.open(
      "orden.php?idOrden=" +
        tokenId +
        "&tipoDocumento=" +
        tipoDocumento +
        "&contenedorActivo=" +
        contenedorActivo +
        "&viaje=" +
        viaje,
      "_blank",
      `width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes`
    );
  }
}

function cancelarDocumentoCliente() {
  $("#botonesDocumentos").removeClass("d-none");
  $("#seleccionarViaje").addClass("d-none");
}

// GENERAR QR //
$(document).ready(function () {
  var qrCode = new QRCodeStyling({
    width: 200,
    height: 200,
    dotsOptions: {
      color: "#01612A",
      type: "rounded",
    },
    backgroundOptions: {
      color: "#e9ebee",
    },
    imageOptions: {
      crossOrigin: "anonymous", // Asegúrate de que la imagen esté configurada correctamente para CORS
      margin: 5, // Reduce este valor para hacer el ícono más grande
    },
  });

  $("#generateQR").click(function () {
    var inputText = $("#primerCodigo").val(); // Recoger el valor del input
    console.log(inputText);
    $("#qrcode").empty(); // Limpiar cualquier código QR existente

    // Validar que el texto no esté vacío
    if (inputText.trim() === "") {
      toastr.error("El QR no está disponible en esta orden.");
      $("#qrcode").html(
        '<p class="tx-danger">El QR no está disponible en esta orden, en caso de necesitarlo, contacte con soporte.</p>'
      );

      return;
    }

    // Actualizar el texto del código QR
    qrCode.update({
      data: inputText,
      image: "ojo.png", // Asegúrate de que esta URL sea accesible
    });

    // Adjuntar el código QR al div
    qrCode.append(document.getElementById("qrcode"));
  });
});

//****************************************************************/
//****** Guardar Orden de Tranporte Personalizada  ***************/
//****************************************************************/

/* Vamos a proceder a la creación de los viajes detectados, que guardara el viaje, hora de llegada, hora de salida, observaciones y firma.
/* COMPROBAR SI EL NOMBRE Y DNI ESTAN METIDOS PARA MOSTRAR FIRMA */

$(document).ready(function () {
  $("#nombreInputConductor, #DNIinputConductor").on(
    "keyup change",
    function () {
      if (
        $("#nombreInputConductor").val() == "" ||
        $("#DNIinputConductor").val() == ""
      ) {
        $("#fsignatureContainerConductor").addClass("d-none");
      } else {
        $("#fsignatureContainerConductor").removeClass("d-none");
      }
    }
  );

  $("#nombreInputReceptor, #DNIinputReceptor").on("keyup change", function () {
    if (
      $("#nombreInputReceptor").val() == "" ||
      $("#DNIinputReceptor").val() == ""
    ) {
      $("#fsignatureContainerReceptor").addClass("d-none");
    } else {
      $("#fsignatureContainerReceptor").removeClass("d-none");
    }
  });

  $("#nombreInputCliente, #DNIinputCliente").on("keyup change", function () {
    if (
      $("#nombreInputCliente").val() == "" ||
      $("#DNIinputCliente").val() == ""
    ) {
      $("#fsignatureContainerCliente").addClass("d-none");
    } else {
      $("#fsignatureContainerCliente").removeClass("d-none");
    }
  });
});
//* RECOJO EL VIAJE */

$("#selectViajes").change(function () {
  var selectedValue = $(this).val();

  // Aquí puedes realizar acciones según el valor seleccionado
  if (selectedValue !== "") {
    $(".insertarDatosViaje").removeClass("d-none");

    console.log("Has seleccionado el viaje con ID:", selectedValue);
    viajeSeleccionado = selectedValue;
    cargarViaje(selectedValue);

    // Aquí puedes realizar más acciones según el valor seleccionado, como enviar una solicitud AJAX, etc.
  } else {
    console.log("Por favor, selecciona una opción válida.");
    $(".insertarDatosViaje").addClass("d-none");
  }
});

/* CARGAR VIAJE CON DATOS GUARDADOS */
function cargarViaje(idViaje) {
  // OCULTAR FIRMA DEL CLIENTE
  if ($("#tipoOrdenTransporte").val() == "C") {
    $(".tabCliente").addClass("d-none");
  }

  //================================================================//
  //======================= FIRMA DE CONDUCTOR =====================//
  //================================================================//
  // Elimina el formulario de firma anterior
  $("#fsignatureContainerConductor").empty();

  // Agrega el nuevo formulario de firma
  $("#fsignatureContainerConductor").append(`
      <form method="POST">
        <canvas id="signaturePadConductor" class="signaturePad" width="400" height="300" style="border: 1px solid #000;"></canvas>
        <div class="d-flex justify-content-center mt-3">
          <input class="btn mt-2 text-center tx-center mr-2" style="background-color: #ff5353; color: white;" type="reset" value="Borrar Firma" />
        </div>
      </form>
    `);

  // Configuración del canvas para redimensionamiento
  const onResize = () => {
    $("#signaturePadConductor").attr({
      height: 200,
      width: 200, // Puedes ajustar el ancho si lo prefieres
    });
  };

  // Asigna eventos para el redimensionamiento
  $(window).on("orientationchange resize", onResize);
  onResize();

  // Inicializa el plugin de firma
  $("#fsignatureContainerConductor").find("form").signaturePad({
    drawOnly: true,
    defaultAction: "drawIt",
    validateFields: false,
    lineWidth: 0,
    clear: "input[type=reset]",
    drawBezierCurves: true,
    lineTop: 200,
  });

  // Limpia el canvas
  const canvas = document.getElementById("signaturePadConductor");
  const context = canvas.getContext("2d");
  clearCanvas(canvas, context);

  //================================================================//
  //================================================================//
  //================================================================//
  //================================================================//

  //================================================================//
  //====================== FIRMA DEL CLIENTE =======================//
  //================================================================//
  // Elimina el formulario de firma anterior
  $("#fsignatureContainerCliente").empty();

  // Agrega el nuevo formulario de firma
  $("#fsignatureContainerCliente").append(`
        <form method="POST">
          <canvas id="signaturePadCliente" class="signaturePad" width="400" height="300" style="border: 1px solid #000;"></canvas>
          <div class="d-flex justify-content-center mt-3">
            <input class="btn mt-2 text-center tx-center mr-2" style="background-color: #ff5353; color: white;" type="reset" value="Borrar Firma" />
          </div>
        </form>
      `);

  // Configuración del canvas para redimensionamiento
  const onResizeCliente = () => {
    $("#signaturePadCliente").attr({
      height: 200,
      width: 200, // Puedes ajustar el ancho si lo prefieres
    });
  };

  // Asigna eventos para el redimensionamiento
  $(window).on("orientationchange resize", onResizeCliente);
  onResizeCliente();

  // Inicializa el plugin de firma
  $("#fsignatureContainerCliente").find("form").signaturePad({
    drawOnly: true,
    defaultAction: "drawIt",
    validateFields: false,
    lineWidth: 0,
    clear: "input[type=reset]",
    drawBezierCurves: true,
    lineTop: 200,
  });

  // Limpia el canvas
  const canvasCliente = document.getElementById("signaturePadCliente");
  const contextCliente = canvasCliente.getContext("2d");
  clearCanvas(canvasCliente, contextCliente);

  //================================================================//
  //================================================================//
  //================================================================//

  //================================================================//
  //===================== FIRMA DEL RECEPTOR =======================//
  //================================================================//
  // Elimina el formulario de firma anterior
  $("#fsignatureContainerReceptor").empty();

  // Agrega el nuevo formulario de firma
  $("#fsignatureContainerReceptor").append(`
        <form method="POST">
          <canvas id="signaturePadReceptor" class="signaturePad" width="400" height="300" style="border: 1px solid #000;"></canvas>
          <div class="d-flex justify-content-center mt-3">
            <input class="btn mt-2 text-center tx-center mr-2" style="background-color: #ff5353; color: white;" type="reset" value="Borrar Firma" />
          </div>
        </form>
      `);

  // Configuración del canvas para redimensionamiento
  const onResizeReceptor = () => {
    $("#signaturePadReceptor").attr({
      height: 200,
      width: 200, // Puedes ajustar el ancho si lo prefieres
    });
  };

  // Asigna eventos para el redimensionamiento
  $(window).on("orientationchange resize", onResizeReceptor);
  onResizeReceptor();

  // Inicializa el plugin de firma
  $("#fsignatureContainerReceptor").find("form").signaturePad({
    drawOnly: true,
    defaultAction: "drawIt",
    validateFields: false,
    lineWidth: 0,
    clear: "input[type=reset]",
    drawBezierCurves: true,
    lineTop: 200,
  });

  // Limpia el canvas
  const canvasReceptor = document.getElementById("signaturePadReceptor");
  const contextReceptor = canvasReceptor.getContext("2d");
  clearCanvas(canvasReceptor, contextReceptor);

  //================================================================//
  //================================================================//
  //================================================================//

  $.post(
    "../../controller/transportes.php?op=recogerViajexIdOrden",
    { idViaje: idViaje },
    function (datosViaje) {
      datosViaje = JSON.parse(datosViaje);
      console.log(datosViaje);

      $("#fechaLlegada").val(datosViaje[0]["fechaLlegadaViaje"]);
      $("#fechaSalida").val(datosViaje[0]["fechaSalidaViaje"]);
      $("#ObservacionViaje").val(datosViaje[0]["ObservacionViaje"]);

      $("#correoInputConductor").val(datosViaje[0]["correoViajeConductor"]);
      $("#nombreInputConductor").val(datosViaje[0]["nombreViajeConductor"]);
      $("#DNIinputConductor").val(datosViaje[0]["dniViajeConductor"]);

      $("#correoInputReceptor").val(datosViaje[0]["correoViajeReceptor"]);
      $("#nombreInputReceptor").val(datosViaje[0]["nombreViajeReceptor"]);
      $("#DNIinputReceptor").val(datosViaje[0]["dniViajeReceptor"]);

      // ESTO TENDRIA QUE VENIR DE OTRO LDO
      $("#correoInputCliente").val(datosViaje[0]["correoCliente"]);
      $("#nombreInputCliente").val(datosViaje[0]["nombreCliente"]);
      $("#DNIinputCliente").val(datosViaje[0]["dniCliente"]);

      // OCULTAR FIRMA DEL CLIENTE
      if ($("#tipoOrdenTransporte").val() == "C") {
        $(".tabCliente").addClass("d-none");
      }
      console.log($("#nombreInputConductor").val());
      if (
        $("#nombreInputConductor").val() == "" ||
        $("#DNIinputConductor").val() == ""
      ) {
        $("#fsignatureContainerConductor").addClass("d-none");
      } else {
        $("#fsignatureContainerConductor").removeClass("d-none");
      }

      if (
        $("#nombreInputReceptor").val() == "" ||
        $("#DNIinputReceptor").val() == ""
      ) {
        $("#fsignatureContainerReceptor").addClass("d-none");
      } else {
        $("#fsignatureContainerReceptor").removeClass("d-none");
      }

      if (
        $("#nombreInputCliente").val() == "" ||
        $("#DNIinputCliente").val() == ""
      ) {
        $("#fsignatureContainerCliente").addClass("d-none");
      } else {
        $("#fsignatureContainerCliente").removeClass("d-none");
      }
      $.post("../../controller/transportes.php?op=recogerFirmaPerfil",{},function (data) {
        data = JSON.parse(data);
        console.log("🚀 ~ data:", data)
        if(datosViaje[0]["FirmaViajeConductor"] != null){
          
          // Cargar la nueva firma
          var img = new Image();
          img.src = datosViaje[0]["FirmaViajeConductor"];
          img.onload = function () {
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.drawImage(img, 0, 0, canvas.width, canvas.height);
          };
        } else {
          // Cargar la nueva firma
          var img = new Image();
          img.src = data[0]["firmaTransportista_transportistasTransporte"];
          img.onload = function () {
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.drawImage(img, 0, 0, canvas.width, canvas.height);
          };
          $("#nombreInputConductor").val(data[0]["nombreTransportista"]);
          $("#DNIinputConductor").val(data[0]["nifTransportista"]);
          if (
            $("#nombreInputConductor").val() == "" ||
            $("#DNIinputConductor").val() == ""
          ) {
            $("#fsignatureContainerConductor").addClass("d-none");
          } else {
            $("#fsignatureContainerConductor").removeClass("d-none");
          }

        }
      })


      // Cargar la nueva Cliente
      var imgCliente = new Image();
      imgCliente.src = datosViaje[0]["firmaCliente"];
      imgCliente.onload = function () {
        contextCliente.clearRect(
          0,
          0,
          canvasCliente.width,
          canvasCliente.height
        );
        contextCliente.drawImage(
          imgCliente,
          0,
          0,
          canvasCliente.width,
          canvasCliente.height
        );
      };

      // Cargar la nueva Receptor
      var imgReceptor = new Image();
      imgReceptor.src = datosViaje[0]["FirmaViajeReceptor"];
      imgReceptor.onload = function () {
        contextReceptor.clearRect(
          0,
          0,
          canvasReceptor.width,
          canvasReceptor.height
        );
        contextReceptor.drawImage(
          imgReceptor,
          0,
          0,
          canvasReceptor.width,
          canvasReceptor.height
        );
      };
    }
  );
}
// Función para limpiar el canvas con promesa
function clearCanvas(canvas, context) {
  var canvas = document.getElementById("signaturePadConductor");
  var context = canvas.getContext("2d");
  context.clearRect(0, 0, canvas.width, canvas.height);
}

/* ACTUALIZAR VIAJE */

$(".datosViaje").change(function () {
  idViaje = $("#selectViajes").val();
  fechaLlegada = $("#fechaLlegada").val();
  fechaSalida = $("#fechaSalida").val();
  observacionesViaje = $("#ObservacionViaje").val();

  $.post(
    "../../controller/transportes.php?op=actualizarViaje",
    {
      idViaje: idViaje,
      fechaLlegada: fechaLlegada,
      fechaSalida: fechaSalida,
      observacionesViaje: observacionesViaje,
    },
    function (data) {
      success_noti_viaje("Viaje guardado");
    }
  );
});

/*********/
/* FIRMA */
/*********/

$('input[type="reset"]').click(function () {
  var canvas = document.getElementById("signaturePadConductor");
  var context = canvas.getContext("2d");
  context.clearRect(0, 0, canvas.width, canvas.height);
});

/* comentado porque no se si funciona bien
 $(".inputsfirma").on("input", function () {
  cargarViaje(viajeSeleccionado);
}); */

//****************************************************************/
//****************************************************************/
//****************************************************************/

//**************************************************************************/
//**************************************************************************/
//********************** APARTADO GUARDADO FIRMA VIAJE  *******+************/
//**************************************************************************/
//**************************************************************************/

//************************** GUARDAR FIRMA CONDUCTOR ************************/
// Guardar firma
$("#saveSignatureConductor").click(function () {
  let validacion = validarCamposVacios();
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE
    let idViaje = $("#selectViajes").val();
    console.log(idViaje);

    var signaturePadConductor = document.getElementById(
      "signaturePadConductor"
    );
    let nombreInput = $("#nombreInputConductor").val();
    let DNIinput = $("#DNIinputConductor").val();

    /*   if (signaturePad.isEmpty()) {
            toastr.error("Por favor, firme en el cuadro."); //! INFORMAR QUE HA DADO ERROR */

    signatureDataConductor = signaturePadConductor.toDataURL("image/png");

    $.post(
      "../../controller/transportes.php?op=actualizarFirma&autorFirma=conductor",
      {
        idViaje: idViaje,
        signature: signatureDataConductor,
        nombreInput: nombreInput,
        DNIinput: DNIinput,
      },
      function (data) {
        // Manejar la respuesta de éxito
        success_noti_firma("Datos conductor guardados");
        $("#firma_modal").modal("hide");
      }
    ).fail(function (jqXHR, textStatus, errorThrown) {
      // Manejar la respuesta de error
      console.error("Error en la solicitud: " + textStatus, errorThrown);
      alert(
        "Hubo un error al guardar la firma. Por favor, intente nuevamente."
      );
    });
  } else {
    toastr.error("Por favor corrija los campos."); //! INFORMAR QUE HA DADO ERROR
  }
});

//************************** GUARDAR FIRMA CLIENTE ************************/
// Guardar firma
$("#saveSignatureCliente").click(function () {
  let validacion = validarCamposVacios();
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE
    let idViaje = $("#selectViajes").val();
    console.log(idViaje);

    var signaturePadCliente = document.getElementById("signaturePadCliente");
    let nombreInput = $("#nombreInputCliente").val();
    let DNIinput = $("#DNIinputCliente").val();
    let correoInput = $("#correoInputCliente").val();
    let idOrdenTokenReceptor = $("#tokenId").val(); // 338109/3 338109/3

    signatureDataCliente = signaturePadCliente.toDataURL("image/png");

    $.post(
      "../../controller/transportes.php?op=actualizarFirma&autorFirma=cliente",
      {
        idViaje: idViaje,
        signature: signatureDataCliente,
        nombreInput: nombreInput,
        DNIinput: DNIinput,
        correoInput: correoInput,
        idOrdenTokenReceptor: idOrdenTokenReceptor,
      },
      function (data) {
        // Manejar la respuesta de éxito
        success_noti_firma("Datos Cliente guardados");
        $("#firma_modal").modal("hide");
      }
    ).fail(function (jqXHR, textStatus, errorThrown) {
      // Manejar la respuesta de error
      console.error("Error en la solicitud: " + textStatus, errorThrown);
      alert(
        "Hubo un error al guardar la firma. Por favor, intente nuevamente."
      );
    });
  } else {
    toastr.error("Por favor corrija los campos."); //! INFORMAR QUE HA DADO ERROR
  }
});

//************************** GUARDAR FIRMA RECEPTOR ************************/
// Guardar firma
$("#saveSignatureReceptor").click(function () {
  let idOrdenReceptor = $("#idOrden").val(); // 337439/01...
  console.log("x1");

  let validacion = validarCamposVacios();
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE
    let idViaje = $("#selectViajes").val();
    console.log(idViaje);
    console.log("x2");

    var signaturePadReceptor = document.getElementById("signaturePadReceptor");
    console.log(signaturePadReceptor);
    let nombreInput = $("#nombreInputReceptor").val();
    let DNIinput = $("#DNIinputReceptor").val();
    let correoInput = $("#correoInputReceptor").val();
    /*   if (signaturePad.isEmpty()) {
          toastr.error("Por favor, firme en el cuadro."); //! INFORMAR QUE HA DADO ERROR */

    signatureDataReceptor = signaturePadReceptor.toDataURL("image/png");
    console.log(signatureDataReceptor);

    $.post(
      "../../controller/transportes.php?op=actualizarFirma&autorFirma=receptor",
      {
        idOrden: idOrdenReceptor,
        idViaje: idViaje,
        signature: signatureDataReceptor,
        nombreInput: nombreInput,
        DNIinput: DNIinput,
        correoInput: correoInput,
      },
      function (data) {
        // Manejar la respuesta de éxito
        success_noti_firma("Datos Receptor guardados");
        $("#firma_modal").modal("hide");
      }
    ).fail(function (jqXHR, textStatus, errorThrown) {
      // Manejar la respuesta de error
      console.error("Error en la solicitud: " + textStatus, errorThrown);
      alert(
        "Hubo un error al guardar la firma. Por favor, intente nuevamente."
      );
    });
  } else {
    toastr.error("Por favor corrija los campos."); //! INFORMAR QUE HA DADO ERROR
  }
});
//**************************************************************************/
//**************************************************************************/
//**************************************************************************/
//**************************************************************************/

//****************************************************************/
//****************************************************************/
//****************************************************************/

//****************************************************************/
//********************** APARTADO INCIDENCIAS *******+************/
//****************************************************************/

/* Apartado de incidencias. Datatable de incidencias y reporte de incidencias por idOrden */
function cargarDatatablesIncidencias() {
  idOrden = $("#idOrden").val();

  var incidencia_table = $("#incidencia_table").DataTable({
    select: true, // Permite seleccionar filas
  
    ordering: true,
    order: [[2, "desc"]], // Orden inicial por la columna FECHA (índice 2)
    language: {
      emptyTable: "No se han reportado incidencias",
    },
    columns: [
      { name: "SITUACIÓN", className: "text-center", orderable: false }, // No ordenable
      { name: "TRANSPORTISTA", className: "text-center", orderable: false }, // No ordenable
      { name: "FECHA", className: "text-center", orderable: true }, // Ordenable (columna FECHA)
      { name: "CONSULTAR", className: "text-center", orderable: false }, // No ordenable
    ],
    columnDefs: [
      { targets: [0], visible: true, orderable: false }, // Columna SITUACIÓN (no ordenable)
      { targets: [1], visible: true, orderable: false }, // Columna TRANSPORTISTA (no ordenable)
      { targets: [2], type: "date-eu", orderable: true }, // Columna FECHA (ordenable)
      { targets: [3], visible: true, orderable: false }, // Columna CONSULTAR (no ordenable)
    ],
  
    searchBuilder: {
      // Las columnas que se pueden buscar
      columns: [0, 1, 2], 
    },
    ajax: {
      url:
        "../../controller/transportes.php?op=mostrarIncidencias&orden=" +
        idOrden,
      type: "get",
      dataType: "json",
      cache: false,
      serverSide: true,
      processData: true,
      beforeSend: function () {
        // Opcional: lo que quieras hacer antes de cargar los datos
      },
      complete: function (data) {
        // Opcional: lo que quieras hacer después de cargar los datos
      },
      error: function (e) {
        // Manejar errores
      },
    },
  });
  
  // del DATATABLE
  $("#incidencia_table")
    .DataTable()
    .on("draw.dt", function () {
      controlarFiltros("incidencia_table");
      // La función está en el mainJs.php, es común para todos
      // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
    });

  $("#incidencia_table").addClass("width-100");
}

cargarDatatablesIncidencias();

function cargarIncidencia(idIncidencia) {
  $.post(
    "../../controller/transportes.php?op=recogerIncidencia",
    { idIncidencia: idIncidencia },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
      $("#divDocumentos").html("");

      data = JSON.parse(data);
      let idIncidencia = data[0]["idIncidencia"];
      let transportistaIncidencia = data[0]["transportistaIncidencia"];
      let situacion = data[0]["nombreSituacion"];
      let fecha = data[0]["fechaCreacionIncidencia"];
      let viajeTexto = data[0]["viajeIncidencia"];
      let descripcion = data[0]["descripcion"];

      let documentos = data[0]["documento"];

      $("#situacionModal").text(situacion);
      $("#reportanteModal").text(transportistaIncidencia);
      $("#fechaModal").text(formatearFechaEuropea(fecha));
      $("#viajeModal").text(viajeTexto);
      $("#descripcionModal").text(descripcion);

      $("#botonEliminarIncidencia").attr(
        "onClick",
        "cambiarEstado(" + idIncidencia + ")"
      );

      var divDocumentos = $("#divDocumentos");

      if (documentos != "null") {
        console.log("Con archivo");
        documentos = JSON.parse(data[0]["documento"]);

        // Itera sobre las claves y valores del objeto "Documentos"
        $.each(documentos["Documentos"], function (clave, valor) {
          // Obtiene la extensión del archivo
          var extension = valor.split(".").pop().toLowerCase();

          // Verifica si la extensión es de un PDF
          if (extension === "pdf") {
            // Crea el HTML para el enlace con un icono de PDF
            var html =
              '<a href="../../public/incidencias/' +
              valor +
              '" target="_blank">';
            html +=
              '<img src="pdfIcono.png" width="50" height="50" class="mg-10  img-bordered" alt="PDF Icon">';
            html += "</a>";
          } else {
            // Si no es un PDF, asume que es una imagen
            // Crea el HTML para el enlace y la imagen
            var html =
              '<a href="../../public/incidencias/' +
              valor +
              '" target="_blank">';
            html +=
              '<img src="../../public/incidencias/' +
              valor +
              '"  width="200vw" height="200vh" class="mg-10  img-bordered" alt="' +
              valor +
              '" >';
            html += "</a>";
          }
          // Agrega el HTML al div
          divDocumentos.append(html);
        });
      } else {
        $("#divDocumentos").html(
          '<b class="tx-danger">Sin archivos presentados</b>'
        );
      }

      $("#consultarIncidencia").modal("show");
    }
  );
}

//****************************************************************/
//****************************************************************/
//****************************************************************/

//****************************************************************/
//************************ AÑADIR INCIDENCIA ********+************/
//****************************************************************/

//===<<!!>>=<<!!>>==<<!!>>==DROPZONE ===<<!!>>=<<!!>>==<<!!>>==//
var archivosAlmacenados = []; // Inicialmente no hay ningún archivo almacenado
//======================<INICIALIZAMOS EL DROPZONE>=======================//

var myDropzone = new Dropzone("#dropzoneGesdoc", {
  url: "../../controller/transportes.php?op=subirDoc", //= Ruta php que recibira los archivos =//
  paramName: "file", //=Con que nombre se recoge en el php de la url=//
  addRemoveLinks: true,
  maxFiles: 5, //=Max cantidad de archivos=//
  parallelUploads: 5, //=Archivos que se pueden subir de golpe=//
  maxFilesize: 5, //=Max MB aceptados =//
  acceptedFiles: ".png, .jpg, .jpeg, .pdf", //=Las extensiones que acepta =//
  autoProcessQueue: false, //=Evita que los archivos se suban automaticamente=//
  uploadMultiple: true, //=Permite subir varios archivos a la vez =//
  dictDefaultMessage: "Arrastra o selecciona una imagen",
  dictRemoveFile: "Eliminar imagen",
  init: function () {
    this.on("error", function (file, errorMessage) {
      this.removeFile(file);
    });
    // Evento cuando se completa la subida
    this.on("removedfile", function (file) {
      // Verificar si el Dropzone está vacío después de eliminar el archivo
    });

    this.on("successmultiple", function (file, response) {
      var response = JSON.parse(response);
      console.log(response);
      var contador = 0;
      $.each(response, function (index, item) {
        console.log("Entra each");

        contador += 1;
        console.log(contador);
        datosJson["Documentos"]["documento" + contador] = item;
        // Aquí puedes realizar cualquier operación que necesites con cada elemento de 'response'
      });

      $.post(
        "../../controller/transportes.php?op=guardarIncidencia",
        {
          idOrden: idOrden,
          selectSituacion: selectSituacion,
          selectViaje: selectViaje,
          reportante: reportante,
          fechaIncidencia: fechaIncidencia,
          descripcionIncidencia: descripcionIncidencia,
          documentos: datosJson,
        },
        function (data) {
          //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})

          resetDropzone();

          $("#incidencia_table").DataTable().ajax.reload(null, false);
          $("#divDocumentos").html("");
          toastr.success("Incidencia añadida");
          limpiarFormInsert();
          return false;
        }
      );
    });
  },
});
//=/=/=/=/=/=/=/=/=/=/=/=/=<FIN DROPZONE INICIALIZADO>=/=/=/=/=/=/=/=/=/=/=/=/=/=/=/

//=/=/=/=/=/=/=/=/=/=/=/=/=<FIN DROPZONE>=/=/=/=/=/=/=/=/=/=/=/=/=/=/=/

$(document).ready(function () {
  $.post(
    "../../controller/transportes.php?op=selectSituacion",
    function (data) {
      var data = JSON.parse(data);
      if (data.length > 0) {
        $("#selectSituacion").empty();

        for (var i = 0; i < data.length; i++) {
          var row = data[i];
          $("#selectSituacion").append(
            "<option value=" +
              data[i].idSituacion +
              " >" +
              data[i].nombreSituacion +
              "</option>"
          );
        }
      } else {
        $("#selectSituacion").empty();
      }
    }
  );
});
// Función para contar los archivos

function resetDropzone() {
  myDropzone.removeAllFiles(true); // Elimina todos los archivos de la vista y la cola, con true remueve también los archivos en proceso
  archivosAlmacenados = []; // Limpia el arreglo de archivos almacenados

  // Reinicia cualquier otra configuración necesaria
  myDropzone.options.autoProcessQueue = false;
  myDropzone.options.uploadMultiple = true;
  // Agrega cualquier otra opción que desees restablecer
}
$("#guardarIncidencia").on("click", function () {
  selectSituacion = $("#selectSituacion").val();
  selectViaje = $("#selectViaje").val();
  reportante = $("#reportante").text();
  fechaIncidencia = $("#fechaIncidencia").val();
  descripcionIncidencia = $("#descripcionIncidencia").val();
  idOrden = $("#idOrden").val();
  datosJson = {
    Documentos: {},
  };

  if (descripcionIncidencia != "") {
    var allFiles = myDropzone.files;

    if (allFiles.length !== 0) {
      myDropzone.processQueue();
    } else {
      $.post(
        "../../controller/transportes.php?op=guardarIncidencia",
        {
          idOrden: idOrden,
          selectSituacion: selectSituacion,
          selectViaje: selectViaje,
          reportante: reportante,
          fechaIncidencia: fechaIncidencia,
          descripcionIncidencia: descripcionIncidencia,
          documentos: datosJson,
        },
        function (data) {
          //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
          resetDropzone();

          $("#incidencia_table").DataTable().ajax.reload(null, false);
          $("#divDocumentos").html("");
          toastr.success("Incidencia añadida");
          limpiarFormInsert();
          return false;
        }
      );
    }
  } else {
    toastr.error("Describe la incidencia");
  }
});

function limpiarFormInsert() {
  var fechaActual = new Date();
  var formattedFechaActual =
    fechaActual.getFullYear() +
    "-" +
    ("0" + (fechaActual.getMonth() + 1)).slice(-2) +
    "-" +
    ("0" + fechaActual.getDate()).slice(-2) +
    " " +
    ("0" + fechaActual.getHours()).slice(-2) +
    ":" +
    ("0" + fechaActual.getMinutes()).slice(-2);
  // Establecer el valor en el campo de fecha
  $("#fechaIncidencia").val(formattedFechaActual);

  $("#descripcionIncidencia").val("");
  // Obtener la instancia de Dropzone
  var myDropzone = Dropzone.forElement("#dropzoneGesdoc");

  // Vaciar Dropzone
  myDropzone.removeAllFiles();
  $("#modalAgregarIncidencia").modal("hide");
}
// ELIMINAR //
function cambiarEstado(idIncidencia) {
  $.post(
    "../../controller/transportes.php?op=cambiarEstado",
    { idIncidencia: idIncidencia },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})

      $("#incidencia_table").DataTable().ajax.reload(null, false);
      toastr.error("Incidencia eliminada");
    }
  );
}

//****************************************************************/
//****************************************************************/
//****************************************************************/

//****************************************************************/
//***************** SUBIDA MANUAL DE DOCUMENTOS ******************/
//****************************************************************/

function subidaArchivosManual() {
  $("#modalSubidaManual").modal("show");
}

//****************************************************************/
//****************************************************************/
//****************************************************************/

//****************************************************************/
//*******************  ORDENES DE TRANSPORTE  ********************/
//****************************************************************/
// AÑADIR BARRA SI NO LO TIENE
if ($("#tipoOrdenTransporte").val() == "C") {
  insertSlashContenedor();
}

function insertSlashContenedor() {
  contenedor = $("#contenedor").val();
  console.log(contenedor);
  // Verificar si el input ya contiene una barra
  if (contenedor.includes("/")) {
    return contenedor;
  }
  console.log("asd");

  // Obtener la longitud del input
  var length = contenedor.length;

  // Si la longitud es menor a 2, no se puede insertar la barra
  if (length < 2) {
    return contenedor;
  }

  // Insertar la barra antes del antepenúltimo dígito
  var position = length - 1;
  var result = contenedor.slice(0, position) + "/" + contenedor.slice(position);
  $("#contenedor").val(result);
}
function removeSlash() {
  contenedor = $("#contenedor").val();
  // Verificar si el input contiene una barra
  if (contenedor.includes("/")) {
    return contenedor.replace("/", "");
  }

  // Si no contiene una barra, devolver el input tal cual
  return contenedor;
}

function guardarNuevoPrecinto() {
  idOrden = $("#idOrden").val();
  precinto = $("#hlogPrecinto").val();

  $.post(
    "../../controller/transportes.php?op=actualizarPrecinto",
    { idOrden: idOrden, precinto: precinto },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})

      console.log(data);
      success_noti_contenedor("Precinto actualizado a " + precinto);

      $("#contenedor_modal").modal("hide");
      $("#idPrecintoSave").val(precinto);

      $(".edicionModePrecintoOn").addClass("d-none");
      $(".edicionModePrecintoOff").removeClass("d-none");

      $("#hlogPrecinto").attr("readonly", "readonly");
    }
  );
}

$(document).ready(function () {
  //=======//
  //PRECINTO//
  //=======//
  $("#cambiarModoPrecinto").click(function () {
    insertSlashContenedor();
    $(".edicionModePrecintoOff").addClass("d-none");
    $(".edicionModePrecintoOn").removeClass("d-none");

    $("#hlogPrecinto").removeAttr("readonly");

    // CANCELAR CONTENEDOR
    $(".edicionModeOn").addClass("d-none");
    $(".edicionModeOff").removeClass("d-none");

    // RESTABLECE EL CONTENEDOR PRINCIPAL
    contenedor = $("#idContenedorSave").val();
    $("#contenedor").val(contenedor);
    $("#contenedor").attr("readonly", "readonly");
  });

  $("#cancelarModoPrecinto").click(function () {
    $(".edicionModePrecintoOn").addClass("d-none");
    $(".edicionModePrecintoOff").removeClass("d-none");

    // RESTABLECE EL CONTENEDOR PRINCIPAL
    contenedor = $("#idPrecintoSave").val();
    $("#hlogPrecinto").val(contenedor);
    $("#hlogPrecinto").attr("readonly", "readonly");
  });

  // BOTON CHECK ✅
  $("#guardarModoPrecinto").click(function () {
    $("#alertInvalid").html("");
    $("#contenedorModalTitle").text("Confirmación de Precinto");
    // Ejemplo de uso
    let matricula = $("#hlogPrecinto").val();

    contenedorSave = $("#idPrecintoSave").val(); // CONTENEDOR ANTERIOR

    if (contenedorSave != "") {
      $("#tituloContenedor").html("");

      $("#contenedorModalTitle").text("Confirmación de precinto");

      $("#txDangerModal").text(
        "Al guardar el precinto, no se podrá revertir al anterior."
      );

      $("#contenedorAnterior").html(
        "ANTERIOR <br> <b class='tx-danger'>" + contenedorSave + "</b>"
      );
      $("#contenedorNuevo").html(
        "ACTUALIZAR PRECINTO <br> <b class='tx-success'>" + matricula + "</b>"
      );
      $("#guardarContenedorModal").addClass("d-none");
      $("#guardarPrecintoModal").removeClass("d-none");
    } else {
      $("#tituloContenedor").html("");
      $("#txDangerModal").text(
        "Al guardar el precinto, no se podrá revertir al anterior."
      );
      $("#guardarContenedorModal").addClass("d-none");
      $("#guardarPrecintoModal").removeClass("d-none");
      $("#contenedorNuevo").html(
        "GUARDAR PRECINTO <br> <b class='tx-success'>" + matricula + "</b>"
      );
    }

    $("#contenedor_modal").modal("show");
  });

  //=======//
  //=======//
  //=======//
  $("#cambiarModoContenedor").click(function () {
    $(".edicionModeOff").addClass("d-none");
    $(".edicionModeOn").removeClass("d-none");

    $("#contenedor").removeAttr("readonly");

    $(".edicionModePrecintoOn").addClass("d-none");
    $(".edicionModePrecintoOff").removeClass("d-none");

    // RESTABLECE EL CONTENEDOR PRINCIPAL
    contenedor = $("#idPrecintoSave").val();
    $("#hlogPrecinto").val(contenedor);
    $("#hlogPrecinto").attr("readonly", "readonly");
  });

  $("#cancelarModoContenedor").click(function () {
    $(".edicionModeOn").addClass("d-none");
    $(".edicionModeOff").removeClass("d-none");

    // RESTABLECE EL CONTENEDOR PRINCIPAL
    contenedor = $("#idContenedorSave").val();
    $("#contenedor").val(contenedor);
    $("#contenedor").attr("readonly", "readonly");
    insertSlashContenedor();
  });

  $("#guardarModoContenedor").click(function () {
    $("#contenedorModalTitle").text("Confirmación de contenedor");
    $("#guardarContenedorModal").removeClass("d-none");
    $("#guardarPrecintoModal").addClass("d-none");
    $("#alertInvalid").html("");
    $("#contenedorAnterior").html("");
    $("#contenedorNuevo").html("");
    // Ejemplo de uso
    let matricula = $("#contenedor").val();
    let resultado = DigitoControl(matricula);
    console.log(resultado);

    contenedorSave = $("#idContenedorSave").val(); // CONTENEDOR ANTERIOR

    if (resultado == true) {
      $("#tituloContenedor").html(
        'El contenedor es <b class="tx-success">valido</b>'
      );

      if (contenedorSave != "") {
        $("#contenedorAnterior").html(
          "ANTERIOR <br> <b class='tx-danger'>" + contenedorSave + "</b>"
        );
        $("#contenedorNuevo").html(
          "ACTUALIZAR CONTENEDOR <br> <b class='tx-success'>" +
            matricula +
            "</b>"
        );
      } else {
        $("#contenedorNuevo").html(
          "GUARDAR CONTENEDOR <br> <b class='tx-success'>" + matricula + "</b>"
        );
      }
    } else {
      $("#tituloContenedor").html(
        "El contenedor es <b class='tx-danger'>inválido</b>"
      );
      $("#alertInvalid").html(
        "Si el contenedor es <b class='tx-danger'>inválido</b>, significa que no cumple con nuestros criterios. Revíselo antes de guardar."
      );

      if (contenedorSave != "") {
        $("#contenedorAnterior").html(
          "ANTERIOR <br> <b class='tx-danger'>" + contenedorSave + "</b>"
        );
        $("#contenedorNuevo").html(
          "ACTUALIZAR CONTENEDOR <br> <b class='tx-success'>" +
            matricula +
            "</b>"
        );
      } else {
        $("#contenedorNuevo").html(
          "GUARDAR CONTENEDOR <br> <b class='tx-success'>" + matricula + "</b>"
        );
      }
    }

    $("#contenedor_modal").modal("show");
  });
});

function guardarNuevoContenedor() {
  idOrden = $("#idOrden").val();
  contenedor = $("#contenedor").val();
  // Verificar si el input contiene una barra
  if (contenedor.includes("/")) {
    contenedor = contenedor.replace("/", "");
  }

  $.post(
    "../../controller/transportes.php?op=actualizarContenedor",
    { idOrden: idOrden, numeroContenedor: contenedor },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})

      console.log(data);
      success_noti_contenedor("Contenedor actualizado a " + contenedor);

      $("#contenedor_modal").modal("hide");
      $("#idContenedorSave").val(contenedor);

      $(".edicionModeOn").addClass("d-none");
      $(".edicionModeOff").removeClass("d-none");

      $("#contenedor").attr("readonly", "readonly");
      insertSlashContenedor();
    }
  );
}

//****************************************************************/
//****************************************************************/
//**************     COMPROBAR MATRICULA VALIDA    ***************/
//****************************************************************/
//****************************************************************/
function DigitoControl(matricula) {
  let result = false;

  // Elimina caracteres no alfanuméricos
  matricula = matricula.replace(/[^a-zA-Z0-9]/g, "").toUpperCase();

  // Extrae el dígito de control recibido
  const digitoRecibido = matricula.charAt(10);

  // Inicializa variables para el cálculo
  let vChk = 0;
  let vPeso = 1;

  // Función para calcular el valor del carácter alfabético
  function calcularValorChar(c) {
    const code = c.charCodeAt(0);
    if (code > 85) return code - 52;
    if (code > 75) return code - 53;
    if (code > 65) return code - 54;
    if (code === 65) return code - 55;
    return 0;
  }

  // Calcula caracteres alfabéticos
  for (let i = 0; i < 4; i++) {
    const s = matricula.charAt(i);
    if (s === "Ñ") {
      return { result: false, matricula: matricula }; // Si encuentra 'Ñ', sale de la función
    }
    vChk += calcularValorChar(s) * vPeso;
    vPeso *= 2;
  }

  // Calcula caracteres numéricos
  for (let i = 4; i < 10; i++) {
    const s = matricula.charAt(i);
    vChk += (s.charCodeAt(0) - 48) * vPeso;
    vPeso *= 2;
  }

  // Calcula el dígito de control
  let medio = vChk % 11;
  let digitoCalculado = medio > 9 ? (medio - 10).toString() : medio.toString();

  // Compara el dígito calculado con el recibido
  if (digitoRecibido !== digitoCalculado) {
    /* const malDigito = confirm('El Digito de Control para la matricula anotada es: ' + digitoCalculado + '\n¿Desea que lo cambie?');
      if (malDigito) {
          matricula = matricula.substring(0, 10) + digitoCalculado;
          result = true;
      } */
    return false;
  } else {
    return true;
  }
}
function subirImagen() {
  cargando();

  var fileInput = document.getElementById("file");
  var files = fileInput.files;
  var formData = new FormData();

  var ficheroError = "false"; // False si el fichero es menor del limite
  var totalMb = 0;
  for (var i = 0; i < files.length; i++) {
    if (files[i].size > 8388608) {
      // 8MB
      ficheroError = "Algún fichero supera el límite de tamaño (8MB)<br>"; // Si supera el limite de tamaño
    }
    totalMb += files[i].size;
  }

  if (files.length > 10) {
    ficheroError = "Ha superado el límite de 10 ficheros.<br>"; // Si supera el limite de tamaño
    $("#file").val("");
    descargando();
  }
  if (totalMb > 16777216) {
    ficheroError += "El total de los ficheros a subir superan los 16MB"; // Si supera el limite de tamaño
    $("#file").val("");
    descargando();
  }

  console.log(ficheroError);
  if (ficheroError == "false") {
    // Si el fichero no es mayor de tamaño o no supera la cantidad de archivos

    var filesProcessed = 0;

    // Convertir imágenes a base64 y enviarlas al servidor
    Array.from(files).forEach((file, index) => {
      const reader = new FileReader();
      reader.onload = function (event) {
        const base64Data = event.target.result.split(",")[1]; // Eliminar el encabezado "data:image/jpeg;base64,"
        formData.append(`files[${index}]`, base64Data);
        formData.append(`filename[${index}]`, file.name);

        filesProcessed++;

        // Enviar los datos al servidor después de leer todos los archivos
        if (filesProcessed === files.length) {
          $.ajax({
            url:
              "../../controller/transportes.php?op=subirDocOrden&idOrden=" +
              $("#tokenId").val(),
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function (texto) {
              toastr.success("Imagenes Subidas");
              $("#listadoSubida").html("");
              $("#textoSubirFotos").text("Subir fotos...");
              $("#file").val("");
              descargando();
            }, // del success
          }); // del ajax
        }
      };
      reader.readAsDataURL(file);
    });
  } else {
    toastr.error(ficheroError);
  }
}

$("#addImg").click(function (e) {
  e.preventDefault();
  subirImagen(e);
});

$("#file").on("change", function (e) {
  $("#listadoSubida").html("");
  var totalMb = 0;
  var ficheroError = "";

  var fileInput = document.getElementById("file");
  var totalFiles = fileInput.files.length;

  // Array to keep track of files
  var filesArray = Array.from(fileInput.files);

  filesArray.forEach(function (file, index) {
    if (file.size > 8388608) {
      // 8MB
      ficheroError += "Algún fichero supera el límite de tamaño (8MB)<br>";
      toastr.error("Algún fichero supera el límite de tamaño (8MB)");
      $("#file").val("");
    } else {
      totalMb += file.size;
      console.log(file.name);
      $("#listadoSubida").append(
        "<p data-index='" +
          index +
          "'>" +
          file.name +
          " <button class='btn btn-danger delete-btn'><i class='fa-solid fa-trash'></i></button></p>"
      );
    }
  });

  if (totalMb > 16777216) {
    ficheroError += "El total de los ficheros a subir superan los 16MB";
    toastr.error("El total de los ficheros a subir superan los 16MB");
    $("#file").val("");
  }

  if (totalFiles > 10) {
    ficheroError += "Ha superado el límite de 10 ficheros.<br>";
    toastr.error("Ha superado el límite de 10 ficheros.");
    $("#file").val("");
    descargando();
  }

  // Event listener for delete buttons
  $(".delete-btn").on("click", function () {
    var index = $(this).parent().data("index");
    filesArray.splice(index, 1);

    // Create a new FileList from the updated filesArray
    var dataTransfer = new DataTransfer();
    filesArray.forEach(function (file) {
      dataTransfer.items.add(file);
    });

    // Update the file input with the new FileList
    fileInput.files = dataTransfer.files;

    // Re-trigger the change event to update the display
    $("#file").trigger("change");
  });
});

$(document).on("click", ".deleteFromGallery", function () {
  // Ruta del documento que se desea eliminar
  var filePath = $(this).parent().find("img").attr("src");
  if ($(this).parent().find("img").attr("src") == "pdfIcono.png") {
    filePath = $(this).parent().find("a").attr("href");
  }
  $.ajax({
    url: "deleteDocument.php",
    type: "POST",
    data: { filePath: filePath },
    success: function (response) {
      toastr.success(response);
      reloadImages();
    },
    error: function () {
      toastr.error("Error al eliminar el documento");
    },
  });
});

function reloadImages() {
  $(".image-grid").html("");
  let orden = $("#tokenId").val();
  $.ajax({
    url: "load_images.php?orden",
    type: "GET",
    data: { orden: orden },
    success: function (response) {
      $(".image-grid").html(response);
    },
    error: function () {
      toastr.info("No hay documentos");
    },
  });
}
// Función para manejar el final de la animación de "irGaleria"
function handleAnimationEndSubirImagen() {
  $("#inModalSubirImagen").addClass("d-none").removeClass("slide-out-left");
  $("#inModalGaleria").addClass("slide-in-right").removeClass("d-none");
  $("#inModalSubirImagen").off("animationend", handleAnimationEndSubirImagen);
}

// Función para manejar el final de la animación de "irImagen"
function handleAnimationEndGaleria() {
  $("#inModalGaleria").addClass("d-none").removeClass("slide-out-right");
  $("#inModalSubirImagen").addClass("slide-in-left").removeClass("d-none");
  $("#inModalGaleria").off("animationend", handleAnimationEndGaleria);
}

// Asignar evento de click al botón "irGaleria"
$(".irGaleria").on("click", function () {
  reloadImages();
  $("#inModalSubirImagen").removeClass("slide-out-left");
  $("#inModalSubirImagen").removeClass("slide-out-right");
  $("#inModalSubirImagen").removeClass("slide-in-left");
  $("#inModalSubirImagen").removeClass("slide-in-right");
  $("#inModalSubirImagen").off("animationend", handleAnimationEndSubirImagen); // Asegurarse de que no haya eventos previos
  $("#inModalSubirImagen")
    .addClass("slide-out-left")
    .on("animationend", handleAnimationEndSubirImagen);
});

// Asignar evento de click al botón "irImagen"
$(".irImagen").on("click", function () {
  $("#inModalGaleria").removeClass("slide-out-left");
  $("#inModalGaleria").removeClass("slide-out-right");
  $("#inModalGaleria").removeClass("slide-in-left");
  $("#inModalGaleria").removeClass("slide-in-right");
  $("#inModalGaleria").off("animationend", handleAnimationEndGaleria); // Asegurarse de que no haya eventos previos
  $("#inModalGaleria")
    .addClass("slide-out-right")
    .on("animationend", handleAnimationEndGaleria);
});

//****************************************************************/
//****************************************************************/
//****************************************************************/

//****************************************************************/
//*************** ENVIAR CORREO ORDEN TOKEN **********************/
//****************************************************************/
function enviarCorreoDatos(opcion) {
  cargando();
  if (opcion == "receptor") {
    correoEnviar = $("#correoInputReceptor").val();
  } else if (opcion == "cliente") {
    correoEnviar = $("#correoInputCliente").val();
  }

  var regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (regexCorreo.test(correoEnviar)) {
    // Aquí se puede añadir el código para enviar los datos del correo
    console.log("Correo válido:", correoEnviar);

    ordenTransporte = $("#idOrden").val();

    viaje = $("#selectViajes").val();

    // Abrir una nueva ventana about:blank con scrollbars y resizable
    var width = 1920;
    var height = 1080;

    var tipoOrden = $("#tipoOrdenTransporte").val();

    var tipoDocumento = "C";
    var tokenId = $("#tokenId").val();
    var contenedorActivo = $("#contenedor").val();

    if (opcion == "receptor") {
      correoEnviar = $("#correoInputReceptor").val();

      (enlaceOrden =
        "/orden.php?idOrden=" +
        tokenId +
        "&tipoDocumento=" +
        tipoDocumento +
        "&contenedorActivo=" +
        contenedorActivo +
        "&viaje=" +
        viaje),
        "_blank",
        `width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes`;
    } else if (opcion == "cliente") {
      correoEnviar = $("#correoInputCliente").val();

      (enlaceOrden =
        "/orden.php?idOrden=" +
        tokenId +
        "&tipoDocumento=E" +
        "&contenedorActivo=" +
        contenedorActivo),
        "_blank",
        `width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes`;
    }
    $.post(
      "../../controller/transportes.php?op=correoEnviarOrden",
      { correo: correoEnviar, orden: ordenTransporte, enlace: enlaceOrden },
      function (data) {
        if (data == 1) {
          descargando();

          toastr["success"](
            "Orden enviado al cliente: " + correoEnviar,
            "Correo Enviado"
          );
        } else {
          descargando();

          toastr["error"](data);
        }
      }
    );
  } else {
    descargando();

    toastr.error("Por favor, introduce un correo válido.");
  }
  descargando();
}

//****************************************************************/
//****************************************************************/
//****************************************************************/
