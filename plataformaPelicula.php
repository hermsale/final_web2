<?php

session_start();
require_once 'db_conexion.php';

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
// Obtener las películas filtradas por plataforma
$id_plataforma = isset($_GET['id_plataforma']) ? (int)$_GET['id_plataforma'] : 0;
// die ('es '.$id_plataforma);
$dataPelicula = $db->getMovieByPlataforma($id_plataforma); // Método para obtener películas filtradas por plataforma 

// query para traer el nombre de la plataforma correspondiente al id
$sqlNombrePlataforma = "SELECT nombre FROM plataforma WHERE id_plataforma = ?";
$stmt = $db->prepare($sqlNombrePlataforma);

$stmt->bind_param('i', $id_plataforma);
$stmt->execute();
$result = $stmt->get_result();
// guardo lo que haya en la clave 'nombre' del array asociativo
$nombrePlataforma = $result->fetch_assoc()['nombre'] ?? 'Plataforma desconocida';

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/loading.css">
    <link rel="stylesheet" href="./css/netflix.css">

    <!-- fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- icono -->
    <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">

   

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
</head>
<body>

    <!-- creamos este overlay para que por unos segundos no se pueda interactuar con la pagina mientras se carga la misma -->
    <div id="overlay"></div>
<!-- barra de navegacion -->
   <?php

   include("navbar.php");
   ?>

<!-- imagen principal netflix -->
    <div id="div__banner" class="container-fluid mt-5">
        <div class="banner">
            <img src="./imagenes/netflix/banner.jpg" alt="netflix">
        </div>
    </div>
    <div class="container mt-3">
        <div class="card mb-3">
            <div class="row g-0 bg-dark">
                <div class="col-md-12">
                    <img src="./imagenes/netflix/pelicula-dia-john-wicj.png" class="d-block w-100" alt="John Wick">
                    <button class="btn btn-dark btn-overlay">Ver ahora</button>
                    <div class="card-body">
                        <h2 class="card-title">John Wick</h2>
                        <p class="card-text">John Wick is on the run after killing a member of the international assassins' guild, and with a $14 million price tag on his head, he is the target of hit men and women everywhere.</p>
                        <p class="card-text"><small>Last updated 3 mins ago</small></p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- vista mobile -->
    <section class="container mt-4 carousel-mobile">
    <h2 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Contenido de la Plataforma <?= htmlspecialchars($nombrePlataforma ) ?></h2>
    <!-- Carrusel -->
    <div id="carousel-platform" class="carousel slide">
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

                                    <!-- Enlace a los detalles de la película -->
                                    <a href="peliculas.php?id_pelicula=<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                                        <!-- Imagen de la película -->
                                        <img src="<?= htmlspecialchars($pelicula['imagen']) ?>" class="card-img-top"
                                            alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                                    </a>

                                    <div class="card-body p-0 m-0">
                                        <!-- Icono de la plataforma -->
                                        <p class="card-title p__cardSeguirViendo--img">
                                            <img src="<?= htmlspecialchars($pelicula['icono_plataforma']) ?>" style="width: 25%"
                                                alt="<?= htmlspecialchars($pelicula['nombre_plataforma']) ?>">
                                        </p>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-platform" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel-platform" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>


<!-- vista desktop -->
<section class="container mt-4 carousel-desktop">
    <h2 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Contenido de la Plataforma <?= htmlspecialchars($nombrePlataforma ) ?></h2>
    <!-- Carrusel -->
    <div id="carousel-platform" class="carousel slide">
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

                                    <!-- Enlace a los detalles de la película -->
                                    <a href="peliculas.php?id_pelicula=<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                                        <!-- Imagen de la película -->
                                        <img src="<?= htmlspecialchars($pelicula['imagen']) ?>" class="card-img-top"
                                            alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                                    </a>

                                    <div class="card-body p-0 m-0">
                                        <!-- Icono de la plataforma -->
                                        <p class="card-title p__cardSeguirViendo--img">
                                            <img src="<?= htmlspecialchars($pelicula['icono_plataforma']) ?>" style="width: 25%"
                                                alt="<?= htmlspecialchars($pelicula['nombre_plataforma']) ?>">
                                        </p>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-platform" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel-platform" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>


<!-- vista laptop -->
<section class="container mt-4 carousel-laptop">
    <h2 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Contenido de la Plataforma <?= htmlspecialchars($nombrePlataforma  ) ?></h2>
    <!-- Carrusel -->
    <div id="carousel-platform" class="carousel slide">
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

                                    <!-- Enlace a los detalles de la película -->
                                    <a href="peliculas.php?id_pelicula=<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                                        <!-- Imagen de la película -->
                                        <img src="<?= htmlspecialchars($pelicula['imagen']) ?>" class="card-img-top"
                                            alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                                    </a>

                                    <div class="card-body p-0 m-0">
                                        <!-- Icono de la plataforma -->
                                        <p class="card-title p__cardSeguirViendo--img">
                                            <img src="<?= htmlspecialchars($pelicula['icono_plataforma']) ?>" style="width: 25%"
                                                alt="<?= htmlspecialchars($pelicula['nombre_plataforma']) ?>">
                                        </p>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-platform" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel-platform" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>


