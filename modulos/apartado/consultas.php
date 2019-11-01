<?php
require_once $_SERVER["DOCUMENT_ROOT"] . 'includes/database.php';
require $_SERVER["DOCUMENT_ROOT"] . 'vendor/autoload.php';
session_start();
error_reporting(0);
$varsesion = $_SESSION['email'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_POST) {
	switch ($_POST["accion"]) {
		case 'insertApartado':
			insertApartado();
			break;
		case 'getApartado':
			getApartado($_POST['id']);
			break;
		case 'updateApartado':
			updateApartado($_POST['id']);
			break;
		case 'deleteApartado':
			deleteApartado($_POST['id']);
			break;
		case 'guardar':
			guardar();
			break;
		default:
			break;
	}
}
function guardar(){
	global $db;
	$datos = $_POST["datos"];
	$contador = count($datos);
	if($contador > 0){
		$todos = [];
		foreach($datos as $dato => $valor){
			$registro = json_decode($valor);
			$fecha_inicio = date("Y-m-d", strtotime($registro->dia_inicio));
			$hora_inicio = date("H:i:s", strtotime($registro->hora_inicio));
			$arreglo = [
				"accesorios" => $registro->accesorios,
				"canon_id" => $registro->canon,
				"comentarios" => $registro->comentarios,
				"fecha_fin" => $fecha_inicio,
				"fecha_inicio" => $fecha_inicio,
				"hora_inicio" => $hora_inicio,
				"hora_fin" => $hora_inicio,
				"salon_id" => $registro->salon,
				"servicios_id" => $registro->servicio,
				"usr_id" => $registro->usuario
			];
			array_push($todos, $arreglo);
		}
		$db->insert("reservas", $todos);
	}
}
function insertApartado()
{
	global $db;
	$respuesta = [];
	extract($_POST);
	$status = 0;
	$fecha= strftime("%y-%m-%d %H:%M:%S");

	if (empty($usuario) || empty($fecha_inicio) || empty($fecha_fin) || empty($hora_inicio) || empty($hora_fin) || empty($servicio) || empty($canon) || empty($salon)) {
		$respuesta["status"] = 0;
	} else {
		$db->insert("reservas", [
			"usr_id" => $usuario,
			"fecha_inicio" => $fecha_inicio,
			"fecha_fin" => $fecha_fin,
			"hora_inicio" => $hora_inicio,
			"hora_fin" => $hora_fin,
			"servicios_id" => $servicio,
			"canon_id" => $canon,
			"salon_id" => $salon,
			"comentarios" => $comentario,
			"accesorios" => $accesorio,
			"status" => $status
		]);
		$varsesion= $_SESSION['email'];
		$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion inserto en el modulo Apartado", "fecha_hora"=>$fecha]);
		$respuesta["status"] = 1;
		$mail = new PHPMailer;
		$mail->CharSet = "utf-8";
		global $error;
		try {
			$mail->isSMTP();
			$mail->SMTPDebug = 0; 
			$mail->SMTPAuth = true; 
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 465; 
			$mail->Username = 'mail.smoothoperators@gmail.com';  
			$mail->Password = 'Goodluck13';
			$mail->SMTPSecure = 'ssl';
			$email_from = "mail@smoothoperators.com.mx";
			$from_name = "Sistema Cañones";
			$mail->SetFrom($email_from, $from_name);
			$mail->Subject = 'Sistema apartado cañones';
			$mail->msgHTML(file_get_contents('message.html'), __DIR__);
			$mail->addAddress($_SESSION['email'], $_SESSION['nombre']);  //recive

			$mail->send();
			if (!$mail) {
				print_r('Message has been sent');
			}
		} catch (Exception $e) {
			print_r("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
		}
	}
	echo json_encode($respuesta);
}

function getApartado($id)
{
	global $db;
	$apartado = $db->get("reservas", "*", ["id_apartado" => $id]);
	$respuesta["usuario"] = $apartado["usr_id"];
	$respuesta["fecha_inicio"] = $apartado["fecha_inicio"];
	$respuesta["fecha_fin"] = $apartado["fecha_fin"];
	$respuesta["hora_inicio"] = $apartado["hora_inicio"];
	$respuesta["hora_fin"] = $apartado["hora_fin"];
	$respuesta["servicio"] = $apartado["servicios_id"];
	$respuesta["canon"] = $apartado["canon_id"];
	$respuesta["salon"] = $apartado["salon_id"];
	$respuesta["comentario"] = $apartado["comentarios"];
	$respuesta["accesorio"] = $apartado["accesorios"];
	$respuesta["status"] = $apartado["status"];
	echo json_encode($respuesta);
}


function updateApartado($id)
{
	global $db;
	$fecha= strftime("%y-%m-%d %H:%M:%S");
	$respuesta = [];
	extract($_POST);
	if (empty($usuario) || empty($fecha_inicio) || empty($fecha_fin) || empty($hora_inicio) || empty($hora_fin) || empty($servicio) || empty($canon) || empty($salon)) {
		$respuesta["status"] = 0;
	} else {
		$db->update("reservas", [
			"usr_id" => $usuario,
			"fecha_inicio" => $fecha_inicio,
			"fecha_fin" => $fecha_fin,
			"hora_inicio" => $hora_inicio,
			"hora_fin" => $hora_fin,
			"servicios_id" => $servicio,
			"canon_id" => $canon,
			"salon_id" => $salon,
			"comentarios" => $comentario,
			"accesorios" => $accesorio,
			"status" => $status
		], [
			"id_apartado" => $id
		]);

		$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion Actualizo en el modulo Apartado", "fecha_hora"=>$fecha]);
		$respuesta["status"] = 1;
	}
	echo json_encode($respuesta);
}



function deleteApartado($id)
{
	global $db;
	$fecha= strftime("%y-%m-%d %H:%M:%S");
	$db->delete("reservas", ["id_apartado" => $id]);
	$varsesion= $_SESSION['email'];
  $db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion Elimino en el modulo Apartado", "fecha_hora"=>$fecha]);
	$respuesta["status"] = 1;
	echo json_encode($respuesta);
}
