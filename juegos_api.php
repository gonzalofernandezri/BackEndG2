<?php
header("Content-Type: application/json; charset=UTF-8");


require_once "juegos.php";



$titulo      = $_GET['titulo']   ?? null;
$genero  = $_GET['genero']  ?? null;
$plataforma  = $_GET['plataformas']  ?? null;



echo mostrarJuegos($titulo, $genero, $plataforma);
exit;
?>
