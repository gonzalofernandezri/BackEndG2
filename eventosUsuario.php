<?php
require_once "conexion.php";

function eventosUsuario($id)
{
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");

    $sql = "SELECT e.* FROM events e INNER JOIN user_events ue ON ue.event_id = e.id WHERE ue.user_id = ?;";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("s", $id);

    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
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

?>