/***********************************/
/********* PERSONALIZACIÓN ********/
/*********** LOGOTIPOS ***********/
/********************************/

function asignarNombreArchivo(nombre) {
  $("#nombreArchivo").val(nombre);
}
$(".dropzone").each(function () {
  var myDropzone = new Dropzone(this, {
    url: "../../controller/subirImagen.php", // Ruta relativa a la ubicación del archivo JavaScript
    paramName: "archivo", // Cambia "file" al nombre que prefieras
    addRemoveLinks: true,
    maxFiles: 1,
    parallelUploads: 10, // Imagenes que se pueden cargar de golpe
    maxFilesize: 5, // Tamaño máximo en MB
    acceptedFiles: ".png,.jpg,.jpeg,.webp,.ico", // Solo acepta imágenes
    autoProcessQueue: false, // Evita la carga automática
    uploadMultiple: true, // Configura para manejar un solo archivo
    dictDefaultMessage: "Arrastra o selecciona una imagen",
    dictRemoveFile: "Eliminar imagen",
    dictMaxFilesExceeded: "Solo puedes subir 1 imagen",
  });
  var imgUrl = $(this).prev().val();
  var partes = imgUrl.split("/");
  var nombreImagen = partes[partes.length - 1];
  fetch(imgUrl)
    .then((res) => res.blob())
    .then((blob) => {
      var file = new File([blob], nombreImagen);

      // Agregar la imagen al Dropzone
      myDropzone.addFile(file);
      $(this).find(".dz-image img").attr("src", imgUrl);
    })
    .catch((err) => {
      console.error("Error al cargar la imagen:", err);
    });
});

$("#cambiarImagenForm").on("submit", function (e) {
  console.log("entra");
    e.preventDefault();
  
    var formData = new FormData(this);
  
    // Obtener todas las instancias de dropzone
    var dropzones = $(".dropzone");
  
    // Iterar sobre cada dropzone y obtener sus archivos
    dropzones.each(function (index, dropzoneElement) {
      var dropzoneInstance = Dropzone.forElement(dropzoneElement); // Obtener la instancia Dropzone para el elemento actual
  
      var files = dropzoneInstance.files; // Obtener los archivos de esta dropzone
      var dataInfo = $(dropzoneElement).data("info"); // Obtener el atributo data-info del elemento dropzone
  
      // Agregar cada archivo al formData
      for (var i = 0; i < files.length; i++) {
        formData.append("files[]", files[i]);
        formData.append("info[]", dataInfo); // Agregar el data-info correspondiente
      }
    });
  
    // Realizar la solicitud AJAX
    $.ajax({
      url: "../../controller/guardarFicheros.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $("#modal_logotipo").modal("hide");
  
        // Dividimos la respuesta
        var nombreFiles = response.split('|');
  
        // Crear un objeto para mapear los nombres correctos
        var fileMap = {
          logoWhite: "",
          favWhite: "",
          logoDark: "",
          favDark: ""
        };
  
        // Mapear los nombres de archivo a sus posiciones
        nombreFiles.forEach(function(fileName) {
          if (fileName.includes("logoWhite")) {
            fileMap.logoWhite = fileName;
          } else if (fileName.includes("favWhite")) {
            fileMap.favWhite = fileName;
          } else if (fileName.includes("logoDark")) {
            fileMap.logoDark = fileName;
          } else if (fileName.includes("favDark")) {
            fileMap.favDark = fileName;
          }
        });
  
        // Si el mapeo se ha realizado correctamente
        swal
          .fire(
            "¡Logo cambiado!",
            "La imagen se ha editado con éxito.",
            "success"
          )
          .then((result) => {
            $.post(
              "../../controller/empresa.php?op=actualizarConfiguracion",
              { tabla: "logotipoDark", estado: fileMap.logoDark },
              function (data) {
              }
            );
            $.post(
              "../../controller/empresa.php?op=actualizarConfiguracion",
              { tabla: "faviconDark", estado: fileMap.favDark },
              function (data) {
              }
            );
            $.post(
              "../../controller/empresa.php?op=actualizarConfiguracion",
              { tabla: "logotipoWhite", estado: fileMap.logoWhite },
              function (data) {
              }
            );
            $.post(
              "../../controller/empresa.php?op=actualizarConfiguracion",
              { tabla: "faviconWhite", estado: fileMap.favWhite },
              function (data) {
              }
            );
            if ("caches" in window) {
              caches.keys().then((cacheNames) => {
                cacheNames.forEach((cacheName) => {
                  caches.delete(cacheName);
                });
              });
            }
            location.reload();
          });
      },
    });
  });
  

