<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
	use PHPMailer\PHPMailer\PHPMailer;
	require $_SERVER["DOCUMENT_ROOT"] . 'vendor/autoload.php';
	session_start();
	error_reporting(0);
	$varsesion = $_SESSION['email'];
	if ($_POST) {
		switch ($_POST["accion"]) {
			case 'login':
				login();
				break;
			
			case 'register':
				register();
				break;

			default:
				break;
		}
	}

	function login(){
		global $db;
		$respuesta = [];
		$fecha= strftime("%y-%m-%d %H:%M:%S");

		if ($_POST['usuario'] !=  "") {	

			$usuario = $db->get("usuarios", "*", ["email_usr" => $_POST['usuario']]);

			if ($usuario) {

				if ($usuario = $db->get("usuarios", "*", ["AND" => ["email_usr" => $_POST['usuario'], "status_usr"=> 0]])) {
					$respuesta["status"] = 6;
				}elseif ($usuario = $db->get("usuarios", "*", ["AND" => ["email_usr" => $_POST['usuario'], "password_usr"=> $_POST['password']]])) {
					session_start();
					error_reporting(0);
					$_SESSION['id'] = $usuario["id_usr"];
					$_SESSION['nombre'] = $usuario["nombre_usr"];
					$_SESSION['email'] = $usuario["email_usr"];
					$_SESSION['status'] = $usuario["status_usr"];
					$_SESSION['nivel'] = $usuario["nivel_usr"];
					$respuesta["status"] = 3;
					$varsesion= $_SESSION['email'];

				    $db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion A iniciado sesion", "fecha_hora"=>$fecha]);

				}else{
					$respuesta["status"] = 2;
				}

			}else{
				$respuesta["status"] = 4;
			}
		
		}else{
			$respuesta["status"] = 5;
		}
		
		echo json_encode($respuesta);
	}

	function register(){
		global $db;
		$fecha= strftime("%y-%m-%d %H:%M:%S");
		$respuesta = [];
		$duplicate = false;
		
			if ($_POST["contraseña"] != $_POST["contraseña2"]) {
				$respuesta["status"] = 3;
			}elseif ($_POST["matricula"]  != ""  && $_POST["nombre"]  != ""  && $_POST["telefono"]  != ""  && $_POST["email"]  != "" &&  $_POST["contraseña"]  != "" &&  $_POST["contraseña2"]  != "") {

            	$matriculas = $db->select("usuarios","matricula_usr");
            		foreach ($matriculas as $matricula) {

                		if($matricula == $_POST["matricula"]){
                    		$duplicate = true;
						}
						
					} 
					
					if (!$duplicate) {
                		$usuarios = $db->insert('usuarios',[
                    	"matricula_usr" => $_POST["matricula"],
                    	"nombre_usr" => $_POST["nombre"],
                    	"telefono_usr" => $_POST["telefono"],
                    	"email_usr" => $_POST["email"],
                    	"nivel_usr" => "1",
                    	"status_usr" => "0",
                    	"password_usr" => $_POST["contraseña"]
						]);
						
						$varsesion= $_SESSION['email'];
						$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion inserto en el modulo Login", "fecha_hora"=>$fecha]);
						 
                    		if ($usuarios) {
								$email = $db->get("usuarios", "*", [
									"matricula_usr" => $_POST["matricula"]
								]);
								$email_to = $email["email_usr"];
								$id_usr = $email["id_usr"];
								$path = "http://smoothoperators.com.mx/modulos/login/";
								$activeLink = $path."activar_usr.php?id=".$id_usr;
								$email_from = "mail@smoothoperators.com.mx";
								$from_name = "Sistema Cañones";
								$subject = "Activación de cuenta Sistema Cañones";
								$body = "Bienvenido a nuestro sistema, por favor da click al siguiente link para activar tu cuenta: <br><br><a href=$activeLink>$activeLink</a>";
								global $error;
								$mail = new PHPMailer();  // create a new object
								$mail->CharSet = "utf-8";
								$mail->IsSMTP(); // enable SMTP
								$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
								$mail->SMTPAuth = true;  // authentication enabled
								$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
								$mail->Host = 'smtp.gmail.com';
								$mail->Port = 465; 
								$mail->Username = 'mail.smoothoperators@gmail.com';  
								$mail->Password = 'Goodluck13';
								$mail->SetFrom($email_from, $from_name);
								$mail->Subject = $subject;
								$mail->Body = $body;
								$mail->IsHTML(true);
								$mail->AddAddress($email_to);
									if(!$mail->Send()) {
										//$error = 'Mail error: '.$mail->ErrorInfo; 
										//echo $error;
										$respuesta["status"] = 4;
									} else {
										$respuesta["status"] = 1;
									}
                    		} else {
                        		$respuesta["status"] = 0;
                    	}

                	} else {
                    	$respuesta["status"] = 2;
					}
				  
    		} else {
        		$respuesta["status"] = 0;
			}
		echo json_encode($respuesta);
	}
?>