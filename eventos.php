<?php
require_once "conexion.php";

function mostrarEventos($tipo = null, $fecha = null, $plazas = null, $pagina = 1)
{
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");

    $limit = 9;
    $offset = ($pagina - 1) * $limit;

    $sql = "SELECT * FROM events WHERE 1=1";
    $params = [];
    $types = "";

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
        $sql .= " AND plazasLibres > 0";
    }

    $sql .= " LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= "ii";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param($types, ...$params);

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

//echo mostrarEventos();

function todosEventos($tipo = null, $fecha = null, $plazas = null)
{
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");

    $sql = "SELECT COUNT(*) AS cantidad FROM events WHERE 1=1";
    $params = [];
    $types = "";

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
        $sql .= " AND plazasLibres > 0";
    }

    $stmt = $mysqli->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();

    $resultado = $stmt->get_result();

    if (!$resultado) {
        die("Error en la consulta: " . $mysqli->error);
    }

    $fila = $resultado->fetch_assoc();
    $cantidad = $fila['cantidad'];

    return $cantidad;
}


function aniadirEventos($titulo, $tipo, $fecha, $hora, $plazasLibres, $imagen, $descripcion, $created_by, $created_at)
{

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