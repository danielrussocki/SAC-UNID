$(document).ready(function () {

  var rowcounttabla = $("#tabla_interna > tbody > tr").length;
  if (rowcounttabla == 0) {
    $("#btn-reservar").hide();
    $("#tabla_interna").hide();
  }

  function countTrs(rowcount) {
    if (rowcount == 0) {
      $("#btn-reservar").hide();
      $("#tabla_interna").hide();
    } else if (rowcount > 0) {
      $("#btn-reservar").show();
      $("#tabla_interna").show();
    }
  }

  let obj = {};

  $("#btn-new").click(function () {
    $("#btn-new").hide();
  });

  $("#btn-cancel").click(function (e) {
    swal({
      title: "¿Estás seguro?",
      text: "Los datos ingresados se perderán",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then(willDelete => {
      if (willDelete) {
        location.reload();
      }
    });
  });

  $(".btn-delete").click(function () {
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
          function (respuesta) {
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

  $(".btn-edit").click(function () {
    $("#btn-interno").removeClass();
    $("#btn-interno").addClass("btn-edit-logic");
    $("#btn-interno").text("Editar");
    $("#btn-cancelar").hide();
    $("#btn-new").hide();
    var id_edit = $(this).attr("data");
    obj = {
      accion: "getApartado",
      id: id_edit,
    };
    $.post(
      "/modulos/apartado/consultas.php",
      obj,
      function (respuesta) {
        $("#usuario")
          .val(respuesta.usuario)
          .trigger("chosen:updated");
        $("#dia_inicio").val(respuesta.fecha_inicio);
        $("#hora_inicio").val(respuesta.hora_inicio);
        $("#servicio")
          .val(respuesta.servicio)
          .trigger("chosen:updated");
        $("#salon")
          .val(respuesta.salon)
          .trigger("chosen:updated");
        $("#canon")
          .val(respuesta.canon)
          .trigger("chosen:updated");
        $("#comentarios").val(respuesta.comentario);
        $("#accesorios").val(respuesta.accesorio);
        $("#id_usr").val(id_edit);
      },
      "JSON"
    );
  });

  $("#table_apartado").DataTable({
    order: [1, 'des'],
    lengthChange: true
  });

  $("#btn-interno").click(function () {
    let flag = true;
    let obj = {};
    $(".formulario_registro")
      .find("input, select")
      .map(function (i, e) {
        let $this = $(this);
        $this.removeClass("error-campo");
        if ($this.val() == "" && !$this.hasClass("norequerido")) {
          $this.addClass("error-campo");
          flag = false;
        } else {
          if ($(this).val() != "") {
            obj[$this.prop("name")] = $this.val();
          }
          if ($this.prop("type") == "select-one") {
            obj[$this.prop("name") + "_texto"] = $this.find("option:selected").text();
          }
        }
      });
    if ($(this).hasClass("btn-edit-logic")) {
      let id = $("#id_usr").val();
      obj = {
        accion: "updateApartado",
        id: id,
        usuario: $("#usuario").val(),
        dia_inicio: $("#dia_inicio").val(),
        hora_inicio: $("#hora_inicio").val(),
        servicio: $("#servicio").val(),
        salon: $("#salon").val(),
        canon: $("#canon").val(),
        comentarios: $("#comentarios").val(),
        accesorios: $("#accesorios").val(),
      };
      $.post(
        "/modulos/apartado/consultas.php",
        obj,
        function (respuesta) {
          if (respuesta.status == 0) {
            swal("¡ERROR!", "Campos vacios", "error");
          } else if (respuesta.status == 1) {
            swal("Éxito", "Apartado editado correctamente", "success").then(() => {
              cancelAlert();
              location.reload();
            });
          }
        },
        "JSON"
      );
    } else if (flag) {
      let session = sessionStorage.getItem("id");
      let id = session != null ? session : $.now();
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
            <td><input type="hidden" id="input-hide" value='${json}'><a href="#" data-id="${id}" class="editar-interno">Editar</a> <a href="#" data-id="${id}" class="eliminar-interno">Eliminar</a></td>
        </tr>
    `;
      if ($(this).hasClass("btn-editar")) {
        $("#" + id).replaceWith(template);
        $("#btn-interno")
          .text("AGREGAR")
          .removeClass("btn-editar");
        sessionStorage.removeItem("id");
      } else {
        rowcounttabla++;
        countTrs(rowcounttabla);
        $("#tabla_interna tbody").append(template);
      }
      reset_content(".formulario_registro");
    } else {
      swal("Por favor ingresa los valores correspondientes", "Se han detectado campos vacíos", "error");
      return flag;
    }
  });

  $("#tabla_interna").on("click", ".eliminar-interno", function (e) {
    e.preventDefault();
    let padre = $(this).data("id");
    swal({
      title: "¿Estás seguro?",
      text: "El apartado será eliminado",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then(willDelete => {
      if (willDelete) {
        $("#" + padre).remove();
        swal("Registro elimiando", "Se ha eliminado correctamente el registro", "success");
        rowcounttabla--;
        countTrs(rowcounttabla);
        reset_content(".formulario_registro");
        $("#btn-interno").text("AGREGAR").removeClass("btn-editar");
      }
    });
  });

  $("#tabla_interna").on("click", ".editar-interno", function (e) {
    e.preventDefault();
    let padre = $(this).data("id");
    sessionStorage.setItem("id", padre);
    $("#btn-interno")
      .text("Editar")
      .addClass("btn-editar");
    let json = $("#" + padre + " input").val();
    let obj = JSON.parse(json);
    $("#usuario")
      .val(obj.usuario)
      .trigger("chosen:updated");
    $("#dia_inicio").val(obj.dia_inicio);
    $("#hora_inicio").val(obj.hora_inicio);
    $("#servicio")
      .val(obj.servicio)
      .trigger("chosen:updated");
    $("#salon")
      .val(obj.salon)
      .trigger("chosen:updated");
    $("#canon")
      .val(obj.canon)
      .trigger("chosen:updated");
    $("#comentarios").val(obj.comentarios);
    $("#accesorios").val(obj.accesorios);
    $("#accesorios").val(obj.accesorios);
    $("#id-reserva").val(obj.id);
  });

  $("#btn-cancelar").click(function (e) {
    e.preventDefault();
    let rowcount = $("#tabla_interna tr").length;
    if (rowcount > 1) {
      swal({
        title: "¿Estás seguro?",
        text: "Los datos ingresados se perderán",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then(willDelete => {
        if (willDelete) {
          $("#tabla_interna tbody").empty();
          reset_content(".formulario_registro");
          rowcounttabla = 0;
          countTrs(rowcounttabla);
        }
      });
    }
  });

  $("#btn-reservar").click(function (e) {
    e.preventDefault();
    let map = {
      accion: "guardar"
    };
    let arreglo = [];
    $("#tabla_interna input").each(function () {
      arreglo.push($(this).val());
    });
    if (arreglo.length > 0) {
      map["datos"] = arreglo;
    }
    $.post("/modulos/apartado/consultas.php", map, function (respuesta) {
      if (respuesta.status == 0) {
        swal("¡ERROR!", "", "error");
      } else if (respuesta.status == 1) {
        swal("Éxito", "Se han guardado tus datos", "success").then(() => {
          cancelAlert();
          location.reload();
        });
      } else {
        errorAlert();
      }
    }, "JSON");
  });

  $("#btn-form").click(function () {
    $("#apartado-form")
      .find("input")
      .map(function (i, e) {
        obj[$(this).prop("name")] = $(this).val();
      });
    $("#apartado-form")
      .find("select")
      .map(function (i, e) {
        obj[$(this).prop("name")] = $(this).val();
      });
  });

  function reset_content(selector) {
    $(selector + " input, " + selector + " select").each(function () {
      $(this).val("");
    });
    $(".chosen-select")
      .val("")
      .trigger("chosen:updated");
  }

  $(".chosen-select")
    .chosen({
      width: "100%",
      no_results_text: "No se encontraron resultados",
    })
    .change(function () {
      $(".chosen-search")
        .find("input")
        .addClass("norequerido");
    });

  $("#hora_inicio").timepicker({
    scrollDefault: "now",
    minTime: "7:00am",
    maxTime: "10:00pm",
    interval: 30,
  });

  $("#dia_inicio").datepicker({
    maxDate: "+3m",
    minDate: "now",
  });
});
