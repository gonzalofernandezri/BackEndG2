<?php
require_once 'juegos.php';
require_once 'eventos.php';
function solicitarJuegos(){
    header('Content-Type: application/json');
    mostrarJuegos($_GET);
}

function solicitarEventos(){
    header('Content-Type: application/json');
    mostrarEventos($_GET);
}
?>