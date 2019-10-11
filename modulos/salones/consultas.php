<?php
require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';

if ($_POST) {
    switch ($_POST["accion"]) {
        case 'insertClass':
            insertClass();
            break;

        case 'updateClass':
        updateClass($_POST["salones"], $_POST["nombre_original"]);
        break;

        case 'getClass':
        getClass($_POST["salones"]);
        break;

        case 'deleteClass':
        deleteClass($_POST["salon"]);
        break;         
        
        default:
            break;
    }
}
  
    function insertClass(){
        global $db;
        $respuesta = [];
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $duplicate = false;
        if($_POST["nombre"]  != "" && $_POST["id_grados"]  != "" && $_POST["tiene_canones"]  != "")
        {
            $salon = $db->select("salones","nombre");
            foreach ($salon as $salones) {
                if($salon == $_POST["nombre"]){
                    $duplicate = true;
                }
            } if (!$duplicate)       
              {
                $salon = $db->insert('salones',[
                    "nombre" => $_POST["nombre"],
                    "id_grados" => $_POST["id_grados"],
                    "tiene_canon" => $_POST["tiene_canones"],
                    "status" => "1",
                    ]); 
                    $varsesion= $_SESSION['email'];

				    $db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion inserto en el modulo Salones", "fecha_hora"=>$fecha]);
                    if($salon){
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

function updateClass($id_salones, $nombre){
    global $db;
    $respuesta = [];
    $fecha= strftime("%y-%m-%d %H:%M:%S");
    $duplicate = false;
    if($_POST["nombre"]  != "" && $_POST["id_grados"]  != "" && $_POST["tiene_canones"]  != "") { 
            if($nombre == $_POST["nombre"]){
                $duplicate = false;
            }else{
        $nombres = $db->select("salones","nombre");
        foreach ($nombres as $nom) {
            if($nom == $_POST["nombre"]){
                $duplicate = true;
            }
        }
    } if (!$duplicate)       
          {
            $nombres = $db->update("salones", [
                "nombre" => $_POST["nombre"],
                "id_grados" => $_POST["id_grados"],
                "tiene_canon" => $_POST["tiene_canones"],
                "status" => "1"
            ],
                [
                    "id_salones" => $id_salones
                ]);
                $varsesion= $_SESSION['email'];

				    $db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion Actualizo en el modulo Salones", "fecha_hora"=>$fecha]);
                if($nombres){
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


    function getClass($id_salones){
        global $db;
        $respuesta = [];
        $obt_salon = $db->get("salones", "*", ["id_salones" => $id_salones]) ;
        $respuesta["nombre"] = $obt_salon["nombre"];
        $respuesta["id_grados"] = $obt_salon["id_grados"];
        $respuesta["tiene_canon"] = $obt_salon["tiene_canon"];
        $respuesta["status"] = 1;
        
 
        echo json_encode($respuesta);
    }
     //okokok
    function deleteClass($id_salon){
        global $db;
        $respuesta = [];
        $fecha= strftime("%y-%m-%d %H:%M:%S");
        $salones = $db->delete("salones", ["id_salones" => $id_salon]);
        $varsesion= $_SESSION['email'];

				    $db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion Elimino en el modulo Salones", "fecha_hora"=>$fecha]);
            if($salones){
                $respuesta["status"]=1;
                echo json_encode($salones);
            }else{
                $respuesta["status"]=0;
                echo json_encode($respuesta);
            }
    }

?>