<?php
// Incluir la clase de la base de datos
require_once 'db_conexion.php';

session_start();

// Verificar si la sesión está activa y contiene los datos necesarios del usuario
if (!isset($_SESSION['id_usuario'], $_SESSION['nombre'], $_SESSION['es_admin'])) {
    // Si no hay sesión válida, redirigir al login
    header("Location: index.php");
    exit();
} else {
    // Cargo los datos del usuario para el navbar
    $nombreUsuario = $_SESSION['nombre'];
    $es_admin = $_SESSION['es_admin'];
}



$db = new Database();

// Conectar a la base de datos
$db->connect();

// Verifica si se recibió el id_pelicula mediante POST
if (isset($_POST['toggle_pelicula'])) {
    $id_pelicula = intval($_POST['toggle_pelicula']); // Convierte a entero
    $id_usuario = $_SESSION['id_usuario']; // Obtiene el id del usuario de la sesión

    // DEBUG: Verifica los valores antes de insertar
    error_log("ID Película: $id_pelicula, ID Usuario: $id_usuario");

    // utilizamos una funcion para verificar si existe la pelicula en favoritos
    if ($db->existePelicula($id_pelicula, $id_usuario)) {
        // Si existe. usamos la funcion para remover peliculas
        if ($db->removePelicula($id_pelicula, $id_usuario)) {
            error_log("Película eliminada correctamente.");
            header("Location: home.php");
            exit();
        } else {
            echo "Error al eliminar la pelicula";
        }
    } else {
        if ($db->addPelicula($id_pelicula, $id_usuario)) {
            error_log("Película agregada correctamente.");
            header("Location: home.php");
            exit();
        } else {
            echo "Error al agregar la pelicula";
        }
    }
}


// consulto la tabla pelicula
$sqlPeliculas = "SELECT 
            p.id_pelicula,
            p.titulo,
            p.descripcion,
            p.imagen,
            pl.nombre AS nombre_plataforma,
            pl.icono
        FROM 
            pelicula p
        INNER JOIN 
            plataforma pl
        ON 
            p.id_plataforma = pl.id_plataforma";



// Obtener los datos en formato JSON
$jsonDataPeliculas = $db->queryToJson($sqlPeliculas);

// guardo en dataPelicula las peliculas disponibles en un array asociativo
$dataPelicula = json_decode($jsonDataPeliculas, true);

// consulto la tabla continuarViendo del usuario activo en SESSION
$sqlContinuarViendo = "SELECT 
    p.id_pelicula,
    p.titulo, 
    p.descripcion, 
    p.imagen, 
    pl.nombre AS nombre_plataforma, 
    pl.icono,
    g.nombre AS genero
FROM continuarViendo cv
INNER JOIN pelicula p ON cv.id_pelicula = p.id_pelicula
INNER JOIN plataforma pl ON p.id_plataforma = pl.id_plataforma
INNER JOIN genero g ON p.id_genero = g.id_genero
WHERE cv.id_usuario = " . $_SESSION['id_usuario'];

// Obtener los datos en formato JSON
$jsonDataContinuarViendo = $db->queryToJson($sqlContinuarViendo);

// Decodificar el JSON a un arreglo asociativo
$continuarViendoPelicula = json_decode($jsonDataContinuarViendo, true);

// Verificar si la decodificación fue exitosa
if ($continuarViendoPelicula && $dataPelicula === null) {
    die("Error al decodificar JSON: " . json_last_error_msg());
}

