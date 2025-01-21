<?php
session_start();
require 'db_conexion.php'; // Conexión a la base de datos

// Crear una instancia de la clase Database
$db = new Database();

// Conectar a la base de datos
$conexion = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verificar si los campos están completos
    if (!empty($nombre) && !empty($email) && !empty($password)) {
        // se hace una consulta si ya esta registrado el email
        $query = "SELECT id_usuario FROM usuario WHERE email = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result(); // guardo el resultado de la consulta

        // comparo el numero de filas de la consulta resultado. si es 0 significa que no hay usuario registrado con ese email
        if ($result->num_rows === 0) {
            // El correo no está registrado, podemos agregar al nuevo usuario
            $query = "INSERT INTO usuario (nombre, email, contrasenia, es_admin) VALUES (?, ?, ?, 0)";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param('sss', $nombre, $email, $password);

            if ($stmt->execute()) {
                // Registro exitoso
                $_SESSION['mensaje'] = 'Usuario registrado correctamente.';
                header("Location: index.php"); // Redirige al login
                exit();
            } else {
                $error = "Hubo un error al registrar el usuario.";
            }
        } else {
            $error = "El correo electrónico ya está registrado.";
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!-- Mostrar el mensaje de error si está definido -->
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="es">

<head>
<head>
<meta charset="UTF-8">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/loading.css">
    <!-- Icono -->
    <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>
    <div class="container">
        <h1 class="m-5 text-center display-1">Registrar Usuario</h1>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <form action="registroUsuario.php" method="POST" class="bg-dark text-white p-4 rounded">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                </form>
                <p class="text-center mt-3">
                    ¿Ya tienes cuenta? <a href="index.php" class="text-decoration-none">Inicia sesión aquí</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>
