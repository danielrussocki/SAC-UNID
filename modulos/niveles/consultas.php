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
	$statu = 1;
	$statua = 0;
	$fecha= strftime("%y-%m-%d %H:%M:%S");

	if (empty($nombre)) {
		$respuesta["status"] = 0;
	}else if(!empty($nombre) && $status == "true"){
		$db->insert("niveles",[
			"nombre" => $nombre,
			"status" => $statu
		]);
		$varsesion= $_SESSION['email'];

		$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion inserto en el modulo Niveles", "fecha_hora"=>$fecha]);
		$respuesta["status"] = 1;
	} else if(!empty($nombre) && $status == "false"){
		$db->insert("niveles",[
			"nombre" => $nombre,
			"status" => $statua
		]);
		$varsesion= $_SESSION['email'];

		$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion inserto en el modulo Niveles", "fecha_hora"=>$fecha]);
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
		$statu = 1;
		$statua = 0;

		if (empty($nombre)) {
			$respuesta["respuesta"] = 0;
		}else if(!empty($nombre) && $status == "true"){
			$db->update("niveles", [
				"nombre" => $nombre,
				"status" => $statu
			], [
				"id" => $id
			]);
			$varsesion= $_SESSION['email'];

				$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion actualizo en el modulo Niveles", "fecha_hora"=>$fecha]);
			$respuesta["respuesta"] = 1;
		} else if(!empty($nombre) && $status == "false"){
			$db->update("niveles", [
				"nombre" => $nombre,
				"status" => $statua
			], [
				"id" => $id
			]);
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