$(document).ready(function () {

    var obj = {};

    $("#btn-new").click(function () {
        obj = {
            accion: "insertEntrada"
        };
        $("#entrada-form")[0].reset();
        $("#btn-form").text("Registrar entrada");
    });

    $(".btn-edit").click(function () {
        let id = $(this).attr("data");
        obj = {
            accion: "getEntrada",
            entrada: id
        };
        $.post("/modulos/entradas/consultas.php",obj,function (respuesta) {
                $("#nombre").val(respuesta.nombre);
                if(respuesta.st == "1"){
                    $("#status2").prop("checked",true);
                } else if(respuesta.st == "0"){
                    $("#status1").prop("checked",true);
                }
                
                obj = {
                    accion: "updateEntrada",
                    entrada: id
                };
            },"JSON"
        );
        $("#btn-form").text("Editar entrada");
    });

    $(".btn-delete").click(function () {
        let id = $(this).attr("data");
        obj = {
            accion: "deleteEntrada",
            entrada: id
        };
        swal({
            title: "¿Estás seguro?",
            text: "La entrada será eliminada",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                $.post("/modulos/entradas/consultas.php",obj,function (respuesta) {
                        if (respuesta.status == 1) {
                            swal("Éxito", "Entrada eliminada correctamente", "success").then((willDelete) => {
                                location.reload();
                            });
                        } else {
                            errorAlert();
                        }
                    },"JSON"
                );
            }
        });
    });

    $("#btn-form").click(function () {
        $("#entrada-form").find("input").map(function (i, e) {
                obj[$(this).prop("name")] = $(this).val();
                if($(this).prop("type") == "radio"){
                    obj[$(this).prop("name")] = $(this).prop("checked");
                }
            });
        switch (obj.accion) {
            case "insertEntrada":
                $.post("/modulos/entradas/consultas.php", obj, function (respuesta) {
                        if (respuesta.status == 0) {
                            swal("¡ERROR!", "Campos vacios", "error");
                        } else if (respuesta.status == 1) {
                            swal("Éxito", "Entrada añadida correctamente", "success").then(() => {
                                location.reload();
                            });
                        } else {
                            errorAlert();
                        }
                    },"JSON"
                );
                break;
            case "updateEntrada":
                $.post("/modulos/entradas/consultas.php", obj, function (respuesta) {
                        if (respuesta.respuesta == 0) {
                            swal("¡ERROR!", "Campos vacios", "error");
                        } else if (respuesta.respuesta == 1) {
                            swal("Éxito", "Entrada editada correctamente", "success").then(() => {
                                location.reload();
                            });
                        } else {
                            errorAlert();
                        }
                    },"JSON"
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