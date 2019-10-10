$(document).ready(function () {

  var remember = $.cookie("remember");
  if (remember == "true") {
    var username = $.cookie("username");
    var password = $.cookie("password");
    $("#inputEmail").attr("value", username);
    $("#inputPassword").attr("value", password);
    $("#inputRemember").prop("checked", remember);
  }

  function processLogin() {
    let obj = {
      accion: "login",
    };
    $("#login-form")
      .find("input")
      .map(function (i, e) {
        //Añanir atributo
        obj[$(this).prop("name")] = $(this).val();
        if ($(this).prop("type") == "checkbox") {
          obj[$(this).prop("name")] = $(this).prop("checked");
        }
      });
    if (obj.recordar == true) {
      $.cookie("username", obj.usuario, {
        expires: 30
      });
      $.cookie("password", obj.password, {
        expires: 30
      });
      $.cookie("remember", true, {
        expires: 30
      });
    } else {
      $.cookie("username", null);
      $.cookie("password", null);
      $.cookie("remember", false);
    }
    $.post(
      "/modulos/login/consultas.php",
      obj,
      function (respuesta) {
        if (respuesta.status == 3) {
          window.location.href = "/index.php";
        }
        if (respuesta.status == 5) {
          swal("¡ERROR!", "Campos vacios", "error");
        }
        if (respuesta.status == 2) {
          swal("¡ERROR!", "Contraseña incorrecta", "error");
        }
        if (respuesta.status == 4) {
          swal("¡ERROR!", "Usuario no registrado", "error");
        }
        if (respuesta.status == 6) {
          swal("¡CUENTA SIN ACTIVAR!", "Se ha enviado un email a su dirección de correo electronico para activar su cuenta", "error");
        }
      },
      "JSON"
    );
  }

  function processRegister() {
    let obj = {
      accion: "register"
    }
    $("#register-form").find("input").map(function (i, e) {
      obj[$(this).prop("name")] = $(this).val();
    });
    $.post("/modulos/login/consultas.php", obj, function (respuesta) {
      if (respuesta.status == 0) {
        swal("¡ERROR!", "Campos vacios", "error");
      } else if (respuesta.status == 1) {
        swal("Éxito", "Usuario insertado correctamente, le hemos envíado un email a su correo para activar su cuenta", "success").then(
          () => {
            location.reload();
          }
        );
      } else if (respuesta.status == 2) {
        swal("¡ERROR!", "La matricula ya existe", "error");
      } else if (respuesta.status == 3) {
        swal("¡ERROR!", "Las contraseñas no coinciden", "error");
      } else {
        errorAlert();
      }
    }, "JSON");
  }

  $("#btn-login").click(function () {
    processLogin();
  });

  $("#inputEmail, #inputPassword, #inputRemember").keyup(function (e) {
    if (e.keyCode == 13) {
      processLogin();
    }
  });

  $("#btn-register").click(function () {
    processRegister();
  });

  $("#matricula, #nombre, #telefono, #email, #contraseña, #contraseña2").keyup(function (e) {
    if (e.keyCode == 13) {
      processRegister();
    }
  });

  $(".message a").click(function () {
    $("form").animate({
        height: "toggle",
        opacity: "toggle",
      },
      "slow"
    );
  });
});