<?php
 require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
 session_start();
 error_reporting(0);
 $varsesion = $_SESSION['email'];
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
		$fecha= strftime("%y-%m-%d %H:%M:%S");

		if (empty($nombre) && empty($status)) {
			$respuesta["status"] = 0;
		}else{
			$db->insert("niveles",[
				"nombre" => $nombre,
				"status" => $status
			]);
			$varsesion= $_SESSION['email'];

			$db->insert("logs",["id_logs"=>"", "mensaje"=>"El usuario $varsesion inserto en el modulo Niveles", "fecha_hora"=>$fecha]);
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
		$fecha= strftime("%y-%m-%d %H:%M:%S");
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
			$varsesion= $_SESSION['email'];

				$db->insert("logs",["id_logs"=>"", "mensaje"=>"El usuario $varsesion actualizo en el modulo Niveles", "fecha_hora"=>$fecha]);
			$respuesta["respuesta"] = 1;
		}
		echo json_encode($respuesta);
	}


	function deleteNivel($id){
		global $db;
		$fecha= strftime("%y-%m-%d %H:%M:%S");
		$db->delete("niveles", ["id" => $id]);
		$varsesion= $_SESSION['email'];

				$db->insert("logs",["id_logs"=>"", "mensaje"=>"El usuario $varsesion elimino en el modulo Niveles", "fecha_hora"=>$fecha]);
		$respuesta["status"] = 1;
		echo json_encode($respuesta);
    }
    
?>