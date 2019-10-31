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
    <link rel ="stylesheet" href="/vendor/datatables/datatables/media/css/jquery.dataTables.min.css" />
    <script src="/vendor/components/jquery/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/js/alert.js"></script>
    <title>Grados</title>
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
          <h3>LOGS</h3>

        </div>
        <div class="info table-responsive-xl">
          <!-- TABLA -->
          <table id="table_id" class="table table-striped table-bordered" style="width:100%; height:80%">
            <thead>
              <tr>
                <th>#</th>
                <th>Mensaje</th>
                <th>Fecha y hora</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $grado = $db->select("logs","*");
                  if($grado){
                      foreach ($grado as $gra => $grados) {
               ?>
              <tr>
                <th scope="row"><?php echo $gra +1; ?></th>
                <td><?php echo utf8_encode($grados['mensaje']); ?></td>
                <td><?php echo utf8_encode($grados['fecha_hora']); ?></td>
                </td>
              </tr>
              <?php
                      }
                  }else{
                    echo "<script>errorAlert()</script>";
                  }
               ?>
            </tbody>
          </table>
          <!-- FIN TABLA -->
          
        </div>
      </div>
    </section>
    <!-- <footer>
      <p><i class="fas fa-user-lock"></i> Sistema desarrollado por La Logia Corp.</p>
    </footer> -->
    <script src="/vendor/fortawesome/font-awesome/js/all.js" data-auto-replace-svg="nest"></script>
    <script src ="/vendor/datatables/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/vendor/components/bootstrap/js/bootstrap.min.js"></script>
    <script src="/modulos/grados/main.js"></script>
  </body>
</html>
<?php
	}else{
		header('Location: /modulos/login/index.php/');
    }
?>