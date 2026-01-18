/**********************************************************************/
/**************** MOSTRAR LOGS ************************************/
/********************************************************************/



/*==================================*/
/*     INICIO DEL DATATABLES        */
/*==================================*/
/*===============================================================*/
/*==============================================================*/
/*    DEFINICION DE LOS PARAMETROS COMUNES DEL DATATABLES      */
/*============================================================*/
/*===========================================================*/

// Está en un archivo aparte comunDataTables.js

/*===============================================================*/
/*==============================================================*/
/*                             FIN                             */
/*    DEFINICION DE LOS PARAMETROS COMUNES DEL DATATABLES     */
/*===========================================================*/
/*==========================================================*/



/*===============================================================*/
/*==============================================================*/
/*    DEFINICION DE LA PARTE PARTICULAR DEL DATATABLES         */
/*============================================================*/
/*===========================================================*/
var log_table = $('#log_table').DataTable({
    columns: [
        { name: "Nombre", className: 'text-center'},
        { name: "Pantalla", className: 'text-center' },
        { name: "Acción Realizada", className: 'text-center' },
        { name: "Fecha", className: 'text-center' },
        { name: "Hora" , className: 'text-center'},
    ],
    columnDefs: [
        { targets: [0], orderData: [0], visible: true, type: 'string', className: 'tx-bold'},
        { targets: [1], orderData: [1], visible: true, type: 'string' },
        { targets: [2], orderData: [2], visible: true, type: 'string' },
        { targets: [3], orderData: [3], visible: true, type: 'string',  className: 'tx-bold' },
        { targets: [4], orderData: [4], visible: true, type: 'string',  className: 'tx-bold' },
    ],
    orderFixed: [[1, "asc"]],
    searchBuilder: {
        columns: [0, 1, 2, 3, 4]
    },
});

////////////////////////////////////////////////////////////////


// SELECT ARCHIVOS LOGS //

$("#select2-log").select2({
    placeholder: "Seleccione un LOG",
    theme: "classic"
});

// CARGAR DATOS FUNCION SELECT

$('#select2-log').on('change', function() {
    log_table.clear().draw();
    $('.table-responsive').removeClass('d-none');

    var selectedValue = $('#select2-log').val();
    // console.log(selectedValue);
    //alert(selectedValue);
    var fichero = '../../public/log/'+selectedValue;

    //alert(fichero);


// SEGUNDA TABLA



$.ajax({
    url: fichero,
    dataType: 'text',
    success: function(data) {
        var lines = data.split('\n');
        var tableHTML = '';
        $.each(lines, function(index, line) {
            if (line.trim().length > 0) {
                var campos = line.split(';');
                tableHTML += '<tr>';
                $.each(campos, function(index, campo) {
                    tableHTML += '<td>' + campo + '</td>';
                });
                tableHTML += '</tr>';
            }
        });
        log_table.rows.add($(tableHTML)).draw();
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error("Error al cargar el archivo log: ", textStatus, errorThrown);
        alert("No se pudo cargar el archivo de log. Verifique la ruta o el nombre del archivo.");
    }
});
});

$("#log_table").addClass("width-100");

/*************************************************/
/*     FIN DE LOS FILTROS DE LOS PIES        ****/
/***********************************************/
// BUSCAR POR PANTALLA
$('#FootPantalla').on('keyup', function () {
    log_table
        .columns(2)
        .search(this.value)
        .draw();
});

$('#log_table').DataTable().on('draw.dt', function () {
    controlarFiltros('log_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/
