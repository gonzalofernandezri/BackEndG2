<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "crearEvento.php";

// Leer JSON enviado por fetch
$input = json_decode(file_get_contents("php://input"), true);

// Obtener datos
$titulo       = $input['titulo'] ?? null;
$tipo         = $input['tipo'] ?? null;
$fecha        = $input['fecha'] ?? null;
$hora         = $input['hora'] ?? null;
$plazas       = $input['plazas'] ?? null;
$imagen       = $input['imagen'] ?? null;
$descripcion  = $input['descripcion'] ?? null;
$createdby    = $input['createdby'] ?? null;
$createdat    = date('Y-m-d H:i:s');

// Validación mínima
if (
    !$titulo || !$tipo || !$fecha || !$hora || !$plazas
) {
    echo json_encode([
        'correcto' => false,
        'mensaje' => 'Faltan campos obligatorios'
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

// Devolver respuesta
echo $resultado;
exit;
?>
