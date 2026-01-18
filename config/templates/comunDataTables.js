/* var idTabla = $(".idTabla").val();
console.log("🚀 ~ idTabla:", idTabla)
var g1 = $("#g1").val();
var g2 = $("#g2").val();
var g3 = $("#g3").val();
var colorAuto = $("#colorAuto").val();
var colorAutoElement = $("#colorAuto").length;
var desplegado = $("#desplegado").val();
var colorPickerView = $("#colorPickerView").val();
var agrupacionesPersonalizadas = $("#agrupacionesPersonalizadas").val();
var cantidadGrupos = $("#cantidadGrupos").val();
var cantidadCount = $(".inputCantidad").length; */

function reducirLuminosidad(color, porcentaje) {
  // Parse the hexadecimal color to an integer value
  var colorInt = parseInt(color.substr(1), 16);

  // Calculate the reduction amount for each component
  var reduccion = 1 - porcentaje;

  // Reduce the intensity of each RGB component based on the given percentage
  var r = Math.round(((colorInt >> 16) & 255) * reduccion);
  var g = Math.round(((colorInt >> 8) & 255) * reduccion);
  var b = Math.round((colorInt & 255) * reduccion);

  // Convert the RGB components back to a hexadecimal color
  var nuevoColor =
    "#" + ((r << 16) | (g << 8) | b).toString(16).padStart(6, "0");

  return nuevoColor;
}

// Function that takes a color and returns the array with colors reduced by 90%, 75%, and 50%
function obtenerColoresReducidos(color, cantidad) {
  var coloresReducidos = [];
  cantidad == 1 ? coloresReducidos.push(reducirLuminosidad(color, 0.1)) : "";
  cantidad == 2
    ? coloresReducidos.push(reducirLuminosidad(color, 0.35)) &&
      coloresReducidos.push(reducirLuminosidad(color, 0.1))
    : "";
  cantidad == 3
    ? coloresReducidos.push(reducirLuminosidad(color, 0.5)) &&
      coloresReducidos.push(reducirLuminosidad(color, 0.35)) &&
      coloresReducidos.push(reducirLuminosidad(color, 0.1))
    : "";

  return coloresReducidos;
}
function isColorDark(color) {
  // Función para extraer los valores RGB de un color en formato hexadecimal
  function hexToRgb(hex) {
    const bigint = parseInt(hex.replace("#", ""), 16);
    const r = (bigint >> 16) & 255;
    const g = (bigint >> 8) & 255;
    const b = bigint & 255;
    return { r, g, b };
  }

  // Función para calcular la luminosidad de un color
  function getLuminance(color) {
    const { r, g, b } = color;
    const rgb = [r / 255, g / 255, b / 255];
    for (let i = 0; i < rgb.length; i++) {
      if (rgb[i] <= 0.03928) {
        rgb[i] = rgb[i] / 12.92;
      } else {
        rgb[i] = Math.pow((rgb[i] + 0.055) / 1.055, 2.4);
      }
    }
    const luminance = 0.2126 * rgb[0] + 0.7152 * rgb[1] + 0.0722 * rgb[2];
    return luminance;
  }

  // Convertir el color hexadecimal a valores RGB
  const rgbColor = hexToRgb(color);

  // Calcular la luminosidad del color
  const luminance = getLuminance(rgbColor);

  // Determinar si el color es oscuro o claro
  return luminance <= 0.5; // Puedes ajustar el valor umbral para definir qué considerar oscuro o claro
}

function recalcularLimites() {
  $(".dataTable thead tr").each(function () {
    var lastVisibleHeader = null;
    $(this)
      .find("th")
      .each(function () {
        if (!$(this).hasClass("dtr-hidden")) {
          lastVisibleHeader = $(this);
        }
      });

    if (lastVisibleHeader) {
      lastVisibleHeader.css("--bs-bg-opacity", "1");
      lastVisibleHeader.css(
        "border-right",
        "1px solid rgba(var(--bs-dark-grey-rgb), var(--bs-bg-opacity))"
      );
    }
  });
  $(".dataTable tfoot tr").each(function () {
    var lastVisibleHeader = null;
    $(this)
      .find("th")
      .each(function () {
        if (!$(this).hasClass("dtr-hidden")) {
          lastVisibleHeader = $(this);
        }
      });

    if (lastVisibleHeader) {
      lastVisibleHeader.css("--bs-bg-opacity", "1");
      lastVisibleHeader.css(
        "border-right",
        "1px solid rgba(var(--bs-dark-grey-rgb), var(--bs-bg-opacity))"
      );
    }
  });
  $(".dataTable tbody tr").each(function () {
    var lastVisibleCell = null;
    $(this)
      .children()
      .each(function () {
        if (!$(this).hasClass("dtr-hidden")) {
          //console.log($(this).attr("class"));
          lastVisibleCell = $(this);
        }
      });

    if (lastVisibleCell) {
      lastVisibleCell.css("--bs-bg-opacity", "1");
      lastVisibleCell.css(
        "border-left",
        "1px solid rgba(var(--bs-dark-grey-rgb), var(--bs-bg-opacity))"
      );
    }
  });
}


