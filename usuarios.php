<?php


//registro de usuario 
session_start();
require_once "conexion.php";

function registroUsuario($username, $email, $password, $role, $created_at)
{

    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");

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

    echo "Usuario registrado correctamente: $username ($email)";

    $stmt->close();
    cerrarConexion($mysqli);
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




function loginUsuarios($email,$password) {
    $mysqli = conexionBBDD();
    $mysqli->set_charset("utf8mb4");

$sql = "SELECT id, username, password_hash FROM users WHERE email = ?";





$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s",$email);


$stmt->execute();


$stmt->bind_result( $id, $username, $password_hash);

if($stmt->fetch()) {
    if(password_verify($password, $password_hash))

    return [
        "id" => $id,
        "username" => $username

    ];
}
cerrarConexion($mysqli);

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

function apuntarseEvento($user_id,$event_id,$created_at) {

  $mysqli = conexionBBDD();
  $mysqli->set_charset("utf8mb4");

    $sql = "INSERT INTO user_events (user_id, event_id, created_at) VALUES (?,?,?)";



   $stmt = $mysqli->prepare($sql);

   
    $tipos = "iis";

        $stmt->bind_param(
        $tipos,
        $user_id,
        $event_id,
        $created_at
    );


    $stmt->execute();
    $stmt->close();
    cerrarConexion($mysqli);

}

// ejemplo de apuntarse a evento
// apuntarseEvento(1,8,date("Y-m-d H:i:s"));


//cierre de sesion

function cerrarSesion(){
session_start();
$_SESSION = [];


session_destroy();
}

// header("Location: login.php"); donde rediridir en un futuro al cerrar sesiónmn
// exit;



