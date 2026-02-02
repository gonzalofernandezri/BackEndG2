<?php
session_start(); // necesario para acceder a $_SESSION
header("Content-Type: application/json; charset=UTF-8");

require_once "usuarios.php";

// Comprobar que hay usuario logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no logueado']);
    exit;
}

$user_id = $_SESSION['user_id']; // Obtenemos el ID desde la sesión
$evento_id = $_POST['evento_id'] ?? null;
$fecha     = $_POST['fecha'] ?? date('Y-m-d'); // si no viene, usamos hoy

if (!$evento_id) {
    echo json_encode(['success' => false, 'message' => 'ID de evento no proporcionado']);
    exit;
}

// Llamamos a la función que apunta al usuario al evento
apuntarseEvento($user_id, $evento_id, $fecha);
exit;
?>
