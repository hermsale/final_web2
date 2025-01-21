<?php

require_once 'db_conexion.php';

$db = new Database();
session_start();

// Verifico si el usuario está logueado y si hay el valor session de admin tiene el valor correspondiente
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nombre']) || $_SESSION['es_admin'] != 1) {
    // Si no está logueado o no es admin, redirigir al login
    header("Location: index.php");
    exit();
} else {
    $nombreUsuario = $_SESSION['nombre'];
    $es_admin = $_SESSION['es_admin'];
}


// Obtengo los datos de todos los usuarios
$dataUsuario = $db->getAllUsuarios();

// Obtengo los datos de todas las peliculas
$dataPeliculas = $db->getAllMovies();


// recibo por el metodo post del formulario el id del usuario a eliminar 
if (isset($_POST['deleteUserId'])) {
    $id_usuario = intval($_POST['deleteUserId']);
    // funcion para eliminar usuario
    $db->deteleUserById($id_usuario);
    header("Location: adminPanel.php");
    exit();
}

// Obtengo los parametros para actualizar los usuarios en la BD 
if (isset($_POST["editUserId"], $_POST["editUserName"], $_POST["editUserEmail"], $_POST["editUserPassword"])) {
    $id_usuario = intval($_POST['editUserId']);
    $userName = htmlspecialchars($_POST['editUserName']);
    $userEmail = htmlspecialchars($_POST['editUserEmail']);
    $userPassword = htmlspecialchars($_POST['editUserPassword']);

    // Actualizar el usuario en la base de datos
    $db->updateUserById($id_usuario, $userName, $userEmail, $userPassword);

    // Redirigir después de la actualización
    header("Location: adminPanel.php?success=true");
    exit();
}

