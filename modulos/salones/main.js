$(document).ready(function() {
  var obj = {};

  $("#btn-new").click(function() {
    obj = {
      accion: "insertClass"
    };
    $("#btn-form").text("Añadir Salon");
  });

  $(".btn-edit").click(function() {
    let id = $(this).attr("data");
    obj = {
      accion: "getClass",
      salones: id
    };
    $.post(
      "/modulos/salones/consultas.php",
      obj,
      function(respuesta) {
        $("#nombre").val(respuesta.nombre);
        $("#id_grados").val(respuesta.id_grados);
        $("#tiene_canones").val(respuesta.tiene_canon);
        $("#status").val(respuesta.status);
        obj = {
          accion: "updateClass",
          salones: id,
          nombre_original: respuesta.nombre
        };
      },
      "JSON"
    );
    $("#btn-form").text("Editar Salon");
  });

  $(".btn-delete").click(function() {
    let id = $(this).attr("data");
    obj = {
      accion: "deleteClass",
      salon: id
    };
    swal({
      title: "¿Estás seguro?",
      text: "El Salon será eliminado",
      icon: "warning",
      buttons: true,
      dangerMode: true
    }).then(willDelete => {
      if (willDelete) {
        $.post(
          "/modulos/salones/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 1) {
              swal("Éxito", "El Salon fue eliminado correctamente", "success").then(() => {
                cancelAlert();
                //location.reload();
              });
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
      case "insertClass":
        $.post(
          "/modulos/salones/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Salon añadido correctamente", "success").then(
                () => {
                  cancelAlert();
                  location.reload();
                }
              );
            } else if (respuesta.status == 2) {
              swal("¡ERROR!", "El nombre de Salon ya existe", "error");
            } else {
              errorAlert();
            }
          },
          "JSON"
        );
        break;
      case "updateClass":
        $.post(
          "/modulos/salones/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Salon editado  correctamente", "success").then(
                () => {
                  cancelAlert();
                  location.reload();
                }
              );
            } else if (respuesta.status == 2) {
              swal("¡ERROR!", "El nombre de Salon ya existe", "error");
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
});
