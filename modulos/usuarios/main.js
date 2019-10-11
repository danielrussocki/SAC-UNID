$(document).ready(function() {
  
  var obj = {};
  
  $("#btn-new").click(function() {
    obj = {
      accion: "insertUsuario"
    };
    $("#btn-form").text("Añadir usuario ");
  });

  $(".btn-edit").click(function() {
    let id = $(this).attr("data");
    obj = {
      accion: "getUsuario",
      usuario: id
    };
    $.post(
      "/modulos/usuarios/consultas.php",
      obj,
      function(respuesta) {
        $("#matricula").val(respuesta.matricula);
        $("#nombre").val(respuesta.nombre);
        $("#telefono").val(respuesta.telefono);
        $("#email").val(respuesta.email);
        $("#contraseña").val(respuesta.contraseña);
        obj = {
          accion: "updateUsuario",
          usuario: id,
          matricula_original: respuesta.matricula
        };
      },
      "JSON"
    );
    $("#btn-form").text("Editar usuario ");
  });

  $(".btn-delete").click(function() {
    let id = $(this).attr("data");
    obj = {
      accion: "deleteUsuario",
      usuario: id
    };
    swal({
      title: "¿Estás seguro?",
      text: "El usuario será eliminado",
      icon: "warning",
      buttons: true,
      dangerMode: true
    }).then(willDelete => {
      if (willDelete) {
        $.post(
          "/modulos/usuarios/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 1) {
              swal("Éxito", "Usuario eliminado correctamente", "success").then(
                () => {
                  location.reload();
                }
              );
            } else {
              errorAlert();
            }
          },
          "JSON"
        );
      }
    });
  });

  $("#btn-form").click(function() {
    $("#user-form")
      .find("input")
      .map(function(i, e) {
        obj[$(this).prop("name")] = $(this).val();
      });

    switch (obj.accion) {
      case "insertUsuario":
        $.post(
          "/modulos/usuarios/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Usuario añadido correctamente", "success").then(
                () => {
                  cancelAlert();
                  location.reload();
                }
              );
            } else if (respuesta.status == 2) {
              swal("¡ERROR!", "La matricula ya existe", "error");
            } else {
              errorAlert();
            }
          },
          "JSON"
        );
        break;
      case "updateUsuario":
        $.post(
          "/modulos/usuarios/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Usuario editado  correctamente", "success").then(
                () => {
                  cancelAlert();
                  location.reload();
                }
              );
            } else if (respuesta.status == 2) {
              swal("¡ERROR!", "La matricula ya existe", "error");
            } else {
              errorAlert();
            }
          },
          "JSON"
        );
        break;

      default:
        break;
    }
  });
  $('#table_id').DataTable({
    "lengthChange": false
  });
});
