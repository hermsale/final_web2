<?php
// Incluir la clase de la base de datos
require_once 'db_conexion.php';

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



// tomo de SESSION el nombre guardado para cargarlo en el navbar
$nombreUsuario = $_SESSION['nombre'];

$db = new Database();

$conexion = $db->connect();

// Obtener el id_pelicula de la URL
$id_pelicula = isset($_GET['id_pelicula']) ? (int) $_GET['id_pelicula'] : 0;

// Validar el ID
if ($id_pelicula <= 0) {
    echo "Película no encontrada.";
    exit();
}

// Consultar la base de datos para obtener la información de la película
$sqlPelicula = "SELECT 
                    p.id_pelicula,
                    p.titulo,
                    p.descripcion,
                    p.imagen,
                    pl.nombre AS nombre_plataforma,
                    pl.icono,
                    g.nombre AS nombre_genero
                FROM 
                    pelicula p
                INNER JOIN 
                    plataforma pl
                ON 
                    p.id_plataforma = pl.id_plataforma
                INNER JOIN 
                    genero g
                ON 
                    p.id_genero = g.id_genero
                WHERE 
                    p.id_pelicula = ?";
$stmt = $conexion->prepare($sqlPelicula);
$stmt->bind_param('i', $id_pelicula);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró la película
if ($result->num_rows === 0) {
    echo "Película no encontrada.";
    exit();
}

// Obtener los datos de la película
$dataPelicula = $result->fetch_assoc();


// Cerrar la conexión
$db->close();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/peliculas.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/loading.css">

    <!-- fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- icono -->
    <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelicula</title>
</head>

<body>
    <!-- barra de navegacion -->
    <?php
    include("navbar.php");
    ?>

    <div class="container">

        <div class="container d-flex flex-column align-items-center justify-content-center text-center"
            style="min-height: 70vh;">
            <img src="<?php echo htmlspecialchars($dataPelicula['imagen']); ?>" alt="Imagen de la película"
                style="max-width: 100%; height: auto;">
            <h1 class="fw-bolder exo-2 fs-1 fs-md-4 fs-lg-5"><?php echo htmlspecialchars($dataPelicula['titulo']); ?>
            </h1>
            <div class="text-left">
                <p><?php echo htmlspecialchars($dataPelicula['descripcion']); ?></p>
                <p><strong>Disponible en:</strong> <?php echo htmlspecialchars($dataPelicula['nombre_plataforma']); ?>
                </p>
                <p><strong>Género:</strong> <?php echo htmlspecialchars($dataPelicula['nombre_genero']); ?></p>
            </div>
        </div>
        <div class="text-left mt-4">
            <button type="button" class="btn btn-warning btn-lg" onclick="window.history.back();">
                Volver
            </button>
        </div>


        <section class="container m-3">
            <h3 class="fw-bold exo-2 fs-1 fs-md-4 fs-lg-5">Peliculas recomendadas</h3>
            <div class="div__img--peliculas-recomendadas">
                <img src="./imagenes/peliculas-series/hard-fie.png" alt="die hard">
                <img src="./imagenes/peliculas-series/anillos.png" alt="el señor de los anillos">
            </div>
        </section>

    </div>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>