// Cerrar la conexión
$db->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <!-- <link rel="stylesheet" href="./css/loading.css"> -->

    <!-- fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- icono -->
    <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">



    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>

    <!-- <style>
    .btn-float {
      /* position: fixed; */
      bottom: 20px;
      right: 20px;
      border-radius: 50%;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-float:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }
  </style> -->
    <!-- creamos este overlay para que por unos segundos no se pueda interactuar con la pagina mientras se carga la misma -->
    <div id="overlay"></div>

    <?php
    // importo la barra de navegacion
    include 'navbar.php';
    ?>



    <!-- carousel -->
    <div class="container-fluid p-0 mt-5 carousel-principal-mobile">
        <div id="carousel-principal-fluid" class="carousel slide" data-bs-ride="carousel">
            <!-- <div class="carousel-loading"></div> -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./imagenes/carousel/jurassicworld.png" class="d-block w-100" alt="jurassicworld">
                </div>
                <div class="carousel-item">
                    <img src="./imagenes/carousel/loki.png" class="d-block w-100" alt="loki">
                </div>
                <div class="carousel-item">
                    <img src="./imagenes/carousel/terminator.jpg" class="d-block w-100" alt="terminator">
                </div>

            </div>
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-principal-fluid" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carousel-principal-fluid" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carousel-principal-fluid" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
        </div>
    </div>

    <!-- carousel -->
    <div class="container p-0 mt-5 carousel-principal">
        <div id="carousel-principal" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-loading"></div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./imagenes/carousel/jurassicworld.png" class="d-block w-100" alt="jurassicworld">
                </div>
                <div class="carousel-item">
                    <img src="./imagenes/carousel/loki.png" class="d-block w-100" alt="loki">
                </div>
                <div class="carousel-item">
                    <img src="./imagenes/carousel/terminator.jpg" class="d-block w-100" alt="terminator">
                </div>

            </div>
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-principal" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carousel-principal" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carousel-principal" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
        </div>
    </div>

    <!-- aplicaciones -->
    <div class="container mt-3 container-app">
        <div class="row">
            <div class="d-flex div__card-app flex-nowrap overflow-auto justify-content-center ">
                <div class="card card-app card-netflix-app carousel-item p-0">
                    <a href="plataformaPelicula.php?id_plataforma=1">
                        <div class="card-app__loading col-2 rounded-circle"></div>
                        <img src="imagenes/apps/netflix.png" class="card-img-top rounded-circle" alt="Netflix">
                    </a>
                </div>
                <div class="card card-app card-disney-app carousel-item p-0">
                    <a href="plataformaPelicula.php?id_plataforma=3">
                        <div class="card-app__loading col-2  rounded-circle"></div>
                        <img src="imagenes/apps/disney.jpg" class="card-img-top rounded-circle" alt="Disney">
                    </a>
                </div>
                <div class="card card-app card-hbo-app carousel-item p-0">
                    <a href="plataformaPelicula.php?id_plataforma=2">
                        <div class="card-app__loading rounded-circle"></div>
                        <img src="imagenes/apps/hbomax.png" class="card-img-top rounded-circle" alt="HBO">
                    </a>
                </div>
                <!-- proximamente -->
                <!-- <div class="card card-app card-paramount-app carousel-item p-0">
                    <a href="404.html">
                        <div class="card-app__loading rounded-circle"></div>
                        <img src="imagenes/apps/paramount.png" class="card-img-top card-paramount rounded-circle"
                            alt="Paramount">
                    </a>
                </div>
                <div class="card card-app card-prime-app carousel-item p-0">
                    <a href="404.html">
                        <img src="imagenes/apps/amazon-prime.png" class="card-img-top card-prime rounded-circle"
                            alt="prime">
                    </a>
                </div> -->
                <div class="card card-app card-add-app carousel-item p-0">
                    <a href="404.php">
                        <img src="imagenes/apps/agregar-producto.png" class="card-img-top rounded-circle"
                            alt="agregar app">
                    </a>
                </div>
            </div>
        </div>
    </div>


    <section class="container mt-4">
        <?php
        if ($continuarViendoPelicula != null) {
            ?>
            <h1 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Lista de Favoritos</h1>
            <div class="row" id="div__seguirViendo">
                <div class="col-12 d-flex flex-wrap gap-3">
                    <?php foreach ($continuarViendoPelicula as $pelicula): ?>
                        <div class="card card-seguir-viendo col-4 col-md-3 col-lg-2 p-0">
                            <!-- <div class="card-seguir-viendo__loading"></div> -->
                            <!-- Enlace a la película -->
                            <!-- <a href="peliculas.php?id_pelicula=">Ver Película</a> -->

                            <!-- link para ir a la pelicula -->
                            <a href="peliculas.php?id_pelicula=<?= htmlspecialchars($pelicula['id_pelicula']) ?>.php">

                                <!-- Imagen de la película -->
                                <img src="<?= htmlspecialchars($pelicula['imagen']) ?>" class="card-img-top"
                                    alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                            </a>

                            <div class="card-body p-2 text-center">
                                <!-- Icono de la plataforma -->
                                <img src="<?= htmlspecialchars($pelicula['icono']) ?>" class="platform-icon"
                                    alt="<?= htmlspecialchars($pelicula['nombre_plataforma']) ?>">
                                <!-- boton que funciona como toggle para agregar o quitar peliculas de la lista de favoritos  -->
                                <form method="POST" action="./home.php">
                                    <input type="hidden" name="toggle_pelicula"
                                        value="<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                                    <!-- <button type="submit" style="background: none; border: none;">
                                        <img src="./imagenes/icon/add-agregar-pelicula-icon.png" class=""
                                            alt="Agregar pelicula">
                                    </button> -->
                                    <button type="submit" class="btn btn-outline-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-caret-right-square-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5.5 10a.5.5 0 0 0 .832.374l4.5-4a.5.5 0 0 0 0-.748l-4.5-4A.5.5 0 0 0 5.5 4z">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <?php
        }
        ?>
    </section>

    <!-- vista desktop -->
    <section class="container mt-4 carousel-desktop">
        <h2 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Top de la semana</h2>
        <!-- carousel -->
        <div id="carousel-top10" class="carousel slide">
            <div class="carousel-inner">
                <?php
                // Dividir películas en bloques de 4 por fila
                $chunks = array_chunk($dataPelicula, 4);
                foreach ($chunks as $index => $peliculasChunk):
                    ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row" style="overflow-x: visible; width: 100%;">
                            <div class="col-12 d-flex justify-content-center">
                                <?php foreach ($peliculasChunk as $pelicula): ?>
                                    <div class="card p-1 col-3 bg-dark hover-bg-black">
                                        <div class="card-app__loading col-3"></div>

                                        <a
                                            href="peliculas.php?id_pelicula=<?= htmlspecialchars($pelicula['id_pelicula']) ?>.php">

                                            <!-- Imagen de la película -->
                                            <img src="<?= htmlspecialchars($pelicula['imagen']) ?>" class="card-img-top"
                                                alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                                        </a>

                                        <div class="card-body p-0 m-0">
                                            <!-- Icono de la plataforma -->
                                            <p class="card-title p__cardSeguirViendo--img">
                                                <img src="<?= htmlspecialchars($pelicula['icono']) ?>" class=""
                                                    style="width: 50%"
                                                    alt="<?= htmlspecialchars($pelicula['nombre_plataforma']) ?>">
                                            </p>

                                            <!-- Formulario para agregar película -->
                                            <p class="card-title p__cardSeguirViendo--img">
                                            <form method="POST" action="./home.php">
                                                <input type="hidden" name="toggle_pelicula"
                                                    value="<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                                                <!-- <button type="submit" style="background: none; border: none;">
                                                    <img src="./imagenes/icon/agregar-pelicula-icon.png" class=""
                                                        style="width: 50%" alt="Agregar película">
                                                </button> -->
                                                <button type="submit" class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-caret-right-square-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5.5 10a.5.5 0 0 0 .832.374l4.5-4a.5.5 0 0 0 0-.748l-4.5-4A.5.5 0 0 0 5.5 4z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Controles del carousel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-top10" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel-top10" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>



    <!-- vista laptop -->
    <section class="container mt-4 carousel-laptop">
        <h2 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Top de la semana</h2>
        <!-- carousel -->
        <div id="carousel-top10-laptop" class="carousel slide">
            <div class="carousel-inner">
                <?php
                // Dividir películas en bloques de 4 por fila
                $chunks = array_chunk($dataPelicula, 3);
                foreach ($chunks as $index => $peliculasChunk):
                    ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row" style="overflow-x: visible; width: 100%;">
                            <div class="col-12 d-flex justify-content-center">
                                <?php foreach ($peliculasChunk as $pelicula): ?>
                                    <div class="card p-1 col-3 bg-dark hover-bg-black">
                                        <div class="card-app__loading col-3"></div>
                                        <!-- Imagen de la película -->
                                        <img src="<?= htmlspecialchars($pelicula['imagen']) ?>" class="card-img-top"
                                            alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                                        <div class="card-body p-0 m-0">
                                            <!-- Icono de la plataforma -->
                                            <p class="card-title p__cardSeguirViendo--img">
                                                <img src="<?= htmlspecialchars($pelicula['icono']) ?>" class=""
                                                    style="width: 50%"
                                                    alt="<?= htmlspecialchars($pelicula['nombre_plataforma']) ?>">
                                            </p>
                                            <p class="card-title p__cardSeguirViendo--img">
                                            <form method="POST" action="./home.php">
                                                <input type="hidden" name="toggle_pelicula"
                                                    value="<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                                                <!-- <button type="submit" style="background: none; border: none;">
                                                    <img src="./imagenes/icon/agregar-pelicula-icon.png" class=""
                                                        style="width: 50%" alt="Agregar película">
                                                </button> -->
                                                <button type="submit" class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-caret-right-square-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5.5 10a.5.5 0 0 0 .832.374l4.5-4a.5.5 0 0 0 0-.748l-4.5-4A.5.5 0 0 0 5.5 4z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- Carousel controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-top10-laptop"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel-top10-laptop"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
    </section>


    <!-- vista mobile -->
    <section class="container mt-4 carousel-mobile">
        <h2 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Top de la semana</h2>
        <!-- carousel -->
        <div id="carousel-top10-mobile" class="carousel slide">
            <div class="carousel-inner">
                <?php
                // Dividir películas en bloques de 4 por fila
                $chunks = array_chunk($dataPelicula, 2);
                foreach ($chunks as $index => $peliculasChunk):
                    ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row" style="overflow-x: visible; width: 100%;">
                            <div class="col-12 d-flex justify-content-center">
                                <?php foreach ($peliculasChunk as $pelicula): ?>
                                    <div class="card p-1 col-3 bg-dark hover-bg-black">
                                        <div class="card-app__loading col-3"></div>
                                        <!-- Imagen de la película -->
                                        <img src="<?= htmlspecialchars($pelicula['imagen']) ?>" class="card-img-top"
                                            alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                                        <div class="card-body p-0 m-0">
                                            <!-- Icono de la plataforma -->
                                            <p class="card-title p__cardSeguirViendo--img">
                                                <img src="<?= htmlspecialchars($pelicula['icono']) ?>" class=""
                                                    style="width: 50%"
                                                    alt="<?= htmlspecialchars($pelicula['nombre_plataforma']) ?>">
                                            </p>
                                            <p class="card-title p__cardSeguirViendo--img">
                                            <form method="POST" action="./home.php">
                                                <input type="hidden" name="toggle_pelicula"
                                                    value="<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                                                <!-- <button type="submit" style="background: none; border: none;">
                                                    <img src="./imagenes/icon/agregar-pelicula-icon.png" class=""
                                                        style="width: 50%" alt="Agregar película">
                                                </button> -->
                                                <button type="submit" class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-caret-right-square-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5.5 10a.5.5 0 0 0 .832.374l4.5-4a.5.5 0 0 0 0-.748l-4.5-4A.5.5 0 0 0 5.5 4z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- Carousel controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-top10-mobile"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel-top10-mobile"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
    </section>

    <!-- mejores peliculas responsive -->

    <!-- las peliculas mejor calificadas -->
    <section class="container mt-4">
        <h2 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Las películas mejor calificadas en IMDb</h2>
        <div class="row" style="overflow-x: visible; width: 100%;">
            <div class="col-12 d-flex flex-wrap">
                <div class="card p-1 bg-dark hover-bg-black">
                    <img src="imagenes/peliculas-series/pulp-fiction.png" class="card-img-top img-responsive" alt="...">
                    <div class="card-body p-0 m-0">
                        <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/hbo.png" class=""
                                style="width: 50%" alt="disney"></p>
                    </div>
                </div>

                <div class="card p-1 bg-dark hover-bg-black">
                    <img src="imagenes/peliculas-series/fast-furious.png" class="card-img-top img-responsive" alt="...">
                    <div class="card-body p-0 m-0">
                        <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/netflix.png" class=""
                                style="width: 50%" alt="disney"></p>
                    </div>
                </div>

                <div class="card p-1 bg-dark hover-bg-black">
                    <img src="imagenes/peliculas-series/johnwick.png" class="card-img-top img-responsive" alt="...">
                    <div class="card-body p-0 m-0">
                        <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/hbo.png" class=""
                                style="width: 50%" alt="disney"></p>
                    </div>
                </div>

                <div class="card p-1 bg-dark hover-bg-black">
                    <img src="imagenes/peliculas-series/star-wars.png" class="card-img-top img-responsive" alt="...">
                    <div class="card-body p-0 m-0">
                        <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/disney-icon.png"
                                class="" style="width: 50%" alt="disney"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- scripts de loading -->
    <!-- <script src="./scripts/loading.js"></script> -->
    <script src="./scripts/peliculas-favoritas.js"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>