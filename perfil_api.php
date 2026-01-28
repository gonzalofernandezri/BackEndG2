
<?php

require_once("conexion.php");


session_start();

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // solo para pruebas
// header("Access-Control-Allow-Credentials: true"); // permite cookies

if(!isset($_SESSION["id"])) {
    echo json_encode([`error`=> "usuario no encontrado"]);
    
exit;
}


conexionBBDD();





$user_id= $_SESSION["id"];

$sql = "SELECT id, username, email, role from users where id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

 echo json_encode($user);
 ?>






