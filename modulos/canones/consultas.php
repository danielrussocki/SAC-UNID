<?php
require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
session_start();
error_reporting(0);
$varsesion = $_SESSION['email'];
//Recibir variable post
switch ($_POST["accion"]) {

	case 'deleteCanon':
		eliminar_canon();
		break;
		case 'insertCanon':
		insertar_canon();
		break;
		case 'getCanon':
		get_canon();
		break;
		case 'updateCanon':
		update_canon();
		break;
	default:
		# code...
		break;
}


function eliminar_canon(){
	global $db;
	$fecha= strftime("%y-%m-%d %H:%M:%S");
	$respuesta = [];
	$canon_e = $db->delete("canones",["id_can" => $_POST["canon"]]);
	$varsesion= $_SESSION['email'];

	$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion Elimino en el modulo Canones", "fecha_hora"=>$fecha]);

		if ($canon_e) {
			$respuesta["status"] = 1;
		}else{
			$respuesta["status"] = 0;
		}
		echo json_encode($respuesta);
}

function insertar_canon(){
	global $db;
	$respuesta = [];
	$nombre = $_POST['nombre'];
	$status = $_POST['status'];
	$entrada = $_POST['entrada'];
	$control = $_POST['control'];
	$serie = $_POST['serie'];
	$fecha= strftime("%y-%m-%d %H:%M:%S");
	if(
		$nombre != '' &&
		$status != '' &&
		$entrada != '' &&
		$control != '' &&
		$serie != ''
	){
		$first_val = $db->get("canones", "serie_can", ["serie_can"=>$serie]);
		if($first_val){
			$respuesta["status"] = 2;
		} else {
			$canon_e = $db->insert(
				"canones",
				[
					"id_can"=>"",
					"nombre_can"=>$nombre,
					"status_can"=>$status,
					"entrada_can"=>$entrada,
					"control_can"=>$control,
					"serie_can"=>$serie
				]);
				$varsesion= $_SESSION['email'];

				$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion inserto en el modulo Canones", "fecha_hora"=>$fecha]);

			$canon_e ? $respuesta["status"] = 1 : $respuesta["status"] = 0;
		}
	} else {
		$respuesta["status"] = 3;
	}
	echo json_encode($respuesta);
}

function get_canon(){
	global $db;
	$respuesta = $db->get("canones", "*", ["id_can" => $_POST['canon']]);
	echo json_encode($respuesta);
}

function update_canon(){
	global $db;
	$nombre = $_POST['nombre'];
	$status = $_POST['status'];
	$entrada = $_POST['entrada'];
	$control = $_POST['control'];
	$serie = $_POST['serie'];
	$id = $_POST['canon'];
	$fecha= strftime("%y-%m-%d %H:%M:%S");
	$respuesta = [];
	if(
		$nombre != '' &&
		$status != '' &&
		$entrada != '' &&
		$control != '' &&
		$serie != ''
	){
		$first_val = $db->get("canones", "serie_can", [
			"AND" => [
				"serie_can"=>$serie,
				"id_can[!]"=>$id
			]
		]);
		if($first_val){
			$respuesta["status"] = 2;
		} else {
			$canon_e = $db->update("canones", [
				"nombre_can"=>$nombre,
				"status_can"=>$status,
				"entrada_can"=>$entrada,
				"control_can"=>$control,
				"serie_can"=>$serie
			], ["id_can" => $id]);

			$varsesion= $_SESSION['email'];

			$db->insert("logs",["id_logs"=>"", "mensaje"=>"El usuario $varsesion actualizo en el modulo Canones", "fecha_hora"=>$fecha]);
			$canon_e ? $respuesta["status"] = 1 : $respuesta["status"] = 0;
		}
	} else {
		$respuesta["status"] = 3;
		
	}
	echo json_encode($respuesta);
}

 ?>