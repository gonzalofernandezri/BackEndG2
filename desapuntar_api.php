<?php
//session_start();
header("Content-Type: application/json; charset=UTF-8");

require_once 'desapuntar.php';

$idUsuario = $_GET['user_id'] ?? null;
$idEvento = $_GET['event_id'] ?? null;

$desapuntarCorretcto = desapuntarEventos($idUsuario, $idEvento);
var_dump($desapuntarCorretcto);
exit;
?>