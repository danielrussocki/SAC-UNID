<?php
require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';

if ($_POST) {
    switch ($_POST["accion"]) {
        case 'insertGrades':
            insertGrades();
            break;

        case 'updateGrades':
        updateGrades($_POST["grados"], $_POST["nombre"]);
        break;

        case 'getGrades':
        getGrades($_POST["grados"]);
        break;

        case 'deleteGrades':
        deleteGrades($_POST["grado"]);
        break;         
        
        default:
            break;
    }
}
  //okokok
    function insertGrades(){
        global $db;
        $respuesta = [];
        $duplicate = false;
        if($_POST["nombre"]  != "")
        {
            $grados = $db->select("grados","nombre");
            foreach ($grados as $grado) {
                if($grados == $_POST["nombre"]){
                    $duplicate = true;
                }
            } if (!$duplicate)       
              {
                $grados = $db->insert('grados',[
                    "nombre" => $_POST["nombre"],
                    "status" => "1",
                    ]); 
                    if($grados){
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

function updateGrades($id_grados, $nombre){
    global $db;
    $respuesta = [];
    $duplicate = false;
    if($_POST["nombre"]  != "") { 
            if($id_grados == $_POST["nombre"]){
                $duplicate = false;
            }else{
        $grados = $db->select("grados","nombre");
        foreach ($grados as $nom) {
            if($nom == $_POST["nombre"]){
                $duplicate = true;
            }
        }
    } if (!$duplicate)       
          {
            $grados = $db->update("grados", [
                "nombre" => $_POST["nombre"]
            ],
                [
                    "id_grados" => $id_grados
                ]);
                if($grados){
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


    function getGrades($id_grados){
        global $db;
        $respuesta = [];
        $grados = $db->get("grados", "*", ["id_grados" => $id_grados]) ;
        $respuesta["nombre"] = $grados["nombre"];
        $respuesta["status"] = 1;
        
 
        echo json_encode($respuesta);
    }
     //okokok
    function deleteGrades($id_grados){
        global $db;
        $respuesta = [];
        $grados = $db -> delete("grados",[
            "id_grados"=> $_POST["grado"]
            ]);
            if($grados){
                $respuesta["status"]=1;
                echo json_encode($respuesta);
            }else{
                $respuesta["status"]=0;
                echo json_encode($respuesta);
            }
    }

?>