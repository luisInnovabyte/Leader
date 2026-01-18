$(document).ready(function() {
    let dataTable = null;
    
    // Inicializar select2 para carpetas
    $('#select2-carpeta-procesados').select2({
        placeholder: 'Seleccione una carpeta...',
        allowClear: true,
        width: '550px'
    });

    // Inicializar select2 para archivos (inicialmente oculto)
    $('#select2-archivo-procesado').select2({
        placeholder: 'Seleccione un archivo JSON...',
        allowClear: true,
        width: '550px'
    });

    // Evento al cambiar la carpeta seleccionada
    $('#select2-carpeta-procesados').on('change', function() {
        const carpetaSeleccionada = $(this).val();
        
        if (carpetaSeleccionada) {
            // Mostrar el select de archivos
            $('#contenedor-archivos').show();
            
            // Limpiar select de archivos
            $('#select2-archivo-procesado').empty().append('<option value="">Seleccione un archivo JSON...</option>');
            
            // Ocultar contenido JSON
            $('#contenidoJSON').hide();
            if (dataTable) {
                dataTable.destroy();
                dataTable = null;
            }

            // Cargar archivos JSON de la carpeta seleccionada
            $.ajax({
                url: 'listarArchivosJSON.php',
                data: { carpeta: carpetaSeleccionada },
                dataType: 'json',
                success: function(archivos) {
                    if (archivos && archivos.length > 0) {
                        archivos.forEach(function(archivo) {
                            $('#select2-archivo-procesado').append(
                                `<option value="${archivo.nombre}">${archivo.nombre} - ${archivo.fecha}</option>`
                            );
                        });
                    } else {
                        $('#select2-archivo-procesado').append(
                            '<option value="" disabled>No hay archivos JSON en esta carpeta</option>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error al cargar los archivos: ' + error);
                }
            });
        } else {
            $('#contenedor-archivos').hide();
            $('#contenidoJSON').hide();
            if (dataTable) {
                dataTable.destroy();
                dataTable = null;
            }
        }
    });

    // Evento al cambiar el archivo seleccionado
    $('#select2-archivo-procesado').on('change', function() {
        const archivoSeleccionado = $(this).val();
        const carpetaSeleccionada = $('#select2-carpeta-procesados').val();
        
        if (archivoSeleccionado && carpetaSeleccionada) {
            // Mostrar contenedor
            $('#contenidoJSON').show();

            // Cargar el archivo JSON
            $.ajax({
                url: '../Ordenes/descargas_procesados/control_procesados/' + carpetaSeleccionada + '/' + archivoSeleccionado,
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
        $('#tbody-control-procesado').empty();

        // Verificar que data es un array
        if (!Array.isArray(data) || data.length === 0) {
            $('#tbody-control-procesado').append('<tr><td colspan="4" class="text-center">No hay registros para mostrar</td></tr>');
            return;
        }

        // Recorrer cada registro del JSON
        data.forEach(function(registro) {
            const nombreArchivo = registro.nombre_archivo || 'N/A';
            const procesado = registro.procesado ? '<span class="badge bg-success">SÍ</span>' : '<span class="badge bg-danger">NO</span>';
            
            // Formatear errores (array de strings)
            let errores = 'Sin errores';
            if (registro.errores && registro.errores.length > 0) {
                errores = '<ul class="mb-0" style="padding-left: 20px;">';
                registro.errores.forEach(function(error) {
                    errores += `<li>${error}</li>`;
                });
                errores += '</ul>';
            }
            
            // Formatear detalles (array de strings)
            let detalles = 'Sin detalles';
            if (registro.detalles && registro.detalles.length > 0) {
                detalles = '<ul class="mb-0" style="padding-left: 20px;">';
                registro.detalles.forEach(function(detalle) {
                    detalles += `<li>${detalle}</li>`;
                });
                detalles += '</ul>';
            }
            
            // Construir fila
            const fila = `
                <tr>
                    <td>${nombreArchivo}</td>
                    <td class="text-center">${procesado}</td>
                    <td>${errores}</td>
                    <td>${detalles}</td>
                </tr>
            `;
            
            $('#tbody-control-procesado').append(fila);
        });

        // Inicializar DataTable
        dataTable = $('#tabla-control-procesado').DataTable({
            language: {
                url: '../../public/espanol.json'
            },
            responsive: true,
            pageLength: 25,
            order: [[0, 'asc']],
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
                    className: 'btn btn-danger',
                    orientation: 'landscape',
                    pageSize: 'A4'
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
