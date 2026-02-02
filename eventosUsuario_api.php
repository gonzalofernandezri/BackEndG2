<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "eventosUsuario.php";

session_start();

// Tomamos el ID del usuario desde la sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Usuario no logueado']);
    exit;
}

$iduser = $_SESSION['user_id'];

echo eventosUsuario($iduser);
exit;
?>
