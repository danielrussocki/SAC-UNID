<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
	session_start();
	error_reporting(0);
	$varsesion = $_SESSION['email'];
	if ($_POST) {
		switch ($_POST["accion"]) {
			case 'insertServicio':
				insertServicio();
				break;
			
			case 'getServicio':
				getServicio($_POST['servicio']);
				break;

			case 'updateServicio':
				updateServicio($_POST['servicio']);
				break;

			case 'deleteServicio':
				deleteServicio($_POST['servicio']);
				break;

			default:
				# code...
				break;
		}
	}

	function insertServicio(){
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
			$db->insert("servicios",[
				"nombre" => $nombre,
				"status" => $statu
			]);
			$varsesion= $_SESSION['email'];

			$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion inserto en el modulo Servicios", "fecha_hora"=>$fecha]);
			$respuesta["status"] = 1;
		} else if(!empty($nombre) && $status == "false"){
			$db->insert("servicios",[
				"nombre" => $nombre,
				"status" => $statua
			]);
			$varsesion= $_SESSION['email'];

			$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion inserto en el modulo Servicios", "fecha_hora"=>$fecha]);
			$respuesta["status"] = 1;
		}
		echo json_encode($respuesta);
	}

	function getServicio($id){
		global $db;
		
		$servicio = $db->get("servicios", "*", ["id" => $id]);
		$respuesta["nombre"] = $servicio["nombre"];
		$respuesta["st"] = $servicio["status"];
		echo json_encode($respuesta);
	}

	function updateServicio($id){
		global $db;
		$fecha= strftime("%y-%m-%d %H:%M:%S");
		$nombre = $_POST['nombre'];
		$status = $_POST['status'];
		$statu = 1;
		$statua = 0;

		if (empty($nombre)) {
			$respuesta["respuesta"] = 0;
		}else if(!empty($nombre) && $status == "true"){
			$db->update("servicios", [
				"nombre" => $nombre,
				"status" => $statu
			], [
				"id" => $id
			]);
			$varsesion= $_SESSION['email'];

				$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion actualizo en el modulo Servicios", "fecha_hora"=>$fecha]);
			$respuesta["respuesta"] = 1;
		} else if(!empty($nombre) && $status == "false"){
			$db->update("servicios", [
				"nombre" => $nombre,
				"status" => $statua
			], [
				"id" => $id
			]);
			$respuesta["respuesta"] = 1;
		}
		echo json_encode($respuesta);
	}

	function deleteServicio($id){
		global $db;
		$fecha= strftime("%y-%m-%d %H:%M:%S");
		$db->delete("servicios", ["id" => $id]);
		$varsesion= $_SESSION['email'];

		$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion elimino en el modulo Servicio", "fecha_hora"=>$fecha]);
		$respuesta["status"] = 1;
		echo json_encode($respuesta);
	}
?>