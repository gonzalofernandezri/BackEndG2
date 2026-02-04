<?php
require_once 'conexion.php';

function desapuntarEventos($user_id, $event_id){
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");


    $sql = "DELETE FROM user_events WHERE user_id = ? AND event_id = ?";

    $stmt = $mysqli->prepare($sql);


    if (!$stmt) {
        die("Error en preparación de la consulta: " . $mysqli->error);
    }


    $stmt->bind_param("ii", $user_id,  $event_id);

    

    $stmt->execute();

    $stmt->close();
    return "Usuario desapuntado correctamente";
}

?>