<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "eventos.php";

$tipo   = $_GET['tipo']   ?? null;
$fecha  = $_GET['fecha']  ?? null;
$plazas = isset($_GET['plazas']) ? true : null;

echo todosEventos($tipo, $fecha, $plazas);
exit;
?>