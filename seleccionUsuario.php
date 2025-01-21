<?php
session_start();

// Verificar si la sesión está activa y contiene datos del usuario
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nombre'])) {
    // Si no hay sesión, redirigir al login
    header("Location: index.php");
    exit();
}

// Obtener el nombre del usuario desde la sesión
$nombreUsuario = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <!-- bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

     <!-- fuente -->
         <link rel="preconnect" href="https://fonts.googleapis.com">
         <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
         <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
     
         <link rel="stylesheet" href="./css/index.css">
         <link rel="stylesheet" href="./css/loading.css">
         <!-- icono -->
         <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de perfil</title>
</head>
<body>

    <div class="container">
        <h1 class=" m-5 text-center display-1">¿Quién está viendo?</h1>
        <div class="row justify-content-center">
            <div class="col-6 col-md-3 profile" id="alejandro-profile">
                <img src="./imagenes/navbar/usuario.png" alt="Perfil Alejandro" class="profile-alejandro img-fluid">
                <div class="profile-name text-center profile-alejandro">
                <?= htmlspecialchars($nombreUsuario) ?>
                </div>
            </div>
            <div class="col-6 col-md-3 profile"  id="profile-nuevo">
                <img src="./imagenes/navbar/masPerfil.png" alt="Añadir perfil" class="img-fluid">
                <div class="profile-name text-center profile-nuevo">Añadir perfil</div>
            </div>
        </div>
    </div>


    <script src="./scripts/redirect.js"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>