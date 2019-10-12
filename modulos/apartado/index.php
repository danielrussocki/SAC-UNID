<?php
require_once $_SERVER["DOCUMENT_ROOT"] . 'includes/database.php';
session_start();
error_reporting(0);
$varsesion = $_SESSION['email'];
if (isset($varsesion)) {
    ?>
    <!DOCTYPE html>
    <html lang="mx">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" href="/css/estilo.css" />
        <link rel="stylesheet" href="/vendor/components/bootstrap/css/bootstrap.min.css" />     
        <link rel ="stylesheet" href="/vendor/datatables/datatables/media/css/jquery.dataTables.min.css" />       
        <script src="/vendor/components/jquery/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="/js/alert.js"></script>
        <title>Apartado</title>
    </head>

    <body>
        <?php
            include_once $_SERVER["DOCUMENT_ROOT"] . 'modulos/shared/navbar.php';
            ?>
        <section class="wrapper">
            <?php
                include_once $_SERVER["DOCUMENT_ROOT"] . 'modulos/shared/sidebar.php';
                ?>
            <div class="contenedor-principal">
                <div class="header">
                    <h3>Apartado</h3>
                    <div class="boton-nuevo" id="btn-new" onClick="newAlert()">
                        <a href="#"><i class="fas fa-calendar fa-lg" title="Apartar cañon"></i></a>
                    </div>
                    <div class="boton-cancelar" onClick="cancelAlert()">
                        <a href="#"><i class="fas fa-times fa-lg" title="Cancelar"></i></a>
                    </div>
                </div>
                <div class="info">

<table id="table_id" class="table table-striped table-bordered" style="width:100%; height:80%">
            <thead>
                            <tr>
                            
                                <th >Usuario</th>
                                <th >Fecha Inicio</th>
                                <th >Fecha Final</th>
                                <th>Hora Inicio</th>
                                <th>Hora Final</th>
                                <th>servicios</th>
                                <th>cañon</th>
                                <th>salon</th>
                                <th>comentarios</th>
                                <th>accesorios</th>
                                <th>status</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $reservas = $db->select("reservas", [
                                    "[>]usuarios" => [
                                        "usr_id" => "id_usr"
                                    ],
                                    "[>]servicios" => [
                                        "servicios_id" => "id"
                                    ],
                                    "[>]canones" => [
                                        "canon_id" => "id_can"
                                    ],
                                    "[>]salones" => [
                                        "salon_id" => "id_salones"
                                    ]
                                ], [
                                    "reservas.id_apartado",
                                    "reservas.usr_id",
                                    "reservas.fecha_inicio",
                                    "reservas.fecha_fin",
                                    "reservas.hora_inicio",
                                    "reservas.hora_fin",
                                    "reservas.servicios_id",
                                    "reservas.canon_id",
                                    "reservas.salon_id",
                                    "reservas.comentarios",
                                    "reservas.accesorios",
                                    "reservas.status",
                                    "usuarios.id_usr",
                                    "usuarios.nombre_usr",
                                    "servicios.id",
                                    "servicios.nombre",
                                    "canones.id_can",
                                    "canones.nombre_can",
                                    "salones.id_salones",
                                    "salones.nombre(nombre_salon)"
                                ]);
                                /* var_dump( $db->error() ); 
                                 var_dump( $db->log() );  */

                                if ($reservas) {
                                    foreach ($reservas as $reserva) {
                                        ?>
                                    <tr>
                                        <td><?php echo $reserva['nombre_usr']; ?></td>
                                        <td><?php echo $reserva['fecha_inicio']; ?></td>
                                        <td><?php echo $reserva['fecha_fin']; ?></td>
                                        <td><?php echo $reserva['hora_inicio']; ?></td>
                                        <td><?php echo $reserva['hora_fin']; ?></td>
                                        <td><?php echo $reserva['nombre']; ?></td>
                                        <td><?php echo $reserva['nombre_can']; ?></td>
                                        <td><?php echo $reserva['nombre_salon']; ?></td>
                                        <td><?php echo utf8_encode($reserva['comentarios']); ?></td>
                                        <td><?php echo utf8_encode($reserva['accesorios']); ?></td>
                                        <td><?php echo $reserva['status']; ?></td>
                                        <td>
                                            <a href="#" data="<?php echo $reserva['id_apartado'] ?>" class="btn-edit"><i class="fas fa-edit" title="Editar" onClick="newAlert()"></i></a>
                                            <a href="#" data="<?php echo $reserva['id_apartado'] ?>" class="btn-delete"><i class="fas fa-trash-alt" title="Eliminar"></i></a>
                                        </td>
                                <?php
                                        }
                                    } else {
                                        echo "<script>errorAlert()</script>";
                                    }
                                    ?>
                                    </tr>
                        </tbody>
                    </table>
                    <!-- FORMULARIO -->
                    <div class="form">
                        <form class="form-register" id="apartado-form">
                            <div class="row">
                                <div class="col">
                                    <select id="usuario" name="usuario" class="select_opt">
                                        <option value="">Usuario</option>
                                        <?php
                                            $usuarios = $db->select("usuarios", "*");
                                            if ($usuarios) {
                                                foreach ($usuarios as $usuario) {
                                                    echo "<option value='$usuario[id_usr]'>$usuario[nombre_usr]</option>";
                                                }
                                            } else {
                                                echo "<script>errorAlert()</script>";
                                            }

                                            ?>
                                    </select>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio">
                                    <input type="date" name="fecha_fin" id="fecha_fin">
                                    <input type="time" name="hora_inicio" id="hora_inicio">
                                </div>
                                <div class="col">
                                    <input type="time" name="hora_fin" id="hora_fin">
                                    <select id="servicio" name="servicio" class="select_opt">
                                        <option value="">Servicio</option>
                                        <?php
                                            $servicios = $db->select("servicios", "*");
                                            if ($servicios) {
                                                foreach ($servicios as $servicio) {
                                                    echo "<option value='$servicio[id]'>$servicio[nombre]</option>";
                                                }
                                            } else {
                                                echo "<script>errorAlert()</script>";
                                            }

                                            ?>
                                    </select>
                                    <select id="canon" name="canon" class="select_opt">
                                        <option value="">Cañon</option>
                                        <?php
                                            $canones = $db->select("canones", "*");
                                            if ($canones) {
                                                foreach ($canones as $canon) {
                                                    echo "<option value='$canon[id_can]'>$canon[nombre_can]</option>";
                                                }
                                            } else {
                                                echo "<script>errorAlert()</script>";
                                            }

                                            ?>
                                    </select>
                                    <select id="salon" name="salon" class="select_opt">
                                        <option value="">salon</option>
                                        <?php
                                            $salones = $db->select("salones", "*");
                                            if ($salones) {
                                                foreach ($salones as $salon) {
                                                    echo "<option value='$salon[id_salones]'>$salon[nombre]</option>";
                                                }
                                            } else {
                                                echo "<script>errorAlert()</script>";
                                            }

                                            ?>
                                    </select>
                                </div>
                                <input type="text" name="comentario" id="comentario" placeholder="Comentario">
                                <input type="text" name="accesorio" id="accesorio" placeholder="Accesorios">
                                <select id="status" name="status" class="select_opt">
                                    <option value="">Status</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                <button type="button" id="btn-form">Apartar cañon <i class="fas fa-level-up-alt fa-sm"></i></button>
                            </div>
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
        <script src="/modulos/apartado/main.js"></script>
    </body>

    </html>
<?php
} else {
    header('Location: /modulos/login/index.php/');
}
?>