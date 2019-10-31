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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="/css/estilo.css" />
    <link rel="stylesheet" href="/vendor/components/bootstrap/css/bootstrap.min.css" />
    <link rel ="stylesheet" href="/vendor/datatables/datatables/media/css/jquery.dataTables.min.css"/>
    <script src="/vendor/components/jquery/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/js/alert.js"></script>
    <title>Salones</title>
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
                <h3>Salones</h3>
                <div class="boton-nuevo" id="btn-new" onClick="newAlert()">
                    <a href="#"><i class="fas fa-eye fa-lg" title="Añadir nuevo Salon"></i></a>
                </div>
                <div class="boton-cancelar"  id="btn-cancel" onClick="cancelAlert()">
                    <a href="#"><i class="fas fa-times fa-lg" title="Cancelar"></i></a>
                </div>
            </div>
            <div class="info">
            <table id="table_salones" class="table table-striped table-bordered" style="width:100%; height:80%">
                    <thead class="thead-dark">
                        <tr>
                          <th>No.</th>
                          <th>Salon</th>
                          <th>Grado</th>
                          <th>Tiene_Cañon</th>
                          <th>Status</th>
                          <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $salones = $db->select("salones","*");
                        if($salones)
                        {
                            foreach ($salones as $sal => $salon)
                            {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $sal+1; ?></th>
                                <td><?php echo utf8_encode($salon['nombre']); ?></td>
                                <td><?php 
                                    global $db;
                                    $grados = $db->get("grados", "*", ["id_grados" => $salon['id_grados']]);
                                    $respuesta["nombre"] = $grados["nombre"];
                                    echo $respuesta["nombre"]; ?></td>
                                <td><?php 
                                      if ($salon['tiene_canon'] == 1) {
                                           echo "Si"; 
                                      }else{
                                          echo "No";
                                          }?>
                                </td>
                                <td><?php 
                                  if($salon['status'] == 1){
                                    echo "Activo"; 
                                  }else{
                                    echo "Inactivo";
                                  }?>
                            </td>
                            <td>
                                <a href="#" data="<?php echo $salon['id_salones']; ?>" class="btn-edit"><i class="fas fa-edit" title="Editar" onClick="newAlert()"></i></a>
                                <a href="#" data="<?php echo $salon['id_salones']; ?>" class="btn-delete"><i class="fas fa-trash-alt" title="Eliminar"></i></a>
                            </td>
                        <?php
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
                    <form class="form-register" id="user-form">
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre" />
                        
                        
                        <select id="id_grados" name="id_grados" class="select_opt">
			                    	<option value="">Selecciona un Grado</option>
                              <?php 
                                 $grados = $db->select("grados", ["id_grados", "nombre"], ["status" => "1"]);
                              foreach ($grados as $grado) { 
                                ?>
                                <option value="<?php echo $grado['id_grados'];?>"> <?php echo $grado['nombre'];?></option>
					                  	<?php
				                      	}	?>
			                  </select>           
                        </select>
                        <select id="tiene_canon" name="tiene_canon" class="select_opt">
                            <option value="">Seleccione, tiene Salon : </option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>

                        <select id="status" name="status" class="select_opt">
                            <option value="">Seleccione el Estatus: </option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        <button type="button" id="btn-form">Registrar nivel <i class="fas fa-level-up-alt fa-sm"></i></button>
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
    <script src ="/vendor/datatables/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/modulos/salones/main.js"></script>
</body>

</html>
<?php
  }else{
        header('Location: /modulos/login/index.php/');
    }
?>
