<?php
require_once "conexion.php";

function crearEvento($titulo, $tipo, $fecha, $hora, $plazasLibres, $imagen, $descripcion, $created_by, $created_at)
{
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");
    $sql = "INSERT INTO events (titulo, tipo, fecha, hora, plazasLibres, imagen, descripcion, created_by, created_at) VALUES (?,?,?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("ssssissss", $titulo, $tipo, $fecha, $hora, $plazasLibres, $imagen, $descripcion, $created_by, $created_at);

    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }

    $stmt->close();
    cerrarConexion($mysqli);

    return "Evento registrado correctamente: $titulo";
};
?>