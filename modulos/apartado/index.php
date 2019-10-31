<?php
require_once $_SERVER["DOCUMENT_ROOT"] . 'includes/database.php';
session_start();
error_reporting(0);
$varsesion = $_SESSION['email'];
$nivel = $_SESSION['nivel'];
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
        <link rel="stylesheet" href="/vendor/datatables/datatables/media/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="/vendor/harvesthq/chosen/chosen.css" />
        <link rel="stylesheet" href="/vendor/jonthornton/jquery-timepicker/jquery.timepicker.css">
        <link rel="stylesheet" href="/vendor/components/jqueryui/themes/black-tie/jquery-ui.css" />
        <script src="/vendor/components/jquery/jquery.min.js"></script>
        <script src="/vendor/components/jqueryui/jquery-ui.min.js"></script>
        <script src="/vendor/harvesthq/chosen/chosen.jquery.js"></script>
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
                    <?php
                        if ($nivel == 1) { } else {
                            ?>
                        <div class="boton-nuevo" id="btn-new" onClick="newAlert()">
                            <a href="#"><i class="fas fa-calendar fa-lg" title="Apartar cañon"></i></a>
                        </div>
                        <div class="boton-cancelar" id="btn-cancel" onClick="cancelAlert()">
                            <a href="#"><i class="fas fa-times fa-lg" title="Cancelar"></i></a>
                        </div>
                    <?php
                        }
                        ?>
                </div>
                <div class="info">
                    <table id="table_apartado" class="table table-striped table-bordered" style="width:100%; height:80%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Usuario</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Final</th>
                                <th>Hora Inicio</th>
                                <th>Hora Final</th>
                                <th>servicios</th>
                                <th>cañon</th>
                                <th>salon</th>
                                <th>comentarios</th>
                                <th>accesorios</th>
                                <th>status</th>
                                <?php
                                    if ($nivel == 1) { } else {
                                        ?>
                                    <th>Acciones</th>
                                <?php
                                    }
                                    ?>
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
                                        <?php
                                                    if ($nivel == 1) { } else {
                                                        ?>
                                            <td>
                                                <a href="#" data="<?php echo $reserva['id_apartado'] ?>" class="btn-edit"><i class="fas fa-edit" title="Editar" onClick="newAlert()"></i></a>
                                                <a href="#" data="<?php echo $reserva['id_apartado'] ?>" class="btn-delete"><i class="fas fa-trash-alt" title="Eliminar"></i></a>
                                            </td>
                                        <?php
                                                    }
                                                    ?>
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
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-4 formulario_registro">
                                        <label for="usuario">Usuario</label>
                                        <select name="usuario" id="usuario" class="select_opt chosen-select">
                                            <option value="">Selecciona un usuario...</option>
                                                <?php 
                                                try {
                                                $items = $db->select("usuarios", "*", ["status_usr" => "1"]);
                                                    foreach ($items as $item) {
                                                        echo "<option value='$item[id_usr]'>$item[nombre_usr]</option>";
                                                    }
                                                } catch (Exception $e) {echo "<script>errorAlert()</script>";}
                                                ?>
                                        </select>
                                        <label for="dia_inicio">Día de Reservación</label>
                                        <input type="text" name="dia_inicio" id="dia_inicio">
                                        <label for="hora_inicio">Hora</label>
                                        <input id="hora_inicio" name="hora_inicio" type="text" class="time ui-timepicker-input" autocomplete="off">

                                        <label for="servicio">Servicio</label>
                                        <select name="servicio" id="servicio" class="select_opt chosen-select">
                                            <option value="">Selecciona un servicio...</option>
                                            <?php 
                                                try {
                                                $items = $db->select("servicios", "*", ["status" => "1"]);
                                                    foreach ($items as $item) {
                                                        echo "<option value='$item[id]'>$item[nombre]</option>";
                                                    }
                                                } catch (Exception $e) {echo "<script>errorAlert()</script>";}
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 formulario_registro">
                                        <label for="Salon">Salon</label>
                                        <select name="salon" id="salon" class="select_opt chosen-select">
                                            <option value="">Selecciona un salon...</option>
                                            <?php 
                                                try {
                                                $items = $db->select("salones", "*", ["status" => "1"]);
                                                    foreach ($items as $item) {
                                                        echo "<option value='$item[id_grados]'>$item[nombre]</option>";
                                                    }
                                                } catch (Exception $e) {echo "<script>errorAlert()</script>";}
                                            ?>
                                        </select>
                                        <label for="canon">Cañon</label>
                                        <select name="canon" id="canon" class="select_opt  chosen-select">
                                            <option value="">Selecciona un cañon...</option>
                                            <?php 
                                            try {
                                            $items = $db->select("canones", "*", ["status_can" => "1"]);
                                                foreach ($items as $item) {
                                                    echo "<option value='$item[id_can]'>$item[nombre_can]</option>";
                                                }
                                            } catch (Exception $e) {echo "<script>errorAlert()</script>";}
                                            ?>
                                        </select>
                                        <label for="comentarios">comentarios</label>
                                        <input type="text" name="comentarios" id="comentarios">
                                        <label for="accesorios">Accesorios</label>
                                        <input type="text" name="accesorios" id="accesorios">
                                    </div>

                                    <div class="col-sm-4 table-responsive">
                                        <table class="table table-striped" id="tabla_interna">
                                            <thead>
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                    <th>Servicio</th>
                                                    <th>Salon</th>
                                                    <th>Cañon</th>
                                                    <th>Comentarios</th>
                                                    <th>Accesorios</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    </div>
                                    <div class="row mt-3">
                                    <div class="col-sm-4">
                                        <button type="button" id="btn-interno" class="btn-agregar">Agregar</button>
                                    </div>
                                    <div class="col-sm-4 ml-auto">
                                        <button type="button" class="btn-cancelar">Cancelar</button>
                                    </div>
                                </div>
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
        <script src="/vendor/jonthornton/jquery-timepicker/jquery.timepicker.js"></script>
        <script src="/vendor/fortawesome/font-awesome/js/all.js" data-auto-replace-svg="nest"></script>
        <script src="/vendor/datatables/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="/vendor/components/bootstrap/js/bootstrap.min.js"></script>
        <script src="/modulos/apartado/main.js"></script>
    </body>

    </html>
<?php
} else {
    header('Location: /modulos/login/index.php/');
}
?>