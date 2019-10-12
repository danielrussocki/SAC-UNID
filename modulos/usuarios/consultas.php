<?php
require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
session_start();
error_reporting(0);
$varsesion = $_SESSION['email'];

if ($_POST) {
    switch ($_POST["accion"]) {
        case 'insertUsuario':
            insertUsuario();
            break;

        case 'updateUsuario':
        updateUsuario($_POST["usuario"], $_POST["matricula_original"])
        ;
        break;

        case 'getUsuario':
        getUsuario($_POST["usuario"]);
        break;

        case 'deleteUsuario':
        deleteUsuario($_POST["usuario"]);
        break;         
        
        default:
            break;
    }
}

    function insertUsuario(){
        global $db;
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $respuesta = [];
        $duplicate = false;
        if($_POST["matricula"]  != ""  && $_POST["nombre"]  != ""  && $_POST["telefono"]  != ""  && $_POST["email"]  != "" && 
        $_POST["contraseña"]  != "")
        {
            $matriculas = $db->select("usuarios","matricula_usr");
            foreach ($matriculas as $matricula) {
                if($matricula == $_POST["matricula"]){
                    $duplicate = true;
                }
            } if (!$duplicate)       
              { 
                $status = $_POST['status'];
                // $status != null ? $status = "1" : $status = "0";
                $status ? $status = "1" :  $status = "0";
                $usuarios = $db->insert('usuarios',[
                    "matricula_usr" => $_POST["matricula"],
                    "nombre_usr" => $_POST["nombre"],
                    "telefono_usr" => $_POST["telefono"],
                    "email_usr" => $_POST["email"],
                    "nivel_usr" => "1",
                    "status_usr" => $status,
                    "password_usr" => $_POST["contraseña"]
                    ]); 
                    $varsesion= $_SESSION['email'];

		$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion inserto en el modulo Usuarios", "fecha_hora"=>$fecha]);
                    if($usuarios){
                            $respuesta["status"] = 1;
                    } else{
                        $respuesta["status"] = 0;
                    }
                    echo json_encode($respuesta);
                } else{
                    $respuesta["status"]=2;
                    echo json_encode($respuesta);
                }  
    }else{
        $respuesta["status"]=0;
        echo json_encode($respuesta);
    }
}

function updateUsuario($id, $matricula){
    global $db;
    $fecha= strftime("%y-%m-%d %H:%M:%S");
    $respuesta = [];
    $duplicate = false;
    if($_POST["matricula"]  != ""  && $_POST["nombre"]  != ""  && $_POST["telefono"]  != ""  && $_POST["email"]  != "" && 
    $_POST["contraseña"]  != "")
    { 
        if($matricula == $_POST["matricula"]){
        $duplicate = false;
    } else{
        $matriculas = $db->select("usuarios","matricula_usr");
        foreach ($matriculas as $mat) {
            if($mat == $_POST["matricula"]){
                $duplicate = true;
            }
        }
    } if (!$duplicate)       
          {
            $status = $_POST['status'];
            $status ? $status = "1" :  $status = "0";
            $usuarios = $db->update("usuarios", [
                "matricula_usr" => $_POST["matricula"],
                "nombre_usr" => $_POST["nombre"],
                "telefono_usr" => $_POST["telefono"],
                "email_usr" => $_POST["email"],
                "nivel_usr" => 1,
                "status_usr" => $status,
                "password_usr" => $_POST["contraseña"]
            ],
                [
                    "id_usr" => $id
                ]);
                $varsesion= $_SESSION['email'];

		$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion Actualizo en el modulo Usuarios", "fecha_hora"=>$fecha]);
                if($usuarios){
                        $respuesta["status"] = 1;
                } else{
                    $respuesta["status"] = 0;
                }
                echo json_encode($respuesta);
            } else{
                $respuesta["status"]=2;
                echo json_encode($respuesta);
            }  
}else{
    $respuesta["status"]=0;
    echo json_encode($respuesta);
}
}


    function getUsuario($id){
        global $db;
        $respuesta = [];
        $usuario = $db->get("usuarios", "*", ["id_usr" => $id]) ;
        $respuesta["matricula"] = $usuario["matricula_usr"];
        $respuesta["nombre"] = $usuario["nombre_usr"];
        $respuesta["telefono"] = $usuario["telefono_usr"];
        $respuesta["email"] = $usuario["email_usr"];
        $respuesta["contraseña"] = $usuario["password_usr"];
        $respuesta["status"] = 1;
        
 
        echo json_encode($respuesta);
    }
     
    function deleteUsuario($id){
        global $db;
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $respuesta = [];
        $usuarios = $db -> delete("usuarios", [
            "id_usr"=> $id
            ]);
            $varsesion= $_SESSION['email'];

		$db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion Elimino en el modulo Usuarios", "fecha_hora"=>$fecha]);
            if($usuarios){
                $respuesta["status"]=1;
                echo json_encode($respuesta);
            }else{
                $respuesta["status"]=0;
                echo json_encode($respuesta);
            }
    }

?>