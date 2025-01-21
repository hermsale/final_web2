<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/index.css">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="/css/loading.css">
    
        
        <link rel="stylesheet" href="./css/navbar.css">
        <link rel="stylesheet" href="./css/loading.css">
        <link rel="stylesheet" href="./css/registro.css">
        <!-- icono -->
        <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <!-- barra de navegacion -->

    <header class="bg-dark p-3">
        <div class="container d-flex justify-content-start">
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                Volver
            </button>
        </div>
    </header>
    
<section class="section__formulario">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Agregar Perfil</h4>
                    </div>
                    <div class="card-body">
                        <form action="404.php" method="POST">
                            <div class="form-group">
                                <label for="profile_name">Nombre del Perfil:</label>
                                <input type="text" class="form-control" id="profile_name" name="profile_name" required>
                            </div>
                            <div class="form-group">
                                <label for="avatar">Seleccionar Avatar:</label>
                                <select class="form-control" id="avatar" name="avatar" required>
                                    <option value="" disabled selected>Seleccione un avatar</option>
                                    <option value="avatar1">Avatar 1</option>
                                    <option value="avatar2">Avatar 2</option>
                                    <option value="avatar3">Avatar 3</option>
                                    <!-- Agregar más opciones de avatar según sea necesario -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="age_group">Grupo de Edad:</label>
                                <select class="form-control" id="age_group" name="age_group" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="kids">Niños</option>
                                    <option value="teens">Adolescentes</option>
                                    <option value="adults">Adultos</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="parental_controls">Controles Parentales:</label>
                                <select class="form-control" id="parental_controls" name="parental_controls" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="enabled">Habilitado</option>
                                    <option value="disabled">Deshabilitado</option>
                                </select>
                            </div>
                            <div class="form-group text-center mt-2">
                                <button type="reset" class="btn btn-secondary">Limpiar</button>
                                <button type="submit" class="btn btn-primary">Guardar Perfil</button>
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
</body>
</html>