//**********************************************************************/
//*********************************************************************/
//******************* CONFIGURACIÓN DE EMPRESA ***********************/
//*******************************************************************/
//******************************************************************/

/***********************************/
/************* GENERAL ************/
/*********************************/

/***********************************/
/******** MOSTRAR DATOS ***********/
/*********************************/
function mostrarDatosEmpresa() {
  $.post("../../controller/empresa.php?op=listarEmpresa", function (data) {
    var data = JSON.parse(data);

    if (data.length === 0) {
      // Si la empresa no esta creada:

      $("#divMostrarEmpresa").addClass("d-none");
      $("#divInsertarEmpresa").removeClass("d-none");

      $(".editando").addClass("d-none");
      $(".insertando").removeClass("d-none");
    } else {
      $("#textNombreEmpresa").text(data[0].descrEmpresa);
      $("#textTelefono").text(data[0].tlfEmpresa);
      $("#textEmail").text(data[0].emailEmpresa);
      $("#textNif").text(data[0].nifEmpresa);
      $("#textWeb").text(data[0].webEmpresa);
      $("#TextRegEmpresa").text(data[0].regEmpresa);
      $("#textfactpro").text(data[0].numFacturaPro);
      $("#textfac").text(data[0].numFactura);
      $("#textfacneg").text(data[0].numFacturaNeg);
      $("#textPreFact").text(data[0].prefijoFact);
      $("#textPrePro").text(data[0].prefijoPro);

      $("#TextDireccion").text(data[0].dirEmpresa);
      $("#TextPoblacion").text(data[0].poblaEmpresa);
      $("#TextProvincia").text(data[0].provEmpresa);
      $("#TextCP").text(data[0].cpEmpresa);
      $("#TextPais").text(data[0].paisEmpresa);

      $("#divMostrarEmpresa").removeClass("d-none");
      $("#divInsertarEmpresa").addClass("d-none");

      $(".editando").removeClass("d-none");
      $(".insertando").addClass("d-none");
    }
  });
}

mostrarDatosEmpresa();

/***********************************/
/**********************************/
/*********************************/

/***********************************/
/********* AÑADIR DATOS ***********/
/*********************************/