// obtengo los parametros para actualizar las peliculas en la BD
if (isset($_POST["id_pelicula"], $_POST["titulo"], $_POST["descripcion"], $_POST["imagen"], $_POST["id_plataforma"], $_POST["id_genero"])){
    // Capturo y sanitizo los datos enviados desde el formulario para actualizar las peliculas
    $id_pelicula = intval($_POST['id_pelicula']);
    $titulo = htmlspecialchars($_POST['titulo']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $imagen = htmlspecialchars($_POST['imagen']);
    $id_plataforma = intval($_POST['id_plataforma']);
    $id_genero = intval($_POST['id_genero']);

    // Actualizar la película en la base de datos
    if ($db->updateMovieById($id_pelicula, $titulo, $descripcion, $imagen, $id_plataforma, $id_genero)) {
        // Redirigir al panel de administración mostrando mensaje de éxito
        header("Location: adminPanel.php?success=true");
    } else {
        // Redirigir al panel de administración mostrando mensaje de  error
        header("Location: adminPanel.php?success=false");
    }
}


$db->close();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/navbar.css">

    <!-- fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- icono -->
    <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">



    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
</head>

<body>
    <?php
    // importo la barra de navegacion
    include 'navbar.php';
    ?>


    <div class="container mt-5 ">

        <h1 class="text-center mb-4">Panel de Administración</h1>

        <!-- mensaje de confirmación que se modifico  y guardo correctamente los cambios. o que algo fallo-->
        <?php if (isset($_GET['success'])):
            if ($_GET['success'] === 'true'): ?>
                <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ¡Los datos se guardaron correctamente!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php else: ?>
                <div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    Hubo un error al guardar los datos. Por favor, intenta nuevamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <!-- Tabla de usuarios -->
        <div class="table-responsive">
            <h2 class="text-center mb-4">Administración de Usuarios</h2>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Generación dinámica de filas con PHP -->
                    <?php foreach ($dataUsuario as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['id_usuario']); ?></td>
                            <td><?= htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?= htmlspecialchars($usuario['email']); ?></td>
                            <td><?= htmlspecialchars($usuario['contrasenia']); ?></td>
                            <td><?= htmlspecialchars($usuario['es_admin'] == 1 ? 'Administrador' : 'Usuario'); ?></td>
                            <td>
                                <?php if ($usuario['es_admin'] != 1): ?>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-name="<?= htmlspecialchars($usuario['nombre']); ?>"
                                        data-email="<?= htmlspecialchars($usuario['email']); ?>"
                                        data-password="<?= htmlspecialchars($usuario['contrasenia']); ?>" data-id="<?= $usuario['id_usuario'];
                                          ?>">Editar</button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-id="<?= $usuario['id_usuario']; ?>">Eliminar</button>
                                <?php else: ?>
                                    <!-- si el usuario es administrador no se puede eliminar -->
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-name="<?= htmlspecialchars($usuario['nombre']); ?>"
                                        data-email="<?= htmlspecialchars($usuario['email']); ?>"
                                        data-password="<?= htmlspecialchars($usuario['contrasenia']); ?>"
                                        data-id="<?= $usuario['id_usuario']; ?>">Editar</button>
                                    <button class="btn btn-danger btn-sm" disabled>Eliminar</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <!-- Tabla de películas -->
        <div class="table-responsive">
            <h2 class="text-center mb-4">Administración de Películas</h2>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Plataforma</th>
                        <th>Género</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Generación dinámica de filas con PHP -->
                    <?php foreach ($dataPeliculas as $pelicula): ?>
                        <tr>
                            <td><?= htmlspecialchars($pelicula['id_pelicula']); ?></td>
                            <td><?= htmlspecialchars($pelicula['titulo']); ?></td>
                            <td><?= htmlspecialchars($pelicula['descripcion']); ?></td>
                            <td><img src="<?= htmlspecialchars($pelicula['imagen']); ?>" alt="Imagen de la película"
                                    width="50"></td>
                            <td><?= htmlspecialchars($pelicula['nombre_plataforma']); ?></td>
                            <td><?= htmlspecialchars($pelicula['nombre_genero']); ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editMovieModal"
                                    data-title="<?= htmlspecialchars($pelicula['titulo']); ?>"
                                    data-description="<?= htmlspecialchars($pelicula['descripcion']); ?>"
                                    data-image="<?= htmlspecialchars($pelicula['imagen']); ?>"
                                    data-platform="<?= htmlspecialchars($pelicula['id_plataforma']); ?>"
                                    data-genre="<?= htmlspecialchars($pelicula['id_genero']); ?>"
                                    data-id="<?= $pelicula['id_pelicula']; ?>">Editar</button>
                                <!-- deshabilito eliminar pelicula. proxima mejora para cuando se agregue la opcion de carga de peliculas -->
                                <button class="btn btn-danger btn-sm disabled" data-bs-toggle="modal"
                                    data-bs-target="#deleteMovieModal"
                                    data-id="<?= $pelicula['id_pelicula']; ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal para Editar Usuario -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="./adminPanel.php">
                            <input type="hidden" id="id__editUserId" name="editUserId">
                            <div class="mb-3">
                                <label for="editUserName" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editUserName" name="editUserName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editUserEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editUserEmail" name="editUserEmail"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editUserEmail" class="form-label">Password</label>
                                <input type="text" class="form-control" id="editUserPassword" name="editUserPassword"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Eliminar Usuario -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Eliminar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                        <form method="POST" action="./adminPanel.php">
                            <input type="hidden" id="id__deleteUserId" name="deleteUserId" value="">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Película -->
    <div class="modal fade" id="editMovieModal" tabindex="-1" aria-labelledby="editMovieModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMovieModalLabel">Editar Película</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="./adminPanel.php">
                        <!-- ID oculto para identificar la película a editar -->
                        <input type="hidden" id="id__editMovieId" name="id_pelicula">

                        <!-- Campo de Título -->
                        <div class="mb-3">
                            <label for="editMovieTitle" class="form-label">Título</label>
                            <input type="text" class="form-control" id="editMovieTitle" name="titulo" required>
                        </div>

                        <!-- Campo de Descripción -->
                        <div class="mb-3">
                            <label for="editMovieDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editMovieDescription" name="descripcion" rows="3"
                                required></textarea>
                        </div>

                        <!-- Campo de Imagen (URL) -->
                        <div class="mb-3">
                            <label for="editMovieImage" class="form-label">Imagen (URL)</label>
                            <input type="text" class="form-control" id="editMovieImage" name="imagen" required>
                        </div>

                        <!-- Selector de Plataforma -->
                        <div class="mb-3">
                            <select class="form-select" id="platform" name="id_plataforma" required>
                                <option value="1" <?= $pelicula['id_plataforma'] == 1 ? 'selected' : '' ?>>Netflix</option>
                                <option value="2" <?= $pelicula['id_plataforma'] == 2 ? 'selected' : '' ?>>HBO</option>
                                <option value="3" <?= $pelicula['id_plataforma'] == 3 ? 'selected' : '' ?>>Disney</option>
                            </select>
                        </div>

                        <!-- Selector de Género -->
                        <div class="mb-3">
                            <select class="form-select" id="genre" name="id_genero" required>
                                <option value="1" <?= $pelicula['id_genero'] == 1 ? 'selected' : '' ?>>Acción</option>
                                <option value="2" <?= $pelicula['id_genero'] == 2 ? 'selected' : '' ?>>Aventura</option>
                                <option value="3" <?= $pelicula['id_genero'] == 3 ? 'selected' : '' ?>>Comedia</option>
                                <option value="4" <?= $pelicula['id_genero'] == 4 ? 'selected' : '' ?>>Drama</option>
                                <option value="5" <?= $pelicula['id_genero'] == 5 ? 'selected' : '' ?>>Ciencia Ficción
                                </option>
                                <option value="6" <?= $pelicula['id_genero'] == 6 ? 'selected' : '' ?>>Fantasía</option>
                            </select>
                        </div>

                        <!-- Botón de enviar -->
                        <button type="submit" class="btn btn-primary">Actualizar Película</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- // Manejar eventos para cargar datos en los modales -->
    <script>
        // para editar usuarios
        document.querySelectorAll('button[data-bs-target="#editModal"]').forEach(button => {
            button.addEventListener('click', () => {
                const id_usuario = button.getAttribute('data-id');
                const userName = button.getAttribute('data-name');
                const userEmail = button.getAttribute('data-email');
                const userPassword = button.getAttribute('data-password');

                // envio el id del usuario a editar 
                document.getElementById('id__editUserId').value = id_usuario;
                // cargo los datos del usuario a editar para una mejor experiencia de usuario
                document.getElementById('editUserName').value = userName;
                document.getElementById('editUserEmail').value = userEmail;
                document.getElementById('editUserPassword').value = userPassword;
            });
        });

        // para eliminar usuarios
        // selecciono todos los botones con el atributo deleteModal. y paso 
        document.querySelectorAll('button[data-bs-target="#deleteModal"]').forEach(button => {
            button.addEventListener('click', () => {
                const id_usuario = button.getAttribute('data-id');
                // agrego el valor id_usuario al id del modal que esta conectado con el php por medio del name="deleteUserId"
                document.getElementById('id__deleteUserId').value = id_usuario;
            });
        });


        // para editar peliculas
        document.querySelectorAll('button[data-bs-target="#editMovieModal"]').forEach(button => {
            button.addEventListener('click', () => {
                const id_pelicula = button.getAttribute('data-id');
                const movieTitle = button.getAttribute('data-title');
                const movieDescription = button.getAttribute('data-description');
                const movieImage = button.getAttribute('data-image');
                const moviePlatform = button.getAttribute('data-platform');
                const movieGenre = button.getAttribute('data-genre');

                // Envio el id de la película a editar
                document.getElementById('id__editMovieId').value = id_pelicula;

                // Cargo los datos de la película a editar para una mejor experiencia de usuario
                document.getElementById('editMovieTitle').value = movieTitle;
                document.getElementById('editMovieDescription').value = movieDescription;
                document.getElementById('editMovieImage').value = movieImage;

                // Selecciono la plataforma y el género en los select
                document.getElementById('platform').value = moviePlatform;
                document.getElementById('genre').value = movieGenre;
            });
        });


        // manejo el mensaje de cuando se guardo exitosamente los cambios
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                const alert = document.getElementById('successAlert');
                alert.classList.remove('d-none'); // Remueve la clase d-none
                alert.classList.add('show'); // Añade la clase show para mostrarlo con animación

                // Ocultar después de 3 segundos
                setTimeout(function () {
                    alert.classList.remove('show'); // Elimina la clase show
                    alert.classList.add('d-none'); // Añade la clase d-none para ocultarlo
                }, 3000); // 3 segundos
            }
        });
    </script>

</body>

</html>