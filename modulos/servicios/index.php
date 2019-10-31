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

    <title>Servicios</title>
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
                <h3>Servicios</h3>
                <div class="boton-nuevo" id="btn-new" onClick="newAlert()">
                    <a href="#"><i class="fas fa-clipboard-check" title="Añadir nuevo servicio"></i></a>
                </div>
                <div class="boton-cancelar" id="btn-cancel" onClick="cancelAlert()">
                    <a href="#"><i class="fas fa-times fa-lg" title="Cancelar"></i></a>
                </div>
            </div>
            <div class="info table-responsive-xl">
            <table id="table_servicios" class="table table-striped table-bordered" style="width:100%; height:80%">
            <thead>
              <tr>
                <th>#</th>
                            <th>Servicio</th>
                            <th>Status</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $servicios = $db->select("servicios","*"); 
                        if($servicios)
                        { 
                            $numero = 1;
                            foreach ($servicios as $servicio) 
                            { 
                        ?>
                        <tr>
                            <th scope="row"><?php echo $numero; ?></th>
                            <td><?php echo utf8_encode($servicio['nombre']); ?></td>
                            <td><?php
                                if($servicio['status'] == 1){
                                    echo "Activo"; 
                                }else{
                                    echo "Inactivo";
                                }
                            ?></td>
                            <td>
                                <a href="#" data="<?php echo $servicio['id']?>" class="btn-edit"><i class="fas fa-edit" title="Editar" onClick="newAlert()"></i></a>
                                <a href="#" data="<?php echo $servicio['id']?>" class="btn-delete"><i class="fas fa-trash-alt" title="Eliminar"></i></a>
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
                    <form class="form-register" id="servicio-form">
                        <input type="text" id="nombre" name="nombre" placeholder="Servicio" />
                    
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="status1" name="status">
                            <label class="custom-control-label" for="status1">Inactivo</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="status2" name="status">
                            <label class="custom-control-label" for="status2">Activo</label>
                        </div>

                        <!--
                        <div class="box">
                        <input type="checkbox" name="recordar" id="recordar">
                        <label for="recordar">Recordar credenciales</label>
                        </div>

                        <select id="status" name="status" class="select_opt">
                            <option value="">Seleccione una opción: </option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select> 
                        -->
                        <div class="col-sm-4 mx-auto">
                         <button type="button" id="btn-form">Registrar servicio</button>
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
    <script src="/modulos/servicios/main.js"></script>
</body>

</html>
<?php
	}else{
        header('Location: /modulos/login/index.php/');
    }
?>
