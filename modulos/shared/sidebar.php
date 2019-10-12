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
        <li>
            <a href='/modulos/usuarios/index.php/'><span class="icon-container"><i class="fas fa-users"></i></span><p class="sidebar-text"> Usuarios</p></a>
        </li>
        <li>
            <a href='/modulos/canones/index.php/'><span class="icon-container"><i class="fas fa-eye"></i></span><p class="sidebar-text"> Cañones</p></a>
        </li>
        <li>
            <a href='/modulos/entradas/index.php/'><span class="icon-container"><i class="fas fa-plug"></i></span><p class="sidebar-text"> Entradas</p></a>
        </li>
        <li>
            <a href='/modulos/niveles/index.php/'><span class="icon-container"><i class="fas fa-level-up-alt"></i></span><p class="sidebar-text"> Niveles</p></a>
        </li>
        <li>
            <a href='/modulos/servicios/index.php/'><span class="icon-container"><i class="fas fa-clipboard-check"></i></span><p class="sidebar-text"> Servicios</p></a>
        </li>
        <li>
            <a href='/modulos/apartado/index.php/'><span class="icon-container"><i class="fas fa-calendar"></i></span><p class="sidebar-text"> Apartado</p></a>
        </li>
        <li>
            <a href='/modulos/grados/index.php/'><span><i class="fas fa-book-reader"></i></span><p class="sidebar-text"> Grados</p></a>
        </li>
        <li>
            <a href='/modulos/salones/index.php/'><span><i class="fas fa-archway"></i></span><p class="sidebar-text"> Salones</p></a>
        </li>
        <li>
            <a href='/modulos/logs/index.php/'><span><i class="fas fa-door-open"></i></span><p class="sidebar-text"> Logs</p></a>
        </li>
    </ul>
</aside>
<?php        
    }
?>