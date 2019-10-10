<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';

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
						 
                    		if ($usuarios) {
								//Envio de correo
								$to = $_POST["email"];
								$subject = 'Activación de correo';
								$msg = '<h1>Hola, bienvenido a nuestro sistema de apartado de cañones.</h1> <p>Link de activación: ...</p>';
								$headers = "From: Sistema Cañones <sistemacanones@smoothoperators.com.mx>\r\n";
								$headers = "Reply To: replyto@smoothoperators.com.mx\r\n";
								$headers .= "Content-type text/html\r\n";
								mail($to, $subject, $msg, $headers);
                            	$respuesta["status"] = 1;
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