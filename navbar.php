<header>
    <nav class="nav__menu">
        <!-- menu peliculas -->
        <ul class="menu menu__left--desplegado">
            <li class="exo-2"><a href="home.php">Inicio</a></li>
            <li class="exo-2"><a href="categorias.php">Categorias</a></li>
        </ul>

        <ul class="menu menu__left--hamburguesa">
            <li><a href="#"><img class="img__icono--hamburguesa" src="./imagenes/navbar/menu.png" alt="menu"></a>
                <ul class="submenu submenu__left">
                    <li class="exo-2"><a href="home.php">Inicio</a></li>
                    <li class="exo-2"><a href="categorias.php">Categorias</a></li>
                </ul>
            </li>
        </ul>

        <!-- menu usuario -->
        <ul class="menu menu__right--desplegado">
            <!-- <li class="menu__right--lupa"><img class="img__right--lupa" src="./imagenes/navbar/lupa.png" alt="menu"></li> -->
            <li class="li__usuario">
                <h3 class="me-2 exo-2">
                    <?php echo htmlspecialchars($nombreUsuario); ?>
                </h3>
                <a href="#">
                    <img class="img__right--usuario" src="./imagenes/navbar/darth-vader.png" alt="menu">
                </a>
                <ul class="submenu submenu__right">
                <?php if ($es_admin == 1) { ?>
                    <li class="exo-2"><a href="./adminPanel.php">Panel Admin</a></li>
                <?php } ?>
                    <li class="exo-2"><a href="./cuenta.php">Cuenta y configuración</a></li>
                    <li class="exo-2"><a href="./contacto.php">Ayuda</a></li>
                    <li class="exo-2"><a href="./seleccionUsuario.php">Perfiles</a></li>
                    <li class="exo-2"><a href="./index.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>

        <ul class="menu menu__right--hamburguesa">
            <!-- <li class="menu__right--lupa"><img class="img__right--lupa" src="./imagenes/navbar/lupa.png" alt="menu"></li> -->
            <li><a href="#"><img class="img__right--usuario" src="./imagenes/navbar/darth-vader.png" alt="menu"></a>
                <ul class="submenu submenu__right">
                    <li class="exo-2"><a href="#"> <?php echo htmlspecialchars($nombreUsuario); ?></a></li>
                    <li class="exo-2"><a href="cuenta.php">Cuenta y configuración</a></li>
                    <li class="exo-2"><a href="contacto.php">Ayuda</a></li>
                    <li class="exo-2"><a href="./seleccionUsuario.php.php">Perfiles</a></li>
                    <li class="exo-2"><a href="./index.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
