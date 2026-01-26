<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "usuarios.php";


$data = json_decode(file_get_contents('php://input'), true);

$usuario = $data['usuario'] ?? null;
$email = $data['email'] ?? null;
$contraseña = $data['contraseña'] ?? null;
$rol = 'usuario';
$creado_en = date('Y-m-d H:i:s');

$errores = [];


if (!$usuario) $errores[] = 'El nombre de usuario es obligatorio';
if (!$email) $errores[] = 'El email es obligatorio';
if (!$contraseña) $errores[] = 'La contraseña es obligatoria';

if ($errores) {
    echo json_encode(['correcto' => false, 'errores' => $errores]);
    exit;
}

$registroCorrecto = registroUsuario($usuario, $email, $contraseña, $rol = "USER", $creado_en);

if ($registroCorrecto) {
    echo json_encode(['correcto' => true, 'mensaje' => 'Usuario registrado correctamente']);
} else {
    echo json_encode(['correcto' => false, 'errores' => ['Error al registrar usuario. Posiblemente el usuario o email ya existe']]);
}
exit;
?>
