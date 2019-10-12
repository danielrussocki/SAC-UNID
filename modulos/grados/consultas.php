<?php
 require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
if ($_POST) {
    switch ($_POST["accion"]) {
        case 'insertGrades':
            insertGrades();
            break;

        case 'updateGrades':
        updateGrades($_POST["grados"]);
        break;

        case 'getGrades':
        getGrades($_POST["grados"]);
        break;

        case 'deleteGrades':
        deleteGrades($_POST["grado"]);
        break;         
        
        default:
            break;
    }
}

    function insertGrades(){
        global $db;
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $respuesta = [];
        $nombre = $_POST['nombre'];
        $status = $_POST['status'];

        if (empty($nombre) && empty($status)) {
            $respuesta["status"] = 0;
        }else{
            $db->insert("grados",[
                "nombre" => $nombre,
                "status" => $status
            ]);
            $respuesta["status"] = 1;
        }
        echo json_encode($respuesta);
    }

    function updateGrades($id_grados){
        global $db;
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $nombre = $_POST['nombre'];
        $status = $_POST['status'];

        if (empty($nombre) && empty($status)) {
            $respuesta["respuesta"] = 0;
        }else{
            $db->update("grados", [
                "nombre" => $nombre,
                "status" => $status
            ], [
                "id_grados" => $id_grados
            ]);
            $respuesta["respuesta"] = 1;
        }
        echo json_encode($respuesta);
    }

    function getGrades($id_grados){
        global $db;
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $grados = $db->get("grados", "*", ["id_grados" => $id_grados]) ;
        $respuesta["nombre"] = $grados["nombre"];
        $respuesta["status"] = $grados["status"];
        echo json_encode($respuesta);
    }

    function deleteGrades($id_grados){
        global $db;
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $db->delete("grados", ["id_grados" => $id_grados]);
        $respuesta["status"] = 1;
        echo json_encode($respuesta);
    }
    
?>