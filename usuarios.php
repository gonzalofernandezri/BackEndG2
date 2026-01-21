<?
require_once "conexion.php";

function registroUsuario($username, $email, $password, $role, $created_at)
{

    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");


    $sql = "INSERT into events (username, email, password_hash, role, created_at) VALUES 
    (?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt->bind_param(
        "sssss",
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

registroUsuario("gonzalo", "gonzalo@gmail.com", "12qw34er", "USER", "2026-01-20 20:53:30")

?>