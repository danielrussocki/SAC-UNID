$(document).ready(function(){
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
        // $("#status").val(respuesta.status_can);
        respuesta.status_can == 1 ?
        $("#stsOne").prop("checked",true) : $("#stsTwo").prop("checked",true);
        $("#entrada").val(respuesta.id_entrada);
        respuesta.control_can == 1 ?
        $("#controlOne").prop("checked",true) : $("#controlTwo").prop("checked",true);
        // $("#control").val(respuesta.control_can);
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
      .find("input, select")
      .map(function(i, e) {
        if($(this).prop("name") != 'control' && $(this).prop("name") != 'status'){
          obj[$(this).prop("name")] = $(this).val();
        } else if($(this).prop("name") == 'control'){
          // console.log($('#controlOne').prop("checked"),$('#controlOne').val(),$('#controlTwo').val());
          obj[$(this).prop("name")] = $('#controlOne').prop("checked");
        } else if($(this).prop("name") == 'status'){
          obj[$(this).prop("name")] = $('#stsOne').prop("checked");
        }
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
  $('#table_lel').DataTable({
    "lengthChange": false
  });
});
