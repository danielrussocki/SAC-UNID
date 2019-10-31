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
          <div class="boton-cancelar" id="btn-cancel" onClick="cancelAlert()">
            <a href="#"><i class="fas fa-times fa-lg" title="Cancelar"></i></a>
          </div>
        </div>
        <div class="info table-responsive-xl">
          <table id="table_lel" class="table table-striped table-bordered" style="width:100%; height:80%">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Status</th>
                <th>Entrada</th>
                <th>Control</th>
                <th>Num. Serie</th>
                <th>Acciones</th>
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
                <td>
                  <?php
                  $entShow = $db->get('entradas','nombre',['id'=>$canon['id_entrada']]);
                  if($entShow){
                    echo $entShow;
                  }
                  ?>
                </td>
                <td>
                  <?php
                    if($canon['control_can'] == 1){
                      echo "Tiene control";
                    } else {
                      echo "No tiene control";
                    }
                  ?>
                </td>
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
          <style>
              #control, #sts{
                margin-bottom: 12px;
              }
              #control span, #sts span{
                font-size:14px;
              }
              #control input, #sts input{
                width: auto;
                margin:0 6px;
                cursor: pointer;
              }
              .radio-container{
                display: flex;
                justify-content:flex-start;
                align-items:center;
              }
              .radio-container span{
                margin-left: 6px;
              }
              </style>
          <div class="form">
            <form class="form-register" id="canon-form">
              <input type="text" name="nombre" id="nombre" placeholder="Nombre" />
              <!-- <input type="text" name="status" id="status" placeholder="Status" /> -->
              <div id="sts">
                <div class="radio-container">
                  <input type="radio" name="status" id="stsOne" value="1" checked="checked">
                  <span>Activo</span>
                </div>
                <div class="radio-container">
                  <input type="radio" name="status" id="stsTwo" value="0">
                  <span>Inactivo</span>
                </div>
              </div>
              <!-- <input type="text" name="entrada" id="entrada" placeholder="Entrada" /> -->
              <select name="entrada" id="entrada" class="select_opt">
                        <option value="">Seleccione una entrada</option>
                        <?php
                          $ents = $db->select('entradas', '*', ['status'=>1]);
                          if($ents){
                            foreach($ents as $eeee){
                              ?>
                              <option value="<?php echo $eeee['id']; ?>"><?php echo $eeee['nombre']; ?></option>
                              <?php
                            }
                          } else {
                            echo "<script>errorAlert()</script>";
                          }
                        ?>
              </select>
              <!-- <input type="text" name="control" id="control" placeholder="Control" /> -->
              <div id="control">
                <div class="radio-container">
                  <input type="radio" name="control" id="controlOne" value="1" checked="checked">
                  <span>Tiene control</span>
                </div>
                <div class="radio-container">
                  <input type="radio" name="control" id="controlTwo" value="0">
                  <span>No tiene control</span>
                </div>
              </div>
              <input type="text" name="serie" id="serie" placeholder="N. serie" />
              <div class="row mt-3">
              <div class="col-sm-4 mx-auto">
              <button type="button" id="btn-form">Registrar cañon <i class="fas fa-eye fa-sm"></i></button>
              </div>
              </div>
            </form>
          </div>
          <!-- FIN FORMULARIO -->
        </div>
      </div>
    </section>
    <!-- <footer>
      <p><i class="fas fa-user-lock"></i> Sistema desarrollado por La Logia Corp.</p>
    </footer> -->
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
