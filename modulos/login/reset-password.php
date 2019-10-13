<!DOCTYPE html>
<html lang="mx">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="/css/estilo_login.css" />
    <title>Restaurar contraseña</title>
  </head>
  <body>
    <section id="pwd">
      <div class="form">
      <div class="reset-page">
        <h1>Restaurar contraseña</h1>
            <?php
                if (isset($_GET["reset"])) {
                    if($_GET["reset"] == "success"){
                        echo '<strong><p>El enlace para restaurar la contraseña ha sido enviado</p></strong>
                        <p class="signupsuccess"> ¡Revisa tu correo!</p>
                        <a href="/modulos/login/index.php">Volver al Login</a>';
                    }
                }
                else{
                  echo '<p>Recibiras un correo con las instrucciones para cambiar tu contraseña</p>
                  <form action="/modulos/login/send-password.php" method="post">
                  <input type="text" name="email" placeholder="Escribe tu correo">
                  <button type="submit" name="reset-request-submit">Recibir nueva contraseña por correo</button>
                  </form>';
                }
            ?>
    </div>
      </div>
    </section>
    <script src="/vendor/components/jquery/jquery.min.js"></script>
    <script src="/vendor/components/jquery-cookie/jquery.cookie.js"></script>
    <script
      src="/vendor/fortawesome/font-awesome/js/all.js"
      data-auto-replace-svg="nest"
    ></script>
  </body>
</html>
