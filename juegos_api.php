<?php
header("Content-Type: application/json; charset=UTF-8");


require_once "juegos.php";



$titulo      = $_GET['query']   ?? null;
$genero  = $_GET['query']  ?? null;
$plataforma  = $_GET['query']  ?? null;



echo mostrarJuegos($titulo, $genero, $plataforma);
exit;
?>