$("#formEmpresa").on("submit", function (event) {
  event.preventDefault();

  nombreEmpresaRex = new validarCamposRegex(
    $("#inputNombreEmpresa"),
    /^(?=.{2,80}$)[a-zA-ZáéíóúñÑÁÉÍÓÚüÜ0-9\s]+$/gm
  );
  let resultadoNombre = nombreEmpresaRex.validarRegex();

  inputTelfEmpresaRex = new validarCamposRegex(
    $("#inputTelf"),
    /^(?=.{1,12}$)[0-9\s]+$/gm
  );
  let resultadoTelfEmpresaRex = inputTelfEmpresaRex.validarRegex();

  inputEmailEmpresaRex = new validarCamposRegex(
    $("#inputEmail"),
    /^[\w.%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/gm
  );
  let resultadoEmailEmpresaRex = inputEmailEmpresaRex.validarRegex();

  inputNifEmpresaRex = new validarCamposRegex(
    $("#inputNif"),
    /^[A-HJNP-SUVW][0-9]{7}[0-9A-J]$|^[KLMXYZ][0-9]{7}[A-J]$|^[0-9]{8}[A-Za-z]$/gm
  );
  let resultadoinputNif = inputNifEmpresaRex.validarRegex();
  inputWebEmpresaRex = new validarCamposRegex(
    $("#inputWeb"),
    /^(http|https):\/\/[a-z0-9]+([\-.][a-z0-9]+)*\.[a-z]{2,3}(:[0-9]{1,5})?(\/.*)?$/gm
  );
  let resultadoinputWeb = inputWebEmpresaRex.validarRegex();

  inputDireccionEmpresaRex = new validarCamposRegex(
    $("#inputDireccion"),
    /^[a-zA-Z0-9áéíóúñÑÁÉÍÓÚüÜ\s\,\.\-\#\/]+$/gm
  );
  let resultadoinputDireccion = inputDireccionEmpresaRex.validarRegex();

  inputPoblacionEmpresaRex = new validarCamposRegex(
    $("#inputPoblacion"),
    /^[a-zA-ZáéíóúñÑÁÉÍÓÚüÜ\s]{2,80}$/gm
  );
  let resultadoinputPoblacion = inputPoblacionEmpresaRex.validarRegex();

  inputProvinciaEmpresaRex = new validarCamposRegex(
    $("#inputProvincia"),
    /^[a-zA-ZáéíóúñÑÁÉÍÓÚüÜ\s]{2,80}$/gm
  );
  let resultadoinputProvincia = inputProvinciaEmpresaRex.validarRegex();

  inputinputCPEmpresaRex = new validarCamposRegex(
    $("#inputCP"),
    /^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/gm
  );
  let resultadoinputCP = inputinputCPEmpresaRex.validarRegex();

  inputPaisEmpresaRex = new validarCamposRegex(
    $("#inputPais"),
    /^[a-zA-ZáéíóúñÑÁÉÍÓÚüÜ\s]{1,12}$/gm
  );
  let resultadoPaisEmpresaRex = inputPaisEmpresaRex.validarRegex();

  prefijoProEmpresaRex = new validarCamposRegex(
    $("#prefijoPro"),
    /^[a-zA-Z0-9]*$/gm
  );
  let resultadoProEmpresaRex = prefijoProEmpresaRex.validarRegex();

  prefijoFactEmpresaRex = new validarCamposRegex(
    $("#prefijoFact"),
    /^[a-zA-Z0-9]*$/gm
  );
  let resultadoFactEmpresaRex = prefijoFactEmpresaRex.validarRegex();

  inputfactProEmpresaRex = new validarCamposRegex(
    $("#inputfactPro"),
    /^[a-zA-Z0-9]*$/gm
  );
  let resultadofactProEmpresaRex = inputfactProEmpresaRex.validarRegex();

  inputfactNegEmpresaRex = new validarCamposRegex(
    $("#inputfactNeg"),
    /^[a-zA-Z0-9]*$/gm
  );
  let resultadofactNegEmpresaRex = inputfactNegEmpresaRex.validarRegex();

  if (
    resultadoNombre === false ||
    resultadoTelfEmpresaRex === false ||
    resultadoEmailEmpresaRex === false ||
    resultadoinputNif === false ||
    resultadoinputWeb === false ||
    resultadoinputDireccion === false ||
    resultadoinputPoblacion === false ||
    resultadoinputProvincia === false ||
    resultadoinputCP === false ||
    resultadoPaisEmpresaRex === false ||
    resultadoProEmpresaRex === false ||
    resultadoFactEmpresaRex === false ||
    resultadofactProEmpresaRex === false ||
    resultadofactNegEmpresaRex === false
  ) {
    toastr.warning("Alguno de los campos no cumple con los requisitos.");
  } else {
    var formData = new FormData($("#formEmpresa")[0]);

    $.ajax({
      url: "../../controller/empresa.php?op=insertarEmpresa",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (texto) {
        mostrarDatosEmpresa();

        swal.fire("Empresa", "La empresa ha sido añadida.", "success");

        // Vaciar los datos del FormData
        formData.forEach(function (value, key) {
          formData.delete(key);
        });
        $("#formEmpresa")[0].reset();
      }, // del success
    }); // del ajax
  }
});

/***********************************/
/**********************************/
/*********************************/

/***********************************/
/********* EDITAR DATOS ***********/
/*********************************/

function cancelarEditar() {
  $("#divMostrarEmpresa").removeClass("d-none");
  $("#divInsertarEmpresa").addClass("d-none");
}
function cargarDatosEmpresa() {
  $("#divMostrarEmpresa").addClass("d-none");
  $("#divInsertarEmpresa").removeClass("d-none");

  $.post("../../controller/empresa.php?op=listarEmpresa", function (data) {
    var data = JSON.parse(data);

    $("#inputIdEmpresa").val(data[0].idEmpresa);

    $("#inputNombreEmpresa").val(data[0].descrEmpresa);
    $("#inputTelf").val(data[0].tlfEmpresa);
    $("#inputEmail").val(data[0].emailEmpresa);
    $("#inputNif").val(data[0].nifEmpresa);
    $("#inputWeb").val(data[0].webEmpresa);
    $("#inputRegEmpresa").val(data[0].regEmpresa);
    $("#prefijoPro").val(data[0].prefijoPro);
    $("#prefijoFact").val(data[0].prefijoFact);
    $("#inputfactPro").val(data[0].numFacturaPro);
    $("#inputfact").val(data[0].numFactura);
    $("#inputfactNeg").val(data[0].numFacturaNeg);

    $("#inputDireccion").val(data[0].dirEmpresa);
    $("#inputPoblacion").val(data[0].poblaEmpresa);
    $("#inputProvincia").val(data[0].provEmpresa);
    $("#inputCP").val(data[0].cpEmpresa);
    $("#inputPais").val(data[0].paisEmpresa);
  });
}

// Guardar editar
function editarEmpresa() {
  var formData = new FormData($("#formEmpresa")[0]);

  $.ajax({
    url: "../../controller/empresa.php?op=editarEmpresa",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (texto) {
      mostrarDatosEmpresa();

      swal.fire("Empresa", "La empresa se ha editado con éxito.", "success");

      // Vaciar los datos del FormData
      formData.forEach(function (value, key) {
        formData.delete(key);
      });
      $("#formEmpresa")[0].reset();
    }, // del success
  }); // del ajax
}

/***********************************/
/**********************************/
/*********************************/

/***********************************/
/**********************************/
/*********************************/
/**********VALIDAR EDITAR********/
/**********************************/
/*********************************/

$("#inputNombreEmpresa").blur(function () {
  campo1 = new validarCampos(
    $("#inputNombreEmpresa"),
    /^(?=.{2,80}$)[a-zA-ZáéíóúñÑÁÉÍÓÚüÜ0-9\s]+$/gm,
    $("#infoInputNombreEmpresa")
  );
  campo1.validar();
});

$("#inputTelf").blur(function () {
  campo1 = new validarCampos(
    $("#inputTelf"),
    /^(?=.{1,12}$)[0-9\s]+$/gm,
    $("#infoInputTelf")
  );
  campo1.validar();
});

$("#inputEmail").blur(function () {
  campo1 = new validarCampos(
    $("#inputEmail"),
    /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
    $("#infoInputEmail")
  );
  campo1.validar();
});

$("#inputNif").blur(function () {
  campo1 = new validarCampos(
    $("#inputNif"),
    /^[A-HJNP-SUVW][0-9]{7}[0-9A-J]$|^[KLMXYZ][0-9]{7}[A-J]$|^[0-9]{8}[A-Za-z]$/gm,
    $("#infoInputNif")
  );
  campo1.validar();
});

$("#inputWeb").blur(function () {
  campo1 = new validarCampos(
    $("#inputWeb"),
    /^(http|https):\/\/[a-z0-9]+([\-.][a-z0-9]+)*\.[a-z]{2,3}(:[0-9]{1,5})?(\/.*)?$/gm,
    $("#infoInputWeb")
  );
  campo1.validar();
});

$("#inputDireccion").blur(function () {
  campo1 = new validarCampos(
    $("#inputDireccion"),
    /^[a-zA-Z0-9áéíóúñÑÁÉÍÓÚüÜ\s\,\.\-\#\/]+$/gm,
    $("#infoInputDireccion")
  );
  campo1.validar();
});

$("#inputPoblacion").blur(function () {
  campo1 = new validarCampos(
    $("#inputPoblacion"),
    /^[a-zA-ZáéíóúñÑÁÉÍÓÚüÜ\s]{2,80}$/gm,
    $("#infoInputDireccion")
  );
  campo1.validar();
});

$("#inputProvincia").blur(function () {
  campo1 = new validarCampos(
    $("#inputProvincia"),
    /^[a-zA-ZáéíóúñÑÁÉÍÓÚüÜ\s]{2,70}$/gm,
    $("#infoInputProvincia")
  );
  campo1.validar();
});

$("#inputCP").blur(function () {
  campo1 = new validarCampos(
    $("#inputCP"),
    /^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/gm,
    $("#infoInputCP")
  );
  campo1.validar();
});

$("#inputPais").blur(function () {
  campo1 = new validarCampos(
    $("#inputPais"),
    /^[a-zA-ZáéíóúñÑÁÉÍÓÚüÜ\s]{1,12}$/gm,
    $("#infoInputPais")
  );
  campo1.validar();
});

$("#prefijoPro").blur(function () {
  campo1 = new validarCampos(
    $("#prefijoPro"),
    /^[a-zA-Z0-9]*$/gm,
    $("#infoInputPro")
  );
  campo1.validar();
});

$("#prefijoFact").blur(function () {
  campo1 = new validarCampos(
    $("#prefijoFact"),
    /^[a-zA-Z0-9]*$/gm,
    $("#infoInputFact")
  );
  campo1.validar();
});

$("#inputfactPro").blur(function () {
  campo1 = new validarCampos(
    $("#inputfactPro"),
    /^[0-9]+$/gm,
    $("#infoInputFactPro")
  );
  campo1.validar();
});

$("#inputfact").blur(function () {
  campo1 = new validarCampos(
    $("#inputfact"),
    /^[0-9]+$/gm,
    $("#infoInputFactPro")
  );
  campo1.validar();
});

$("#inputfactNeg").blur(function () {
  campo1 = new validarCampos(
    $("#inputfactNeg"),
    /^[0-9]+$/gm,
    $("#infoInputFactPro")
  );
  campo1.validar();
});

///////////////////////////////////////////////////////
//////////////////////////////////////////////////////
///////////// SWITCH PERSONALIZACIÓN ////////////////
////////////////////////////////////////////////////
///////////////////////////////////////////////////
// Inicializar Bootstrap Switch
// CARGAR AL INICIO BD
// 0 proforma 1 presu
/* $("#tipoPresupuestoSwitch").bootstrapSwitch();
    // Configurar el estado inicial del Bootstrap Switch
    if ($('#tipoPresupuestoSwitch').val() == 1) {
        $("#tipoPresupuestoSwitch").bootstrapSwitch("state", true);
    } else {
        $("#tipoPresupuestoSwitch").bootstrapSwitch("state", false);
    }
    $("#mostrarTrimestralSwitch").bootstrapSwitch();
    // Configurar el estado inicial del Bootstrap Switch
    if ($('#mostrarTrimestralSwitch').val() == 1) {
        $("#mostrarTrimestralSwitch").bootstrapSwitch("state", true);
    } else {
        $("#mostrarTrimestralSwitch").bootstrapSwitch("state", false);
    }
    $("#mostrarQuincenasSwitch").bootstrapSwitch();
    // Configurar el estado inicial del Bootstrap Switch
    if ($('#mostrarQuincenasSwitch').val() == 1) {
        $("#mostrarQuincenasSwitch").bootstrapSwitch("state", true);
    } else {
        $("#mostrarQuincenasSwitch").bootstrapSwitch("state", false);
    }
    $("#mostrarSancionSwitch").bootstrapSwitch();
    // Configurar el estado inicial del Bootstrap Switch
    if ($('#mostrarSancionSwitch').val() == 1) {
        $("#mostrarSancionSwitch").bootstrapSwitch("state", true);
    } else {
        $("#mostrarSancionSwitch").bootstrapSwitch("state", false);
    } */
//! CARGAR SWITCH !//
// Configurar el estado inicial del Bootstrap Switch
if ($("#mostrarFacturasSwitch").val() == 1) {
  $("#mostrarFacturasSwitch")
    .next()
    .find(".presupuesto")
    .addClass("tx-18 tx-bold");
  $("#mostrarFacturasSwitch").prop("checked", true);
} else {
  $("#mostrarFacturasSwitch")
    .next()
    .find(".proforma")
    .addClass("tx-18 tx-bold");
}

// Configurar el estado inicial del Bootstrap Switch

if ($("#trimestralSwitch").val() == 1) {
  $("#trimestralSwitch").next().find(".trimestral").addClass("tx-18 tx-bold");
  $("#trimestralSwitch").prop("checked", true);
}
// Configurar el estado inicial del Bootstrap Switch
console.log($("#quincenasSwitch").val());
if ($("#quincenasSwitch").val() == 1) {
  $("#quincenasSwitch").next().find(".quincenal").addClass("tx-18 tx-bold");
  $("#quincenasSwitch").prop("checked", true);
}
// Configurar el estado inicial del Bootstrap Switch
if ($("#sancionSwitch").val() == 1) {
  $("#sancionSwitch").next().find(".sancion").addClass("tx-18 tx-bold");
  $("#sancionSwitch").prop("checked", true);
}
if ($("#conteprecintoSwitch").val() == 1) {
  $("#conteprecintoSwitch").next().find(".conteprecinto").addClass("tx-18 tx-bold");
  $("#conteprecintoSwitch").prop("checked", true);
}
//! CARGAR SWITCH !//

//! BOTONES SWITCH !//
//EJECUTAR FUNCION
$("#mostrarFacturasSwitch").on("change", function () {
  tabla = "tipoPresupusto";
  if ($(this).is(":checked")) {
    estado = 1;
    $("#mostrarFacturasSwitch")
      .next()
      .find(".presupuesto")
      .addClass("tx-18 tx-bold");
    $("#mostrarFacturasSwitch")
      .next()
      .find(".proforma")
      .removeClass("tx-18 tx-bold");
  } else {
    estado = 0;
    $("#mostrarFacturasSwitch")
      .next()
      .find(".proforma")
      .addClass("tx-18 tx-bold");
    $("#mostrarFacturasSwitch")
      .next()
      .find(".presupuesto")
      .removeClass("tx-18 tx-bold");
  }

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
      toastr["success"]("Tipo de presupuesto actualizado");
    }
  );
});

$("#trimestralSwitch").on("change", function () {
  tabla = "mostrarTrimestral";
  if ($(this).is(":checked")) {
    estado = 1;
    $("#trimestralSwitch").next().find(".trimestral").addClass("tx-18 tx-bold");
  } else {
    estado = 0;
    $("#trimestralSwitch")
      .next()
      .find(".trimestral")
      .removeClass("tx-18 tx-bold");
  }

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
      toastr["success"]("Trimestral Actualizado");
    }
  );
});


