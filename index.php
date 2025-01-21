<?php
session_start();
require 'db_conexion.php'; // Archivo para conectar a la base de datos
// Crear una instancia de la clase Database
$db = new Database();

// Conectar a la base de datos
$conexion = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verificar si los campos están completos
    if (!empty($email) && !empty($password)) {
        // Preparar la consulta
        $query = "SELECT id_usuario, nombre, contrasenia, es_admin FROM usuario WHERE email = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verificar contraseña
            if ($password == $user['contrasenia']) {
                // Iniciar sesión
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nombre'] = $user['nombre'];
                // guardamos el valor de es_admin para tener doble factor de seguridad en el navbar el primer valor de seguridad y corroborando en adminPanel que el valor de SESSION sea de admin
                $_SESSION['es_admin'] = $user['es_admin']; 
                $_SESSION['es_admin'] = $user['es_admin'];
                // Redirigir a seleccionUsuario.php
                header("Location: seleccionUsuario.php");
                exit();
            } else {
                $error = "Contraseña incorrecta.";
                
            }
        } else {
            $error = "El usuario no existe.";
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>


<!-- Asegúrate de mostrar el mensaje de error si está definido -->
<?php if (isset($error)): ?>
    <div class="error-message"><?php echo "Sus credenciales son invalidas." ?></div>
<?php endif; ?>
<html lang="en">

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
    <title>Iniciar Sesión</title>
</head>

<body>

    <div class="container">
        <h1 class="m-5 text-center display-1">Iniciar Sesión</h1>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <form action="index.php" method="POST" class="bg-dark text-white p-4 rounded">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Ingresa tu contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </form>
                <p class="text-center mt-3">
                    ¿No tienes cuenta? <a href="registroUsuario.php" class="text-decoration-none">Regístrate aquí</a>
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