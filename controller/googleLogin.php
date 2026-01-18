<?php
require_once '../public/vendor/autoload.php';


use League\OAuth2\Client\Provider\Google;

session_start();

// Configura el proveedor Google OAuth2
$provider = new Google([
    'clientId'     => '1060163309282-sq6ktpeh6vchjs9qvte6s162bm0sitrj.apps.googleusercontent.com',
    'clientSecret' => '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',
    'redirectUri'  => 'http://localhost/proyectos/N.Project/controller/googleLogin.php', // Debe coincidir con la URI registrada en Google Console
]);

if (!isset($_GET['code'])) {
    // Si no tenemos un código, redirigimos al usuario a Google para autenticar
    $authUrl = $provider->getAuthorizationUrl([
        'scope' => [
            'openid',
            'email',
            'profile',
            'https://www.googleapis.com/auth/contacts.readonly'  // Acceso a los contactos del usuario
        ]
    ]);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    // Verifica el estado para proteger contra CSRF
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {
    // El usuario ha regresado de Google, intercambiamos el código por un token de acceso
    try {
        // Obtén un token de acceso usando el código proporcionado
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        // Obtén detalles del usuario autenticado
        $user = $provider->getResourceOwner($token);
        $userData = $user->toArray();

        // Muestra datos de usuario o guárdalos en sesión
        // Ejemplos de datos que puedes obtener
       
       /*  // Ejemplos de datos extendidos que puedes obtener
        echo 'ID de Google: ' . $userData['sub'] . '<br>';
        echo 'Nombre: ' . $userData['name'] . '<br>';
        echo 'Primer Nombre: ' . $userData['given_name'] . '<br>';
        echo 'Apellido: ' . $userData['family_name'] . '<br>';
        echo 'Correo electrónico: ' . $userData['email'] . '<br>';
        echo 'Correo verificado: ' . ($userData['email_verified'] ? 'Sí' : 'No') . '<br>';
        echo 'Foto de perfil: <img src="' . $userData['picture'] . '" alt="Foto de perfil"><br>';
        echo 'Idioma preferido: ' . $userData['locale'] . '<br>';
        echo 'Zona horaria: ' . (isset($userData['timezone']) ? $userData['timezone'] : 'No disponible') . '<br>';
        echo 'Género: ' . (isset($userData['gender']) ? $userData['gender'] : 'No disponible') . '<br>';
        echo 'Link de perfil: ' . (isset($userData['profile']) ? $userData['profile'] : 'No disponible') . '<br>'; */
        echo '<div style="font-family: Arial, sans-serif; color: #333; max-width: 400px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px; background-color: #f9f9f9;">';
        
        echo '<h2 style="text-align: center; color: #4CAF50;">Perfil de Usuario</h2>';
        
        echo '<p><strong>ID de Google:</strong> ' . $userData['sub'] . '</p>';
        echo '<p><strong>Nombre:</strong> ' . $userData['name'] . '</p>';
        echo '<p><strong>Primer Nombre:</strong> ' . $userData['given_name'] . '</p>';
        echo '<p><strong>Apellido:</strong> ' . $userData['family_name'] . '</p>';
        echo '<p><strong>Correo electrónico:</strong> ' . $userData['email'] . '</p>';
        echo '<p><strong>Correo verificado:</strong> ' . ($userData['email_verified'] ? 'Sí' : 'No') . '</p>';
        
        echo '<div style="text-align: center; margin: 20px 0;">';
        echo '<img src="' . $userData['picture'] . '" alt="Foto de perfil" style="border-radius: 50%; border: 2px solid #4CAF50; max-width: 150px;">';
        echo '</div>';
        
        echo '<p><strong>Idioma preferido:</strong> ' . $userData['locale'] . '</p>';
        echo '<p><strong>Zona horaria:</strong> ' . (isset($userData['timezone']) ? $userData['timezone'] : 'No disponible') . '</p>';
        echo '<p><strong>Género:</strong> ' . (isset($userData['gender']) ? $userData['gender'] : 'No disponible') . '</p>';
        echo '<p><strong>Link de perfil:</strong> ' . (isset($userData['profile']) ? '<a href="' . $userData['profile'] . '" style="color: #4CAF50;">' . $userData['profile'] . '</a>' : 'No disponible') . '</p>';
        
        echo '</div>';
    } catch (Exception $e) {
        // Manejo de errores
        exit('Error: ' . $e->getMessage());
    }
}
