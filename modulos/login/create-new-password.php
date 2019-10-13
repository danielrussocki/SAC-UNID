<!DOCTYPE html>
<html lang="mx">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="/css/estilo_login.css" />
    <title>Crear nueva contraseña</title>
  </head>
  <body>
    <div class="newPwd-page">
    <div class="form">
        <?php
        require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
        require $_SERVER["DOCUMENT_ROOT"] . 'vendor/autoload.php';

        if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"])){
            $key = $_GET["key"];
            $email = $_GET["email"];
            $curDate = date("Y-m-d H:i:s");
            $error="";
            $row = $db->count("password_reset_temp",
            [
              "key" => $key,
              "email" => $email
            ]);

            if ($row == ""){
              header('HTTP/1.0 403 Forbidden');
              $error = '<h2>Link Invalido</h2>
              <p>El link es invalido o expirado.</p>
              <p><a href="/modulos/login/reset-password.php">
              Haz clic aquí</a> para reiniciar tu contraseña</p>';
             }
             else{
              $row = $db->get("password_reset_temp", "*",
              [
                "key" => $key,
                "email" => $email
              ]);
              $expDate = $row['expDate'];
              if ($expDate >= $curDate){
                echo'
                <form action="/modulos/login/create-new-password.php" method="post">
                  <label><strong>Nueva Contraseña:</strong></label><br/><br/>
                  <input type="password" name="pwd" placeholder="Escribe tu nueva contraseña" required>
                  <input type="password" name="pwd-repeat" placeholder="Confirma tu nueva contraseña" required>
                  <input type="hidden" name="email" value='.$email.'>
                  <button type="submit" name="action" value = "update">Resetear Contraseña</button>
                </form>';
          }
          else{
            header('HTTP/1.0 403 Forbidden');
            $error='<h2>Link Expirado</h2>
            <p>El link ha expirado.</p>
            <p><a href="/modulos/login/reset-password.php">
            Haz clic aquí</a> para reiniciar tu contraseña</p>';
                        }
                  }
        }
        else{
          header('HTTP/1.0 403 Forbidden');
          $error = '<h2>Link Invalido</h2>
          <p>El link es invalido o expirado.</p>
          <p><a href="/modulos/login/reset-password.php">
          Haz clic aquí</a> para reiniciar tu contraseña</p>';
        } 

        if((isset($_POST["email"]) && isset($_POST["action"]) &&  isset($_POST["pwd"]) && isset($_POST["pwd-repeat"])) &&
           ($_POST["action"]=="update")){
               $respuesta = [];
               $error = "";
               $email = $_POST["email"];
               $pwd = $_POST["pwd"];
               $pwd2 = $_POST["pwd-repeat"];
               $curDate = date("Y-m-d H:i:s");
               $form =  '<form action="/modulos/login/create-new-password.php" method="post">
                 <label><strong>Nueva Contraseña:</strong></label><br/><br/>
                 <input type="password" name="pwd" placeholder="Escribe tu nueva contraseña" required>
                 <input type="password" name="pwd-repeat" placeholder="Confirma tu nueva contraseña" required>
                 <input type="hidden" name="email" value='.$email.'>
                 <button type="submit" name="action" value = "update">Resetear Contraseña</button>
               </form>';

               $row = $db->count(
                   "password_reset_temp",
                   [
                 "email" => $email
               ]
               );

               if (empty($pwd) || empty($pwd2)) {
                   echo $form.'<br><p style="color:red">Campos vacíos</p>';
               } else {
                   if ($pwd != $pwd2) {
                       echo $form.'<br><p style="color:red">Las contraseñas no coinciden</p>';
                   } else {
                       if ($row == 1) {
                           $db->update(
                               "usuarios",
                               [
                          "password_usr" => $pwd
                          ],
                               [
                          "email_usr" => $email
                          ]
                           );

                           $db->delete(
                              "password_reset_temp",
                              [
                          "email"=> $email
                          ]
                          );
           
                           echo '<div class="error"><p>Felicidades! Tu contraseña se ha actualizado</p>
                          <p><a href="/modulos/login/index.php">
                          Inicia sesión</a></p></div><br />';
                       } else {
                          $error = '<h2>Link Invalido</h2>
                          <p>El link es invalido o expirado.</p>
                          <p><a href="/modulos/login/reset-password.php">
                          Haz clic aquí</a> para reiniciar tu contraseña</p>';
                           header('HTTP/1.0 403 Forbidden');
                       }
                   }
               }
           }
            header('HTTP/1.0 403 Forbidden');

        if($error!=""){
             echo "<div class='error'>".$error."</div><br />";
        }     
        ?> 
        </div>    
    </div>
    <script src="/vendor/components/jquery/jquery.min.js"></script>
    <script src="/vendor/components/jquery-cookie/jquery.cookie.js"></script>
    <script
      src="/vendor/fortawesome/font-awesome/js/all.js"
      data-auto-replace-svg="nest"
    ></script>
  </body>
</html>