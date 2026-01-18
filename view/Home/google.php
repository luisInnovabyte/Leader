<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión con Google</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <h2>Inicia sesión con Google</h2>
    <button id="google-login">Iniciar sesión con Google</button>

    <script>
        $(document).ready(function() {
            $('#google-login').on('click', function() {
                window.location.href = '../../controller/googleLogin.php';
            });
        });
    </script>
</body>
</html>
