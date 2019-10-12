<?php
require_once $_SERVER["DOCUMENT_ROOT"] . 'includes/database.php';
require $_SERVER["DOCUMENT_ROOT"] . 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_POST) {
	switch ($_POST["accion"]) {
		case 'insertApartado':
			insertApartado();
			break;
		case 'getApartado':
			getApartado($_POST['id']);
			break;
		case 'updateReserva':
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
	$usuario = $_POST['usuario'];
	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_fin = $_POST['fecha_fin'];
	$hora_inicio = $_POST['hora_inicio'];
	$hora_fin = $_POST['hora_fin'];
	$servicio = $_POST['servicio'];
	$canon = $_POST['canon'];
	$salon = $_POST['salon'];
	$comentario = $_POST['comentario'];
	$accesorio = $_POST['accesorio'];
	$status = 0;
	$fecha= strftime("%y-%m-%d %H:%M:%S");

	if (empty($usuario) && empty($fecha_inicio) && ($fecha_fin) && ($hora_inicio) && ($hora_fin) && ($servicio) && ($canon) && ($salon)) {
		$respuesta["status"] = 0;
	} else if (!empty($usuario)  && $status == "true") {
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

		global $db;
		$data = $db->get("usuarios","*",["id_usr" => $usuario]);

		$mail = new PHPMailer;

		try {
			$mail->isSMTP();
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;
			$mail->Host = 'smtp.sendgrid.net';
			$mail->SMTPAuth = true;
			$mail->Username = 'apikey';
			$mail->Password = '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';
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = 587;

			$mail->setFrom('apartado@canones.com', 'Sistema Apartado Cañones'); //send
			$mail->addAddress($data["email_usr"], $data["nombre_usr"]);  //recive

			$mail->Subject = 'Sistema apartado cañones';
			$mail->msgHTML(file_get_contents('message.html'), __DIR__);
			$mail->AltBody = 'La logia Corp.';

			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
		
		var_dump($db->error());
		var_dump($db->log());
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


function updateServicio($id)
{
	global $db;
	$usuario = $_POST['usuario_id'];
	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_fin = $_POST['fecha_final'];
	$hora_inicio = $_POST['hora_inicio'];
	$hora_fin = $_POST['hora_final'];
	$servicio = $_POST['servicios_id'];
	$canon = $_POST['cañon_id'];
	$salon = $_POST['salon_id'];
	$comentario = $_POST['comentarios'];
	$accesorio = $_POST['accesorios'];
	$status = $_POST['status'];
	$fecha= strftime("%y-%m-%d %H:%M:%S");
	if (empty($usuario) && empty($fecha_inicio) && ($fecha_fin) && ($hora_inicio) && ($hora_fin) && ($servicio) && ($canon) && ($salon)) {
		$respuesta["status"] = 0;
	} else if (!empty($usuario) && $status == "true") {
		$db->update("servicios", [
			"usr_id" => $usuario,
			"fecha_inicio" => $fecha_inicio,
			"fecha_fin" => $fecha_fin,
			"hora_inicio" => $hora_inicio,
			"hora_fin" => $hora_fin,
			"servicios_id" => $servicio,
			"cano_id" => $canon,
			"salon_id" => $salon,
			"comentarios" => $comentario,
			"accesorios" => $accesorio,
			"status" => $status
		], [
			"id" => $id
		]);
		$varsesion= $_SESSION['email'];

		$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion Actualizo en el modulo Apartado", "fecha_hora"=>$fecha]);
		$respuesta["respuesta"] = 1;
		var_dump($db->error());
		var_dump($db->log());
	}
	echo json_encode($respuesta);
}


//done
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
