<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");


require_once 'desapuntar.php';


$data = json_decode(file_get_contents('php://input'), true);

$idUsuario = $data['user_id'] ?? null;
$idEvento = $data['event_id'] ?? null;

$desapuntarCorretcto = desapuntarEventos($idUsuario, $idEvento);

?>