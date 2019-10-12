<?php 
    $nivel = $_SESSION['nivel'];
    echo $nivel;

    if ($nivel == 1) {
?>
<aside class="sidebar">
    <ul>
        <li><a href='/modulos/apartado/index.php/'><i class="fas fa-calendar"></i> Apartado</a></li>
    </ul>
</aside>
<?php
    }elseif ($nivel == 2) {
?>
<aside class="sidebar">
    <ul>
        <li><a href='/modulos/apartado/index.php/'><i class="fas fa-calendar"></i> Apartado</a></li>
    </ul>
</aside>
<?php
    }elseif ($nivel == 3) {
?>
<aside class="sidebar">
    <ul>
        <li><a href='/modulos/usuarios/index.php/'><i class="fas fa-users"></i> Usuarios</a></li>
    </ul>
    <ul>
        <li><a href='/modulos/canones/index.php/'><i class="fas fa-eye"></i> Cañones</a></li>
    </ul>
    <ul>
        <li><a href='/modulos/entradas/index.php/'><i class="fas fa-plug"></i> Entradas</a></li>
    </ul>
    <ul>
        <li><a href='/modulos/niveles/index.php/'><i class="fas fa-level-up-alt"></i> Niveles</a></li>
    </ul>
    <ul>
        <li><a href='/modulos/servicios/index.php/'><i class="fas fa-clipboard-check"></i> Servicios</a></li>
    </ul>
    <ul>
        <li><a href='/modulos/apartado/index.php/'><i class="fas fa-calendar"></i> Apartado</a></li>
    </ul>
    <ul>
        <li><a href='/modulos/grados/index.php/'><i class="fas fa-book-reader"></i> Grados</a></li>
    </ul>
    <ul>
        <li><a href='/modulos/salones/index.php/'><i class="fas fa-archway"></i> Salones</a></li>
    </ul>
    <ul>
        <li><a href='/modulos/logs/index.php/'><i></i> Logs</a></li>
    </ul>
</aside>
<?php        
    }
?>