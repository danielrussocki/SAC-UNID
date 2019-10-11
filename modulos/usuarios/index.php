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
    <link rel ="stlylesshet" hreff="/vendor/datatables/datatables/media/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="/vendor/components/bootstrap/css/bootstrap.min.css" />
    <script src="/vendor/components/jquery/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/js/alert.js"></script>
    <script src ="/vendor/datatables/datatables/media/js/jquery.dataTables.min.js"></script>

    <title>Usuarios</title>
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
          <h3>Usuarios</h3>
          <div class="boton-nuevo" id="btn-new" onClick="newAlert()">
            <a href="#"><i class="fas fa-user-plus fa-lg" title="Añadir nuevo usuario"></i></a>
          </div>
          <div class="boton-cancelar" onClick="cancelAlert()">
            <a href="#"><i class="fas fa-times fa-lg" title="Cancelar"></i></a>
          </div>
        </div>
        <div class="info">
          <!-- TABLA -->
          <table id="table_id" class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Matricula</th>
                <th scope="col">Nombre</th>
                <th scope="col">Telefono</th>
                <th scope="col">Email</th>
                <th scope="col">Nivel</th>
                <th scope="col">Status</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $usuarios = $db->select("usuarios","*");
                  if($usuarios){
                      foreach ($usuarios as $usuario) {
               ?>
              <tr>
                <th scope="row"><?php echo $usuario['id_usr']; ?></th>
                <td ><?php echo $usuario['matricula_usr']; ?></td>
                <td><?php echo utf8_encode($usuario['nombre_usr']); ?></td>
                <td><?php echo $usuario['telefono_usr']; ?></td>
                <td><?php echo $usuario['email_usr']; ?></td>
                <td><?php echo $usuario['nivel_usr']; ?></td>
                <td><?php echo $usuario['status_usr']; ?></td>
                <td>
                  <a href="#" data="<?php echo $usuario['id_usr']?>" class="btn-edit"><i class="fas fa-edit" title="Editar" onClick="newAlert()"></i></a> 
                  <a href="#" data="<?php echo $usuario['id_usr']?>" class="btn-delete"><i class="fas fa-trash-alt" title="Eliminar"></i></a>
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
          <!-- FORMULARIO -->
          <div class="form">
            <form class="form-register" id="user-form">
              <input type="text" id="matricula" name="matricula" placeholder="Matricula" />
              <input type="text" id="nombre" name="nombre" placeholder="Nombre" />
              <input type="text" id="telefono" name="telefono" placeholder="Telefono" />
              <input type="text" id="email" name="email" placeholder="Email" />
              <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" />
              <input type="hidden" id="status" name="status" value="1" name="status_usr" />
              <button type="button" id="btn-form"></button>
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
    <script src="/vendor/components/bootstrap/js/bootstrap.min.js"></script>
    <script src="/modulos/usuarios/main.js"></script>
  </body>
</html>
<?php
	}else{
		header('Location: /modulos/login/index.php/');
    }
?>