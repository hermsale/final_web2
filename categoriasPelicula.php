<?php

require_once 'db_conexion.php';
$db = new Database();
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


// Obtener el id_genero de la URL
$id_genero = isset($_GET['id_genero']) ? (int) $_GET['id_genero'] : 0;

// obtengo todas las peliculas
$resultadoPeliculas = $db->getMoviesByIdCategory($id_genero);

// consulto la tabla genero
$sqlGenero = "SELECT * FROM genero";

// Obtener los datos en formato JSON
$jsonDataGenero = $db->queryToJson($sqlGenero);

// guardo en dataGenero los generos disponibles en un array asociativo
$dataGenero = json_decode($jsonDataGenero, true);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Películas del Género</title>

    <!-- CSS -->
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/categorias.css">

    <!-- fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- icono -->
    <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">
    
</head>

<body>
    <?php
    include("navbar.php");
    ?>
    <div class="container mt-5">
        <h1 class="mb-4 text-center h1__categorias">Películas de Género: <?php

        $nombreGenero = "Género desconocido"; // Valor por defecto
        foreach ($dataGenero as $genero) {
            if ($genero['id_genero'] == $id_genero) {
                $nombreGenero = htmlspecialchars($genero['nombre']);
                break;
            }
        }
        echo $nombreGenero;
        ?>
        </h1>
        <div class="row">

            <?php if (!empty($resultadoPeliculas)): ?>
                <?php foreach ($resultadoPeliculas as $pelicula): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card category-card">
                            <!-- Enlace a los detalles de la película -->
                            <a href="peliculas.php?id_pelicula=<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                            <img src="<?php echo htmlspecialchars($pelicula['imagen']); ?>" class="card-img-top"
                                alt="<?php echo htmlspecialchars($pelicula['titulo']); ?>">
                            </a>
                            <div class="card-body bg-dark text-white">
                                <h2 class="card-title"><?php echo htmlspecialchars($pelicula['titulo']); ?></h2>
                                <p class="card-text"><?php echo htmlspecialchars($pelicula['descripcion']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">No hay películas disponibles para este género.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>