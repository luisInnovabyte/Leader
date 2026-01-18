$(document).ready(function() {
    let dataTable = null;
    
    // Inicializar select2
    $('#select2-control-descarga').select2({
        placeholder: 'Seleccione un archivo de control...',
        allowClear: true,
        width: '400px'
    });

    // Evento al cambiar la selección
    $('#select2-control-descarga').on('change', function() {
        const archivoSeleccionado = $(this).val();
        
        if (archivoSeleccionado) {
            // Mostrar contenedor
            $('#contenidoJSON').show();

            // Cargar el archivo JSON
            $.ajax({
                url: '../Ordenes/descargas/control_descargas/' + archivoSeleccionado,
                dataType: 'json',
                success: function(data) {
                    cargarDataTable(data);
                },
                error: function(xhr, status, error) {
                    alert('Error al cargar el archivo: ' + error);
                    $('#contenidoJSON').hide();
                }
            });
        } else {
            $('#contenidoJSON').hide();
            if (dataTable) {
                dataTable.destroy();
                dataTable = null;
            }
        }
    });

    function cargarDataTable(data) {
        // Destruir DataTable existente si existe
        if (dataTable) {
            dataTable.destroy();
        }

        // Limpiar tbody
        $('#tbody-control-descarga').empty();

        // Calcular resumen a partir del array de archivos
        const totalArchivos = data.archivos ? data.archivos.length : 0;
        const archivosDescargados = data.archivos ? data.archivos.filter(a => a.descargado === true).length : 0;
        const archivosConError = data.archivos ? data.archivos.filter(a => a.descargado === false).length : 0;
        
        // Extraer fecha y hora del primer archivo (si existe)
        let fecha = 'N/A';
        let hora = 'N/A';
        let timestamp = 'N/A';
        
        if (data.archivos && data.archivos.length > 0 && data.archivos[0].fecha_hora_descarga) {
            const fechaHora = data.archivos[0].fecha_hora_descarga.split(' ');
            fecha = fechaHora[0] || 'N/A';
            hora = fechaHora[1] || 'N/A';
            timestamp = data.archivos[0].fecha_hora_descarga;
        }

        // Construir fila con los datos calculados
        const fila = `
            <tr>
                <td>${fecha}</td>
                <td>${hora}</td>
                <td>${timestamp}</td>
                <td>${totalArchivos}</td>
                <td>${archivosDescargados}</td>
                <td>${archivosConError}</td>
            </tr>
        `;
        
        $('#tbody-control-descarga').append(fila);

        // Inicializar DataTable
        dataTable = $('#tabla-control-descarga').DataTable({
            language: {
                url: '../../public/espanol.json'
            },
            responsive: true,
            pageLength: 10,
            order: [[0, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    text: 'Copiar',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn btn-danger'
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-info'
                }
            ]
        });
    }
});