$("#conteprecintoSwitch").on("change", function () {
  tabla = "mostrarContPrecinto";
  if ($(this).is(":checked")) {
    estado = 1;
    $("#conteprecintoSwitch").next().find(".conteprecinto").addClass("tx-18 tx-bold");
  } else {
    estado = 0;
    $("#conteprecintoSwitch")
      .next()
      .find(".conteprecinto")
      .removeClass("tx-18 tx-bold");
  }

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
      toastr["success"]("Contenedor/Precinto Actualizado");
    }
  );
});

$("#quincenasSwitch").on("change", function () {
  tabla = "mostrarQuincenas";
  if ($(this).is(":checked")) {
    estado = 1;
    $("#quincenasSwitch").next().find(".quincenal").addClass("tx-18 tx-bold");
  } else {
    estado = 0;
    $("#quincenasSwitch")
      .next()
      .find(".quincenal")
      .removeClass("tx-18 tx-bold");
  }

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
      toastr["success"]("Quincenas actualizado");
    }
  );
});

$("#sancionSwitch").on("change", function () {
  tabla = "mostrarSancion";
  if ($(this).is(":checked")) {
    estado = 1;
    $("#sancionSwitch").next().find(".sancion").addClass("tx-18 tx-bold");
  } else {
    estado = 0;
    $("#sancionSwitch").next().find(".sancion").removeClass("tx-18 tx-bold");
  }
  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
      toastr["success"]("Sanción Actualizada");
    }
  );
});
//! BOTONES SWITCH !//

