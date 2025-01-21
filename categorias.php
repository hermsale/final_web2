<?php
session_start();

// Verificar si la sesión está activa y contiene datos del usuario
if (!isset($_SESSION['id_usuario'], $_SESSION['nombre'], $_SESSION['es_admin'])) {
    // Si no hay sesión válida, redirigir al login
    header("Location: index.php");
    exit();
} else {
    // Cargo los datos del usuario para el navbar
    $nombreUsuario = $_SESSION['nombre'];
    $es_admin = $_SESSION['es_admin'];
}


$nombreUsuario = $_SESSION['nombre'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/categorias.css">

    <!-- fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- icono -->
    <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
</head>

<body>
    <?php
    include("navbar.php");
    ?>

    <div class="container mt-5">
        <h1 class="mb-4 text-center h1__categorias">Categorías de Películas</h1>
        <div class="row">
            <!-- Card 1 (Acción) -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card category-card">
                    <img src="imagenes/categorias/pelicula-dia-john-wik.png" class="card-img-top" alt="Acción">
                    <div class="card-body bg-dark">
                        <h2 class="card-title">Acción</h2>
                        <p class="card-text">Explora las mejores películas de acción llenas de adrenalina y emocionantes
                            escenas de combate.</p>
                        <a href="categoriasPelicula.php?id_genero=1" class="btn btn-primary">Ver más</a>
                        <!-- Redirección a categoriasPelicula.php con id_genero=1 -->
                    </div>
                </div>
            </div>
            <!-- Card 2 (Aventura) -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card category-card bg-dark">
                    <img src="imagenes/categorias/uncharted.png" class="card-img-top" alt="Aventura">
                    <div class="card-body">
                        <h2 class="card-title">Aventura</h2>
                        <p class="card-text">Disfruta de una selección de películas de aventura llenas de emoción y
                            paisajes exóticos.</p>
                        <a href="categoriasPelicula.php?id_genero=2" class="btn btn-primary">Ver más</a>
                        <!-- Redirección a categoriasPelicula.php con id_genero=2 -->
                    </div>
                </div>
            </div>
            <!-- Card 3 (Comedia) -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card category-card bg-dark">
                    <img src="imagenes/categorias/american-pie-2.png" class="card-img-top" alt="Comedia">
                    <div class="card-body">
                        <h2 class="card-title">Comedia</h2>
                        <p class="card-text">Disfruta de una selección de películas cómicas que te harán reír a
                            carcajadas.</p>
                        <a href="categoriasPelicula.php?id_genero=3" class="btn btn-primary">Ver más</a>
                        <!-- Redirección a categoriasPelicula.php con id_genero=3 -->
                    </div>
                </div>
            </div>
            <!-- Card 4 (Drama) -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card category-card">
                    <img src="imagenes/categorias/drama.png" class="card-img-top" alt="Drama">
                    <div class="card-body bg-dark">
                        <h2 class="card-title">Drama</h2>
                        <p class="card-text">Explora las mejores películas dramáticas que exploran temas profundos y
                            emocionantes.</p>
                        <a href="categoriasPelicula.php?id_genero=4" class="btn btn-primary">Ver más</a>
                        <!-- Redirección a categoriasPelicula.php con id_genero=4 -->
                    </div>
                </div>
            </div>
            <!-- Card 5 (Ciencia Ficción) -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card category-card bg-dark">
                    <img src="imagenes/categorias/ciencia-ficcion.png" class="card-img-top" alt="Ciencia Ficción">
                    <div class="card-body">
                        <h2 class="card-title">Ciencia Ficción</h2>
                        <p class="card-text">Explora los mejores títulos de ciencia ficción llenos de avances
                            tecnológicos y mundos futuristas.</p>
                        <a href="categoriasPelicula.php?id_genero=5" class="btn btn-primary">Ver más</a>
                        <!-- Redirección a categoriasPelicula.php con id_genero=5 -->
                    </div>
                </div>
            </div>
            <!-- Card 6 (Fantasía) -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card category-card bg-dark">
                    <img src="imagenes/categorias/animada.png" class="card-img-top" alt="Fantasía">
                    <div class="card-body">
                        <h2 class="card-title">Fantasía</h2>
                        <p class="card-text">Sumérgete en un mundo lleno de magia, criaturas fantásticas y aventuras
                            épicas.</p>
                        <a href="categoriasPelicula.php?id_genero=6" class="btn btn-primary">Ver más</a>
                        <!-- Redirección a categoriasPelicula.php con id_genero=6 -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- scripts de loading -->
    <script src="./scripts/loading.js"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>