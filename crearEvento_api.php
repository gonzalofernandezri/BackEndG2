<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "crearEvento.php";
$titulo   = $_GET['titulo']   ?? null;
$tipo   = $_GET['tipo']   ?? null;
$fecha   = $_GET['fecha']   ?? null;
$hora   = $_GET['hora']   ?? null;
$plazas   = $_GET['plazas']   ?? null;
$imagen   = $_GET['imagen']   ?? null;
$descripcion   = $_GET['descripcion']   ?? null;
$createdby   = $_GET['createdby']   ?? null;
$createdat   = date('Y-m-d H:i:s')  ?? null;

echo crearEvento($titulo,$tipo,$fecha,$hora,$plazas,$imagen, $descripcion, $createdby, $createdat);
exit;
?>