// ACTUALIZAR COLOR
function actualizarColor() {
  //RECOGEMOS COLOR ACTUAL
  color = $("#wheel-demo").val();
  tabla = "colorPrincipal";

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: color },
    function (data) {
      toastr["success"]("Color actualizado");
    }
  );
}

// ACTUALIZAR NOMBRE.
$("#nombreConfigEmpresa").keyup(function () {
  let nombreRex = new validarCamposRegex($(this), /^[\p{L}\s]{1,20}$/u);
  let resultadoNombre = nombreRex.validarRegex();
});
function actualizarNombre() {
  let nombreRex = new validarCamposRegex($("#nombreConfigEmpresa"), 0, 1, 20);
  let resultadoNombre = nombreRex.validarRegex();

  if (resultadoNombre == true) {
    nombreEmpresa = $("#nombreConfigEmpresa").val();
    tabla = "nombreEmpresa";

    $.post(
      "../../controller/empresa.php?op=actualizarConfiguracion",
      { tabla: tabla, estado: nombreEmpresa },
      function (data) {
        toastr["success"]("Nombre Actualizado");
      }
    );
  } else {
    toastr["error"]("Solo está permitido letras", "Nombre Empresa");
  }
}

// ACTUALIZAR CODIGO LOCAL
$("#codigoConfigEmpresa").keyup(function () {
  let codigoRex = new validarCamposRegex($(this), /^[0-9#]{1,6}$/);
  let resultadoCodigo = codigoRex.validarRegex();
});
function actualizarCodigo() {
  let codigoRex = new validarCamposRegex(
    $("#codigoConfigEmpresa"),
    /^[0-9#]{1,6}$/u
  );
  let resultadoCodigo = codigoRex.validarRegex();

  if (resultadoCodigo == true) {
    codigoConfigEmpresa = $("#codigoConfigEmpresa").val();
    tabla = "codigoPuertaLocal";

    $.post(
      "../../controller/empresa.php?op=actualizarConfiguracion",
      { tabla: tabla, estado: codigoConfigEmpresa },
      function (data) {
        toastr["success"]("Código Local Actualizado");
      }
    );
  } else {
    toastr["error"]("Solo está permitido números", "Código Local");
  }
}

/* $(document).ready(function () {
    $("#tipoPresupuesto").bootstrapSwitch("state", false);


  // TIPO PRESUPUESTO
  console.log($('#tipoPresupuesto').val() );

   // Inicializar Bootstrap Switch
   $("#tipoPresupuesto").bootstrapSwitch();

   // Configurar el estado inicial del Bootstrap Switch
   if ($('#tipoPresupuesto').val() == 1) {
       console.log('false');
       $("#tipoPresupuesto").bootstrapSwitch("state", false);
   } else {
       $("#tipoPresupuesto").bootstrapSwitch("state", false);
   }


}); */

/* // SI HAY DATOS EN LA BD, PONER SWITCH false
    if ($('#partActAlumno').val() == 1) {
  
      // Establecer el valor del Bootstrap Switch a false
      $("#partActAlumno").bootstrapSwitch("state", false);
    } else {
      $("#partActAlumno").bootstrapSwitch("state", false);
  
    }
  
  
    // Inicializar el switch
    $("#partActAlumno").bootstrapSwitch();
  
    // Obtener el estado actual del switch
    var switchValuePartActAlumno = $("#partActAlumno").bootstrapSwitch("state");
  
    // Verificar el estado del switch
    if (switchValuePartActAlumno) {
      $('#numActAlumnoDiv').addClass('d-none');
  
    } else {
      $('#numActAlumnoDiv').removeClass('d-none');
  
    }
  
    // Capturar el evento de cambio del switch
    $("#partActAlumno").on("switchChange.bootstrapSwitch", function (event, state) {
      // Obtener el estado actual del switch
      var switchValuePartActAlumno = state;
  
      // Verificar el estado del switch y realizar acciones
      if (switchValuePartActAlumno) {
        $('#numActAlumnoDiv').addClass('d-none');
        $('#numActAlumno').val('');
        // Realizar acciones adicionales cuando el switch está encendido
      } else {
        $('#numActAlumnoDiv').removeClass('d-none');
        // Realizar acciones adicionales cuando el switch está apagado
      }
    });
  }); */
