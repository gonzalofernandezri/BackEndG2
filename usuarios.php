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
//ejemplo de usuario a registrar
// $user_id = registroUsuario(
//     "gonzalo",
//     "gonzalo@gmail.com",
//     "12qw34er",
//     "USER",
//     date("Y-m-d H:i:s")
// );


// $_SESSION["user_id"] = $user_id;
// $_SESSION["username"] = "gonzalo";
// $_SESSION["role"] = "USER";


// header("Location: dashboard.php");  en un futuro para redirigir al iniciar sesion
// exit;








// inicio de sesion 

require_once "conexion.php";




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

//ejemplo de inicio de sesion
// $resultado= loginUsuarios("gonzalo@gmail.com","12qtw34er");

// if($resultado){




//     $_SESSION["user_id"]  = $resultado["id"];
//     $_SESSION["username"] = $resultado["username"];

//     echo "sesion iniciada correctamente";

// }else

// echo "usuario o contraseña icnorrecto";
// 



//apuntarse a evento 


require_once "conexion.php";

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

// ejemplo de apuntarse a evento
// apuntarseEvento(1,8,date("Y-m-d H:i:s"));


//cierre de sesion

// function cerrarSesion()
// {
//     session_start();
//     $_SESSION = [];


//     session_destroy();
// }

// header("Location: login.php"); donde rediridir en un futuro al cerrar sesiónmn
// exit;



