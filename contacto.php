<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <!-- bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/contacto.css">

    <!-- fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- icono -->
    <link rel="icon" href="./imagenes/icon/icono-viendo-una-pelicula.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
</head>
<body>
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
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Formulario de Contacto</h4>
                        </div>
                        <div class="card-body">
                            <form id="contactForm" action="/submit-your-form-handler" method="POST">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="apellido">Apellido:</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo Electrónico:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="prefijo">Prefijo:</label>
                                    <input type="text" class="form-control" id="prefijo" name="prefijo">
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Número de Teléfono:</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono">
                                </div>
                                <div class="form-group">
                                    <label for="comentarios">Comentarios:</label>
                                    <textarea class="form-control" id="comentarios" name="comentarios" rows="4" required></textarea>
                                </div>
                                <div class="form-group text-center mt-2">
                                    <button type="reset" class="btn btn-secondary">Limpiar</button>
                                    <button type="submit" class="btn btn-primary">Enviar</button>
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