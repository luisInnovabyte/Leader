$("#changePasswordButton").click(function () {
  var newPassword = $("#NewPassword").val();
  var confirmPassword = $("#ConfirmPassword").val();

  let usu_passReg = new validarCamposRegexManual(
    $("#ConfirmPassword"),
    /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\/\\])(.{8,})$/
  );
  let resultadoPass = usu_passReg.validarRegexManual();
  let usu_passRegNew = new validarCamposRegexManual(
    $("#NewPassword"),
    /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\/\\])(.{8,})$/
  );
  let resultadoPassNew = usu_passRegNew.validarRegexManual();

  if (newPassword !== confirmPassword) {
    toastr["error"]("Las contraseñas no coinciden");
  } else {
    if (resultadoPass == true) {
      //ejecutamos el ajax que nos ejecuta el cambio de password

      let password = $("#ConfirmPassword").val();
      let idUsu = $("#token").val();

      console.log(password);
      console.log(idUsu);

      $.ajax({
        url: "../../controller/usuario.php?op=cambiarPassword",
        type: "POST",
        data: { idUsu: idUsu, password: password },
        success: function (data) {
          // Succes en AJAX
          toastr["success"]("Contraseña modificada, vuelve a intentar entrar");
          // Mandar al index con la sesión iniciada
          window.location.href = "../../view/Home";
        },
      });
    } else {
      $("#textError").addClass("tx-danger");
      toastr["error"](
        "Para garantizar tu seguridad, es necesario que refuerces tu contraseña.",
        "Contraseña Insegura"
      );
      return false;
    }
  }
});
