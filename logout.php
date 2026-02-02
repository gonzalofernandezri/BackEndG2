<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

// Vaciar todas las variables de sesión
$_SESSION = [];

// Si se usan cookies de sesión, eliminarlas
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

echo json_encode([
    'success' => true,
    'message' => 'Sesión cerrada correctamente'
]);
