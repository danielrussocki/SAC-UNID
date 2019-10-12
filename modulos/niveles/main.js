$(document).ready(function () {

    var obj = {};

    $("#btn-new").click(function () {
        obj = {
            accion: "insertNivel"
        };
        $("#nivel-form")[0].reset();
        $("#btn-form").text("Registrar Nivel");
    });

    $(".btn-edit").click(function () {
        let id = $(this).attr("data");
        obj = {
            accion: "getNivel",
            nivel: id
        };
        $.post("/modulos/niveles/consultas.php", obj, function (respuesta) {
            $("#nombre").val(respuesta.nombre);
            $("#status").val(respuesta.status);
            obj = {
                accion: "updateNivel",
                nivel: id
            };
        }, "JSON"
        );
        $("#btn-form").text("Editar Nivel");
    });

    $(".btn-delete").click(function () {
        let id = $(this).attr("data");
        obj = {
            accion: "deleteNivel",
            nivel: id
        };
        swal({
            title: "¿Estás seguro?",
            text: "El nivel será eliminado",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                $.post("/modulos/niveles/consultas.php", obj, function (respuesta) {
                    if (respuesta.status == 1) {
                        swal("Éxito", "Nivel eliminado correctamente", "success").then((willDelete) => {
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
        $("#nivel-form").find("input").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
        });
        $("#nivel-form").find("select").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
        });
        switch (obj.accion) {
            case "insertNivel":
                $.post("/modulos/niveles/consultas.php", obj, function (respuesta) {
                    if (respuesta.status == 0) {
                        swal("¡ERROR!", "Campos vacios", "error");
                    } else if (respuesta.status == 1) {
                        swal("Éxito", "Nivel añadido correctamente", "success").then(() => {
                            location.reload();
                        });
                    } else {
                        errorAlert();
                    }
                }, "JSON"
                );
                break;
            case "updateNivel":
                $.post("/modulos/niveles/consultas.php", obj, function (respuesta) {
                    if (respuesta.respuesta == 0) {
                        swal("¡ERROR!", "Campos vacios", "error");
                    } else if (respuesta.respuesta == 1) {
                        swal("Éxito", "Nivel editado correctamente", "success").then(() => {
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
    $('#table_id').DataTable({
        "lengthChange": false
      });
});