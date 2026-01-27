<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");


require_once "usuarios.php";


$username   = $_GET['username']   ?? null;
$password  = $_GET['password']  ?? null;


// Llamamos a login
$usersJson = login($username, $password);
$users = json_decode($usersJson, true); // convertimos a array
//var_dump($users);
if (count($users) > 0) {
    // Guardamos datos en la sesión
    $_SESSION['user_id']   = $users[0]['id'];
    $_SESSION['username']  = $users[0]['username'];
    $_SESSION['role']      = $users[0]['role'];   // <-- admin o user
    $_SESSION['logged_in'] = true;


    // Devolvemos JSON indicando éxito con ID y rol
    echo json_encode([
        'success' => true,
        'user_id' => $users[0]['id'],
        'username' => $users[0]['username'],
        'role' => $users[0]['role']  // <-- pasamos el rol al frontend
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario o contraseña incorrectos'
    ]);
}
?>
