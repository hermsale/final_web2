<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Estamos Trabajando en el Sitio Web</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
        }
        .bg-cover {
            background-image: url('imagenes/fondo-404.png');
            background-size: contain;
            background-position: center;
            height: 100%;
        }
        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .centered {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>
<body>
    <div class="bg-cover">
        <div class="overlay"></div>
        <div class="centered">
            <h1 class="display-4">Estamos Trabajando en el Sitio Web</h1>
            <p class="lead">¡Vuelve pronto para ver las novedades!</p>
            <p>Gracias por tu paciencia.</p>
            <button onclick="goBack()" class="btn btn-primary">Volver</button>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
