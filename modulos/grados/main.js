$(document).ready(function () {
  var obj = {};

  $("#btn-new").click(function() {
    obj = {
      accion: "insertGrades"
    };
    $("#btn-new").hide();
    $("#btn-form").text("Añadir Grado ");
  });

  $("#btn-cancel").click(function(){
    $("#btn-new").show();
  });

  $(".btn-edit").click(function() {
    let id = $(this).attr("data");
    obj = {
      accion: "getGrades",
      grados: id
    };
    $.post(
      "/modulos/grados/consultas.php",
      obj,
      function(respuesta) {
        $("#nombre").val(respuesta.nombre);
        obj = {
          accion: "updateGrades",
          grados: id,
          nombre_original: respuesta.nombre
        };
      },
      "JSON"
    );
    $("#btn-form").text("Editar Grados");
  });

  $(".btn-delete").click(function () {
      let id = $(this).attr("data");
      obj = {
          accion: "deleteGrades",
          grado: id
      };
      swal({
          title: "¿Estás seguro?",
          text: "El grado será eliminado",
          icon: "warning",
          buttons: true,
          dangerMode: true
      }).then(willDelete => {
          if (willDelete) {
              $.post("/modulos/grados/consultas.php", obj, function (respuesta) {
                  if (respuesta.status == 1) {
                      swal("Éxito", "El grado fue eliminado correctamente", "success").then((willDelete) => {
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
          case "insertGrades":
              $.post("/modulos/grados/consultas.php", obj, function (respuesta) {
                  if (respuesta.status == 0) {
                      swal("¡ERROR!", "Campos vacios", "error");
                  } else if (respuesta.status == 1) {
                      swal("Éxito", "El grado fue añadido correctamente", "success").then(() => {
                          location.reload();
                      });
                  } else {
                      errorAlert();
                  }
              }, "JSON"
              );
              break;
          case "updateGrades":
              $.post("/modulos/grados/consultas.php", obj, function (respuesta) {
                  if (respuesta.respuesta == 0) {
                      swal("¡ERROR!", "Campos vacios", "error");
                  } else if (respuesta.respuesta == 1) {
                      swal("Éxito", "Grado editado correctamente", "success").then(() => {
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
  $('#table_grados').DataTable({
    "lengthChange": false
  });
});