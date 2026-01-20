<?
require_once "conexion.php";

function aniadirEventos($username, $email, $password_hash, $role, $created_at)
{

    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");


    $sql = "INSERT into events (username, email, password_hash, role, created_at) VALUES 
    (?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);


    $tipos = "sssss";
    $stmt->bind_param(
        $tipos,
        $username,
        $email,
        $password_hash,
        $role,
        $created_at
    );


    $stmt->execute();
    $stmt->close();
    cerrarConexion($mysqli);

}

?>