<?php

require_once 'db_conexion.php';

$db = new Database();
session_start();

// Verifico si el usuario está logueado y si hay el valor session de admin tiene el valor correspondiente
if (!isset($_SESSION['id_usuario'])) {
    // Si no está logueado o no es admin, redirigir al login
    header("Location: index.php");
    exit();
} else {
    $id_usuario = $_SESSION['id_usuario'];
    $nombreUsuario = $_SESSION['nombre'];
}

// obtengo los datos del usuario
$dataUsuario = $db->getUsuarioById($id_usuario);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $dataUsuario['id_usuario']; // Obtenido de la sesión
    $nuevoNombre = $_POST['profile_name'];
    $contraseñaActual = $_POST['current_password']; // obtengo del formulario
    $nuevaContraseña = $_POST['new_password']; // obtengo del formulario
    $confirmarContraseña = $_POST['confirm_password']; // obtengo del formulario

    // actualizo el nombre sin modificar contrasenia - comparo el nombre actual con el nuevo nombre
    if(!empty($nuevoNombre) && $nuevoNombre != $dataUsuario['nombre']){
        $resultadoNombre = $db->actualizarNombreUsuario($id_usuario, $nuevoNombre);
        if (!$resultadoNombre['success']) {
            echo $resultadoNombre['message']; // Error al actualizar el nombre
        } else {
            echo $resultadoNombre['message']; // Nombre actualizado correctamente
            $_SESSION['nombre'] = $nuevoNombre; // actualizamos el nombre de la sesion
        }
    }

    if(!empty($contraseñaActual) || !empty($nuevaContraseña) || !empty($confirmarContraseña)){
        if ($nuevaContraseña !== $confirmarContraseña) {
            echo "Las nuevas contraseñas no coinciden.";
        } else {
            $resultado = $db->cambiarContrasenia($id_usuario, $contraseñaActual, $nuevaContraseña);
            if ($resultado['success']) {
                echo $resultado['message']; // Contraseña actualizada correctamente
            } else {
                echo $resultado['message']; // Error o mensaje específico
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/loading.css">


    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/loading.css">
    <link rel="stylesheet" href="./css/registro.css">
    <!-- icono -->
    <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cuenta</title>
</head>

<body>
    <!-- barra de navegacion -->
    <header class="bg-dark p-3">
        <div class="container d-flex justify-content-start">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='home.php';">
                Volver
            </button>
        </div>
    </header>
    <section class="section__formulario">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Modificar Perfil</h4>
                        </div>
                        <div class="card-body">
                            <form action="cuenta.php" method="POST">
                                <!-- Campo para cambiar el nombre del usuario -->
                                <div class="form-group">
                                    <label for="profile_name">Nombre:</label>
                                    <input type="text" class="form-control" id="profile_name" name="profile_name"
                                        value="<?php echo htmlspecialchars( $dataUsuario['nombre']  ); ?>" required>
                                </div>

                                <!-- Campo para cambiar la contraseña actual -->
                                <div class="form-group">
                                    <label for="current_password">Contraseña Actual:</label>
                                    <input type="password" class="form-control" id="current_password"
                                        name="current_password">
                                </div>

                                <!-- Campo para ingresar la nueva contraseña -->
                                <div class="form-group">
                                    <label for="new_password">Nueva Contraseña:</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                    >
                                </div>

                                <!-- Confirmación de la nueva contraseña -->
                                <div class="form-group">
                                    <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password">
                                </div>

                                <!-- Botón para enviar el formulario -->
                                <div class="form-group text-center mt-3">
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer>
        <p class="p__footer">
            ¿Preguntas? Llama al 0800 345 1111
            Preguntas frecuentes
            Centro de ayuda
            Cuenta
            Términos de uso
            Privacidad
            Contáctanos
        </p>
    </footer>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>