<section class="container-fluid mt-4">
    <h2 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Clásicos que no pasan de moda</h2>
    <div class="row" style="overflow-x: visible; width: 100%;">
        <div class="col-12 d-flex flex-wrap">
            <div class="card p-1 bg-dark hover-bg-black">
                <img src="imagenes/peliculas-series/pulp-fiction.png" class="card-img-top img-responsive" alt="...">
                <div class="card-body p-0 m-0">
                    <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/hbo.png" class="" style="width: 50%" alt="disney"></p>
                </div>
            </div>

            <div class="card p-1 bg-dark hover-bg-black">
                <img src="imagenes/peliculas-series/terminator-1.png" class="card-img-top img-responsive" alt="...">
                <div class="card-body p-0 m-0">
                    <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/netflix.png" class="" style="width: 50%" alt="disney"></p>
                </div>
            </div>

            <div class="card p-1 bg-dark hover-bg-black">
                <img src="imagenes/peliculas-series/scars-face.png" class="card-img-top img-responsive" alt="...">
                <div class="card-body p-0 m-0">
                    <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/hbo.png" class="" style="width: 50%" alt="disney"></p>
                </div>
            </div>

            <div class="card p-1 bg-dark hover-bg-black">
                <img src="imagenes/peliculas-series/hard-fie.png" class="card-img-top img-responsive" alt="...">
                <div class="card-body p-0 m-0">
                    <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/disney-icon.png" class="" style="width: 50%" alt="disney"></p>
                </div>
            </div>
        </div>
    </div>
</section>
    
    <!-- carousel -->
<!-- carousel -->
<div class="container-fluid p-0 mt-5 carousel-principal-mobile">
    <div id="carousel-principal-fluid" class="carousel slide" data-bs-ride="carousel">
        <!-- <div class="carousel-loading"></div> -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./imagenes/carousel/terror-netflix.png" class="d-block w-100" alt="jurassicworld">
            </div>
            <div class="carousel-item">
                <img src="./imagenes/carousel/carousel-netflix-2.png" class="d-block w-100" alt="loki">
            </div>
            <div class="carousel-item">
                <img src="./imagenes/carousel/carousel-netflix-1.png" class="d-block w-100" alt="terminator">
            </div>

        </div>
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel-principal-fluid" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carousel-principal-fluid" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carousel-principal-fluid" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
      </div>
</div>

<!-- carousel -->
<div class="container p-0 mt-5 carousel-principal">
    <div id="carousel-principal" class="carousel slide" data-bs-ride="carousel">
        <!-- <div class="carousel-loading"></div> -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./imagenes/carousel/terror-netflix.png" class="d-block w-100" alt="jurassicworld">
            </div>
            <div class="carousel-item">
                <img src="./imagenes/carousel/carousel-netflix-1.png" class="d-block w-100" alt="loki">
            </div>
            <div class="carousel-item">
                <img src="./imagenes/carousel/carousel-netflix-2.png" class="d-block w-100" alt="terminator">
            </div>

        </div>
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel-principal" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carousel-principal" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carousel-principal" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
      </div>
</div>

    <section class="container-fluid mt-4 mb-4">
        <h2 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Los más buscados en la plataforma</h2>
        <div class="row" style="overflow-x: visible; width: 100%;">
            <div class="col-12 d-flex flex-wrap">
                <div class="card p-1 bg-dark hover-bg-black">
                    <img src="imagenes/peliculas-series/johnwick.png" class="card-img-top img-responsive" alt="...">
                    <div class="card-body p-0 m-0">
                        <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/hbo.png" class="" style="width: 50%" alt="disney"></p>
                    </div>
                </div>
    
                <div class="card p-1 bg-dark hover-bg-black">
                    <img src="imagenes/peliculas-series/spiderman.png" class="card-img-top img-responsive" alt="...">
                    <div class="card-body p-0 m-0">
                        <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/disney-icon.png" class="" style="width: 50%" alt="disney"></p>
                    </div>
                </div>
    
                <div class="card p-1 bg-dark hover-bg-black">
                    <img src="imagenes/peliculas-series/terminator-2.png" class="card-img-top img-responsive" alt="...">
                    <div class="card-body p-0 m-0">
                        <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/netflix.png" class="" style="width: 50%" alt="disney"></p>
                    </div>
                </div>
    
                <div class="card p-1 bg-dark hover-bg-black">
                    <img src="imagenes/peliculas-series/star-wars.png" class="card-img-top img-responsive" alt="...">
                    <div class="card-body p-0 m-0">
                        <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/disney-icon.png" class="" style="width: 50%" alt="disney"></p>
                    </div>
                </div>

                <div class="card p-1 bg-dark hover-bg-black">
                    <img src="imagenes/peliculas-series/fast-furious.png" class="card-img-top img-responsive" alt="...">
                    <div class="card-body p-0 m-0">
                        <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/netflix.png" class="" style="width: 50%" alt="disney"></p>
                    </div>
                </div>

                <div class="card p-1 bg-dark hover-bg-black">
                    <img src="imagenes/peliculas-series/anillos.png" class="card-img-top img-responsive" alt="...">
                    <div class="card-body p-0 m-0">
                        <p class="card-title p__cardSeguirViendo--img"><img src="./imagenes/icon/disney-icon.png" class="" style="width: 50%" alt="disney"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- scripts de loading -->
     <script src="./scripts/loading.js"></script>
     <script src="./scripts/cargaPeliculas.js"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>