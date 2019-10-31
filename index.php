<?php
  require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
	session_start();
	error_reporting(0);
	$varsesion = $_SESSION['email'];
	if (isset($varsesion)){
?>
<!DOCTYPE html>
<html lang="mx">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="/css/estilo.css" />
    <link rel="stylesheet" href="/vendor/components/bootstrap/css/bootstrap.min.css" />
    <script src="/vendor/components/jquery/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/js/alert.js"></script>
    <title>Sistema de Apartado de Cañones</title>
  </head>
  <body>
    <?php
        Include_once $_SERVER["DOCUMENT_ROOT"].'modulos/shared/navbar.php';
    ?>
    <section class="wrapper">
      <?php
        Include_once $_SERVER["DOCUMENT_ROOT"].'modulos/shared/sidebar.php';
      ?>
      <div class="contenedor-principal">
        <div class="header">
          <h3>Home</h3>
        </div>
        <div class="info">
          <p>Sistema para administrar el apartado de cañones</p>
        </div>
      </div>
    </section>
    <!-- <footer>
      <p><i class="fas fa-user-lock"></i> Sistema desarrollado por La Logia Corp.</p>
    </footer> -->
    <script src="/vendor/fortawesome/font-awesome/js/all.js" data-auto-replace-svg="nest"></script>
    <script src="/vendor/components/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/main.js"></script>
  </body>
</html>
<?php
	}else{
		header('Location: /modulos/login/index.php/');
    }
?>
