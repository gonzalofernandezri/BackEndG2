<?php
require_once "conexion.php";
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
function  mostrarJuegos($titulo = null, $genero = null, $plataforma = null)
{
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");


    $sql = "SELECT * FROM games WHERE titulo LIKE ? OR genero LIKE ? OR plataformas LIKE ?";
    $params = ["%".$titulo."%","%".$genero."%","%".$plataforma."%"];
    $types = "sss";



    
    $stmt = $mysqli->prepare($sql);

   

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $resultado = $stmt->get_result();

    $games = [];
    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $games[] = $fila;
        }
    }
    $stmt->close();
    cerrarConexion($mysqli);

    return json_encode($games, JSON_UNESCAPED_UNICODE);

}

// echo mostrarJuegos(null,"Sandbox")

    // echo mostrarJuegos("M","M")
?>