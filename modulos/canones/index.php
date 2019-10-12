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
    <title>Cañones</title>
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
          <h3>Cañones</h3>
          <div class="boton-nuevo" id="btn-new" onClick="newAlert()">
            <a href="#"><i class="fas fa-eye fa-lg" title="Añadir nuevo cañon"></i></a>
          </div>
          <div class="boton-cancelar" onClick="cancelAlert()">
            <a href="#"><i class="fas fa-times fa-lg" title="Cancelar"></i></a>
          </div>
        </div>
        <div class="info">
        <!-- TABLA -->
        <table id="table_id" class="table table-striped table-bordered" style="width:100%; height:80%">
            <thead>
              <tr>
                <th>#</th>
                <th >Nombre</th>
                <th >Status</th>
                <th >Entrada</th>
                <th >Control</th>
                <th >Num. Serie</th>
                <th >Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                        $canones = $db->select("canones","*");
                        if($canones)
                        {
                            $numero = 1;
                            foreach ($canones as $canon)
                            {
              ?>
              <tr>
                <th scope="row"><?php echo  $numero; ?></th>
                <td><?php echo utf8_encode($canon['nombre_can']); ?></td>
                <td><?php
                    if($canon['status_can'] == 1){
                        echo "Activo"; 
                    }else{
                        echo "Inactivo";
                    }
                ?></td> 
                <td><?php echo $canon['entrada_can']; ?></td>
                <td><?php echo $canon['control_can']; ?></td>
                <td><?php echo $canon['serie_can']; ?></td>
                <td>
                  <a href="#" data="<?php echo $canon['id_can']; ?>" class="btn-edit"><i class="fas fa-edit" title="Editar" onClick="newAlert()"></i></a>
                  <a href="#" data="<?php echo $canon['id_can']; ?>" class="btn-delete"><i class="fas fa-trash-alt" title="Eliminar"></i></a>
                </td>
                <?php
                 $numero = $numero + 1;
                            }
                        }else{
                            echo "<script>errorAlert()</script>";
                        }
                ?>
              </tr>
            </tbody>
          </table>
          <!-- FORMULARIO -->
          <div class="form">
            <form class="form-register" id="canon-form">
              <input type="text" name="nombre" id="nombre" placeholder="Nombre" />
              <input type="text" name="status" id="status" placeholder="Status" />
              <input type="text" name="entrada" id="entrada" placeholder="Entrada" />
              <input type="text" name="control" id="control" placeholder="Control" />
              <input type="text" name="serie" id="serie" placeholder="N. serie" />
              <button type="button" id="btn-form">Registrar cañon <i class="fas fa-eye fa-sm"></i></button>
            </form>
          </div>
          <!-- FIN FORMULARIO -->
        </div>
      </div>
    </section>
    <footer>
      <p><i class="fas fa-user-lock"></i> Sistema desarrollado por La Logia Corp.</p>
    </footer>
    <script src="/vendor/fortawesome/font-awesome/js/all.js" data-auto-replace-svg="nest"></script>
    <script src ="/vendor/datatables/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/vendor/components/bootstrap/js/bootstrap.min.js"></script>
    <script src="/modulos/canones/main.js"></script>
  </body>
</html>
<?php
	}else{
        header('Location: /modulos/login/index.php/');
    }
?>
