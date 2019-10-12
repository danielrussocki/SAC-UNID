$(document).ready(function () {
  var obj = {};

  $("#btn-new").click(function () {
      obj = {
          accion: "insertClass"
      };
      $("#user-form")[0].reset();
      $("#btn-form").text("Registrar Nivel");
  });

  $(".btn-edit").click(function () {
      let id = $(this).attr("data");
      obj = {
          accion: "getClass",
          salones: id
      };
      $.post("/modulos/salones/consultas.php", obj, function (respuesta) {
          $("#nombre").val(respuesta.nombre);
          $("#id_grados").val(respuesta.id_grados);
          $("#tiene_canon").val(respuesta.tiene_canon);
          $("#status").val(respuesta.status);
          obj = {
              accion: "updateClass",
              salones: id
          };
      }, "JSON"
      );
      $("#btn-form").text("Editar Salon");
  });

  $(".btn-delete").click(function () {
      let id = $(this).attr("data");
      obj = {
          accion: "deleteClass",
          salones: id
      };
      swal({
          title: "¿Estás seguro?",
          text: "El salon será eliminado",
          icon: "warning",
          buttons: true,
          dangerMode: true
      }).then(willDelete => {
          if (willDelete) {
              $.post("/modulos/salones/consultas.php", obj, function (respuesta) {
                  if (respuesta.status == 1) {
                      swal("Éxito", "Salon eliminado correctamente", "success").then((willDelete) => {
                          location.reload();
                      });
                  } else {
                      errorAlert();
                  }
              }, "JSON"
              );
          }
      });
  });

  $("#btn-form").click(function () {
      $("#user-form").find("input").map(function (i, e) {
          obj[$(this).prop("name")] = $(this).val();
      });
      $("#user-form").find("select").map(function (i, e) {
          obj[$(this).prop("name")] = $(this).val();
      });
      switch (obj.accion) {
          case "insertClass":
              $.post("/modulos/salones/consultas.php", obj, function (respuesta) {
                  if (respuesta.status == 0) {
                      swal("¡ERROR!", "Campos vacios", "error");
                  } else if (respuesta.status == 1) {
                      swal("Éxito", "Salon añadido correctamente", "success").then(() => {
                          location.reload();
                      });
                  } else {
                      errorAlert();
                  }
              }, "JSON"
              );
              break;
          case "updateClass":
              $.post("/modulos/salones/consultas.php", obj, function (respuesta) {
                  if (respuesta.respuesta == 0) {
                      swal("¡ERROR!", "Campos vacios", "error");
                  } else if (respuesta.respuesta == 1) {
                      swal("Éxito", "Salon editado correctamente", "success").then(() => {
                          location.reload();
                      });
                  } else {
                      errorAlert();
                  }
              }, "JSON"
              );
              break;

          default:
              break;
      }
  });

});