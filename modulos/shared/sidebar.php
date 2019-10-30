<?php 
    $nivel = $_SESSION['nivel'];
    echo $nivel;

    if ($nivel == 1) {
?>
<aside class="sidebar">
    <ul>
        <li>
            <a href='/modulos/apartado/index.php/'><i class="fas fa-calendar"></i><p class="sidebar-text">Apartado</p></a>
        </li>
    </ul>
</aside>
<?php
    }elseif ($nivel == 2) {
?>
<aside class="sidebar">
    <ul>
        <li>
            <a href='/modulos/apartado/index.php/'><i class="fas fa-calendar"></i><p class="sidebar-text">Apartado</p></a>
        </li>
    </ul>
</aside>
<?php
    }elseif ($nivel == 3) {
?>
<aside class="sidebar">
    <ul>
        <li>
            <a href='/modulos/apartado/index.php/'><i class="fas fa-calendar"></i><p class="sidebar-text">Apartado</p></a>
        </li>
        <li>
            <a href="#canonSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-eye"></i><p class="sidebar-text">Cañones</p></a>
            <ul class="collapse list-unstyled" id="canonSubmenu">
                <li>
                    <a href="/modulos/canones/index.php/"><i class="fas fa-eye"></i><p class="sidebar-text">Cañones</p></a>
                </li>
                <li>
                    <a href="/modulos/entradas/index.php/"><i class="fas fa-plug"></i><p class="sidebar-text">Entradas</p></a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user"></i><p class="sidebar-text">Usuarios</p></a>
            <ul class="collapse list-unstyled" id="userSubmenu">
                <li>
                    <a href="/modulos/usuarios/index.php/"><i class="fas fa-user"></i><p class="sidebar-text">Usuarios</p></a>
                </li>
                <li>
                    <a href="/modulos/niveles/index.php/"><i class="fas fa-level-up-alt"></i><p class="sidebar-text">Niveles</p></a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#campusSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-school"></i><p class="sidebar-text">Campus</p></a>
            <ul class="collapse list-unstyled" id="campusSubmenu">
                <li>
                    <a href="/modulos/grados/index.php/"><i class="fas fa-graduation-cap"></i><p class="sidebar-text">Grados</p></a>
                </li>
                <li>
                    <a href="/modulos/salones/index.php/"><i class="fas fa-door-open"></i><p class="sidebar-text">Salones</p></a>
                </li>
                <li>
                    <a href="/modulos/servicios/index.php/"><i class="fas fa-place-of-worship"></i><p class="sidebar-text">Servicios</p></a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#configSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-cogs"></i><p class="sidebar-text">Configuración</p></a>
            <ul class="collapse list-unstyled" id="configSubmenu">
                <li>
                    <a href="/modulos/logs/index.php/"><i class="fas fa-history"></i><p class="sidebar-text">Logs</p></a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
<?php        
    }
?>