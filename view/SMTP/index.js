$(document).ready(function () {
  var checkbox = $("#usarSMTP");

  // Verificamos el valor del checkbox
  if (checkbox.val() == "0") {
    checkbox.prop("checked", false); // Desmarcar el checkbox
  }
});

$("#servHosting").on("change", function () {
  tabla = "smtp_host";
  estado = $("#servHosting").val();

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
    }
  );
});

$("#usarSMTP").on("change", function () {
  tabla = "smtp_auth";
  if ($(this).is(":checked")) {
    estado = 1;
  } else {
    estado = 0;
  }

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
    }
  );
});

$("#userHosting").on("change", function () {
  tabla = "smtp_username";
  estado = $("#userHosting").val();

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
    }
  );
});

$("#passHosting").on("change", function () {
  tabla = "smtp_pass";
  estado = $("#passHosting").val();

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
    }
  );
});

$("#puertoSMTP").on("change", function () {
  tabla = "smtp_port";
  estado = $("#puertoSMTP").val();

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
    }
  );
});

$("#emailReceptor").on("change", function () {
  tabla = "smtp_receptor";
  estado = $("#emailReceptor").val();

  $.post(
    "../../controller/empresa.php?op=actualizarConfiguracion",
    { tabla: tabla, estado: estado },
    function (data) {
    }
  );
});
