<?php
//registro de usuario 

require_once "conexion.php";

function registroUsuario($username, $email, $password, $role, $created_at)
{

    $mysqli = conexionBBDD();
    $mysqli->set_charset(charset: "utf8mb4");

    $sql = "INSERT INTO users (username, email, password_hash, role, created_at)
     VALUES (?,?,?,?,?)";


    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("Error en preparación de la consulta: " . $mysqli->error);
    }


    $password_hash = password_hash($password, PASSWORD_BCRYPT);


    $stmt->bind_param("sssss", $username, $email, $password_hash, $role, $created_at);


    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }


    $stmt->close();
    cerrarConexion($mysqli);

    return "Usuario registrado correctamente: $username ($email)";
}

// inicio de sesion 
function login($username, $password)
{
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");


    $sql = "SELECT * FROM users WHERE username = ?";

    $stmt = $mysqli->prepare($sql);


    $stmt->bind_param("s", $username);


    $stmt->execute();


    $resultado = $stmt->get_result();


    $usuario = null;
    if ($resultado && $resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // 🔑 Verificación de contraseña
        if (password_verify($password, $usuario['password_hash'])) {
            // Login correcto
            $stmt->close();
            cerrarConexion($mysqli);
            return json_encode($usuario, JSON_UNESCAPED_UNICODE);
        } else {
            $stmt->close();
            cerrarConexion($mysqli);
            return false; // contraseña incorrecta
        }
    }
    
    $stmt->close();
    cerrarConexion($mysqli);
    return false;
}

//apuntarse a evento 

function apuntarseEvento($user_id, $event_id, $created_at)
{

    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");

    $sql = "
        INSERT INTO user_events (user_id, event_id, created_at)
        SELECT ?, ?, ?
        FROM events
        WHERE id = ?
        AND plazasLibres > 0
    ";

    $stmt = $mysqli->prepare($sql);


    $tipos = "iisi";

    $stmt->bind_param(
        $tipos,
        $user_id,
        $event_id,
        $created_at,
        $event_id
    );


    $stmt->execute();
    $stmt->close();
    cerrarConexion($mysqli);

}

?>


