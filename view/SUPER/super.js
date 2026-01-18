$(document).ready(function() {

    $('#gesdocModuloActivar').on('change', function() {
        console.log('El estado del checkbox ha cambiado. Ahora está: ' + ($(this).is(':checked') ? 'marcado' : 'desmarcado'));
          // Verificar el estado del switch y realizar acciones
        estado = $(this).is(':checked') ? 1: 0;
        modulo = 'gesdoc_m';

        $.post("../../controller/empresa.php?op=actualizarModulo",{ modulo:modulo, estado:estado},function (data) {
                toastr['success']('Modulo Gesdoc actualizado');
        });
        
    });
    $('#cmsModuloActivar').on('change', function() {
        console.log('El estado del checkbox ha cambiado. Ahora está: ' + ($(this).is(':checked') ? 'marcado' : 'desmarcado'));
          // Verificar el estado del switch y realizar acciones
        estado = $(this).is(':checked') ? 1: 0;
        modulo = 'cms_m';

        $.post("../../controller/empresa.php?op=actualizarModulo",{ modulo:modulo, estado:estado},function (data) {
                toastr['success']('Modulo CMS actualizado');
        });
    });
    $('#inscripcionModuloActivar').on('change', function() {
        console.log('El estado del checkbox ha cambiado. Ahora está: ' + ($(this).is(':checked') ? 'marcado' : 'desmarcado'));
        // Verificar el estado del switch y realizar acciones
        estado = $(this).is(':checked') ? 1: 0;
        modulo = 'inscripciones_m';

        $.post("../../controller/empresa.php?op=actualizarModulo",{ modulo:modulo, estado:estado},function (data) {
                toastr['success']('Modulo Inscripciones actualizado');
        });
    });
    $('#facturacionModuloActivar').on('change', function() {
        console.log('El estado del checkbox ha cambiado. Ahora está: ' + ($(this).is(':checked') ? 'marcado' : 'desmarcado'));
        // Verificar el estado del switch y realizar acciones
        estado = $(this).is(':checked') ? 1: 0;
        modulo = 'facturacion_m';

        $.post("../../controller/empresa.php?op=actualizarModulo",{ modulo:modulo, estado:estado},function (data) {
                toastr['success']('Modulo Facturación actualizado');
        });
    });
    $('#helpDeskModuloActivar').on('change', function() {
        console.log('El estado del checkbox ha cambiado. Ahora está: ' + ($(this).is(':checked') ? 'marcado' : 'desmarcado'));
        // Verificar el estado del switch y realizar acciones
        estado = $(this).is(':checked') ? 1: 0;
        modulo = 'helpdesk_m';

        $.post("../../controller/empresa.php?op=actualizarModulo",{ modulo:modulo, estado:estado},function (data) {
                toastr['success']('Modulo HelpDesk actualizado');
        });    
    });

    $('#transportesModuloActivar').on('change', function() {
        console.log('El estado del checkbox ha cambiado. Ahora está: ' + ($(this).is(':checked') ? 'marcado' : 'desmarcado'));
        // Verificar el estado del switch y realizar acciones
        estado = $(this).is(':checked') ? 1: 0;
        modulo = 'transporte_m';

        $.post("../../controller/empresa.php?op=actualizarModulo",{ modulo:modulo, estado:estado},function (data) {
                toastr['success']('Modulo Transportes actualizado');
        });        
    });

    $('#avisosModuloActivar').on('change', function() {
        console.log('El estado del checkbox ha cambiado. Ahora está: ' + ($(this).is(':checked') ? 'marcado' : 'desmarcado'));
        // Verificar el estado del switch y realizar acciones
        estado = $(this).is(':checked') ? 1: 0;
        modulo = 'avisos_m';

        $.post("../../controller/empresa.php?op=actualizarModulo",{ modulo:modulo, estado:estado},function (data) {
                toastr['success']('Modulo Avisos actualizado');
        });     
    });
    $('#educacionModuloActivar').on('change', function() {
        console.log('El estado del checkbox ha cambiado. Ahora está: ' + ($(this).is(':checked') ? 'marcado' : 'desmarcado'));
        // Verificar el estado del switch y realizar acciones
        estado = $(this).is(':checked') ? 1: 0;
        modulo = 'educacion_m';

        $.post("../../controller/empresa.php?op=actualizarModulo",{ modulo:modulo, estado:estado},function (data) {
                toastr['success']('Modulo Educación actualizado');
        });         
    });
 
});