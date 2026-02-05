<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL & ~E_DEPRECATED);

require_once("conexion.php");

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:8800"); // solo para pruebas
header("Access-Control-Allow-Credentials: true"); // permite cookies
session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(['error' => "usuario no encontrado"]);

    exit;
}

$conn = conexionBBDD();

$user_id = $_SESSION["user_id"];

$sql = "SELECT id, username, email, role from users where id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo json_encode([
    'session' => [
        'user_id' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'role' => $user['role'],
        'logged_in' => true
    ]
]);
?>