$(".dtAuto").each(function () {
  var idTabla = $(".idTabla").eq(0).val();
  console.log("🚀 ~ idTabla:", idTabla);
  var g1 = $(".g1").eq(0).val();
  var g2 = $(".g2").eq(0).val();
  var g3 = $(".g3").eq(0).val();
  var colorAuto = $(".colorAuto").eq(0).val();
  var colorAutoElement = $(".colorAuto").eq(0).length;
  var desplegado = $(".desplegado").eq(0).val();
  var colorPickerView = $("#colorPickerView").eq(0).val();
  var agrupacionesPersonalizadas = $(".agrupacionesPersonalizadas")
    .eq(0)
    .val();
  var cantidadGrupos = $(".cantidadGrupos").eq(0).val();
  var cantidadCount = $(".inputCantidad").length;

  $(".idTabla").eq(0).remove();
  $(".g1").eq(0).remove();
  $(".g2").eq(0).remove();
  $(".g3").eq(0).remove();
  $(".colorAuto").eq(0).remove();
  $(".desplegado").eq(0).remove();
  $(".colorPickerView").eq(0).remove();
  $(".agrupacionesPersonalizadas").eq(0).remove();
  $(".cantidadGrupos").eq(0).remove();

  // Obtener la ruta actual
  var path = window.location.pathname;
  // Separar la ruta en partes usando '/'
  var parts = path.split("/");

  // La carpeta actual será el penúltimo elemento en la matriz
  var currentFolder = parts[parts.length - 2];

  var $toolbar = null; // Variable para almacenar el elemento del botón y el tooltip
  var toolbarInitialized = false; // Variable de control para verificar si el código ya se ejecutó
  const estado = {
    savedStates: {},
  };

  $.extend(true, $.fn.dataTable.defaults, {
    // con esto le estamos diciendo que todas las tablas de la pagina se van a comportar igual
    //scrollY: 200,  // El datatables se adaptará a ese tamaño de ALTO se mode en px
    //scrollY: 80vh , // El datatables ocupará el 80% del ancho de la pantalla
    //scroller: true, // con este parametro, desaparece el mostrar registros, se muestran todos y permite scroll, debe ir con scrollY necesariamente.
    //scrollX: 200,
    autoWidth: true, //Habilita o deshabilita el cálculo automático del ancho de columna.
    colReorder: false, // Nos permite reordenar las columnas
    aProcessing: true, //Activamos el procesamiento del datatables
    ServerSide: true, //Paginación y filtrado realizados por el servidor
    destroy: true,
    fixedHeader: true, // con esto fijamos las cabeceras en la parte superior de la pantalla
    responsive: true,
    stateSave: true,

    stateSaveParams: function (settings, data) {
      data.colores = estado.savedStates.colores; // Guardar el estado de 'colores'
    },
    stateLoadParams: function (settings, data) {
      estado.savedStates.colores = data.colores; // Recuperar el estado de 'colores'
    },
    info: true, //mostrandio xxx de xx registros
    //https://datatables.net/reference/option/pagingType
    paging: true, //quita no solo la información, sino toda la paginacion, se muestra todo de golpe
    ordering: false, // quitar la posibilidad de ordenacion de las columnas
    searching: true, // quitar el sistema de busqueda
    // Cambiar el lenguaje - https://datatables.net/plug-ins/i18n/Spanish.html
    language: {
      // url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
      url: "../../public/espanol.json",
      //url: "espanol.json"
      //cdn.datatables.net/plug-ins/1.11.3/i18n/ --> Varios Archivos
    },
    deferRender: true, // Esta indicado para gran cantidad de datos, solo los cargará cuando los necesite
    lengthChange: true, // controla la capacidad para que el usuario cambie la longitud de las rows que está viendo, si esto está a false, no aparecerá el lengthMenu
    lengthMenu: [
      // para sobreescribir los datos de MOSTRAR
      [10, 20, 30, -1],
      [10, 20, 30, "Todos"], // son dos arrays, el primero son los datos y el segundo es el texto que se va a mostrar (el -1 son Todos)
    ],
    select: true, // nos permite seleccionar filas para exportar
    //https://datatables.net/reference/button/ -> lista de botones que podemos colocar
    //https://datatables.net/reference/option/dom - Lista de opciones que deben aparecer
    //dom: '<"toolbar">lBfrtip', //Definimos los elementos del control de tabla
    dom: "QlBfrtip", //Definimos los elementos del control de tabla, se quita la f por que tenemos un campo propio
    // l - Mostrar xxx Registros
    // B - Botones para exportar
    // f - Buscar
    // r - ?????
    // t - La propia tabla - ????
    // i - Informacion - Mostrando xxx de xxx registros
    // p - Paginación
    // B - Son Botones
    // Q - Busqueda compleja
    // https://datatables.net/reference/option/#searchbuilder

    buttons: [
      // Estos no les veo utilidad
      // 'selectRows',
      // 'selectColumns',
      // 'selectCells',
      {
        extend: "savedStates",
        text: '<span class= "btn btn-outline-info" data-toggle="tooltip"  id="btn-help" title = "Estados" ><i class="fa-regular fa-floppy-disk"></i></span >',
        buttons: ["createState", "removeAllStates"],
      },
      // BARRA PARA SEPARAR ICONOS
      {
        extend: "spacer",
        style: "bar",
      },
      //======================================================
      // ==  MENU DE AYUDA - HACE CLICK EN UN BOTON OCULTO  ==
      //======================================================
      {
        text: '<span class= "btn btn-outline-info" data-toggle="tooltip"  id="btn-help" style="cursor: help" title = "Ayuda" > <i class="fa-regular fa-circle-question"></i></span >',
        action: function (e, dt, node, config) {
          $("#modalAyuda").modal("show");
        },
      },

      //=============================
      // ==  ESPACIADOR VERTICAL   ==
      //=============================
      {
        extend: "spacer",
        style: "bar",
        //text: 'Visualizador'  // Pone a continuación del espaciador este texto.
      },

      {
        text: '<span class= "btn quitarFiltros btn-outline-info" data-toggle="tooltip"  id="btn-help" style="cursor: help" title = "Quitar filtros" > <i class="fa-solid fa-filter-circle-xmark"></i></span >',
        action: function (e, dt, node, config) {
          dt.search("").columns().search("").draw();
        },
      },

      //======================================================
      //======================================================
      //======================================================
      // ==  BOTONES DE VISUALIZACIÓN DE COLUMNAS           ==
      // =========  4 FORMAS DE HACERLO           ============
      //======================================================
      //======================================================
      //======================================================

      //==========================================================
      // ==  PRIMERA FORMA - AÑADIENDO UN CLASS a las COLUMNS   ==
      //==========================================================

      //        {
      //            extend: 'columnVisibility',
      //            text: '<span class= "btn btn-outline-info ocultar-columnas" data-toggle="tooltip" title = "Ocultar columnas" > <i class="fa-solid fa-eye-slash"></i></span >',
      //            visibility: false,
      //            columns: ".secundaria"   /* Hay que poner en la columns -> class: "secundaria"*/
      //        },
      //        {
      //            extend: 'columnVisibility',
      //            text: '<span class= "btn btn-outline-info mostrar-columnas" data-toggle="tooltip" title = "Visualizar columnas" > <i class="fa-solid fa-eye"></i></span >',
      //            visibility: true, //Hacemos visibles la columnas
      //            columns: ".secundaria", /* Hay que poner en la columns -> class: "secundaria"*/
      //        },

      //=================================================================
      // FORMA NORMAL - PONER TODOS LOS BOTONES DE VISUALIZACION EN LINEA
      // UTILIZA MATRICES PARA MOSTRAR Y OCULTAR VARIAS COLUMNAS
      //=================================================================
      // {
      //     extend: 'colvisGroup',
      //     text: '<span class= "btn btn-outline-info ocultar-columnas" data-toggle="tooltip" title = "Ocultar columnas" > <i class="fa-solid fa-eye-slash"></i></span >',
      //     show: [1, 2, 4],
      //     hide: [0, 3]
      // },

      // {
      //     extend: 'colvisGroup',
      //     text: '<span class= "btn btn-outline-info mostrar-columnas" data-toggle="tooltip" title = "Visualizar columnas" > <i class="fa-solid fa-eye"></i></span >',
      //     show: [0, 1, 2, 4],  //Si se quiere visualizar todo se puede colocar ':hidden' y quitar lo de abajo "hide: []"
      //     hide: [3]
      // },

      //=======================================================================================
      // AGRUPAR BOTONES EN UN DESPLEGABLE, BOTON PRAL y cuando CLICK SE DESPLIEGA EN OTROS DOS
      //=======================================================================================
      // {
      //     extend: 'collection',
      //     text: '<span class="btn btn-outline-info" data-toggle="tooltip" title="Visualizar columnas"><i class="fa-solid fa-table-list"></i></span>',
      //     autoClose: true, // Esto hace que al seleccionar un sub-boton se cierre el desplegable, de otra forma permanecerá abierto
      //     buttons: [
      //         {
      //             extend: 'colvisGroup',
      //             text: '<span class= "btn btn-outline-info ocultar-columnas" data-toggle="tooltip" title = "Ocultar columnas" > <i class="fa-solid fa-eye-slash"></i></span >',
      //             show: [1, 2, 4],
      //             hide: [0, 3]
      //         },
      //         {
      //             extend: 'colvisGroup',
      //             text: '<span class= "btn btn-outline-info mostrar-columnas" data-toggle="tooltip" title = "Visualizar columnas" > <i class="fa-solid fa-eye"></i></span >',
      //             show: [0, 1, 2, 4],  //Si se quiere visualizar todo se puede colocar ':hidden' y quitar lo de abajo "hide: []"
      //             hide: [3]
      //         }
      //     ] // del buttons de la colección
      // }, // del collection

      //=================================================
      // ALTERNAR LA VISUALIZACION DE LA COLUMNA 1
      //================================================
      {
        //extend: 'colvisGroup',
        text: '<span class="btn btn-outline-info" data-toggle="tooltip" title="Conmutar visualizar columnas"><i class="fa-solid fa-table-list"></i></span>',
        action: function (e, dt, node, config) {
          dt.column(0).visible(!dt.column(0).visible());
        },
      },

      {
        extend: "colvis",
        text: '<span class="btn btn-outline-warning" data-toggle="tooltip" title="Visualizar-Ocultar columnas"><i class="fas fa-columns"></i></span>',
        // className: 'DataTable',
        postfixButtons: ["colvisRestore"],
        columns:
          ":not(.secundariaDef)" /* Relaciona con columnDef, solo mostrara en el desplegable para seleccionar la visualizacion aquellas que no tiene la clase secundaria*/,
        key: {
          shiftKey: true,
          key: "c",
        },
      },

      //======================================================
      //======================================================
      //=============== FIN  =================================
      // ==  BOTONES DE VISUALIZACIÓN DE COLUMNAS           ==
      // =========  4 FORMAS DE HACERLO           ============
      //======================================================
      //======================================================
      {
        extend: "spacer",
        style: "bar",
        //text: 'Visualizador'  // Pone a continuación del espaciador este texto.
      },

      //======================================================
      //======================================================
      //======================================================
      // ====  BOTONES DE FIJACION DE COLUMNAS            ====
      // =========  4 FORMAS DE HACERLO           ============
      //======================================================
      //======================================================
      //======================================================

      /* NOS SIRVE PARA CUANDO HACEMOS SCROLL X*/
      // {
      //     extend: 'fixedColumns',
      //     config: {
      //         left: 2,
      //         right: 1
      //     },
      //     text: 'Fijar'
      // },
      // {
      //     extend: 'spacer',
      //     style: 'bar'
      //},
      //======================================================
      //======================================================
      //=================  FIN  ==============================
      // ====  BOTONES DE FIJACION DE COLUMNAS            ====
      // =========  4 FORMAS DE HACERLO           ============
      //======================================================
      //======================================================

      //======================================================
      //======================================================
      //======================================================
      // ====  BOTONES DE EXPORTACION            =============
      // =========  AGRUPADOS          ========================
      //======================================================
      //======================================================
      //======================================================

      // Si queremos dar formato a las columnas antes de exportar, debo utilizar la función de render en las columnas

      {
        extend: "collection",
        text: '<span class="btn btn-outline-info" data-toggle="tooltip" title="Exportación de datos"><i class="fa-solid fa-file-export"></i></span>',
        autoClose: true, // Esto hace que al seleccionar un sub-boton se cierre el desplegable, de otra forma permanecerá abierto
        buttons: [
          {
            extend: "pdfHtml5",
            orientation: "landscape",
            pageSize: "A4",
            download: "open",
            footer: true, // con esto conseguimos que el footer se exporte también
            title: "Archivos",
            //messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.', //mensaje que aparece entre el TITULO y la EXPORTACION DE LA TABLA
            //messageBottom: '', // mensaje que aparece en el pie de la exportación.
            filename: "Archivos",
            text: '<span class="btn btn-outline-info" data-toggle="tooltip" title="PDF"><i class="fas fa-file-pdf"></i> PDF</span>',

            exportOptions: {
              columns: [0, ":visible"], // con esto conseguimos que la columna 0 se exporte
            },

            // ===========================
            // OTRA FORMA DE HACERLO
            // ===========================
            //exportOptions: {
            //    columns: [0, 1, 2, 3]
            //}
          },

          {
            extend: "excelHtml5",
            footer: true, // con esto conseguimos que el footer se exporte también
            title: "Archivos",
            //messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.', //mensaje que aparece entre el TITULO y la EXPORTACION DE LA TABLA
            //messageBottom: '', // mensaje que aparece en el pie de la exportación.
            filename: "Archivos",
            // autoFilter: true, // es una caracteristica propia de la excel de hacer autofiltros, no funciona con LibreOffice
            text: '<span  class="btn btn-outline-info" data-toggle="tooltip" title="Exportar EXCEL"><i class="fas fa-file-excel"></i> EXCEL</span>',
          },
          {
            extend: "csvHtml5",
            footer: true, // con esto conseguimos que el footer se exporte también
            filename: "Archivos",
            //messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.', //mensaje que aparece entre el TITULO y la EXPORTACION DE LA TABLA
            //messageBottom: '', // mensaje que aparece en el pie de la exportación.
            text: '<span class="btn btn-outline-info" data-toggle="tooltip" title="Exportar CSV"><i class="fas fa-file-csv"></i> CSV</span>',
          },
          {
            extend: "print",
            footer: true, // con esto conseguimos que el footer se exporte también
            filename: "Archivos",
            //messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.', //mensaje que aparece entre el TITULO y la EXPORTACION DE LA TABLA
            //messageBottom: '', // mensaje que aparece en el pie de la exportación.
            text: '<span class="btn btn-outline-info" data-toggle="tooltip" title="Imprimir"><i class="fas fa-print"></i> PRINT</span>',
          },
        ], // del buttons de la colección
      }, // del collection
      //======================================================
      //======================================================
      //=============    FIN      ============================
      // ====  BOTONES DE EXPORTACION            =============
      // =========  AGRUPADOS          ========================
      //======================================================
      //======================================================
      // Botón para conmutar visualizar la busqueda compleja
      {
        text: '<span class= "btn btn-outline-info" data-toggle="tooltip"  id="btn-help" style="cursor: pointer" title = "Conmutador Busqueda completa" > <i class="fa-solid fa-magnifying-glass" style="cursor: pointer"></i></span >',
        action: function (e, dt, node, config) {
          $(".dtsb-searchBuilder").toggle();
          $(".dtsb-searchBuilder").focus();
        },
        key: {
          key: "s",
          altkey: true,
        },
      },

      /* Botón de busqueda compleja*/
      // {
      //     extend: 'searchBuilder',
      //     text: '<span class="btn btn-outline-danger" data-toggle="tooltip" title="Busqueda compleja"><i class="fa-solid fa-magnifying-glass"></i></span>',
      //     key: {
      //         key: 's',
      //         altkey: true
      //     },
      //     className: 'btn-SearchBuilder' // del Key
      // }  // del searchBuilder
    ], // del buttons
    rowGroup: {
      dataSrc: [g1, g2, g3],
      startRender: function (rows, group) {
        if (!toolbarInitialized) {
          // Verificar si el código aún no se ha ejecutado

          if (
            "colores" in estado.savedStates &&
            estado.savedStates.colores != undefined
          ) {
            $toolbar = $(
              '<span class="dt-button-spacer bar"></span><button id="btnColorToolTip" class= "pd-t-7 pd-b-5 btn btn-outline-info pd-t-3 pd-b-2 mg-l-10" data-toggle="tooltip"><input type="color" class="bd-0 pd-0" value="' +
                estado.savedStates.colores +
                '" id="colores" style=""></button>'
            );
          } else {
            if (colorAutoElement > 0) {
              $toolbar = $(
                '<span class="dt-button-spacer bar"></span><button id="btnColorToolTip" class= "pd-t-7 pd-b-5 btn btn-outline-info pd-t-3 pd-b-2 mg-l-10" data-toggle="tooltip"><input type="color" class="bd-0 pd-0" value="' +
                  colorAuto +
                  '" id="colores" style=""></button>'
              );
            } else {
              $toolbar = $(
                '<span class="dt-button-spacer bar"></span><button id="btnColorToolTip" class= "pd-t-7 pd-b-5 btn btn-outline-info pd-t-3 pd-b-2 mg-l-10" data-toggle="tooltip"><input type="color" class="bd-0 pd-0 colores" value="' +
                  $("#colorPorDefectoBD").val() +
                  '" id="colores" style=""></button>'
              );
            }
          }
          if (colorPickerView == 1) {
            $(".ui-buttonset").append($toolbar);
            $("#colores").tooltip();
          }
          toolbarInitialized = true; // Actualizar la variable de control para indicar que el código ya se ha ejecutado

          $("#colores").on("change", function () {
            estado.savedStates["colores"] = $("#colores").val();

            var rgbaColor = $("#colores").val();
            $("#" + idTabla)
              .DataTable()
              .ajax.reload();
          });
        }

        var backgroundColor;

        if (colorPickerView == 1) {
          var colores = obtenerColoresReducidos(
            $("#colores").val(),
            cantidadCount
          );
          var isDark = isColorDark($("#colores").val()); // TRUE SI EL COLOR ES OSCURO FALSE SI ES CLASE
        } else {
          var colores = obtenerColoresReducidos(colorAuto, cantidadCount);
          var isDark = isColorDark(colorAuto); // TRUE SI EL COLOR ES OSCURO FALSE SI ES CLASE
        }

        var colorLetra = "black";
        if (isDark) {
          colorLetra = "white";
        } else {
          colorLetra = "black";
        }
        // Verificar si el grupo es igual a alguna columna de datos adicional
        if (g1 != "") {
          if (group === rows.data()[0][g1]) {
            if (agrupacionesPersonalizadas == 0) {
              // Grupo por columna de datos 12 (índice 11)
              backgroundColor = colores[0];

              if (colorAutoElement > 0) {
                return $('<tr class="group1">').append(
                  '<td colspan="10" style="background-color: ' +
                    backgroundColor +
                    "; opacity: 1; color: " +
                    colorLetra +
                    '"><label class="wd-95p">' +
                    group +
                    "</label></td>"
                );
              } else {
                return $('<tr class="group1">').append(
                  '<td colspan="10" style="background-color:' +
                    $("#colorPorDefectoBD").val() +
                    "; opacity: 1; color: " +
                    colorLetra +
                    '"><label class="wd-95p">' +
                    group +
                    "</label></td>"
                ); //COLOR POR DEFECTO
              }
            } else {
              return $('<tr class="group1">').append(
                '<td colspan="10"><label class="wd-95p">' +
                  group +
                  "</label></td>"
              );
            }
          }
        }
        if (g2 != "") {
          if (group === rows.data()[0][g2]) {
            if (agrupacionesPersonalizadas == 0) {
              // Grupo por columna de datos 30 (índice 29)
              backgroundColor = colores[1];

              if (colorAutoElement > 0) {
                return $('<tr class="group2">').append(
                  '<td colspan="10" style="background-color: ' +
                    backgroundColor +
                    "; opacity: 1; color: " +
                    colorLetra +
                    '"><i class="fa-solid fa-turn-up fa-rotate-90 mg-l-15"></i>  <label class="mg-l-10 noRotar">' +
                    group +
                    "</label>"
                );
              } else {
                return $('<tr class="group2">').append(
                  '<td colspan="10" style="background-color: ' +
                    $("#colorPorDefectoBD").val() +
                    "; opacity: 1; color: " +
                    colorLetra +
                    '"><i class="fa-solid fa-turn-up fa-rotate-90 mg-l-15"></i>  <label class="mg-l-10 noRotar">' +
                    group +
                    "</label>"
                );
              }
            } else {
              return $('<tr class="group2">').append(
                '<td colspan="10"><label class="wd-95p">' +
                  group +
                  "</label></td>"
              );
            }
          }
        }
        if (g3 != "") {
          if (group === rows.data()[0][g3]) {
            if (agrupacionesPersonalizadas == 0) {
              // Si no coincide con ninguno de los grupos adicionales, utilizar el grupo principal
              backgroundColor = colores[2];
              if (colorAutoElement > 0) {
                return $('<tr class="group3">').append(
                  '<td colspan="10" style="background-color: ' +
                    backgroundColor +
                    "; opacity: 1; color: " +
                    colorLetra +
                    '"><i class="fa-solid fa-turn-up fa-rotate-90 mg-l-30"></i>  <label class="mg-l-20 noRotar">' +
                    group +
                    "</label>"
                );
              } else {
                return $('<tr class="group3">').append(
                  '<td colspan="10" style="background-color: ' +
                    $("#colorPorDefectoBD").val() +
                    "; opacity: 1; color: " +
                    colorLetra +
                    '"><i class="fa-solid fa-turn-up fa-rotate-90 mg-l-30"></i>  <label class="mg-l-20 noRotar">' +
                    group +
                    "</label>"
                );
              }
            } else {
              return $('<tr class="group3">').append(
                '<td colspan="10"><label class="wd-95p">' +
                  group +
                  "</label></td>"
              );
            }
          }
        }
      },
    },

    initComplete: function (settings, json) {
      // Obtenemos el ID de la tabla que está ejecutando el initComplete
      let $table = $(settings.nTable);
      let idTabla = $table.attr("id"); // Obtenemos el id de la tabla actual
      recalcularLimites();
      if (desplegado == 1) {
        $("#conmutar").parent().parent().addClass("d-none");
        $(".dtrg-level-2").each(function () {
          $(this)
            .nextUntil(".dtrg-level-0, .dtrg-level-1, .dtrg-level-2")
            .toggle(); //Plegar todo hasta el proximo encabezado 2 pero si hay un encabezado 1 por medio se para ahi
        });
        $(".dtrg-level-1").each(function () {
          $(this).nextUntil(".dtrg-level-0, .dtrg-level-1").toggle(); //Plegar todo hasta el proximo encabezado 2 pero si hay un encabezado 1 por medio se para ahi
        });
        $(".dtrg-level-0").each(function () {
          $(this).nextUntil(".dtrg-level-0").toggle(); //Plegar todo hasta el proximo encabezado 2 pero si hay un encabezado 1 por medio se para ahi
        });
        /* 
        $(".group2").each(function(){
            
            $(this).nextUntil(".group1, .group2").toggle()//Lo mismo que el anterior pero agregando el encabezado 3
        });
        $(".group1").each(function(){
            
            $(this).nextUntil(".group1").toggle()//Lo mismo que el anterior pero agregando el encabezado 3
        }); */
      }
      // Seleccionar los divs generados por DataTables
        // Seleccionar los divs generados por DataTables usando la referencia a la tabla actual
    let dataTableLength = $table.closest(".dataTables_wrapper").find(".dataTables_length").addClass(
      "col-12 col-lg-3 d-flex justify-content-center justify-content-lg-start"
  );
  let dtButtons = $table.closest(".dataTables_wrapper").find(".dt-buttons.ui-buttonset").addClass(
      "col-12 col-lg-6 mt-lg-0 mt-2 d-flex justify-content-center responsive-buttons"
  );
  let dtSearch = $table.closest(".dataTables_wrapper").find(".dataTables_filter").addClass(
      "col-12 col-lg-3 mt-lg-0 mt-2 d-flex justify-content-center justify-content-lg-end"
  );
      $(".dataTables_length")
        .find("select")
        .addClass(idTabla + "_dtSelect2");
      $("." + idTabla + "_dtSelect2").select2({
        theme: "bootstrap-5",
        width: "100%",
        minimumResultsForSearch: Infinity, // Deshabilita el buscador
      });
      // Crear un nuevo div con la clase row
      let rowDiv = $("<div class='row'></div>");

      // Envolver los divs seleccionados dentro del nuevo div
      dataTableLength.add(dtButtons).add(dtSearch).wrapAll(rowDiv);
    },

    select: true,
    select: {
      style: "single", // Puedes usar 'single' o 'multi' dependiendo de si deseas seleccionar una fila a la vez o múltiples filas.
    },
  });

  //FUNCIONES PARA PLEGAR Y DESPLEGAR AGRUPACIONES//
  //****************************************************//
  //!IMPORANTE MANTENER EL MISMO ORDEN DE LAS FUNCIONES!//
  //!IMPORANTE MANTENER EL MISMO ORDEN DE LAS FUNCIONES!//
  //!IMPORANTE MANTENER EL MISMO ORDEN DE LAS FUNCIONES!//
  //****************************************************//

  //$("elementoElegido").nextUntil("elemento1","elemento2")   Te coge todos los elementos2 a partir del elementoElegido hasta llegar a un elemento1, este elemento1 no lo coge, solo coge elemento2

  if (typeof g3 !== "undefined") {
    //CUANDO HACES CLICK EN EL GRUPO 1
    $("#" + idTabla + " tbody").on("click", ".dtrg-level-1", function () {
      $(this).nextUntil(".dtrg-level-1", ".dtrg-level-2").toggle();
      if (
        $(this)
          .nextUntil(".dtrg-level-1", ".dtrg-level-2")
          .nextUntil(".dtrg-level-2", ".even")
          .css("display") != "none"
      ) {
        $(this)
          .nextUntil(".dtrg-level-1", ".dtrg-level-2")
          .nextUntil(".dtrg-group", ".even")
          .toggle();
      }
      if (
        $(this)
          .nextUntil(".dtrg-level-1", ".dtrg-level-2")
          .nextUntil(".dtrg-level-2", ".odd")
          .css("display") != "none"
      ) {
        $(this)
          .nextUntil(".dtrg-level-1", ".dtrg-level-2")
          .nextUntil(".dtrg-group", ".odd")
          .toggle();
      }
    });

    //CUANDO HACES CLICK EN EL GRUPO 2
    $("#" + idTabla + " tbody").on("click", ".dtrg-level-2", function () {
      $(this).nextUntil(".dtrg-group", ".odd, .even").toggle();
    });
    //CUANDO HACES CLICK EN EL GRUPO 0
    $("#" + idTabla + " tbody").on("click", ".dtrg-level-0", function () {
      //PLEGAR/DESPLEGAR EL GRUPO 1
      $(this)
        .nextUntil(".dtrg-level-0", ".dtrg-level-1")
        .each(function () {
          if (
            $(this).css("display") != "none" &&
            $(this)
              .nextUntil(".dtrg-level-1", ".dtrg-level-2")
              .css("display") == "none"
          ) {
            $(this).nextUntil(".dtrg-level-1", ".dtrg-level-2").toggle();
          }
          $(this).toggle();
        });
      //PLEGAR/DESPLEGAR EL GRUPO 2
      $(this)
        .nextUntil(".dtrg-level-0", ".dtrg-level-2")
        .each(function () {
          if (
            $(this).nextUntil(".dtrg-level-2", ".even").css("display") != "none"
          ) {
            $(this).nextUntil(".dtrg-group", ".even").toggle();
          }
          if (
            $(this).nextUntil(".dtrg-level-2", ".odd").css("display") != "none"
          ) {
            $(this).nextUntil(".dtrg-group", ".odd").toggle();
          }
          $(this).toggle();
        });
    });
  } else if (typeof g2 !== "undefined") {
    $("#" + idTabla + " tbody").on("click", ".dtrg-level-1", function () {
      $(this).nextUntil(".dtrg-group", ".odd, .even").toggle();
    });
    //CUANDO HACES CLICK EN EL GRUPO 0
    $("#" + idTabla + " tbody").on("click", ".dtrg-level-0", function () {
      var index = $(this).index(".dtrg-level-0") + 1; // Index comienza desde 0, por eso sumamos 1
      var totalElementos = $(".dtrg-level-0").length;

      //PLEGAR/DESPLEGAR EL GRUPO 1
      $(this)
        .nextUntil(".dtrg-level-0", ".dtrg-level-1")
        .each(function () {
          if (
            $(this).nextUntil(".dtrg-level-1", ".even").css("display") != "none"
          ) {
            $(this).nextUntil(".dtrg-group", ".even").toggle();
          }
          if (
            $(this).nextUntil(".dtrg-level-1", ".odd").css("display") != "none"
          ) {
            $(this).nextUntil(".dtrg-group", ".odd").toggle();
          }
          $(this).toggle();
        });
    });
  } else if (typeof g1 !== "undefined") {
    $("#" + idTabla + " tbody").on("click", ".dtrg-level-0", function () {
      $(this).nextUntil(".dtrg-group", ".odd, .even").toggle();
    });
  }

  $("#" + idTabla).on("responsive-resize.dt", function (e, datatable, columns) {
    console.log("redimensionado");
    recalcularLimites();
  });
});
