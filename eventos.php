<?php
require_once "conexion.php";

function mostrarEventos($tipo = null, $fecha = null, $plazas = null)
{
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");

    $sql = "SELECT * FROM events WHERE 1=1";
    $params = [];
    $types = "ss";

    if ($tipo != null) {
        $sql .= " AND tipo = ?";
        $params[] = $tipo;
        $types .= "s"; // string
    }

    if ($fecha != null) {
        $sql .= " AND fecha = ?";
        $params[] = $fecha;
        $types .= "s"; // string 
    }

    if ($plazas === true) {
        $sql .= " AND plazas > 0";
    }

    $stmt = $mysqli->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $resultado = $stmt->get_result();

    $events = [];
    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $events[] = $fila;
        }
    }
    $stmt->close();
    cerrarConexion($mysqli);

    return json_encode($events, JSON_UNESCAPED_UNICODE);

}

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

?>