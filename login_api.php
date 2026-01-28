
<?php

session_start();
header("Content-Type: application/json; charset=UTF-8");

require_once "usuarios.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['correcto' => false, 'errores' => ['Método no permitido']]);
    exit;
}


$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? null;
$contraseña = $data['contraseña'] ?? null;






$loginCorrecto = loginUsuarios($email, $contraseña);


$errores = [];
if (!$email) $errores[] = 'El email es obligatorio';
if (!$contraseña) $errores[] = 'La contraseña es obligatoria';

if ($errores) {
    echo json_encode(['correcto' => false, 'errores' => $errores]);
    exit;
}


$loginCorrecto = loginUsuarios($email, $contraseña);

if ($loginCorrecto) {
    echo json_encode([
        'correcto' => true,
        'mensaje' => 'Login exitoso',
        'usuario' => $loginCorrecto
    ]);
} else {
    echo json_encode([
        'correcto' => false,
        'errores' => ['Email o contraseña incorrectos']
    ]);
}
exit;

?>