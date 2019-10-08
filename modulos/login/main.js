$(document).ready(function() {
  var remember = $.cookie("remember");
  if (remember == "true") {
    var username = $.cookie("username");
    var password = $.cookie("password");
    $("#inputEmail").attr("value", username);
    $("#inputPassword").attr("value", password);
    $("#inputRemember").prop("checked", remember);
  }
  $("#btn-login").click(function() {
    let obj = {
      accion: "login",
    };
    $("#login-form")
      .find("input")
      .map(function(i, e) {
        //Añanir atributo
        obj[$(this).prop("name")] = $(this).val();
        if ($(this).prop("type") == "checkbox") {
          obj[$(this).prop("name")] = $(this).prop("checked");
        }
      });
    if (obj.recordar == true) {
      $.cookie("username", obj.usuario, { expires: 30 });
      $.cookie("password", obj.password, { expires: 30 });
      $.cookie("remember", true, { expires: 30 });
    } else {
      $.cookie("username", null);
      $.cookie("password", null);
      $.cookie("remember", false);
    }
    $.post(
      "/modulos/login/consultas.php",
      obj,
      function(respuesta) {
        if (respuesta.status == 3) {
          swal({
            title: "Datos Correctos",
            text: "¿Deseas iniciar sesión?",
            icon: "success",
            buttons: true,
            ConfirmButtonText: true,
          }).then(willLogin => {
            if (willLogin) {
              window.location.href = "/index.php";
            } else {
              location.reload();
            }
          });
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
      },
      "JSON"
    );
  });

  $(".message a").click(function() {
    $("form").animate(
      {
        height: "toggle",
        opacity: "toggle",
      },
      "slow"
    );
  });
});
