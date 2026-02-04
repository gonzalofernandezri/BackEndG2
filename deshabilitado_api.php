<?php
session_start();

// Solo errores fatales, evitar warnings/notices que rompan JSON
error_reporting(E_ERROR | E_PARSE);

header("Content-Type: application/json; charset=UTF-8");

require_once "usuarios.php"; // Contiene la función deshabilitadoEvento y la conexión

// Comprobar usuario logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'apuntado' => false,
        'error' => 'Usuario no logueado'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];
$evento_id = $_POST['evento_id'] ?? null;

// Validar que se haya enviado el evento_id
if (!$evento_id) {
    echo json_encode([
        'apuntado' => false,
        'error' => 'No se proporcionó evento_id'
    ]);
    exit;
}

// Comprobar si el usuario ya está apuntado
try {
    // deshabilitadoEvento devuelve true o false
    $apuntado = deshabilitadoEvento($user_id, $evento_id);

    // Devolver siempre un objeto JSON con propiedad 'apuntado'
    echo json_encode([
        'apuntado' => $apuntado
    ]);

} catch (Exception $e) {
    echo json_encode([
        'apuntado' => false,
        'error' => $e->getMessage()
    ]);
}

exit;
?>
