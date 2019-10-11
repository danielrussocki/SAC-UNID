$(document).ready(function () {
    $('#table_id').DataTable();

    var obj = {};

    $("#btn-new").click(function () {
        obj = {
            accion: "insertServicio"
        };
        $("#servicio-form")[0].reset();
        $("#btn-form").text("Registrar servicio");
    });

    $(".btn-edit").click(function () {
        let id = $(this).attr("data");
        obj = {
            accion: "getServicio",
            servicio: id
        };
        $.post("/modulos/servicios/consultas.php",obj,function (respuesta) {
                $("#nombre").val(respuesta.nombre);
                
                if(respuesta.st == "1"){
                    $("#status2").prop("checked",true);
                } else if(respuesta.st == "0"){
                    $("#status1").prop("checked",true);
                }
                
                obj = {
                    accion: "updateServicio",
                    servicio: id
                };
            },"JSON"
        );
        $("#btn-form").text("Editar servicio");
    });

    $(".btn-delete").click(function () {
        let id = $(this).attr("data");
        obj = {
            accion: "deleteServicio",
            servicio: id
        };
        swal({
            title: "¿Estás seguro?",
            text: "El servicio será eliminado",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                $.post("/modulos/servicios/consultas.php",obj,function (respuesta) {
                        if (respuesta.status == 1) {
                            swal("Éxito", "Servicio eliminado correctamente", "success").then((willDelete) => {
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
        $("#servicio-form").find("input").map(function (i, e) {
                obj[$(this).prop("name")] = $(this).val();

                if($(this).prop("type") == "radio"){
                    obj[$(this).prop("name")] = $(this).prop("checked");
                }
            });

            /*$("#servicio-form").find("input:radio").map(function (i, e) {

                var radioValue =  1;
                //alert(2);
                obj[$(this).prop("name")] = $(this).val(1);
                if($(this).prop("id") == "status1"){    
                    obj[$(this).prop("name")] = $(this).val(radioValue);
                } else{
                    obj[$(this).prop("name")] = $(this).val(0);
                }
                
            });*/
            //alert(radioValue);            
        switch (obj.accion) {
            case "insertServicio":
                $.post("/modulos/servicios/consultas.php", obj, function (respuesta) {
                        if (respuesta.status == 0) {
                            swal("¡ERROR!", "Campos vacios", "error");
                        } else if (respuesta.status == 1) {
                            swal("Éxito", "Servicio añadido correctamente", "success").then(() => {
                                location.reload();
                            });
                        } else {
                            errorAlert();
                        }
                    },"JSON"
                );
                break;
            case "updateServicio":
                $.post("/modulos/servicios/consultas.php", obj, function (respuesta) {
                        if (respuesta.respuesta == 0) {
                            swal("¡ERROR!", "Campos vacios", "error");
                        } else if (respuesta.respuesta == 1) {
                            swal("Éxito", "Servicio editado correctamente", "success").then(() => {
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
});