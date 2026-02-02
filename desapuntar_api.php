<?php
session_start(); // necesario para acceder a $_SESSION
header("Content-Type: application/json; charset=UTF-8");

require_once 'desapuntar.php';

// Comprobar que hay usuario logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Usuario no logueado']);
    exit;
}

$idUsuario = $_SESSION['user_id']; // Obtenemos el ID desde la sesión

// Tomamos el ID del evento desde POST o GET
$idEvento = $_POST['event_id'] ?? $_GET['event_id'] ?? null;

if (!$idEvento) {
    echo json_encode(['error' => 'ID de evento no proporcionado']);
    exit;
}

// Llamamos a la función que desapunta al usuario del evento
$desapuntarCorrecto = desapuntarEventos($idUsuario, $idEvento);

// Devolvemos resultado como JSON
echo json_encode(['success' => $desapuntarCorrecto]);
exit;
?>
