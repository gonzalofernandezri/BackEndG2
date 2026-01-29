<?php
require_once 'conexion.php';

function desapuntarEventos($idUsuario, $idEvento){
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");


$sql = "DELETE FROM users_events (user_id, event_id)
     VALUES (?,?)";

$stmt = $mysqli->prepare($sql);


if (!$stmt) {
        die("Error en preparación de la consulta: " . $mysqli->error);
    }



$stmt->bind_param("ss", $idUsuario,  $idEvento);




$stmt->close();
return "Usuario desapuntado correctamente";
}


?>