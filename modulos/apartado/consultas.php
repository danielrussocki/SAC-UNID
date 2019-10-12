<?php
require_once $_SERVER["DOCUMENT_ROOT"] . 'includes/database.php';
require $_SERVER["DOCUMENT_ROOT"] . 'vendor/autoload.php';
session_start();

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
		default:
			break;
	}
}
function insertApartado()
{
	global $db;
	$respuesta = [];
	extract($_POST);
	$status = 0;

	if (empty($usuario) && empty($fecha_inicio) && ($fecha_fin) && ($hora_inicio) && ($hora_fin) && ($servicio) && ($canon) && ($salon)) {
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
		$respuesta["status"] = 1;
		
		$mail = new PHPMailer;
		try {
			$mail->isSMTP();
			$mail->Host = 'smtp.sendgrid.net';
			$mail->SMTPAuth = true;
			$mail->Username = 'apikey';
			$mail->Password = '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';
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = 587;

			$mail->setFrom('apartado@canones.com', 'Sistema Apartado Cañones'); //send
			$mail->addAddress($_SESSION['email'], $_SESSION['nombre']);  //recive

			$mail->Subject = 'Sistema apartado cañones';
			$mail->msgHTML(file_get_contents('message.html'), __DIR__);
			$mail->AltBody = 'La logia Corp.';

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
	$respuesta = [];
	extract($_POST);
	if (empty($usuario) && empty($fecha_inicio) && ($fecha_fin) && ($hora_inicio) && ($hora_fin) && ($servicio) && ($canon) && ($salon)) {
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
		$respuesta["status"] = 1;
	}
	echo json_encode($respuesta);
}



function deleteApartado($id)
{
	global $db;
	$db->delete("reservas", ["id_apartado" => $id]);
	$respuesta["status"] = 1;
	echo json_encode($respuesta);
}
