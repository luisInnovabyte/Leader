<?php
require 'vendor/autoload.php'; // Incluye la biblioteca JWT de Google (instálala usando composer require google/apiclient:^2.0)

// Recibir el JWT enviado desde el cliente
$token = $_POST['credential'];

$client = new Google_Client(['client_id' => 'TU_CLIENTE_ID.apps.googleusercontent.com']);
$payload = $client->verifyIdToken($token);

if ($payload) {
    $userid = $payload['sub']; // ID único de usuario
    $email = $payload['email'];
    $name = $payload['name'];
    $picture = $payload['picture'];

    // Aquí puedes realizar la lógica para iniciar sesión o registrar al usuario en tu base de datos
    session_start();
    $_SESSION['userid'] = $userid;
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    $_SESSION['picture'] = $picture;

    echo json_encode(['status' => 'success']);
} else {
    // Token no válido
    echo json_encode(['status' => 'error', 'message' => 'Token inválido']);
}
?>
