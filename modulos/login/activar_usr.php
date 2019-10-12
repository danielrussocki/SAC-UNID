<?php 
    require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';

    global $db;

    if (isset($_GET['id'])) {
        $id_usr = $_GET['id'];

        $update = $db->update("usuarios", [
            "status_usr" => 1
        ], [
            "id_usr" => $id_usr
        ]);

        if ($update) {
            header("Location: activado.html");
        }else{
            echo "No se pudo activar tu cuenta";
        }
    }
?>