<?php
 require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
 if ($_POST) {
     switch ($_POST["accion"]) {
        case 'insertClass':
            insertClass();
            break;

        case 'updateClass':
        updateClass($_POST["salones"]);
        break;

        case 'getClass':
        getClass($_POST["salones"]);
        break;

        case 'deleteClass':
        deleteClass($_POST["salones"]);
        break;

        default:
            # code...
            break;
     }
 }

    function insertClass(){
        global $db;
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $respuesta = [];
        $nombre = $_POST['nombre'];
        $id_grados = $_POST['id_grados'];
        $tiene_canon = $_POST['tiene_canon'];
        $status = $_POST['status'];

        if (empty($nombre) && empty($id_grados) && empty($tiene_canon) && empty($status)) {
            $respuesta["status"] = 0;
        }else{
            $db->insert("salones",[
                "nombre" => $nombre,
                "id_grados" => $id_grados,
                "tiene_canon" => $tiene_canon,
                "status" => $status
            ]);
            $respuesta["status"] = 1;
        }
        echo json_encode($respuesta);
    }

    function getClass($id_salones){
        global $db;
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $obt_salon = $db->get("salones", "*", ["id_salones" => $id_salones]);
        $respuesta["nombre"] = $obt_salon["nombre"];
        $respuesta["id_grados"] = $obt_salon["id_grados"];
        $respuesta["tiene_canon"] = $obt_salon["tiene_canon"];
        $respuesta["status"] = $obt_salon["status"];
        echo json_encode($respuesta);
    }

    function updateClass($id_salones){
        global $db;
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $nombre = $_POST['nombre'];
        $id_grados = $_POST['id_grados'];
        $tiene_canon = $_POST['tiene_canon'];
        $status = $_POST['status'];


        if (empty($nombre) && empty($id_grados) && empty($tiene_canon) && empty($status)) {
            $respuesta["respuesta"] = 0;
        }else{
            $db->update("salones", [
                "nombre" => $nombre,
                "id_grados" => $id_grados,
                "tiene_canon" => $tiene_canon,
                "status" => $status
            ], [
                "id_salones" => $id_salones
            ]);
            $respuesta["respuesta"] = 1;
        }
        echo json_encode($respuesta);
    }


    function deleteClass($id_salones){
        global $db;
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $db->delete("salones", ["id_salones" => $id_salones]);
        $respuesta["status"] = 1;
        echo json_encode($respuesta);
    }
    
?>