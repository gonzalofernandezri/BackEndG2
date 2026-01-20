<?php
require_once "conexion.php";

function mostrarEventos($tipo, $fecha, $plazas)
{
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");

    $sql = "SELECT * FROM events";

    $resultado = $mysqli->query($sql);

    $events = [];

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $events[] = $fila;
        }
    }
    //$stmt->close();
    cerrarConexion($mysqli);

    return json_encode($events, JSON_UNESCAPED_UNICODE);

}

$json = mostrarEventos("","","");

echo $json;
?>