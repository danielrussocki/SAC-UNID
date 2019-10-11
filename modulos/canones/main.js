$(document).ready(function(){
  $('#table_id').DataTable();
  let obj = {};
  $("#btn-new").click(function() {
    obj = {
      accion: "insertCanon"
    };
    $("#btn-form").text("Añadir cañón");
  });
  $(".btn-delete").click(function() {
    let id = $(this).attr("data");
    obj = {
      accion: "deleteCanon",
      canon: id
    };
    swal({
      title: "¿Estás seguro?",
      text: "El cañón será eliminado",
      icon: "warning",
      buttons: true,
      dangerMode: true
    }).then(willDelete => {
      if (willDelete) {
        $.post(
          "/modulos/canones/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 1) {
              swal("Éxito", "El cañón fue eliminado correctamente", "success").then(() => {
                cancelAlert();
                location.reload();
                //console.log("Holisss");
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
  $(".btn-edit").click(function() {
    let id = $(this).attr("data");
    obj = {
      accion: "getCanon",
      canon: id
    };
    $.post(
      "/modulos/canones/consultas.php",
      obj,
      function(respuesta) {
        // $("#nombre").val(respuesta.id_can);
        $("#nombre").val(respuesta.nombre_can);
        $("#status").val(respuesta.status_can);
        $("#entrada").val(respuesta.entrada_can);
        $("#control").val(respuesta.control_can);
        $("#serie").val(respuesta.serie_can);
        obj = {
          accion: "updateCanon",
          canon: id
        };
      },
      "JSON"
    );
    $("#btn-form").text("Editar cañón");
  });
  $("#btn-form").click(function() {
    $("#canon-form")
      .find("input")
      .map(function(i, e) {
        obj[$(this).prop("name")] = $(this).val();
      });

    switch (obj.accion) {
      case "insertCanon":
        $.post(
          "/modulos/canones/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Cañón añadido correctamente", "success").then(() => {
                cancelAlert();
                location.reload();
              });
            } else if (respuesta.status == 2) {
              swal("¡ERROR!", "El número de serie ya existe", "error");
            } else if(respuesta.status == 3){
              swal("¡ERROR!", "Campos Vacíos", "error");
            } else {
              errorAlert();
            }
          },
          "JSON"
        );
        break;
      case "updateCanon":
        $.post(
          "/modulos/canones/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Cañón editado  correctamente", "success").then(() => {
                cancelAlert();
                location.reload();
              });
            } else if (respuesta.status == 2) {
              swal("¡ERROR!", "El canon ya existe", "error");
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