<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "eventos.php";

// Leer parámetros GET (opcionalmente)
$tipo   = $_GET['tipo']   ?? null;
$fecha  = $_GET['fecha']  ?? null;
$plazas = isset($_GET['plazas']) ? true : null;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;


// Llamar a la función
echo mostrarEventos($tipo, $fecha, $plazas, $pagina);
exit;
?>  