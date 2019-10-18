$(document).ready(function () {
    let obj = {};
    $("#btn-new").click(function () {
        obj = {
            accion: "insertApartado"
        };
        $("#apartado-form")[0].reset();
        $("#btn-form").text("Apartar cañon");
        $("#btn-new").hide();
    });
    $("#btn-cancel").click(function () {
        $("#btn-new").show();
    });
    $(".btn-delete").click(function () {
        let id = $(this).attr("data");
        obj = {
            accion: "deleteApartado",
            id: id
        };
        swal({
            title: "¿Estás seguro?",
            text: "El apartado será eliminado",
            icon: "warning",
            buttons: true,
            dangerMode: true
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
        let id = $(this).attr("data");
        obj = {
            accion: "getApartado",
            id: id
        };
        $.post(
            "/modulos/apartado/consultas.php",
            obj,
            function (respuesta) {
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
                    id: id
                };
            },
            "JSON"
        );
        $("#btn-form").text("Editar apartado");
    });
    $("#btn-form").click(function () {
        $("#apartado-form")
            .find("input")
            .map(function (i, e) {
                obj[$(this).prop("name")] = $(this).val();
            });
        $("#apartado-form").find("select").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
        });

        switch (obj.accion) {
            case "insertApartado":
                $.post(
                    "/modulos/apartado/consultas.php",
                    obj,
                    function (respuesta) {
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
                    function (respuesta) {
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
    $('#table_apartado').DataTable({
        "lengthChange": false
    });

    $("#btn-interno").click(function () {
        let obj = {};
        $("#apartado-form").find("input, select").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
            if ($(this).prop("type") == "select-one") {
                obj[$(this).prop("name") + "_texto"] = $(this).find("option:selected").text();
            }
        });
        let template = `
            <tr>
                <td>${obj.usuario_texto}</td>
                <td>${obj.dia_inicio}</td>
                <td>${obj.hora_inicio}</td>
                <td>${obj.servicio_texto}</td>
                <td>${obj.salon_texto}</td>
                <td>${obj.canon_texto}</td>
                <td>${obj.comentarios}</td>
                <td>${obj.accesorios}</td>
                <td>Editar Eliminar</td>
            </tr>
        `;
        $("#tabla_interna tbody").append(template);
        reset_content(".formulario_registro");
    });

    function reset_content(selector) {
        $(selector + " input, " + selector + " select").each(function () {
            $(this).val("");
        })
    }
});