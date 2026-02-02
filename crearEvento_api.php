<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

require_once "crearEvento.php";

// 🔐 Comprobar que el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado'
    ]);
    exit;
}

// (Opcional pero recomendado) Solo ADMIN
if ($_SESSION['role'] !== 'ADMIN') {
    echo json_encode([
        'success' => false,
        'message' => 'No autorizado'
    ]);
    exit;
}

// Leer JSON enviado por fetch
$input = json_decode(file_get_contents("php://input"), true);

// Obtener datos del evento
$titulo       = $input['titulo'] ?? null;
$tipo         = $input['tipo'] ?? null;
$fecha        = $input['fecha'] ?? null;
$hora         = $input['hora'] ?? null;
$plazas       = $input['plazas'] ?? null;
$imagen       = $input['imagen'] ?? null;
$descripcion  = $input['descripcion'] ?? null;

// 🔐 Datos desde la sesión
$createdby = $_SESSION['user_id'];
$createdat = date('Y-m-d H:i:s');

// Validación mínima
if (!$titulo || !$tipo || !$fecha || !$hora || !$plazas) {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan campos obligatorios'
    ]);
    exit;
}

// Llamar a la función
$resultado = crearEvento(
    $titulo,
    $tipo,
    $fecha,
    $hora,
    $plazas,
    $imagen,
    $descripcion,
    $createdby,
    $createdat
);

// Respuesta consistente
if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Evento creado correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al crear el evento'
    ]);
}

exit;
