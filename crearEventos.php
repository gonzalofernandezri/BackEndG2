<?php

require_once "conexion.php";

function aniadirEventos($titulo, $tipo, $fecha, $hora, $plazasLibres, $imagen, $descripcion, $created_by, $created_at){

    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");


    $sql = "INSERT into events (titulo, tipo, fecha, hora, plazasLibres, imagen, descripcion, created_by, created_at) VALUES 
    (?,?,?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);

   
    $tipos = "ssssissis";
        $stmt->bind_param(
        $tipos,
        $titulo,
        $tipo,
        $fecha,
        $hora,
        $plazasLibres,
        $imagen,
        $descripcion,
        $created_by,
        $created_at
    );


    $stmt->execute();
    $stmt->close();
    cerrarConexion($mysqli);

}
$titulo = "hola";
$tipo = "Educativo";
$fecha = "2026-03-10";          // formato YYYY-MM-DD
$hora = "18:00";                // formato HH:MM
$plazasLibres = 20;
$imagen = "taller_fotografia.jpg";  // nombre de la imagen
$descripcion = "Aprende los secretos de la fotografía con nuestro taller práctico de 2 horas.";
$created_by = 1;                // ID del usuario creador
$created_at = date("Y-m-d H:i:s"); // fecha y hora actual

// Llamada a la función para añadir el evento
aniadirEventos($titulo, $tipo, $fecha, $hora, $plazasLibres, $imagen, $descripcion, $created_by, $created_at);


?>