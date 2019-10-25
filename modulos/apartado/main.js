$(document).ready(function() {
  let obj = {};
  $("#btn-new").click(function() {
    obj = {
      accion: "insertApartado",
    };
    $("#apartado-form")[0].reset();
    $("#btn-form").text("Apartar cañon");
    $("#btn-new").hide();
  });
  $("#btn-cancel").click(function() {
    $("#btn-new").show();
  });
  $(".btn-delete").click(function() {
    let id = $(this).attr("data");
    obj = {
      accion: "deleteApartado",
      id: id,
    };
    swal({
      title: "¿Estás seguro?",
      text: "El apartado será eliminado",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then(willDelete => {
      if (willDelete) {
        $.post(
          "/modulos/apartado/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 1) {
              swal("Éxito", "El apartado fue eliminado correctamente", "success").then(() => {
                cancelAlert();
                location.reload();
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
      accion: "getApartado",
      id: id,
    };
    $.post(
      "/modulos/apartado/consultas.php",
      obj,
      function(respuesta) {
        $("#usuario").val(respuesta.usuario);
        $("#fecha_inicio").val(respuesta.fecha_inicio);
        $("#fecha_fin").val(respuesta.fecha_fin);
        $("#hora_inicio").val(respuesta.hora_inicio);
        $("#hora_fin").val(respuesta.hora_fin);
        $("#servicio").val(respuesta.servicio);
        $("#canon").val(respuesta.canon);
        $("#salon").val(respuesta.salon);
        $("#comentario").val(respuesta.comentario);
        $("#accesorio").val(respuesta.accesorio);
        $("#status").val(respuesta.status);
        obj = {
          accion: "updateApartado",
          id: id,
        };
      },
      "JSON"
    );
    $("#btn-form").text("Editar apartado");
  });
  $("#btn-form").click(function() {
    $("#apartado-form")
      .find("input")
      .map(function(i, e) {
        obj[$(this).prop("name")] = $(this).val();
      });
    $("#apartado-form")
      .find("select")
      .map(function(i, e) {
        obj[$(this).prop("name")] = $(this).val();
      });

    switch (obj.accion) {
      case "insertApartado":
        $.post(
          "/modulos/apartado/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Cañon apartado correctamente", "success").then(() => {
                cancelAlert();
                location.reload();
              });
            } else {
              errorAlert();
            }
          },
          "JSON"
        );
        break;
      case "updateApartado":
        $.post(
          "/modulos/apartado/consultas.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            }
            if (respuesta.status == 1) {
              swal("Éxito", "Cañón editado  correctamente", "success").then(() => {
                cancelAlert();
                location.reload();
              });
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
  $("#table_apartado").DataTable({
    lengthChange: false,
  });

  $("#btn-interno").click(function() {
    let flag = true;
    let obj = {};
    $("#apartado-form")
      .find("input, select")
      .map(function(i, e) {
        let $this = $(this);
        $this.removeClass("error-campo");
        if ($this.val() == "" && !$this.hasClass("norequerido")) {
          $this.addClass("error-campo");
          flag = false;
        } else {
          obj[$this.prop("name")] = $this.val();
          if ($this.prop("type") == "select-one") {
            obj[$this.prop("name") + "_texto"] = $this.find("option:selected").text();
          }
        }
      });
    if (flag) {
      let id = $.now();
      let json = JSON.stringify(obj);
      let template = `
        <tr id="${id}">
            <td>${obj.usuario_texto}</td>
            <td>${obj.dia_inicio}</td>
            <td>${obj.hora_inicio}</td>
            <td>${obj.servicio_texto}</td>
            <td>${obj.salon_texto}</td>
            <td>${obj.canon_texto}</td>
            <td>${obj.comentarios}</td>
            <td>${obj.accesorios}</td>
            <td><input type="hidden" value='${json}'><a href="#" data-id="${id}" class="editar-interno">Editar</a> <a href="#" data-id="${id}" class="eliminar-interno">Eliminar</a></td>
        </tr>
    `;
      if ($(this).hasClass("btn-editar")) {

      } else {
        $("#tabla_interna tbody").append(template);
      }
      reset_content(".formulario_registro");
    } else {
      swal("Por favor ingresa los valores correspondientes", "Se han detectado campos vacíos", "error");
      return flag;
    }
  });

  $("#tabla_interna").on("click", ".eliminar-interno", function(e) {
    e.preventDefault();
    let padre = $(this).data("id");
    swal({
      title: "¿Estás seguro?",
      text: "El apartado será eliminado",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then(willDelete => {
      $("#" + padre).remove();
      swal("Registro elimiando", "Se ha eliminado correctamente el registro", "success");
    });
  });

  $("#tabla_interna").on("click", ".editar-interno", function(e) {
    e.preventDefault();
    let padre = $(this).data("id");
    sessionStorage.setItem("id", padre);
    $("#btn-interno")
      .text("Editar")
      .addClass("btn-editar");
    let json = $("#" + padre + " input").val();
    let obj = JSON.parse(json);
    $("#usuario").val(obj.usuario).trigger("chosen:updated");
    $("#dia_inicio").val(obj.dia_inicio);
    $("#hora_inicio").val(obj.hora_inicio);
    $("#servicio").val(obj.servicio).trigger("chosen:updated");
    $("#salon").val(obj.salon).trigger("chosen:updated");
    $("#canon").val(obj.canon).trigger("chosen:updated");
    $("#comentarios").val(obj.comentarios);
    $("#accesorios").val(obj.accesorios);
  });

  function reset_content(selector) {
    $(selector + " input, " + selector + " select").each(function() {
      $(this).val("");
    });
    $(".chosen-select").val("").trigger("chosen:updated");
  }

  $(".chosen-select").chosen({
    width: "100%",
    no_results_text: "No se encontraron resultados"
  
  }).change(function(){

    $(".chosen-search").find("input").addClass("norequerido");
  });

  $('#hora_inicio').timepicker({
     'scrollDefault': 'now',
     'minTime': '7:00am',
     'maxTime': '10:00pm',
     'interval': 30
  });

    $( "#dia_inicio" ).datepicker({
      "maxDate":"+3m",
      "minDate":"now"
    });
});
