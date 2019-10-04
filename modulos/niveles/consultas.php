<?php
 require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
 if ($_POST) {
     switch ($_POST["accion"]) {
        case 'insertNivel':
            insertNivel();
        break;

        case 'getNivel':
            getNivel($_POST['nivel']);
            break;
            
		case 'updateNivel':
			updateNivel($_POST['nivel']);
			break;

        case 'deleteNivel':
            deleteNivel($_POST['nivel']);
            break;

        default:
            # code...
            break;
     }
 }

 	function insertNivel(){
		global $db;
		$respuesta = [];
		$nombre = $_POST['nombre'];
		$status = $_POST['status'];

		if (empty($nombre) && empty($status)) {
			$respuesta["status"] = 0;
		}else{
			$db->insert("niveles",[
				"nombre" => $nombre,
				"status" => $status
			]);
			$respuesta["status"] = 1;
		}
		echo json_encode($respuesta);
	}

    function getNivel($id){
		global $db;
        $nivel = $db->get("niveles", "*", ["id" => $id]);
        $respuesta["nombre"] = $nivel["nombre"];
        $respuesta["status"] = $nivel["status"];
        echo json_encode($respuesta);
    }

	function updateNivel($id){
		global $db;
		$nombre = $_POST['nombre'];
		$status = $_POST['status'];

		if (empty($nombre) && empty($status)) {
			$respuesta["respuesta"] = 0;
		}else{
			$db->update("niveles", [
				"nombre" => $nombre,
				"status" => $status
			], [
				"id" => $id
			]);
			$respuesta["respuesta"] = 1;
		}
		echo json_encode($respuesta);
	}


	function deleteNivel($id){
		global $db;
		$db->delete("niveles", ["id" => $id]);
		$respuesta["status"] = 1;
		echo json_encode($respuesta);
    }
    
?>